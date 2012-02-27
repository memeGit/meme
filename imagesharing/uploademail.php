<?
require_once("header.php"); 
require_once("inc/email.php"); 
?>
<center>
<br />
<div align="center"><span class="heading">Image Links Email</span></div>
<br />
<span class="body">
<form name="uploadresults" action="uploademail.php" method="post">
<? if (!$ok) { ?>
<span style="font-weight: bold; color: maroon;">Your e-mail could not be sent. Please try again.</span><br />
<br />
Thank you for using our service. To try again, 
<?
if(!$auth_id)
{?>
<a href="index.php">Click here</a>.<br />
<?}
else{
?>
<a href="uploader.php">Click here</a>.<br />
<? }?><br />
<br />
<? } else { ?>
<span style="color: maroon;">An e-mail has been sent to the address you entered.</span><br />
<br />
Thank you for using our service. To upload another image, 
<?
if(!$auth_id)
{?>
<a href="index.php">Click here</a>.<br />
<?}
else{
?>
<a href="uploader.php">Click here</a>.<br />
<? }?>
<br />
<? } ?>
<br />
</form>
</span>
</center>
<? require_once("footer.php"); ?>