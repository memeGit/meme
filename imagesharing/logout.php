<?php
session_start();

session_destroy();
      setcookie("cookname", "", time()-60*60*24*365, "/");
      setcookie("cookpass", "", time()-60*60*24*365, "/");
	header("Location: index.php");
	exit;
?> 
