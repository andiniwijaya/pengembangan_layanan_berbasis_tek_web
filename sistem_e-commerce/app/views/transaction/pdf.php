<h2>Laporan Transaksi</h2>

<table border="1" width="100%" cellpadding="5" cellspacing="0">

<tr>
<th>ID</th>
<th>Tanggal</th>
<th>User</th>
<th>Total</th>
</tr>

<?php foreach($data as $d): ?>
<tr>
<td><?= $d['id'] ?></td>
<td><?= $d['transaction_date'] ?></td>
<td><?= $d['username'] ?></td>
<td><?= $d['total'] ?></td>
</tr>
<?php endforeach; ?>

</table>