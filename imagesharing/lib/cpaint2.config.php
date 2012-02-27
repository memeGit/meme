<?php
/**
* CPAINT (Cross-Platform Asynchronous INterface Toolkit)
*
* http://sf.net/projects/cpaint
*
* released under the terms of the GPL
* see http://www.fsf.org/licensing/licenses/gpl.txt for details
*
* Configuration file for backend scripts, including proxy
*
* @package    CPAINT
* @author     Paul Sullivan <wiley14@gmail.com>
* @author     Dominique Stender <dstender@st-webdevelopment.de>
* @copyright  Copyright (c) 2005-2006 Paul Sullivan, Dominique Stender - http://sf.net/projects/cpaint
* @version 	  $Id: cpaint2.config.php 307 2006-09-30 08:17:43Z saloon12yrd $
*/

//---- initialization ----------------------------------------------------------
  $cpaint2_config                       = array();
//  $cpaint2_config['proxy']              = array();
//  $cpaint2_config['proxy']['security']  = array();

  $cpaint2_proxy_whitelist  = array();

//---- proxy settings ----------------------------------------------------------
  // Use the whitelist for allowed URLs?
	$cpaint2_config['proxy']['security']['use_whitelist']    = true;
	// setting for PHP's error reporting
	$cpaint2_config['proxy']['security']['error_reporting']  = E_ALL ^ E_NOTICE ^ E_WARNING;
	// maximum runtime of the proxy script in seconds. Set to -1 to use PHP's defaults
	$cpaint2_config['proxy']['time_limit']                   = -1;
	// number of seconds for the proxy to wait until a connection is established
	$cpaint2_config['proxy']['connect_timeout']              = 10;
	/* number of miliseconds to wait for the remote server to answer after the
      proxy has sent its request.
      Set to -1 if no specific value is to be used. */
	$cpaint2_config['proxy']['stream_timeout']               = 2000;
	/* whether or not to use the CURL (Client URL) library for connections
	   Possible values:
	   0 - Attempt to use PHP's fsockopen function (default for backwards compatibility)
	   1 - Attempt to use CURL
	   2 - Try socket functions first, failover to CURL
	   3 - Try CURL first, failover to socket functions
	   
	   Note:  The failover condition is reached when the appropriate function for opening
	   the connection to the remote server is not available.  If both methods fail, then 
	   a non-recoverable error will occur and a message will be passed to the frontend.
	   
	   This condition is different from the host being unreachable, which will return
	   an error, regardless which method is used for attempting the connection.
	*/
	$cpaint2_config['proxy']['use_curl']					= 0;

//---- proxy security whitelist ------------------------------------------------
	/* 	whitelist data should be added to the variable $cpaint2_proxy_whitelist[]
			example: $cpaint2_proxy_whitelist[] = "example.com/test.php";
				- or -
			example: $cpaint2_proxy_whitelist[] = "example.com";
			** Omit http:// and https:// from the URL **
	*/
	// this server
	$cpaint2_proxy_whitelist[] = $_SERVER['HTTP_HOST'];
	// needed for the proxy_ping example
	$cpaint2_proxy_whitelist[] = 'www.salcms.de/test/cpaint2/examples/ping/';
	// needed for the google request example
	$cpaint2_proxy_whitelist[] = 'www.google.com';

?>