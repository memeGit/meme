<?require "header.php"; 

if ($auth_gid)
  {
    
   if ($auth_gid!="1" && $auth_gid!="2")
      {

      header("Location: logout.php"); exit;
       }
        
   }
else
  {
   header("Location: login.php");
   }

	$uid=check_input($_REQUEST['uid']);

    $sql="select * from users where userid=$uid";
	
    $result = mysql_query($sql) or die("Query failed.");
		if(mysql_num_rows($result) ==0) { ?>
		<div id="error"><div class="msg" id="sucmsgid"> <?
	echo "No user found with this ID!"; ?>
	</div></div>
	<?
	@mysql_close();
	}
	while ($row = mysql_fetch_array($result)) 
	{
		$ed_uname=$row['username'];		
		$ed_fname=$row['fname'];
		$ed_lname=$row['lname'];
		$ed_email=$row['email'];
		$ed_status=$row['status'];		
		$ed_ugid=$row['usergid'];		
		$ed_uid=$row['userid'];
	}	
	
			if(($auth_gid=="2" && $ed_ugid=="1") || ($ed_uid=="1"){

?>
		<div id="error"><div class="msg" id="sucmsgid"> <?
	echo "You are not allowed to edit this user!"; ?>
	</div></div>
	<?
}


?>

<center>
<h4> <font face="Comic Sans MS" size="4" color="#FF0000">Edit Account ID <?=$uid?> - "<?=$uname?>"<br />    </font></h4></center>
<br />
<hr>
<br /><br />
</center>
<div id="error" style="display:none;"><div class="msg" id="sucmsgid"></div><div class="error" id="msgid"></div></div>

<form name="config" action="<?= $_SERVER['PHP_SELF'] ?>" method="post" style="margin-top: 0px; margin-bottom: 0px;" onSubmit="return chk_update();">
<input type="hidden" name="uid" id="uid" value="<?=$ed_uid?>" >
<div class="profile">

<div class="row">
	<div class="rowleft">
		Username:
	</div>
	<div class="rowright">
		<input type="text" name="uname" id="uname" value="<?=$ed_uname?>" size="40" maxlength="20" />
	</div>
</div>	

<div class="float row">
	<div class="rowleft">
		First Name:
	</div>
	<div class="rowright">
		<input type="text" name="fname" id="fname" value="<?=$ed_fname?>" size="40" maxlength="20" />
	</div>
</div>	

<div class="float row">
	<div class="rowleft">
		Last Name:
	</div>
	<div class="rowright">
		<input type="text" name="lname" id="lname" value="<?=$ed_lname?>" size="40" maxlength="20" />
	</div>
</div>	

<div class="float row">
	<div class="rowleft">
		Email Address:
	</div>
	<div class="rowright">
		<input type="text" id="email" name="email" value="<?=$ed_email?>" size="40" maxlength="50" />
	</div>	
</div>


<div class="float row">
	<div class="rowleft">
		User Group:
	</div>
	<div class="rowright">
		<select id="usergid" name="usergid"><option value="1" <?php if ($ed_ugid=="1"){ echo "selected";}?> >Admins</option><option value="2" <?php if ($ed_ugid=="2"){ echo "selected";}?> >Moderators</option><option value="3" <?if ($ed_ugid=="3") echo "selected";?>>Members</option></select>
	</div>	
</div>


<div class="float row">
	<div class="rowleft">
		Account Status:
	</div>
	<div class="rowright">
		<select id="status" name="status"><option value="0" <?php if ($ed_status=="0"){ echo "selected";}?> >Pending</option><option value="1" <?php if ($ed_status=="1"){ echo "selected";}?> >Active</option><option value="2" <?php if ($ed_status=="2"){ echo "selected";}?> >Suspended</option></select>
	</div>	
</div>

<br />
<br />
<br />
Fill this only if you want to change this user password.<br />

<div class="float row">
	<div class="rowleft">
		New Password:
	</div>
	<div class="rowright">
		<input type="password" name="pass" id="pass" value="" size="40" maxlength="32" />
	</div>
</div>

<br />
<br />


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
<br />
<? require "footer.php"; ?>