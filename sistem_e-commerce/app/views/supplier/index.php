<?php
// dipanggil dari controller:
// $view = __DIR__ . '/../views/supplier/index.php';
// require __DIR__ . '/../views/layout/main.php';
?>

<h3 class="mb-4 fw-bold">Supplier</h3>

<a href="/?url=supplier/create" class="btn btn-primary mb-3">
    <i class="bi bi-plus-lg"></i> Tambah Supplier
</a>

<table class="table table-bordered bg-white align-middle">

    <thead class="table-light">
        <tr>
            <th width="50">No</th>
            <th>Nama</th>
            <th>No HP</th>
            <th>Alamat</th>
            <th width="150">Aksi</th>
        </tr>
    </thead>

    <tbody>
        <?php $no=1; foreach($data as $d): ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $d['name'] ?></td>
            <td><?= $d['phone'] ?></td>
            <td><?= $d['address'] ?></td>
            <td>

                <a href="/?url=supplier/edit&id=<?= $d['id'] ?>" 
                   class="btn btn-warning btn-sm">
                   Edit
                </a>

                <a href="/?url=supplier/delete&id=<?= $d['id'] ?>" 
                   class="btn btn-danger btn-sm"
                   onclick="return confirm('Yakin hapus data?')">
                   Hapus
                </a>

            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>

</table>

<?php if(isset($_GET['success'])): ?>
<script>showToast("Data berhasil disimpan")</script>
<?php endif; ?>