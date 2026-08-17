CREATE TABLE IF NOT EXISTS `#__cwtraffic` (
  `id` int(11) NOT NULL auto_increment,
  `tm` int NOT NULL,
  `ip` varchar(50) NOT NULL DEFAULT '0.0.0.0',
  `iphash` BINARY(20) NOT NULL,
  `browser` varchar(255) NOT NULL,
  `bversion` varchar(255) NOT NULL,
  `platform` varchar(255) NOT NULL,
  `referer` varchar(255) NOT NULL,
  `country_code` varchar( 10 )DEFAULT NULL,
  `country_name` varchar( 50 )DEFAULT NULL,
  `city` varchar( 50 )DEFAULT NULL,
  `useragent` varchar(1024) NULL,
  `continent_code` varchar(50) NULL,
  `location_latitude` decimal(10,8) NULL,
  `location_longitude` decimal(11,8) NULL,
  `location_time_zone` varchar(50) NULL,
  PRIMARY KEY  (`id`),
  KEY `idx_ip` (`ip`),
  KEY `idx_iphash` (`iphash`),
  KEY `idx_tm` (`tm`),
  KEY `idx_iptm` (`ip`,`tm`),
  KEY `idx_iphashtm` (`iphash`,`tm`),
  UNIQUE KEY `unique_tm_ip` (`tm`, `ip`),
  UNIQUE KEY `unique_tm_iphash` (`tm`, `iphash`)
) DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `#__cwtraffic_knownips` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `catid` int(11) NOT NULL DEFAULT '0',
  `title` varchar(250) NOT NULL DEFAULT '',
  `alias` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '',
  `ip` varchar(50) NOT NULL DEFAULT '0.0.0.0',
  `botname` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `state` tinyint(1) NOT NULL DEFAULT '0',
  `count` tinyint(1) NOT NULL,
  `checked_out` int(11) NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `archived` tinyint(1) NOT NULL DEFAULT '0',
  `approved` tinyint(1) NOT NULL DEFAULT '1',
  `params` text NOT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(10) unsigned NOT NULL DEFAULT '0',
  `created_by_alias` varchar(255) NOT NULL DEFAULT '',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(10) unsigned NOT NULL DEFAULT '0',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `idx_checkout` (`checked_out`),
  KEY `idx_state` (`state`),
  KEY `idx_catid` (`catid`),
  KEY `idx_createdby` (`created_by`)
) DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `#__cwtraffic_whoisonline` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ip` bigint(20) NOT NULL DEFAULT 0,
  `iphash` BINARY(20) NOT NULL,
  `country_name` varchar(64) NOT NULL DEFAULT '',
  `country_code` varchar(10) NOT NULL DEFAULT '',
  `city` varchar(64) NOT NULL DEFAULT '',
  `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `countrycode` (`country_code`),
  KEY `idx_ip` (`ip`),
  KEY `idx_iphash` (`iphash`),
  KEY `idx_dt` (`dt`),
  KEY `idx_ipdt` (`ip`,`dt`),
  KEY `idx_iphashdt` (`iphash`,`dt`),
  UNIQUE KEY `unique_dt_ip` (`dt`, `ip`),
  UNIQUE KEY `unique_dt_iphash` (`dt`, `iphash`)
) DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `#__cwtraffic_total` (
  `tcount` int(11) NOT NULL
) DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_unicode_ci;

INSERT INTO `#__cwtraffic_total` (`tcount`) VALUES (0);

CREATE TABLE IF NOT EXISTS `#__cwtraffic_locations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `country_code` varchar(10) DEFAULT NULL,
  `country_name` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `continent_code` varchar(50) DEFAULT NULL,
  `location_latitude` decimal(10,8) DEFAULT NULL,
  `location_longitude` decimal(11,8) DEFAULT NULL,
  `location_time_zone` varchar(50) DEFAULT NULL,
  `count` int(10) NOT NULL DEFAULT '0',
  `state` tinyint(3) NOT NULL DEFAULT '0',
  `type` tinyint(3) NOT NULL DEFAULT '1',
  `checked_out` int(10) NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `auto` tinyint(3) DEFAULT '0',
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `#__cwtraffic_storage` (
  `tag` varchar(255) NOT NULL,
  `lastcheck` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `lastsent` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `data` longtext DEFAULT NULL,
   PRIMARY KEY (`tag`(100))
) DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_unicode_ci;

