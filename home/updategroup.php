<?php 

        session_start();
        if($_SESSION['authuser']!=1)
       
                 header("Location:../index.php");
                 
            include('../lib/connectionfile.php');  
             
             //echo $_POST['type'];    
           $sql1=dbconfn()->prepare("UPDATE w_groups set name='$_POST[name]' where groupid='$_POST[groupid]'");
           $sql2=dbconfn()->prepare("UPDATE w_groups set description='$_POST[description]' where groupid='$_POST[groupid]'");
           $sql3=dbconfn()->prepare("UPDATE w_groups set type='$_POST[type]' where groupid='$_POST[groupid]'");
           $sql1->execute();
           $sql2->execute();
           $sql3->execute();
           header("Location:editgroups.php");
      ?>
