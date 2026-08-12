<?php
session_start();

$_SESSION['admin_logged_in'] = true;
$_SESSION['admin_id'] = 1;
$_SESSION['admin_email'] = 'admin@gmail.com';
$_SESSION['admin_name'] = 'Administrator';

return true;
?>