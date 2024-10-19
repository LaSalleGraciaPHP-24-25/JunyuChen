<?php

require_once 'Item.php';

class Expendable extends Item implements Naming {
    protected $expirationDate;
    protected $tax = 10;

    public function __toString() {
        return "Expendable Item:
        Name: " . $this->name . "
        Weight: " . $this->weight . "
        Price: " . $this->price . "
        Is New: " . ($this->isNew ? 'Yes' : 'No') . "
        Expire Date: " . $this->expireDate . "
        Tax: " . $this->tax . "%";
    }

    public function __construct(string $name, float $weight, float $price, bool $isNew, string $expirationDate, $tax) {
        parent::__construct($name, $weight, $price, $isNew);
        $this->expirationDate = $expirationDate;
        $this->tax = $tax;
    }

    public function calcPriceWithTax() {
        return $this->price * (1 + $this->tax / 100);
    }

    public function isExpired() {
        $currentDate = date('Y-m-d');
        return $currentDate > $this->expireDate;
    }
}