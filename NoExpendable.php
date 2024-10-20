<?php

require_once 'Item.php';

class NoExpendable extends Item implements Naming {
    private $warrantyDueDate;
    private $purchaseDate;
    const TAX = 21;

    public function __toString() {
        return parent::__toString() . " Warranty Due Date: " . $this->warrantyDueDate . " Purchase Date: " . $this->purchaseDate;
    }

    public function __construct($name, $weight, $price, $isNew, $warrantyDueDate, $purchaseDate, $tax = self::TAX) {
        parent::__construct($name, $weight, $price, $isNew, $tax);
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