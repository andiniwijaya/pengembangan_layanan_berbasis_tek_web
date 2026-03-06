<?php

class Car {

    public $name;
    public $brand;

    public function __construct($name, $brand) {
        $this->name = $name;
        $this->brand = $brand;
    }

    public function startEngine() {
        return "The $this->brand $this->name engine is starting<br>";
    }

    public function stopEngine() {
        return "The $this->brand $this->name engine is stopping<br>";
    }

}
