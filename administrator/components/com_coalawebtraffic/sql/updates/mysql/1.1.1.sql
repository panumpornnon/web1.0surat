--
-- Create new locations table for keeping location counts
--
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
  `auto` tinyint(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_unicode_ci;

--
-- Enlarge columns to avoid data loss on later conversion to utf8mb4
--
ALTER TABLE `#__cwtraffic_knownips` MODIFY `alias` varchar(400) NOT NULL DEFAULT '';

--
-- Convert all tables to utf8mb4 character set with utf8mb4_unicode_ci collation
--
ALTER TABLE `#__cwtraffic` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `#__cwtraffic_knownips` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `#__cwtraffic_whoisonline` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `#__cwtraffic_total` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

--
-- Set collation to utf8mb4_bin for formerly utf8_bin collated columns
--
ALTER TABLE `#__cwtraffic_knownips` MODIFY `alias` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '';

--
-- Set default character set and collation for all tables
--
ALTER TABLE `#__cwtraffic` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `#__cwtraffic_knownips` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `#__cwtraffic_whoisonline` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `#__cwtraffic_total` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;