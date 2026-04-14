<?php
session_start();
session_destroy();
setcookie('session_user', '', time() - 3600, '/');
setcookie('user_balance', '', time() - 3600, '/');
header('Location: login.php');
exit;
?>