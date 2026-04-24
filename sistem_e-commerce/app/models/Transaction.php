<?php
require_once __DIR__ . '/../../config/database.php';

class Transaction {

    private $db;

    public function __construct(){
        $this->db = Database::connect();
    }

    public function create($user_id,$total){
        $stmt = $this->db->prepare("INSERT INTO transactions(user_id,total) VALUES(?,?)");
        $stmt->execute([$user_id,$total]);
        return $this->db->lastInsertId();
    }

    public function addDetail($trx_id,$product_id,$qty,$price){
        $subtotal = $qty * $price;

        $stmt = $this->db->prepare("
            INSERT INTO transaction_details(transaction_id,product_id,quantity,price,subtotal)
            VALUES(?,?,?,?,?)
        ");

        return $stmt->execute([$trx_id,$product_id,$qty,$price,$subtotal]);
    }

    public function getAll($from = null, $to = null){

        $sql = "
            SELECT t.*, u.username 
            FROM transactions t
            LEFT JOIN users u ON t.user_id = u.id
        ";

        if($from && $to){
            $sql .= " WHERE DATE(t.transaction_date) BETWEEN ? AND ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$from,$to]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDetail($transaction_id){

        $stmt = $this->db->prepare("
            SELECT d.*, p.name 
            FROM transaction_details d
            JOIN products p ON d.product_id = p.id
            WHERE d.transaction_id=?
        ");

        $stmt->execute([$transaction_id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}