<?php

namespace Previewtechs\Cart;

/**
 * Class Cart
 * @package Previewtechs\Cart
 */
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
     * @var float
     */
    protected $vat = 0.00;

    /**
     * @var float
     */
    protected $tax = 0.00;

    /**
     * @var float
     */
    protected $shippingCost = 0.00;

    /**
     * @var float
     */
    protected $discount = 0.00;

    /**
     * @var float
     */
    protected $subtotal = 0.00;

    /**
     * @var float
     */
    protected $total = 0.00;

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
     * @return StorageInterface
     */
    public function getStorage()
    {
        return $this->storage;
    }

    /**
     * @param StorageInterface $storage
     */
    public function setStorage(StorageInterface $storage)
    {
        $this->storage = $storage;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
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
            'items' => $this->items,
            'total_items' => $this->countItems(),
            'subtotal' => $this->getSubtotal(),
            'vat' => $this->getVat(),
            'tax' => $this->getTax(),
            'shipping_cost' => $this->getShippingCost(),
            'discount' => $this->getDiscount(),
            'total' => $this->getTotal()
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
        return $this->storage->write($this->id, $this->items);
    }

    /**
     * @param $cartItems
     * @param $newItem
     * @return bool
     */
    public function hasAlreadyInCart($cartItems, $newItem)
    {
        foreach ($cartItems as $key => $item) {
            if ($item->getName() == $newItem->getName()) {
                $this->items[$key]->setQuantity($item->getQuantity() + 1);
                return true;
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
     * @return float
     */
    public function getVat()
    {
        return $this->vat;
    }

    /**
     * @param float $vat
     */
    public function setVat($vat)
    {
        $this->vat = $vat;
    }

    /**
     * @return float
     */
    public function getTax()
    {
        return $this->tax;
    }

    /**
     * @param float $tax
     */
    public function setTax($tax)
    {
        $this->tax = $tax;
    }

    /**
     * @return float
     */
    public function getShippingCost()
    {
        return $this->shippingCost;
    }

    /**
     * @param float $shippingCost
     */
    public function setShippingCost($shippingCost)
    {
        $this->shippingCost = $shippingCost;
    }

    /**
     * @return float
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * @param float $discount
     */
    public function setDiscount($discount)
    {
        $this->discount = $discount;
    }


    /**
     * @return array
     */
    public function getSubtotal()
    {
        $subTotal = 0;
        foreach ($this->items as $key => $item) {
            $subTotal += $item->getSubtotal();
        }
        return $this->subtotal = $subTotal;
    }

    /**
     * @return array
     */
    public function getTotal()
    {
        return $this->total = $this->subtotal - ($this->vat + $this->tax + $this->shippingCost + $this->discount);
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