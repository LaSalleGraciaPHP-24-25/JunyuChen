<?php

// Fitxer: index.php

// Incloem els fitxers necessaris
require_once 'Warehouse.php';
require_once 'Item.php';
require_once 'Expendable.php';
require_once 'Food.php';
require_once 'Drink.php';
require_once 'NoExpendable.php';

// Creem una nova instància de Warehouse
$warehouse = new Warehouse("Main Warehouse", "1234 Street", "Barcelona", 5, 5);
echo $warehouse->__toString() . PHP_EOL;

// Creem alguns objectes de Food
$apple = new Food("Apple", 200, 1.50, true, "2024-12-31", ["Fruit", "Km 0", "Fresh"]);
$banana = new Food("Banana", 150, 1.00, true, "2024-11-15", ["Fruit", "Imported"]);
$milk = new Drink("Milk", 1000.0, 2.5, true, "2024-10-25", false, 1000);
$whisky = new Drink("Whisky", 700.0, 25.0, false, "2025-12-01", true, 700);
$laptop = new NoExpendable("Laptop", 1500, 999.99, false, "2023-08-15");

// Afegim els objectes a la Warehouse
$warehouse->add($apple);
$warehouse->add($banana);
$warehouse->add($milk);
$warehouse->add($whisky);
$warehouse->add($laptop);

// Mostrem l'inventari actual
echo PHP_EOL . "=== Inventari actual ===" . PHP_EOL;
$warehouse->printInventory();

// Busquem un item per nom
echo PHP_EOL . "=== Cerca per nom 'Apple' ===" . PHP_EOL;
$searchResult = $warehouse->search("Apple");
echo "Nombre d'elements trobats: " . $searchResult['count'] . PHP_EOL;

// Busquem per tipus
echo PHP_EOL . "=== Cerca per tipus 'Fruit', 'Km 0' ===" . PHP_EOL;
$typeResult = $warehouse->searchByType("Fruit", "Km 0");
echo "Nombre de Food trobats: " . $typeResult['count'] . PHP_EOL;

// Ordenem els elements per classe
$warehouse->order();
echo PHP_EOL . "=== Inventari ordenat per classe ===" . PHP_EOL;
$warehouse->printInventory();

// Eliminar items caducats
echo PHP_EOL . "=== Eliminant Expendables caducats ===" . PHP_EOL;
$warehouse->searchExpired();
$warehouse->printInventory();

// Afegir data de garantia al laptop i mostrar-ho
echo PHP_EOL . "=== Afegeix garantia a l'ordinador portàtil ===" . PHP_EOL;
$laptop->fulfillWarranty();
echo $laptop->__toString() . PHP_EOL;

// Suma i mitjana de preus
echo PHP_EOL . "=== Suma i mitjana dels preus amb impostos ===" . PHP_EOL;
echo "Suma total: " . $warehouse->sumPriceItems() . "€" . PHP_EOL;
echo "Mitjana de preus: " . $warehouse->avgPriceItems() . "€" . PHP_EOL;

// Calcular el total de litres de begudes
echo PHP_EOL . "=== Càlcul de litres totals de begudes ===" . PHP_EOL;
$warehouse->calculateTotalLiters();

// Busca Expendables que caduquin entre dues dates
echo PHP_EOL . "=== Expendables que caduquen entre '2024-10-01' i '2024-12-31' ===" . PHP_EOL;
$warehouse->findExpiringBetweenDates("2024-10-01", "2024-12-31");

?>