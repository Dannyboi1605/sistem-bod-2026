<?php
// Get Saira CSS
$opts = [
    'http' => [
        'method' => 'GET',
        'header' => 'User-Agent: Mozilla/5.0 (Windows NT 6.1; rv:60.0) Gecko/20100101 Firefox/60.0\r\n'
    ]
];
$context = stream_context_create($opts);
$css = file_get_contents('https://fonts.googleapis.com/css2?family=Saira:wght@700&display=swap', false, $context);
preg_match('/url\((.*?)\)/', $css, $matches);
if (isset($matches[1])) {
    $url = trim($matches[1], "'");
    $ttf = file_get_contents($url);
    if (!is_dir('public/fonts')) mkdir('public/fonts');
    file_put_contents('public/fonts/saira-bold.ttf', $ttf);
    echo "Font downloaded successfully to public/fonts/saira-bold.ttf\n";
} else {
    echo "Failed to find TTF URL in CSS:\n$css\n";
}
