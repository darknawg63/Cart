<?php

use function DI\get;
use Slim\Views\Twig;
use Cart\Basket\Basket;
use Cart\Models\Product;
use Cart\Models\Payment;
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

    // cart is the name of the bucket, or array, within the SessionStorage 
    // object where all of the user's chosen items are stored.
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

    Payment::class => function (ContainerInterface $c) {
        return new Payment;
    },

    Basket::class => function (ContainerInterface $c) {
        
        return new Basket(

            // Here we grab these two classes off the container
            // and pass them into, or make them available to <thead>
            // Basket class
            $c->get(SessionStorage::class),
            $c->get(Product::class)

        );
    }

];
