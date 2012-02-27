<?php

header("ETag: PUB" . time());
header("Last-Modified: " . gmdate("D, d M Y H:i:s", time()-10) . " GMT");
header("Expires: " . gmdate("D, d M Y H:i:s", time() + 5) . " GMT");
header("Pragma: no-cache");
header("Cache-Control: max-age=1, s-maxage=1, no-cache, must-revalidate");
session_cache_limiter("nocache");

ob_start();
session_start();

if ((file_exists('../install.php')) ||  (file_exists('../upgrade.php'))){
    die('Please remove the files install.php and upgrade.php if you already used them!');
} 

require_once("../inc/config.php"); 

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



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title><?=$config[SiteName]?> | Admin Control Panel</title>
<link rel="shortcut icon" href="<?=$server_url?>/i/favicon.ico" />

<link href="<?=$server_url?>/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?=$server_url?>/lib/cpaint2.inc.js"></script>
<script type="text/javascript" src="<?=$server_url?>/lib/staff.js"></script>

</head>
<body>
<div id="full"> 

    <div id="header">
        <img src="<?=$server_url?>/i/logo.jpg" alt="logo" align="left"/>
        
    </div>



<? if ($auth_id){ // member Links?>

        <div class="nav">
            <ul>
			
<li><a href="<?=$server_url?>/index.php" title="Home">Home</a></li>
<li><a href="<?=$server_url?>/myimages.php" title="My Photos">My Photos</a></li>
<li><a href="<?=$server_url?>/gallery.php" title="Gallery">Gallery</a></li>
<li><a href="<?=$server_url?>/profile.php" title="Profile">Profile</a></li>
<li><a href="<?=$server_url?>/faq.php" title="FAQ">F.A.Q</a></li>
<li><a href="<?=$server_url?>/terms.php" title="Terms">Terms</a></li>												
<li><a href="logout.php" title="Log Out">Log Out</a></li>


                       <li class="last"></li>
            </ul>
            <div class="clr"></div>
			        </div>       

<?}  else { // guest links?>

        <div class="nav">
            <ul>
			
			
<li><a href="<?=$server_url?>/index.php" title="Home">Site Home</a></li>
<li><a href="login.php" title="Login">Staff Login</a></li>

                       <li class="last"></li>
            </ul>
            <div class="clr"></div>
			        </div>

<?}?>	


		
<? if ($auth_gid=="1")
                {  // admin links
?>				

        <div class="nav"><br />	
            <ul>
			
<li><a href="index.php">Statistics</a></li>  
<li><a href="images.php">Manage Images</a></li>
<li><a href="users.php">Manage Users</a></li>
<li><a href="reports.php">Abuse Reports</a></li>
<li><a href="blocked.php">Blocked IPS</a></li> <br>
<li><a href="settings.php">Settings</a></li>
<li><a href="ad_manager.php">Ad Manager</a></li>
<li><a href="servers.php">Servers</a></li>  
<li><a href="cleaner.php">Image Cleaner</a></li>  


				
                       <li class="last"></li>
            </ul>
            <div class="clr"></div>
			        </div>     		

<?php
}
?>	


<? if ($auth_gid=="2")
                {  // moderator links
?>				

        <div class="nav"><br />	
            <ul>
			
<li><a href="index.php">Statistics</a></li>  
<li><a href="images.php">Manage Images</a></li>
<li><a href="users.php">Manage Users</a></li>
<li><a href="blocked.php">Blocked IPS</a></li> 
<li><a href="reports.php">Abuse Reports</a></li>

				
                       <li class="last"></li>
            </ul>
            <div class="clr"></div>
			        </div>     		

<?php
}
?>	




        <div id="content">  		
		    <div id="wrapper">    
