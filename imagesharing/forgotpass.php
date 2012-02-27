<?require "header.php";?>

<div id="wrapper">
<div id="error" style="display:none;"><div class="msg" id="sucmsgid"></div><div class="error" id="msgid"></div></div>
<form name="config" action="<?= $_SERVER['PHP_SELF'] ?>" method="post" style="margin-top: 0px; margin-bottom: 0px;" onSubmit="return forgetpass();">
<div class="profile">

<div class="row">
	<div class="rowleft">
		<span class="fontcolor"><b>Email Address:</b></span>
	</div>
	<div class="rowright">
		<input type="text" name="email" id="email" value="<?=$uname?>" size="40" maxlength="255" />
	</div>
</div>	
<br /><br />
<div class="row">
	<div class="rowleft">
		
	</div>

	<div class="rowright">
		<input name="submit" value="Send Me Password" type="submit" >
	</div>
</div>	
<br /><br /><br />
</div>

</form>
</div>


<? require "footer.php"; ?>