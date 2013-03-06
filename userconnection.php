<?php
        session_start();
        if($_SESSION['authuser']!=1)
                header("Location:index.php");
        
        include('lib/connectionfile.php');
        
        $username1=$_POST['username1'];
        $username2=$_POST['username2'];
        $status=$_POST['status'];
        
        if($status=='A')
        {
                $count1=dbconfn()->prepare("DELETE FROM w_connections WHERE (username1='$username1' and username2='$username2') or (username1='$username2' and username2='$username1')");
                $count1->execute();
                header("Location:profile?id=$username1");
               
           }
        
       if($status=='R' || $status=='S' )
        {
                $count1=dbconfn()->prepare("DELETE FROM w_connections WHERE username1='$username1' and username2='$username2'");
                $count1->execute();
               if($status=='S')                                 //Status S: For Sent Invites from Homepage 
                        header("Location:home");
                
               else
                header("Location:profile?id=$username2");
               
           }
        
        if($status=='I' || $status=='J')
        {
                $count1=dbconfn()->prepare("UPDATE w_connections SET status='A' WHERE username1='$username1' and username2='$username2'");
                $count1->execute();
             
               if($status=='J')                                 //Status J: For Requests from Homepage 
                        header("Location:home");
                
               else
                        header("Location:profile?id=$username1");
                
           }
           
                   
        if($status=='O')
        {
                $count1=dbconfn()->exec("INSERT INTO w_connections VALUES('$username1','$username2','R')");
                header("Location:profile?id=$username2");
              
           }

?>
