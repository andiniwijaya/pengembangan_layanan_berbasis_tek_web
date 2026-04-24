<?php
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Transaction.php';
require_once __DIR__ . '/../../core/helpers.php';

class TransactionController {

    private function auth(){
        if(!isset($_SESSION['user'])){
            header("Location: /?url=auth/login");
            exit;
        }
    }

    public function index(){
        $this->auth();

        $products = (new Product())->all();

        $view = __DIR__ . '/../views/transaction/index.php';
        require __DIR__ . '/../views/layout/main.php';
    }

    public function store(){
        $this->auth();

        $productModel = new Product();
        $trxModel = new Transaction();

        $total = 0;

        foreach($_POST['qty'] as $id=>$qty){
            if($qty > 0){

                $product = $productModel->find($id);

                if($qty > $product['stock']){
                    die("Stok tidak cukup untuk ".$product['name']);
                }

                $total += $product['price'] * $qty;
            }
        }

        $trx_id = $trxModel->create($_SESSION['user']['id'],$total);

        foreach($_POST['qty'] as $id=>$qty){
            if($qty > 0){

                $product = $productModel->find($id);

                $trxModel->addDetail($trx_id,$id,$qty,$product['price']);
                $productModel->reduceStock($id,$qty);
            }
        }

        header("Location: /?url=transaction/index&success=1");
    }

    public function report(){
        $this->auth();

        $model = new Transaction();

        $from = $_GET['from'] ?? null;
        $to   = $_GET['to'] ?? null;

        $data = $model->getAll($from,$to);

        $chart = [];
        foreach($data as $d){
            $date = date('Y-m-d', strtotime($d['transaction_date']));
            $chart[$date] = ($chart[$date] ?? 0) + $d['total'];
        }

        $view = __DIR__ . '/../views/transaction/report.php';
        require __DIR__ . '/../views/layout/main.php';
    }

    public function detail(){
        $this->auth();

        $data = (new Transaction())->getDetail($_GET['id']);

        $view = __DIR__ . '/../views/transaction/detail.php';
        require __DIR__ . '/../views/layout/main.php';
    }

    public function exportPDF(){
        $this->auth();

        require_once __DIR__ . '/../../vendor/dompdf/autoload.inc.php';

        $model = new Transaction();
        $data = $model->getAll();

        ob_start();
        require __DIR__ . '/../views/transaction/pdf.php';
        $html = ob_get_clean();

        $dompdf = new Dompdf\Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->render();

        $dompdf->stream("laporan.pdf", ["Attachment"=>false]);
    }
}