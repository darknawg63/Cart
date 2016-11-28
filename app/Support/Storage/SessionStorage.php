<?php

/**
 * The purpose of the storage class is to handle anything that has to do
 * with getting, setting, counting, querying and clearing items in the 
 * user's session. By using this utility class we keep all of this code
 * out of our controller. The SessionStorage class will mainly be used by
 * the Basket class
 */

namespace Cart\Support\Storage;

use Countable;

use Cart\Support\Storage\Contracts\StorageInterface;

class SessionStorage implements StorageInterface, Countable
{
    protected $bucket;

    public function __construct($bucket = 'default')
    {
        if (!isset($_SESSION[$bucket]))
        {
            $_SESSION[$bucket] = [];
        }

        $this->bucket = $bucket;

    }

    // The $index being passed is the product's  id which is used
    // to set the bucket index of the product used for later referral
    // $value is the quantity of the item with id $index :))
    public function set($index, $value)
    {
        $_SESSION[$this->bucket][$index] = $value;
    }

    public function get($index)
    {
        if (!$this->exists($index))
        {
            return null;
        }

        return $_SESSION[$this->bucket][$index];
    }

    public function exists($index)
    {
        return isset($_SESSION[$this->bucket][$index]);
    }

    public function all()
    {
        return $_SESSION[$this->bucket];
    }

    public function unset($index)
    {
        if ($this->exists($index))
        {
            unset($_SESSION[$this->bucket][$index]);
        }
        
    }

    public function clear()
    {
        unset($_SESSION[$this->bucket]);
    }

    public function count()
    {
        return count($this->all());
    }
}
