<?php
require (__DIR__ . '/vendor/autoload.php');

error_reporting(E_ALL);
ini_set('display_errors', '1');

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Monolog\Logger;

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
