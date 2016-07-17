

<?php


include 'session.php';
include 'connectivity.php';


if (isset($_POST['username'])&&isset($_POST['password'])){
    $username = strtoupper($_POST['username']);
    $password = ($_POST['password']);
    $password_h = md5($password);
    if(!empty($username) &&!empty($password)){
        $query2 = "SELECT `id`,`username`,`password` FROM `verify` WHERE `password`='".mysql_real_escape_string($password_h)."'AND `username` = '".mysql_real_escape_string($username)."'";
           
        if ($query_run2 = mysql_query($query2)){
            echo ' <br><br>READ QUERY SUCCESS';
            if (mysql_num_rows($query_run2)==NULL){
                echo  '<br>No results found';
            }else{
                while ($row = mysql_fetch_assoc($query_run2)){
                    $user = $row['username'];
                    $pass = $row['password'];
                    $id = $row['id'];
                    $_SESSION['user_id']=$id;
                }
                if ($user = $username && $pass = $password_h){
                    echo "<br><br>YOU ARE Successfully LOGGED IN";
                    $redirect = 'service.php';
                    header('Location: '.$redirect); 

                }
            }
        }else{
                echo "READ QUERY FAILED";
            }
        
    }else{
        echo "ALL FIELDS ARE COMPULSORY";
    }
}


?>

<form action = "<?php echo $current; ?>" method = "POST" enctype = "multipart/form-data">
USERNAME : <input type = "text" name = "username"><br><br>
PASSWORD : <input type = "password" name = "password"><br><br>
<input type = "submit" name = "in" value = "LOGIN"><br><br>
</form>

<?php 

if ( isset($_GET['up']) || isset($_GET['fp'])){
    
     if (!empty($_GET['up'])){
        $redirect = 'up.php';
        header('Location: '.$redirect);
    }elseif (!empty($_GET['fp'])){
        $redirect = 'fp.php';
        header('Location: '.$redirect);
    }
}

?>
<form action = "<?php echo $current; ?>" method = "GET" >
 
 <input type = "submit" name = "fp" value = "FORGOT PASSWORD">  <input type = "submit" name = "up" value = "SIGN UP HERE">
</form>
