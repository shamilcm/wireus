<?php 

        session_start();
        if($_SESSION['authuser']!=1)
                header("Location:../index.php");
      ?>  
<?php
session_start(); 
//w3 schools

$dir="../images/profiles/";

if ((($_FILES["image"]["type"] == "image/gif")
|| ($_FILES["image"]["type"] == "image/jpeg")
|| ($_FILES["image"]["type"] == "image/pjpeg"))
&& ($_FILES["image"]["size"] < 5000000))
  {
  if ($_FILES["image"]["error"] > 0)
    {
    echo "Return Code: " . $_FILES["image"]["error"] . "<br />";
    }
    else
    {
    
         
    
    /*
    echo "Upload: " . $_FILES["image"]["name"] . "<br />";
    echo "Type: " . $_FILES["image"]["type"] . "<br />";
    echo "Size: " . ($_FILES["image"]["size"] / 1024) . " Kb<br />";
    echo "Temp image: " . $_FILES["image"]["tmp_name"] . "<br />";
    */
    
    if(is_uploaded_file($_FILES['image']['tmp_name'])) {
    //echo "File ". $_FILES['image']['name'] ." uploaded successfully.\n";
       $ext = findexts($_FILES["image"]["name"]) ;
       //echo $ext;
       //echo $_SESSION['username'];
       //echo $_FILES['image']['tmp_name'];
       $_FILES["image"]["name"]=$_SESSION['username'].".".$ext;
       //echo $_FILES["image"]["name"];
      
      move_uploaded_file($_FILES["image"]["tmp_name"],$dir.$_FILES["image"]["name"]);
      //echo "Stored in: " . $dir . $_FILES["image"]["name"];
      
      include('../lib/connectionfile.php');
      
      $picdir="../images/profiles/".$_FILES["image"]["name"];
      //echo $picdir;
      $sql1="UPDATE w_profiles SET profpic='$picdir' WHERE username='$_SESSION[username]'";
      $count=dbconfn()->prepare($sql1);
      $count->execute();
      //$count=dbconfn()->exec("UPDATE w_profiles set profpic='$picdir' where username='$_SESSION['username']'");
     //echo $count;

       $a=resizeImage($picdir,350,350);
       imagejpeg($a,$picdir);
       

     
     header('Location:../home?profile='.$_SESSION['username']);
    }
    
    
  }
  }
else
  {
  echo "Invalid image";
  }
  
  
function findexts ($filename)
{
	if (is_dir($filename)) { return; }
	$filename = strtolower($filename) ;
	$exts = split("[/\\.]", $filename) ;
	$n = count($exts)-1;
	$exts = $exts[$n];
	return $exts;
} 

function  resizeImage($originalImage,$toWidth,$toHeight){
    
    // Get the original geometry and calculate scales
    list($width, $height) = getimagesize($originalImage);
    $xscale=$width/$toWidth;
    $yscale=$height/$toHeight;
    
    // Recalculate new size with default ratio
    if ($yscale>$xscale){
        $new_width = round($width * (1/$yscale));
        $new_height = round($height * (1/$yscale));
    }
    else {
        $new_width = round($width * (1/$xscale));
        $new_height = round($height * (1/$xscale));
    }

    // Resize the original image
    $imageResized = imagecreatetruecolor($new_width, $new_height);
    $imageTmp     = imagecreatefromjpeg ($originalImage);
    imagecopyresampled($imageResized, $imageTmp, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
	
	
    return $imageResized;
    
}


?>
