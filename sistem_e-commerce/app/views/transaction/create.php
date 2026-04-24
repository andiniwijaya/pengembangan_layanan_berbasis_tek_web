<?php

require_once __DIR__ . '/../../../config/database.php';

$db = (new Database())->connect();
$products = $db->query("SELECT * FROM products");
?>

<!DOCTYPE html>
<html>
<head>

    <title>Tambah Transaksi</title>

    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- css custom -->
    <link rel="stylesheet" href="/ecommerce/public/css/style.css">

</head>

<body>

<div class="container mt-4">

    <h3>Tambah Transaksi</h3>

    <form method="POST" action="/ecommerce/app/controllers/TransactionController.php">

        <!-- container item -->
        <div id="items">

            <div class="row mb-2">
                <div class="col">
                    <select name="product_id[]" class="form-control product-select" onchange="setPrice(this)">
                        <?php foreach ($products as $p): ?>
                            <option value="<?= $p['id'] ?>" data-price="<?= $p['price'] ?>">
                                <?= $p['name'] ?> - <?= $p['price'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col">
                    <input type="number" name="qty[]" class="form-control qty" onkeyup="calculateTotal()" placeholder="Qty">
                </div>

                <div class="col">
                    <input type="text" class="form-control price" readonly>
                </div>
            </div>

        </div>

<h4>Total: <span id="total">0</span></h4>

        <!-- template hidden untuk JS -->
        <div id="item-template" style="display:none;">
            <div class="row mb-2">
                <div class="col">
                    <select name="product_id[]" class="form-control">
                        <?php foreach ($products as $p): ?>
                            <option value="<?= $p['id'] ?>">
                                <?= $p['name'] ?> - <?= $p['price'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col">
                    <input type="number" name="qty[]" class="form-control" placeholder="Qty">
                </div>
            </div>
        </div>

        <button type="button" onclick="addItem()" class="btn btn-secondary mb-3">
            Tambah Barang
        </button>

        <br>

        <button class="btn btn-primary">Simpan Transaksi</button>

    </form>

</div>

<!-- js external -->
<script src="/ecommerce/public/js/script.js"></script>

</body>
</html>