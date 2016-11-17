<?php

// app.php

use Cart\App;

// Needed to pass Twig to our middleware
use Slim\Views\Twig;

use Illuminate\Database\Capsule\Manager as Capsule;

session_start();

require __dir__ . '/../vendor/autoload.php';

$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

Braintree_Configuration::environment('sandbox');
Braintree_Configuration::merchantId($_ENV['BT_MERCHANT_ID']);
Braintree_Configuration::publicKey($_ENV['BT_PUBLIC_KEY']);
Braintree_Configuration::privateKey($_ENV['BT_PRIVATE_KEY']);

$app = new App;

$container = $app->getContainer();

$capsule = new Capsule;

$capsule->addConnection([
    'driver' => 'mysql',
    'host' => 'localhost',
    'database' => 'cart',
    'username' => $_ENV['DB_USER'],
    'password' => $_ENV['DB_PASSWORD'],
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => '',

]);

$capsule->setAsGlobal();
$capsule->bootEloquent();

require __dir__ . '/../app/routes.php';

// This registers our custom made middleware :)
$app->add(new \Cart\Middleware\ValidationErrorsMiddleware($container->get(Twig::class)));