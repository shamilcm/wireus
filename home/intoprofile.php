<?php 

        session_start();
        if($_SESSION['authuser']!=1)
                header("Location:../index.php");
      ?>  
<?php
	session_start(); 
	include('../lib/connectionfile.php');
	//echo $_POST[fname];
	//echo $_POST[lname];
	//echo $_POST[dob];
	$dob=$_POST['year']."-".$_POST['month']."-".$_POST['day'];
	$ftname=trim($_POST['fname']);
	$ltname=trim($_POST['lname']);
	if(($ftname=="")||($ltname==""))
	{
		header('Location:editprofile.php?xid=1');	
	}
	else
	{
		$sql1="UPDATE w_profiles SET fname='$_POST[fname]' WHERE username='$_SESSION[username]'";
		$sql2="UPDATE w_profiles SET lname='$_POST[lname]' WHERE username='$_SESSION[username]'";
		$sql3="UPDATE w_profiles SET dob='$dob' WHERE username='$_SESSION[username]'";
		$sql4="UPDATE w_profiles SET sex='$_POST[sex]' WHERE username='$_SESSION[username]'";
		$sql5="UPDATE w_profiles SET bio='$_POST[bio]' WHERE username='$_SESSION[username]'";
		$count1=dbconfn()->prepare($sql1);
		$count1->execute();
		//echo $count1;
		$count2=dbconfn()->prepare($sql2);
		$count2->execute();
		//echo $count2;
		$count3=dbconfn()->prepare($sql3);
		$count3->execute();
		//echo $count3;
		$count4=dbconfn()->prepare($sql4);
		$count4->execute();
		//echo $count4;
		$count5=dbconfn()->prepare($sql5);
		$count5->execute();
		//echo $count5;*/
		header('Location:../home');
	}

?>
