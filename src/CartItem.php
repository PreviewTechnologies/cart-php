<?php

namespace Previewtechs\Cart;

/**
 * Class CartItem
 * @package Previewtechs\Cart
 */
class CartItem
{
    /**
     * @var
     */
    protected $name;

    /**
     * @var int
     */
    protected $quantity = 1;

    /**
     * @var
     */
    protected $price;

    /**
     * @var
     */
    protected $subtotal;

    /**
     * @var
     */
    protected $sku;

    /**
     * @var
     */
    protected $description;

    /**
     * @var
     */
    protected $note;

    /**
     * @var array
     */
    protected $options = [];

    /**
     * CartItem constructor.
     * @param $name
     * @param $price
     */
    public function __construct($name = null, $price = null)
    {
        $this->name = $name;
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
        $this->setSubtotal();
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
        $this->setSubtotal();
    }

    /**
     * @return mixed
     */
    public function getSubtotal()
    {
        return $this->subtotal;
    }

    /**
     *
     */
    public function setSubtotal()
    {
        $this->subtotal = (float) $this->price * $this->quantity;
    }

    /**
     * @return mixed
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * @param mixed $sku
     */
    public function setSku($sku)
    {
        $this->sku = $sku;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @param mixed $note
     */
    public function setNote($note)
    {
        $this->note = $note;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param array $options
     */
    public function setOptions($options)
    {
        $this->options = $options;
    }
}