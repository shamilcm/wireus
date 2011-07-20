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




	
      <div class="wrapper">
      <div id="contenthead">Edit Own Group</div></br></br>
      <div id="groupeditbox">
      <?php
      
      		include('../lib/connectionfile.php');
      		
      		//echo $_POST['groupid'];
      		$sql=dbconfn()->prepare("SELECT * from w_groups where groupid='$_POST[groupid]'");
      		$sql->execute();
      		
      		$res=$sql->fetch();
      		
      		echo "<form action=\"updategroup.php\" method=\"post\" id=\"groupinfo\">
      		<input type=\"hidden\" name=\"groupid\" value=\"$res[0]\"/>
      		</br>Group Name : </br><div class=\"editinput\"><input type=\"text\" name=\"name\" value=\"$res[1]\"/></div>
      		</br>Group Description : </br><div class=\"editinput\"><textarea name=\"description\" style=\"resize:none\" cols=70 rows=5>$res[2]</textarea></div>
      		
      		</br>Group Type : <div><select name=\"type\">
      		<option value=\"O\" "; 
      		if($res[3]=='O') echo "selected=\"selected\"";
      		echo ">Open</option>
      		<option value=\"P\" ";
      		if($res[3]=='P') echo "selected=\"selected\"";
      		echo ">Private</option></select></div>
      		</br><input type=\"submit\" value=\"Update\"/>     
      		</form>";
      		
      		echo "</br><div>Delete Group Permanently : ";
      		echo "<form action=\"deleteowngroup.php\" method=\"post\"><input type=\"hidden\" name=\"delgpid\" value=\"$res[0]\"/><input type=\"submit\" value=\"DELETE\"/></div>";
      
      
      ?>
      </div>
      </div>
      
</div>
</body>
</html>
