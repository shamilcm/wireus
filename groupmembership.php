<?php
session_start();
if($_SESSION['authuser']!=1)
{
	header("Location:index.php");
	exit;
}

include('lib/connectionfile.php');

$username=$_POST['username'];
$type=$_POST['type'];
$status=$_POST['status'];
$gid=$_POST['gid'];
   
switch ($status)
{
	case "A":
		$count1=dbconfn()->prepare("DELETE FROM w_membership WHERE username='$username' and groupid='$gid';");
		$count1->execute();
		header("Location:groups?id=$gid");
		exit;
	break;
	
	case "O":
		$sql=dbconfn()->prepare("DELETE from w_groups where groupid='$gid';");
		$sql->execute();
		$sql=dbconfn()->prepare("DELETE from w_membership where groupid='$gid';");
		$sql->execute();
		header("Location:home");
		exit;
	break;
	
	case "R":
		$sql=dbconfn()->prepare("DELETE from w_membership where username='$username' and groupid='$gid';");
		$sql->execute();
		header("Location:groups?id=$gid");
		exit;
	break;
	
	case "I":
		$sql=dbconfn()->prepare("INSERT into w_membership values ('$username','$gid','R');");
		$sql->execute();
		header("Location:groups?id=$gid");
		exit;
	break;
	
	case "J":
		$sql=dbconfn()->prepare("INSERT into w_membership values ('$username','$gid','A');");
		$sql->execute();
		header("Location:groups?id=$gid");
		exit;
	break;
	
	case "K":
		$sql=dbconfn()->prepare("UPDATE w_membership set status='A' where username='$username' and groupid='$gid'");
		$sql->execute();
		header("Location:home");
		exit;
	break;
}            

?>
