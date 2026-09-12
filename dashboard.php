<?php
require_once __DIR__ . '/config/functions.php'; require_login();
$user=current_user(); if(!$user){logout_user();redirect('login.php');}
$success=get_flash('success');
?>
<!doctype html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Dashboard — Authly</title><link rel="stylesheet" href="assets/css/style.css"></head><body>
<header class="topbar"><a class="brand" href="dashboard.php"><b>A</b> Authly</a><nav><a href="profile.php">Edit Profile</a><a class="logout" href="logout.php">Logout</a></nav></header>
<main class="dashboard"><section class="welcome"><div><span class="eyebrow">DASHBOARD</span><h1>Halo, <?=e($user['name'])?>! 👋</h1><p>Kamu berhasil login. Halaman ini diproteksi menggunakan PHP Session.</p></div>
<div class="avatar"><?=e(strtoupper(substr($user['name'],0,1)))?></div></section>
<?php if($success): ?><div class="alert success"><?=e($success)?></div><?php endif; ?>
<section class="info-grid">
<article><span>👤</span><small>Nama Lengkap</small><strong><?=e($user['name'])?></strong></article>
<article><span>✉️</span><small>Email</small><strong><?=e($user['email'])?></strong></article>
<article><span>🛡️</span><small>Status</small><strong>Authenticated</strong></article></section>
<section class="security"><div><span class="eyebrow">SECURITY</span><h2>Session kamu aktif</h2><p>Password diverifikasi dengan <code>password_verify()</code> dan disimpan sebagai hash melalui <code>password_hash()</code>.</p></div><a class="btn secondary" href="profile.php">Kelola Profil</a></section>
</main></body></html>