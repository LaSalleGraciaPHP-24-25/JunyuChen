<?php

Class Drink extends Extendable implements Naming {
    protected $isAlcoholic;
    protected $volume;

    public function __toString() {
        return parent::__toString() . " Is Alcoholic: " . $this->isAlcoholic . " Volume: " . $this->volume;
    }

    public function __construct(string $name, float $weight, float $price, bool $isNew, string $expirationDate, bool $isAlcoholic, float $volume) {
        parent::__construct($name, $weight, $price, $isNew, $expirationDate);
        $this->isAlcoholic = $isAlcoholic;
        $this->volume = $volume;

        if ($this->isAlholic) {
            $this->tax = 1.20;
        }
    }

    public function getIsAlcoholic() {
        return $this->isAlcoholic;
    }

    public function setIsAlcoholic(bool $isAlcoholic) {
        $this->isAlcoholic = $isAlcoholic;
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