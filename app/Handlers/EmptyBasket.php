<?php

namespace Cart\Handlers;

use Cart\Hanlders\Contracts\HandlerInterface;


class EmptyBasket implements HandlerInterface
{
    public function handle($event)
    {
        die('empty basket');
    }
}