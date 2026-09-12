<?php
require_once __DIR__ . '/config/functions.php';
logout_user();
redirect('login.php');
?>