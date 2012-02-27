<?php
session_start();

include_once( 'config.php' );
include_once( 'saetv2.ex.class.php' );

$o = new SaeTOAuthV2( WB_AKEY , WB_SKEY );

if (isset($_REQUEST['code'])) {
	$keys = array();
	$keys['code'] = $_REQUEST['code'];
	$keys['redirect_uri'] = WB_CALLBACK_URL;
	try {
		$token = $o->getAccessToken( 'code', $keys ) ;
		//$secret = $o->getAccessTokenSecret( 'secret', $keys ) ;
	} catch (OAuthException $e) {
	}
}

if ($token) {
	$_SESSION['token'] = $token;
	setcookie( 'weibojs_'.$o->client_id, http_build_query($token) );


	$c = new SaeTClientV2( WB_AKEY , WB_SKEY , $_SESSION['token']['access_token'] );
	$ms  = $c->home_timeline(); // done
	$uid_get = $c->get_uid();
	$uid = $uid_get['uid'];
	$user_message = $c->show_user_by_id( $uid);//根据ID获取用户等基本信息
	$uname = $user_message['screen_name'];
	$utoken = $token['access_token'];
	$usecret = $token['refresh_token'];

	echo $o->client_id;
	echo $uid;

	if ( is_array($token) && !isset($token['error']) ) {
		mysql_connect('localhost', 'root', '');
		mysql_select_db('freeimage');
		$query = mysql_query("SELECT * FROM iusers WHERE oauth_provider = 'weibo' AND oauth_uid = ". $uid);
		$result = mysql_fetch_array($query);
		if(empty($result)){
			$query = mysql_query("INSERT INTO iusers (oauth_provider, oauth_uid, username, oauth_token, oauth_secret) VALUES ('weibo', {$uid}, '{$uname}', '{$utoken}', '{$usecret}')");
			$query = mysql_query("SELECT * FROM users WHERE id = " . mysql_insert_id());
			$result = mysql_fetch_array($query);
		} else {
			//Update the tokens
			$query = mysql_query("UPDATE iusers SET oauth_token = '{$utoken}', oauth_secret = '{$usecret}' WHERE oauth_provider = 'weibo' AND oauth_uid = {$uid}");
		}
		header('Location: index.php');	
	} else {
		header('Location: login.php');	
	}


?>
授权完成,<a href="weibolist.php">进入你的微博列表页面</a><br />
<?php
} else {
?>
授权失败。
<?php
}
?>
