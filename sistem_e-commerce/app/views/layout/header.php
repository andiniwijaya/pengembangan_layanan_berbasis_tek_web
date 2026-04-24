<nav class="navbar shadow-sm px-4 d-flex justify-content-between">

    <span class="fw-bold">Dashboard</span>

    <div class="d-flex align-items-center gap-3">

        <span class="fw-semibold">
            <?= $_SESSION['user']['username'] ?>
        </span>

        <!-- toggle dark mode -->
        <button onclick="toggleTheme()" class="btn btn-dark btn-sm">
            🌙
        </button>

        <!-- logout -->
        <a href="/?url=auth/logout" class="btn btn-danger btn-sm">
            Logout
        </a>

    </div>

</nav>