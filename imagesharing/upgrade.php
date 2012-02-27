<?php 

include("header.php");
$version = $config['ScriptVersion'];

if(!function_exists('str_split')) {
    function str_split($string,$string_length=1) {
        if(strlen($string)>$string_length || !$string_length) {
            do {
                $c = strlen($string);
                $parts[] = substr($string,0,$string_length);
                $string = substr($string,$string_length);
            } while($string !== false);
        } else {
            $parts = array($string);
        }
        return $parts;
    }
}


$versionx = implode('.',str_split($version,1));
?>

<div id="wrapper">
<div style="width:760px;">
<div id="error"><div class="msg" id="sucmsgid">

<?
if ($version<200){ 


mysql_query('INSERT INTO `config` (`soption`, `svalue`) VALUES (\'Watermarking\', \'1\')');
mysql_query('INSERT INTO `config` (`soption`, `svalue`) VALUES (\'Hotlinking\', \'1\')');
mysql_query('INSERT INTO `config` (`soption`, `svalue`) VALUES (\'Uploads\', \'2\')');
mysql_query('INSERT INTO `config` (`soption`, `svalue`) VALUES (\'MemberRegistration\', \'1\')');
mysql_query('INSERT INTO `config` (`soption`, `svalue`) VALUES (\'EmailValidation\', \'1\')');
mysql_query('INSERT INTO `config` (`soption`, `svalue`) VALUES (\'Advertisements\', \'2\')');
mysql_query('ALTER TABLE `users` ADD `usergid` INT(1) NOT NULL default \'3\' AFTER `userid`');
mysql_query('ALTER TABLE `ftp` ADD `status` INT(1) NOT NULL default \'1\' AFTER `ftpid`');
mysql_query('UPDATE `users` SET usergid="3"'); 
mysql_query('UPDATE `users` SET usergid="1" WHERE userid="1"'); 
mysql_query('UPDATE config SET svalue="270" where soption="ScriptVersion"');
mysql_query('UPDATE config SET svalue="30" where soption="GalleryPhotoPerPage"'); 
 
mysql_query(' CREATE TABLE `reports` (
`id` BIGINT( 20 ) NOT NULL AUTO_INCREMENT ,
`reporterid` BIGINT( 20 ) NOT NULL DEFAULT \'0\',
`uploaderid` BIGINT( 20 ) NOT NULL DEFAULT \'0\',
`timestamp` INT( 11 ) NOT NULL DEFAULT \'0\',
`imagename` VARCHAR( 50 ) NOT NULL ,
`ip` VARCHAR( 15 ) NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1');



$query = "SHOW TABLES";
$result = mysql_query($query) or die('Query failed: ' . mysql_error());
 
while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
  foreach ($line as $col_value) {
    $lock = mysql_query("LOCK TABLE ".$col_value." WRITE") or die('Query failed: ' . mysql_error());
    $optimize = mysql_query("OPTIMIZE TABLE ".$col_value) or die('Query failed: ' . mysql_error());
    $repair = mysql_query("REPAIR TABLE ".$col_value." QUICK") or die('Query failed: ' . mysql_error());
    $unlock = mysql_query("UNLOCK TABLES") or die('Query failed: ' . mysql_error());
  }
}
mysql_free_result($result);
mysql_free_result($repair);
mysql_free_result($optimize);
 
// Closing connection
mysql_close($link);

echo "Upgrade from version $versionx to 2.7 completed! please remove upgrade.php from the server.";


}

if ($version==200){ 
mysql_query('UPDATE config SET svalue="30" where soption="GalleryPhotoPerPage"'); 
mysql_query('UPDATE config SET svalue="270" where soption="ScriptVersion"');
echo "Upgrade from version $versionx to 2.7 completed! please remove upgrade.php from the server.";

}

if ($version==210){ 

mysql_query('INSERT INTO `config` (`soption`, `svalue`) VALUES (\'Hotlinking\', \'1\')');
mysql_query('UPDATE config SET svalue="270" where soption="ScriptVersion"');
echo "Upgrade from version $versionx to 2.7 completed! please remove upgrade.php from the server.";


}

if ($version==220){ 
mysql_query('UPDATE config SET svalue="270" where soption="ScriptVersion"');
echo "Upgrade from version $versionx to 2.7 completed! please remove upgrade.php from the server.";
}

if ($version==230){ 
mysql_query('UPDATE config SET svalue="270" where soption="ScriptVersion"');
echo "Upgrade from version $versionx to 2.7 completed! please remove upgrade.php from the server.";
}

if ($version==240){ 
mysql_query('UPDATE config SET svalue="270" where soption="ScriptVersion"');
echo "Upgrade from version $versionx to 2.7 completed! please remove upgrade.php from the server.";
}

if ($version==250){ 
mysql_query('UPDATE config SET svalue="270" where soption="ScriptVersion"');
echo "Upgrade from version $versionx to 2.7 completed! please remove upgrade.php from the server.";
}

if ($version==260){ 
mysql_query('UPDATE config SET svalue="270" where soption="ScriptVersion"');
echo "Upgrade from version $versionx to 2.7 completed! please remove upgrade.php from the server.";
}
///////////////////////////////////////////////////

if ($version==270){ 
echo "Your are already running version $versionx which is the latest version of the script!";
}

if ($version>270){ 

echo "Your current installed version is newer than the one you are trying to upgrade to!";

}


?></div></div>

<br />


</div>
</div>
<br />

<? require "footer.php"; ?>