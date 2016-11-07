<?php

namespace Cart\Controllers;

use Slim\Router;

use Slim\Views\Twig;

use Cart\Basket\Basket;

use Cart\Models\Product;

use Psr\Http\Message\ResponseInterface as Response;

use Psr\Http\Message\ServerRequestInterface as Request;

class CartController
{
    protected $basket;
    protected $product;

    public function __construct(Basket $basket, Product $product)
    {
        $this->basket = $basket; 
        $this->product = $product; 
    }

    public function index(Request $request, Response $response, Twig $view)
    {
        // TODO
        return $view->render($response, 'cart/index.twig');

    }  

    public function add($slug, $quantity, Request $request, Response $response, Router $router)
    {
        // Must take care of adding items into the client's cart
        $product = $this->product->where('slug', $slug)->first();

        if (!$product)
        {
            return $response->withRedirect($router->pathFor('home'));
        }

        try 
        {
            $this->basket->add($product, $quantity);
        } 

        catch (QuantityExceededException $e)
        {

        }

        return $response->withRedirect($router->pathFor('cart.index'));
    }  
}
