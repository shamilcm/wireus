<?php 

        session_start();
        if($_SESSION['authuser']!=1)
                header("Location:../index.php");
      ?>  
      
<?php

	include('../lib/connectionfile.php');
		
	$sql1=dbconfn()->prepare("UPDATE w_photos SET title='$_POST[title]' where photoid='$_POST[photoid]'");
	$sql2=dbconfn()->prepare("UPDATE w_photos SET description='$_POST[description]' where photoid='$_POST[photoid]'");
	$sql1->execute();
	$sql2->execute();
	//echo $sql1;
	
	header('Location:editphotos.php');


?>
