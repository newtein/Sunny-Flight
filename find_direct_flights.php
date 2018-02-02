<?php
require dirname(__FILE__) . DIRECTORY_SEPARATOR . 'config.php';

$list = [];
$file = fopen(DATA_DIR . 'routes.dat', 'r');
while (!feof($file)) {
    $line = fgetcsv($file);
    if ($line[7]) {
        continue;
    }
    
    $start = $line[2];
    $dest = $line[4];
    if (!isset($list[$start])) {
        $list[$start] = [];
    }
    
    if (!isset($list[$dest])) {
        $list[$dest] = [];
    }
    
    $list[$start][] = $dest;
    $list[$dest][] = $start;
}

foreach ($list as &$val) {
    $val = array_unique($val);
}

file_put_contents(DATA_DIR . 'direct.dat', serialize($list));

echo 'Saved ' . (count($list)  / 2) . ' airpots';
