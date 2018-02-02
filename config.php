<?php
ini_set('display_errors', true);

$classPath = __DIR__ . DIRECTORY_SEPARATOR . 'class';
set_include_path(get_include_path() . PATH_SEPARATOR . $classPath);

spl_autoload_register();

require __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
$tmpDir = __DIR__ . DIRECTORY_SEPARATOR . "vendor\ypid\suncalc\lib\php\Boot.class.php";
require $tmpDir;

define('DATA_DIR', __DIR__ . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR);

define('FA_API_LOGIN', getenv('FA_API_LOGIN'));
define('FA_API_KEY', getenv('FA_API_KEY'));

?>

