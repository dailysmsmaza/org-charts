<?php

 
 include("connect.php");

 $db_up = mysqli_query($c,"ALTER DATABASE dailysms_maza CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci");

 $tb_up = mysqli_query($c,"ALTER TABLE message CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");

 $col_up = mysqli_query($c,"ALTER TABLE message CHANGE sms sms VARCHAR(10000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
?>