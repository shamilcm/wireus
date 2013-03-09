<?php

session_start();
if($_SESSION['authuser']!=1)
{
	header("Location:index.php");
	exit;
}
        
include('lib/connectionfile.php');
        
$username1=$_POST['username1'];
$username2=$_POST['username2'];
$status=$_POST['status'];

switch ($status)
{
	case "A":
		$count1=dbconfn()->prepare("DELETE FROM w_connections WHERE (username1='$username1' and username2='$username2') or (username1='$username2' and username2='$username1')");
		$count1->execute();
		header("Location:profile?id=$username1");
		exit;
	break;
	
	case "R":
	case "S":
		$count1=dbconfn()->prepare("DELETE FROM w_connections WHERE username1='$username1' and username2='$username2'");
		$count1->execute();
		if($status=='S')                                 //Status S: For Sent Invites from Homepage 
		{
			header("Location:home");
			exit;
		}
		else
		{
			header("Location:profile?id=$username2");
			exit;
		}
	break;
	
	case "I":
	case "J":
		$count1=dbconfn()->prepare("UPDATE w_connections SET status='A' WHERE username1='$username1' and username2='$username2'");
		$count1->execute();
		 
		if($status=='J')                                 //Status J: For Requests from Homepage 
		{
			header("Location:home");
			exit;
		}
			
		else
		{
			header("Location:profile?id=$username1");
			exit;
		}	
	break;
	
	case "O":
		$count1=dbconfn()->exec("INSERT INTO w_connections VALUES('$username1','$username2','R')");
		header("Location:profile?id=$username2");
		exit;
	break;
	
	default:
		//This error should be handled better in the future -WILLIAMKNAUSS
		die("Unknown status: ".$status);
	break;
}

?>
