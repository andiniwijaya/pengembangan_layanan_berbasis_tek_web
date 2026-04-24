<?php
// dipanggil dari controller:
// $view = __DIR__ . '/../views/dashboard/admin.php';
// require __DIR__ . '/../views/layout/main.php';
?>

<h3 class="mb-4 fw-bold">Dashboard Admin</h3>

<div class="row g-3">

    <div class="col-md-3">
        <div class="card p-3">
            <h6>Kategori</h6>
            <p class="text-muted small">Kelola kategori produk</p>
            <a href="/?url=category/index" class="btn btn-sm btn-primary">Lihat</a>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card p-3">
            <h6>Produk</h6>
            <p class="text-muted small">Kelola produk</p>
            <a href="/?url=product/index" class="btn btn-sm btn-primary">Lihat</a>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card p-3">
            <h6>Supplier</h6>
            <p class="text-muted small">Kelola supplier</p>
            <a href="/?url=supplier/index" class="btn btn-sm btn-primary">Lihat</a>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card p-3">
            <h6>Laporan</h6>
            <p class="text-muted small">Lihat laporan transaksi</p>
            <a href="/?url=transaction/report" class="btn btn-sm btn-primary">Lihat</a>
        </div>
    </div>

</div>