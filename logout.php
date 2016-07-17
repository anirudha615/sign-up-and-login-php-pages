<?php

include 'session.php';

session_destroy();
$redirect = 'in.php';
header('Location: '.$redirect);


?>