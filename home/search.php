<?php 

        session_start();
        if($_SESSION['authuser']!=1)
                header("Location:../index.php");
      ?>  
      

<html>

<head>
<link rel="icon" 
      href="../favicon.ico">
</link>
<title> Wireus </title>

<link rel="stylesheet" type="text/css" href="../themes/style2.css">

</link>

<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    
   $(".globalheader").click(function(){
                $(".globalheader").stop().animate({top:"0px"},"slow");
           });
 $(".globalheader").hover(function(){
         },
         function() {
		 $(".globalheader").stop().animate({top:"-30px"},"slow");
         });


});

</script>
</head>
<body>

<?php
   include('../lib/header.php');
    getheader();
    ?>



<div class=globalcontainer>
      <div class="wrapper">
      	  <div id="pagecontainer">  
                <div id="pageleft">
         	<?php
      		

      		
                ?>
                </div>
                <div id="pageright">
                <?php   
                                
                                        include('../lib/connectionfile.php');
				        $username=$_SESSION['username'];
                                        $key = $_GET['key'];
                                        echo "<div class=\"contentwrapper\">";
		                        $count=0;
					$sql_results=dbconfn()->prepare("select profpic,username,fname,lname from w_profiles where (username ILIKE '%".$key."%') OR (fname ILIKE '%".$key."%') OR (lname ILIKE '%".$key."%')");
					$sql_results->execute();
					$results=$sql_results->fetchAll(PDO::FETCH_NUM);
                                        $resultcount=($sql_results->rowCount());
                                        echo "<div id=\"contentsubhead\">Results ($resultcount)</div>";
					foreach($results as $row=>$val)
					{
					
					  echo "<div class=\"searchresult\">";
                                        $sql_status1=dbconfn()->prepare("select status from w_connections where username1='$username' and username2='$val[1]';");
                                        $sql_status1->execute();
                                        $result_status1=$sql_status1->fetch();
                                        $sql_status2=dbconfn()->prepare("select status from w_connections where username1='$val[1]' and username2='$username';");
                                        $sql_status2->execute();
                                        $result_status2=$sql_status2->fetch();
                                        if($result_status1[0]=='A' || $result_status2[0]=='A')
                                                {
                             
                                                        
                                                        $status='A';   //Already Connected
                                                        
                                                        echo "<div class=\"reqpic\">";
				                        echo "<a href=\"../profile?id=$val[1]&pid=profile\"><img src=\"$val[0]\" height=50 width=50></img>";
				                        echo "</div>$val[1]</a> ($val[2] $val[3])";
				                        
                                                        echo "<form action=\"../userconnection.php\" method=\"POST\">";
                                                        echo "<input type=\"hidden\" name=\"status\" value=\"$status\"/>";
                                                        echo "<input type=\"hidden\" name=\"username1\" value=\"$val[1]\"/>";
                                                        echo "<input type=\"hidden\" name=\"username2\" value=\"$username\"/>";
                                                        echo "<input type=\"submit\" style=\"float:right;\" value=\"Remove Connection\" />";
                                                        echo "</form>";     
                                                 }
                                         else if($result_status1[0]=='R')
                                         {
                                                        $status='R';       //Connection Request Send
                                                        $friendcount=0;
			                                $sql_friends=dbconfn()->prepare("((select username2 from w_connections where username1='$val[1]' and status='A' order by random())
union (select username1 from w_connections where username2='$val[1]' and status='A' order by random())) 

intersect ((select username2 from w_connections where username1='$username' and status='A' order by random())
union (select username1 from w_connections where username2='$username' and status='A' order by random()));");
				                        $sql_friends->execute();
				                        $result_friends=$sql_friends->fetchAll(PDO::FETCH_NUM);
				                        $friendcount=($sql_friends->rowCount());
				                        echo "<div class=\"reqpic\">";
				                        echo "<a href=\"../profile?id=$val[1]&pid=profile\"><img src=\"$val[0]\" height=50 width=50></img>";
				                        echo "</div>$val[1]</a> ($val[2] $val[3])";
				                        echo "<br/>$friendcount Mutual Connections";
                                                        echo "<span style=\"float:right;\">Connection Request Sent</span>";
                                                        echo "<form action=\"../userconnection.php\" method=\"POST\">";
                                                        echo "<input type=\"hidden\" name=\"status\" value=\"$status\"/>";
                                                        echo "<input type=\"hidden\" name=\"username1\" value=\"$username\"/>";
                                                        echo "<input type=\"hidden\" name=\"username2\" value=\"$val[1]\"/>";
                                                        echo "<input type=\"submit\" style=\"float:right;\" value=\"Cancel Request\" />";
                                                        echo "</form>";  
                             }
                                        else if($result_status2[0]=='R')
                                                {
                                                        $status='I';   //Invited                                
                                                        $friendcount=0;
			                                $sql_friends=dbconfn()->prepare("((select username2 from w_connections where username1='$val[1]' and status='A' order by random())
union (select username1 from w_connections where username2='$val[1]' and status='A' order by random())) 

intersect ((select username2 from w_connections where username1='$username' and status='A' order by random())
union (select username1 from w_connections where username2='$username' and status='A' order by random()));");
				                        $sql_friends->execute();
				                        $result_friends=$sql_friends->fetchAll(PDO::FETCH_NUM);
				                        $friendcount=($sql_friends->rowCount());
				                        echo "<div class=\"reqpic\">";
				                        echo "<a href=\"../profile?id=$val[1]&pid=profile\"><img src=\"$val[0]\" height=50 width=50></img>";
				                        echo "</div>$val[1]</a> ($val[2] $val[3])";
				                        echo "<form action=\"../userconnection.php\" style=\"float:right;\"method=\"POST\">";
                                                        echo "<input type=\"hidden\" name=\"status\" value=\"$status\"/>";
                                                        echo "<input type=\"hidden\" name=\"username1\" value=\"$val[1]\"/>";
                                                        echo "<input type=\"hidden\" name=\"username2\" value=\"$username\"/>";
                                                        echo "<input type=\"submit\" style=\"float:right;\" value=\"Accept Request\" />";
                                                        echo "</form>";   
				                        echo "<br/><br/>$friendcount Mutual Connections";
                                                        echo "<span style=\"float:right;\"></span>";
  
                                                }
                                        else if($val[1]==$username)
                                                {
                                                        echo "<div class=\"reqpic\">";
				                        echo "<a href=\"../profile?id=$val[1]&pid=profile\"><img src=\"$val[0]\" height=50 width=50></img>";
				                        echo "</div>$val[1]</a> ($val[2] $val[3])";
                            
                                                }
                                        else
                                                {
                                                        $status = 'O';      //Open for connection
                                                        $friendcount=0;
			                                $sql_friends=dbconfn()->prepare("((select username2 from w_connections where username1='$val[1]' and status='A' order by random())
union (select username1 from w_connections where username2='$val[1]' and status='A' order by random())) 

intersect ((select username2 from w_connections where username1='$username' and status='A' order by random())
union (select username1 from w_connections where username2='$username' and status='A' order by random()));");
				                        $sql_friends->execute();
				                        $result_friends=$sql_friends->fetchAll(PDO::FETCH_NUM);
			                                $friendcount=($sql_friends->rowCount());
				                        echo "<div class=\"reqpic\">";
				                        echo "<a href=\"../profile?id=$val[1]&pid=profile\"><img src=\"$val[0]\" height=50 width=50></img>";
				                        
				                        echo "</div>$val[1]</a> ($val[2] $val[3])";
				                                                                               echo "<form action=\"../userconnection.php\" style=\"float:right;\" method=\"POST\">";
                                                        echo "<input type=\"hidden\" name=\"status\" value=\"$status\"/>";
                                                        echo "<input type=\"hidden\" name=\"username1\" value=\"$username\"/>";
                                                        echo "<input type=\"hidden\" name=\"username2\" value=\"$val[1]\"/>";
                                                        echo "<input type=\"submit\" style=\"float:right;\" value=\"Connect\" />";
                                                        echo "</form>";   
				                        echo "<br/><br/>$friendcount Mutual Connections";
                                                        echo "<span style=\"float:right;\"></span>";
   
                                                }




				        echo "</div>";
						$count++;

					     }	
		                        echo "</div>";         
                
                ?>
                </div>
      </div>
      
</div>
</body>
</html>
