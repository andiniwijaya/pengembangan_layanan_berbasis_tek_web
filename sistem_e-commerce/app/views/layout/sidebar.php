<?php $url = $_GET['url'] ?? ''; ?>

<div class="sidebar text-white p-3">

    <h5 class="mb-4 fw-bold">E-Commerce</h5>

    <!-- dashboard -->
    <a href="/?url=dashboard/admin"
       class="nav-link text-white <?= str_contains($url,'dashboard') ? 'active' : '' ?>">
        <i class="bi bi-speedometer2 me-2"></i> Dashboard
    </a>

    <?php if($_SESSION['user']['role'] == 'admin'): ?>

        <a href="/?url=category/index" class="nav-link text-white">
            <i class="bi bi-tags me-2"></i> Kategori
        </a>

        <a href="/?url=product/index" class="nav-link text-white">
            <i class="bi bi-box-seam me-2"></i> Produk
        </a>

        <a href="/?url=supplier/index" class="nav-link text-white">
            <i class="bi bi-truck me-2"></i> Supplier
        </a>

        <a href="/?url=transaction/report" class="nav-link text-white">
            <i class="bi bi-bar-chart me-2"></i> Laporan
        </a>

    <?php else: ?>

        <a href="/?url=transaction/index" class="nav-link text-white">
            <i class="bi bi-cart me-2"></i> Transaksi
        </a>

    <?php endif; ?>

    <!-- logout -->
    <a href="/?url=auth/logout" class="nav-link text-danger mt-4">
        <i class="bi bi-box-arrow-right me-2"></i> Logout
    </a>

</div>