<?php
declare(strict_types=1);

/**
 * Escape for HTML output.
 */
function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/**
 * Build a site URL from a path relative to the project root.
 */
function url(string $path = ''): string
{
    return BASE_URL . ltrim($path, '/');
}

/**
 * Build an asset URL.
 */
function asset(string $path): string
{
    return ASSET_URL . ltrim($path, '/');
}

/**
 * Render a compressed site image from assets/images/Compressed.
 * Falls back to a labeled skeleton if the file is missing.
 */
function site_image(
    string $filename,
    string $alt,
    string $aspect = '',
    string $extraClass = '',
    string $width = '',
    string $height = ''
): string {
    $relative = 'images/Compressed/' . ltrim($filename, '/');
    $diskPath = ROOT_PATH . 'assets' . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $relative);

    if (!is_file($diskPath)) {
        return image_placeholder(
            $width !== '' ? $width : '800',
            $height !== '' ? $height : '600',
            $alt,
            'Missing image file: ' . $filename,
            $aspect,
            $extraClass
        );
    }

    $style = $aspect !== '' ? 'aspect-ratio:' . e($aspect) . ';' : '';
    $class = trim('site-media ' . $extraClass);
    $src = e(asset($relative));
    $altEsc = e($alt);
    $wh = '';
    if ($width !== '') {
        $wh .= ' width="' . e($width) . '"';
    }
    if ($height !== '') {
        $wh .= ' height="' . e($height) . '"';
    }

    return <<<HTML
<figure class="{$class}" style="{$style}">
  <img src="{$src}" alt="{$altEsc}"{$wh} loading="lazy" decoding="async">
</figure>
HTML;
}

/**
 * Render a skeleton image placeholder with intended dimensions and brief.
 */
function image_placeholder(
    string $width,
    string $height,
    string $label,
    string $brief,
    string $aspect = '',
    string $extraClass = ''
): string {
    $style = $aspect !== '' ? 'aspect-ratio:' . e($aspect) . ';' : '';
    $class = trim('img-placeholder ' . $extraClass);
    return <<<HTML
<figure class="{$class}" style="{$style}" data-w="{$width}" data-h="{$height}" role="img" aria-label="{$label}">
  <div class="img-placeholder__frame">
    <div class="img-placeholder__skeleton" aria-hidden="true"></div>
    <div class="img-placeholder__meta">
      <span class="img-placeholder__size">{$width} × {$height} px</span>
      <strong class="img-placeholder__label">{$label}</strong>
      <p class="img-placeholder__brief">{$brief}</p>
    </div>
  </div>
</figure>
HTML;
}

/**
 * Generate a CSRF token.
 */
function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Validate CSRF token.
 */
function csrf_validate(?string $token): bool
{
    return is_string($token)
        && isset($_SESSION['csrf_token'])
        && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Persist a JSON record under /data.
 */
function save_submission(string $folder, array $payload): string
{
    $dir = ROOT_PATH . 'data' . DIRECTORY_SEPARATOR . $folder;
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
    $id = date('Ymd-His') . '-' . bin2hex(random_bytes(4));
    $payload['id'] = $id;
    $payload['received_at'] = date('c');
    $path = $dir . DIRECTORY_SEPARATOR . $id . '.json';
    file_put_contents($path, json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    return $id;
}

/**
 * Flash message helpers.
 */
function flash_set(string $type, string $message): void
{
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function flash_get(): ?array
{
    if (empty($_SESSION['flash'])) {
        return null;
    }
    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);
    return $flash;
}
