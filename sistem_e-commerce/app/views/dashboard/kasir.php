<?php
// dipanggil dari controller:
// $view = __DIR__ . '/../views/dashboard/kasir.php';
// require __DIR__ . '/../views/layout/main.php';
?>

<h3 class="mb-4 fw-bold">Dashboard Kasir</h3>

<div class="row g-3">

    <div class="col-md-4">
        <div class="card p-3">
            <h6>Transaksi</h6>
            <p class="text-muted small">Buat transaksi baru</p>
            <a href="/?url=transaction/index" class="btn btn-sm btn-primary">Mulai</a>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card p-3">
            <h6>Produk</h6>
            <p class="text-muted small">Lihat daftar produk</p>
            <a href="/?url=product/index" class="btn btn-sm btn-primary">Lihat</a>
        </div>
    </div>

</div>