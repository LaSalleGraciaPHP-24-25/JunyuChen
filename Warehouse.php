<?php

class Warehouse {
    protected $addresses;
    protected $city;
    protected $slots = [];
    protected $maxX;
    protected $maxY;
    protected $searchName;
    protected $type;

    public function __construct(string $city, array $addresses, int $maxX, int $maxY) {
        $this->city = $city;
        $this->addresses = $addresses;
        $this->maxX = [NULL];
        $this->maxY = [NULL];
    } 

    public function add(Item $item, int $x, int $y) {
        if ($x > $this->maxX || $y > $this->maxY) {
            return false;
        }
        $this->slots[$x][$y] = $item;
        return true;
    }

    public function remove(int $x, int $y) {
        if ($x > $this->maxX || $y > $this->maxY) {
            return false;
        }
        unset($this->slots[$x][$y]);
        return true;
    }

    public function orderByClass() {
        $items = [];
        foreach ($this->slots as $x => $row) {
            foreach ($row as $y => $item) {
                $items[] = $item;
            }
        }
        usort($items, function($a, $b) {
            return get_class($a) <=> get_class($b);
        });
        return $items;
    }

    public function removeBlanks() {
        foreach ($this->slots as $x => $row) {
            foreach ($row as $y => $item) {
                if ($item == NULL) {
                    unset($this->slots[$x][$y]);
                }
            }
        }
    }

    public function search($searchName) {
        $items = [];
        foreach ($this->slots as $x => $row) {
            foreach ($row as $y => $item) {
                if ($item->getName() == $searchName) {
                    $items[] = $item;
                }
            }
        }
        return $items;
    }

    public function searchByType($type) {
        $items = [];
        foreach ($this->slots as $x => $row) {
            foreach ($row as $y => $item) {
                if ($item instanceof $type) {
                    $items[] = $item;
                }
            }
        }
        return $items;
    }

    public function cleanWarehouse() {
        $this->slots = [];
    }

    public function sumPrices() {
        $sum = 0;
        foreach ($this->slots as $x => $row) {
            foreach ($row as $y => $item) {
                $sum += $item->calcPriceWithTax();
            }
        }
        return $sum;
    }

    public function avgPriceItems() {
        $sum = 0;
        $count = 0;
        foreach ($this->slots as $x => $row) {
            foreach ($row as $y => $item) {
                $sum += $item->calcPriceWithTax();
                $count++;
            }
        }
        return $sum / $count;
    }

    public function printInventory() {
        foreach ($this->slots as $x => $row) {
            foreach ($row as $y => $item) {
                echo $item . "\n";
            }
        }
    }
}