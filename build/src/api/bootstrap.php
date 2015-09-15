<?php

	require_once '../../../packages/autoload.php';

    $dsn = "mysql:dbname=scada_it_database;host=localhost;charset=UTF8";
    $username = "root";
    $password = "";
    $pdo = new PDO($dsn, $username, $password);
    $db = new NotORM($pdo);

    /* Slim framework */
    //$app = new \Slim\Slim();

    $app = new \Slim\Slim(array(
        'view' => new \Slim\Views\Twig(),
        'templates.path' => '../../../src/api/views'
    ));

    $view = $app->view();
    $view->parserExtensions = array(
        new \Slim\Views\TwigExtension()
    );

    require 'routes.php';

    $app->run();

?>