<?php
ob_start();
session_start();
$current = $_SERVER['SCRIPT_NAME'];


function logger(){
if(isset($_SESSION['user_id'])&&!empty($_SESSION['user_id'])){
        return true;
    }else{
        return false;
    }
}


?>