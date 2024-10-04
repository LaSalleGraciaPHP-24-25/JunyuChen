<?php

require_once 'Item.php';

class Expendable extends Item implements Naming {
    protected $expirationDate;
    protected $tax = 1.10;

    public function __toString () {
        return parent::__toString() . " Expiration Date: " . $this->expirationDate;
    }

    public function __construct(string $name, float $weight, float $price, bool $isNew, string $expirationDate) {
        parent::__construct($name, $weight, $price, $isNew);
        $this->expirationDate = $expirationDate;
    }

    public function calcPriceWithTax() {
        return $this->price * $this->tax;
    }

    public function isExpired() {
        return strtotime($this->expirationDate) < time();
    }
}