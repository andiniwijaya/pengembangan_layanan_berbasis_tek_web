<?php

require_once __DIR__ . '/class/Person.php';
require_once __DIR__ . '/class/Car.php';

echo "<h2>Class Person</h2>";

$eko = new Person("Eko", "Eko");
$joko = new Person("Joko", "Nugroho");
$budi = new Person("Budi", "Nugraha");

/** Hello */
echo $eko->sayHello("Joko");
echo $eko->sayHello("Budi");

echo $joko->sayHello("Eko");
echo $joko->sayHello("Budi");

echo $budi->sayHello("Eko");
echo $budi->sayHello("Joko");

/** Good Bye */
echo $eko->sayGoodBye("Joko");
echo $eko->sayGoodBye("Budi");

echo $joko->sayGoodBye("Eko");
echo $joko->sayGoodBye("Budi");

echo $budi->sayGoodBye("Eko");
echo $budi->sayGoodBye("Joko");


echo "<hr>";


echo "<h2>Class Car</h2>";

$avanza = new Car("Avanza", "Toyota");
$almaz = new Car("Almaz", "Wuling");
$mobilio = new Car("Mobilio", "Honda");

/** Start Engine */
echo $avanza->startEngine();
echo $almaz->startEngine();
echo $mobilio->startEngine();

/** Stop Engine */
echo $avanza->stopEngine();
echo $almaz->stopEngine();
echo $mobilio->stopEngine();
