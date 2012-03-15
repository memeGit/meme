<?php
session_start();

$uid = $_COOKIE["iuserid"];
$uname = $_COOKIE["iusername"];
$utoken = $_COOKIE["iusertoken"];
$usecret = $_COOKIE["iusersecret"];
mysql_connect('localhost', 'root', '');
mysql_select_db('freeimage');
$query = mysql_query("SELECT * FROM iusers WHERE oauth_provider='weibo'" .
" AND oauth_uid=" . '{$uid}' .
" AND username=" . '{$uname}' .
" AND oauth_token=" . '{$utoken}' .
" AND oauth_secret=" . '{$usecret}');
$result = mysql_fetch_array($query);
if (!empty ($result)) {
	$_SESSION['is_ilogin'] = 1;
	header('Location: index.php');
}

include_once ('config.php');
include_once ('saetv2.ex.class.php');
$o = new SaeTOAuthV2(WB_AKEY, WB_SKEY);
$code_url = $o->getAuthorizeURL(WB_CALLBACK_URL);

require "imagesharing/header2.php";
if (isset ($_POST['uname'])) {

	$msg = "";
	if ($_POST['uname'] == "") {
		$msg .= "<br />User Name cannot be left empty!<br />";
	}
	if ($_POST['pass'] == "") {
		$msg .= "<br />Password cannot be left empty!<br />";
	} else {

		$po_uname = check_input($_POST['uname']);
		$po_pass = md5($_POST['pass']);

		$query = sprintf("select * from users where username='$po_uname' and password='$po_pass'");
		$result = mysql_query($query);
		//	print_r($query);
		if (mysql_num_rows($result) == 0) {
			$msg .= "Wrong login details entered!";
			@ mysql_close();
		} else {
			while ($row = mysql_fetch_assoc($result)) {
				$auth_id = $row['userid'];
				$auth_gid = $row['usergid'];
				$auth_name = $row['username'];
				$auth_pass = $row['password'];
				$auth_status = $row['status'];
			}
			if ($auth_status == '0') {
				$msg .= "This account is not active, Please activate the account first!";
				@ mysql_close();
			}

			if ($auth_status == '2') {
				$msg .= "This account is suspended by site admin!";
				@ mysql_close();
			}

			if ($auth_status == '1') {
				session_start();
				$_SESSION['userid'] = $auth_id;
				$_SESSION['usergid'] = $auth_gid;
				$_SESSION['username'] = $auth_name;
				$_SESSION['password'] = $auth_pass;
				$_SESSION['status'] = $auth_status;

				@ mysql_close();
				if (isset ($_POST['remember'])) {
					setcookie("cookname", $auth_name, time() + 60 * 60 * 24 * 30, "/");
					setcookie("cookpass", $auth_pass, time() + 60 * 60 * 24 * 30, "/");
				}

				header("Location: index.php");
				exit;
			}
		}
	}
} // if post
?>

<!DOCTYPE html>
<html lang="en" xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml">

<head>
<title>Just for Fun!</title>
<!--nemo:
<link rel="shortcut icon" href="img/favicon.gif" />-->
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<meta content="width=device-width; initial-scale=1.0;" name="viewport" />
<link rel="stylesheet" href="./9gag_static/https@d24w6bsrhbeh9d.cloudfront.net/css/screen-v5.3.9.css" media="screen,projection" type="text/css" />

<script type="text/javascript" src="./9gag_static/https@d24w6bsrhbeh9d.cloudfront.net/js/mootools/mootools-1.3.1-yui-compressed.js"></script>
<script type="text/javascript" src="./9gag_static/https@d24w6bsrhbeh9d.cloudfront.net/js/Libraries-v1.3.js"></script>
<script type="text/javascript" src="./9gag_static/https@d24w6bsrhbeh9d.cloudfront.net/js/gag.min-v2.5.3.js"></script>

</head>

<body id="page-signup">
<div class="signup-login-wrap">
   <a class="signup-login-btn" href="signup.php">New to 9GAG? <b>Join today!</b></a>
	<div class="header">
		<a href="index.php"><h1>9gag</h1></a>
	</div>
	<div class="content">
		<div class="description">
			<h2>Awww Yeah! Welcome back.</h2>
			<div class="special-btn-wrap">

				<a href="<?=$code_url?>"><img src="weibo_login.png" title="点击进入授权页面" alt="点击进入授权页面" border="0" /></a>

				<!--
				<a class="special-btn facebook badge-facebook-connect" label="LoginFormFacebookButton" next="" href="javascript:void(0);">Login with Facebook</a>
				-->
			</div>
			<p class="message"> </p>
		</div>

		<form id="form-signup-login" class="generic" action="<?= $_SERVER['PHP_SELF'] ?>" method="post" onsubmit="return GAG.Login.validateLogin();">
            <input type="hidden" id="csrftoken" name="csrftoken" value="d8d1d0aef1ee011bb52f8c2ead09a5a6"/>
			<div id="login-username-block" class="field">
				<label>帳戶名稱 或 電郵地址				</label>
				<input id="login-username" type="text" class="text" name="username" placeholder="帳戶名稱 或 電郵地址" tabindex="1" maxlength="200"/>
			</div>


			<div id="login-password-block" class="field">
				<label>密码

                				<span>(<a href="recover.php">Forgot<span class="badge-js" style="color:#00a5f0;" key="?"></span></a>)</span>


				</label>
				<input id="login-password" type="password" class="text" name="password" placeholder="密码" tabindex="3" maxlength="32"/>
			</div>
			<div class="action">
				<input type="hidden" name="next" value=""></input>
				<input id="login-submit-type" type="hidden" name="type" value="login"></input>
				<input id="login-submit" type="submit" class="submit-button" value="登录"></input>
			</div>
						<p id="login-msg" class="message red" style="display:none;"></p>
		</form>
	</div>
</div>
<div style="display:none;">
<span id="siteDomain">9gag.com</span>
<span id="backUrl">%2Flogin</span>
<span id="fb-app-id">111569915535689</span>
<span id="fbTimelineApi">ninegag:laugh_at?funny_post</span>
</div>

<div id="fb-root"></div>
<script src="./9gag_static/https@connect.facebook.net/en_US/all.js" type="text/javascript"></script>

<noscript>
<div style="display:none;">
<img src="./9gag_static/https@pixel.quantserve.com/pixel/p-f8Bn5MbvAQbXQ.gif" border="0" height="1" width="1" alt="Quantcast"/>
</div>
</noscript>

	</body>
</html>


