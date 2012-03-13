<?php

//header("ETag: PUB" . time());
//header("Last-Modified: " . gmdate("D, d M Y H:i:s", time()-10) . " GMT");
//header("Expires: " . gmdate("D, d M Y H:i:s", time() + 5) . " GMT");
//header("Pragma: no-cache");
//header("Cache-Control: max-age=1, s-maxage=1, no-cache, must-revalidate");

session_cache_limiter("nocache");
ob_start();
session_start();

if (!isset ($__installer_mode)) {
	require_once ("inc/config.php");
	//	include("email.php");
}
if (isset ($_COOKIE['cookname'])) {
	$vname = check_input($_COOKIE['cookname']);
	$vpass = check_input($_COOKIE['cookpass']);
	$result = mysql_query("select * from users where username='$vname' and password='$vpass'");
	if (mysql_num_rows($result) == 0) {
		header("Location: logout.php");
		exit;
	} else {
		while ($row = mysql_fetch_assoc($result)) {
			$auth_id = $row['userid'];
			$auth_gid = $row['usergid'];
			$auth_name = $row['username'];
			$auth_pass = $row['password'];
			$auth_status = $row['status'];
		}
	}
} else {
	$auth_id = $_SESSION['userid'];
	$auth_gid = $_SESSION['usergid'];
	$auth_name = $_SESSION['username'];
	$auth_pass = $_SESSION['password'];
	$auth_status = $_SESSION['status'];
}
if (!$auth_id || empty ($auth_id) || $auth_id == "") {
	$auth_id = 0;
}
if (!$auth_gid || empty ($auth_gid) || $auth_gid == "") {
	$auth_gid = 0;
}
require_once ("inc/limits.php");
?>
