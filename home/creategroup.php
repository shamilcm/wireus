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
    $("#photobox").hide();
    $("#groupbox").hide();
    
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

	
      <div class="wrapper">
      <div id="contenthead">Create Own Group</div></br></br>
      <div id="creategroupbox">
      
                
      		      		
      		<form action="insertnewgroup.php" method="post">
      		</br>Group Name : </br><div><input type="text" name="name"></div>
      		</br>Group Description : </br><div><textarea name="description" style="resize:none" cols=70 rows=5></textarea></div>
      		
      		</br>Group Type : <div><select name="type">
      		<option value="O">Open</option>
      		<option value="P">Private</option></select></div>
      		</br><input type="submit" value="Create Group"/>     
      		</form>
      		
      		<?php
      			if($_GET['id']==1)
      			{
      				echo "</br><div>The following files are mandatory : 'Group Name' </div>";
      			}
      		
      		
      		?>      		
      		     
      
      </div>
      </div>
      
</div>
