<?php

namespace Previewtechs\Cart\Storage;

use Previewtechs\Cart\StorageInterface;

class Session implements StorageInterface
{
    public function __construct()
    {
        if(!isset($_SESSION)){
            Throw new \Exception('Session is not started!');
        }
    }

    public function read($cartId)
    {
        return isset($_SESSION[$cartId]) ? $_SESSION[$cartId] : [];
    }

    public function write($cartId, $data)
    {
        $_SESSION[$cartId] = $data;
        if(isset($_SESSION[$cartId]) && $_SESSION[$cartId])
        {
            return true;
        }
    }

    public function delete($cartId)
    {
        unset($_SESSION[$cartId]);
    }
}