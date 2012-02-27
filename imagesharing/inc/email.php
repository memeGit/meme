<?
	$email = $_POST['email'];

	$url1 = $_POST['url1'];

	$url2 = $_POST['url2'];

	$url3 = $_POST['url3'];

	$url4 = $_POST['url4'];

	$url5 = $_POST['url5'];
	
	$url6 = $_POST['url6'];

	$ok = false;

	if ($email != "") {

		$subject = "Here are your URL's from " . $site_name . "!";

		$message = "Your uploaded image is now available from anywhere on the Internet!\n\n\n";

		if ($url1 != "") {

			$message .= "Link for viewing the photo:\n\n";
				foreach($url1 as $tmp)
				{
			$message .= "$tmp\n\n";
			}

		}

		if ($url2 != "") {

			$message .= "Link directly to your photo:\n\n";
			foreach($url2 as $tmp)
				{
			$message .= "$tmp\n\n";
			}

		}

		if ($url3 != "") {

			$message .= "Link directly to photo thumbnail:\n\n";
			foreach($url3 as $tmp)
				{
			$message .= "$tmp\n\n";
			}

		}

		if ($url4 != "") {

			$message .= "Link to post the photo in a forum:\n\n";
			foreach($url4 as $tmp)
				{
			$tmp = stripslashes($tmp);
			$message .= "$tmp\n\n";
			}

		}

		if ($url5 != "") {

			$message .= "Link to post the thumbnail in a forum:\n\n";
			foreach($url5 as $tmp)
				{
			$tmp = stripslashes($tmp);
			$message .= "$tmp\n\n";
			}

		}
		
		
				if ($url6 != "") {

			$message .= "Link to photo in your website:\n\n";
			foreach($url6 as $tmp)
				{
			$tmp = stripslashes($tmp);
			$message .= "$tmp\n\n";
			}

		}
		
		

		$message .= "\nThank you for using " . $site_name . " for your image hosting.\n\n";

		$message .=  $site_name . "\n";

		$message .=  $support_email . "\n";

		$headers .= "From: " . $site_name . " <" . $support_email . ">\r\n";

		mail($email, $subject, $message, $headers);

		$ok = true;

	}

?>