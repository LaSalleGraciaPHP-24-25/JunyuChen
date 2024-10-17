<?php

require_once 'Item.php';

class NoExpendable extends Item implements Naming {
    protected $warrantyDueDate;
    protected $purchaseDate;
    protected $tax = 21;

    public function __toString() {
        return parent::__toString() . " Warranty Due Date: " . $this->warrantyDueDate . " Purchase Date: " . $this->purchaseDate;
    }

    public function __construct(string $name, float $weight, float $price, bool $isNew, string $warrantyDueDate, string $purchaseDate) {
        parent::__construct($name, $weight, $price, $isNew);
        $this->warrantyDueDate = NULL;
        $this->purchaseDate = $purchaseDate;
    }

    public function getWarrantyDueDate() {
        return $this->warrantyDueDate;
    }

    public function setWarrantyDueDate(string $warrantyDueDate) {
        $this->warrantyDueDate = $warrantyDueDate;
    }

    public function getPurchaseDate() {
        return $this->purchaseDate;
    }

    public function setPurchaseDate(string $purchaseDate) {
        $this->purchaseDate = $purchaseDate;
    }

    public function fulfillWarranty() {
        return strtotime($this->warrantyDueDate) > time();
    }

    public function calcPriceWithTax() {
        return $this->price * $this->tax;
    }
}