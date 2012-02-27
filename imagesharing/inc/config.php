<?php

include("db.php");

$link = mysql_connect($db_server, $db_user, $db_password) or die("Could not connect");

mysql_select_db($db_name) or die("Could not select database");

$query = "SELECT * from config";

$result = mysql_query($query) or die("Query failed");

while ($row = mysql_fetch_assoc($result)) { 

        $config[$row['soption']]=$row['svalue'];

}

$site_name = $config['SiteName'];

	$sql="select * from users where userid='1'";
	
	$result = mysql_query($sql) or die("Query failed.");
	while ($row = mysql_fetch_array($result)) 
	{
		$support_email=$row['email'];		
	}

$server_url = $config['SiteUrl'];


// config options

$version = $config['ScriptVersion'];
$uploads = $config['Uploads'];
$registration = $config['MemberRegistration'];
$validation = $config['EmailValidation'];
$ads = $config['Advertisements'];
$watermarking = $config['Watermarking'];
$HotLink = $config['Hotlinking'];
// thumbnail settings

$dest_height = $config['ThumbHeight'];

$dest_width = $config['ThumbWidth'];


$server_root = $config['SiteRoot'];

$server_directory = "";

$server_save_directory = $server_directory . "/images/"; //      /folder/     





// do not change the following variables
//global $server_dir;

$server_dir = $server_root . $server_save_directory;

$page_url = $server_url . $server_directory;

$image_url = $server_url . $server_save_directory;


$valid_mime_types_display = $config['Extension'];

$valid_file_ext=explode(",",$config['Extension']);


function getSize($imageurl)
{
    if ( intval(phpversion()) < 5 )
        die ( 'PHP5 Required' );
    
    $headers = get_headers($imageurl, 1);
    return $headers['Content-Length'];
} 



/*
function validate_username($v_username) {
   return eregi('[^0-9a-z _-]', $v_username) ? 'Invalid' : 'Valid';
}
if (eregi("[^0-9a-z _-]", $string)) {
echo "Error: String can only contain letters and numbers!";
exit();
}*/

function check_input($value){
$value = trim($value);
if (get_magic_quotes_gpc()){$value = stripslashes($value);}
if (!is_numeric($value)){$value = mysql_escape_string(strip_tags($value));}
if (is_numeric($value)){$value = intval($value);}
//$value = preg_replace("/[^0-9a-z _-]/i",'', $value);
return $value;
}
?>