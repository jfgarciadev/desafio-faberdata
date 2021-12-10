<?php

session_start();
//clear session

$_SESSION['user_id'] = null;
$_SESSION['username'] = null;
$_SESSION['loggedin'] = null;
unset($_SESSION);
session_unset();
session_destroy();

//redirect to login page
header("Location: /login");
