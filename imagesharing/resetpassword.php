<? require "header.php"; ?>

<div id="wrapper">
<div style="width:760px;">
<div id="error"><div class="msg" id="sucmsgid">
<?

	$url_code = check_input($_REQUEST['code']); 
	$result = mysql_query("SELECT * from users where code='$url_code'");
	
	if(mysql_num_rows($result) ==0) {
	echo "Wrong reset code!";
	@mysql_close();
	}

else {

while ($row = mysql_fetch_assoc($result)) {
         $pass=$row['password'];
		 $uname=$row['username'];
         $code=$row['code'];
		 $email=$row['email'];
        }
		
		$newpassword = rand(1111111111,9999999999);
        $md5_newpassword=md5($newpassword);

	$sql1="UPDATE users SET password='$md5_newpassword' where code='$url_code'";
	mysql_query($sql1);

	$sql2="UPDATE users SET code='0' where code='$url_code'";
	mysql_query($sql2);
	@mysql_close();
	
	        ///Mail User
        $subject = "New password";
        $to = $email;
        $from = $support_email;
        $body= "Hello $uname, <br /><br /> 
		This is your updated account details. <br /> User name: $uname <br /> Password: $newpassword<br /><br /> To log into your account with those details click the link below <br />  $server_url/login.php <br /><br />Please remember to change this password when you log in with something you can easily remember.<br /><br />------------------------------------------------<br /> This is an automated E-mail from <br />  $site_name ";
                $headers = "From: " . $from . "\n";
                $headers .= "X-Sender: <" . "$to" . ">\n";
                $headers .= "Return-Path: <" . "$to" . ">\n";
                $headers .= "Error-To: <" . "$to" . ">\n";
                $headers .= "Content-Type: text/html\n";
                mail($to,$subject,$body,$headers);

	echo "New password has been sent to your email, redirecting to login page shortly";
?>
<META HTTP-EQUIV="Refresh"
      CONTENT="5; URL=login.php">
	  <?
	}
?>


</div></div>




<br />
						    <br /><br /><br /><center><?=$config[footer]?></center><br /><br />

</div>
</div>
<br />

<? require "footer.php"; ?>
