<?php

  session_start();
if($_SESSION['authuser']!=1)
{
	header("Location:index.php");
}
	
include('lib/connectionfile.php');

$gmsgid=$_POST['gmsgid'];
$returngrp=$_POST['returngrp']; 

if($gmsgid)
{
	$count1=dbconfn()->prepare("DELETE FROM w_gmsgs WHERE gmsgid='$gmsgid'");
	$count1->execute();
	header("Location:groups?id=$returngrp&pid=msgs");
	exit;
}
else
{
	header("Location:home");
	exit;
}

?>
