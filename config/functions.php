<?php
declare(strict_types=1);
if(session_status()===PHP_SESSION_NONE) session_start();
define('USERS_FILE',__DIR__.'/../data/users.json');

function e(string $value):string{return htmlspecialchars($value,ENT_QUOTES,'UTF-8');}
function redirect(string $path):never{header('Location: '.$path);exit;}
function read_users():array{
    if(!file_exists(USERS_FILE))return [];
    $json=file_get_contents(USERS_FILE); if($json===false||trim($json)==='')return [];
    $users=json_decode($json,true); return is_array($users)?$users:[];
}
function save_users(array $users):bool{
    $json=json_encode($users,JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
    return $json!==false && file_put_contents(USERS_FILE,$json,LOCK_EX)!==false;
}
function find_user_by_id(string $id):?array{
    foreach(read_users() as $user) if(($user['id']??'')===$id)return $user;
    return null;
}
function is_logged_in():bool{return isset($_SESSION['user_id'])&&find_user_by_id((string)$_SESSION['user_id'])!==null;}
function current_user():?array{return isset($_SESSION['user_id'])?find_user_by_id((string)$_SESSION['user_id']):null;}
function require_login():void{if(!is_logged_in()){set_flash('error','Silakan login terlebih dahulu.');redirect('login.php');}}
function logout_user():void{
    $_SESSION=[];
    if(ini_get('session.use_cookies')){ $p=session_get_cookie_params(); setcookie(session_name(),'',
        time()-42000,$p['path'],$p['domain']??'',$p['secure'],$p['httponly']); }
    session_destroy(); setcookie('remember_email','',time()-3600,'/');
}
function set_flash(string $type,string $message):void{$_SESSION['flash'][$type]=$message;}
function get_flash(string $type):?string{$m=$_SESSION['flash'][$type]??null;unset($_SESSION['flash'][$type]);return $m;}
?>