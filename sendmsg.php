<?php

session_start();
if($_SESSION['authuser']!=1)
{
	header("Location:index.php");
	exit;
}
            
include('lib/connectionfile.php');
        
$sender=$_POST['sender'];
$recipent=$_POST['recipent'];
$msg=$_POST['msg'];
$dt=date('Y-m-d H:i:s');
$privacy=$_POST['privacy'];

if($msg && $sender!=$recipent)
{
	$count1=dbconfn()->prepare("INSERT INTO w_msgs(sender,recipent,content,send_date_time,privacy) VALUES('$sender','$recipent','$msg','$dt','$privacy')");
	$count1->execute();
	header("Location:profile?id=$recipent&pid=msgs");
	exit;
}
elseif($msg && $sender==$recipent)
{
	$count1=dbconfn()->prepare("DELETE FROM w_msgs where sender=$sender and recipent=$recipent;");
	$count1->execute();
	
	$count2=dbconfn()->prepare("INSERT INTO w_msgs(sender,recipent,content,send_date_time,privacy) VALUES('$sender','$recipent','$msg','$dt','$privacy')");
	$count2->execute();
	header("Location:profile?id=$recipent");
	exit;
}
else
{
		header("Location:profile?id=$recipent");
		exit;
}
?>
