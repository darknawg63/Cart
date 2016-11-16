<?php

// BraintreeController.php

namespace Cart\Controllers;

use Braintree_ClientToken as BT_ClientToken;

use Psr\Http\Message\ResponseInterface as Response;

class BraintreeController
{
    public function token(Response $response)
    {
        return $response->withJson([
            'token' => BT_ClientToken::generate(),
        ]);
    }
}