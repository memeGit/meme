<?php   // version 2.7 installer

function check_input($value){
$value = trim($value);
if (get_magic_quotes_gpc()){$value = stripslashes($value);}
if (!is_numeric($value)){$value = mysql_escape_string(strip_tags($value));}
if (is_numeric($value)){$value = intval($value);}
//$value = preg_replace("/[^0-9a-z _-]/i",'', $value);
return $value;
}

//Output array of errors
function output_error($arr){
	$size = sizeof($arr);
	echo '<p class="error">You have ' . $size . ' error' . ($size == 1 ? '' : 's') . ':</p>';
	echo '<ol type="1" class="error">';
	foreach($arr as $key => $value)
		echo '<li>' . $value . '</li>';
	echo '</ol>';
}//Output array of errors
//Add slashes if required
function _addsl($post_val){
	return get_magic_quotes_gpc() ? $post_val : addslashes($post_val);
}//Add slashes if required
//Redirect
function http_redirect($url){
	ob_end_clean();
	header('Location: ' . $url);
	exit;
}//Redirect

$__installer_mode = true; //Important

$server_url = this_install_url();

$_GET['step'] = (int)$_GET['step']; //Less important, just don't touch it :)

$db_file = 'inc/db.php'; //Name of file with DB details

$self = 'install.php'; //Equivalent of $PHP_SELF, I just use that cause PHP_SELF sometimes does not work

//Pattern to identify valid email addresses
$email_pattern = '/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@([0-9A-Za-z](-?[0-9A-Za-z])*\.)+[a-z]{2}([zmuvtg]|fo|me)?$/';

//List all required tables
$tbls_list = array(
	'blocked' => "CREATE TABLE `blocked` (
				 `ip` varchar(15) NOT NULL default ''
				 ) ENGINE=MyISAM DEFAULT CHARSET=latin1;",
	'config' => "CREATE TABLE `config` (
				`soption` varchar(200) collate latin1_general_ci NOT NULL default '',
				`svalue` text collate latin1_general_ci NOT NULL
				) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;",
	'ftp' => "CREATE TABLE `ftp` (
			 `ftpid` int(11) NOT NULL auto_increment,
			 `status` int(1) NOT NULL default '1',
			 `name` varchar(255) collate latin1_general_ci NOT NULL default '',
			 `host` varchar(255) collate latin1_general_ci NOT NULL default '',
			 `user` varchar(255) collate latin1_general_ci NOT NULL default '',
			 `ftppass` varchar(30) collate latin1_general_ci NOT NULL default '',
			 `adddate` int(11) NOT NULL default '0',
			 `dir` varchar(255) collate latin1_general_ci NOT NULL default '',
			 PRIMARY KEY  (`ftpid`)
			 ) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;",
	'imagehits' => "CREATE TABLE `imagehits` (
					`idx` bigint(20) NOT NULL auto_increment,
					`timestamp` int(11) NOT NULL default '0',
					`filename` varchar(50) NOT NULL default '',
					`referer` varchar(255) NOT NULL default '',
					`ip` varchar(15) NOT NULL default '',
					`kb` bigint(20) NOT NULL default '0',
					UNIQUE KEY `idx` (`idx`),
					KEY `filename` (`filename`)
					) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;",
	'images' => "CREATE TABLE `images` (
				`idx` bigint(20) NOT NULL auto_increment,
				`added` int(11) NOT NULL default '0',
				`filename` varchar(50) NOT NULL default '',
				`tn_filename` varchar(75) NOT NULL default '',
				`filepath` varchar(150) NOT NULL default '',
				`ip` varchar(25) NOT NULL default '',
				`filesize` bigint(20) NOT NULL default '0',
				`userid` int(11) NOT NULL default '0',
				`ftpid` int(11) NOT NULL default '0',
				`prv` int(1) NOT NULL default '0',
				KEY `idx` (`idx`)
				) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;",
	'users' => "CREATE TABLE `users` (
				`userid` int(11) NOT NULL auto_increment,
				`usergid` int(1) NOT NULL default '3',
				`username` varchar(20) collate latin1_general_ci NOT NULL default '',
				`fname` varchar(20) collate latin1_general_ci NOT NULL default '',
				`lname` varchar(20) collate latin1_general_ci NOT NULL default '',
				`ip` varchar(15) collate latin1_general_ci NOT NULL default '',
				`joindate` int(11) NOT NULL default '0',
				`email` varchar(50) collate latin1_general_ci NOT NULL default '',
				`password` varchar(32) collate latin1_general_ci NOT NULL default '',
				`code` int(10) NOT NULL default '0',
				`status` int(1) NOT NULL default '0',
				PRIMARY KEY  (`userid`)
				) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=2 ;",
					'reports' => "CREATE TABLE `reports` (
					`id` bigint(20) NOT NULL auto_increment,
					`reporterid` bigint(20) NOT NULL default '0',
					`uploaderid` bigint(20) NOT NULL default '0',
					`timestamp` int(11) NOT NULL default '0',
					`imagename` varchar(50) NOT NULL default '',
					`ip` varchar(15) NOT NULL default '',
                    PRIMARY KEY ( `id` )
					) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;",
);
include 'header.php';
?>
<div id="wrapper">
<div  style="width:760px;">
<?php
if($_POST){
	$errors = array();
	switch($_GET['step']){
		case 2:
			//Connect to database
			require_once $db_file;
			if(!@mysql_connect($db_server, $db_user, $db_password) || !@mysql_select_db($db_name))
				http_redirect($self);
			$required = array(
				'SiteName' => 'Site Name',
				'SiteUrl' => 'Site URL',
				'SiteRoot' => 'Site Root',
				'Extension' => 'Extension',
				'FileSizeGuest' => 'Max File Size [Guest]',
				'FileSizeMember' => 'Max File Size [Member]',
				'BandwidthGuest' => 'Bandwidth [Guest]',
				'BandwidthMember' => 'Bandwidth [Member]',
				'GalleryPhotoNo' => 'Gallery Photo No.',
				'GalleryPhotoPerPage' => 'Gallery Photo Per Page',
				'ThumbWidth' => 'Thumbnail Width',
				'ThumbHeight' => 'Thumbnail Height',
			);
			foreach($required as $k => $v){
				if(!isset($_POST['config'][$k]) || trim($_POST['config'][$k]) == ''){
					$errors[] = 'Please enter ' . $v;
				}
			}
			if(!$errors){
				mysql_query('Delete from config');
				foreach($_POST['config'] as $k => $v){
					mysql_query('Insert into config set soption = "' . _addsl($k) . '", svalue="' . _addsl($v) . '"');
				}
				http_redirect($self . '?step=3');
			}
		break;
		case 3:
			//Connect to database
			require_once $db_file;
			if(!@mysql_connect($db_server, $db_user, $db_password) || !@mysql_select_db($db_name))
				http_redirect($self);
			if(trim($_POST['admin_login']) == '')
				$errors[] = 'Please enter administrator username';
			if(trim($_POST['admin_password']) == '')
				$errors[] = 'Please enter administrator password';
			if($_POST['admin_password'] != $_POST['admin_password2'])
				$errors[] = 'Entered passwords do not match';
			if(!preg_match($email_pattern, $_POST['admin_email']))
				$errors[] = 'Please enter valid email address';
			if(!$errors){
				$adminip = $_SERVER['REMOTE_ADDR'];
				$md5_admin_pass=md5($_POST['admin_password']); // 2.7
				mysql_query('Delete from users where userid = 1 limit 1');
				mysql_query('Insert into users set
					userid = 1,
					usergid = 1,
					fname = "Admin",
					lname = "Admin",
					ip = "' . _addsl($adminip) . '",
					joindate = ' . time() . ',
					email = "' . _addsl($_POST['admin_email']) . '",
					username = "' . _addsl($_POST['admin_login']) . '",
					password = "' . _addsl($md5_admin_pass) . '",
					status = 1
				');
				mysql_query('Insert into config set soption = "AdminEmail", svalue = "' . _addsl($_POST['admin_email']) . '"');
				mysql_query('Insert into config set soption = "ScriptVersion", svalue = "270"');
				http_redirect($self . '?step=4');
			}
		break;
		default:
			$db_server = $_POST['db_server'];
			$db_name = $_POST['db_database'];
			$db_user = $_POST['db_username'];
			$db_password = $_POST['db_password'];
			if($_POST['db_server'] == '')
				$errors[] = 'Please enter database server name or IP address';
			if($_POST['db_username'] == '')
				$errors[] = 'Please enter database user name';
			if($_POST['db_database'] == '')
				$errors[] = 'Please enter database name';
			if(!$errors){
				if(!@mysql_connect($_POST['db_server'], $_POST['db_username'], $_POST['db_password']))
					$errors[] = 'Could not connect to database server. Please check provided details';
				elseif(!@mysql_select_db($_POST['db_database']))
					$errors[] = 'The database with provided name does not exist';
			}
			if(!$errors){
				$fp = @fopen($db_file, 'w');
				if($fp === false)
					$errors[] = 'File ' . $db_file . ' is not writable. Please change the access permissions or delete current file.';
				else{
					$content = '<?php' . "\n";
					$content .= '$db_server = \'' . _addsl($_POST['db_server']) . '\';' . "\n";
					$content .= '$db_name = \'' . _addsl($_POST['db_database']) . '\';' . "\n";
					$content .= '$db_user = \'' . _addsl($_POST['db_username']) . '\';' . "\n";
					$content .= '$db_password = \'' . _addsl($_POST['db_password']) . '\';' . "\n";
					$content .= '?>';

					fwrite($fp, $content);
					fclose($fp);

					http_redirect($self . '?step=2');
				}
			}
		break;
	}
}

//Step 1
if($_GET['step'] != 2 && $_GET['step'] != 3 && $_GET['step'] != 4){
	if(is_file('inc/db.php') && !$_POST)
		include 'inc/db.php';
?>
<center>
<h1>Scripteen Free Image Hosting Script v2.7 Installer</h1>
<h2>Step 1 of 3</h1>
<p>Please enter your database details in appropriate fields.</p></center>
<?php
if(isset($errors) && sizeof($errors) > 0)
	output_error($errors);
?>
<form action="<?php echo $self;?>" method="post">
  <table>
    <tbody>
      <tr>
        <td><label for="db_server">Database Host</label></td>
        <td><input type="text" name="db_server" id="db_server" value="<?php echo $db_server;?>" /></td><td>Usually <b>localhost</b></td> 
      </tr>
	        <tr>
        <td><label for="db_database">Database Name</label></td>
        <td><input type="text" name="db_database" id="db_database" value="<?php echo $db_name;?>" /></td>
      </tr>
      <tr>
        <td><label for="db_username">Database Username</label></td>
        <td><input type="text" name="db_username" id="db_username" value="<?php echo $db_user;?>" /></td>
      </tr>
      <tr>
        <td><label for="db_password">Database Password</label></td>
        <td><input type="text" name="db_password" id="db_password" value="<?php echo $db_password;?>" /></td>
      </tr>
      <tr>
        <td></td>
        <td><input type="submit" value="Continue" /></td>
      </tr>
    </tbody>
  </table>
</form>

<?php
}//Step 1
//Step 2
if($_GET['step'] == 2){
	//Connect to database
	require_once $db_file;
	if(!@mysql_connect($db_server, $db_user, $db_password) || !@mysql_select_db($db_name))
		http_redirect($self . '?step=1');
	//See if all tables exist
	$res = mysql_query('Show tables');
	$tables = array();
	while($row = mysql_fetch_array($res))
		$tables[] = $row[0];
	if(!isset($errors))
		$errors = array();
	foreach($tbls_list as $tbl => $query){
		if(!in_array($tbl, $tables)){
			mysql_query($query);
			if(mysql_error())
				$errors[] = 'Could not create table ' . $tbl;
		}
	}
	//Get current config values if any
	if(!$_POST){
		$config = array();
		if($res = mysql_query('Select * from `config`')){
			while($row = mysql_fetch_assoc($res))
				$config[$row['soption']] = $row['svalue'];
		}
	}
	//Autofill some config values
	if($_POST)
		$config = $_POST['config'];
		
					if(!isset($config['SiteName']))
		$config['SiteName'] = 'Scripteen Free Image Hosting Script v2.7';
					if(!isset($config['MetaDesc']))
		$config['MetaDesc'] = 'Scripteen Free Image Hosting Script v2.7';
					if(!isset($config['MetaWords']))
		$config['MetaWords'] = 'image hosting, photo upload';
		
	if(!isset($config['SiteUrl'])){
		$arr = explode('/', getenv('REQUEST_URI'));
		array_pop($arr);
		foreach($arr as $k => $v)
			if($v == '')
				unset($arr[$k]);
		$config['SiteUrl'] = 'http://' . getenv('HTTP_HOST');
		if(sizeof($arr) != 0)
			$config['SiteUrl'] .= '/' . implode('/', $arr);
	}
		$config['SiteRoot'] = realpath(dirname(__FILE__));
		$config['Extension'] = 'gif,jpg,jpeg,png,bmp';
		$config['FileSizeGuest'] = '1';
		$config['FileSizeMember'] = '2';
		$config['BandwidthGuest'] = '1';
		$config['BandwidthMember'] = '2';
		$config['ThumbWidth'] = '150';
		$config['ThumbHeight'] = '150';
		$config['GalleryPhotoNo'] = '1000';
		$config['Uploads'] = '2';
		$config['MemberRegistration'] = '1';
		$config['EmailValidation'] = '1';
		$config['Advertisements'] = '2';
		$config['GalleryPhotoPerPage'] = '30';
		$config['homeleft'] = 'Adsense width 336 and height 280';
		$config['header'] = 'Adsense width 468 and height 60';
		$config['footer'] = 'Adsense width 468 and height 60';
?>

<center>
<h1>Scripteen Free Image Hosting Script v2.7 Installer</h1>
<h2>Step 2 of 3</h1>
<p>Please enter all script configuration variables</p></center>
<?php
if(isset($errors) && sizeof($errors) > 0)
	output_error($errors);
?>

<form action="<?php echo $self;?>?step=2" method="post">
  <table>
    <tbody>
      <tr>
        <td><label for="c_site_name">Site Name:</label></td>
        <td><input type="text" name="config[SiteName]" id="c_site_name" size="30" value="<?php echo $config['SiteName'];?>" /></td>
      </tr>
      <tr>
        <td><label for="c_meta_description">Meta Description:</label></td>
        <td><input type="text" name="config[MetaDesc]" id="c_meta_description" size="30" value="<?php echo $config['MetaDesc'];?>" /></td>
      </tr>
      <tr>
        <td><label for="c_meta_keywords">Meta Keywords:</label></td>
        <td><input type="text" name="config[MetaWords]" id="c_meta_keywords" size="30" value="<?php echo $config['MetaWords'];?>" /></td>
      </tr>
      <tr>
        <td><label for="c_site_url">Site URL:</label></td>
        <td><input type="text" name="config[SiteUrl]" id="c_site_url" size="30" value="<?php echo $config['SiteUrl'];?>" /></td>
      </tr>
      <tr>
        <td><label for="c_site_root">Site Root:</label></td>
        <td><input type="text" name="config[SiteRoot]" id="c_site_root" size="30" value="<?php echo $config['SiteRoot'];?>" /></td>
      </tr>
      <tr>
        <td><label for="c_extension">Extension:</label></td>
        <td><input type="text" name="config[Extension]" id="c_extension" size="30" value="<?php echo $config['Extension'];?>" /></td>
      </tr>
      <tr>
        <td><label for="c_fs_guest">Max File Size [Guest]:</label></td>
        <td><input type="text" name="config[FileSizeGuest]" id="c_fs_guest" size="30" value="<?php echo $config['FileSizeGuest'];?>" />&nbsp;MB/File</td>
      </tr>
      <tr>
        <td><label for="c_fs_member">Max File Size [Member]:</label></td>
        <td><input type="text" name="config[FileSizeMember]" id="c_fs_member" size="30" value="<?php echo $config['FileSizeMember'];?>" />&nbsp;MB/File</td>
      </tr>
      <tr>
        <td><label for="c_bw_guest">Bandwidth [Guest]:</label></td>
        <td><input type="text" name="config[BandwidthGuest]" id="c_bw_guest" size="30" value="<?php echo $config['BandwidthGuest'];?>" />&nbsp;GB/File</td>
      </tr>
      <tr>
        <td><label for="c_bw_member">Bandwidth [Member]:</label></td>
        <td><input type="text" name="config[BandwidthMember]" id="c_bw_member" size="30" value="<?php echo $config['BandwidthMember'];?>" />&nbsp;GB/File</td>
      </tr>
      <tr>
        <td><label for="c_thumb_width">Thumbnail Width:</label></td>
        <td><input type="text" name="config[ThumbWidth]" id="c_thumb_width" size="30" value="<?php echo $config['ThumbWidth'];?>" />150 recommended.</td>
      </tr>
      <tr>
        <td><label for="c_thumb_height">Thumbnail Height:</label></td>
        <td><input type="text" name="config[ThumbHeight]" id="c_thumb_height" size="30" value="<?php echo $config['ThumbHeight'];?>" />150 recommended.</td>
      </tr>
	  
	  
	        <tr>
        <td><label for="AcceptTerms">Accept terms before upload:</label></td>
        <td>
          <select name="config[AcceptTerms]" id="AcceptTerms">
            <option value="1">Enabled</option>
            <option value="0"<?php if ($config['AcceptTerms'] == '0') echo ' selected="selected"';?>>Disabled</option>
          </select>
        </td>
      </tr>
	  
	        <tr>
        <td><label for="Uploads">Allow Uploads:</label></td>
        <td>
          <select name="config[Uploads]" id="Uploads">
          <option value="2">Enabled For All</option>
          <option value="1"<?php if ($config['Uploads'] == '1') echo ' selected="selected"';?>>Disabled For Guests</option>
          <option value="0"<?php if ($config['Uploads'] == '0') echo ' selected="selected"';?>>Disabled For All</option>
          </select>
        </td>
      </tr>


      <tr>
        <td><label for="c_url_guest">Guest URL Upload:</label></td>
        <td>
          <select name="config[GuestUpload]" id="c_url_guest">
            <option value="1">Enabled</option>
            <option value="0"<?php if ($config['GuestUpload'] == '0') echo ' selected="selected"';?>>Disabled</option>
          </select>
        </td>
      </tr>
	  
	  
      <tr>
        <td><label for="c_url_member">Member URL Upload:</label></td>
        <td>
          <select name="config[MemberUpload]" id="c_url_member">
            <option value="1">Enabled</option>
            <option value="0"<?php if ($config['MemberUpload'] == '0') echo ' selected="selected"';?>>Disabled</option>
          </select>
        </td>
      </tr>
	  
	  
	  
	  
	        <tr>
        <td><label for="MemberRegistration">Allow Registration:</label></td>
        <td>
          <select name="config[MemberRegistration]" id="MemberRegistration">
            <option value="1">Yes</option>
            <option value="0"<?php if ($config['MemberRegistration'] == '0') echo ' selected="selected"';?>>No</option>
          </select>
        </td>
      </tr>

	        <tr>
        <td><label for="EmailValidation">Validate User Email:</label></td>
        <td>
          <select name="config[EmailValidation]" id="EmailValidation">
            <option value="1">Yes</option>
            <option value="0"<?php if ($config['EmailValidation'] == '0') echo ' selected="selected"';?>>No</option>
          </select>
        </td>
      </tr>

	        <tr>
        <td><label for="Advertisements">Advertisements:</label></td>
        <td>
          <select name="config[Advertisements]" id="Advertisements">
            <option value="2"<?php if ($config['Advertisements'] == '2') echo ' selected="selected"';?>>Enabled For All</option>
            <option value="1"<?php if ($config['Advertisements'] == '1') echo ' selected="selected"';?>>Disabled For Members</option>
            <option value="0"<?php if ($config['Advertisements'] == '0') echo ' selected="selected"';?>>Disabled For All</option>
          </select>
        </td>
      </tr>
	  
	  
	  
	  	        <tr>
        <td><label for="Hotlinking">Image Hotlinking:</label></td>
        <td>
          <select name="config[Hotlinking]" id="Hotlinking">
            <option value="1">Enabled</option>
            <option value="0"<?php if ($config['Hotlinking'] == '0') echo ' selected="selected"';?>>Disabled</option>
          </select>
        </td>
      </tr>	  
	  
	  
      <tr>
        <td><label for="c_gallery_no">Gallery Photo No:</label></td>
        <td><input type="text" name="config[GalleryPhotoNo]" id="c_gallery_no" size="30" value="<?php echo $config['GalleryPhotoNo'];?>" /></td>
      </tr>
      <tr>
        <td><label for="c_gallery_perpage">Gallery Photo Per Page:</label></td>
        <td><input type="text" name="config[GalleryPhotoPerPage]" id="c_gallery_perpage" size="30" value="<?php echo $config['GalleryPhotoPerPage'];?>" /></td>
      </tr>
      <tr>
        <td><label for="c_ad_homeleft">Home Left Advertisement:</label></td>
        <td><textarea name="config[homeleft]" id="c_ad_homeleft" cols="40" rows="5"><?php echo $config['homeleft'];?></textarea></td>
      </tr>
      <tr>
        <td><label for="c_ad_header">Header Advertisement:</label></td>
        <td><textarea name="config[header]" id="c_ad_header" cols="40" rows="5"><?php echo $config['header'];?></textarea></td>
      </tr>
      <tr>
        <td><label for="c_ad_footer">Footer Advertisement:</label></td>
        <td><textarea name="config[footer]" id="c_ad_footer" cols="40" rows="5"><?php echo $config['footer'];?></textarea></td>
      </tr>
	  
	  
	  
	  
	  
	  
      <tr>
        <td></td>
        <td><input type="submit" value="Continue" /></td>
      </tr>
    </tbody>
  </table>
</form>
<?php
}//Step 2
//Step 3
if($_GET['step'] == 3){
	//Connect to database
	require_once $db_file;
	if(!@mysql_connect($db_server, $db_user, $db_password) || !@mysql_select_db($db_name))
		http_redirect($self);
?>

<center>
<h1>Scripteen Free Image Hosting Script v2.7 Installer</h1>
<h2>Step 3 of 3</h1>
<p>Create administrator account</p></center>
<?php
if(isset($errors) && sizeof($errors) > 0)
	output_error($errors);
?>

<form action="<?php echo $self;?>?step=3" method="post">
  <table>
    <tbody>
      <tr>
        <td><label for="admin_login">Admin username:</label></td>
        <td><input type="text" name="admin_login" id="admin_login" size="30" value="<?php echo $admin_login;?>" /></td>
      </tr>
      <tr>
        <td><label for="admin_password">Admin password:</label></td>
        <td><input type="password" name="admin_password" id="admin_password" size="30" value="" /></td>
      </tr>
      <tr>
        <td><label for="admin_password2">Re-type password:</label></td>
        <td><input type="password" name="admin_password2" id="admin_password2" size="30" value="" /></td>
      </tr>
      <tr>
        <td><label for="admin_email">Email address:</label></td>
        <td><input type="text" name="admin_email" id="admin_email" size="30" value="<?php echo $admin_email;?>" /></td>
      </tr>
      <tr>
        <td></td>
        <td><input type="submit" value="Finish" /></td>
      </tr>
    </tbody>
  </table>
</form>
<?php
}//Step 3
//Step 4 - congratulate 'em

if($_GET['step'] == 4){
?>
<h1>Installation Complete</h1>
<p>Our congratulations&nbsp;&mdash; The installation process is complete and you can finally enjoy the ultimate ease of our script.</p>
<p>As a last step, connect to your hosting accout via FTP and <strong>delete install.php file</strong>!</p>
<p>Thank you for choosing <a href="http://www.scripteen.com/scripts/scripteen-free-image-hosting-script.html">Scripteen Free Image Hosting Script</a>.</p>
<div style="padding:15px; border:1px solid #FF6666">
<p><strong>PLEASE NOTE!!</strong> - We take pride in our scripts and allowing free scripts. Although we offer free scripts, these scripts MUST contain the footer link to Scripteen.</p>
<p><strong><?php echo this_install_url(); ?></strong> Has been submitted to our servers. If you have purchased the link removal license simply past the key in the footer commented out. Otherwise do not remove the link in the footer.
<script src="http://www.scripteen.com/tracker/?url=<?php echo this_install_url(); ?>" type="text/javascript"></script>
</div>
<?php
}//Step 4

?>
</div></div>
<?php
include 'footer.php';
function this_install_url(){
	$pageURL = 'http';
	if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
	$pageURL .= "://";
	if ($_SERVER["SERVER_PORT"] != "80" && $_SERVER["SERVER_PORT"] != "443") {
	$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	} else {
	$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	} return $pageURL;
}
?>