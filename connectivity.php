<?php
error_reporting(E_ALL ^ E_DEPRECATED);
$host = "localhost";
$user = "root"; // retrieving info from database NICE :D
$pass = "";

mysql_connect($host,$user,$pass) || die ('Could not connect') ;
mysql_select_db('management') || die ('could not connect to the required database');


?>