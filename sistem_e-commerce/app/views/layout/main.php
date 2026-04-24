<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>E-Commerce</title>

    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- custom css -->
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>

<div class="d-flex">

    <!-- sidebar -->
    <?php require __DIR__ . '/sidebar.php'; ?>

    <!-- content -->
    <div class="content w-100">

        <!-- header -->
        <?php require __DIR__ . '/header.php'; ?>

        <!-- page -->
        <div class="container mt-4">
            <?php require $view; ?>
        </div>

        <!-- footer -->
        <?php require __DIR__ . '/footer.php'; ?>

    </div>

</div>

<!-- loader -->
<div id="loader">
    <div class="spinner-border text-primary"></div>
</div>

<!-- bootstrap js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- custom js -->
<script src="/assets/js/script.js"></script>

</body>
</html>