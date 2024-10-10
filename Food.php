<?php

Class Food extends Extendable implements Naming {
    protected $type = [];

    public function __toString() {
        return parent::__toString() . " Type: " . $this->type;
    }

    public function __construct(string $name, float $weight, float $price, bool $isNew, string $expirationDate, array $type) {
        parent::__construct($name, $weight, $price, $isNew, $expirationDate);
        $this->type = $type;
    }

    public function getType () {
        return $this->type;
    }

    public function setType (array $type) {
        $this->type = $type;
    }
}