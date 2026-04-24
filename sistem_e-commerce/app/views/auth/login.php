<?php
// view ini dipanggil dari controller pakai:
// require_once __DIR__ . '/../views/auth/login.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>

    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- custom css -->
    <link rel="stylesheet" href="/assets/style.css">
</head>

<body class="login-bg d-flex justify-content-center align-items-center" style="min-height:100vh;">

    <form method="POST" class="card p-4 shadow" style="width:360px;">

        <h4 class="mb-3 text-center fw-bold">Login</h4>

        <!-- error -->
        <?php if(isset($error)): ?>
            <div class="alert alert-danger">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <!-- username -->
        <input 
            type="text" 
            name="username" 
            class="form-control mb-3" 
            placeholder="Username" 
            required
        >

        <!-- password -->
        <input 
            type="password" 
            name="password" 
            class="form-control mb-3" 
            placeholder="Password" 
            required
        >

        <!-- button -->
        <button class="btn btn-primary w-100">
            Login
        </button>

    </form>

</body>
</html>