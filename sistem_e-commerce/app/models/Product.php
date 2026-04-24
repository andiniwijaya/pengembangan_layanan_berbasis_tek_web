<?php
require_once __DIR__ . '/../../config/database.php';

class Product {

    private $db;

    public function __construct(){
        $this->db = Database::connect();
    }

    public function all(){
        return $this->db->query("
            SELECT p.*, c.name as category, s.name as supplier
            FROM products p
            LEFT JOIN categories c ON p.category_id=c.id
            LEFT JOIN suppliers s ON p.supplier_id=s.id
        ")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCategories(){
        return $this->db->query("SELECT * FROM categories")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSuppliers(){
        return $this->db->query("SELECT * FROM suppliers")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id){
        $stmt = $this->db->prepare("SELECT * FROM products WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($d){
        $stmt = $this->db->prepare("
            INSERT INTO products(name,price,stock,category_id,supplier_id)
            VALUES(?,?,?,?,?)
        ");
        return $stmt->execute([
            $d['name'],$d['price'],$d['stock'],$d['category_id'],$d['supplier_id']
        ]);
    }

    public function update($id,$d){
        $stmt = $this->db->prepare("
            UPDATE products 
            SET name=?,price=?,stock=?,category_id=?,supplier_id=? 
            WHERE id=?
        ");
        return $stmt->execute([
            $d['name'],$d['price'],$d['stock'],$d['category_id'],$d['supplier_id'],$id
        ]);
    }

    public function delete($id){
        return $this->db->prepare("DELETE FROM products WHERE id=?")->execute([$id]);
    }

    public function reduceStock($id,$qty){
        $stmt = $this->db->prepare("UPDATE products SET stock = stock - ? WHERE id=?");
        return $stmt->execute([$qty,$id]);
    }
}