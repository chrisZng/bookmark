<?php

$longOpts = [
    'url:',
    'tag:',
];

$options = getopt('', $longOpts);

if (!isset($options['url'])) {
    echo "\033[1;35m".'Usage: php script.php --url <url> [--tag <tag1> ...]'."\033[0m".PHP_EOL;
    exit(1);
}

if (empty($options['url'])) {
    echo "\033[1;35m".'The --url parameter cannot be empty.'."\033[0m".PHP_EOL;
    exit(1);
}

$urlValidate = filter_var($options['url'], FILTER_VALIDATE_URL);

if (false === $urlValidate) {
    echo "\033[1;35m".'The provided URL is invalid. Please enter a valid URL.'."\033[0m".PHP_EOL;
    exit(1);
}

$addData = [
    'url' => $options['url'],
];

if (empty($options['tag'])) {
    $addData['tags'] = [];
} elseif (is_string($options['tag'])) {
    $addData['tags'] = [
        $options['tag'],
    ];
} elseif (is_array($options['tag'])) {
    $addData['tags'] = $options['tag'];
}

$file = 'data.json';

if (file_exists($file)) {
    $rawData = json_decode(file_get_contents($file), true) ?: [];
} else {
    $rawData = [];
}

$rawData[] = $addData;
$newData = json_encode($rawData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
file_put_contents($file, $newData);

echo 'Operation complete.'.PHP_EOL;

