<?php 

        session_start();
        if($_SESSION['authuser']!=1)
                header("Location:../index.php");
      ?>  
      
<?php
session_start(); 

$dir="../images/photos/";
if ((($_FILES["image"]["type"] == "image/gif")
|| ($_FILES["image"]["type"] == "image/jpeg")
|| ($_FILES["image"]["type"] == "image/JPG")
|| ($_FILES["image"]["type"] == "image/JPEG")
|| ($_FILES["image"]["type"] == "image/pjpeg"))
&& ($_FILES["image"]["size"] < 50000000))
  {
  if ($_FILES["image"]["error"] > 0)
    {
    echo "Return Code: " . $_FILES["image"]["error"] . "<br />";
    }
    else
    {
    
    if(is_uploaded_file($_FILES['image']['tmp_name'])) {
    //echo "File ". $_FILES['image']['name'] ." uploaded successfully.\n";
       $ext = findexts($_FILES["image"]["name"]) ;
       //echo $ext;
      
       include('../lib/connectionfile.php');
       $sql=dbconfn()->prepare("SELECT max(photoid) from w_photos");
       $sql->execute();
       $result=$sql->fetch();
       $cur=$result[0]+1;
       //echo $cur;
       
      $_FILES["image"]["name"]=$cur.".".$ext;
       //echo "</br>";
       //echo $_FILES["image"]["name"];
      
      move_uploaded_file($_FILES["image"]["tmp_name"],$dir . $_FILES["image"]["name"]);
      //echo "</br>Stored in: " . $dir . $_FILES["image"]["name"];
      
      
      
      $picdir="../images/photos/".$_FILES["image"]["name"];
      //echo $picdir;
      $up_date=date('Y-m-d H:i:s');
      //echo $up_date;
     
     $sql1="INSERT INTO w_photos(path,up_date_time,username) values ('$picdir','$up_date','$_SESSION[username]')";
      //echo $sql1;
      $count=dbconfn()->prepare($sql1);
      $count->execute();
      //echo $count;
      
    
      $a=resizeImage($picdir,350,350);
     
      $thumb="../images/photos/".$cur."_t.jpg";
     imagejpeg($a,$thumb);
     imagejpeg($picdir,$thumb);
     
     $b=resizeImage($picdir,100,100);
     $thumbt="../images/photos/".$cur."_tt.jpg";
      imagejpeg($b,$thumbt);
      imagejpeg($picdir,$thumbt);
  
     header('Location:editphotos.php');
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
