CREATE TABLE IF NOT EXISTS `#__cwtraffic_storage` (
  `tag` varchar(255) NOT NULL,
  `lastcheck` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `lastsent` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `data` longtext DEFAULT NULL,
   PRIMARY KEY (`tag`(100))
) DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `#__cwtraffic_whoisonline`
ADD COLUMN `iphash` BINARY(20) NOT NULL,
ADD KEY `idx_ip` (`ip`),
ADD KEY `idx_iphash` (`iphash`),
ADD KEY `idx_dt` (`dt`),
ADD KEY `idx_ipdt` (`ip`,`dt`),
ADD KEY `idx_iphashdt` (`iphash`,`dt`),
ADD UNIQUE KEY `unique_dt_ip` (`dt`, `ip`),
ADD UNIQUE KEY `unique_dt_iphash` (`dt`, `iphash`);