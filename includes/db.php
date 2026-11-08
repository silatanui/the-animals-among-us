<?php
declare(strict_types=1);

/**
 * Shared PDO connection for form destinations.
 */
function db(): PDO
{
    static $pdo = null;
    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $dsn = sprintf(
        'mysql:host=%s;port=%d;dbname=%s;charset=%s',
        DB_HOST,
        DB_PORT,
        DB_NAME,
        DB_CHARSET
    );

    $pdo = new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);

    return $pdo;
}

/**
 * Insert a newsletter subscriber. Re-subscribing refreshes consent/source.
 */
function db_save_newsletter(string $email, string $source = 'footer'): int
{
    $sql = 'INSERT INTO newsletter_subscribers (email, source, consent)
            VALUES (:email, :source, 1)
            ON DUPLICATE KEY UPDATE
              source = VALUES(source),
              consent = 1,
              created_at = CURRENT_TIMESTAMP';
    $stmt = db()->prepare($sql);
    $stmt->execute([
        ':email' => $email,
        ':source' => $source,
    ]);

    $id = (int) db()->lastInsertId();
    if ($id > 0) {
        return $id;
    }

    $find = db()->prepare('SELECT id FROM newsletter_subscribers WHERE email = :email LIMIT 1');
    $find->execute([':email' => $email]);
    return (int) ($find->fetchColumn() ?: 0);
}

/**
 * Insert a contact enquiry.
 */
function db_save_contact(array $data): int
{
    $sql = 'INSERT INTO contact_messages
              (name, email, category, subject, message, consent, status)
            VALUES
              (:name, :email, :category, :subject, :message, :consent, :status)';
    $stmt = db()->prepare($sql);
    $stmt->execute([
        ':name' => $data['name'],
        ':email' => $data['email'],
        ':category' => $data['category'],
        ':subject' => $data['subject'],
        ':message' => $data['message'],
        ':consent' => !empty($data['consent']) ? 1 : 0,
        ':status' => $data['status'] ?? 'new',
    ]);
    return (int) db()->lastInsertId();
}

/**
 * Insert a private welfare concern report.
 */
function db_save_report(array $data): int
{
    $sql = 'INSERT INTO welfare_reports (
              reference_code, status, animal_type, concern_types, observations,
              event_date, event_time, not_sure_when, county, area, precise_location,
              immediate_danger, contact_name, contact_email, contact_phone
            ) VALUES (
              :reference_code, :status, :animal_type, :concern_types, :observations,
              :event_date, :event_time, :not_sure_when, :county, :area, :precise_location,
              :immediate_danger, :contact_name, :contact_email, :contact_phone
            )';

    $eventDate = trim((string) ($data['event_date'] ?? ''));
    $eventTime = trim((string) ($data['event_time'] ?? ''));

    $stmt = db()->prepare($sql);
    $stmt->execute([
        ':reference_code' => $data['reference_code'],
        ':status' => $data['status'] ?? 'received',
        ':animal_type' => $data['animal_type'],
        ':concern_types' => json_encode(array_values($data['concern_types'] ?? []), JSON_UNESCAPED_UNICODE),
        ':observations' => $data['observations'],
        ':event_date' => $eventDate !== '' ? $eventDate : null,
        ':event_time' => $eventTime !== '' ? $eventTime : null,
        ':not_sure_when' => !empty($data['not_sure_when']) ? 1 : 0,
        ':county' => $data['county'],
        ':area' => $data['area'],
        ':precise_location' => ($data['precise_location'] ?? '') !== '' ? $data['precise_location'] : null,
        ':immediate_danger' => $data['immediate_danger'],
        ':contact_name' => ($data['contact_name'] ?? '') !== '' ? $data['contact_name'] : null,
        ':contact_email' => ($data['contact_email'] ?? '') !== '' ? $data['contact_email'] : null,
        ':contact_phone' => ($data['contact_phone'] ?? '') !== '' ? $data['contact_phone'] : null,
    ]);

    return (int) db()->lastInsertId();
}

/**
 * Insert a community story awaiting moderation.
 */
function db_save_story(array $data): int
{
    $sql = 'INSERT INTO community_stories (
              status, title, body, animal_type, location, display_name, category, photo_path, consent
            ) VALUES (
              :status, :title, :body, :animal_type, :location, :display_name, :category, :photo_path, :consent
            )';
    $stmt = db()->prepare($sql);
    $stmt->execute([
        ':status' => $data['status'] ?? 'pending_moderation',
        ':title' => $data['title'],
        ':body' => $data['body'],
        ':animal_type' => $data['animal_type'],
        ':location' => ($data['location'] ?? '') !== '' ? $data['location'] : null,
        ':display_name' => $data['display_name'],
        ':category' => ($data['category'] ?? '') !== '' ? $data['category'] : null,
        ':photo_path' => ($data['photo_path'] ?? '') !== '' ? $data['photo_path'] : null,
        ':consent' => !empty($data['consent']) ? 1 : 0,
    ]);
    return (int) db()->lastInsertId();
}

/**
 * Store an optional uploaded image under /data/uploads and return a relative path.
 */
function store_upload(array $file, string $folder): ?string
{
    if (($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
        return null;
    }
    if (($file['error'] ?? UPLOAD_ERR_OK) !== UPLOAD_ERR_OK) {
        throw new RuntimeException('The upload failed. Please try a smaller image.');
    }

    $tmp = (string) ($file['tmp_name'] ?? '');
    if ($tmp === '' || !is_uploaded_file($tmp)) {
        throw new RuntimeException('Invalid upload.');
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($tmp) ?: '';
    $allowed = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp',
        'image/gif' => 'gif',
    ];
    if (!isset($allowed[$mime])) {
        throw new RuntimeException('Please upload a JPG, PNG, WEBP or GIF image.');
    }

    if (($file['size'] ?? 0) > 5 * 1024 * 1024) {
        throw new RuntimeException('Images must be 5 MB or smaller.');
    }

    $dir = ROOT_PATH . 'data' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . $folder;
    if (!is_dir($dir) && !mkdir($dir, 0755, true) && !is_dir($dir)) {
        throw new RuntimeException('Could not prepare the upload folder.');
    }

    $name = date('Ymd-His') . '-' . bin2hex(random_bytes(4)) . '.' . $allowed[$mime];
    $dest = $dir . DIRECTORY_SEPARATOR . $name;
    if (!move_uploaded_file($tmp, $dest)) {
        throw new RuntimeException('Could not save the uploaded image.');
    }

    return 'uploads/' . $folder . '/' . $name;
}
