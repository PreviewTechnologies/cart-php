<?php

namespace Previewtechs\Cart;

/**
 * Class Cart
 * @package Previewtechs\Cart
 */
class Cart
{
    /**
     * @var
     */
    protected $id;

    /**
     * @var StorageInterface
     */
    protected $storage;

    /**
     * @var string
     */
    public $name = 'Cart';

    /**
     * @var array
     */
    protected $items = [];

    /**
     * Cart constructor.
     * @param $id
     * @param StorageInterface $storage
     */
    public function __construct($id, StorageInterface $storage)
    {
        $this->id = $id;
        $this->storage = $storage;
        $this->items = $this->storage->read($this->id);;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return array
     */
    public function getInfo()
    {
        $info = [
            'id' => $this->id,
            'items' => $this->items
        ];
        return $info;
    }

    /**
     * @param CartItem $cartItem
     * @return mixed
     */
    public function addItem(CartItem $cartItem)
    {
        $this->items = $this->storage->read($this->id);
        $alreadyExiest = $this->hasAlreadyInCart($this->items, $cartItem);
        if (!$alreadyExiest) {
            $itemId = uniqid();
            $this->items[$itemId] = $cartItem;
        }
    }

    /**
     * @param $cartItems
     * @param $newItem
     * @return bool
     */
    public function hasAlreadyInCart($cartItems, $newItem)
    {
        if(is_array($cartItems)){
            foreach ($cartItems as $key => $item) {
                if ($item->getName() == $newItem->getName()) {
                    $this->items[$key]->setQuantity($item->getQuantity() + 1);
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * @param $itemId
     * @return mixed
     */
    public function has($itemId)
    {
        if ($this->items[$itemId]) {
            return true;
        }
        return false;
    }

    /**
     * @param $itemId
     * @return mixed
     */
    public function get($itemId)
    {
        return $this->items[$itemId];
    }

    /**
     * @param $itemId
     * @return mixed
     */
    public function update($itemId)
    {
        $this->storage->write($this->id, $this->items);
        return $this->items[$itemId];
    }

    /**
     * @param $itemId
     */
    public function delete($itemId)
    {
        unset($this->items[$itemId]);
        $this->storage->write($this->id, $this->items);
    }

    /**
     * @return array
     */
    public function countItems()
    {
        return sizeof($this->items);
    }

    /**
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @return array
     */
    public function getTotal()
    {
        $total = 0.00;
        foreach ($this->items as $key => $item) {
            $total += $item->getPrice();
        }
        return number_format((float)$total, 2, '.', '');
    }

    /**
     * @return array
     */
    public function clear()
    {
        $this->items = [];
        return $this->storage->write($this->id, $this->items);
    }
}