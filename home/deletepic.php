<?php 

        session_start();
        if($_SESSION['authuser']!=1)
                header("Location:../index.php");
      
      	include('../lib/connectionfile.php');
      	
      	$sql=dbconfn()->prepare("SELECT * from w_photos where photoid='$_POST[photoid]' and username='$_SESSION[username]'");
      	$sql->execute();
      	
      	$row=$sql->fetch();
      	$str=explode(".",$row[1]);
	$thumb="..".$str[2]."_t.".$str[3];
	$thumbt="..".$str[2]."_tt.".$str[3];
      	unlink($row[1]);
      	unlink($thumb);
      	unlink($thumbt);
      	
      	$sql2=dbconfn()->prepare("DELETE from w_photos where photoid='$_POST[photoid]'");
      	$sql2->execute();
      	header('Location:editphotos.php');
      	    		     
      		     
      		     
?>  
