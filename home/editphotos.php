 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php 

        session_start();
        if($_SESSION['authuser']!=1)
                header("Location:../index.php");
      
      		        $cur=$_POST['pno'];
			if(!($cur>1))
			        $cur=1; 
                        
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
<?php  echo "<body";
  if($cur>3) echo "onLoad=\"javascript:scrollTo(0,parseInt(document.body.clientHeight))\";";
  echo ">"; 
  ?>
<?php
   include('../lib/header.php');
    getheader();
    ?>


<div class=globalcontainer>

	
      <div class="wrapper">
      <div id="contenthead">Edit Photos</div><br/><br/>
      <div id="editpicbox">
		<?php
			echo "<div id=\"uploadoption\">";
			echo "<br/>Select image to upload (Image type:jpg,jpeg,gif Maximum size=5MB) :<br/>";

			echo "<form action=\"uploadpic.php\" method=\"post\" enctype=\"multipart/form-data\">
			    		 <input type=\"file\" name=\"image\"/>
				      <input type=\"submit\" value=\"Upload\"/>
				       </form><br/>";
		        echo "</div>";
			
			include('../lib/connectionfile.php');
			
			$sql=dbconfn()->prepare("SELECT * from w_photos where username='$_SESSION[username]' order by up_date_time desc");
			$sql->execute();
			$pic=$sql->fetchAll();
			$count=0;
			$num=0;
			//echo $count;
			echo "<table id=\"picedit\">";
			
	
			foreach($pic as $row1=>$val)
			{	
				if(($val[1]!="")||($thumb!=""))
				{
				
				
					$str=explode(".",$val[1]);
					//print_r($str);
					$thumb="..".$str[2]."_t.".$str[3];
				
				
				
				echo "<tr id=\"piceditrow\">
						<td id=\"piceditleft\" width=\"600px\"> 
						<form action=\"updatepicinfo.php\" method=\"post\">
						
						<input type=\"hidden\" name=\"photoid\" value=\"$val[0]\"/>
						Title:<input type=\"text\" name=\"title\" value=\"$val[2]\"/><br/>
						Description<br/>
						<textarea name=\"description\" style=\"resize:none\" cols=50 rows=7>$val[3]</textarea><br/>
						<input type=\"submit\" value=\"Update\"/><br/>
						</form>
						<br/>
						<form action=\"deletepic.php\" method=\"post\">
						<input type=\"hidden\" name=\"photoid\" value=\"$val[0]\"/>
						Delete Picture : <input type=\"submit\" value=\"Delete\"/>
						</form>
						 </td>
					<td id=\"piceditright\"> <img src=\"$thumb\"/> </td>
					</tr>";
				$count++;
				$num++;
				if($count==(6*($cur)))
				{
					break;
				}
				}		
			
			}
			
			echo "</table><br/>";
			 
			$cur++;    
			if($pic)
			{
			        echo "<form action=\"editphotos.php\" method=\"POST\">
			        <input type=\"hidden\" name=\"pno\" value=$cur />
			        <input type=\"submit\" value=\"More\"/>
			        </form>";
			}
			
			
					

		?>
	</div>
	</div>
</div>
	
</body>
</html>
