<?php

require __DIR__ . '/../vendor/autoload.php';

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$config = ORMSetup::createAttributeMetadataConfiguration(
    paths: array(__DIR__."/../src"),
    isDevMode: true,
);
// configuring the database connection
$dbConfig = require __DIR__ . '/../bootstrap/database.php';
$connection = DriverManager::getConnection($dbConfig, $config);
// obtaining the entity manager
$entityManager = new EntityManager($connection, $config);