<?php

// ValidationErrorsMiddleware.php

namespace Cart\Middleware;

use Slim\Views\Twig;

class ValidationErrorsMiddleware
{
   
   // Needed because we wish to pass any errors into the session and 
   // display them on our views.
   protected $view;

   // Here we pass Twig through to our middleware
   public function __construct(Twig $view)
   {
       $this->view = $view;
   }

   // The __invoke magic method is a part ot the Slim framework middleware
   public function __invoke($request, $response, $next)
   {
       $response = $next($request, $response);

       if (isset($_SESSION['errors']))
       {
           // Our views should be picking up the errors, but for some reason it doesn't
           $this->view->getEnvironment()->addGlobal('errors', $_SESSION['errors']);
           var_dump($this->view);
           die('ValidationErrorsMiddleware');

           unset($_SESSION['errors']);
       }

       return $response;
   }
}