<!-- PROFILE PAGE -->


<?php 

        session_start();
        if($_SESSION['authuser']!=1)
                header("Location:../index.php");
        if($_GET['id']==$_SESSION['username'])
              { if($_GET['pid'])   $str="?pid=".$_GET['pid'];  
                header("Location:../home".$str); }
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
				        $username=$_GET['id'];
                        $cur_username=$_SESSION['username'];
				        $sql=dbconfn()->prepare("select * from w_profiles where username='$username'");
				        $sql->execute();
				        $result=$sql->fetch(PDO::FETCH_LAZY);
				        
                        echo "<img src=\"".$result['profpic']."\"></img>";
                        
                       ?>
                      </div>
                               
                               
                       <?php
                          echo "<div class=\"friendlist\">";   //Mutual Connections
		          $count=0;
			  $friendcount=0;
			  $sql_friends=dbconfn()->prepare("((select username2 from w_connections where username1='$username' and status='A' order by random())
union (select username1 from w_connections where username2='$username' and status='A' order by random())) 

intersect ((select username2 from w_connections where username1='$cur_username' and status='A' order by random())
union (select username1 from w_connections where username2='$cur_username' and status='A' order by random()));");
				        $sql_friends->execute();
				        $result_friends=$sql_friends->fetchAll(PDO::FETCH_NUM);
				        $friendcount=($sql_friends->rowCount());
				        echo "Mutual Connections (".$friendcount.")<br/>";
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
				       
                        
	                echo  "</div>";
	              ?>
                       <?php
                        echo "<div class=\"friendlist\">";
				        $count=0;
				        $friendcount=0;
				        $sql_friends=dbconfn()->prepare("(select username2 from w_connections where username1='$username' and status='A' order by random())
				        union (select username1 from w_connections where username2='$username' and status='A' order by random())");
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
				        
                             
	                 echo "</div>";
	              ?>
   
	            
	            
                    <div class="grouplist">
                    <?php
                    $count=0;
                    $groupcount=0;
                    $sql_groups=dbconfn()->prepare("select name,w_groups.groupid from w_groups, w_membership where w_groups.groupid=w_membership.groupid and w_membership.username='$username' and w_membership.status='A'  order by random();");
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
                        echo $result_name[0]." ".$result_name[1];
                        echo "</div>";
                        
                        echo "<div id=\"friendrequestbox\">";
                        $sql_status1=dbconfn()->prepare("select status from w_connections where username1='$cur_username' and username2='$username';");
                        $sql_status1->execute();
                        $result_status1=$sql_status1->fetch();
                        $sql_status2=dbconfn()->prepare("select status from w_connections where username1='$username' and username2='$cur_username';");
                        $sql_status2->execute();
                        $result_status2=$sql_status2->fetch();
                        if($result_status1[0]=='A' || $result_status2[0]=='A')
                         {
                             
                             $status='A';   //Already Connected
                             echo "<form action=\"../userconnection.php\" method=\"POST\">";
                             echo "<input type=\"hidden\" name=\"status\" value=\"$status\"/>";
                             echo "<input type=\"hidden\" name=\"username1\" value=\"$username\"/>";
                             echo "<input type=\"hidden\" name=\"username2\" value=\"$cur_username\"/>";
                             echo "<input type=\"submit\" value=\"Remove Connection\" />";
                             echo "</form>";     
                             
                             }
                        else if($result_status1[0]=='R')
                         {
                             $status='R';       //Connection Request Send
                             echo "<span>Connection Request Sent</span>";
                             echo "<form action=\"../userconnection.php\" method=\"POST\">";
                             echo "<input type=\"hidden\" name=\"status\" value=\"$status\"/>";
                             echo "<input type=\"hidden\" name=\"username1\" value=\"$cur_username\"/>";
                             echo "<input type=\"hidden\" name=\"username2\" value=\"$username\"/>";
                             echo "<input type=\"submit\" value=\"Cancel Request\" />";
                             echo "</form>";  
                             }
                        else if($result_status2[0]=='R')
                           {
                               $status='I';   //Invited
                               echo "<span>Connection Request</span>";
                               echo "<form action=\"../userconnection.php\" method=\"POST\">";
                               echo "<input type=\"hidden\" name=\"status\" value=\"$status\"/>";
                               echo "<input type=\"hidden\" name=\"username1\" value=\"$username\"/>";
                               echo "<input type=\"hidden\" name=\"username2\" value=\"$cur_username\"/>";
                               echo "<input type=\"submit\" value=\"Accept\" />";
                               echo "</form>";     
                               }
                        else
                            {
                                $status = 'O';      //Open for connection
                               echo "<form action=\"../userconnection.php\" method=\"POST\">";
                               echo "<input type=\"hidden\" name=\"status\" value=\"$status\"/>";
                               echo "<input type=\"hidden\" name=\"username1\" value=\"$cur_username\"/>";
                               echo "<input type=\"hidden\" name=\"username2\" value=\"$username\"/>";
                               echo "<input type=\"submit\" value=\"Send Connection Request\" />";
                               echo "</form>";     
                                }
                            
                       
                        echo "</div>";
                        echo "</div>";
                        echo "<div class=\"status\">";
                        $sql_status=dbconfn()->prepare("select content from w_msgs where sender='$username' and recipent='$username' order by send_date_time desc ;");
                        $sql_status->execute();
                        $result_status=$sql_status->fetch();
                        echo "<div id=\"statusmsg\">$result_status[0]</div>";
                        echo "</div>";
                        ?>
			        
                  	
			        <div id="pagelinks">
				<?php
					if($_GET[pid]=="profile" || !$_GET[pid])
						echo "<a id=\"clickprofiles\" href=\"../profile?id=$username&pid=profile\"><img class=\"link\" src=\"../images/btn_profiles_h.png\" style=\"opacity:1;filter:alpha(opacity=100)\"
onmouseover=\"this.style.opacity=0.7;this.filters.alpha.opacity=70\"
onmouseout=\"this.style.opacity=1;this.filters.alpha.opacity=100\"/></a>";
					else
						echo "<a id=\"clickprofiles\" href=\"../profile?id=$username&pid=profile\"><img class=\"link\" src=\"../images/btn_profiles.png\" style=\"opacity:1;filter:alpha(opacity=100)\"
onmouseover=\"this.style.opacity=0.7;this.filters.alpha.opacity=70\"
onmouseout=\"this.style.opacity=1;this.filters.alpha.opacity=100\"/></a>";
					if($_GET[pid]=="msgs")
						echo "<a id=\"clickmessages\" href=\"../profile?id=$username&pid=msgs\"><img class=\"link\" src=\"../images/btn_msgs_h.png\" style=\"opacity:1;filter:alpha(opacity=100)\"
onmouseover=\"this.style.opacity=0.7;this.filters.alpha.opacity=70\"
onmouseout=\"this.style.opacity=1;this.filters.alpha.opacity=100\"/></a>";
					else
						echo "<a id=\"clickmessages\" href=\"../profile?id=$username&pid=msgs\"><img class=\"link\" src=\"../images/btn_msgs.png\" style=\"opacity:1;filter:alpha(opacity=100)\"
onmouseover=\"this.style.opacity=0.7;this.filters.alpha.opacity=70\"
onmouseout=\"this.style.opacity=1;this.filters.alpha.opacity=100\"/></a>";					if($_GET[pid]=="photos")
						echo "<a id=\"clickphotos\" href=\"../profile?id=$username&pid=photos\"><img class=\"link\" src=\"../images/btn_photos_h.png\" style=\"opacity:1;filter:alpha(opacity=100)\"
onmouseover=\"this.style.opacity=0.7;this.filters.alpha.opacity=70\"
onmouseout=\"this.style.opacity=1;this.filters.alpha.opacity=100\"/></a>";
					else
						echo "<a id=\"clickphotos\" href=\"../profile?id=$username&pid=photos\"><img class=\"link\" src=\"../images/btn_photos.png\" style=\"opacity:1;filter:alpha(opacity=100)\"
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
				        
				        echo "<div id=\"sendmsgbox\">";
				        echo "<form action=\"../sendmsg.php\" method=\"POST\">";
				        echo "<textarea style=\"resize: none;\" name=\"msg\" cols=80 rows=4 maxlength=180></textarea> ";
				        echo "<input type=\"hidden\" name=\"sender\" value=\"$cur_username\" />";
				        echo "<input type=\"hidden\" name=\"recipent\" value=\"$username\" /><br />";
				       echo "<input type=\"submit\" name=\"submit\" value=\"Send Message\" style=\"float:right;  height:25px; \"/>";
				       if($status=='R' || $status=='O') 
				        { echo "<select name=\"privacy\" style=\"float:right; height:25px; width:100px;\">";
				        echo "<option value=\"P\">Private</option></select>";
				        }
				      if($status=='I' || $status=='A') 
				        { echo "<select name=\"privacy\" style=\"float:right; height:25px; width:100px;\"><option value=\"O\">Open</option>";
				        echo "<option value=\"P\">Private</option></select>";
				        } 
				        
				        echo "</form>";
				         echo "</div>";
					
//---------------------------------------------------------------------------------------------------------- 
					$sql_msgs=dbconfn()->prepare("select content,sender,send_date_time,privacy,msgid from w_msgs where (recipent='$username' and sender<>'$username' and privacy='O') or (recipent='$username' and sender='$cur_username') order by send_date_time desc");
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
						        
						if($val[1]==$cur_username)                      //Current User
						       echo "<form style=\"display:inline;\" action=\"../deletemsg.php\" method=\"POST\">
						       <input type=\"hidden\" name=\"msgid\"  value=\"$val[4]\" />
						       <input type=\"hidden\" name=\"returnuser\"  value=\"$username\" />
						        <input type=\"submit\" class=\"btn_delmsg\"  value=\"\" /></form>";
                                                        
						echo "<div class=\"msgdetails\">";
						echo $val[0];
                                               
						
						echo "</div>";
				        echo "</div>";
						$count++;
						
						if($count==40)
							break;
					     }	
				
				          echo "</div>";
				        }
//---------------------------------------------------------------------------------------------------------- -----				     
				        
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
				       {
				               echo "<div id=\"mainimgbox\"><br/><img src=$result_pic[0] ></img>";
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
                                        echo "<a href=\"../profile?id=$username&pid=photos&photo=$val[0]\"><img src=\"$thumb\" width=65></img></a>";
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
		
		       	
				        
				      else
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
				        echo "<div class=\"profdetail\">  About Me: </div><br/>  $result_profile[5]<br/><br/>";
				        echo "</div>";
				        echo "</div>";
                                        }
				        ?>
			        </div>
			   </div>
			</div>
	
				
		</div>
	</div>
</body>


</html>
