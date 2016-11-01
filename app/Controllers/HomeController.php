<?php

namespace Cart\Controllers;

use Slim\Views\Twig;

use Cart\Models\Product;

use Psr\Http\Message\ResponseInterface as Response;

use Psr\Http\Message\ServerRequestInterface as Request;

class HomeController
{
    public function index(Request $request, Response $response, Twig $view, Product $product)
    {
        // Just for testing connectivity for now
        $products = $product->get();
        var_dump($products->first());
        die();
        return $view->render($response, 'home.twig');
    }
}
