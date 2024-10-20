<?php

// Fitxer: Warehouse.php

require_once 'Naming.php';
require_once 'Item.php';
require_once 'Expendable.php';
require_once 'Food.php';
require_once 'Drink.php';

class Warehouse implements Naming {
    // Atributs propis
    private $name;
    private $address;
    private $city;
    private $slots;
    private $maxX;
    private $maxY;

    // Constructor
    public function __construct($name, $address, $city, $maxX, $maxY) {
        $this->name = $name;
        $this->address = $address;
        $this->city = $city;
        $this->maxX = $maxX;
        $this->maxY = $maxY;
        $this->slots = array_fill(0, $maxX, array_fill(0, $maxY, null));
    }

    // Mètodes de la interfície Naming
    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function __toString() {
        return "Warehouse: $this->name, Address: $this->address, City: $this->city";
    }

    // Mètode per afegir un item a la primera posició buida
    public function add(Item $item) {
        for ($x = 0; $x < $this->maxX; $x++) {
            for ($y = 0; $y < $this->maxY; $y++) {
                if ($this->slots[$x][$y] === null) {
                    $this->slots[$x][$y] = $item;
                    return true;
                }
            }
        }
        return false; // Si no hi ha espais disponibles
    }

    // Mètode per eliminar un item d'una posició específica
    public function remove($x, $y) {
        if (isset($this->slots[$x][$y])) {
            $this->slots[$x][$y] = null;
        }
    }

    // Mètode per ordenar els items per classe
    public function order() {
        $items = [];
        foreach ($this->slots as $row) {
            foreach ($row as $item) {
                if ($item !== null) {
                    $items[] = $item;
                }
            }
        }
        usort($items, function ($a, $b) {
            return strcmp(get_class($a), get_class($b));
        });
        $this->slots = array_fill(0, $this->maxX, array_fill(0, $this->maxY, null));
        $this->fillSlots($items);
    }

    // Mètode per eliminar posicions buides dins de slots
    public function removeBlanks() {
        $items = [];
        foreach ($this->slots as $row) {
            foreach ($row as $item) {
                if ($item !== null) {
                    $items[] = $item;
                }
            }
        }
        $this->slots = array_fill(0, $this->maxX, array_fill(0, $this->maxY, null));
        $this->fillSlots($items);
    }

    // Mètode auxiliar per omplir slots amb una llista d'items
    private function fillSlots($items) {
        $index = 0;
        for ($x = 0; $x < $this->maxX && $index < count($items); $x++) {
            for ($y = 0; $y < $this->maxY && $index < count($items); $y++) {
                $this->slots[$x][$y] = $items[$index++];
            }
        }
    }

    // Mètode de cerca d'items per nom
    public function search($name) {
        $result = ['count' => 0, 'items' => []];
        foreach ($this->slots as $row) {
            foreach ($row as $item) {
                if ($item !== null && $item->getName() === $name) {
                    $result['count']++;
                    $result['items'][] = $item;
                }
            }
        }
        return $result;
    }

    // Mètode de cerca d'items per tipus utilitzant el rest operator
    public function searchByType(...$types) {
        $result = ['count' => 0, 'items' => []];
        foreach ($this->slots as $row) {
            foreach ($row as $item) {
                if ($item instanceof Food && !array_diff($types, $item->getType())) {
                    $result['count']++;
                    $result['items'][] = $item;
                }
            }
        }
        return $result;
    }

    // Mètode per buscar i eliminar Expendables caducats
    public function searchExpired($days = 0) {
        $currentDate = new DateTime();
        foreach ($this->slots as $x => $row) {
            foreach ($row as $y => $item) {
                if ($item instanceof Expendable) {
                    $expirationDate = new DateTime($item->getexpirationDate());
                    $interval = $currentDate->diff($expirationDate)->days;
                    if ($interval <= $days || $currentDate > $expirationDate) {
                        $this->remove($x, $y);
                    }
                }
            }
        }
    }

    // Mètode per buidar la Warehouse
    public function cleanWarehouse() {
        foreach ($this->slots as $x => $row) {
            foreach ($row as $y => $item) {
                $this->remove($x, $y);
            }
        }
    }

    // Mètode per calcular la suma total dels preus amb taxes
    public function sumPriceItems() {
        $sum = 0;
        foreach ($this->slots as $row) {
            foreach ($row as $item) {
                if ($item !== null) {
                    $sum += $item->calcPriceWithTax();
                }
            }
        }
        return $sum;
    }

    // Mètode per calcular la mitjana dels preus amb taxes
    public function avgPriceItems() {
        $total = 0;
        $count = 0;
        foreach ($this->slots as $row) {
            foreach ($row as $item) {
                if ($item !== null) {
                    $total += $item->calcPriceWithTax();
                    $count++;
                }
            }
        }
        return $count > 0 ? $total / $count : 0;
    }

    // Mètode per mostrar l'inventari de la Warehouse
    public function printInventory() {
        foreach ($this->slots as $x => $row) {
            foreach ($row as $y => $item) {
                if ($item !== null) {
                    echo "Position [$x][$y]: " . $item . PHP_EOL;
                }
            }
        }
    }

    // Mètode per calcular el total de litres de begudes a la Warehouse
    public function calculateTotalLiters() {
        $totalLiters = 0;
        $alcoholicLiters = 0;
        $nonAlcoholicLiters = 0;

        foreach ($this->slots as $row) {
            foreach ($row as $item) {
                if ($item instanceof Drink) {
                    $liters = $item->toLiters();
                    $totalLiters += $liters;
                    if ($item->getIsAlcoholic()) {
                        $alcoholicLiters += $liters;
                    } else {
                        $nonAlcoholicLiters += $liters;
                    }
                }
            }
        }

        $alcoholicPercentage = $totalLiters > 0 ? ($alcoholicLiters / $totalLiters) * 100 : 0;
        $nonAlcoholicPercentage = $totalLiters > 0 ? ($nonAlcoholicLiters / $totalLiters) * 100 : 0;

        echo "Total liters: $totalLiters L" . PHP_EOL;
        echo "Alcoholic drinks: $alcoholicPercentage%" . PHP_EOL;
        echo "Non-alcoholic drinks: $nonAlcoholicPercentage%" . PHP_EOL;
    }

    // Mètode per buscar Expendables que caduquin entre dues dates
    public function findExpiringBetweenDates($startDate, $endDate) {
        $start = new DateTime($startDate);
        $end = new DateTime($endDate);

        foreach ($this->slots as $x => $row) {
            foreach ($row as $y => $item) {
                if ($item instanceof Expendable) {
                    $expirationDate = new DateTime($item->getexpirationDate());
                    if ($expirationDate >= $start && $expirationDate <= $end) {
                        echo "Item: " . $item->getName() . " at position [$x][$y] expires between the given dates." . PHP_EOL;
                    }
                }
            }
        }
    }
}