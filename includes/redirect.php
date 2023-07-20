<?php
session_start();
if(!isset($_SESSION['logged_in'])){
    $_SESSION['logged_in'] = false;
    header('Location: '.'login.php');
    exit;
}
if(!$_SESSION['logged_in']){
    header('Location: '.'login.php');
}
