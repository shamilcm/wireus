<?php
	
include('lib/connectionfile.php');

$uname=$_POST['reg_username'];
$email=$_POST['reg_email'];
$password1=$_POST['reg_password1'];
$password2=$_POST['reg_password2'];

$xid=0;

if($uname=="")
{
	header("Location:index.php?xid=6"); 
}
elseif($password1=="")
{
	header("Location:index.php?xid=7"); 
}
elseif($email=="")
{
	header("Location:index.php?xid=8");
}
elseif(!eregi("([^A-Za-z0-9])",$uname))   //Test for alphanum
{ 
	//test for duplicate names (errorid=3)
	$check3 = dbconfn()->prepare("SELECT COUNT(*) FROM w_users WHERE username='$uname'"); 
	$check3->execute();
	$result=$check3->fetch();
	if($result[0]==0) 
	{
		$check4 = dbconfn()->prepare("SELECT COUNT(*) FROM w_users WHERE email='$email'");
		$check4->execute();
		$result=$check4->fetch();
		if($result[0]==0)
		{          
			if($password1==$password2)
			{    
				$confirm_code = md5(uniqid(rand()));
				//echo $confirm_code;
				$uname = strip_tags($uname);
				$email = strip_tags($email);
				$password1=strip_tags($password1);
				$password1 = md5($password1);
                             
				$count2 = dbconfn()->exec("INSERT INTO w_users VALUES('$uname','$password1','$email')");
				$count3 = dbconfn()->exec("INSERT INTO w_profiles (username,profpic) VALUES ('$uname','../images/profiles/default.png')");
				$count1 = dbconfn()->exec("INSERT INTO w_confirmation VALUES ('$uname', '$confirm_code')");
				//echo $count1;
				//echo $count2;
				if($count1>=1 && $count2>=1);
				{
					session_start();
					$_SESSION['username']=$uname;
					$_SESSION['authuser']=1;										
					header("Location:home/editprofile.php");
					exit;
				}
			}
			else
			{
				header("Location:index.php?xid=5");   
				exit;
			}
		}
		else
		{
			header("Location:index.php?xid=4"); 
		}
        
	}
	else
	{
		header("Location:index.php?xid=3");
	}
}
else 
{
	header("Location:index.php?xid=2");
}

?>
