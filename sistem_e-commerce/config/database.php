<?php

class Database {

    public static function connect(){

        $host = "localhost";
        $dbname = "e_commerce";
        $user = "root";
        $pass = "";

        try {

            return new PDO(
                "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
                $user,
                $pass,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                ]
            );

        } catch (PDOException $e) {
            die("Koneksi database gagal");
        }
    }
}