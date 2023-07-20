<?php
session_start();
if(isset($_SESSION['logged_in'])){
    if($_SESSION['logged_in']){
        header('Location: '.'index.php');
    }
}
