<?php

use function DI\get;
use Slim\Views\Twig;
use Cart\Basket\Basket;
use Cart\Models\Product;
use Slim\Views\TwigExtension;
use Interop\Container\ContainerInterface;
use Cart\Support\Storage\SessionStorage;
use Cart\Support\Storage\Contracts\StorageInterface;
use Cart\Validation\Contracts\ValidatorInterface;
use Cart\Validation\Validator;
use Cart\Models\Order;
use Cart\Models\Customer;
use Cart\Models\Address;

return [

    'router' => get(Slim\Router::class),

    ValidatorInterface::class => function (ContainerInterface $c) {

        return new Validator;

    },

    StorageInterface::class => function (ContainerInterface $c) {

        return new SessionStorage('cart');
    },

    Twig::class => function (ContainerInterface $c) {

        $twig = new Twig(__dir__ . '/../resources/views', [

            // For production you might want to set this to true
            'cache' => false

        ]);

        $twig->addExtension(new TwigExtension(

            $c->get('router'),
            $c->get('request')->getUri()

        ));

        // We want our basket to be accessable to all views
        // addGlobal("Key", "Current container")
        $twig->getEnvironment()->addGlobal('basket', $c->get(Basket::class));

        return $twig;

    },

    Product::class => function (ContainerInterface $c) {
        return new Product;
    },

    Order::class => function (ContainerInterface $c) {
        return new Order;
    },

    Customer::class => function (ContainerInterface $c) {
        return new Customer;
    },

    Address::class => function (ContainerInterface $c) {
        return new Address;
    },

    Basket::class => function (ContainerInterface $c) {
        
        return new Basket(

            $c->get(SessionStorage::class),
            $c->get(Product::class)

        );
    }

];
