<?php
require_once __DIR__ . '/config/functions.php'; require_login();
$user=current_user(); if(!$user){logout_user();redirect('login.php');}
$errors=[]; $success=get_flash('success');
if($_SERVER['REQUEST_METHOD']==='POST'){
    $name=trim($_POST['name']??''); $email=strtolower(trim($_POST['email']??''));
    if($name===''||mb_strlen($name)<3)$errors[]='Nama minimal 3 karakter.';
    if($email===''||!filter_var($email,FILTER_VALIDATE_EMAIL))$errors[]='Masukkan email yang valid.';
    $users=read_users();
    foreach($users as $other) if($other['id']!==$user['id']&&strtolower($other['email'])===$email){$errors[]='Email tersebut sudah digunakan akun lain.';break;}
    if(!$errors){
        foreach($users as &$item) if($item['id']===$user['id']){$item['name']=$name;$item['email']=$email;break;}
        unset($item);
        if(save_users($users)){set_flash('success','Profil berhasil diperbarui.');redirect('profile.php');}
        $errors[]='Profil gagal disimpan.';
    }
    $user['name']=$name;$user['email']=$email;
}
?>
<!doctype html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Edit Profile — Authly</title><link rel="stylesheet" href="assets/css/style.css"></head><body>
<header class="topbar"><a class="brand" href="dashboard.php"><b>A</b> Authly</a><nav><a href="dashboard.php">Dashboard</a><a class="logout" href="logout.php">Logout</a></nav></header>
<main class="profile"><div class="heading"><span class="eyebrow">PROFILE</span><h1>Edit Profile</h1><p>Perbarui nama dan email akunmu.</p></div>
<section class="profile-card"><?php if($success): ?><div class="alert success"><?=e($success)?></div><?php endif; ?>
<?php if($errors): ?><div class="alert error"><ul><?php foreach($errors as $x): ?><li><?=e($x)?></li><?php endforeach; ?></ul></div><?php endif; ?>
<form method="post"><label>Nama Lengkap<input type="text" name="name" value="<?=e($user['name'])?>" required></label>
<label>Email<input type="email" name="email" value="<?=e($user['email'])?>" required></label>
<div class="form-actions"><a class="btn secondary" href="dashboard.php">Batal</a><button class="btn primary">Simpan Perubahan</button></div></form></section></main></body></html>