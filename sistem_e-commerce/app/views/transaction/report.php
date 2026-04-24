<?php
// dipanggil dari controller:
// $view = __DIR__ . '/../views/transaction/report.php';
?>

<h3 class="mb-4 fw-bold">Laporan Transaksi</h3>

<div class="d-flex gap-2 mb-3">

    <form class="d-flex gap-2">
        <input type="date" name="from" class="form-control">
        <input type="date" name="to" class="form-control">
        <button class="btn btn-primary">Filter</button>
    </form>

    <a href="/?url=transaction/exportPDF" class="btn btn-danger">
        <i class="bi bi-file-earmark-pdf"></i> PDF
    </a>

</div>

<canvas id="chart" class="mb-4"></canvas>

<table class="table table-bordered bg-white">

<thead class="table-light">
<tr>
<th>ID</th>
<th>Tanggal</th>
<th>User</th>
<th>Total</th>
<th>Aksi</th>
</tr>
</thead>

<tbody>
<?php foreach($data as $d): ?>
<tr>
<td><?= $d['id'] ?></td>
<td><?= $d['transaction_date'] ?></td>
<td><?= $d['username'] ?></td>
<td><?= number_format($d['total']) ?></td>
<td>
<a href="/?url=transaction/detail&id=<?= $d['id'] ?>" 
   class="btn btn-info btn-sm">
   Detail
</a>
</td>
</tr>
<?php endforeach; ?>
</tbody>

</table>

<!-- chart -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const labels = <?= json_encode(array_keys($chart)) ?>;
const data = <?= json_encode(array_values($chart)) ?>;

new Chart(document.getElementById('chart'), {
    type: 'line',
    data: {
        labels: labels,
        datasets: [{
            label: 'Penjualan',
            data: data
        }]
    }
});
</script>