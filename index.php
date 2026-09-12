<?php
require_once __DIR__ . '/config/functions.php';
if (is_logged_in()) redirect('dashboard.php');
?>
<!doctype html><html lang="id"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Authly — PHP Native Authentication</title><link rel="stylesheet" href="assets/css/style.css"></head>
<body class="landing"><main class="landing-card">
<a class="brand" href="index.php"><b>A</b> Authly</a>
<span class="eyebrow">PHP NATIVE AUTHENTICATION</span>
<h1>Simple, clean, and secure <em>login system.</em></h1>
<p>Sistem Login/Register dengan PHP Native, session, validasi form, password hashing, dan penyimpanan JSON.</p>
<div class="actions"><a class="btn primary" href="login.php">Masuk ke Authly</a><a class="btn secondary" href="register.php">Buat Akun</a></div>
<div class="features"><span>🔐 Password Hash</span><span>✓ Form Validation</span><span>◈ JSON Storage</span></div>
</main></body></html>