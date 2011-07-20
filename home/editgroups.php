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
      <div id="contenthead">Edit Groups</div></br></br>
      <div id="editgroupbox">
      	<?php
      		
      		include('../lib/connectionfile.php');
      		
      		echo "<div><div>Create your own group!!</div>";
      		echo "<div><form action=\"creategroup.php\" method=\"post\"><input type=\"submit\" value=\"Create Now\"/></form></div></div>";
      		
      		echo "</br><div><div> Groups you are a member of :</div>";
      		$sql=dbconfn()->prepare("SELECT g.name,g.groupid,g.owner from w_groups g,w_membership m where g.groupid=m.groupid and m.username='$_SESSION[username]' and status='A'");
      		
      		$sql->execute();
      		$gpm=$sql->fetchAll();
      		echo "<table id=\"grouptable\">";
      		foreach($gpm as $row1=>$val)
      		{	
      			echo "<tr id=\"grouptable\">";
      			echo "<td id=\"grouptable\"><a href=\"../groups?id=$val[1]\">".$val[0]."</a></td>";
      			echo "<td id=\"grouptable\"><form action=\"unjoingroup.php\" method=\"post\">
      			<input type=\"hidden\" name=\"groupid\" value=\"$val[1]\"/>";
      			if($val[2]!=$_SESSION[username])
      			        echo "<input type=\"submit\" value=\"Unjoin\"/>";
      			echo "</form></td>";
      			echo "</tr>";
      		}
      		
      		echo "</table>";
      		echo "</div></br>";
      		echo "<div><div>Groups you own :</div>";
      		
      		$sql1=dbconfn()->prepare("SELECT name,groupid from w_groups where owner='$_SESSION[username]'");
      		$sql1->execute();
      		$gpo=$sql1->fetchAll();
      		echo "<table id=\"grouptable\">";
 
      		foreach($gpo as $row2=>$val1)
      		{
      			echo "<tr id=\"grouptable\">";
      			echo "<td id=\"grouptable\"><a href=\"../groups?id=$val1[1]\">".$val1[0]."</a></td>";
      			echo "<td id=\"grouptable\"><form action=\"editowngroup.php\" method=\"post\">
      			<input type=\"hidden\" name=\"groupid\" value=\"$val1[1]\"/>
      			<input type=\"submit\" value=\"Edit Group Details\"/>
      			</form></td>";
      			
      			echo "</tr>";
      
      		}
      		echo "</table>";
      		echo "</div></br>";
      		
      		
      ?>
      </div>
      </div>
</div>
