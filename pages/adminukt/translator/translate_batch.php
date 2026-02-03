<?php
$input = json_decode(file_get_contents('php://input'), true);
$texts = $input['texts'];
$to = $input['targetLang'];
$from = 'en';

// Path to the cache file
$cacheFile = 'translation_cache.json';
$cache = file_exists($cacheFile) ? json_decode(file_get_contents($cacheFile), true) : [];

$translations = [];
$updated = false;

foreach ($texts as $text) {
    // Create a unique key based on the source language, target language, and the text
    $key = md5($from . '|' . $to . '|' . $text);

    if (isset($cache[$key])) {
        // Use the cached translation if available
        $translations[] = $cache[$key];
    } else {
        if ($from === $to) {
            // If source and target language are the same, no translation needed
            $translations[] = $text;
            $cache[$key] = $text;  // Cache the original text
        } else {
            // Make the API call to get the translated text
            $url = "https://api.mymemory.translated.net/get?q=" . urlencode($text) . "&langpair=$from|$to";
            $response = file_get_contents($url);
            $result = json_decode($response, true);

            $translated = $result['responseData']['translatedText'] ?? '[Translation error]';
            $translations[] = $translated;

            // Cache the translated text
            $cache[$key] = $translated;
            $updated = true;

            // Optional: Avoid hitting API rate limits
            usleep(100000);  // 100ms delay
        }
    }
}

// If there are new translations, update the cache file
if ($updated) {
    file_put_contents($cacheFile, json_encode($cache));
}

echo json_encode(['translations' => $translations]);
?>
