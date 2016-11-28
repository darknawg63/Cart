<?php

// OldInputMiddleware.php

// I forgot to implement this from Build A Shopping Cart with PHP: Order form (10/15) 
// This middleware class is responsible for saving the user's entered form data.
// If for some reason, the payment fails, the user won't have to re-enter everything anew.

namespace Cart\Middleware;

use Slim\Views\Twig;

class OldInputMiddleware
{
   
   protected $view;

   // Here we pass Twig through to our middleware
   public function __construct(Twig $view)
   {
       $this->view = $view;
   }

   // The __invoke magic method is a part ot the Slim framework middleware
   public function __invoke($request, $response, $next)
   {
       if (isset($_SESSION['old']))
       {
            $this->view->getEnvironment()->addGlobal('old', $_SESSION['old']);
       }

       // Here, we grab all of the data that was entered into the form.
       $_SESSION['old'] = $request->getParams();

       $response = $next($request, $response);

       return $response;
   }
}
