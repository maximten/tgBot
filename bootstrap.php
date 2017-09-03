<?php
require (__DIR__ . '/vendor/autoload.php');
require (__DIR__ . '/timezones.php');

error_reporting(E_ALL);
ini_set('display_errors', '1');

date_default_timezone_set('Asia/Krasnoyarsk');

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Monolog\Logger;

function write($value) {
    fwrite(STDOUT, print_r($value, true) . "\n");
}

global $CONFIG, $LOG, $entityManager;

$LOG = new Logger('main');

try {
    $contents = file_get_contents(__DIR__ . '/conf.json');
    if (! strlen($contents)) {
        throw new Exception("Config file not found");
    }
    $CONFIG = json_decode($contents, true);
    if (! $CONFIG) {
        throw new Exception("Config file has wrong format");
    }
} catch (Exception $e) {
    $LOG->error($e->getMessage());
    die;
} 

$isDevMode = true;
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/app"), $isDevMode);
$conn = array(
    'dbname' => $_ENV['DB_DATABASE'],
    'user' => 'root',
    'password' => $_ENV['DB_PASSWORD'],
    'host' => $_ENV['DB_HOST'],
    'driver' => 'pdo_mysql',
);
$entityManager = EntityManager::create($conn, $config);
