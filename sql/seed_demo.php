<?php
declare(strict_types=1);

/**
 * Seed rich portfolio demo data for the admin dashboard.
 * Safe to re-run: clears previous demo rows tagged by known prefixes/emails first.
 */
require_once dirname(__DIR__) . '/includes/config.php';

$pdo = db();
$pdo->exec('SET FOREIGN_KEY_CHECKS=0');
$pdo->exec('DELETE FROM welfare_reports');
$pdo->exec('DELETE FROM contact_messages');
$pdo->exec('DELETE FROM newsletter_subscribers');
$pdo->exec('DELETE FROM community_stories');
$pdo->exec('SET FOREIGN_KEY_CHECKS=1');

$animals = ['Donkey', 'Cattle', 'Goat', 'Sheep', 'Poultry', 'Dog', 'Cat', 'Horse', 'Ox'];
$counties = [
    'Nairobi', 'Kiambu', 'Nakuru', 'Kisumu', 'Mombasa', 'Meru', 'Machakos',
    'Kajiado', 'Nyeri', 'Kakamega', 'Uasin Gishu', 'Bungoma',
];
$townsByCounty = [
    'Nairobi' => ['Nairobi CBD', 'Westlands', 'Kasarani', 'Kibera'],
    'Kiambu' => ['Thika', 'Ruiru', 'Kiambu Town'],
    'Nakuru' => ['Nakuru Town', 'Naivasha'],
    'Kisumu' => ['Kisumu City'],
    'Mombasa' => ['Mombasa Island', 'Nyali'],
    'Meru' => ['Meru Town'],
    'Machakos' => ['Machakos Town'],
    'Kajiado' => ['Kajiado Town'],
    'Nyeri' => ['Nyeri Town'],
    'Kakamega' => ['Kakamega Town'],
    'Uasin Gishu' => ['Eldoret'],
    'Bungoma' => ['Bungoma Town'],
];
$concernPool = [
    'Possible overwork', 'Lack of water or food', 'Injury or illness',
    'Unsafe housing', 'Harmful handling', 'Abandonment', 'Other',
];
$storyCats = [
    'Positive care stories', 'Community initiatives', 'Learning moments',
    'Owner experiences', 'School and youth projects', 'Events and outreach',
];
$contactCats = [
    'General question', 'Educational content suggestion', 'Partnership enquiry',
    'Directory correction', 'Press / communications', 'Other',
];

$reportStmt = $pdo->prepare(
    'INSERT INTO welfare_reports (
      reference_code, status, animal_type, concern_types, observations,
      event_date, event_time, not_sure_when, county, area, precise_location,
      immediate_danger, contact_name, contact_email, contact_phone, created_at
    ) VALUES (
      :reference_code, :status, :animal_type, :concern_types, :observations,
      :event_date, :event_time, :not_sure_when, :county, :area, :precise_location,
      :immediate_danger, :contact_name, :contact_email, :contact_phone, :created_at
    )'
);

$statuses = ['received', 'received', 'in_review', 'referred', 'closed', 'received'];
// Weight denser counties so overlapping translucent dots show clearly on the map.
$countyWeights = [];
foreach ($counties as $c) {
    $countyWeights[] = $c;
}
foreach (['Nairobi', 'Nairobi', 'Nairobi', 'Kiambu', 'Kiambu', 'Nakuru', 'Mombasa'] as $hot) {
    $countyWeights[] = $hot;
}
for ($i = 1; $i <= 48; $i++) {
    $animal = $animals[array_rand($animals)];
    $county = $countyWeights[array_rand($countyWeights)];
    $concerns = array_values(array_unique([
        $concernPool[array_rand($concernPool)],
        $concernPool[array_rand($concernPool)],
    ]));
    $created = (new DateTimeImmutable('first day of -5 months'))
        ->modify('+' . random_int(0, 150) . ' days')
        ->modify('+' . random_int(0, 20) . ' hours');
    $danger = random_int(1, 10) <= 2 ? 'yes' : 'no';
    $reportStmt->execute([
        ':reference_code' => 'TAU-DEMO' . strtoupper(bin2hex(random_bytes(2))),
        ':status' => $statuses[array_rand($statuses)],
        ':animal_type' => $animal,
        ':concern_types' => json_encode($concerns, JSON_UNESCAPED_UNICODE),
        ':observations' => "Demo observation {$i}: neighbours noticed a {$animal} needing attention near {$county}. Shared for portfolio triage practice.",
        ':event_date' => $created->modify('-' . random_int(0, 5) . ' days')->format('Y-m-d'),
        ':event_time' => sprintf('%02d:%02d:00', random_int(6, 18), random_int(0, 59)),
        ':not_sure_when' => random_int(0, 1) === 1 ? 1 : 0,
        ':county' => $county,
        ':area' => $townsByCounty[$county][array_rand($townsByCounty[$county])],
        ':precise_location' => random_int(0, 1) ? 'Near the public borehole' : null,
        ':immediate_danger' => $danger,
        ':contact_name' => random_int(0, 1) ? 'Demo Reporter ' . $i : null,
        ':contact_email' => random_int(0, 1) ? "reporter{$i}@example.com" : null,
        ':contact_phone' => random_int(0, 1) ? '07' . random_int(10000000, 99999999) : null,
        ':created_at' => $created->format('Y-m-d H:i:s'),
    ]);
}

$storyStmt = $pdo->prepare(
    'INSERT INTO community_stories (
      status, title, body, animal_type, location, display_name, category, photo_path, consent, created_at
    ) VALUES (
      :status, :title, :body, :animal_type, :location, :display_name, :category, NULL, 1, :created_at
    )'
);

$stories = [
    ['Shade and water after market day', 'Donkey', 'Owner experiences'],
    ['Youth club builds a rest yard', 'Cattle', 'School and youth projects'],
    ['Learning harness fit the gentle way', 'Horse', 'Learning moments'],
    ['Neighbourhood feeding rota for street dogs', 'Dog', 'Community initiatives'],
    ['Poultry house cleaned before rains', 'Poultry', 'Positive care stories'],
    ['Goat kids get a dry night shelter', 'Goat', 'Owner experiences'],
    ['Clinic day reaches working animals', 'Ox', 'Events and outreach'],
    ['Cats in the compound: quiet kindness', 'Cat', 'Positive care stories'],
    ['Sheep flock checked after a long walk', 'Sheep', 'Learning moments'],
    ['Teachers host an animal care assembly', 'Donkey', 'School and youth projects'],
    ['Rest stops mapped for cart routes', 'Donkey', 'Community initiatives'],
    ['Farmers share load-limit tips', 'Cattle', 'Events and outreach'],
    ['First aid kit for small stock', 'Goat', 'Learning moments'],
    ['Water trough repaired by volunteers', 'Cattle', 'Community initiatives'],
    ['A gentle approach to dogs at the gate', 'Dog', 'Owner experiences'],
];
$storyStatuses = ['pending_moderation', 'published', 'published', 'needs_changes', 'declined', 'published'];
foreach ($stories as $i => $story) {
    $created = (new DateTimeImmutable('first day of -4 months'))
        ->modify('+' . ($i * 7 + random_int(0, 4)) . ' days');
    $storyStmt->execute([
        ':status' => $storyStatuses[$i % count($storyStatuses)],
        ':title' => $story[0],
        ':body' => "Demo story: {$story[0]}. This portfolio sample shows how everyday care for {$story[1]} can be shared, moderated and celebrated on the platform.",
        ':animal_type' => $story[1],
        ':location' => $counties[$i % count($counties)],
        ':display_name' => ['Amina K.', 'Joseph M.', 'Wanjiku N.', 'Otieno O.', 'Grace W.'][$i % 5],
        ':category' => $story[2],
        ':created_at' => $created->format('Y-m-d H:i:s'),
    ]);
}

$contactStmt = $pdo->prepare(
    'INSERT INTO contact_messages (
      name, email, category, subject, message, consent, status, created_at
    ) VALUES (
      :name, :email, :category, :subject, :message, 1, :status, :created_at
    )'
);
$contactStatuses = ['new', 'new', 'in_progress', 'resolved'];
for ($i = 1; $i <= 18; $i++) {
    $cat = $contactCats[array_rand($contactCats)];
    $created = (new DateTimeImmutable('first day of -3 months'))
        ->modify('+' . random_int(0, 85) . ' days');
    $contactStmt->execute([
        ':name' => 'Demo Contact ' . $i,
        ':email' => "contact{$i}@example.com",
        ':category' => $cat,
        ':subject' => "Portfolio enquiry #{$i}: {$cat}",
        ':message' => "Hello, this is a seeded contact message about {$cat}. Useful for demonstrating inbox triage in the admin desk.",
        ':status' => $contactStatuses[array_rand($contactStatuses)],
        ':created_at' => $created->format('Y-m-d H:i:s'),
    ]);
}

$newsStmt = $pdo->prepare(
    'INSERT INTO newsletter_subscribers (email, source, consent, created_at)
     VALUES (:email, :source, 1, :created_at)'
);
$sources = ['footer', 'footer', 'event-booth', 'partners-page'];
for ($i = 1; $i <= 42; $i++) {
    $created = (new DateTimeImmutable('first day of -6 months'))
        ->modify('+' . random_int(0, 170) . ' days');
    $newsStmt->execute([
        ':email' => "subscriber{$i}@example.com",
        ':source' => $sources[array_rand($sources)],
        ':created_at' => $created->format('Y-m-d H:i:s'),
    ]);
}

$counts = $pdo->query(
    'SELECT
      (SELECT COUNT(*) FROM welfare_reports) reports,
      (SELECT COUNT(*) FROM community_stories) stories,
      (SELECT COUNT(*) FROM contact_messages) contacts,
      (SELECT COUNT(*) FROM newsletter_subscribers) subscribers'
)->fetch();

echo "Seeded demo data:\n";
echo json_encode($counts, JSON_PRETTY_PRINT) . PHP_EOL;
