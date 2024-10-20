<?php

Class Food extends Expendable implements Naming {
    protected $type = [];

    public function __toString() {
        return parent::__toString() . " Type: " . $this->type;
    }

    public function __construct($name, $weight, $price, $isNew, $expirationDate, $type = [], $tax = 10) {
        parent::__construct($name, $weight, $price, $isNew, $expirationDate, $tax);
        $this->type = $type;
    }

    public function getType () {
        return $this->type;
    }

    public function setType (array $type) {
        $this->type = $type;
    }
}