<?php

$file = 'undergraduate/test-ug.txt';

$links = file($file);


set_time_limit(0);

foreach ($links as $key => $link) {
    if ($link) {

        $urlParts = parse_url(trim($link));

        $path = trim($urlParts['path'], '/');

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $file =  $path . '/index.html';

        $content = file_get_contents(trim($link));

        include 'includes/include-ug.php';

        file_put_contents($file, $content);
    } else {
        exit();
    }
}

echo 'process complete';
