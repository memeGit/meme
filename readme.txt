[1]install wamp:
	open php mode:
		1.php_curl
		2.short open tag
	turn off the warning, in PHP.ini:
		1.error_reporting = E_ERROR
		2.display_errors = Off

[2] localhost/meme/imagesharing/install.php


[3] create table iusers for database freeimage

CREATE TABLE `iusers` (
    `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `oauth_provider` VARCHAR(10),
    `oauth_uid` text,
    `oauth_token` text,
    `oauth_secret` text,
    `username` text,
    PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

[4] localhost/meme/index.php

