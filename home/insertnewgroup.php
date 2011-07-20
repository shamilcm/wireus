<?php 

        session_start();
        if($_SESSION['authuser']!=1)
       
                 header("Location:../index.php");
                 
           if($_POST['name']=="")
           {
           	
           	header("Location:creategroup.php?id=1");           
           }    
           else
           {
           	include('../lib/connectionfile.php'); 
           	 $cr_date=date('Y-m-d H:i:s');
           	 //echo $cr_date;
           	$sql1=dbconfn()->prepare("INSERT INTO w_groups(name,description,type,owner,create_date_time) values ('$_POST[name]','$_POST[description]','$_POST[type]','$_SESSION[username]','$cr_date')");
           	$sql1->execute();
           	$sql2=dbconfn()->prepare("SELECT max(groupid) from w_groups where owner='$_SESSION[username]'");
           	$sql2->execute();
           	$res=$sql2->fetch();
           	//echo $res[0];
           	$sql3=dbconfn()->prepare("INSERT INTO w_membership values('$_SESSION[username]','$res[0]','A')");
           	$sql3->execute();
           	
           	header("Location:editgroups.php");
           }
                 
      ?>
