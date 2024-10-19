<?php

require_once 'Naming.php';

abstract class Item implements Naming {
    protected $name;
    protected $weight;
    protected $price;
    protected $isNew;

    protected function __construct(string $name, float $weight, float $price, bool $isNew) {
        $this->name = $name;
        $this->weight = $weight;
        $this->price = $price;
        $this->isNew = $isNew;
    }

    public function getName() {
        return $this->name;
    }

    public function setName(string $name) {
        $this->name = $name;
    }

    public function getWeight() {
        return $this->weight;
    }

    public function setWeight(float $weight) {
        $this->weight = $weight;
    }

    public function getPrice() {
        return $this->price;
    }

    public function setPrice(float $price) {
        $this->price = $price;
    }

    public function getIsNew() {
        return $this->isNew;
    }

    public function setIsNew(bool $isNew) {
        $this->isNew = $isNew;
    }

    abstract public function calcPriceWithTax();
}