<?
require "header.php"; 


require_once('../inc/recaptchalib.php');

// Get a key from http://recaptcha.net/api/getkey
$publickey = "6LfxIggAAAAAAPFnMx-yed8fWjF4tu_kmWr7r9Mt";
$privatekey = "6LfxIggAAAAAANmmEY4OsOGMoy9vDAFeijpLsKQE";

# the response from reCAPTCHA
$resp = null;
# the error code from reCAPTCHA, if any
$error = null;

# was there a reCAPTCHA response?
if ($_POST["recaptcha_response_field"]) {
        $resp = recaptcha_check_answer ($privatekey,
                                        $_SERVER["REMOTE_ADDR"],
                                        $_POST["recaptcha_challenge_field"],
                                        $_POST["recaptcha_response_field"]);

        if ($resp->is_valid) {
		
		
 if (isset($_POST['uname']))
 {
 

$msg="";
if($_POST['uname']==""){
$msg.="<br />User Name cannot be left empty!<br />";}
if($_POST['pass']==""){
$msg.="<br />Password cannot be left empty!<br />";}

else {

$po_uname=check_input($_POST['uname']);
$po_pass=md5($_POST['pass']);

$query =sprintf("select * from users where username='$po_uname' and password='$po_pass'");
 	$result = mysql_query($query);
//	print_r($query);
	if(mysql_num_rows($result) ==0) {
	$msg.="Wrong login details entered!";
	@mysql_close();
	}
	
else {	
	while ($row = mysql_fetch_assoc($result)) { 				
			$auth_id=$row['userid'];
			$auth_gid=$row['usergid'];						
			$auth_name=$row['username'];
			$auth_pass=$row['password'];
			$auth_status=$row['status'];
	}
	
	@mysql_close();
		if($auth_gid=="1" || $auth_gid=="2") {
		   session_start(); 
		$_SESSION['userid']=$auth_id;
		$_SESSION['usergid']=$auth_gid; 
		$_SESSION['username']=$auth_name;
		$_SESSION['password']=$auth_pass;
		$_SESSION['status']=$auth_status; 
		
		if(isset($_POST['remember'])){
			setcookie("cookname", $auth_name, time()+60*60*24*30, "/");
			setcookie("cookpass", $auth_pass, time()+60*60*24*30, "/");
		}
		
	header("Location: index.php");
	exit;
	}  else { $msg.="You don't have permission to access this area!";  }


} }


 } // if post
 
 } // if captcha ok
 else {
 $msg.="<br />Verify the text in the red box!<br />";

                # set the error code so that we can display it
                $error = $resp->error;
        }
} // if captcha post

?>
<div style="width:760px;">

<center>
<?if($msg){?>
<div id="error"><span class="error"><?=$msg?></span></div>
<?}?>

<form name="config" action="<?= $_SERVER['PHP_SELF'] ?>" method="post" style="margin-top: 0px; margin-bottom: 0px;" onSubmit="return validate();">
User Name:<br />
<input type="text" name="uname" id="uname" value="<?=$uname?>" maxlength="20"><br />
Password:<br />
<input type="password" name="pass" value="" maxlength="32"><br />
<br />
<input type="checkbox" name="remember">
<font size="2">Remember me<br /><br />
<? 
echo recaptcha_get_html($publickey, $error);
?><br /><br />
<input type="submit" value="Login" type="submit">
<br /><br />
<a href="../forgotpass.php">Forgot Password ?</a>
<br /><br /><br /><br />
</center>

</form>

    </div>
    </div>

<? require "footer.php"; ?>