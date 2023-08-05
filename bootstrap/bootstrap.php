<?php

require __DIR__ . '/../vendor/autoload.php';

use DI\ContainerBuilder;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Subwayminder\CrudTestTask\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$config = ORMSetup::createAttributeMetadataConfiguration(
    paths: array(__DIR__."/../src/Entity"),
    isDevMode: true,
);
// configuring the database connection
$dbConfig = require __DIR__ . '/../config/database.php';
$connection = DriverManager::getConnection($dbConfig, $config);
// obtaining the entity manager
$entityManager = new EntityManager($connection, $config);


$request = Request::createFromGlobals();
$jwt = $request->headers->get('Authorization');
$decoded = $jwt !== null
     ? JWT::decode($jwt,
        new Key(
        'DfzCzKBflsthbax1TKUawbhOd6NR207bgtr9DesRw5A0W7WznHNJShGwPCKuoKYV',
        'HS256'
        )
    )
    : null;
$user = $decoded
    ? $entityManager
    ->getRepository(User::class)
    ->find($decoded->data->id)
    : null;


$containerBuilder = new ContainerBuilder;
$containerBuilder->addDefinitions([
    EntityManager::class => $entityManager,
    ValidatorInterface::class => Validation::createValidator(),
    User::class => $user
]);
$container = $containerBuilder->build();