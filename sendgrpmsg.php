<?php


          session_start();
        if($_SESSION['authuser']!=1)
                header("Location:index.php");
            
        include('lib/connectionfile.php');
        
        $sender=$_POST['sender'];
        $r_groupid=$_POST['gid'];
        $msg=$_POST['msg'];
        $dt=date('Y-m-d H:i:s');
                   
           
        if($msg)
        {
                $count1=dbconfn()->prepare("INSERT INTO w_gmsgs(s_username,r_groupid,content,send_date_time) VALUES('$sender','$r_groupid','$msg','$dt');");
                $count1->execute();
                header("Location:groups?id=$r_groupid&pid=msgs");
        }


       else
        {
                header("Location:groups?id=$r_groupid");
        }
        
        
?>
