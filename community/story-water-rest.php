<?php
$storyTitle = 'Clean water changed our mornings';
$category = 'Positive care';
$animalType = 'Donkeys';
$publishedAt = 'Sample story';
$author = 'Market transporter (display name)';
$summary = 'A simple water stop helped two working donkeys start the day with less exhaustion.';
$heroLabel = 'Working donkeys drinking at a clean roadside water point';
$heroImage = 'tau-home-story-water-640x400.jpg';
$paragraphs = [
    'Every morning we move goods before the heat builds. For a long time we pushed through without a reliable place for the donkeys to drink.',
    'After speaking with a neighbour who had attended a short animal-care session, we agreed to stop at a known water point and check that the animals drank before the heavier part of the route.',
    'The change was practical, not dramatic. The donkeys were steadier. We still work hard, but we no longer treat thirst as something to ignore until the end of the day.',
];
$takeaway = 'Small actions can make a real difference: offer clean water where appropriate, allow rest, notice changes in behaviour and seek qualified help when needed.';
$relatedGuides = [
    ['href' => 'care-guides/donkeys.php', 'label' => 'Donkey care basics'],
    ['href' => 'take-action.php', 'label' => 'Ways to help'],
];
require dirname(__DIR__) . '/includes/story-template.php';
