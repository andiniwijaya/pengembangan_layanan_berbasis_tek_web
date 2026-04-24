<?php
// dipanggil dari controller:
// $view = __DIR__ . '/../views/category/edit.php';
// require __DIR__ . '/../views/layout/main.php';
?>

<h3 class="mb-4 fw-bold">Edit Kategori</h3>

<form method="POST" class="card p-4">

    <label class="mb-2">Nama Kategori</label>

    <input 
        type="text" 
        name="name" 
        value="<?= $category['name'] ?>" 
        class="form-control mb-3"
        required
    >

    <div class="d-flex gap-2">
        <button class="btn btn-primary">
            Update
        </button>

        <a href="/?url=category/index" class="btn btn-secondary">
            Kembali
        </a>
    </div>

</form>