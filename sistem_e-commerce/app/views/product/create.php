<?php
// dipanggil dari controller:
// $view = __DIR__ . '/../views/product/create.php';
// require __DIR__ . '/../views/layout/main.php';
?>

<h3 class="mb-4 fw-bold">Tambah Produk</h3>

<form method="POST" class="card p-4">

    <label class="mb-2">Nama Produk</label>
    <input name="name" class="form-control mb-3" required>

    <label class="mb-2">Harga</label>
    <input type="number" name="price" class="form-control mb-3" required>

    <label class="mb-2">Stok</label>
    <input type="number" name="stock" class="form-control mb-3" required>

    <label class="mb-2">Kategori</label>
    <select name="category_id" class="form-control mb-3" required>
        <?php foreach($categories as $c): ?>
            <option value="<?= $c['id'] ?>"><?= $c['name'] ?></option>
        <?php endforeach; ?>
    </select>

    <label class="mb-2">Supplier</label>
    <select name="supplier_id" class="form-control mb-3" required>
        <?php foreach($suppliers as $s): ?>
            <option value="<?= $s['id'] ?>"><?= $s['name'] ?></option>
        <?php endforeach; ?>
    </select>

    <div class="d-flex gap-2">
        <button class="btn btn-primary">Simpan</button>
        <a href="/?url=product/index" class="btn btn-secondary">Kembali</a>
    </div>

</form>