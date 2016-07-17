

<?php
 
include 'connectivity.php';
include 'session.php';

function upload() {
    $maxsize = 10000000; 
    
        if($_FILES['file']['error']==UPLOAD_ERR_OK) {

        
        if(is_uploaded_file($_FILES['file']['tmp_name'])) {    


            if( $_FILES['file']['size'] < $maxsize) {  
  
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                if(strpos(finfo_file($finfo, $_FILES['file']['tmp_name']),"image")===0) {    

                    
                    $imgData =addslashes (file_get_contents($_FILES['file']['tmp_name']));

                    

                   
                    $sql = "INSERT INTO `image`(`image`,`name`) VALUES('".($imgData)."','".($_FILES['file']['name'])."')";
                    
                    

                   
                    mysql_query($sql) or die("Error in Query: " . mysql_error());
                    $msg='<p>Image successfully saved in database  </p>';
                }
                else
                    $msg="<p>Uploaded file is not an image.</p>";
            }
             else {
                
                $msg='<div>File exceeds the Maximum File limit</div>
                <div>Maximum File limit is '.$maxsize.' bytes</div>
                <div>File '.$_FILES['file']['name'].' is '.$_FILES['file']['size'].
                ' bytes</div><hr />';
                }
        }
        else $msg="File not uploaded successfully.";

    }else {
        $msg= file_upload_error_message($_FILES['file']['error']);
    }
    return $msg;
}




function file_upload_error_message($error_code) {
    switch ($error_code) {
        case UPLOAD_ERR_INI_SIZE:
            return 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
        case UPLOAD_ERR_FORM_SIZE:
            return 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
        case UPLOAD_ERR_PARTIAL:
            return 'The uploaded file was only partially uploaded';
        case UPLOAD_ERR_NO_FILE:
            return 'No file was uploaded';
        case UPLOAD_ERR_NO_TMP_DIR:
            return 'Missing a temporary folder';
        case UPLOAD_ERR_CANT_WRITE:
            return 'Failed to write file to disk';
        case UPLOAD_ERR_EXTENSION:
            return 'File upload stopped by extension';
        default:
            return 'Unknown upload error';
    }
}





if (isset($_POST['username'])&&isset($_POST['password']) &&isset($_POST['pass'])&&isset($_POST['first']) &&isset($_POST['last']) &&isset($_POST['dob']) &&isset($_POST['email']) &&isset($_POST['phone']) ){
    $username = strtoupper($_POST['username']);
    $password = $_POST['password'];
    $password_hash = md5($password);
    $pass = $_POST['pass'];
    $pass_hash = md5($pass);
    $first = strtoupper($_POST['first']);
    $last = strtoupper($_POST['last']);
    $email = strtoupper($_POST['email']);
    $phone = $_POST['phone'];
    $dob = strtoupper($_POST['dob']);
    if(!empty($username) &&!empty($password_hash) &&!empty($first)&&!empty($last) &&!empty($pass_hash) &&!empty($email) &&!empty($dob) &&!empty($phone)){
        if($password_hash == $pass_hash){
            $query = "SELECT `username` FROM `verify` WHERE `username` = '".mysql_real_escape_string($username)."'";
            if ($query_run = mysql_query($query)){
                if(mysql_num_rows($query_run)!=NULL){
                    echo '<br><br>The Username '.mysql_real_escape_string($username).' already exists';
                }else{
                    $ip = $_SERVER['REMOTE_ADDR'];
                    $query1 = "INSERT INTO `verify`( `username`, `password`, `firstname`, `lastname`, `dob`, `email`, `phone`, `ip`) VALUES('".mysql_real_escape_string($username)."','".mysql_real_escape_string($password_hash)."','".mysql_real_escape_string($first)."','".mysql_real_escape_string($last)."','".mysql_real_escape_string($dob)."','".mysql_real_escape_string($email)."','".mysql_real_escape_string($phone)."','".mysql_real_escape_string($ip)."')";
                    if ($query_run1 = mysql_query($query1)){
                        
                        if (isset($_FILES['file'])) {
                                
                                   try {
                                    $msg= upload(); 
                                    echo $msg;  
                                    }
                                    catch(Exception $e) {
                                    echo $e->getMessage();
                                    echo 'Sorry, could not upload file';
                                    }
                                    }else{
                                      echo '<br><br>Please select a File .';
                                    }
                                       echo "<br><br> Thank You for registration";
                                       require 'class-Clockwork.php';
                                       $apikey = "5ad3a0bf9805fe7d332d44cc4f9e8a82043f103a";
                                       $clockwork = new Clockwork($apikey);
                                       $message = array('to' => '91'.$phone, 'message' => 'Your Account is verified. Thank You !!');
                                       $done = $clockwork->send($message);
                         
            
                        }else{
                                echo mysql_error();
                                echo ' <br><br>INSERT QUERY FAILED';
                        } 
                
                }
            }else{
                echo '<br><br>Read Query Failed';
            }
        }else{
                echo '<br><br>PASSWORDS DONOT MATCH';
            }
        }else{
        echo "<br><br>PLEASE FILL ALL THE FIELDS";
    }
}





?>

<form action = "<?php echo $current; ?>" method = "POST" enctype = "multipart/form-data">
USERNAME : <input type = "text" name = "username"><br><br>
PASSWORD : <input type = "password" name = "password"><br><br>
RE ENTER THE PASSWORD: <input type = "password" name = "pass"><br><br>
FIRSTNAME : <input type = "text" name = "first"><br><br>
LASTNAME : <input type = "text" name = "last"><br><br>
UPLOAD YOUR PIC :<input type = "file" name = "file"><br><br>
<input type="hidden" name="MAX_FILE_SIZE" value="10000000" >
DATE OF BIRTH : <input type = "date" name = "dob"><br><br>
EMAIL ID : <input type = "text" name = "email"><br><br>
PHONE NUMBER : <input type = "text" name = "phone"><br><br>
<input type ="submit" value = "APPLY">
</form>
