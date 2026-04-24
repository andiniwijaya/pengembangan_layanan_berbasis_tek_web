<?php
// dipanggil dari controller:
// $view = __DIR__ . '/../views/transaction/detail.php';
?>

<h3 class="mb-4 fw-bold">Detail Transaksi</h3>

<table class="table table-bordered bg-white">

<thead class="table-light">
<tr>
<th>Produk</th>
<th>Harga</th>
<th>Qty</th>
<th>Subtotal</th>
</tr>
</thead>

<tbody>
<?php foreach($data as $d): ?>
<tr>
<td><?= $d['name'] ?></td>
<td><?= number_format($d['price']) ?></td>
<td><?= $d['quantity'] ?></td>
<td><?= number_format($d['subtotal']) ?></td>
</tr>
<?php endforeach; ?>
</tbody>

</table>

<a href="/?url=transaction/report" class="btn btn-secondary">
    Kembali
</a>