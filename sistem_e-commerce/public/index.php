<?php

session_start();

// base path (opsional tapi bagus)
define('BASE_URL', '/');

// load config & core
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../core/Router.php';

// jalankan router
Router::route();