<?php

namespace Cart\Handlers;

use Cart\Handlers\Contracts\HandlerInterface;


class EmptyBasket implements HandlerInterface
{
    public function handle($event)
    {
        die('empty basket');
    }
}