<?php
// dipanggil dari controller:
// $view = __DIR__ . '/../views/supplier/edit.php';
// require __DIR__ . '/../views/layout/main.php';
?>

<h3 class="mb-4 fw-bold">Edit Supplier</h3>

<form method="POST" class="card p-4">

    <label class="mb-2">Nama Supplier</label>
    <input 
        type="text" 
        name="name" 
        value="<?= $data['name'] ?>" 
        class="form-control mb-3"
        required
    >

    <label class="mb-2">No HP</label>
    <input 
        type="text" 
        name="phone" 
        value="<?= $data['phone'] ?>" 
        class="form-control mb-3"
    >

    <label class="mb-2">Alamat</label>
    <textarea 
        name="address" 
        class="form-control mb-3"
        rows="3"
    ><?= $data['address'] ?></textarea>

    <div class="d-flex gap-2">
        <button class="btn btn-primary">Update</button>
        <a href="/?url=supplier/index" class="btn btn-secondary">Kembali</a>
    </div>

</form>