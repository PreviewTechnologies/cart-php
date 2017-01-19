<?php

namespace Previewtechs\Cart;

interface StorageInterface
{
    public function read($cartId);

    public function write($cartId, $data);

    public function delete($cartId);
}