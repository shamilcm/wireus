<?php
     
     
       session_start();
       $_SESSION['authuser']==0;
       session_unset();
       header('Location:index.php');

?>
