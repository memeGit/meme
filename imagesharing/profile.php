<?require "header.php"; 
if($auth_id == '0')
{
	header("Location: logout.php");
	exit;
}
    $sql="select * from users where userid=$auth_id";
	
    $result = mysql_query($sql) or die("Query failed.");
	while ($row = mysql_fetch_array($result)) 
	{
		$uname=$row['username'];		
		$fname=$row['fname'];
		$lname=$row['lname'];
		$email=$row['email'];
	}	
?>
<div id="wrapper">
<div id="error" style="display:none;"><div class="msg" id="sucmsgid"></div><div class="error" id="msgid"></div></div>

<form name="config" action="<?= $_SERVER['PHP_SELF'] ?>" method="post" style="margin-top: 0px; margin-bottom: 0px;" onSubmit="return chk_profileupdate();">
<input type="hidden" name="userid" id="userid" value="<?=$auth_id?>" >
<div class="profile">

<div class="row">
	<div class="rowleft">
		Username:
	</div>
	<div class="rowright">
		<input type="text" name="uname" id="uname" value="<?=$uname?>" size="40" maxlength="20" readonly>
	</div>
</div>	

<div class="float row">
	<div class="rowleft">
		First Name:
	</div>
	<div class="rowright">
		<input type="text" name="fname" id="fname" value="<?=$fname?>" size="40" maxlength="20" />
	</div>
</div>	

<div class="float row">
	<div class="rowleft">
		Last Name:
	</div>
	<div class="rowright">
		<input type="text" name="lname" id="lname" value="<?=$lname?>" size="40" maxlength="20" />
	</div>
</div>	

<div class="float row">
	<div class="rowleft">
		Email Address:
	</div>
	<div class="rowright">
		<input type="text" id="email" name="email" value="<?=$email?>" size="40" maxlength="50" />
	</div>	
</div>



<br /><br /><br />
Fill these only if you want to change your password.<br />

<div class="float row">
	<div class="rowleft">
		Old Password:
	</div>
	<div class="rowright">
		<input type="password" name="oldpass" id="oldpass" size="40" maxlength="32" />
	</div>
</div>


<div class="float row">
	<div class="rowleft">
		New Password:
	</div>
	<div class="rowright">
		<input type="password" name="pass1" id="pass1" size="40" maxlength="32" />
	</div>
</div>


<div class="float row">
	<div class="rowleft">
		Confirm New Password:
	</div>
	<div class="rowright">
		<input type="password" name="pass2" id="pass2" size="40" maxlength="32" />
	</div>
</div>

<br /><br />
<div class="float row">
	<div class="rowleft">
		&nbsp;
	</div>
	<div class="rowright">
		<input name="submit" value="Update" type="submit" >
	</div>	
</div>	
	
</div>
<br />
<br />	
</form>
</div>

<? require "footer.php"; ?>