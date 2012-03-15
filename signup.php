<?
require "imagesharing/header.php";

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
?>

<!DOCTYPE html>
<html lang="en" xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml">

<!--

   ____                    __      __
  / __ \____ _____ _____ _/ /___  / /
 / /_/ / __ `/ __ `/ __ `/ / __ \/ /
 \__, / /_/ / /_/ / /_/ / / /_/ / /
/____/\__, /\__,_/\__, /_/\____/_/
     /____/      /____/

-->

<head>
<title>Just for Fun!</title>
<link rel="shortcut icon" href="img/favicon.gif" />
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<meta content="width=device-width; initial-scale=1.0;" name="viewport" />
<link rel="stylesheet" href="./9gag_static/https@d24w6bsrhbeh9d.cloudfront.net/css/screen-v5.3.9.css" media="screen,projection" type="text/css" />

<script type="text/javascript" src="./9gag_static/https@d24w6bsrhbeh9d.cloudfront.net/js/mootools/mootools-1.3.1-yui-compressed.js"></script>
<script type="text/javascript" src="./9gag_static/https@d24w6bsrhbeh9d.cloudfront.net/js/Libraries-v1.3.js"></script>
<script type="text/javascript" src="./9gag_static/https@d24w6bsrhbeh9d.cloudfront.net/js/gag.min-v2.5.3.js"></script>

</head>

<body id="page-signup">

<div class="signup-login-wrap">
   <a class="signup-login-btn" href="login.php">Have an account? <b>Sign in</b></a>
	<div class="header">
		<a href="index.php"><h1>9gag</h1></a>
	</div>
	<div class="content">
		<div id="signup-desc" class="description">
			<h2>Welcome to the best place for fun.</h2>
			<h3>Sign up now to explore new content <br/>and vote on your favourites.</h3>
			<div class="special-btn-wrap">
				<a href="<?=$code_url?>"><img src="weibo_login.png" title="点击进入授权页面" alt="点击进入授权页面" border="0" /></a>
				<!--<a class="special-btn facebook badge-facebook-connect" label="LoginFormFacebookButton" next="" href="javascript:void(0);">Sign up with Facebook</a>-->
			</div>
			<p class="message">
				We'll never post without your permission.<br/>
			<a id="no-facebook-account" href="javascript:void(0);">I don't have a Facebook account</a>.
			</p>
		</div>

				<div id="signup-desc-done" class="description" style="display:none;">
			<h2>Thanks for your sign up!</h2>
			<h3>
				We will send you an invite as soon as we can.<br/>
				In the meantime, <a href="index.php">go have some fun now!</a>			</h3>
		</div>
		<div id="request-invite-block" style="display:none;">

<? if ($registration == 0) {
		echo "<center><b>Registration is temporarily disabled by the site admin</center></b>";
	}else {
?>
			<form class="generic" name="registerForm" id="form-signup-login"  method="get" action="<?= $_SERVER['PHP_SELF'] ?>" onsubmit="return validate();">
				<!--<input type="hidden" id="csrftoken" name="csrftoken" value="d851aabfbe41270771f81f3ca30c028a"/>-->
				<div class="field">
					<label>Email</label>
					<input id="signup-request-email" type="text" class="text" placeholder="Your email" maxlength="200" name="email"/>
				</div>
				<div class="field">
					<label>账号</label>
					<input id="signup-request-account" type="text" class="text" placeholder="Your account" maxlength="200" name="uname"/>
				</div>
				<div class="field">
					<label>Lname</label>
					<input id="signup-request-account" type="text" class="text" placeholder="Your account" maxlength="200" name="lname"/>
				</div>
				<div class="field">
					<label>Fname</label>
					<input id="signup-request-account" type="text" class="text" placeholder="Your account" maxlength="200" name="fname"/>
				</div>
				<div class="field">
					<label>密码</label>
					<input id="signup-request-pass" type="password" class="text" placeholder="Your password" maxlength="200" name="pass"/>
				</div>
				<div class="field">
					<label>再输入一次密码</label>
					<input id="signup-request-cpass" type="password" class="text" placeholder="Your password again" maxlength="200" name="cpass"/>
				</div>
				<div class="action">
					<a id="get-account-invitation" class="button"  onClick="document.forms['registerForm'].submit();">注册</a>
				</div>
				<p id="signup-msg" class="message red" style="display:none;"></p>
				<input type="submit" value="zhuce"/>
			</form>
<?
}
?>
		</div>
		<div id="request-invite-loading" style="display:none;">
			<a class="button loading" href="javascript:void(0);"></a>
		</div>

	</div>
</div>

<div style="display:none;">
<span id="siteDomain">9gag.com</span>
<span id="backUrl">%2Fsignup</span>
<span id="fb-app-id">111569915535689</span>
<span id="fbTimelineApi">ninegag:laugh_at?funny_post</span>
</div>

<div id="fb-root"></div>
<script src="./9gag_static/https@connect.facebook.net/en_US/all.js" type="text/javascript"></script>

<!-- Google Analytics -->
<!--ipt type="text/javascript">

var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-4838180-1']);
_gaq.push(['_setDomainName', '.9gag.com']);
_gaq.push(['_deleteCustomVar', 1]);
_gaq.push(['_trackPageview']);

(function() {
 var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
 ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
 var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
 })();

</scri-->

<!-- Quantcast Tag -->
<script type="text/javascript">
var _qevents = _qevents || [];

(function() {
var elem = document.createElement('script');
elem.src = (document.location.protocol == "https:" ? "./9gag_static/https@secure/" : "./9gag_static/edge/") + ".quantserve.com/quant.js";
elem.async = true;
elem.type = "text/javascript";
var scpt = document.getElementsByTagName('script')[0];
scpt.parentNode.insertBefore(elem, scpt);
})();

_qevents.push({
qacct:"p-f8Bn5MbvAQbXQ"
});
</script>

<noscript>
<div style="display:none;">
<img src="./9gag_static/https@pixel.quantserve.com/pixel/p-f8Bn5MbvAQbXQ.gif" border="0" height="1" width="1" alt="Quantcast"/>
</div>
</noscript>
<!-- End Quantcast tag -->


	</body>
</html>


