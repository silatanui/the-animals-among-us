<?php
$storyTitle = 'What a better harness taught us';
$category = 'Learning moment';
$animalType = 'Donkeys';
$publishedAt = 'Sample story';
$author = 'Working-animal owner (display name)';
$summary = 'Checking for sores and adjusting equipment protected both the animal and the work.';
$heroLabel = 'Owner carefully checking and adjusting a padded donkey harness';
$heroImage = 'tau-home-story-harness-640x400.jpg';
$paragraphs = [
    'I used to think a harness was just a tool. When I found rubbing marks, I first tried to work around them instead of fixing the cause.',
    'A local animal-health worker showed me how to check contact points, pad pressure areas and reduce load while the skin recovered.',
    'The donkey moved more freely. The lesson stayed with me: equipment that fits is part of care, not an optional extra.',
];
$takeaway = 'Keep equipment comfortable, allow rest when needed, and seek qualified help rather than increasing force.';
$relatedGuides = [
    ['href' => 'care-guides/donkeys.php', 'label' => 'Donkey care basics'],
    ['href' => 'why-it-matters.php', 'label' => 'Why it matters'],
];
require dirname(__DIR__) . '/includes/story-template.php';
