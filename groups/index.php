<!-- GROUP PAGE -->



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
        $('#gridfriends').tableScroll({height:700, width:270});
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
              <?php
                        include('../lib/connectionfile.php');
                        $gid=$_GET['id'];
                        echo "<div class=\"friendlist\">";
				        $count=0;
				        $friendcount=0;
				        $sql_friends=dbconfn()->prepare("select username from w_membership where groupid=$gid and status='A';");
				        $sql_friends->execute();
				        $result_friends=$sql_friends->fetchAll(PDO::FETCH_NUM);
				        $friendcount=($sql_friends->rowCount());
				        echo "Members (".$friendcount.")<br/>";
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
                </div>
                         <div id="pageright">
			     
			     <div id="pagehead">
			        <?php
                                echo "<div id=\"pagetitle\">"; 
                                $username=$_SESSION['username'];
                                $sql_status=dbconfn()->prepare("select status from w_membership where groupid='$gid' and username='$username';");
                                $sql_status->execute();
                                $result_status=$sql_status->fetch();
                                $status=$result_status[0];
                                $sql_name=dbconfn()->prepare("select name,type,owner from w_groups where groupid='$gid'");
                                $sql_name->execute();
                                $result_name=$sql_name->fetch();
                                if($result_name[2]==$username)
                                        $status='O';
                                echo $result_name[0];
                                echo "</div>";
                                echo "<div id=\"friendrequestbox\">";
                        
                                if($status=='A')
                                 {   
                                       
                                        echo "<form action=\"../groupmembership.php\" method=\"POST\">";
                                        echo "<input type=\"hidden\" name=\"gid\" value=\"$gid\"/>";
                                        echo "<input type=\"hidden\" name=\"username\" value=\"$username\"/>";
                                        echo "<input type=\"hidden\" name=\"status\" value=\"$status\"/>";
                                        echo "<input type=\"submit\" value=\"Unjoin Group\" />";
                                        echo "</form>"; 
                                      }
                                else if($status=='O')
                                 {
                                     
                                        echo "<form action=\"../groupmembership.php\" method=\"POST\">";
                                        echo "<input type=\"hidden\" name=\"gid\" value=\"$gid\"/>";
                                        echo "<input type=\"hidden\" name=\"username\" value=\"$username\"/>";
                                        echo "<input type=\"hidden\" name=\"status\" value=\"$status\"/>";
                                        echo "<input type=\"submit\" value=\"Delete Group\" />";
                                        echo "</form>"; 
                                 }
                               else if($status=='R')
                                 {
                                        echo "Membership Requested";
                                        echo "<form action=\"../groupmembership.php\" method=\"POST\">";
                                        echo "<input type=\"hidden\" name=\"gid\" value=\"$gid\"/>";
                                        echo "<input type=\"hidden\" name=\"username\" value=\"$username\"/>";
                                        echo "<input type=\"hidden\" name=\"status\" value=\"$status\"/>";
                                        echo "<input type=\"submit\" value=\"Cancel Request\" />";
                                        echo "</form>"; 
                                 }    
                              
                              else
                               {
                                        if($result_name[1]=='P')                        //request for membership in a private group
                                          {
                                                echo "<form action=\"../groupmembership.php\" method=\"POST\">";
                                                echo "<input type=\"hidden\" name=\"gid\" value=\"$gid\"/>";
                                                echo "<input type=\"hidden\" name=\"username\" value=\"$username\"/>";
                                                echo "<input type=\"hidden\" name=\"status\" value=\"I\"/>";
                                                echo "<input type=\"submit\" value=\"Request Membership\" />";
                                                echo "</form>"; 
                                          }
                                       else                                             //join a public group
                                          {
                                                echo "<form action=\"../groupmembership.php\" method=\"POST\">";
                                                echo "<input type=\"hidden\" name=\"gid\" value=\"$gid\"/>";
                                                echo "<input type=\"hidden\" name=\"username\" value=\"$username\"/>";
                                                echo "<input type=\"hidden\" name=\"status\" value=\"J\"/>";
                                                echo "<input type=\"submit\" value=\"Join\" />";
                                                echo "</form>"; 
                                          }
                                   }
                              
                            
                       
                        echo "</div>";
                        echo "</div>";
                        ?>
                                <div class="status"><div id="statusmsg"></div></div>
                        
                     <div id="pagelinks">
				<?php

					if($_GET[pid]=="msgs")
						echo "<a id=\"clickmessages\" href=\"../groups?id=$gid&pid=msgs\"><img class=\"link\" src=\"../images/btn_msgs_h.png\" style=\"opacity:1;filter:alpha(opacity=100)\"
onmouseover=\"this.style.opacity=0.7;this.filters.alpha.opacity=70\"
onmouseout=\"this.style.opacity=1;this.filters.alpha.opacity=100\"/></a>";
					else
						echo "<a id=\"clickmessages\" href=\"../groups?id=$gid&pid=msgs\"><img class=\"link\" src=\"../images/btn_msgs.png\" style=\"opacity:1;filter:alpha(opacity=100)\"
onmouseover=\"this.style.opacity=0.7;this.filters.alpha.opacity=70\"
onmouseout=\"this.style.opacity=1;this.filters.alpha.opacity=100\"/></a>";
					if($_GET[pid]=="profile" || !$_GET[pid])
						echo "<a id=\"clickprofiles\" href=\"../groups?id=$gid&pid=profile\"><img class=\"link\" src=\"../images/btn_profiles_h.png\" style=\"opacity:1;filter:alpha(opacity=100)\"
onmouseover=\"this.style.opacity=0.7;this.filters.alpha.opacity=70\"
onmouseout=\"this.style.opacity=1;this.filters.alpha.opacity=100\"/></a>";
					else
						echo "<a id=\"clickprofiles\" href=\"../groups?id=$gid&pid=profile\"><img class=\"link\" src=\"../images/btn_profiles.png\" style=\"opacity:1;filter:alpha(opacity=100)\"
onmouseover=\"this.style.opacity=0.7;this.filters.alpha.opacity=70\"
onmouseout=\"this.style.opacity=1;this.filters.alpha.opacity=100\"/></a>";
	        		?><br/>
		      <div id="pagelinkbar" style="margin-top:11px;"></div>
		     </div><br/><br/>
                        <div id="pagecontent">
		        <?php

				        if($_GET['pid']=="msgs")
				        {
				        echo "<div class=\"contentwrapper\">";
				        echo "<div id=\"contenthead\">Messages</div>";
				        $count=0;
				      if($status=='O' || $status=='A')
				       { echo "<div id=\"sendmsgbox\">";
				        echo "<form action=\"../sendgrpmsg.php\" method=\"POST\">";
				        echo "<textarea style=\"resize: none;\" name=\"msg\" cols=80 rows=4 maxlength=180></textarea> ";
				        echo "<input type=\"hidden\" name=\"sender\" value=\"$_SESSION[username]\" />";
				        echo "<input type=\"hidden\" name=\"gid\" value=\"$gid\" /><br />";
				       echo "<input type=\"submit\" name=\"submit\" value=\"Post\" style=\"float:right;  height:25px; \"/>";
				        echo "</form>";
				         echo "</div>";
					}
					
//---------------------------------------------------------------------------------------------------------- 
					
					$sql_msgs=dbconfn()->prepare("select content,s_username,send_date_time,gmsgid from w_gmsgs where r_groupid='$gid' order by send_date_time desc");
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
						        
						if($val[1]==$_SESSION['username'] ||  $status=='O')                      //Current User
						       echo "<form style=\"display:inline;\" action=\"../deletegrpmsg.php\" method=\"POST\">
						       <input type=\"hidden\" name=\"gmsgid\"  value=\"$val[3]\" />
						       <input type=\"hidden\" name=\"returngrp\"  value=\"$gid\" />
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
				        
				        
				       else
				        {
				        echo "<div class=\"contentwrapper\">";
				        echo "<div id=\"contenthead\">Profile</div>";
				        
				        $sql_profile=dbconfn()->prepare("select description,type,owner,create_date_time from w_groups where groupid='$gid'");
					$sql_profile->execute();
					$result_profile=$sql_profile->fetch(PDO::FETCH_LAZY);
				        echo "<br/>";
				        echo "<br/>";
				        echo "<div id=\"profilebox\">";
				        echo "<div class=\"profdetail\">Description:</div>". $result_profile[0]."<br/><br/>";
				       
				        if($result_profile[1]=='O')
				                echo "<div class=\"profdetail\"> Type: </div>Open"."<br/><br/>";
				        else
				                 echo "<div class=\"profdetail\"> Type</div>: Moderated"."<br/><br/>";
				        echo "<div class=\"profdetail\">  Owner: </div>". $result_profile[2]."<br/><br/>";
				        $dt =date("F j, Y, g:i a",strtotime($result_profile[3]));
				        echo "<div class=\"profdetail\"> Created On:</div> $dt"."<br/><br/>";
				        echo "</div>";
				        echo "</div>";
				        
				        }
				        ?>
                                    
             </div>
           </div>
         </div>  
