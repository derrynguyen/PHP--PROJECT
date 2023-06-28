<?php
require_once './Class/Database.php';

require_once './Class/User.php';
$user = new User();

$user->logout();

session_start();
session_unset();
session_destroy();
exit();