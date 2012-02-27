<? require_once("header.php"); 


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



    $link = mysql_connect($db_server, $db_user, $db_password) or die("Could not connect.");
    mysql_select_db($db_name) or die("Could not select database.");

    // delete selected images, if delete button clicked
    $btn = $_REQUEST['delete'];
    
    if ($btn == "delete") {
        $deleteList = $_REQUEST['chk'];
        if($deleteList)
        {
        foreach ($deleteList as $fn) {            
            $query = "delete from users where userid = '$fn'";                
            $result = mysql_query($query) or die("Query failed.");
            
        }
        }
    }

    $limit = $_REQUEST['limit'];
    if ($limit == "") {
        $limit = 25;
    }
    $start = $_REQUEST['start'];
    if ($start == "") {
        $start = 0;
    }
    $sort = $_REQUEST['sort'];
    
    if ($sort == "") {
        $sort = "userid";
    }
    
    $tn = $_REQUEST['tn'];
    if ($tn == "") {
        $tn = 0;
    }
    $where="";
    $uname = $_REQUEST['uname'];
    if ($uname) {
    if($where!="")
        $where.= " or username like '%$uname%'";
    else
        $where.= "username like '%$uname%'";
    
    }
    $fname = $_REQUEST['fname'];
    if ($fname) {
    if($where!="")
        $where.= " or fname like '%$fname%'";
    else
        $where.= " fname like '%$fname%'";
    }
    $lname = $_REQUEST['lname'];
    if ($lname) {
    if($where!="")
        $where.= " or lname like '%$lname%'";
    else    
        $where.= "lname like '%$lname%'";
    }
    $email = $_REQUEST['email'];
    if ($email) {
    if($where)
        $where.= " or email='$email'";
    else    
        $where.= "email='$email'";
    }
     
    if($where!="")
    $where=" and ($where)";
    
    $totalcount = 0;
	if ($auth_gid=="1") { 
	if ($auth_id=="1") { $query = "SELECT count(*) as ct from users where userid>1 $wh";  }
	else { $query = "SELECT count(*) as ct from users where usergid>1 $wh"; }  
	}

	if ($auth_gid=="2") { $query = "SELECT count(*) as ct from users where usergid=3 $wh";  }  


    $result = mysql_query($query) or die("Query failed.");
    while ($line = mysql_fetch_array($result)) {
            $totalcount = $line[ct];
    }
    
    mysql_free_result($result);
    
    $displaystart = $start + 1;
    $displayend = ($start + $limit > $totalcount ? $totalcount : $start + $limit);
    if ($displayend == $totalcount) {
        $nextset = 0;
    } else {
        $nextset = ($totalcount - $displayend > $limit ? $limit: ($totalcount - $displayend));
    }

	
		if ($auth_gid=="1") { 
	if ($auth_id=="1") {  $query = "select * from users where usergid>1 $where order by " . $sort . " desc limit " . $start . "," . $limit; }

	else { $query = "select * from users where usergid>1 $where order by " . $sort . " desc limit " . $start . "," . $limit; }  
	}

	if ($auth_gid=="2") { $query = "select * from users where usergid=3 $where order by " . $sort . " desc limit " . $start . "," . $limit;  }  	
	
   
    $result = mysql_query($query) or die("Query failed.");
?>
<div style="width:760px;">
<center>
<h4> <font face="Comic Sans MS" size="4" color="#FF0000">User Management<br />    </font></h4></center>
<br />
<hr>
<br />
<form name="users" id="users" action="<?= $_SERVER['PHP_SELF'] ?>" method="post" style="margin-bottom: 0px;"  >
<div style="color: #000080;text-align:center;">
    <div><div class="search1">User Name: </div><div class="search2"><input type="text" name="uname" value="<?= $uname ?>" size="30" /></div><div class="search1">Email Address: </div><div class="search2"><input type="text" name="email" value="<?= $email ?>" size="30" /></div></div>
    <div><br /><br />
    <div class="search1">First Name: </div><div class="search2"><input type="text" name="fname" value="<?= $fname ?>" size="30" /></div><div class="search1">Last Name: </div><div class="search2"><input type="text" name="lname" value="<?= $lname ?>" size="30" /></div></div>
    <br /><br /><input type="submit" name="btn" value="Search" ></div>
   <br />
   <div align="center" style="color: #000080;">Users per page: <input type="text" name="limit" value="<?= $limit ?>" size="3" maxlength="4" />&nbsp;&nbsp;&nbsp;&nbsp;Sort by: <select name="sort" size="1"><option value="joindate" <?= ($sort == "joindate" ? "selected" : "") ?>>Join Date</option><option value="username" <?= ($sort == "username" ? "selected" : "") ?>>User Name</option><option value="usergid" <?= ($sort == "usergid" ? "selected" : "") ?>>Group</option><option value="status" <?= ($sort == "status" ? "selected" : "") ?>>Status</option><option value="fname" <?= ($sort == "fname" ? "selected" : "") ?>>First Name</option><option value="lname" <?= ($sort == "lname" ? "selected" : "") ?>>Last Name</option><option value="email" <?= ($sort == "email" ? "selected" : "") ?>>E-mail Address</option><option value="ip" <?= ($sort == "ip" ? "selected" : "") ?>>IP Address</option></select>&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="btn" value="View" style="font-size: large;"></div>
<br />
<br />
<div id="error" style="display:none;"><div class="msg" id="sucmsgid"></div></div>
<table border="0" width="100%" cellpadding="2" cellspacing="0">
    <tr>
        <td width="90%" valign="top" align="center" nowrap><strong>Displaying users <?= $displaystart ?> to <?= $displayend ?> of <?= $totalcount ?>.</strong></td>
        <td width="20%" valign="top" align="right" nowrap><? if ($start > 0) { ?><a style="color: #0000cd;" href="<?= $PHP_SELF ?>?limit=<?= $limit ?>&sort=<?= $sort ?>&start=<?= $start - $limit?>&tn=<?= $tn ?>">Previous <?= $limit ?></a> - <? } ?><? if ($nextset > 0) { ?><a style="color: #0000cd;" href="<?= $PHP_SELF ?>?limit=<?= $limit ?>&sort=<?= $sort ?>&start=<?= $start + $limit?>&tn=<?= $tn ?>">Next <?= $nextset ?></a><? } ?></td>
    </tr>
</table>


<table border="0" width="100%" cellpadding="2" cellspacing="0">
    <tr bgcolor="#dcdcdc">
        <td align="left" class="cell"><input type="checkbox" onClick="check_all('chk','users')"></td>
        <td align="left" class="cell"><strong>User Name</strong></td>
        <td align="left" class="cell"><strong>Group</strong></td>
        <td align="left" class="cell"><strong>Status</strong></td>
        <td align="center" class="cell"><strong>Join Date</strong></td>
        <td align="center" class="cell"><strong>E-mail</strong></td>
        <td align="left" class="cell"><strong>IP Address</strong></td>
        <td align="left"><strong>Total images</strong></td>
        
    </tr>
<? while ($line = mysql_fetch_array($result)) { 
$sql="select count(*) as total from images where userid=$line[userid]";
$total = mysql_query($sql) or die("Query failed.");
while ($rs = mysql_fetch_array($total)) {
$total_img=$rs['total'];
}
?>
    <tr id="u_<?= $line[userid] ?>">
        <td align="left" class="cell"><input type="checkbox" name="chk[]" value="<?= $line[userid] ?>"></td>
        <td align="left" class="cell"><a href="edituser.php?uid=<?=$line[userid]?>"><?=$line[username]?></a>&nbsp;</td>
        <td align="left" class="cell"><span id="g_<?= $line[userid] ?>"><?php if($line[usergid]==1) echo "Admins"; if($line[usergid]==2) echo "Moderators"; if($line[usergid]==3) echo "Members"; ?></span>&nbsp;</td>
        <td align="left" class="cell"><span id="s_<?= $line[userid] ?>"><?php if($line[status]==0) echo "Pending"; if($line[status]==1) echo "Active"; if($line[status]==2) echo "Suspended"; ?></span>&nbsp;</td>
        <td align="left" class="cell"><?= date("d/m/Y h:i:s A", $line[joindate]) ?>&nbsp;</td>
        <td align="left" class="cell"><?= $line[email] ?>&nbsp;</td>
        <td align="left" class="cell"><?= $line[ip] ?>&nbsp;</td>            
        <td align="center" ><a href="userimages.php?uid=<?=$line[userid]?>&name=<?=$line[username]?>"><?=$total_img?><a>&nbsp;</td>            
    </tr>
<? } ?>
</table>
<?
    mysql_free_result($result);
    mysql_close($link);
?>
<br />
<table border="0" width="100%" cellpadding="2" cellspacing="0">
    <tr bgcolor="#dcdcdc">
        <td align="center" class="cell"><input type="button" name="delete" value="Delete" onClick="return deleteuser();">
        &nbsp;&nbsp;
        <input type="button" name="activate" value="Activate" onClick="return activateuser('Activated');">
        &nbsp;&nbsp;
        <input type="button" name="suspend" value="Suspend" onClick="return activateuser('Suspended');">
        </td>
    </tr>
</table>    
</form>
</div>
</div>
<br />
<br />
<? require_once("footer.php"); ?>