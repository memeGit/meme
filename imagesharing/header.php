<?php

header("ETag: PUB" . time());
header("Last-Modified: " . gmdate("D, d M Y H:i:s", time()-10) . " GMT");
header("Expires: " . gmdate("D, d M Y H:i:s", time() + 5) . " GMT");
header("Pragma: no-cache");
header("Cache-Control: max-age=1, s-maxage=1, no-cache, must-revalidate");
session_cache_limiter("nocache");

ob_start();
session_start();


if(!isset($__installer_mode)){
	require_once("inc/config.php");
//	include("email.php");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="description" content="<?=$config[MetaDesc]?>" />
<meta name="keywords" content="<?=$config[MetaWords]?>" />

<?

if(isset($_COOKIE['cookname'])){

 $vname = check_input($_COOKIE['cookname']); 
 $vpass = check_input($_COOKIE['cookpass']); 

 $result = mysql_query("select * from users where username='$vname' and password='$vpass'");
	
	if(mysql_num_rows($result) ==0) {
	header("Location: logout.php");
	exit;
	}

else {	
	while ($row = mysql_fetch_assoc($result)) { 				
			$auth_id=$row['userid'];
			$auth_gid=$row['usergid'];						
			$auth_name=$row['username'];
			$auth_pass=$row['password'];
			$auth_status=$row['status'];
	}


	}

	}
	
	else {

$auth_id=$_SESSION['userid'];
$auth_gid=$_SESSION['usergid']; 
$auth_name=$_SESSION['username'];
$auth_pass=$_SESSION['password'];
$auth_status=$_SESSION['status'];
}
if (!$auth_id || empty($auth_id) || $auth_id==""){
	$auth_id = 0;
}
if (!$auth_gid || empty($auth_gid) || $auth_gid==""){
	$auth_gid = 0;
}
	require_once("inc/limits.php");

?>


<title><?=$site_name?></title>


<link rel="shortcut icon" href="<?=$server_url?>/i/favicon.ico" />
<link href="<?=$server_url?>/style.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="<?=$server_url?>/lib/cpaint2.inc.js"></script>
<script language="javascript" type="text/javascript" src="<?=$server_url?>/lib/upload.js"></script>
<script language="javascript" type="text/javascript" src="<?=$server_url?>/lib/user.js"></script>

</head>
<body>
<div id="full"> 

    <div id="header">
                <img src="<?=$server_url?>/i/logo.jpg" width="250px" alt="logo" align="left"/>
                
        </div>
<div class="nav">
            <ul>

<? if ($auth_id){ // member Links?>

<li><a href="<?=$server_url?>/index.php" title="Home">Home</a></li>



<? if ($auth_gid=="1")
                {  // admin link
?><li><a href="<?=$server_url?>/admin/index.php">Admin</a></li> <?}?>


	 
<? if ($auth_gid=="2")
                {  // Moderator link
?><li><a href="<?=$server_url?>/admin/index.php">Moderator</a></li> <?}?>


<li><a href="<?=$server_url?>/myimages.php" title="My Photos">My Photos</a></li>
<li><a href="<?=$server_url?>/gallery.php" title="Gallery">Gallery</a></li>
<li><a href="<?=$server_url?>/profile.php" title="Profile">Profile</a></li>
<li><a href="<?=$server_url?>/faq.php" title="FAQ">F.A.Q.</a></li>
<li><a href="<?=$server_url?>/terms.php" title="Terms">Terms</a></li>												
<li><a href="<?=$server_url?>/logout.php" title="Log Out">Log Out</a></li>




<?}  else { // guest links?>
<li><a href="<?=$server_url?>/index.php" title="Home">Home</a></li>
<li><a href="<?=$server_url?>/register.php" title="Register">Register</a></li>
<li><a href="<?=$server_url?>/login.php" title="Login">Login</a></li>
<li><a href="<?=$server_url?>/gallery.php" title="Gallery">Gallery</a></li>
<li><a href="<?=$server_url?>/faq.php" title="FAQ">F.A.Q.</a></li>
<li><a href="<?=$server_url?>/terms.php" title="Terms">Terms</a></li>												


<?}?>


                       <li class="last"></li>
            </ul>
            <div class="clr"></div>

			        </div>       
        
        <div id="content">  			
 <?if (($ads == "1" && !$auth_id) || ($ads == "2") ) { ?> <center> <?=$config[header]?> </center> <br /><br /> <?}?>