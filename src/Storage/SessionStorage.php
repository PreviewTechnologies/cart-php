<?php

namespace Previewtechs\Cart\Storage;

use Previewtechs\Cart\StorageInterface;

class SessionStorage implements StorageInterface
{
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