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
	    <div id="contenthead">Edit Profile</div></br></br></br>
	    <div id="editbox">
	    <?php
	    include('../lib/connectionfile.php');
	    
	    $sql1=dbconfn()->prepare("select * from w_profiles where username='$_SESSION[username]'");
	    $sql1->execute();
	    $result=$sql1->fetch();
	    $d=$result[3];
	    $year=$d[0].$d[1].$d[2].$d[3];
	    $month=$d[5].$d[6];
	    $day=$d[8].$d[9];
	    
	    
	    echo "<form action=\"intoprofile.php\" method=\"post\" id=\"profileinfo\">";
	    if($_GET['xid']==1)
             		{
             			echo "</br></br><div id=\"editprofileerror\" class=\"error\">PLEASE ENTER YOUR FIRST NAME AND LAST NAME</div>";
            		 }
	    echo "</br>First Name:<div class=\"editinput\"><input type=\"text\" name=\"fname\" value=\"$result[1]\"/>
		    
		    
		    </div></br>Last Name:<div class=\"editinput\"><input type=\"text\" name=\"lname\" value=\"$result[2]\"/>
		    
		    
		    </div></br><div>Date of Birth: </br><table border=\"0\">
		    <th> Day : </th><td><select name=\"day\">";
		    for($i=01;$i<=31;$i++)
		    {
		    	echo "<option value=\"$i\" ";
		    	if($i==$day) echo "selected=\"selected\"";
		    	echo ">$i</option>";
		    }
		    echo "</select></td>
		    
		    <th> Month : </th><td><select name=\"month\">
		    <option value=\"01\" ";if($month=='01')echo "selected=\"selected\""; echo ">January</option>
		    <option value=\"02\" ";if($month=='02')echo "selected=\"selected\""; echo ">February</option>
		    <option value=\"03\" ";if($month=='03')echo "selected=\"selected\""; echo ">March</option>
		    <option value=\"04\" ";if($month=='04')echo "selected=\"selected\""; echo ">April</option>
		    <option value=\"05\" ";if($month=='05')echo "selected=\"selected\""; echo ">May</option>
		    <option value=\"06\" ";if($month=='06')echo "selected=\"selected\""; echo ">June</option>
		    <option value=\"07\" ";if($month=='07')echo "selected=\"selected\""; echo ">July</option>
		    <option value=\"08\" ";if($month=='08')echo "selected=\"selected\""; echo ">August</option>
		    <option value=\"09\" ";if($month=='09')echo "selected=\"selected\""; echo ">September</option>
		    <option value=\"10\" ";if($month=='10')echo "selected=\"selected\""; echo ">October</option>
		    <option value=\"11\" ";if($month=='11')echo "selected=\"selected\""; echo ">November</option>
		    <option value=\"12\" ";if($month=='12')echo "selected=\"selected\""; echo ">December</option>
		    </select></td>
		    
		    <th> Year : </th><td><select name=\"year\">"; 
		    for($j=2011;$j>=1900;$j--)
		    {
		    	echo "<option value=\"$j\" ";
		    	if($j==$year) echo "selected=\"selected\"";
		    	echo ">$j</option>";
		    }
		    echo "</select></td>
		    </table>
		    </div>
		    </br>Sex:</br><div>
		    <input type=\"radio\" name=\"sex\" value=\"Male\" ";
		    	if($result[4]=='Male') echo "checked=\"true\"";
		    	echo ">Male</input>
		    <input type=\"radio\" name=\"sex\" value=\"Female\" ";
		    	if($result[4]=='Female') echo "checked=\"true\"";
		    	echo ">Female</input>
		    
		    </div></br>About You: <div class=\"editinput\"></br><textarea name=\"bio\" style=\"resize:none\" cols=70 rows=5 >$result[5]</textarea>
		    
		    </div>
		    <div>
		    </br>
		    <input type=\"submit\" value=\"Update\"/>
		    </div>
		    
	    </form>";
	    echo "</br> Select profile picture </br>";
	    echo "<form action=\"upload.php\" method=\"post\" enctype=\"multipart/form-data\">
	    		 <input type=\"file\" name=\"image\"/>
                      <input type=\"submit\" value=\"Change\"/>
                       </form>";
            
	    
	    ?>
	    </div>
	    </div>
	    
	    
	    
	  </div>  
    
</body>
</html>
