<!-- HOME PAGE -->

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

<link rel="stylesheet" type="text/css" href="../themes/style2.css" />
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/jquery.tablescroll.js"></script>
<script type="text/javascript">
$(document).ready(function(){
        $('#gridfriends').tableScroll({height:400, width:270});
        
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
    <div class="globalcontainer">
		<div class="wrapper">
			<div id="pagecontainer">  
			        <div id="pageleft">
			                <div id="profilepic">
				        <?php  
				        include('../lib/connectionfile.php');
				        $username=$_SESSION['username'];
				        $sql=dbconfn()->prepare("select * from w_profiles where username='$username'");
				        $sql->execute();
				        $result=$sql->fetch(PDO::FETCH_LAZY);
				        if($result[profpic])
                                              echo "<img src=\"".$result['profpic']."\"></img>";
				       
                        echo "</div>";
                        
                        
                        
                        echo "<div class=\"friendlist\">";
		        $count=0;
		        $friendcount=0;
		        $sql_friends=dbconfn()->prepare("(select username2 from w_connections where username1='$username' and           status='A' order by random()) union (select username1 from w_connections where username2='$username' and status='A' order by random())");
		        $sql_friends->execute();
		        $result_friends=$sql_friends->fetchAll(PDO::FETCH_NUM);
		        $friendcount=($sql_friends->rowCount());
		        echo "Connections (".$friendcount.")<br/>";
		        echo "<table class=\"gridtable\" id=\"gridfriends\">
		              <tbody>
                               <tr class=\"gridrow\">";
                        foreach($result_friends as $row1=>$val)
		          {
                            echo "<td class=\"gridcell\">";
                            $sql_friendinfo=dbconfn()->prepare("select profpic, fname, lname from w_profiles where username='$val[0]'");
                            $sql_friendinfo->execute();
                            $result_friendinfo=$sql_friendinfo->fetch(PDO::FETCH_LAZY);
					        echo "<a href=\"../profile?id=$val[0]&pid=profile\">";
                            $name = $result_friendinfo[1]." ".$result_friendinfo[2];
                            echo "<img src=\"$result_friendinfo[0]\" ></img>";
                            $fname = explode(" ",$result_friendinfo[1]);
                            echo "<div class=\"name\">".$fname[0]."</div></a>";
                            $count++;
                            echo "</td>";
                            if($count%5==0)
			      { 
                                   echo "</tr>";
                                   echo "<tr>";
                                   }
                  
                            }
                            if($count<5)
                             {
                               while($count<5)
                                 { echo "<td class=\"gridcell\"></td>";
                                   $count++;  }
                              }	
                            
                            echo "</tr></tbody> </table>";
				     ?>
                        
	             </div>
			                
			                
			                
                    <div class="grouplist">
                    <?php
                    $count=0;
                    $groupcount=0;
	            $sql_groups=dbconfn()->prepare("select name,w_groups.groupid from w_groups, w_membership where w_groups.groupid=w_membership.groupid and w_membership.username='$username' and w_membership.status='A' order by random();");
	            $sql_groups->execute();
		    $result_groups=$sql_groups->fetchAll(PDO::FETCH_NUM);
		    $groupcount=($sql_groups->rowCount());
	            echo "Groups (".$groupcount.")<br/>";
	            echo "<table id=\"grouptable\">
		          <tbody>"; 
                    foreach($result_groups as $row1=>$val)
		    {   echo "<tr class=\"grouprow\">";
                        echo "<td class=\"groupcell\">";
                        echo "<a href=\"../groups?id=$val[1]&pid=profile\">$val[0]</a>";
                        $count++;
                        echo "</td>";
                        
                        echo "</tr>";
                         }
       
                    echo "</tr></tbody> </table>";
                    ?>
                    </div>      
			        </div>
			   <div id="pageright">
                <div id="pagehead">
                <?php
                        echo "<div id=\"pagetitle\">";
                        $sql_name=dbconfn()->prepare("select fname,lname from w_profiles where username='$username'");
                        $sql_name->execute();
                        $result_name=$sql_name->fetch();
                        echo strip_tags($result_name[0])." ".strip_tags($result_name[1]);
                        echo "</div>";
                        if(!$result_name[0])
                            {
                                header('Location:editprofile.php?xid=1');
                                }
                        echo "<div class=\"status\">";
                        $sql_status=dbconfn()->prepare("select content from w_msgs where sender='$username' and recipent='$username' order by send_date_time desc ;");
                        $sql_status->execute();
                        $result_status=$sql_status->fetch();
                        echo "<div id=\"statusmsg\">".htmlspecialchars($result_status[0])."</div>";            
	                echo "</div>";
	                
			        ?>
                </div>
			        
			        
			        <div id="pagelinks">
				<?php
					if(!$_GET[pid])
						echo 	"<a id=\"clickhome\" href=\"../home\"><img class=\"link\" src=\"../images/btn_home_h.png\" style=\"opacity:1;filter:alpha(opacity=100)\"
onmouseover=\"this.style.opacity=0.7;this.filters.alpha.opacity=70\"
onmouseout=\"this.style.opacity=1;this.filters.alpha.opacity=100\" /></a>";
					else
						echo 	"<a id=\"clickhome\" href=\"../home\"><img class=\"link\" src=\"../images/btn_home.png\" style=\"opacity:1;filter:alpha(opacity=100)\"
onmouseover=\"this.style.opacity=0.7;this.filters.alpha.opacity=70\"
onmouseout=\"this.style.opacity=1;this.filters.alpha.opacity=100\"/></a>";
					if($_GET[pid]=="profile")
						echo "<a id=\"clickprofiles\" href=\"../home?pid=profile\"><img class=\"link\" src=\"../images/btn_profiles_h.png\"style=\"opacity:1;filter:alpha(opacity=100)\"
onmouseover=\"this.style.opacity=0.7;this.filters.alpha.opacity=70\"
onmouseout=\"this.style.opacity=1;this.filters.alpha.opacity=100\" /></a>";
					else
						echo "<a id=\"clickprofiles\" href=\"../home?pid=profile\"><img class=\"link\" src=\"../images/btn_profiles.png\" style=\"opacity:1;filter:alpha(opacity=100)\"
onmouseover=\"this.style.opacity=0.7;this.filters.alpha.opacity=70\"
onmouseout=\"this.style.opacity=1;this.filters.alpha.opacity=100\"/></a>";
					if($_GET[pid]=="msgs")
						echo "<a id=\"clickmessages\" href=\"../home?pid=msgs\"><img class=\"link\" src=\"../images/btn_msgs_h.png\" style=\"opacity:1;filter:alpha(opacity=100)\"
onmouseover=\"this.style.opacity=0.7;this.filters.alpha.opacity=70\"
onmouseout=\"this.style.opacity=1;this.filters.alpha.opacity=100\"/></a>";
					else
						echo "<a id=\"clickmessages\" href=\"../home?pid=msgs\"><img class=\"link\" src=\"../images/btn_msgs.png\" style=\"opacity:1;filter:alpha(opacity=100)\"
onmouseover=\"this.style.opacity=0.7;this.filters.alpha.opacity=70\"
onmouseout=\"this.style.opacity=1;this.filters.alpha.opacity=100\"/></a>";					if($_GET[pid]=="photos")
						echo "<a id=\"clickphotos\" href=\"../home?pid=photos\"><img class=\"link\" src=\"../images/btn_photos_h.png\" style=\"opacity:1;filter:alpha(opacity=100)\"
onmouseover=\"this.style.opacity=0.7;this.filters.alpha.opacity=70\"
onmouseout=\"this.style.opacity=1;this.filters.alpha.opacity=100\"/></a>";
					else
						echo "<a id=\"clickphotos\" href=\"../home?pid=photos\"><img class=\"link\" src=\"../images/btn_photos.png\" style=\"opacity:1;filter:alpha(opacity=100)\"
onmouseover=\"this.style.opacity=0.7;this.filters.alpha.opacity=70\"
onmouseout=\"this.style.opacity=1;this.filters.alpha.opacity=100\"/></a>";
	        		?>
		                </div>
		                <div id="pagelinkbar"></div>
			        <div id="pagecontent">
				<?php
				        
				       
				       if($_GET['pid']=="msgs")
				        {
				         echo "<div class=\"contentwrapper\">";
				         echo "<div id=\"contenthead\">Messages</div>";
				        $count=0;

					$sql_msgs=dbconfn()->prepare("select content,sender,send_date_time,privacy,msgid from w_msgs where recipent='$username' and sender<>'$username'  order by send_date_time desc;");
					$sql_msgs->execute();
					$result_msgs=$sql_msgs->fetchAll(PDO::FETCH_NUM);

					foreach($result_msgs as $row2=>$val)
					{
					
					  echo "<div class=\"msgbox\">";
					         echo "<div class=\"msgpic\">";
					        $sql_pic=dbconfn()->prepare("select profpic from w_profiles where username='$val[1]';");
					        $sql_pic->execute();
					        $result_pic=$sql_pic->fetch();
						echo "<a href=\"../profile?id=$val[1]&pid=msgs\"><img src=\"$result_pic[0]\" height=50 width=50></img>";
						echo "</div>";
						
						 $dt =date("F j, Y, g:i a",strtotime($val[2]));
						echo "$val[1]</a>";
						echo "on $dt";
						if($val[3]=='P')
						        echo "<img src=\"../images/img_key.jpg\"></img>";
					        echo "<form style=\"display:inline;\" action=\"../deletemsg.php\" method=\"POST\">
						<input type=\"hidden\" name=\"msgid\"  value=\"$val[4]\" />
						<input type=\"hidden\" name=\"returnuser\"  value=\"$username\" />
						<input type=\"submit\" class=\"btn_delmsg\"  value=\"\" /></form>";
                                                        
						echo "<div class=\"msgdetails\">";
						echo htmlspecialchars($val[0]);
                                               
						
						echo "</div>";
				        echo "</div>";
						$count++;
						
						if($count==40)
							break;
					     }	
				
				          echo "</div>";
				        }
				        
			else if($_GET['pid']=="photos")
		               {
				       echo "<div class=\"contentwrapper\">";
				       echo "<div id=\"contenthead\">Photos</div>";
				       echo "</div>";
				       echo "<div id=\"displayphoto\">";
				       
				       if(!($_GET['photo']>13300))
				        {       
				              $sql_id=dbconfn()->prepare("select photoid from w_photos where username='$username' order by up_date_time desc;"); 
				                $sql_id->execute();
				                $result_id=$sql_id->fetch();
				                $photo=$result_id[0];             
				        }
				       else
				         {
				                $photo=$_GET['photo'];
				         }
				       $sql_pic=dbconfn()->prepare("select path,title,description,up_date_time from w_photos where photoid='$photo';");
				       $sql_pic->execute();
				       $result_pic=$sql_pic->fetch();
				       if($result_pic)
				       {        echo "<div id=\"mainimgbox\"><br/><img src=$result_pic[0]></img>";
				                echo "<br/><span class=\"phototitle\">$result_pic[1]</span>";
				               $dt =date("F j, Y, g:i a",strtotime($result_pic[3]));
				               echo "<span class=\"photodate\">$dt</span>";
				               echo "<br/><br/>".$result_pic[2];
				               echo "</div>";
				               echo "</div>";
				               
				            }
				            
			                else
				        {
				        
				                echo "<center><br/><br/><br/>There are no photos to display</center>";
				              
				        }
			        echo "<table class=\"gridtable\" id=\"gridphotos\">
		                <tbody>
                                 <tr class=\"gridphotorow\">";
                                $count=0;
                      
                                 $sql_photos=dbconfn()->prepare("select photoid,path,title from w_photos where username='$username' order by up_date_time desc");
		                $sql_photos->execute();
				$result_photos=$sql_photos->fetchAll(PDO::FETCH_NUM);
				$photocount=($sql_photos->rowCount());
                        
                                foreach($result_photos as $row1=>$val)
		                  {
		              	
		                  	$str=explode(".",$val[1]);
					$thumb="..".$str[2]."_tt.".$str[3];
			
					
                                        echo "<td class=\"gridphotocell\">";
                                        echo "<a href=\"../home?pid=photos&photo=$val[0]\"><img src=\"$thumb\" width=90></img></a>";
                                        $count++;
                                        echo "</td>";
                                        if($count%7==0)
                                        { 
                                                echo "</tr>";
                                                echo "<tr>";
                                        }
                                   }
                            if($count<7)
                             {
                               while($count<=7)
                                 { echo "<td class=\"gridphotocell\"></td>";
                                   $count++;  }
                              }	
                            
                            echo "</tr></tbody> </table>";
                            echo "</div>";
		           }
		
		       	      
		    else if($_GET['pid']=="profile")
				      {
				        echo "<div class=\"contentwrapper\">";
				        echo "<div id=\"contenthead\">Profile</div>";
				        
				        $sql_profile=dbconfn()->prepare("select * from w_profiles where username='$username'");
					$sql_profile->execute();
					$result_profile=$sql_profile->fetch(PDO::FETCH_LAZY);
				        echo "<br/>";
				        echo "<br/>";
			                echo "<div id=\"profilebox\">";
				        $dt = date("F j, Y",strtotime($result_profile[3]));
				        echo "<div class=\"profdetail\"> Date Of Birth:  </div>". $dt."<br/><br/>";
				        echo "<div class=\"profdetail\">  Sex : </div> $result_profile[4]<br/><br/>";
				        echo "<div class=\"profdetail\">  About Me: </div><br/>" .htmlspecialchars($result_profile[5])."<br/><br/>";
				        echo "</div>";
				        echo "</div>";
				        
							      
                                       }
                                      
                                else
                                      {
                                        echo "<div class=\"contentwrapper\">";
                                        echo "<div id=\"statushead\">What's up?</div>";
                                        echo "<form action=\"../sendmsg.php\" method=\"POST\">";
		                        echo "<textarea style=\"resize: none;\" name=\"msg\" cols=80 rows=3 maxlength=150></textarea> ";
		                        echo "<input type=\"hidden\" name=\"sender\" value=\"$username\" />";
		                        echo "<input type=\"hidden\" name=\"recipent\" value=\"$username\" /><br />";
		                        echo "<input type=\"hidden\" name=\"privacy\" value=\"O\" />";
		                        echo "<input type=\"submit\" name=\"statussubmit\" value=\"Update Status\" style=\"float:right;\"/>";
		                        echo "</form>";  


//----------------------------------------------Connection Requests---------------------------------------------------------
		                        $count=0;

					$sql_requests=dbconfn()->prepare("select username1 from w_connections where username2='$username' and status='R';");
					$sql_requests->execute();
					$result_requests=$sql_requests->fetchAll(PDO::FETCH_NUM);
                                        $requestcount=($sql_requests->rowCount());
                                        echo "<div id=\"contentsubhead\">Connection Requests($requestcount)</div>";
					foreach($result_requests as $row=>$val)
					{
					
					  echo "<div class=\"reqbox\">";
					         echo "<div class=\"reqpic\">";
					        $sql_info=dbconfn()->prepare("select profpic,username,fname,lname from w_profiles where username='$val[0]';");
					        $sql_info->execute();
					        $info=$sql_info->fetch();
						echo "<a href=\"../profile?id=$val[0]&pid=profile\"><img src=\"$info[0]\" height=50 width=50></img>";
						echo "</div>";
						echo " $info[1]</a>($info[2] $info[3])";
					        echo "<form style=\"display:inline;\" action=\"../userconnection.php\" method=\"POST\">
						<input type=\"hidden\" name=\"username1\"  value=\"$val[0]\" />
						<input type=\"hidden\" name=\"username2\"  value=\"$username\" />
						<input type=\"hidden\" name=\"status\"  value=\"J\" />
						<input type=\"submit\" class=\"btn_accept\"  value=\"Accept Request\" /></form>";
				        echo "</div>";
						$count++;
						
						if($count==10)
							break;
					     }	
		                        echo "</div>";                                    
                                      
//------------------------___Connection Requests Sent--------------------------------------
                                       
		                        $count=0;

					$sql_requests=dbconfn()->prepare("select username2 from w_connections where username1='$username' and status='R';");
					$sql_requests->execute();
					$result_requests=$sql_requests->fetchAll(PDO::FETCH_NUM);
					$requestcount=($sql_requests->rowCount());
                                        echo "<div id=\"contentsubhead\">Open Invites($requestcount)</div>";
					foreach($result_requests as $row=>$val)
					{
					
					  echo "<div class=\"reqbox\">";
					         echo "<div class=\"reqpic\">";
					        $sql_info=dbconfn()->prepare("select profpic,username,fname,lname from w_profiles where username='$val[0]';");
					        $sql_info->execute();
					        $info=$sql_info->fetch();
						echo "<a href=\"../profile?id=$val[0]&pid=profile\"><img src=\"$info[0]\" height=50 width=50></img>";
						echo "</div>";
						echo " $info[1]</a>($info[2] $info[3])";
					        echo "<form style=\"display:inline;\" action=\"../userconnection.php\" method=\"POST\">
						<input type=\"hidden\" name=\"username2\"  value=\"$val[0]\" />
						<input type=\"hidden\" name=\"username1\"  value=\"$username\" />
						<input type=\"hidden\" name=\"status\"  value=\"S\" />
						<input type=\"submit\" class=\"btn_accept\"  value=\"Cancel Invite\" /></form>";
				                echo "</div>";
						$count++;
						
						if($count==10)
							break;
					     }	
		                        echo "</div>";                                    
//------------------------------------___Group Requests----------------------------------------------------
		                        $count=0;

					$sql_requests=dbconfn()->prepare("select m.username,g.groupid,g.name from w_groups g,w_membership m where g.groupid=m.groupid and g.owner='$_SESSION[username]' and m.status='R';");
					$sql_requests->execute();
					$result_requests=$sql_requests->fetchAll(PDO::FETCH_NUM);
                                        $requestcount=($sql_requests->rowCount());
                                        echo "<div id=\"contentsubhead\">Group Requests($requestcount)</div>";
					foreach($result_requests as $row=>$val)
					{
					
					  echo "<div class=\"reqbox\">";
					         echo "<div class=\"reqpic\">";
					        $sql_info=dbconfn()->prepare("select profpic,username,fname,lname from w_profiles where username='$val[0]';");
					        $sql_info->execute();
					        $info=$sql_info->fetch();
						echo "<a href=\"../profile?id=$val[0]&pid=profile\"><img src=\"$info[0]\" height=50 width=50></img>";
						echo "</div>";
						echo " $info[1]</a>($info[2] $info[3]) - ";
						echo "<a href=\"../groups?id=$val[1]&pid=profile\">$val[2]</a>";
					        echo "<form style=\"display:inline;\" action=\"../groupmembership.php\" method=\"POST\">
						<input type=\"hidden\" name=\"username\"  value=\"$val[0]\" />
						<input type=\"hidden\" name=\"status\"  value=\"K\" />
						<input type=\"hidden\" name=\"gid\"  value=\"$val[1]\" />
						<input type=\"submit\" class=\"btn_accept\"  value=\"Accept Request\" /></form>";
				        echo "</div>";
						$count++;
						
						if($count==10)
							break;
					     }	
		                        echo "</div>";                                      
                                      
                                      
                                      
                                      }
                                        
				      
				?>
				

			        </div>
			   </div>
			</div>

				
		
	</div>
</body>


</html>
