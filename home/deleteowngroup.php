<?php 

        session_start();
        if($_SESSION['authuser']!=1)
       
                 header("Location:../index.php");
            
           //echo $_POST['delgpid'];
           include('../lib/connectionfile.php');
           $sql=dbconfn()->prepare("DELETE from w_groups where groupid='$_POST[delgpid]'");
           $sql->execute();
           $sql=dbconfn()->prepare("DELETE from w_membership where groupid='$_POST[delgpid]'");
           $sql->execute();
           header("Location:editgroups.php"); 
            
                
                
               
      ?>

