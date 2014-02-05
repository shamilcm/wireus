<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php

session_start();
if (isset($_SESSION['authuser'])) 
{
	if($_SESSION['authuser']==1)
	{
		header("Location:home?profile=$_SESSION[username]");
		exit;
	}
}

if (isset($_GET['xid'])) 
{
	$id = $_GET['xid'];
	if(!($id>=1 && $id<=8))
	{
		$id=0;
	}
}
else
{
	$id = 0;
}
         
?>
<html>

<head>
<link rel="icon" href="favicon.ico">
<title> Wireus </title>

<link rel="stylesheet" type="text/css" href="themes/style.css">

<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript">
   
    
$(document).ready(function(){
   
    var x = <?php echo $id;?>;
   
    if(!(x>=2 && x<=8))
     {  $("#register_box").hide();
        $("#signinbutton").hide();
      
        if(x==1)
             $("#loginerror").css("display","block");
       
      }
    else if(x!=0)
     {
        $("#login_box").css("display","none");
        $("#register_box").css("z-index",8)
        $("#registerbutton").hide();  
        $(".errorbox").show();
        $("#xid"+x).show();
     }
    
       $("#btn_register").click(function(){
    
  		$("#register_box").css("display","none");
  		$("#register_box").css("z-index",1);
  		$("#login_box").fadeOut(1000);
  		$("#register_box").fadeIn(1000);
  		$("#registerbutton").hide();
  		$("#signinbutton").show();
  		$("#xid"+x).fadeOut(1000);
  		$(".errorbox").fadeOut(1000);
  		xid = 0;
  		
  		
  		});
  	$("#btn_signin").click(function(){
              
  		$("#login_box").css("display","none");
  		$("#login_box").css("z-index",1);
  		$("#register_box").fadeOut(1000);
  		$("#login_box").fadeIn(1000);
  		$("#signinbutton").hide();
  		$("#registerbutton").show();
  		$("#xid"+x).fadeOut(1000);
  		$(".errorbox").fadeOut(1000);
  		xid = 0;
  	     });
  		  
});
</script>
</script> 
</link>

</head>

<body>

<div class=globalcontainer>

        <div class="wrapper">
                 <div class="topbox">               
                                <div id="registerbutton" class="cornerbutton">  
                                <span>Not a member yet?</span>
	                	<button id="btn_register" class="btn_front"> 
	                	<span> Register </span>
	                	</button> 
	                	
	                        </div>
	                        <div id="signinbutton" class="cornerbutton">  
                                <span>Already a member?</span>
	                	<button id="btn_signin" class="btn_front"> 
	                	<span> Sign In </span>
	                	</button> 
	                        </div>
	        </div>
                <div class="centerbox">	
                	<div id="logo">
	                <img src="images/img_mainlogo.png" width="450"></img>
                	  </div>
	
	                <div id="login_box" class="rt_box"> 
	                   
	                    <div class="login_form_container">
	                    <form action="loginnext.php" method="post" id="login_form">
	                        <span class="error" id="loginerror">Invalid Username/Password </span> 
	                        <div class="formlabel">Username
	                        </div>
			        <div class="input_wrapper">
			        <input type="text" name="username" id="login_username"/>
			        </div>
			        <div class="formlabel">Password
			        </div>    
			        <div class="input_wrapper">
	               	        <input type="password" name="password" id="login_password"/> 
	                	</div>
	                         <div id="loginformbutton" class="formbutton">
	                         <input type="submit" class="btn_form" id = "btn_formenter" value="Enter">
                                 </div>
       	                         </form>
	                   </div>
	
	                </div>
	                
	                <div id="register_box" class="rt_box">
	 	            	<div class="errorbox" id="reg"> </div>
	 	            	<span class="regerror" id="xid2">USERNAME MUST BE ALPHA NUMERIC</span>
	                        <span class="regerror" id="xid3">USERNAME IS ALREADY TAKEN</span>
	                        <span class="regerror" id="xid4">EMAIL ID IS ALREADY REGISTERED</span>
	                        <span class="regerror" id="xid5">PASSWORDS DO NOT MATCH</span>
	                        <span class="regerror" id="xid6">PLEASE ENTER A USERNAME</span>
	                        <span class="regerror" id="xid7">PLEASE ENTER A PASSWORD</span>
	                        <span class="regerror" id="xid8">PLEASE ENTER AN EMAIL ADDRESS</span>

	 	            <div class="register_form_container">
	                         
	                        <form action="registernext.php" method="post" id="register_form">

	                        <div class=reginputcontainer>
	                               
	                                <div class="regformlabel">USERNAME
	                                </div>
			                <div class="reginput_wrapper">
			                <input type="text" name="reg_username" maxlength=15 id="reg_username"/>
			                </div>
			        </div>
			       
			        
			        
			         <div class=reginputcontainer>
			      
			                <div class="regformlabel">PASSWORD
			                </div>   
			                <div class="reginput_wrapper">
	               	                <input type="password" name="reg_password1" maxlength=20 id="reg_password1"/> 
	                	        </div>
	                	       
	                	</div>	 
	                	<div class=reginputcontainer>             
	                                <div class="regformlabel">RE-TYPE PASSWORD
	                                </div>
			                <div class="reginput_wrapper">
			                <input type="password" name="reg_password2" maxlength=20 id="reg_password2"/>
			                </div>
			   
			                
			         </div>
			         <div class=reginputcontainer> 
			                <div class="regformlabel">EMAIL ADDRESS
			                </div>   
			                <div class="reginput_wrapper">
	               	                <input type="text" name="reg_email" maxlength=30 id="reg_email"/> 
	                	        </div>
	                	 </div>
	                                 <div class="formbutton" id="regformbutton">
	                                 <input type="submit" class="btn_form" id="btn_formregister" value="Register">
                      
                                        </div>

       	                         </form>
       	                         
	                   </div>
	                
	             </div>
		  </div>
		  <div class="bottombox">
		        <div id="bottomline"> </div>
		        <div id="copyright">
	                <span> WIREUS Inc. Developed by  Sreeraj and Shamil. <a style="text-decoration:none; flot:right;" href="http://github.com/shamilcm/wireus">http://github.com/shamilcm/wireus</a></span>
		        </div>
		        
		        
		        <div id="linkbox">
		       
		  <!--    
		        <a href="about.php">About</a>
		        . 
		        <a href="privacy.php">Privacy</a>
		         . 
		        <a href="help.php">Help</a>
		        -->
		        </div>
		  </div> 
	                
          </div>
		
</div>

</body>
</html>

