<?php
include 'connectivity.php';
include 'session.php';

 if (logger()){
     echo '<br><br>  <a href="logout.php">LOG OUT</a>';
     $query = "SELECT `firstname` FROM `verify` WHERE `id` = '".$_SESSION['user_id']."'";
             if($query_run = mysql_query($query)){
                 echo '<br><br>READ QUERY SUCCESS ';
                 while ($row = mysql_fetch_assoc($query_run)){
                         $firstname = $row['firstname'];
                 }
             }
             echo '<br><br>YOU ARE LOGGED IN, WELCOME  '.$firstname.'.';
             $query1 = "SELECT `image` FROM `image` WHERE `id` = '".$_SESSION['user_id']."'";
             if ($query_run1 = mysql_query($query1)){
                 echo '<br><br> READ QUERY SUCCESS';
                 echo "<table>";
                 while ($row1 = mysql_fetch_assoc($query_run1)){
                     echo "<tr>";
                     echo "<td>";?> <img src ="<?php echo $row['image']; ?>" height ="100" width = "100"> <?php echo "</td>";
                     echo "</tr>";
                 }
                 echo "</table>";
             }
 }
 
 ?>