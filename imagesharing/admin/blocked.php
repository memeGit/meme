<?php
require_once("header.php");
if($auth_gid!=="1" && $auth_gid!=="2") {	header("Location: logout.php");	exit;	}			$link = mysql_connect($db_server, $db_user, $db_password) or die("Could not connect");	mysql_select_db($db_name) or die("Could not select database");
if($_POST['submit']){
	
$ips = $_REQUEST['ips'];
mysql_query("delete from blocked") or die("Query failed");
			$array = preg_split( "/\r\n/", $ips	);
			foreach ($array as $ip) {
			if ($ip != "") {
						mysql_query("insert into blocked (ip) values ('$ip')") or die("Query failed");
				}
			}

		} // else
	// get blocked ip addresses
			$query = "SELECT ip from blocked order by ip";
			$result = mysql_query($query) or die("Query failed");
	?>
    <div style="width:760px"><center><h4> <font face="Comic Sans MS" size="4" color="#FF0000">Block IPs<br />	</font></h4></center><br /><hr /><br /><div align="center">Enter IP addresses, one per line, and they will be blocked from uploading images.<br /><br /><br />xxx.xxx.xxx.xxx<br />
    <form name="blocked" action="<?= $_SERVER['PHP_SELF'] ?>" method="post" style="margin-top: 0px; margin-bottom: 0px;">
    <textarea name="ips" cols="15" rows="25"><?php
while($row = mysql_fetch_assoc($result)){

echo $row["ip"] . "\n";

}	
	   ?></textarea><br />
       <input type="submit" name="submit" value="Save List" >
       </form>
       </div>
	   
	   <?    mysql_free_result($result);	mysql_close($link);?>
       
       </div></div><br />
			
			<?php

			 require_once("footer.php");
			 
?>