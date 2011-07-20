<?php 

        session_start();
        if($_SESSION['authuser']!=1)
                header("Location:../index.php");
     
     
        include('../lib/connectionfile.php');
        $sql=dbconfn()->prepare("SELECT * from w_groups where groupid='$_POST[groupid]'");
        $sql->execute();
        
        $rmgp=$sql->fetch();
        

     
        	$sql2=dbconfn()->prepare("DELETE from w_membership where groupid='$_POST[groupid]' and username='$_SESSION[username]' and status='A'");
        	$sql2->execute();	
                header("Location:editgroups.php");    
     
      ?>  


