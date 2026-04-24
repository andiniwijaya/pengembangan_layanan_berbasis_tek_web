<?php
class TransactionDetail {
    private $db;
    public function __construct($db){ $this->db=$db; }

    public function create($trx,$pid,$q,$p,$sub){
        $this->db->prepare("INSERT INTO transaction_details(transaction_id,product_id,quantity,price,subtotal) VALUES(?,?,?,?,?)")
                 ->execute([$trx,$pid,$q,$p,$sub]);
    }
}