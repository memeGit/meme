<?
//ob_start();
session_start();
$auth_id=$_SESSION['userid'];
if (!$auth_id || empty($auth_id) || $auth_id==""){
$auth_id = 0;
}
require_once("config.php"); 
require_once("limits.php"); 
require_once("ftp.class.php");
require_once("func.php"); 

$link = mysql_connect($db_server, $db_user, $db_password) or die("Could not connect to the database.");

mysql_select_db($db_name) or die("Could not select the database.");

if ($config[Uploads] == 0) {

$msg= "<center><b><br><br><br>Uploads are temporarily disabled by the site admin</center></b>";
}

else if ($config[Uploads] == 1 && !$auth_id) {

$msg= "<center><b><br><br><br>You have to <a href=\"register.php\" title=\"Register\">Register</a> before you will be able to upload photos.</center></b>";
}


$query = "select count(*) as total from ftp where status=1";

$result = mysql_query($query) or die("Query failed.");


while ($row = mysql_fetch_array($result))

{

$total=$row[total];
}


if($total<=0)

    {

    $no_server="1";

    $ftpid=0;

    $url=$server_url."/images/";

    }

else

{

$query = "select * from ftp where status=1 ORDER BY RAND() limit 1";

$result = mysql_query($query) or die("Query failed.");

while ($row = mysql_fetch_array($result)) 

    {

            $no_server="0";

        $ftpid=$row['ftpid'];

        $path=$row['name'];        

        $url=$row['dir'];        

        $host=$row['host'];        

        $user=$row['user'];        

        $pass=$row['ftppass'];        

    }    

 }

// get variables for fields on upload screen                

        $tos = $_POST['tos'];        

        $prv = $_POST['prv'];        

                if($prv!="1")

                $prv=0;

        

        $uploaderip = $_SERVER['REMOTE_ADDR'];
		
        $messages="";

        $msg="";

        $newID="";

        $FileName="";

        $FileFile="";

        $FileUrl="";

        $FileUrlLink="";

        $FiletnUrl="";

        // check for blocked ip address

        if ($uploaderip != "") {
      
                $query = "select ip from blocked where ip = '$uploaderip'";

            $result = mysql_query($query) or die("Query failed.");

                $num_rows = mysql_num_rows($result);



                if ($num_rows > 0) {

                        $msg= "Your IP address (".$uploaderip.") has been blocked from using this service.";

                }



        }


if ($config[AcceptTerms]=="1"){

if ($tos=="") 

                {

                    $msg= "You must check the box stating you agree to our terms.";

                    echo "<script language='javascript'>parent.upload('".$msg."','".$newID."','".$messages."','".$FileName."','".$FileFile."','".$FileUrl."','".$FileUrlLink."','".$FiletnUrl."','".$page_url."','".$server_url."','".$site_name."','".$HotLink."');</script>";

                }
				
				}

if($msg=="")
{



// check for a file

for($i=0;$i<=14;$i++)

{

        $err="0";

        $thefile = $_FILES['thefile'.$i];        

				
				

        if ($thefile['name']!="") 

                {


        // check for valid file extension

$path_parts = pathinfo($thefile['name']);
		
$file_ext = strtolower($path_parts['extension']);
			  
		
        if ($err == "0") 

                {

                        // check for valid file type

                        if (!in_array_nocase($file_ext, $valid_file_ext)) 

                                {

                                        $messages.= "|<em>".$thefile['name']."</em> is not in a valid format (".$valid_mime_types_display.")";

                                        

                                        $err="1";

                                }                        

                }
				
  
 if ($err == "0") {        
   // check for valid image file
$imageinfo = getimagesize($_FILES['thefile0']['tmp_name']);

if(!eregi('image',$imageinfo['mime'])) {

$messages.="|". "Sorry, This is not a valid image file!";
  $err="1";  } }

  

                if ($err == "0") 

                {        

                    

                     // check for valid file size

                        if ($thefile['size'] > ($max_file_size_b)) 

                                {
                $filesizemb =($thefile['size']/1048576);
				$filesizemb = number_format($filesizemb, 3);
				
$messages.="Sorry but this image size is ".$filesizemb." MB which is bigger than the max allowed file size of ".$max_file_size_mb." MB.";

                                        $err="1";        

                                }

                }
				
				
				
				
				
				


        

       // save the file, if no error messages

        if ($err == "0") 

                {

	
	// replace special chars with  spaces
	$thefile['name'] = eregi_replace("[^a-z0-9.]", " ", $thefile['name']);
	
	// Replace multiple spaces with one space
    $thefile['name'] = ereg_replace(' +', ' ', $thefile['name']);
    // Replace spaces with underscore
    $thefile['name'] = str_replace(' ', '_', $thefile['name']);
    // Replace hyphens with underscore
    $thefile['name'] = str_replace('-', '_', $thefile['name']);  
	
	// Replace multiple underscores with one underscore
    $thefile['name'] = ereg_replace('_+', '_', $thefile['name']);


$path_parts = pathinfo($thefile['name']);

// if php < 5.2
              if(!isset($path_parts['filename'])){
                $path_parts['filename'] = substr($path_parts['basename'], 0,strpos($path_parts['basename'],'.'));
              }


$thefile['name'] = strpos($path_parts['filename'], '.');


$thefile['name'] = substr($path_parts['filename'], 0, 22); // limit file name length to 22 chars from the beginning

$thefile['name'] = $thefile['name'] . "." . strtolower($path_parts['extension']);    


    // Generate prefix to add to file name
	
     $prefix = rand(99,999);

    // Add prefix to file name
						
    $newFileName = $prefix . $thefile['name'];    



                        // SAVE THE PICTURE


                        $FileName.="|". newImageName($thefile['name']);

                        $FileFile.="|". $server_dir . $newFileName;

                        $newFile = $server_dir . $newFileName;                        

                        $newFileUrl = $url . $newFileName;

                        $FileUrl.="|". $url . $newFileName;

                        $newFileUrlLink = $server_save_directory . $newFileName;

                        $FileUrlLink.="|". $newFileName;


						 if (in_array_nocase($file_ext, $valid_file_ext)) 

						
                                {

$lx = 3;
if ($file_ext == "jpeg") {
$lx = 4; }

$tnFileName = substr($newFileName, 0, strlen($newFileName) - $lx) . "jpg";
$tnFileName = str_replace('.', '_tn.', $tnFileName);


                                        $tnFile = $server_dir . $tnFileName;

                                        $FiletnUrl.="|". $url . $tnFileName;

                                        $tnFileUrl = $url . $tnFileName;

                                } 

                        else 

                                {

                                        $tnFileName = "";

                                        $tnFile = "";

                                        $tnFileUrl = "";

                                }

                        $filesize = $thefile['size'];

                        $newID = "";

                        if (!@copy($thefile['tmp_name'], $newFile)) 

                                {

                                        $messages.="|". "Please check site settings in admin panel and set proper value for server local path.<br><br>Also please make sure the images folder is chmodded to 0777";

                                } 

                        else 

                                {

                                        // add to database

                                        if($auth_id)        

                                        $uid=$auth_id;

                                        else $uid=0;

                                        

                                        //ftpupload($host,$user,$pass,$path."/".$dir."/".$newFileName,$newFileUrl);                                        

                                        //ftpupload

                                        if($no_server=="0")

                                         {

                                        $ftp =& new FTP();

                                        if ($ftp->connect($host)) {

                                            if ($ftp->login($user,$pass)) {

                                                $ftp->chdir($path);

                                                $ftp->put($newFileName,$newFile);

                                            }

                                        }
										
						//	unlink($newFile);


                                          }

                                        //ftpupload

                                        $date_add=time();


                                        $query = "INSERT INTO images (prv,ftpid,userid,filename, tn_filename, filepath, ip, filesize,added) VALUES ($prv,$ftpid,$uid,'$newFileName', '$tnFileName', '$url', '$uploaderip', $filesize,$date_add)";

                                        

                                        mysql_query($query) or die("Database entry failed.");

                                        $newID.="|". mysql_insert_id();

                                }

		 
		                         if ($file_ext == "jpeg" ||$file_ext == "jpg" || $file_ext == "png" || $file_ext == "gif" || $file_ext == "bmp") 


                                {

                                        if ($file_ext == "jpg") 

                                                {

                                                        $source_id = imagecreatefromjpeg($newFile);

                                                }

                                        if ($file_ext == "jpeg") 

                                                {

                                                        $source_id = imagecreatefromjpeg($newFile);

                                                }												

                                        elseif ($file_ext == "png") 

                                                {

                                                        $source_id = imagecreatefrompng($newFile);

                                                } 

                                        elseif ($file_ext == "gif") 

                                                {

                                                        $source_id = imagecreatefromgif($newFile);

                                                }
												
										 elseif ($file_ext == "bmp") 

                                                {

                                                        $source_id = ImageCreateFromBMP($newFile);

                                                }

                                        $true_width = imagesx($source_id);

                                        $true_height = imagesy($source_id);

                                        // create thumb

                                        if ($true_width > $thumbnail_size_max || $true_height > $thumbnail_size_max) 

                                                {

$ratio1=$true_width/$dest_width;
$ratio2=$true_height/$dest_height;
if($ratio1>$ratio2) {
$thumb_w=$dest_width;
$thumb_h=$true_height/$ratio1;
}
else {
$thumb_h=$dest_height;
$thumb_w=$true_width/$ratio2;
}


 $target_id = imagecreatetruecolor($thumb_w, $thumb_h);

 $target_pic = imagecopyresized($target_id, $source_id, 0, 0, 0, 0, $thumb_w, $thumb_h, $true_width, $true_height);
 

                                                        // create a thumbnail in JPEG format

                                                        imagejpeg($target_id, $tnFile, 100);

                                                        imagedestroy($target_id);

                                                } 

                                        else 

                                                {

                                                        copy($newFile, $tnFile);

                                                }

                                        if($no_server=="0")

                                         {

                                            $ftp->put($tnFileName,$tnFile);

                                            $ftp->close();

                                            if(file_exists($newFile))

                                            {

                                             unlink($newFile);

                                            }

                                            if(file_exists($tnFile))

                                            {

                                             unlink($tnFile);

                                            }

                                            }

                                }

                }

                

} 
             

} 

mysql_close($link);

        // create URL links to display to user



        $showURL1 = false;  // image on hosted page - image only



        $showURL2 = false;  // direct link to file - all



        $showURL3 = false;  // HTML for img - image only



        $showURL4 = false;  // [img][/img] tags - image only



        $showURL5 = false;  // thumbnail pic - image only







        // determine flags



        $showURL2 = true;



        if ($file_ext == "jpg" || $file_ext == "jpeg"|| $file_ext == "gif" || $file_ext == "png" || $file_ext == "bmp") {



                $showURL1 = true;



                $showURL3 = true;



                $showURL4 = true;



        }



        if ($file_ext == "jpg" || $file_ext == "gif" || $file_ext == "png"|| $file_ext == "jpeg" || $file_ext == "bmp") {

                        $showURL5 = true;                        

        }

                    echo "<script language='javascript'>parent.upload('".$msg."','".$newID."','".$messages."','".$FileName."','".$FileFile."','".$FileUrl."','".$FileUrlLink."','".$FiletnUrl."','".$page_url."','".$server_url."','".$site_name."','".$HotLink."');</script>";


}
else
{
	echo "<script language='javascript'>parent.uploaderror('".$msg."');</script>";
	exit;
}



        function newImageName($fname) {



                $timestamp = time();



                $new_image_file_ext = substr($fname, strlen($fname) - 3, strlen($fname));



                if ($new_image_file_ext == "peg") {



                        $ext = ".jpg";



                } else {



                        $ext = "." . $new_image_file_ext;



                }



                $newfilename = randString() . substr($timestamp, strlen(timestamp) - 4, strlen(timestamp)) . $ext;

                

                return $newfilename;



        }







        function randString() {



                $newstring="";



                while(strlen($newstring) < 3) {



                        $randnum = mt_rand(0,61);



                        if ($randnum < 10) {



                                $newstring .= chr($randnum + 48);



                        } elseif ($randnum < 36) {



                                $newstring .= chr($randnum + 55);



                        } else {



                                $newstring .= chr($randnum + 61);



                        }



                }



                return $newstring;



        }







        function in_array_nocase($item, $array) {



                $item = &strtoupper($item);



                foreach($array as $element) {



                        if ($item == strtoupper($element)) {



                                return true; 



                        }



                }



                return false;



        } 



?>