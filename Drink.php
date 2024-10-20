<?php

Class Drink extends Expendable implements Naming {
    private $isAlcoholic;
    private $volume;

    public function __toString() {
        return parent::__toString() . " Is Alcoholic: " . $this->isAlcoholic . " Volume: " . $this->volume;
    }

    public function __construct($name, $weight, $price, $isNew, $expirationDate, $isAlcoholic, $volume, $tax = 10) {
        parent::__construct($name, $weight, $price, $isNew, $expirationDate, $tax);
        $this->isAlcoholic = $isAlcoholic;
        $this->volume = $volume;

        if ($this->isAlcoholic) {
            $this->tax = 21;
        }
    }

    public function getIsAlcoholic() {
        return $this->isAlcoholic;
    }

    public function setIsAlcoholic($isAlcoholic) {
        $this->isAlcoholic = $isAlcoholic;
        if ($this->isAlcoholic) {
            $this->tax = 21;
        }
    }

    public function getVolume() {
        return $this->volume;
    }

    public function setVolume(float $volume) {
        $this->volume = $volume;
    }

    public function toLiters() {
        return $this->volume / 1000;
    }

    public function toGallons() {
        return $this->volume / 3785.41;
    }
}