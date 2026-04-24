<?php
// dipanggil dari controller:
// $view = __DIR__ . '/../views/transaction/index.php';
// require __DIR__ . '/../views/layout/main.php';
?>

<h3 class="mb-4 fw-bold">Transaksi</h3>

<form method="POST" action="/?url=transaction/store">

<table class="table table-bordered bg-white align-middle">

    <thead class="table-light">
        <tr>
            <th>Produk</th>
            <th>Harga</th>
            <th width="120">Qty</th>
            <th>Subtotal</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach($products as $p): ?>
        <tr>
            <td><?= $p['name'] ?></td>

            <td class="price"><?= $p['price'] ?></td>

            <td>
                <input type="number" 
                       name="qty[<?= $p['id'] ?>]" 
                       class="form-control qty" 
                       value="0" min="0">
            </td>

            <td class="subtotal">0</td>
        </tr>
        <?php endforeach; ?>
    </tbody>

</table>

<div class="d-flex justify-content-between align-items-center">

    <h4>Total: <span id="total">0</span></h4>

    <button class="btn btn-primary">
        <i class="bi bi-save"></i> Simpan Transaksi
    </button>

</div>

</form>

<?php if(isset($_GET['success'])): ?>
<script>showToast("Transaksi berhasil")</script>
<?php endif; ?>