PRE TEST

Nama : Andini Wijayanti
NIM : 2341004

Project ini dibuat untuk memenuhi tugas pre test mata kuliah 'Pengembangan Layanan Berbasis Tek. WEB'
Dosen Pengampu : Mohamad Abduh


## Struktur Folder
PRE_TEST
    index.php
    class
        Person.php
        Car.php
    README.md


## Penjelasan File
1. index.php
    File utama untuk menjalankan program.
    Di dalam file index.php dibuat beberapa object dari class Person dan class Car, lalu memanggil method yang ada di dalam class tersebut.

    Contoh:
    - Person saling menyapa menggunakan `sayHello()`
    - Person mengucapkan perpisahan menggunakan `sayGoodBye()`
    - Mobil menyalakan mesin dengan `startEngine()`
    - Mobil mematikan mesin dengan `stopEngine()`


2. Person.php
    Berisi class Person dengan atribut:
    - `firstName`
    - `lastName`

    Method yang tersedia:
    - `sayHello($name)`     -> untuk menyapa
    - `sayGoodBye($name)`   -> untuk mengucapkan perpisahan


3. Car.php
    Berisi class Car dengan atribut:
    - `name`
    - `brand`

    Method ynag tersedia:
    - `startEngine()`   -> menyalakan mesin mobil
    - `stopEngine()`    -> mematikan mesin mobil


4. Output
    Class Person
        Hello Joko, my name is Eko Eko
        Hello Budi, my name is Eko Eko
        Hello Eko, my name is Joko nugroho
        Hello Budi, my name is Joko Nugroho
        Hello Eko, my name is Budi Nugraha
        Hello Joko, my name is Budi Nugraha
        Good Bye Joko, from Eko Eko. See you again!
        Good Bye Budi, from Eko Eko. See you again!
        Good Bye Eko, from Joko Nugroho. See you again!
        Godd Bye Budi, from Joko Nugroho. See you again!
        Good Bye Eko, from Budi Nugraha. See you again!
        Good Bye Joko, from Budi Nugraha. See you again!

    Class Car
        The Toyota Avanza engine is starting
        The Wuling Almaz engine is starting
        The Honda Mobilio engine is strating
        The Toyota Avanza engine is stopping
        The Wuling Almaz engine is stopping
        The Honda Mobilio engine is stopping
