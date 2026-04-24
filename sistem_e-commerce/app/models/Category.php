<?php
require_once __DIR__ . '/../../config/database.php';

class Category {

    private $db;

    public function __construct(){
        $this->db = Database::connect();
    }

    public function all(){
        return $this->db->query("SELECT * FROM categories")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id){
        $stmt = $this->db->prepare("SELECT * FROM categories WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($name){
        $stmt = $this->db->prepare("INSERT INTO categories(name) VALUES(?)");
        return $stmt->execute([$name]);
    }

    public function update($id,$name){
        $stmt = $this->db->prepare("UPDATE categories SET name=? WHERE id=?");
        return $stmt->execute([$name,$id]);
    }

    public function delete($id){
        return $this->db->prepare("DELETE FROM categories WHERE id=?")->execute([$id]);
    }
}