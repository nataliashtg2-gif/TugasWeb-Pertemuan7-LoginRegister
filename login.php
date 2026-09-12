<?php
require_once __DIR__ . '/config/functions.php';
if (is_logged_in()) redirect('dashboard.php');
$email=''; $error=get_flash('error'); $success=get_flash('success');
if ($_SERVER['REQUEST_METHOD']==='POST') {
    $email=strtolower(trim($_POST['email'] ?? '')); $password=$_POST['password'] ?? '';
    $remember=isset($_POST['remember']);
    if ($email==='' || $password==='') $error='Email dan password wajib diisi.';
    elseif (!filter_var($email,FILTER_VALIDATE_EMAIL)) $error='Format email tidak valid.';
    else {
        $found=null;
        foreach(read_users() as $user) if(strtolower($user['email'])===$email){$found=$user;break;}
        if($found && password_verify($password,$found['password'])){
            session_regenerate_id(true); $_SESSION['user_id']=$found['id'];
            if($remember) setcookie('remember_email',$found['email'],[
                'expires'=>time()+2592000,'path'=>'/','secure'=>!empty($_SERVER['HTTPS']),
                'httponly'=>true,'samesite'=>'Lax'
            ]); else setcookie('remember_email','',time()-3600,'/');
            redirect('dashboard.php');
        }
        $error='Email atau password salah.';
    }
}
if($email==='' && !empty($_COOKIE['remember_email'])) $email=$_COOKIE['remember_email'];
?>
<!doctype html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Login — Authly</title><link rel="stylesheet" href="assets/css/style.css"></head><body class="auth-page">
<main class="auth-layout"><aside class="showcase"><a class="brand white" href="index.php"><b>A</b> Authly</a>
<div><span class="eyebrow">WELCOME BACK</span><h1>Masuk dan lanjutkan perjalananmu.</h1><p>Authentication sederhana untuk project PHP Native.</p></div>
<small>Tugas Rutin 7 • Pemrograman Web</small></aside>
<section class="panel"><div class="form-card"><a class="brand mobile" href="index.php"><b>A</b> Authly</a>
<span class="eyebrow">LOGIN</span><h2>Selamat datang kembali 👋</h2><p class="muted">Masukkan akunmu untuk membuka dashboard.</p>
<?php if($error): ?><div class="alert error"><?=e($error)?></div><?php endif; ?>
<?php if($success): ?><div class="alert success"><?=e($success)?></div><?php endif; ?>
<form method="post"><label>Email<input type="email" name="email" value="<?=e($email)?>" placeholder="nama@email.com" required></label>
<label>Password<input type="password" name="password" placeholder="Masukkan password" required></label>
<label class="check"><input type="checkbox" name="remember" <?=isset($_COOKIE['remember_email'])?'checked':''?>> Remember Me <small>(ingat email)</small></label>
<button class="btn primary full">Masuk ke Dashboard →</button></form>
<p class="switch">Belum punya akun? <a href="register.php">Daftar sekarang</a></p><a class="back" href="index.php">← Kembali ke beranda</a>
</div></section></main></body></html>