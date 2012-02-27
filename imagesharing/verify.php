<? require "header.php"; ?>

<div id="wrapper">
<div style="width:760px;">
<div id="error"><div class="msg" id="sucmsgid">
<?

	$code = intval(@$_REQUEST['code']); 
	$sql="SELECT * from users where joindate='$code'"; 
	$result=mysql_query($sql);
	
	if(mysql_num_rows($result) ==0) {
	echo "Wrong activation code!";
	@mysql_close();
	}
	
	$row = mysql_fetch_assoc($result);
	if($row['status'] == '1') {
	echo "This account is already active!";
	@mysql_close();
	}
	
	if($row['status'] == '2') {
	echo "This account is suspended by site admin!";
	@mysql_close();
	}
	
	if($row['status'] == '0') {
	$sql="UPDATE users SET status='1' where joindate='$code'"; 
	mysql_query($sql);
	@mysql_close();
	echo "Thank you for verifying your account, redirecting to login page shortly";
?>
<META HTTP-EQUIV="Refresh"
      CONTENT="3; URL=login.php">
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
