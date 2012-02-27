<?
session_start();
require_once("../inc/config.php"); 
require_once("../lib/cpaint2.inc.php"); 
require_once ("../inc/ftp.class.php");


        $link = mysql_connect($db_server, $db_user, $db_password) or die("Could not connect.");
        mysql_select_db($db_name) or die("Could not select database.");
		
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

if($auth_gid=="1" || $auth_gid=="2") {


$uid=check_input($_POST['uid']);
$uname=check_input($_POST['uname']);
$pass=check_input($_POST['pass']);
$md5_pass=md5($pass);
$ugid=check_input($_POST['ugid']);
$status=check_input($_POST['status']);

function chkupdate($uid,$uname,$fname,$lname,$email,$auth_gid,$status,$pass)
{
 global $cp;
$msg="";

$sql="select count(*) as total1 from users where username='$uname' and userid!=$uid";
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
$sql="select count(*) as total from users where email='$email' and userid!=$uid";
$result=mysql_query($sql);
while ($row = mysql_fetch_assoc($result)) {
                        $total=$row['total'];
						$xpass=$row['pass'];
        }
if($total)
{
$id="email";
$msg="Duplicate Email address.";
}
}
if($msg=="")
{
        $sql1="update users set fname='$fname',lname='$lname',email='$email',username='$uname',status='$status',usergid='$auth_gid' where userid='$uid'";
        mysql_query($sql1);

				      if ($pass !== '') {
			  		$md5_pass=md5($pass);
			  $sql2="update users set password='$md5_pass' where userid='$uid'";
        mysql_query($sql2);
  }
					  
        $msg="User account successfully updated.";
        $id=1;
}
$x = &$cp->add_node("msg");
$x->set_data($msg);
$x = &$cp->add_node("id");
$x->set_data($id);
//$cp->set_data($msg);
}




function delete($chk)

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





function deleteftp($chk)

{

    global $cp;    

    $filename=explode("|",$chk);    

    unset($filename[0]);

    $fid="";

    foreach ($filename as $fn) {

    if($fn!="" && $fn!="on")

        {

            $fid.="|".$fn;

            $query2 = "delete from ftp where ftpid =".$fn;            

            mysql_query($query2) or die("Could not delete.");

            mysql_free_result($result);            

            $msg="FTP deleted successfully.";

        }

    }    

    

$x = &$cp->add_node("response");

$x->set_data($msg);

$y = &$cp->add_node("fid");

$y->set_data($fid);

}


function ftpstatus($chk,$status)

{

    global $cp;

    if($status=="Enabled")

        $s = 1;
    else

        $s = 0;


    $filename=explode("|",$chk);

    unset($filename[0]);

    $fid="";

    foreach ($filename as $fn) {

    if($fn!="")

    {

        $fid.="|".$fn;



        $sql="update ftp set status=$s where ftpid=$fn";

        mysql_query($sql);

    }

    }



$msg="Selected servers have been $status";

$x = &$cp->add_node("response");

$x->set_data($msg);

$y = &$cp->add_node("fid");

$y->set_data($fid);

$z = &$cp->add_node("status");

$z->set_data($status);



}



function deletereport($chk)

{

    global $cp;    

    $filename=explode("|",$chk);    

    unset($filename[0]);

    $fid="";

    foreach ($filename as $fn) {
	
    if($fn!="" && $fn!="on")

        {

            $fid.="|".$fn;

            $query2 = "delete from reports where id =".$fn."";            

            mysql_query($query2) or die("Could not delete.");

            mysql_free_result($result);            

            $msg="Selected reports have been deleted.";

        }

    }    

    

$x = &$cp->add_node("response");

$x->set_data($msg);

$y = &$cp->add_node("fid");

$y->set_data($fid);

}



function deleteuser($chk)

{

    global $cp, $server_dir;

    

    $filename=explode("|",$chk);    

    unset($filename[0]);

    $fid="";

    foreach ($filename as $fn) {

    if($fn!=""  && $fn!="on")

    {

        $fid.="|".$fn;

        

            $sql="delete from users where userid=$fn";

            mysql_query($sql);

            $query = "SELECT filename, tn_filename, filepath from images where userid = '$fn'";

            $result = mysql_query($query) or die("Query failed.");

            while ($line = mysql_fetch_array($result)) {

                

                // remove image                

                 $file=$server_dir . $line[filename];

                 

                if ( file_exists ( $file))

                unlink($file);

                // remove image from database

                $query2 = "delete from images where filename = '" . $line[filename] . "'";

                mysql_query($query2) or die("Could not delete.");

                $query2 = "delete from imagehits where filename = '" . $line[filename] . "'";

                mysql_query($query2) or die("Could not delete.");

                // remove image thumbnail

                if ($line[tn_filename] != "") {

                    $file=$server_dir . $line[tn_filename];

                 if ( file_exists ( $file))

                    unlink($file);

                }

            }

            mysql_free_result($result);

            

            $msg="User deleted successfully.";

        }

    }        

    

$x = &$cp->add_node("response");

$x->set_data($msg);

$y = &$cp->add_node("fid");

$y->set_data($fid);



}





function activateuser($chk,$status)

{

    global $cp;

    if($status=="Activated")

        $s = 1;

    else

        $s = 2;



    $filename=explode("|",$chk);

    unset($filename[0]);

    $fid="";

    foreach ($filename as $fn) {

    if($fn!="")

    {

        $fid.="|".$fn;



        $sql="update users set status=$s where userid=$fn";

        mysql_query($sql);

    }

    }



$msg="Selected users have been $status";

$x = &$cp->add_node("response");

$x->set_data($msg);

$y = &$cp->add_node("fid");

$y->set_data($fid);

$z = &$cp->add_node("status");

$z->set_data($status);



}



function changeusergroup($chk,$group)

{

    global $cp;

    if($group=="Admin") { $g = 1; }

    if($group=="Moderator") { $g = 2; }

    if($group=="Member") { $g = 3; }



    $filename=explode("|",$chk);

    unset($filename[0]);

    $fid="";

    foreach ($filename as $fn) {

    if($fn!="")

    {

        $fid.="|".$fn;



        $sql="update users set usergid=$s where userid=$fn";

        mysql_query($sql);

    }

    }



$msg="User Edited successfully.";

$x = &$cp->add_node("response");

$x->set_data($msg);

$y = &$cp->add_node("fid");

$y->set_data($fid);

$z = &$cp->add_node("group");

$z->set_data($group);



}




}

$cp = new cpaint();
$cp->register('chkupdate');
$cp->register('delete');  
$cp->register('deleteuser');
$cp->register('deletereport');  
$cp->register('activateuser');
$cp->register('changeusergroup');
$cp->register('deleteftp'); 
$cp->register('ftpstatus'); 
$cp->start();
$cp->return_data();
?>