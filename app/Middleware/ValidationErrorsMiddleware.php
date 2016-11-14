<?php

namespace Cart\Middlewware;


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

       return $response;
   } 
}