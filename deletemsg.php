<?php

/*send message to different users
  two  variables are posted
  1) sender and 2) recipent
  */
          session_start();
        if($_SESSION['authuser']!=1)
                header("Location:index.php");
            
        include('lib/connectionfile.php');
        
        $msgid=$_POST['msgid'];
        $returnuser=$_POST['returnuser'];  // returs
        if($msgid)
        {
                $count1=dbconfn()->prepare("DELETE FROM w_msgs WHERE msgid='$msgid'");
                $count1->execute();
                header("Location:profile?id=$returnuser&pid=msgs");
        }

       else
        {
                header("Location:home");
        }
?>
