<?php

namespace Cart\Events;

use Cart\Handlers\Contracts\HandlerInterface;

class Event
{
    protected $handlers = [];

    public function attach($handlers)
    {
        if (is_array($handlers))
        {
            foreach ($handlers as $handler)
            {
                if (!$handler instanceof HandlerInterface)
                {
                    // No handler method, so do not attach it
                    continue;
                }

                $this->handlers[] = $handler;
            }

            return;
        }

        if (!$handlers instanceof HandlerInterface)
        {
            return;
        }

        $this->handlers[] = $handlers;
    }

    public function dispatch()
    {
        foreach ($this->handlers as $handler)
        {
            // passing in the current instance of this Event
            $handler->handle($this);
        }
    }
}