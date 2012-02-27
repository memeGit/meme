<?
session_start();
require_once("inc/config.php"); 
require_once("lib/cpaint2.inc.php"); 
require_once ("inc/ftp.class.php");


        $link = mysql_connect($db_server, $db_user, $db_password) or die("Could not connect.");
        mysql_select_db($db_name) or die("Could not select database.");
$uname=check_input($_POST['uname']);
$pass=check_input($_POST['pass']);
$pass1=check_input($_POST['pass1']);
$pass2=check_input($_POST['pass2']);
$ugid=check_input($_POST['ugid']);
$md5_pass2=md5($pass2);
$r_reporterid=check_input($_POST['r_reporterid']);
$r_uploaderid=check_input($_POST['r_uploaderid']);
$r_timestamp=check_input($_POST['r_timestamp']);
$r_imagename=check_input($_POST['r_imagename']);
$r_ip=check_input($_POST['r_ip']);
$md5_pass=md5($pass);
$validation = $config['EmailValidation'];
$registration = $config['MemberRegistration'];
$d_filename=check_input($_POST['d_filename']);

if(isset($_COOKIE['cookname'])){

 $vname = check_input($_COOKIE['cookname']); 
 $vpass = check_input($_COOKIE['cookpass']); 

 $result = mysql_query("select * from users where username='$vname' and password='$vpass'");
	
	if(mysql_num_rows($result) ==0) {
	header("Location: logout.php");
	exit;
	}

else {	
	while ($row = mysql_fetch_assoc($result)) { 				
			$auth_id=$row['userid'];
			$auth_gid=$row['usergid'];						
			$auth_name=$row['username'];
			$auth_pass=$row['password'];
			$auth_status=$row['status'];
	}


	}

	}
	
	else {

$auth_id=$_SESSION['userid'];
$auth_gid=$_SESSION['usergid']; 
$auth_name=$_SESSION['username'];
$auth_pass=$_SESSION['password'];
$auth_status=$_SESSION['status'];
}
if (!$auth_id || empty($auth_id) || $auth_id==""){
	$auth_id = 0;
}
if (!$auth_gid || empty($auth_gid) || $auth_gid==""){
	$auth_gid = 0;
}

function usersignup($uname,$fname,$lname,$email,$pass,$md5_pass,$validation,$registration)
{
 global $cp, $support_email, $site_name, $server_url, $validation, $registration;
$msg="";

if ($registration == 0) { // registration disabled
$id="registration";
$msg="Registration Disabled!";
}


$sql="select count(*) as total1 from users where username='$uname'";
$result=mysql_query($sql);
while ($row = mysql_fetch_assoc($result)) {
         $total1=$row['total1'];
        }
if($total1)
{
$id="uname";
$msg="Duplicate username.";
}

if($msg=="")
{
$sql="select count(*) as total from users where email='$email'";
$result=mysql_query($sql);
while ($row = mysql_fetch_assoc($result)) {
                        $total=$row['total'];
        }
if($total)
{
$id="email";
$msg="Duplicate Email address.";
}

if(strlen($pass) < 6 ) {
$id="pass";
$msg="Password is too short! Password should be 6 characters minimum.";
	 } 

}
if($msg=="")
{

if ($validation == 1) { // email verification is enabled

        $ip = $_SERVER['REMOTE_ADDR'];
		$time = time();
        $md5_pass=md5($pass);
        $sql="insert into users set fname='$fname',lname='$lname',joindate='$time',email='$email',username='$uname',password='$md5_pass',ip='$ip'";
        mysql_query($sql);
        $msg="Your Account has been Successfully Registered. Please check your email to verify your account";
        $id=1;
        $uid = mysql_insert_id();
        
        ///Mail User
        $subject = "Verify Your email";
        $to = $email;
        $from = $support_email;
        $body= "Hello $uname, <br /> Welcome to $site_name.<br /> To activate your account click the following link<br /> $server_url/verify.php?code=$time <br /> --------------------------<br /> This is an automated E-mail from <br />  $site_name ";
                $headers = "From: " . $from . "\n";
                $headers .= "X-Sender: <" . "$to" . ">\n";
                $headers .= "Return-Path: <" . "$to" . ">\n";
                $headers .= "Error-To: <" . "$to" . ">\n";
                $headers .= "Content-Type: text/html\n";
                mail($to,$subject,$body,$headers);
				
								}  }
								
if($msg=="")
{								
								if ($validation == 0) { // email verification is disabled

        $ip = $_SERVER['REMOTE_ADDR'];
		$time = time();
        $md5_pass=md5($pass);
        $sql="insert into users set fname='$fname',lname='$lname',joindate='$time',email='$email',username='$uname',password='$md5_pass',ip='$ip',status='1'";
        mysql_query($sql);
        $msg="Your Account has been successfully registered and activated!";
        $id=1;
        $uid = mysql_insert_id();
        
		
								}


} 





$x = &$cp->add_node("msg");
$x->set_data($msg);
$x = &$cp->add_node("id");
$x->set_data($id);
//$cp->set_data($msg);
}



function chkprofileupdate($uname,$fname,$lname,$email,$oldpass,$pass1,$pass2,$auth_id)
{
 global $cp;
$msg="";

$sql="select count(*) as total1 from users where username='$uname' and userid!=$auth_id";
$result=mysql_query($sql);
while ($row = mysql_fetch_assoc($result)) {
         $total1=$row['total1'];
        }
if($total1)
{
$id="uname";
$msg="Duplicate username.";
}

if($msg=="")
{
$sql="select count(*) as total from users where email='$email' and userid!=$auth_id";
$result=mysql_query($sql);
while ($row = mysql_fetch_assoc($result)) {
                        $total=$row['total'];
        }
if($total)
{
$id="email";
$msg="Duplicate Email address.";
}
}



if($msg=="")
{

        $sql="update users set fname='$fname',lname='$lname',email='$email' where username='$uname'";
        mysql_query($sql);
		
		      if ($pass2 !== '') {
		  		$md5_oldpass=md5($oldpass);
			  	$result = mysql_query("select * from users where username='$uname' and password='$md5_oldpass'");
	
	if(mysql_num_rows($result) ==0) {
$id="oldpass";
$msg="Incorrect old pass!";
	} else {
				  		$md5_pass2=md5($pass2);
			  $sql2="update users set password='$md5_pass2' where username='$uname'";
        mysql_query($sql2);

		} } }
if($msg=="")
{

        $msg="Your profile successfully updated!";
        $id=1;
} 
$x = &$cp->add_node("msg");
$x->set_data($msg);
$x = &$cp->add_node("id");
$x->set_data($id);
//$cp->set_data($msg);
}



function forgetpass($email,$code)
{
 global $cp, $support_email, $site_name, $server_url, $code;
$msg="";

$sql="select * from users where email='$email'";
$result=mysql_query($sql);
while ($row = mysql_fetch_assoc($result)) {
         $pass=$row['password'];
		 $uname=$row['username'];
        }
if($pass=="")
{        
    $msg="Wrong Email address provided.";
    $id=1;
}

else 
{
        $ip = $_SERVER['REMOTE_ADDR'];
		$code = rand(1111111111,9999999999);

		$sql="UPDATE users SET code='$code' where email='$email'"; 
        mysql_query($sql);
		@mysql_close();

        ///Mail User
        $subject = "Password reset confirmation";
        $to = $email;
        $from = $support_email;
        $body= "Hello $uname, <br /><br /> 
		We have received a request from IP address $ip  to reset your account password. <br /><br /> To reset your password click the link below <br /><br />  $server_url/resetpassword.php?code=$code <br /><br /> If you didn't make this request just ignore this message. <br /><br /><br />-------------------------------------<br /> This is an automated E-mail from <br />  $site_name ";
                $headers = "From: " . $from . "\n";
                $headers .= "X-Sender: <" . "$to" . ">\n";
                $headers .= "Return-Path: <" . "$to" . ">\n";
                $headers .= "Error-To: <" . "$to" . ">\n";
                $headers .= "Content-Type: text/html\n";
                mail($to,$subject,$body,$headers);
				

    $msg="Please check your email for the password recovery link.";
    $id=1;

	}


$x = &$cp->add_node("msg");
$x->set_data($msg);
$x = &$cp->add_node("id");
$x->set_data($id);
//$cp->set_data($msg);
}





function u_deleteimage($authid,$chk)

{

    global $cp, $server_dir;  
    

    $filename=explode("|",$chk);    

    unset($filename[0]);

    $fid="";

    foreach ($filename as $fn) {
	

			if($fn!="" && $fn!="on")

    {

            $fid.="|".$fn;

            

            $query = "SELECT * from images where filename = '$fn'";

            $result = mysql_query($query) or die("Query failed.");

            while ($line = mysql_fetch_array($result)) {

                if ($line[userid]!=$authid) {
				
            $msg="You don't have permission to delete this photo!";
				
				}
				
				else {
				
				if($line[ftpid]>0)
				{
					$query = "select * from ftp where ftpid=".$line[ftpid]." limit 1";

					$result2 = mysql_query($query) or die("Query failed.");

					while ($row = mysql_fetch_array($result2)) 
				    {

					        $ftpid=$row['ftpid'];

					        $path=$row['name'];        

					        $url=$row['dir'];        

					        $host=$row['host'];        

					        $user=$row['user'];        

					        $pass=$row['ftppass'];        
				    }
					if($ftpid>0)
					{
						$ftp =& new FTP();
						if ($ftp->connect($host)) {
							if ($ftp->login($user,$pass)) {
								$ftp->chdir($path);
								$ftp->delete($line[filename]);
								$ftp->delete($line[tn_filename]);								
							}
						}
					}

				}
				else
				{
	                // remove image                
	                $file=$server_dir . $line[filename];

	                if ( file_exists ( $file))

	                unlink($file);

	                // remove image thumbnail

	                if ($line[tn_filename] != "") {

	                    $file=$server_dir . $line[tn_filename];

	                 if ( file_exists ( $file))

	                    unlink($file);

	                }
					

				}
	                // remove image from database

	                $query2 = "delete from images where filename = '" . $line[filename] . "'";

	                mysql_query($query2) or die("Could not delete.");

	                $query2 = "delete from imagehits where filename = '" . $line[filename] . "'";

	                mysql_query($query2) or die("Could not delete.");
				

            mysql_free_result($result);

            $msg="Selected photos have been deleted!";

			} // else
			
			} // result
			
        } 

    }    // loop



    

$x = &$cp->add_node("response");

$x->set_data($msg);

$y = &$cp->add_node("fid");

$y->set_data($fid);

} // func


function reportimage($r_reporterid,$r_uploaderid,$r_timestamp,$r_imagename,$r_ip)

{
 global $cp;
$msg="";
if($msg=="")
{
        $sql="insert into reports set reporterid='$r_reporterid',uploaderid='$r_uploaderid',timestamp='$r_timestamp',imagename='$r_imagename',ip='$r_ip'";
        mysql_query($sql);
        $msg="Thanks for reporting this photo. Our staff will review it soon.";
        $id=1;
}		
		
$x = &$cp->add_node("msg");
$x->set_data($msg);
$x = &$cp->add_node("id");
$x->set_data($id);

}



function imgstatus($chk,$status)
{
    global $cp;

    if($status=="Private")

        $s = 1;
		
    if($status=="Public")

        $s = 0;
		
		$filename=explode("|",$chk);
    unset($filename[0]);
    $fid="";
    foreach ($filename as $fn) {
    if($fn!="")
    {
        $fid.="|".$fn;
        $sql="update images set prv='$s' where filename='$fn'";
        mysql_query($sql);
    }
    }
$msg="Selected images are now set to $status";

$x = &$cp->add_node("response");

$x->set_data($msg);

$y = &$cp->add_node("fid");

$y->set_data($fid);

$z = &$cp->add_node("status");

$z->set_data($status);



}





		
		
// staff functions		


if($auth_gid=="1" || $auth_gid=="2") {

function deleteimage($chk)

{

    global $cp, $server_dir;  
    

    $filename=explode("|",$chk);    

    unset($filename[0]);

    $fid="";

    foreach ($filename as $fn) {
	

			if($fn!="" && $fn!="on")

    {

            $fid.="|".$fn;

            

            $query = "SELECT filename, tn_filename, filepath, ftpid from images where filename = '$fn'";

            $result = mysql_query($query) or die("Query failed.");

            while ($line = mysql_fetch_array($result)) {

                
				if($line[ftpid]>0)
				{
					$query = "select * from ftp where ftpid=".$line[ftpid]." limit 1";

					$result2 = mysql_query($query) or die("Query failed.");

					while ($row = mysql_fetch_array($result2)) 
				    {

					        $ftpid=$row['ftpid'];

					        $path=$row['name'];        

					        $url=$row['dir'];        

					        $host=$row['host'];        

					        $user=$row['user'];        

					        $pass=$row['ftppass'];        
				    }
					if($ftpid>0)
					{
						$ftp =& new FTP();
						if ($ftp->connect($host)) {
							if ($ftp->login($user,$pass)) {
								$ftp->chdir($path);
								$ftp->delete($line[filename]);
								$ftp->delete($line[tn_filename]);								
							}
						}
					}

				}
				else
				{
	                // remove image                
	                $file=$server_dir . $line[filename];

	                if ( file_exists ( $file))

	                unlink($file);

	                // remove image thumbnail

	                if ($line[tn_filename] != "") {

	                    $file=$server_dir . $line[tn_filename];

	                 if ( file_exists ( $file))

	                    unlink($file);

	                }
					

				}
	                // remove image from database

	                $query2 = "delete from images where filename = '" . $line[filename] . "'";

	                mysql_query($query2) or die("Could not delete.");

	                $query2 = "delete from imagehits where filename = '" . $line[filename] . "'";

	                mysql_query($query2) or die("Could not delete.");
				
            }

            mysql_free_result($result);

            

            $msg="Selected photos have been deleted!";

        }

    }    



    

$x = &$cp->add_node("response");

$x->set_data($msg);

$y = &$cp->add_node("fid");

$y->set_data($fid);

}

function s_delete1image($d_filename)

{
 global $cp;
$msg="";
if($msg=="")
{

        $query1 = "select * from images where filename='$d_filename'";        
        $result1 = mysql_query($query1) or die("Query failed1.");


    while ($line = mysql_fetch_array($result1)) {


				if($line[ftpid]>0)
				{
					$query2 = "select * from ftp where ftpid=".$line[ftpid]." limit 1";

					$result2 = mysql_query($query2) or die("Query failed.");

					while ($row = mysql_fetch_array($result2)) 
				    {

					        $ftpid=$row['ftpid'];

					        $path=$row['name'];        

					        $url=$row['dir'];        

					        $host=$row['host'];        

					        $user=$row['user'];        

					        $pass=$row['ftppass'];        
				    }
					if($ftpid>0)
					{
						$ftp =& new FTP();
						if ($ftp->connect($host)) {
							if ($ftp->login($user,$pass)) {
								$ftp->chdir($path);
								$ftp->delete($line[filename]);
								$ftp->delete($line[tn_filename]);
                                $ftp->close();
								
							}
						}
					}

				}
				else
				{
	                // remove image                
	                $file=$server_dir . $line[filename];

	                if ( file_exists ( $file))

	                unlink($file);

	                // remove image thumbnail

	                if ($line[tn_filename] != "") {

	                    $file=$server_dir . $line[tn_filename];

	                 if ( file_exists ( $file))

	                    unlink($file);

	                }
					

				}
	                // remove image from database

	                $query2 = "delete from images where filename = '" . $line[filename] . "'";

	                mysql_query($query2) or die("Could not delete.");

	                $query2 = "delete from imagehits where filename = '" . $line[filename] . "'";

	                mysql_query($query2) or die("Could not delete.");

                        mysql_close($link);
						
        $msg="This photo has been deleted.";
        $id=1;

                } 
}		
		
$x = &$cp->add_node("msg");
$x->set_data($msg);
$x = &$cp->add_node("id");
$x->set_data($id);

}


}

$cp = new cpaint();
$cp->register('usersignup');
$cp->register('chkprofileupdate');
$cp->register('forgetpass');
$cp->register('u_deleteimage');
$cp->register('deleteimage');  
$cp->register('reportimage');  
$cp->register('imgstatus');  
$cp->register('s_delete1image');  
$cp->start();
$cp->return_data();
?>