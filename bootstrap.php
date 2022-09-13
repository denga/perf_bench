<?php

use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Doctrine\ORM\Tools\SchemaTool;

require_once(__DIR__ . '/vendor/autoload.php');

function getEntityManager(): EntityManager
{
    $classDirs = array(
        __DIR__ . '/src/Entity',
    );

    $config = ORMSetup::createAttributeMetadataConfiguration($classDirs);

    $connectionOptions = array(
        'driver' => 'pdo_sqlite',
        'memory' => true,
        //'path' => __DIR__ . '/data/database.sqlite'
    );

    return EntityManager::create($connectionOptions, $config);
}


function createSchema(EntityManager $em): void
{
    $metadatas = $em->getMetadataFactory()->getAllMetadata();

    $tool = new SchemaTool($em);
    $tool->createSchema($metadatas);
}

function dropSchema(EntityManager $em): void
{
    $metadatas = $em->getMetadataFactory()->getAllMetadata();

    $tool = new SchemaTool($em);
    $tool->dropSchema($metadatas);
}

function loadFixtures(EntityManager $em): void
{
    $loader = new Loader();
    $loader->loadFromDirectory(__DIR__ . '/src/Fixtures');

    $executor = new ORMExecutor($em, new ORMPurger());
    $executor->execute($loader->getFixtures());
}

