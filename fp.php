<?php

include 'session.php';
include 'connectivity.php';
if (isset($_POST['username']) && isset($_POST['email'])){
    $user = $_POST['username'];
    $email = $_POST['email'];
    if(!empty($user) && !empty($email)){
        $query = "SELECT `username`, `email` FROM `verify` WHERE `username` = '".mysql_real_escape_string($user)."' AND `email` = '".mysql_real_escape_string($email)."'";
        if ($query_run2 = mysql_query($query)){
            echo ' <br><br>READ QUERY SUCCESS';
            if (mysql_num_rows($query_run2)==NULL){
                echo  '<br>No results found';
            }else{
                while ($row = mysql_fetch_assoc($query_run2)){
                    $pass = $row['password'];
                }
                $to = $email;
                $sub = 'PASSWORD RECOVERY';
                $body = 'Good Morning ! <br> Your Username is :'.$user.'<br> Your Password is :'.$pass.'<br>THANK YOU.';
                mail($to,$sub,$body,$header);
            }
        }else{
            echo ' <br><br>READ QUERY FAILED';
        }
    }else{
        echo '<br><br>FIELDS ARE COMPULSORY';
    }
}









?>

<form action = "<?php echo $current; ?>" method = "POST" enctype = "multipart/form-data">
USERNAME : <input type = "text" name = "username"><br><br>
EMAIL ID : <input type = "text" name = "email"><br><br>
<input type = "submit"  value = "SEND REQUEST"><br><br>
</form>