<? require_once("header.php"); 

if($auth_gid!=="1")
{
	header("Location: logout.php");	exit;
}

     $link = mysql_connect($db_server, $db_user, $db_password) or die("Could not connect.");
     mysql_select_db($db_name) or die("Could not select database.");        
     
     if($_REQUEST["add"]=="Add")
     {
        $msg="";
        $name=check_input($_REQUEST['name']);
        $dir=check_input($_REQUEST['dir']);
        preg_match("/^(http:\/\/)?([^\/]+)/i",$dir, $matches);
        $http = $matches[1];
        if($http=="")
        $url="http://".$dir;
        else
        $url=$dir;
        
        $host=check_input($_REQUEST['host']);
        $pass=check_input($_REQUEST['pass']);
        $uname=check_input($_REQUEST['uname']);

        if($msg=="")
        {
            $sql="insert into ftp SET host='".$host."',dir='".$url."',ftppass='".$pass."',name='".$name."',user='".$uname."',adddate=".time();
            mysql_query($sql);
        }
        
     }
        
        $limit = check_input($_REQUEST['limit']);
        if ($limit == "") {
                $limit = 10;
        }
        $start = check_input($_REQUEST['start']);
        if ($start == "") {
                $start = 0;
        }
        $totalcount = 0;
        $query = "SELECT count(*) as ct from ftp";
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
        $query = "select * from ftp order by ftpid desc limit " . $start . "," . $limit;
        $result = mysql_query($query) or die("Query failed.");
?>
<div style="width:760px;">
<center>
<h4> <font face="Comic Sans MS" size="4" color="#FF0000">Servers Configuration<br />    </font></h4></center>
<br />
<hr />
<br />
<b>If you host all the images on this server then you don't need to edit this page.<br />
If you delete a server, all the images hosted on that deleted server will NOT be deleted.<br />
If you disable a server, no more images will be uplaoded to it but old images that were uploaded to that disabled server will still work.<br />
</b>

<div  align="center">
<?if ($msg!=""){?>
<div id="error"><?=$msg?></div>
<?}?>
<form name="config" action="<?= $_SERVER['PHP_SELF'] ?>" method="post" style="margin-top: 0px; margin-bottom: 0px;" onSubmit="return chkfield();">


<div class="config-width"><br />
    <div class="config1">Local Path :</div>
    <div class="config2">
        <input type="text" name="name" id="name" size="30"value="<?=$name?>" > Local path relative from FTP account home  (ends with slash).
    </div>
</div>


<div class="config-width"><br />
    <div class="config1">Server URL : </div>
    <div class="config2">    
        <input type="text" name="dir" id="dir" size="30"value="<?=$dir?>" > This will be link to images uploaded to this server (Ends with slash).
    </div>    
</div>


<div class="config-width"><br />
    <div class="config1">Server IP : </div>
    <div class="config2">
        <input type="text" name="host" id="host" size="30" value="<?=$host?>" > The ip or host address for the ftp account of this server.
    </div>
</div>
<div class="config-width"><br />
    <div class="config1">User Name : </div>
    <div class="config2">
        <input type="text" name="uname" id="uname" size="30"value="<?=$uname?>" > The user name of the ftp account of that server.
    </div>
</div>
<div class="config-width"><br />
    <div class="config1">Password : </div>
    <div class="config2"><input type="password"size="30" name="pass" id="pass" value="<?=$pass?>" > The password of the ftp account of that server.
	</div>
</div>
<div class="config-width">
    <div class="config1">&nbsp;</div>
    <div class="config2">&nbsp;</div>
</div>    
<div class="config-width"><br />
    <div class="config1">&nbsp;</div>
    <div class="config2"><input type="submit" name="add" value="Add" ></div>
</div>    

</form>
<br />

<div style="clear:both;">
<br /><br />

<div id="error" style="display:none;"><div id="sucmsgid"></div></div>
<table border="0" width="95%" cellpadding="2" cellspacing="0">
        <tr>
                <td width="20%" valign="top" align="left" nowrap></td>
                <td width="60%" valign="top" align="center" nowrap><strong>Displaying <?= $displaystart ?> to <?= $displayend ?> of <?= $totalcount ?>.</strong></td>
                <td width="20%" valign="top" align="right" nowrap><? if ($start > 0) { ?><a style="color: #0000cd;" href="<?= $PHP_SELF ?>?limit=<?= $limit ?>&sort=<?= $sort ?>&start=<?= $start - $limit?>&tn=<?= $tn ?>&details=<?= $details ?>">Previous <?= $limit ?></a> - <? } ?><? if ($nextset > 0) { ?><a style="color: #0000cd;" href="<?= $PHP_SELF ?>?limit=<?= $limit ?>&sort=<?= $sort ?>&start=<?= $start + $limit?>&tn=<?= $tn ?>&details=<?= $details ?>">Next <?= $nextset ?></a><? } ?></td>
        </tr>
</table>
<br />
<form name="servers" id="servers" action="<?= $_SERVER['PHP_SELF'] ?>" method="post" style="margin-bottom: 0px;" >
<table border="0" width="95%" cellpadding="2" cellspacing="0">
        <tr bgcolor="#dcdcdc">
                <td align="center" class="cell"><input type="checkbox" onClick="check_all('chk','servers')"></td>
                <td align="center" class="cell"><strong>Id</strong></td>
				<td align="center" class="cell"><strong>Status</strong></td>
                <td align="center" class="cell"><strong>Local Path</strong></td>
                <td align="center" class="cell"><strong>Server URL</strong></td>
                <td align="center" class="cell"><strong>Server IP</strong></td>
                <td align="center" class="cell"><strong>User Name</strong></td>
                <td align="center" class="cell"><strong>Password</strong></td>                
                <td align="center" class="cell"><strong>Action</strong></td>                
        </tr>
<? while ($line = mysql_fetch_array($result)) { ?>
        <tr id="<?= $line[ftpid] ?>">
                <td align="center" class="cell"><input type="checkbox" name="chk[]" value="<?=$line[ftpid] ?>"></td>
                <td align="center" class="cell"><?=$line[ftpid] ?></td>
        <td align="left" class="cell"><span id="s_<?= $line[ftpid] ?>"><?php if($line[status]==0) echo "Disabled"; if($line[status]==1) echo "Enabled"; ?></span></td>				
		<td align="center" class="cell"><?=$line[name] ?></td>
                <td align="center" class="cell"><?=$line[dir] ?></td>
                <td align="center" class="cell"><?=$line[host]?></td>                
                <td align="center" class="cell"><?=$line[user]?></td>                                                
                <td align="center" class="cell"><?=$line[ftppass]?></td>                                                                
                <td align="center" class="cell"><a href="servers_edit.php?ftpid=<?=$line[ftpid]?>"><img title="Edit this server" src="<?=$server_url?>/i/edit.gif" /></a>&nbsp;&nbsp;&nbsp;<? if($line[status]==0){?><a href="javascript:void(0);"  onClick="return ftpstatus('<?=$line[ftpid]?>','Enabled');"><img title="Enable this server" src="<?=$server_url?>/i/enable.png" /></a><?}if($line[status]==1){ ?><a href="javascript:void(0);"  onClick="return ftpstatus('<?=$line[ftpid]?>','Disabled');"><img title="Disable this server" src="<?=$server_url?>/i/disable.png" /></a><?}?>&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);"  onClick="return deleteftpSingle('<?=$line[ftpid]?>');"><img title="Delete this server" src="<?=$server_url?>/i/delete.png" /></a></td>                                                                
        </tr>
<? } ?>        
</table>
<table border="0" width="95%" cellpadding="2" cellspacing="0">
        <tr bgcolor="#dcdcdc">
                <td align="center" class="cell"><input type="button" name="delete" value="Delete" onClick="return deleteftp();"></td>
        </tr>
</table>   
</form>
<br />
</div>
</div>

</div>
</div>
<br /><br /><br /><br /><br /><br />
<? require_once("footer.php"); ?>