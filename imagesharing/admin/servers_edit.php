<? require_once("header.php"); 
if($auth_gid!="1"){	header("Location: logout.php");	exit;}

         $link = mysql_connect($db_server, $db_user, $db_password) or die("Could not connect.");
     mysql_select_db($db_name) or die("Could not select database.");        
         
         if($_REQUEST["edit"]=="Save Changes")
         {
                $msg="";
                $ftpid = intval(@$_REQUEST['ftpid']); 
                $dir=$_REQUEST['dir'];
                preg_match("/^(http:\/\/)?([^\/]+)/i",$dir, $matches);
                $http = $matches[1];
                if($http=="")
                $url="http://".$dir;
                else
                $url=$dir;
                $name=$_REQUEST['name'];
                $host=$_REQUEST['host'];
                $pass=$_REQUEST['pass'];
                $uname=$_REQUEST['uname'];								$newstatus=$_REQUEST['status'];								$sql="SELECT count(*) as total FROM ftp WHERE host='$host' and ftpid!=$ftpid";
                $result=mysql_query($sql);
                while ($row = mysql_fetch_assoc($result)) {
         $total=$row['total'];
        }
                if($total>0)
                $msg="Duplicate Host Name";
                if($msg=="")
                {
                        $sql="UPDATE ftp SET status='".$newstatus."',host='".$host."',dir='".$url."',ftppass='".$pass."',name='".$name."',user='".$uname."' where ftpid=".$ftpid;
                        mysql_query($sql);
                        header("location:servers.php");
                        exit;
                }                
         }        
        $ftpid = $_REQUEST['ftpid'];        
        $query = "select * from ftp where ftpid=$ftpid";
                $result = mysql_query($query) or die("Query failed.");
                while ($row = mysql_fetch_array($result)) 
        {				$status=$row['status'];  
                $user=$row['user'];                
                $host=$row['host'];
                $ftppass=$row['ftppass'];
                $name=$row['name'];                
                $dir=$row['dir'];                
        }        
?>
<div style="width:760px;">
<center>
<h4> <font face="Comic Sans MS" size="4" color="#FF0000">Edit Server ID <?=$ftpid?> <br /></font></h4></center>
<br />
<hr />
<br />

<?if ($msg!=""){?>
<div id="error"><?=$msg?></div>
<?}?>
<form name="config" action="<?= $_SERVER['PHP_SELF'] ?>" method="post" style="margin-top: 0px; margin-bottom: 0px;" onSubmit="return chkfield();">
<input type="hidden" name="ftpid" value="<?=$ftpid?>">

<div class="config-width"><br />
<div class="config1">Server URL : </div>
        <div class="config2">        
                <input type="text" name="dir" id="dir" size="30"value="<?=$dir?>" >This will be link to images uploaded to this server (Ends with slash).  
        </div>        
</div><div class="config-width"><br />        <div class="config1">Local Path :</div>        <div class="config2">                        <input type="text" name="name" id="name" size="30"value="<?=$name?>" > Local path relative from FTP account home  (ends with slash).        </div>        </div>
<div class="config-width"><br />
        <div class="config1">Server IP :</div>
        <div class="config2">
                <input type="text" name="host" id="host" size="30" value="<?=$host?>" > This is the ip or host address for the ftp account of this server.
        </div>
</div>
<div class="config-width"><br />
        <div class="config1">User Name :</div>
        <div class="config2">
                <input type="text" name="uname" id="uname" size="30"value="<?=$user?>" > This is the user name of the ftp account of that server.
        </div>
</div>
<div class="config-width"><br />
        <div class="config1">Password :</div>
        <div class="config2"><input type="password"size="30" name="pass" id="pass" value="<?=$ftppass?>" > This is the password of the ftp account of that server.
</div></div><div class="config-width">        <div class="config1">&nbsp;</div>        <div class="config2">&nbsp;</div></div>   <div class="config-width">        <div class="config1">&nbsp;</div>        <div class="config2"><select name="status"><option value="1" <?php if ($status=="1") {echo "selected";}?> >Enabled</option><option value="0" <?if ($status=="0") echo "selected";?>>Disabled</option></select></div></div>       
<div class="config-width">        <div class="config1">&nbsp;</div>        <div class="config2">&nbsp;</div></div>   
<div class="config-width"><br />
        <div class="config1">&nbsp;</div>
        <div class="config2"><input type="submit" name="edit" value="Save Changes" ></div>
</div>        

</form>
<br />

<div style="clear:both;">
<br /><br />

<br />
</div>


</div>
</div>
<br /><br />
<? require_once("footer.php"); ?>
