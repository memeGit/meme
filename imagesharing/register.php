<?require "header.php"; 
?>
<div id="wrapper">
<div id="error" style="display:none;"><div class="msg" id="sucmsgid"></div><div class="error" id="msgid"></div></div>
<? if ($registration == 0) {

echo "<center><b>Registration is temporarily disabled by the site admin</center></b>";
}

else { ?>


<form name="config" action="<?= $_SERVER['PHP_SELF'] ?>" method="post" style="margin-top: 0px; margin-bottom: 0px;" onSubmit="return validate();">
<table width="80%" border="0" cellpadding="2" cellspacing="0" align="center">
        <tr>
                <td align="right" valign="top" class="fontcolor"><b>
                        Username:</b></td>
                <td align="left"><input type="text" name="uname" id="uname" value="" size="40" maxlength="20" /></td>
        </tr>
        <tr>
                <td align="right" valign="top" class="fontcolor"><b>
                        First Name:</b></td>
                <td align="left"><input type="text" name="fname" id="fname" value="" size="40" maxlength="20" /></td>
        </tr>
        <tr>
                <td align="right" valign="top" class="fontcolor"><b>
                        Last Name:</b></td>
                <td align="left"><input type="text" name="lname" id="lname" value="" size="40" maxlength="20" /></td>
        </tr>
        <tr>
                <td align="right" valign="top" class="fontcolor"><b>
                        Email Address:</b></td>
                <td align="left"><input type="text" id="email" name="email" value="" size="40" maxlength="50" /></td>
        </tr>
        <tr>
                <td align="right" valign="top" class="fontcolor"><b>
                        Password:</b></td>
                <td align="left"><input type="password" name="pass" id="pass" value="" size="40" maxlength="32" /></td>
        </tr>
        <tr>
                <td align="right" valign="top" class="fontcolor"><b>
                        Confirm Password:</b></td>
                <td align="left"><input type="password" name="cpass" id="cpass" value="" size="40" maxlength="32" /></td>
        </tr>

                        <tr>
                        <td colspan="2" align="center">
                        <input name="submit" value="Register" type="submit" /></td>
                </tr>
        </table>
</form>

<?
}  ?>


</div>

<? require "footer.php"; ?>