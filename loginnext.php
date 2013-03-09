<?php

session_start();

include('lib/connectionfile.php');
$uname= pg_escape_string($_POST['username']);
$password1= pg_escape_string($_POST['password']);
$encpass = md5($password1);

 
$count=0;
$xid=0;
 
$sql = "SELECT * FROM w_users where username='$_POST[username]' and password='$encpass'";
foreach(dbconfn()->query($sql) as $row)
{
	$count=$count+1;
}

if($count==1)
{
	$_SESSION['username']=$uname;
	$_SESSION['authuser']=1;
	header('Location:home');
	exit;
}
else
{
	header('Location:index.php?xid=1');
	exit;
}

?>
