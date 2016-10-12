CREATE TABLE `users` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`oauth_provider` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
	`oauth_uid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
 	`fname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
 	`lname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
 	`email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
 	`gender` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
 	`locale` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
	`gpluslink` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
 	`picture` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
 	`created` datetime NOT NULL,
 	`modified` datetime NOT NULL,
 	`travelfrom` varchar(3),
 	`travelto` varchar(3),
 	`traveldate` varchar(30),
 	`traveltime` varchar(30),
 	`flightno` varchar(30),
 	`emailvisible` int(1) DEFAULT 1,
 	`phoneno` varchar(15),
 	`phonenovisible` int(1) DEFAULT 1,
 	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `requests`(
	`r_id` int(11) NOT NULL AUTO_INCREMENT,
	`from_uid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
	`to_uid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
	`seen` int(3) DEFAULT 0,
	PRIMARY KEY (`r_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;