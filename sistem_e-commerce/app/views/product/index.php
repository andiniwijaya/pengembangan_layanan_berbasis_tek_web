<?php
// dipanggil dari controller:
// $view = __DIR__ . '/../views/product/index.php';
// require __DIR__ . '/../views/layout/main.php';
?>

<h3 class="mb-4 fw-bold">Produk</h3>

<div class="d-flex justify-content-between mb-3">

    <a href="/?url=product/create" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Tambah Produk
    </a>

    <input type="text" id="search" class="form-control w-25" placeholder="Cari produk...">

</div>

<table class="table table-bordered bg-white align-middle">

    <thead class="table-light">
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Kategori</th>
            <th>Supplier</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody>
        <?php $no=1; foreach($data as $d): ?>
        <tr class="product-row">
            <td><?= $no++ ?></td>
            <td><?= $d['name'] ?></td>
            <td><?= number_format($d['price']) ?></td>
            <td><?= $d['stock'] ?></td>
            <td><?= $d['category'] ?></td>
            <td><?= $d['supplier'] ?></td>
            <td>

                <a href="/?url=product/edit&id=<?= $d['id'] ?>" 
                   class="btn btn-warning btn-sm">Edit</a>

                <a href="/?url=product/delete&id=<?= $d['id'] ?>" 
                   class="btn btn-danger btn-sm"
                   onclick="return confirm('Yakin hapus?')">Hapus</a>

            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>

</table>

<?php if(isset($_GET['success'])): ?>
<script>showToast("Data berhasil disimpan")</script>
<?php endif; ?>