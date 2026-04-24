<?php
require_once __DIR__ . '/../../config/database.php';

class Supplier {

    private $db;

    public function __construct(){
        $this->db = Database::connect();
    }

    public function all(){
        return $this->db->query("SELECT * FROM suppliers")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id){
        $stmt = $this->db->prepare("SELECT * FROM suppliers WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data){
        $stmt = $this->db->prepare("INSERT INTO suppliers(name,phone,address) VALUES(?,?,?)");
        return $stmt->execute([$data['name'],$data['phone'],$data['address']]);
    }

    public function update($id,$data){
        $stmt = $this->db->prepare("UPDATE suppliers SET name=?,phone=?,address=? WHERE id=?");
        return $stmt->execute([$data['name'],$data['phone'],$data['address'],$id]);
    }

    public function delete($id){
        return $this->db->prepare("DELETE FROM suppliers WHERE id=?")->execute([$id]);
    }
}