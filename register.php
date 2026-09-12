<?php
require_once __DIR__ . '/config/functions.php';
if(is_logged_in()) redirect('dashboard.php');
$old=['name'=>'','email'=>'']; $errors=[];
if($_SERVER['REQUEST_METHOD']==='POST'){
    $name=trim($_POST['name']??''); $email=strtolower(trim($_POST['email']??''));
    $password=$_POST['password']??''; $confirm=$_POST['confirm_password']??'';
    $old=['name'=>$name,'email'=>$email];
    if($name==='' || mb_strlen($name)<3) $errors[]='Nama minimal 3 karakter.';
    if($email==='' || !filter_var($email,FILTER_VALIDATE_EMAIL)) $errors[]='Masukkan email yang valid.';
    if(strlen($password)<8) $errors[]='Password minimal 8 karakter.';
    if($password!==$confirm) $errors[]='Konfirmasi password tidak sama.';
    $users=read_users();
    foreach($users as $u) if(strtolower($u['email'])===$email){$errors[]='Email tersebut sudah terdaftar.';break;}
    if(!$errors){
        $users[]=['id'=>bin2hex(random_bytes(8)),'name'=>$name,'email'=>$email,
        'password'=>password_hash($password,PASSWORD_DEFAULT),'created_at'=>date('Y-m-d H:i:s')];
        if(save_users($users)){set_flash('success','Registrasi berhasil! Silakan login.');redirect('login.php');}
        $errors[]='Data gagal disimpan. Pastikan users.json dapat ditulis.';
    }
}
?>
<!doctype html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Register — Authly</title><link rel="stylesheet" href="assets/css/style.css"></head><body class="auth-page">
<main class="auth-layout"><aside class="showcase"><a class="brand white" href="index.php"><b>A</b> Authly</a>
<div><span class="eyebrow">CREATE ACCOUNT</span><h1>Buat akun baru dalam beberapa langkah.</h1><p>Password tidak disimpan sebagai teks biasa.</p></div><small>Secure by design • PHP Native</small></aside>
<section class="panel"><div class="form-card"><a class="brand mobile" href="index.php"><b>A</b> Authly</a>
<span class="eyebrow">REGISTER</span><h2>Buat akun baru ✨</h2><p class="muted">Lengkapi data di bawah.</p>
<?php if($errors): ?><div class="alert error"><strong>Periksa kembali:</strong><ul><?php foreach($errors as $x): ?><li><?=e($x)?></li><?php endforeach; ?></ul></div><?php endif; ?>
<form method="post"><label>Nama Lengkap<input type="text" name="name" value="<?=e($old['name'])?>" placeholder="Natalia Enjelina Sihotang" required></label>
<label>Email<input type="email" name="email" value="<?=e($old['email'])?>" placeholder="nama@email.com" required></label>
<label>Password<input type="password" name="password" placeholder="Minimal 8 karakter" required><small>Minimal 8 karakter.</small></label>
<label>Konfirmasi Password<input type="password" name="confirm_password" placeholder="Ulangi password" required></label>
<button class="btn primary full">Buat Akun →</button></form>
<p class="switch">Sudah punya akun? <a href="login.php">Login di sini</a></p><a class="back" href="index.php">← Kembali ke beranda</a>
</div></section></main></body></html>