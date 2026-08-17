-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 17, 2026 at 01:58 AM
-- Server version: 10.2.8-MariaDB
-- PHP Version: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `suratcity2022`
--

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_action_logs`
--

CREATE TABLE `jba8l_action_logs` (
  `id` int(10) UNSIGNED NOT NULL,
  `message_language_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `log_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `extension` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_id` int(11) NOT NULL DEFAULT 0,
  `item_id` int(11) NOT NULL DEFAULT 0,
  `ip_address` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0.0.0.0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_action_logs_extensions`
--

CREATE TABLE `jba8l_action_logs_extensions` (
  `id` int(10) UNSIGNED NOT NULL,
  `extension` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_action_logs_users`
--

CREATE TABLE `jba8l_action_logs_users` (
  `user_id` int(11) UNSIGNED NOT NULL,
  `notify` tinyint(1) UNSIGNED NOT NULL,
  `extensions` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_action_log_config`
--

CREATE TABLE `jba8l_action_log_config` (
  `id` int(10) UNSIGNED NOT NULL,
  `type_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `type_alias` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `id_holder` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_holder` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `table_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `text_prefix` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_activities_resources`
--

CREATE TABLE `jba8l_activities_resources` (
  `activities_resource_id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) NOT NULL,
  `package` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL,
  `resource_id` varchar(2048) NOT NULL DEFAULT '',
  `title` varchar(255) NOT NULL DEFAULT '',
  `created_on` datetime NOT NULL,
  `data` longtext NOT NULL COMMENT '@Filter("json")'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_admintools_acl`
--

CREATE TABLE `jba8l_admintools_acl` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `permissions` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_admintools_adminiplist`
--

CREATE TABLE `jba8l_admintools_adminiplist` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_admintools_badwords`
--

CREATE TABLE `jba8l_admintools_badwords` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `word` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_admintools_cookies`
--

CREATE TABLE `jba8l_admintools_cookies` (
  `series` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_hash` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `valid_to` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_admintools_customperms`
--

CREATE TABLE `jba8l_admintools_customperms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `perms` varchar(4) COLLATE utf8mb4_unicode_ci DEFAULT '0644'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_admintools_filescache`
--

CREATE TABLE `jba8l_admintools_filescache` (
  `admintools_filescache_id` bigint(20) NOT NULL,
  `path` varchar(2048) COLLATE utf8mb4_unicode_ci NOT NULL,
  `filedate` int(11) NOT NULL DEFAULT 0,
  `filesize` int(11) NOT NULL DEFAULT 0,
  `data` blob DEFAULT NULL,
  `checksum` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_admintools_ipautoban`
--

CREATE TABLE `jba8l_admintools_ipautoban` (
  `ip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'other',
  `until` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_admintools_ipautobanhistory`
--

CREATE TABLE `jba8l_admintools_ipautobanhistory` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'other',
  `until` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_admintools_ipblock`
--

CREATE TABLE `jba8l_admintools_ipblock` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_admintools_log`
--

CREATE TABLE `jba8l_admintools_log` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `logdate` datetime NOT NULL,
  `ip` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(10240) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reason` enum('other','adminpw','ipwl','ipbl','sqlishield','antispam','wafblacklist','tpone','tmpl','template','muashield','csrfshield','badbehaviour','geoblocking','rfishield','dfishield','uploadshield','xssshield','httpbl','loginfailure','securitycode','external','awayschedule','admindir','sessionshield','nonewadmins','nonewfrontendadmins','configmonitor','phpshield','404shield') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `extradata` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_admintools_profiles`
--

CREATE TABLE `jba8l_admintools_profiles` (
  `id` int(10) UNSIGNED NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `configuration` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `filters` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_admintools_redirects`
--

CREATE TABLE `jba8l_admintools_redirects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `source` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dest` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ordering` bigint(20) NOT NULL DEFAULT 0,
  `published` tinyint(1) NOT NULL DEFAULT 1,
  `keepurlparams` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_admintools_scanalerts`
--

CREATE TABLE `jba8l_admintools_scanalerts` (
  `admintools_scanalert_id` bigint(20) NOT NULL,
  `path` varchar(2048) COLLATE utf8mb4_unicode_ci NOT NULL,
  `scan_id` bigint(20) NOT NULL DEFAULT 0,
  `diff` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `threat_score` int(11) NOT NULL DEFAULT 0,
  `acknowledged` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_admintools_scans`
--

CREATE TABLE `jba8l_admintools_scans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `comment` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scanstart` timestamp NULL DEFAULT NULL,
  `scanend` timestamp NULL DEFAULT NULL,
  `status` enum('run','fail','complete') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'run',
  `origin` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'backend',
  `totalfiles` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_admintools_storage`
--

CREATE TABLE `jba8l_admintools_storage` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` longtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_admintools_tempsupers`
--

CREATE TABLE `jba8l_admintools_tempsupers` (
  `user_id` bigint(20) NOT NULL,
  `expiration` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_admintools_wafblacklists`
--

CREATE TABLE `jba8l_admintools_wafblacklists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `option` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `view` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `task` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `query` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `query_type` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `query_content` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `verb` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `application` enum('site','admin','both') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'site',
  `enabled` tinyint(3) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_admintools_wafexceptions`
--

CREATE TABLE `jba8l_admintools_wafexceptions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `option` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `view` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `query` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_admintools_waftemplates`
--

CREATE TABLE `jba8l_admintools_waftemplates` (
  `admintools_waftemplate_id` bigint(20) UNSIGNED NOT NULL,
  `reason` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `language` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '*',
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `template` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `enabled` tinyint(3) NOT NULL DEFAULT 1,
  `email_num` tinyint(3) UNSIGNED NOT NULL,
  `email_numfreq` tinyint(3) UNSIGNED NOT NULL,
  `email_freq` enum('','second','minute','hour','day') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `created_on` datetime DEFAULT NULL,
  `created_by` bigint(20) NOT NULL DEFAULT 0,
  `modified_on` datetime DEFAULT NULL,
  `modified_by` bigint(20) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_akeeba_common`
--

CREATE TABLE `jba8l_akeeba_common` (
  `key` varchar(190) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `value` longtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_ak_profiles`
--

CREATE TABLE `jba8l_ak_profiles` (
  `id` int(10) UNSIGNED NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `configuration` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `filters` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quickicon` tinyint(3) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_ak_stats`
--

CREATE TABLE `jba8l_ak_stats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `backupstart` timestamp NULL DEFAULT NULL,
  `backupend` timestamp NULL DEFAULT NULL,
  `status` enum('run','fail','complete') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'run',
  `origin` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'backend',
  `type` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'full',
  `profile_id` bigint(20) NOT NULL DEFAULT 1,
  `archivename` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `absolute_path` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `multipart` int(11) NOT NULL DEFAULT 0,
  `tag` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `backupid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `filesexist` tinyint(3) NOT NULL DEFAULT 1,
  `remote_filename` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_size` bigint(20) NOT NULL DEFAULT 0,
  `frozen` tinyint(1) DEFAULT 0,
  `instep` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_ak_storage`
--

CREATE TABLE `jba8l_ak_storage` (
  `tag` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastupdate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `data` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_ampz`
--

CREATE TABLE `jba8l_ampz` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `params` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_ampz_stats`
--

CREATE TABLE `jba8l_ampz_stats` (
  `id` int(11) UNSIGNED NOT NULL,
  `date_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `network` varchar(50) NOT NULL,
  `position` varchar(50) NOT NULL,
  `url` varchar(2000) NOT NULL,
  `title` varchar(2000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_assets`
--

CREATE TABLE `jba8l_assets` (
  `id` int(10) UNSIGNED NOT NULL COMMENT 'Primary Key',
  `parent_id` int(11) NOT NULL DEFAULT 0 COMMENT 'Nested set parent.',
  `lft` int(11) NOT NULL DEFAULT 0 COMMENT 'Nested set lft.',
  `rgt` int(11) NOT NULL DEFAULT 0 COMMENT 'Nested set rgt.',
  `level` int(10) UNSIGNED NOT NULL COMMENT 'The cached level in the nested tree.',
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'The unique name for the asset.\n',
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'The descriptive title for the asset.',
  `rules` varchar(5120) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'JSON encoded access control.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_associations`
--

CREATE TABLE `jba8l_associations` (
  `id` int(11) NOT NULL COMMENT 'A reference to the associated item.',
  `context` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'The context of the associated item.',
  `key` char(32) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'The key for the association computed from an md5 on associated ids.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_banners`
--

CREATE TABLE `jba8l_banners` (
  `id` int(11) NOT NULL,
  `cid` int(11) NOT NULL DEFAULT 0,
  `type` int(11) NOT NULL DEFAULT 0,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `alias` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '',
  `imptotal` int(11) NOT NULL DEFAULT 0,
  `impmade` int(11) NOT NULL DEFAULT 0,
  `clicks` int(11) NOT NULL DEFAULT 0,
  `clickurl` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `state` tinyint(3) NOT NULL DEFAULT 0,
  `catid` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `custombannercode` varchar(2048) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sticky` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `ordering` int(11) NOT NULL DEFAULT 0,
  `metakey` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `params` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `own_prefix` tinyint(1) NOT NULL DEFAULT 0,
  `metakey_prefix` varchar(400) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `purchase_type` tinyint(4) NOT NULL DEFAULT -1,
  `track_clicks` tinyint(4) NOT NULL DEFAULT -1,
  `track_impressions` tinyint(4) NOT NULL DEFAULT -1,
  `checked_out` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `reset` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `language` char(7) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `created_by` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_by_alias` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `version` int(10) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_banner_clients`
--

CREATE TABLE `jba8l_banner_clients` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `contact` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `extrainfo` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` tinyint(3) NOT NULL DEFAULT 0,
  `checked_out` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `metakey` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `own_prefix` tinyint(4) NOT NULL DEFAULT 0,
  `metakey_prefix` varchar(400) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `purchase_type` tinyint(4) NOT NULL DEFAULT -1,
  `track_clicks` tinyint(4) NOT NULL DEFAULT -1,
  `track_impressions` tinyint(4) NOT NULL DEFAULT -1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_banner_tracks`
--

CREATE TABLE `jba8l_banner_tracks` (
  `track_date` datetime NOT NULL,
  `track_type` int(10) UNSIGNED NOT NULL,
  `banner_id` int(10) UNSIGNED NOT NULL,
  `count` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_categories`
--

CREATE TABLE `jba8l_categories` (
  `id` int(11) NOT NULL,
  `asset_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'FK to the #__assets table.',
  `parent_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `lft` int(11) NOT NULL DEFAULT 0,
  `rgt` int(11) NOT NULL DEFAULT 0,
  `level` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `path` varchar(400) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `extension` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `alias` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '',
  `note` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `description` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `published` tinyint(1) NOT NULL DEFAULT 0,
  `checked_out` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `access` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `params` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `metadesc` varchar(1024) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'The meta description for the page.',
  `metakey` varchar(1024) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'The meta keywords for the page.',
  `metadata` varchar(2048) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'JSON encoded metadata properties.',
  `created_user_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_user_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `modified_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `hits` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `language` char(7) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `version` int(10) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_coalaweb_common`
--

CREATE TABLE `jba8l_coalaweb_common` (
  `key` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Primary Key',
  `value` longtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_contact_details`
--

CREATE TABLE `jba8l_contact_details` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alias` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '',
  `con_position` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `suburb` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postcode` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telephone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fax` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `misc` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_to` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `default_con` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `published` tinyint(1) NOT NULL DEFAULT 0,
  `checked_out` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL DEFAULT 0,
  `params` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `catid` int(11) NOT NULL DEFAULT 0,
  `access` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `webpage` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `sortname1` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `sortname2` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `sortname3` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `language` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_by_alias` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `metakey` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `metadesc` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `metadata` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `featured` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Set if contact is featured.',
  `xreference` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'A reference to enable linkages to external data sets.',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `hits` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_content`
--

CREATE TABLE `jba8l_content` (
  `id` int(10) UNSIGNED NOT NULL,
  `asset_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'FK to the #__assets table.',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `alias` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '',
  `introtext` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `fulltext` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` tinyint(3) NOT NULL DEFAULT 0,
  `catid` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_by_alias` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `checked_out` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `images` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `urls` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribs` varchar(5120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `version` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `ordering` int(11) NOT NULL DEFAULT 0,
  `metakey` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `metadesc` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `access` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `hits` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `metadata` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `featured` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Set if article is featured.',
  `language` char(7) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'The language code for the article.',
  `xreference` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'A reference to enable linkages to external data sets.',
  `note` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_contentitem_tag_map`
--

CREATE TABLE `jba8l_contentitem_tag_map` (
  `type_alias` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `core_content_id` int(10) UNSIGNED NOT NULL COMMENT 'PK from the core content table',
  `content_item_id` int(11) NOT NULL COMMENT 'PK from the content type table',
  `tag_id` int(10) UNSIGNED NOT NULL COMMENT 'PK from the tag table',
  `tag_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'Date of most recent save for this tag-item',
  `type_id` mediumint(8) NOT NULL COMMENT 'PK from the content_type table'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Maps items from content tables to tags';

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_content_frontpage`
--

CREATE TABLE `jba8l_content_frontpage` (
  `content_id` int(11) NOT NULL DEFAULT 0,
  `ordering` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_content_rating`
--

CREATE TABLE `jba8l_content_rating` (
  `content_id` int(11) NOT NULL DEFAULT 0,
  `rating_sum` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `rating_count` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `lastip` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_content_types`
--

CREATE TABLE `jba8l_content_types` (
  `type_id` int(10) UNSIGNED NOT NULL,
  `type_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `type_alias` varchar(400) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `table` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `rules` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `field_mappings` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `router` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `content_history_options` varchar(5120) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'JSON string for com_contenthistory options'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_core_log_searches`
--

CREATE TABLE `jba8l_core_log_searches` (
  `search_term` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `hits` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_cwgears`
--

CREATE TABLE `jba8l_cwgears` (
  `id` int(11) UNSIGNED NOT NULL COMMENT 'Primary Key',
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `time` int(11) NOT NULL,
  `facebook_js` int(11) NOT NULL,
  `uikit` int(11) NOT NULL,
  `uikit_plus` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_cwgears_schedule`
--

CREATE TABLE `jba8l_cwgears_schedule` (
  `id` int(11) UNSIGNED NOT NULL COMMENT 'Primary Key',
  `time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_cwtraffic`
--

CREATE TABLE `jba8l_cwtraffic` (
  `id` int(11) NOT NULL,
  `tm` int(11) NOT NULL,
  `ip` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0.0.0.0',
  `iphash` binary(20) NOT NULL,
  `browser` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bversion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `platform` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `referer` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_code` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `useragent` varchar(1024) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `continent_code` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location_latitude` decimal(10,8) DEFAULT NULL,
  `location_longitude` decimal(11,8) DEFAULT NULL,
  `location_time_zone` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_cwtraffic_knownips`
--

CREATE TABLE `jba8l_cwtraffic_knownips` (
  `id` int(11) UNSIGNED NOT NULL,
  `catid` int(11) NOT NULL DEFAULT 0,
  `title` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `alias` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '',
  `ip` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0.0.0.0',
  `botname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `state` tinyint(1) NOT NULL DEFAULT 0,
  `count` tinyint(1) NOT NULL,
  `checked_out` int(11) NOT NULL DEFAULT 0,
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL DEFAULT 0,
  `archived` tinyint(1) NOT NULL DEFAULT 0,
  `approved` tinyint(1) NOT NULL DEFAULT 1,
  `params` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_by_alias` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_cwtraffic_locations`
--

CREATE TABLE `jba8l_cwtraffic_locations` (
  `id` int(10) UNSIGNED NOT NULL,
  `country_code` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `continent_code` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location_latitude` decimal(10,8) DEFAULT NULL,
  `location_longitude` decimal(11,8) DEFAULT NULL,
  `location_time_zone` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `count` int(10) NOT NULL DEFAULT 0,
  `state` tinyint(3) NOT NULL DEFAULT 0,
  `type` tinyint(3) NOT NULL DEFAULT 1,
  `checked_out` int(10) NOT NULL DEFAULT 0,
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `auto` tinyint(3) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_cwtraffic_storage`
--

CREATE TABLE `jba8l_cwtraffic_storage` (
  `tag` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastcheck` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `lastsent` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `data` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_cwtraffic_total`
--

CREATE TABLE `jba8l_cwtraffic_total` (
  `tcount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_cwtraffic_whoisonline`
--

CREATE TABLE `jba8l_cwtraffic_whoisonline` (
  `id` int(10) UNSIGNED NOT NULL,
  `ip` bigint(20) NOT NULL,
  `country_name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `country_code` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `city` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `dt` timestamp NOT NULL DEFAULT current_timestamp(),
  `iphash` binary(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_djimageslider`
--

CREATE TABLE `jba8l_djimageslider` (
  `id` int(10) UNSIGNED NOT NULL,
  `catid` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `title` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL DEFAULT '',
  `image` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `published` tinyint(1) NOT NULL DEFAULT 0,
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `checked_out` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL DEFAULT 0,
  `params` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_dpcalendar_bookings`
--

CREATE TABLE `jba8l_dpcalendar_bookings` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `uid` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(255) DEFAULT NULL,
  `telephone` varchar(255) DEFAULT NULL,
  `country` varchar(255) NOT NULL DEFAULT '',
  `province` varchar(255) NOT NULL DEFAULT '',
  `city` varchar(255) NOT NULL DEFAULT '',
  `zip` varchar(255) NOT NULL DEFAULT '',
  `street` varchar(255) NOT NULL DEFAULT '',
  `number` varchar(255) NOT NULL DEFAULT '',
  `latitude` decimal(12,8) DEFAULT NULL,
  `longitude` decimal(12,8) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `book_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `options` varchar(255) DEFAULT NULL,
  `state` tinyint(1) NOT NULL DEFAULT 0,
  `transaction_id` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `currency` varchar(10) DEFAULT NULL,
  `processor` varchar(255) DEFAULT NULL,
  `net_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `tax_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `gross_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `payment_fee` decimal(10,2) NOT NULL DEFAULT 0.00,
  `tax_percent` float DEFAULT NULL,
  `txn_type` varchar(255) DEFAULT NULL,
  `txn_currency` varchar(10) DEFAULT NULL,
  `payer_id` varchar(255) DEFAULT NULL,
  `payer_email` varchar(255) DEFAULT NULL,
  `raw_data` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_dpcalendar_caldav_calendarchanges`
--

CREATE TABLE `jba8l_dpcalendar_caldav_calendarchanges` (
  `id` int(11) UNSIGNED NOT NULL,
  `uri` varbinary(200) NOT NULL,
  `synctoken` int(11) UNSIGNED NOT NULL,
  `calendarid` int(11) UNSIGNED NOT NULL,
  `operation` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_dpcalendar_caldav_calendarinstances`
--

CREATE TABLE `jba8l_dpcalendar_caldav_calendarinstances` (
  `id` int(10) UNSIGNED NOT NULL,
  `calendarid` int(10) UNSIGNED NOT NULL,
  `principaluri` varbinary(100) DEFAULT NULL,
  `access` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 = owner, 2 = read, 3 = readwrite',
  `displayname` varchar(100) DEFAULT NULL,
  `uri` varbinary(200) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `calendarorder` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `calendarcolor` varbinary(10) DEFAULT NULL,
  `timezone` text DEFAULT NULL,
  `transparent` tinyint(1) NOT NULL DEFAULT 0,
  `share_href` varbinary(100) DEFAULT NULL,
  `share_displayname` varchar(100) DEFAULT NULL,
  `share_invitestatus` tinyint(1) NOT NULL DEFAULT 2 COMMENT '1 = noresponse, 2 = accepted, 3 = declined, 4 = invalid'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_dpcalendar_caldav_calendarobjects`
--

CREATE TABLE `jba8l_dpcalendar_caldav_calendarobjects` (
  `id` int(11) UNSIGNED NOT NULL,
  `calendardata` mediumblob DEFAULT NULL,
  `uri` varbinary(200) DEFAULT NULL,
  `calendarid` int(10) UNSIGNED NOT NULL,
  `lastmodified` int(11) UNSIGNED DEFAULT NULL,
  `etag` varbinary(32) DEFAULT NULL,
  `size` int(11) UNSIGNED NOT NULL,
  `componenttype` varbinary(8) DEFAULT NULL,
  `firstoccurence` int(11) UNSIGNED DEFAULT NULL,
  `lastoccurence` int(11) UNSIGNED DEFAULT NULL,
  `uid` varbinary(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_dpcalendar_caldav_calendars`
--

CREATE TABLE `jba8l_dpcalendar_caldav_calendars` (
  `id` int(10) UNSIGNED NOT NULL,
  `synctoken` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `components` varbinary(21) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_dpcalendar_caldav_calendarsubscriptions`
--

CREATE TABLE `jba8l_dpcalendar_caldav_calendarsubscriptions` (
  `id` int(11) UNSIGNED NOT NULL,
  `uri` varbinary(200) NOT NULL,
  `principaluri` varbinary(100) NOT NULL,
  `source` text DEFAULT NULL,
  `displayname` varchar(100) DEFAULT NULL,
  `refreshrate` varchar(10) DEFAULT NULL,
  `calendarorder` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `calendarcolor` varbinary(10) DEFAULT NULL,
  `striptodos` tinyint(1) DEFAULT NULL,
  `stripalarms` tinyint(1) DEFAULT NULL,
  `stripattachments` tinyint(1) DEFAULT NULL,
  `lastmodified` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_dpcalendar_caldav_groupmembers`
--

CREATE TABLE `jba8l_dpcalendar_caldav_groupmembers` (
  `id` int(10) UNSIGNED NOT NULL,
  `principal_id` int(10) UNSIGNED NOT NULL,
  `member_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_dpcalendar_caldav_principals`
--

CREATE TABLE `jba8l_dpcalendar_caldav_principals` (
  `id` int(10) UNSIGNED NOT NULL,
  `uri` varbinary(200) NOT NULL,
  `email` varbinary(80) DEFAULT NULL,
  `displayname` varchar(80) DEFAULT NULL,
  `external_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_dpcalendar_caldav_propertystorage`
--

CREATE TABLE `jba8l_dpcalendar_caldav_propertystorage` (
  `id` int(10) UNSIGNED NOT NULL,
  `path` varbinary(1024) NOT NULL,
  `name` varbinary(100) NOT NULL,
  `valuetype` int(10) UNSIGNED DEFAULT NULL,
  `value` mediumblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_dpcalendar_caldav_schedulingobjects`
--

CREATE TABLE `jba8l_dpcalendar_caldav_schedulingobjects` (
  `id` int(11) UNSIGNED NOT NULL,
  `principaluri` varbinary(255) DEFAULT NULL,
  `calendardata` mediumblob DEFAULT NULL,
  `uri` varbinary(200) DEFAULT NULL,
  `lastmodified` int(11) UNSIGNED DEFAULT NULL,
  `etag` varbinary(32) DEFAULT NULL,
  `size` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_dpcalendar_events`
--

CREATE TABLE `jba8l_dpcalendar_events` (
  `id` int(10) UNSIGNED NOT NULL,
  `catid` varchar(255) NOT NULL DEFAULT '0',
  `uid` varchar(255) NOT NULL DEFAULT '',
  `original_id` int(11) DEFAULT NULL,
  `title` varchar(250) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `rrule` varchar(255) DEFAULT NULL,
  `recurrence_id` varchar(255) DEFAULT NULL,
  `start_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `end_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `show_end_time` tinyint(3) UNSIGNED NOT NULL DEFAULT 1,
  `all_day` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `color` varchar(250) NOT NULL DEFAULT '',
  `url` varchar(250) NOT NULL DEFAULT '',
  `images` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `hits` int(11) NOT NULL DEFAULT 0,
  `capacity` int(11) DEFAULT NULL,
  `capacity_used` int(11) DEFAULT 0,
  `max_tickets` int(11) DEFAULT 1,
  `booking_closing_date` varchar(255) DEFAULT NULL,
  `price` text DEFAULT NULL,
  `earlybird` text DEFAULT NULL,
  `user_discount` text DEFAULT NULL,
  `booking_information` text DEFAULT NULL,
  `booking_options` text DEFAULT NULL,
  `tax` tinyint(1) NOT NULL DEFAULT 0,
  `ordertext` text DEFAULT NULL,
  `orderurl` varchar(255) DEFAULT NULL,
  `canceltext` text DEFAULT NULL,
  `cancelurl` varchar(255) DEFAULT NULL,
  `terms` varchar(255) DEFAULT NULL,
  `rooms` text DEFAULT NULL,
  `state` tinyint(1) NOT NULL DEFAULT 0,
  `checked_out` int(11) NOT NULL DEFAULT 0,
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `access` int(11) NOT NULL DEFAULT 1,
  `access_content` int(11) NOT NULL DEFAULT 1,
  `params` text DEFAULT NULL,
  `language` char(7) NOT NULL DEFAULT '',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_by_alias` varchar(255) NOT NULL DEFAULT '',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `metakey` text DEFAULT NULL,
  `metadesc` text DEFAULT NULL,
  `metadata` text DEFAULT NULL,
  `featured` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Set if link is featured.',
  `xreference` varchar(255) DEFAULT NULL COMMENT 'A reference to enable linkages to external data sets.',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `plugintype` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_dpcalendar_events_location`
--

CREATE TABLE `jba8l_dpcalendar_events_location` (
  `event_id` int(11) NOT NULL DEFAULT 0,
  `location_id` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_dpcalendar_extcalendars`
--

CREATE TABLE `jba8l_dpcalendar_extcalendars` (
  `id` int(10) UNSIGNED NOT NULL,
  `asset_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `title` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `plugin` varchar(255) NOT NULL DEFAULT '',
  `description` text DEFAULT NULL,
  `color` varchar(250) NOT NULL DEFAULT '',
  `color_force` tinyint(1) NOT NULL DEFAULT 0,
  `state` tinyint(1) NOT NULL DEFAULT 0,
  `ordering` int(11) NOT NULL DEFAULT 0,
  `params` text DEFAULT NULL,
  `language` char(7) NOT NULL DEFAULT '',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_by_alias` varchar(255) NOT NULL DEFAULT '',
  `version` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `access` int(11) NOT NULL DEFAULT 1,
  `access_content` int(11) NOT NULL DEFAULT 1,
  `sync_token` text DEFAULT NULL,
  `sync_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_dpcalendar_locations`
--

CREATE TABLE `jba8l_dpcalendar_locations` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `country` varchar(255) NOT NULL DEFAULT '',
  `province` varchar(255) NOT NULL DEFAULT '',
  `city` varchar(255) NOT NULL DEFAULT '',
  `zip` varchar(255) NOT NULL DEFAULT '',
  `street` varchar(255) NOT NULL DEFAULT '',
  `number` varchar(255) NOT NULL DEFAULT '',
  `rooms` text DEFAULT NULL,
  `latitude` decimal(12,8) DEFAULT NULL,
  `longitude` decimal(12,8) DEFAULT NULL,
  `url` varchar(250) NOT NULL DEFAULT '',
  `description` text DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `state` tinyint(1) NOT NULL DEFAULT 0,
  `checked_out` int(11) NOT NULL DEFAULT 0,
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL DEFAULT 0,
  `params` text DEFAULT NULL,
  `language` char(7) NOT NULL DEFAULT '',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_by_alias` varchar(255) NOT NULL DEFAULT '',
  `version` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_dpcalendar_tickets`
--

CREATE TABLE `jba8l_dpcalendar_tickets` (
  `id` int(10) UNSIGNED NOT NULL,
  `booking_id` int(11) NOT NULL DEFAULT 0,
  `event_id` int(11) NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `uid` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `telephone` varchar(255) DEFAULT NULL,
  `country` varchar(255) NOT NULL DEFAULT '',
  `province` varchar(255) NOT NULL DEFAULT '',
  `city` varchar(255) NOT NULL DEFAULT '',
  `zip` varchar(255) NOT NULL DEFAULT '',
  `street` varchar(255) NOT NULL DEFAULT '',
  `number` varchar(255) NOT NULL DEFAULT '',
  `latitude` decimal(12,8) DEFAULT NULL,
  `longitude` decimal(12,8) DEFAULT NULL,
  `seat` varchar(255) DEFAULT NULL,
  `remind_time` int(11) NOT NULL DEFAULT 0,
  `remind_type` tinyint(1) NOT NULL DEFAULT 1,
  `reminder_sent_date` datetime DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `state` tinyint(1) NOT NULL DEFAULT 0,
  `public` tinyint(1) NOT NULL DEFAULT 1,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `type` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_extensions`
--

CREATE TABLE `jba8l_extensions` (
  `extension_id` int(11) NOT NULL,
  `package_id` int(11) NOT NULL DEFAULT 0 COMMENT 'Parent package ID for extensions installed as a package.',
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `element` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `folder` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_id` tinyint(3) NOT NULL,
  `enabled` tinyint(3) NOT NULL DEFAULT 0,
  `access` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `protected` tinyint(3) NOT NULL DEFAULT 0,
  `manifest_cache` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `params` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `custom_data` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `system_data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `checked_out` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` int(11) DEFAULT 0,
  `state` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_falang_content`
--

CREATE TABLE `jba8l_falang_content` (
  `id` int(10) UNSIGNED NOT NULL,
  `language_id` int(11) NOT NULL DEFAULT 0,
  `reference_id` int(11) NOT NULL DEFAULT 0,
  `reference_table` varchar(100) NOT NULL DEFAULT '',
  `reference_field` varchar(100) NOT NULL DEFAULT '',
  `value` mediumtext NOT NULL,
  `original_value` varchar(255) DEFAULT NULL,
  `original_text` mediumtext DEFAULT NULL,
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `published` tinyint(1) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_falang_tableinfo`
--

CREATE TABLE `jba8l_falang_tableinfo` (
  `id` int(11) NOT NULL,
  `joomlatablename` varchar(100) NOT NULL DEFAULT '',
  `tablepkID` varchar(100) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_fields`
--

CREATE TABLE `jba8l_fields` (
  `id` int(10) UNSIGNED NOT NULL,
  `asset_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `context` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `group_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `default_value` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'text',
  `note` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` tinyint(1) NOT NULL DEFAULT 0,
  `required` tinyint(1) NOT NULL DEFAULT 0,
  `checked_out` int(11) NOT NULL DEFAULT 0,
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL DEFAULT 0,
  `params` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `fieldparams` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `language` char(7) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `created_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_user_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `modified_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `access` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_fields_categories`
--

CREATE TABLE `jba8l_fields_categories` (
  `field_id` int(11) NOT NULL DEFAULT 0,
  `category_id` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_fields_groups`
--

CREATE TABLE `jba8l_fields_groups` (
  `id` int(10) UNSIGNED NOT NULL,
  `asset_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `context` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `note` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` tinyint(1) NOT NULL DEFAULT 0,
  `checked_out` int(11) NOT NULL DEFAULT 0,
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL DEFAULT 0,
  `params` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `language` char(7) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `access` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_fields_values`
--

CREATE TABLE `jba8l_fields_values` (
  `field_id` int(10) UNSIGNED NOT NULL,
  `item_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Allow references to items which have strings as ids, eg. none db systems.',
  `value` text COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_files_containers`
--

CREATE TABLE `jba8l_files_containers` (
  `files_container_id` int(11) UNSIGNED NOT NULL,
  `slug` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `path` varchar(255) NOT NULL,
  `parameters` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_files_mimetypes`
--

CREATE TABLE `jba8l_files_mimetypes` (
  `mimetype` varchar(255) NOT NULL,
  `extension` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_finder_filters`
--

CREATE TABLE `jba8l_finder_filters` (
  `filter_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alias` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` tinyint(1) NOT NULL DEFAULT 1,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(10) UNSIGNED NOT NULL,
  `created_by_alias` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `checked_out` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `map_count` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `params` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_finder_links`
--

CREATE TABLE `jba8l_finder_links` (
  `link_id` int(10) UNSIGNED NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `route` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `indexdate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `md5sum` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `published` tinyint(1) NOT NULL DEFAULT 1,
  `state` int(5) DEFAULT 1,
  `access` int(5) DEFAULT 0,
  `language` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  `publish_start_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_end_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `start_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `end_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `list_price` double UNSIGNED NOT NULL DEFAULT 0,
  `sale_price` double UNSIGNED NOT NULL DEFAULT 0,
  `type_id` int(11) NOT NULL,
  `object` mediumblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_finder_links_terms0`
--

CREATE TABLE `jba8l_finder_links_terms0` (
  `link_id` int(10) UNSIGNED NOT NULL,
  `term_id` int(10) UNSIGNED NOT NULL,
  `weight` float UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_finder_links_terms1`
--

CREATE TABLE `jba8l_finder_links_terms1` (
  `link_id` int(10) UNSIGNED NOT NULL,
  `term_id` int(10) UNSIGNED NOT NULL,
  `weight` float UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_finder_links_terms2`
--

CREATE TABLE `jba8l_finder_links_terms2` (
  `link_id` int(10) UNSIGNED NOT NULL,
  `term_id` int(10) UNSIGNED NOT NULL,
  `weight` float UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_finder_links_terms3`
--

CREATE TABLE `jba8l_finder_links_terms3` (
  `link_id` int(10) UNSIGNED NOT NULL,
  `term_id` int(10) UNSIGNED NOT NULL,
  `weight` float UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_finder_links_terms4`
--

CREATE TABLE `jba8l_finder_links_terms4` (
  `link_id` int(10) UNSIGNED NOT NULL,
  `term_id` int(10) UNSIGNED NOT NULL,
  `weight` float UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_finder_links_terms5`
--

CREATE TABLE `jba8l_finder_links_terms5` (
  `link_id` int(10) UNSIGNED NOT NULL,
  `term_id` int(10) UNSIGNED NOT NULL,
  `weight` float UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_finder_links_terms6`
--

CREATE TABLE `jba8l_finder_links_terms6` (
  `link_id` int(10) UNSIGNED NOT NULL,
  `term_id` int(10) UNSIGNED NOT NULL,
  `weight` float UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_finder_links_terms7`
--

CREATE TABLE `jba8l_finder_links_terms7` (
  `link_id` int(10) UNSIGNED NOT NULL,
  `term_id` int(10) UNSIGNED NOT NULL,
  `weight` float UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_finder_links_terms8`
--

CREATE TABLE `jba8l_finder_links_terms8` (
  `link_id` int(10) UNSIGNED NOT NULL,
  `term_id` int(10) UNSIGNED NOT NULL,
  `weight` float UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_finder_links_terms9`
--

CREATE TABLE `jba8l_finder_links_terms9` (
  `link_id` int(10) UNSIGNED NOT NULL,
  `term_id` int(10) UNSIGNED NOT NULL,
  `weight` float UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_finder_links_termsa`
--

CREATE TABLE `jba8l_finder_links_termsa` (
  `link_id` int(10) UNSIGNED NOT NULL,
  `term_id` int(10) UNSIGNED NOT NULL,
  `weight` float UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_finder_links_termsb`
--

CREATE TABLE `jba8l_finder_links_termsb` (
  `link_id` int(10) UNSIGNED NOT NULL,
  `term_id` int(10) UNSIGNED NOT NULL,
  `weight` float UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_finder_links_termsc`
--

CREATE TABLE `jba8l_finder_links_termsc` (
  `link_id` int(10) UNSIGNED NOT NULL,
  `term_id` int(10) UNSIGNED NOT NULL,
  `weight` float UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_finder_links_termsd`
--

CREATE TABLE `jba8l_finder_links_termsd` (
  `link_id` int(10) UNSIGNED NOT NULL,
  `term_id` int(10) UNSIGNED NOT NULL,
  `weight` float UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_finder_links_termse`
--

CREATE TABLE `jba8l_finder_links_termse` (
  `link_id` int(10) UNSIGNED NOT NULL,
  `term_id` int(10) UNSIGNED NOT NULL,
  `weight` float UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_finder_links_termsf`
--

CREATE TABLE `jba8l_finder_links_termsf` (
  `link_id` int(10) UNSIGNED NOT NULL,
  `term_id` int(10) UNSIGNED NOT NULL,
  `weight` float UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_finder_taxonomy`
--

CREATE TABLE `jba8l_finder_taxonomy` (
  `id` int(10) UNSIGNED NOT NULL,
  `parent_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` tinyint(1) UNSIGNED NOT NULL DEFAULT 1,
  `access` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `ordering` tinyint(1) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_finder_taxonomy_map`
--

CREATE TABLE `jba8l_finder_taxonomy_map` (
  `link_id` int(10) UNSIGNED NOT NULL,
  `node_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_finder_terms`
--

CREATE TABLE `jba8l_finder_terms` (
  `term_id` int(10) UNSIGNED NOT NULL,
  `term` varchar(75) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stem` varchar(75) COLLATE utf8mb4_unicode_ci NOT NULL,
  `common` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `phrase` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `weight` float UNSIGNED NOT NULL DEFAULT 0,
  `soundex` varchar(75) COLLATE utf8mb4_unicode_ci NOT NULL,
  `links` int(10) NOT NULL DEFAULT 0,
  `language` char(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_finder_terms_common`
--

CREATE TABLE `jba8l_finder_terms_common` (
  `term` varchar(75) COLLATE utf8mb4_unicode_ci NOT NULL,
  `language` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_finder_tokens`
--

CREATE TABLE `jba8l_finder_tokens` (
  `term` varchar(75) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stem` varchar(75) COLLATE utf8mb4_unicode_ci NOT NULL,
  `common` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `phrase` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `weight` float UNSIGNED NOT NULL DEFAULT 1,
  `context` tinyint(1) UNSIGNED NOT NULL DEFAULT 2,
  `language` char(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=MEMORY DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_finder_tokens_aggregate`
--

CREATE TABLE `jba8l_finder_tokens_aggregate` (
  `term_id` int(10) UNSIGNED NOT NULL,
  `map_suffix` char(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `term` varchar(75) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stem` varchar(75) COLLATE utf8mb4_unicode_ci NOT NULL,
  `common` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `phrase` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `term_weight` float UNSIGNED NOT NULL,
  `context` tinyint(1) UNSIGNED NOT NULL DEFAULT 2,
  `context_weight` float UNSIGNED NOT NULL,
  `total_weight` float UNSIGNED NOT NULL,
  `language` char(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=MEMORY DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_finder_types`
--

CREATE TABLE `jba8l_finder_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mime` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_flexicontent_advsearch_index`
--

CREATE TABLE `jba8l_flexicontent_advsearch_index` (
  `sid` int(11) NOT NULL,
  `field_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `extraid` int(11) NOT NULL,
  `search_index` longtext NOT NULL,
  `value_id` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_flexicontent_advsearch_index_field_2`
--

CREATE TABLE `jba8l_flexicontent_advsearch_index_field_2` (
  `sid` int(11) NOT NULL,
  `field_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `extraid` int(11) NOT NULL,
  `search_index` longtext NOT NULL,
  `value_id` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_flexicontent_advsearch_index_field_117`
--

CREATE TABLE `jba8l_flexicontent_advsearch_index_field_117` (
  `sid` int(11) NOT NULL,
  `field_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `extraid` int(11) NOT NULL,
  `search_index` longtext NOT NULL,
  `value_id` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_flexicontent_authors_ext`
--

CREATE TABLE `jba8l_flexicontent_authors_ext` (
  `user_id` int(11) UNSIGNED NOT NULL,
  `author_basicparams` text DEFAULT NULL,
  `author_catparams` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_flexicontent_cats_item_relations`
--

CREATE TABLE `jba8l_flexicontent_cats_item_relations` (
  `catid` int(11) NOT NULL DEFAULT 0,
  `itemid` int(11) NOT NULL DEFAULT 0,
  `ordering` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_flexicontent_download_coupons`
--

CREATE TABLE `jba8l_flexicontent_download_coupons` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `file_id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `hits` int(11) NOT NULL,
  `hits_limit` int(11) NOT NULL,
  `expire_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_flexicontent_download_history`
--

CREATE TABLE `jba8l_flexicontent_download_history` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `file_id` int(11) NOT NULL,
  `hits` int(11) NOT NULL,
  `last_hit_on` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_flexicontent_edit_coupons`
--

CREATE TABLE `jba8l_flexicontent_edit_coupons` (
  `id` int(11) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `timestamp` int(11) NOT NULL,
  `token` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_flexicontent_favourites`
--

CREATE TABLE `jba8l_flexicontent_favourites` (
  `id` int(11) NOT NULL,
  `itemid` int(11) NOT NULL DEFAULT 0,
  `userid` int(11) NOT NULL DEFAULT 0,
  `notify` int(11) NOT NULL DEFAULT 0,
  `type` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_flexicontent_fields`
--

CREATE TABLE `jba8l_flexicontent_fields` (
  `id` int(11) UNSIGNED NOT NULL,
  `asset_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `field_type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `label` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `isfilter` tinyint(1) NOT NULL DEFAULT 0,
  `isadvfilter` tinyint(1) NOT NULL DEFAULT 0,
  `iscore` tinyint(1) NOT NULL DEFAULT 0,
  `issearch` tinyint(1) NOT NULL DEFAULT 1,
  `isadvsearch` tinyint(1) NOT NULL DEFAULT 0,
  `untranslatable` tinyint(1) NOT NULL DEFAULT 0,
  `formhidden` tinyint(1) NOT NULL DEFAULT 0,
  `valueseditable` tinyint(1) NOT NULL DEFAULT 0,
  `edithelp` tinyint(1) NOT NULL DEFAULT 2,
  `positions` text NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT 0,
  `attribs` mediumtext NOT NULL,
  `checked_out` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `access` int(11) UNSIGNED NOT NULL DEFAULT 1,
  `ordering` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_flexicontent_fields_item_relations`
--

CREATE TABLE `jba8l_flexicontent_fields_item_relations` (
  `field_id` int(11) NOT NULL DEFAULT 0,
  `item_id` int(11) NOT NULL DEFAULT 0,
  `valueorder` int(11) NOT NULL DEFAULT 1,
  `suborder` int(11) NOT NULL DEFAULT 1,
  `value` mediumtext NOT NULL,
  `value_integer` bigint(20) DEFAULT NULL,
  `value_decimal` decimal(65,15) DEFAULT NULL,
  `value_datetime` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_flexicontent_fields_type_relations`
--

CREATE TABLE `jba8l_flexicontent_fields_type_relations` (
  `field_id` int(11) NOT NULL DEFAULT 0,
  `type_id` int(11) NOT NULL DEFAULT 0,
  `ordering` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_flexicontent_files`
--

CREATE TABLE `jba8l_flexicontent_files` (
  `id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `filename_original` varchar(255) NOT NULL DEFAULT '',
  `altname` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `url` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `secure` tinyint(3) UNSIGNED NOT NULL DEFAULT 1,
  `ext` varchar(10) NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT 1,
  `language` char(7) NOT NULL DEFAULT '*',
  `hits` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `size` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `assignments` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `stamp` tinyint(3) UNSIGNED NOT NULL DEFAULT 1,
  `uploaded` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `uploaded_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `checked_out` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `access` int(11) UNSIGNED NOT NULL DEFAULT 1,
  `attribs` mediumtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_flexicontent_items_ext`
--

CREATE TABLE `jba8l_flexicontent_items_ext` (
  `item_id` int(11) UNSIGNED NOT NULL,
  `type_id` int(11) UNSIGNED NOT NULL,
  `language` varchar(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '*',
  `lang_parent_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `sub_items` text NOT NULL,
  `sub_categories` text NOT NULL,
  `related_items` text NOT NULL,
  `search_index` mediumtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_flexicontent_items_extravote`
--

CREATE TABLE `jba8l_flexicontent_items_extravote` (
  `content_id` int(11) NOT NULL,
  `field_id` int(11) NOT NULL,
  `lastip` varchar(50) NOT NULL,
  `rating_sum` int(11) NOT NULL,
  `rating_count` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_flexicontent_items_tmp`
--

CREATE TABLE `jba8l_flexicontent_items_tmp` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alias` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` tinyint(3) NOT NULL DEFAULT 0,
  `catid` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `ordering` int(11) NOT NULL DEFAULT 0,
  `access` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `hits` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `featured` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `language` varchar(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '*',
  `type_id` int(11) NOT NULL DEFAULT 0,
  `lang_parent_id` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_flexicontent_items_versions`
--

CREATE TABLE `jba8l_flexicontent_items_versions` (
  `version` int(11) NOT NULL DEFAULT 0,
  `field_id` int(11) NOT NULL DEFAULT 0,
  `item_id` int(11) NOT NULL DEFAULT 0,
  `valueorder` int(11) NOT NULL DEFAULT 1,
  `suborder` int(11) NOT NULL DEFAULT 1,
  `value` mediumtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_flexicontent_layouts_conf`
--

CREATE TABLE `jba8l_flexicontent_layouts_conf` (
  `template` varchar(50) NOT NULL DEFAULT '',
  `cfgname` varchar(50) NOT NULL DEFAULT '',
  `layout` varchar(20) NOT NULL DEFAULT '',
  `attribs` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_flexicontent_reviews`
--

CREATE TABLE `jba8l_flexicontent_reviews` (
  `id` int(11) NOT NULL,
  `content_id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'item',
  `average_rating` int(11) NOT NULL,
  `custom_ratings` text DEFAULT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `email` varchar(255) NOT NULL DEFAULT '',
  `title` varchar(255) DEFAULT NULL,
  `text` mediumtext DEFAULT NULL,
  `state` tinyint(3) NOT NULL DEFAULT 0,
  `approved` tinyint(3) NOT NULL DEFAULT 0,
  `useful_yes` int(11) NOT NULL DEFAULT 0,
  `useful_no` int(11) NOT NULL DEFAULT 0,
  `submit_date` datetime NOT NULL,
  `update_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `checked_out` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `attribs` mediumtext DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_flexicontent_tags`
--

CREATE TABLE `jba8l_flexicontent_tags` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `published` tinyint(1) NOT NULL,
  `checked_out` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `jtag_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_flexicontent_tags_item_relations`
--

CREATE TABLE `jba8l_flexicontent_tags_item_relations` (
  `tid` int(11) NOT NULL DEFAULT 0,
  `itemid` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_flexicontent_templates`
--

CREATE TABLE `jba8l_flexicontent_templates` (
  `id` int(11) UNSIGNED NOT NULL,
  `template` varchar(50) NOT NULL DEFAULT '',
  `cfgname` varchar(50) NOT NULL DEFAULT '',
  `layout` varchar(20) NOT NULL DEFAULT '',
  `position` varchar(100) NOT NULL DEFAULT '',
  `fields` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_flexicontent_types`
--

CREATE TABLE `jba8l_flexicontent_types` (
  `id` int(11) NOT NULL,
  `asset_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `name` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `published` tinyint(1) NOT NULL,
  `itemscreatable` smallint(8) NOT NULL DEFAULT 0,
  `checked_out` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `access` int(11) UNSIGNED NOT NULL DEFAULT 1,
  `attribs` mediumtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_flexicontent_versions`
--

CREATE TABLE `jba8l_flexicontent_versions` (
  `id` int(11) UNSIGNED NOT NULL,
  `item_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `version_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `comment` mediumtext NOT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `state` int(3) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_j2xml_usergroups`
--

CREATE TABLE `jba8l_j2xml_usergroups` (
  `id` int(10) UNSIGNED NOT NULL,
  `parent_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `title` varchar(100) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_j2xml_websites`
--

CREATE TABLE `jba8l_j2xml_websites` (
  `id` int(11) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `remote_url` varchar(255) NOT NULL DEFAULT '',
  `username` varchar(255) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL DEFAULT '',
  `state` tinyint(3) NOT NULL DEFAULT 0,
  `checked_out` int(11) NOT NULL DEFAULT 0,
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_jevents_catmap`
--

CREATE TABLE `jba8l_jevents_catmap` (
  `evid` int(12) NOT NULL,
  `catid` int(11) NOT NULL DEFAULT 1,
  `ordering` int(5) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_jevents_exception`
--

CREATE TABLE `jba8l_jevents_exception` (
  `ex_id` int(12) NOT NULL,
  `rp_id` int(12) NOT NULL DEFAULT 0,
  `eventid` int(12) NOT NULL DEFAULT 1,
  `eventdetail_id` int(12) NOT NULL DEFAULT 0,
  `exception_type` int(2) NOT NULL DEFAULT 0,
  `startrepeat` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `oldstartrepeat` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `tempfield` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_jevents_filtermap`
--

CREATE TABLE `jba8l_jevents_filtermap` (
  `fid` int(12) NOT NULL,
  `userid` int(12) NOT NULL DEFAULT 0,
  `modid` int(12) NOT NULL DEFAULT 0,
  `andor` tinyint(3) NOT NULL DEFAULT 0,
  `filters` text NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `md5` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_jevents_icsfile`
--

CREATE TABLE `jba8l_jevents_icsfile` (
  `ics_id` int(12) NOT NULL,
  `srcURL` varchar(500) NOT NULL DEFAULT '',
  `label` varchar(30) NOT NULL DEFAULT '',
  `filename` varchar(120) NOT NULL DEFAULT '',
  `icaltype` tinyint(3) NOT NULL DEFAULT 0,
  `isdefault` tinyint(3) NOT NULL DEFAULT 0,
  `ignoreembedcat` tinyint(3) NOT NULL DEFAULT 0,
  `state` tinyint(3) NOT NULL DEFAULT 1,
  `access` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `catid` int(11) NOT NULL DEFAULT 1,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `created_by_alias` varchar(100) NOT NULL DEFAULT '',
  `modified_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `refreshed` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `autorefresh` tinyint(3) NOT NULL DEFAULT 0,
  `overlaps` tinyint(3) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_jevents_repetition`
--

CREATE TABLE `jba8l_jevents_repetition` (
  `rp_id` int(12) NOT NULL,
  `eventid` int(12) NOT NULL DEFAULT 1,
  `eventdetail_id` int(12) NOT NULL DEFAULT 0,
  `duplicatecheck` varchar(32) NOT NULL DEFAULT '',
  `startrepeat` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `endrepeat` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_jevents_rrule`
--

CREATE TABLE `jba8l_jevents_rrule` (
  `rr_id` int(12) NOT NULL,
  `eventid` int(12) NOT NULL DEFAULT 1,
  `freq` varchar(30) NOT NULL DEFAULT '',
  `until` int(12) NOT NULL DEFAULT 1,
  `untilraw` varchar(30) NOT NULL DEFAULT '',
  `count` int(6) NOT NULL DEFAULT 1,
  `rinterval` int(6) NOT NULL DEFAULT 1,
  `bysecond` varchar(50) NOT NULL DEFAULT '',
  `byminute` varchar(50) NOT NULL DEFAULT '',
  `byhour` varchar(50) NOT NULL DEFAULT '',
  `byday` varchar(50) NOT NULL DEFAULT '',
  `bymonthday` varchar(50) NOT NULL DEFAULT '',
  `byyearday` varchar(100) NOT NULL DEFAULT '',
  `byweekno` varchar(50) NOT NULL DEFAULT '',
  `bymonth` varchar(50) NOT NULL DEFAULT '',
  `bysetpos` varchar(50) NOT NULL DEFAULT '',
  `wkst` varchar(50) NOT NULL DEFAULT '',
  `irregulardates` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_jevents_translation`
--

CREATE TABLE `jba8l_jevents_translation` (
  `translation_id` int(12) NOT NULL,
  `evdet_id` int(12) NOT NULL DEFAULT 0,
  `description` longtext NOT NULL,
  `location` varchar(120) NOT NULL DEFAULT '',
  `summary` longtext NOT NULL,
  `contact` varchar(120) NOT NULL DEFAULT '',
  `extra_info` text NOT NULL,
  `language` varchar(20) NOT NULL DEFAULT '*'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_jevents_vevdetail`
--

CREATE TABLE `jba8l_jevents_vevdetail` (
  `evdet_id` int(12) NOT NULL,
  `rawdata` longtext NOT NULL,
  `dtstart` int(11) NOT NULL DEFAULT 0,
  `dtstartraw` varchar(30) NOT NULL DEFAULT '',
  `duration` int(11) NOT NULL DEFAULT 0,
  `durationraw` varchar(30) NOT NULL DEFAULT '',
  `dtend` int(11) NOT NULL DEFAULT 0,
  `dtendraw` varchar(30) NOT NULL DEFAULT '',
  `dtstamp` varchar(30) NOT NULL DEFAULT '',
  `class` varchar(10) NOT NULL DEFAULT '',
  `categories` varchar(120) NOT NULL DEFAULT '',
  `color` varchar(20) NOT NULL DEFAULT '',
  `description` longtext NOT NULL,
  `geolon` float NOT NULL DEFAULT 0,
  `geolat` float NOT NULL DEFAULT 0,
  `location` varchar(120) NOT NULL DEFAULT '',
  `priority` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `status` varchar(20) NOT NULL DEFAULT '',
  `summary` longtext NOT NULL,
  `contact` varchar(120) NOT NULL DEFAULT '',
  `organizer` varchar(120) NOT NULL DEFAULT '',
  `url` text NOT NULL,
  `extra_info` text NOT NULL,
  `created` varchar(30) NOT NULL DEFAULT '',
  `sequence` int(11) NOT NULL DEFAULT 1,
  `state` tinyint(3) NOT NULL DEFAULT 1,
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `multiday` tinyint(3) NOT NULL DEFAULT 1,
  `hits` int(11) NOT NULL DEFAULT 0,
  `noendtime` tinyint(3) NOT NULL DEFAULT 0,
  `loc_id` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_jevents_vevent`
--

CREATE TABLE `jba8l_jevents_vevent` (
  `ev_id` int(12) NOT NULL,
  `icsid` int(12) NOT NULL DEFAULT 0,
  `catid` int(11) NOT NULL DEFAULT 1,
  `uid` varchar(255) NOT NULL DEFAULT '',
  `refreshed` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `created_by_alias` varchar(100) NOT NULL DEFAULT '',
  `modified_by` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `rawdata` longtext NOT NULL,
  `recurrence_id` varchar(30) NOT NULL DEFAULT '',
  `detail_id` int(12) NOT NULL DEFAULT 0,
  `state` tinyint(3) NOT NULL DEFAULT 1,
  `lockevent` tinyint(3) NOT NULL DEFAULT 0,
  `author_notified` tinyint(3) NOT NULL DEFAULT 0,
  `access` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `tzid` varchar(100) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_jev_defaults`
--

CREATE TABLE `jba8l_jev_defaults` (
  `id` int(11) UNSIGNED NOT NULL,
  `title` varchar(100) NOT NULL DEFAULT '',
  `name` varchar(50) NOT NULL DEFAULT '',
  `subject` text NOT NULL,
  `value` text NOT NULL,
  `state` tinyint(3) NOT NULL DEFAULT 1,
  `params` text NOT NULL,
  `language` varchar(20) NOT NULL DEFAULT '*',
  `catid` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_jev_users`
--

CREATE TABLE `jba8l_jev_users` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `published` tinyint(2) NOT NULL DEFAULT 0,
  `canuploadimages` tinyint(2) NOT NULL DEFAULT 0,
  `canuploadmovies` tinyint(2) NOT NULL DEFAULT 0,
  `cancreate` tinyint(2) NOT NULL DEFAULT 0,
  `canedit` tinyint(2) NOT NULL DEFAULT 0,
  `canpublishown` tinyint(2) NOT NULL DEFAULT 0,
  `candeleteown` tinyint(2) NOT NULL DEFAULT 0,
  `canpublishall` tinyint(2) NOT NULL DEFAULT 0,
  `candeleteall` tinyint(2) NOT NULL DEFAULT 0,
  `cancreateown` tinyint(2) NOT NULL DEFAULT 0,
  `cancreateglobal` tinyint(2) NOT NULL DEFAULT 0,
  `eventslimit` int(11) NOT NULL DEFAULT 0,
  `extraslimit` int(11) NOT NULL DEFAULT 0,
  `categories` varchar(255) NOT NULL DEFAULT '',
  `calendars` varchar(255) NOT NULL DEFAULT '',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_jmap`
--

CREATE TABLE `jba8l_jmap` (
  `id` int(11) UNSIGNED NOT NULL,
  `type` varchar(100) NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `checked_out` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `published` tinyint(1) NOT NULL DEFAULT 0,
  `ordering` int(11) NOT NULL DEFAULT 0,
  `sqlquery` text DEFAULT NULL,
  `sqlquery_managed` text DEFAULT NULL,
  `params` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_jmap_canonicals`
--

CREATE TABLE `jba8l_jmap_canonicals` (
  `id` int(11) UNSIGNED NOT NULL,
  `linkurl` varchar(600) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `canonical` varchar(600) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_jmap_cats_priorities`
--

CREATE TABLE `jba8l_jmap_cats_priorities` (
  `id` int(11) NOT NULL,
  `priority` char(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_jmap_datasets`
--

CREATE TABLE `jba8l_jmap_datasets` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `checked_out` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `published` tinyint(1) NOT NULL DEFAULT 0,
  `sources` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_jmap_dss_relations`
--

CREATE TABLE `jba8l_jmap_dss_relations` (
  `datasetid` int(11) NOT NULL,
  `datasourceid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_jmap_google`
--

CREATE TABLE `jba8l_jmap_google` (
  `id` int(11) NOT NULL,
  `token` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_jmap_headings`
--

CREATE TABLE `jba8l_jmap_headings` (
  `id` int(11) UNSIGNED NOT NULL,
  `linkurl` varchar(600) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `h1` text DEFAULT NULL,
  `h2` text DEFAULT NULL,
  `h3` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_jmap_menu_priorities`
--

CREATE TABLE `jba8l_jmap_menu_priorities` (
  `id` int(11) NOT NULL,
  `priority` char(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_jmap_metainfo`
--

CREATE TABLE `jba8l_jmap_metainfo` (
  `id` int(11) UNSIGNED NOT NULL,
  `linkurl` varchar(600) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_title` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_desc` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_image` varchar(255) DEFAULT NULL,
  `robots` varchar(255) DEFAULT NULL,
  `published` tinyint(1) NOT NULL DEFAULT 0,
  `excluded` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_jmap_pingomatic`
--

CREATE TABLE `jba8l_jmap_pingomatic` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `blogurl` varchar(255) NOT NULL,
  `rssurl` varchar(255) DEFAULT NULL,
  `services` text NOT NULL,
  `lastping` datetime DEFAULT NULL,
  `checked_out` int(11) NOT NULL DEFAULT 0,
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_languages`
--

CREATE TABLE `jba8l_languages` (
  `lang_id` int(11) UNSIGNED NOT NULL,
  `asset_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `lang_code` char(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_native` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sef` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  `metakey` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `metadesc` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `sitename` varchar(1024) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `published` int(11) NOT NULL DEFAULT 0,
  `access` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `ordering` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_logman_activities`
--

CREATE TABLE `jba8l_logman_activities` (
  `logman_activity_id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(36) NOT NULL DEFAULT '',
  `application` varchar(10) NOT NULL DEFAULT '',
  `type` varchar(3) NOT NULL DEFAULT '',
  `package` varchar(50) NOT NULL DEFAULT '',
  `name` varchar(50) NOT NULL DEFAULT '',
  `action` varchar(50) NOT NULL DEFAULT '',
  `row` varchar(2048) NOT NULL DEFAULT '',
  `title` varchar(255) NOT NULL DEFAULT '',
  `status` varchar(100) NOT NULL,
  `created_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL DEFAULT 0,
  `ip` varchar(45) NOT NULL DEFAULT '',
  `metadata` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_logman_activities_impressions`
--

CREATE TABLE `jba8l_logman_activities_impressions` (
  `logman_activity_id` bigint(20) UNSIGNED NOT NULL,
  `logman_impression_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_logman_impressions`
--

CREATE TABLE `jba8l_logman_impressions` (
  `logman_impression_id` bigint(20) UNSIGNED NOT NULL,
  `row` varchar(2048) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `package` varchar(255) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `referrer` varchar(2048) DEFAULT NULL,
  `internal` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `url` varchar(2048) DEFAULT NULL,
  `session_hash` varchar(32) DEFAULT NULL,
  `ip` varchar(45) DEFAULT NULL,
  `metadata` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_logman_routes`
--

CREATE TABLE `jba8l_logman_routes` (
  `logman_route_id` bigint(20) UNSIGNED NOT NULL,
  `row` varchar(2048) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `package` varchar(255) DEFAULT NULL,
  `page` bigint(20) DEFAULT NULL,
  `path` varchar(2048) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_logman_synchronization`
--

CREATE TABLE `jba8l_logman_synchronization` (
  `uuid` varchar(36) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_menu`
--

CREATE TABLE `jba8l_menu` (
  `id` int(11) NOT NULL,
  `menutype` varchar(24) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'The type of menu this item belongs to. FK to #__menu_types.menutype',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'The display title of the menu item.',
  `alias` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL COMMENT 'The SEF alias of the menu item.',
  `note` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `path` varchar(1024) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'The computed path of the menu item based on the alias field.',
  `link` varchar(1024) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'The actually link the menu item refers to.',
  `type` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'The type of link: Component, URL, Alias, Separator',
  `published` tinyint(4) NOT NULL DEFAULT 0 COMMENT 'The published state of the menu link.',
  `parent_id` int(10) UNSIGNED NOT NULL DEFAULT 1 COMMENT 'The parent menu item in the menu tree.',
  `level` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'The relative level in the tree.',
  `component_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'FK to #__extensions.id',
  `checked_out` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'FK to #__users.id',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'The time the menu item was checked out.',
  `browserNav` tinyint(4) NOT NULL DEFAULT 0 COMMENT 'The click behaviour of the link.',
  `access` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'The access level required to view the menu item.',
  `img` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'The image of the menu item.',
  `template_style_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `params` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'JSON encoded data for the menu item.',
  `lft` int(11) NOT NULL DEFAULT 0 COMMENT 'Nested set lft.',
  `rgt` int(11) NOT NULL DEFAULT 0 COMMENT 'Nested set rgt.',
  `home` tinyint(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Indicates if this menu item is the home or default page.',
  `language` char(7) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `client_id` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_menu_types`
--

CREATE TABLE `jba8l_menu_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `asset_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `menutype` varchar(24) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(48) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `client_id` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_messages`
--

CREATE TABLE `jba8l_messages` (
  `message_id` int(10) UNSIGNED NOT NULL,
  `user_id_from` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `user_id_to` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `folder_id` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `date_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `state` tinyint(1) NOT NULL DEFAULT 0,
  `priority` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_messages_cfg`
--

CREATE TABLE `jba8l_messages_cfg` (
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `cfg_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `cfg_value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_modules`
--

CREATE TABLE `jba8l_modules` (
  `id` int(11) NOT NULL,
  `asset_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'FK to the #__assets table.',
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `note` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `content` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ordering` int(11) NOT NULL DEFAULT 0,
  `position` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `checked_out` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `published` tinyint(1) NOT NULL DEFAULT 0,
  `module` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `access` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `showtitle` tinyint(3) UNSIGNED NOT NULL DEFAULT 1,
  `params` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_id` tinyint(4) NOT NULL DEFAULT 0,
  `language` char(7) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_modules_menu`
--

CREATE TABLE `jba8l_modules_menu` (
  `moduleid` int(11) NOT NULL DEFAULT 0,
  `menuid` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_newsfeeds`
--

CREATE TABLE `jba8l_newsfeeds` (
  `catid` int(11) NOT NULL DEFAULT 0,
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `alias` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '',
  `link` varchar(2048) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `published` tinyint(1) NOT NULL DEFAULT 0,
  `numarticles` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `cache_time` int(10) UNSIGNED NOT NULL DEFAULT 3600,
  `checked_out` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL DEFAULT 0,
  `rtl` tinyint(4) NOT NULL DEFAULT 0,
  `access` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `language` char(7) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `params` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_by_alias` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `metakey` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `metadesc` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `metadata` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `xreference` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'A reference to enable linkages to external data sets.',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `version` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `hits` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `images` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_overrider`
--

CREATE TABLE `jba8l_overrider` (
  `id` int(10) NOT NULL COMMENT 'Primary Key',
  `constant` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `string` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_pagebuilderck_elements`
--

CREATE TABLE `jba8l_pagebuilderck_elements` (
  `id` int(10) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` tinytext NOT NULL,
  `type` varchar(50) NOT NULL,
  `ordering` int(11) NOT NULL,
  `state` int(10) NOT NULL DEFAULT 1,
  `catid` varchar(255) NOT NULL,
  `htmlcode` longtext NOT NULL,
  `checked_out` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_pagebuilderck_pages`
--

CREATE TABLE `jba8l_pagebuilderck_pages` (
  `id` int(10) NOT NULL,
  `title` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `ordering` int(11) NOT NULL,
  `state` int(10) NOT NULL DEFAULT 1,
  `created` datetime NOT NULL,
  `catid` varchar(255) NOT NULL,
  `created_by` int(10) NOT NULL,
  `params` text NOT NULL,
  `access` int(10) NOT NULL,
  `hits` int(10) NOT NULL,
  `featured` tinyint(3) NOT NULL,
  `htmlcode` longtext NOT NULL,
  `checked_out` varchar(10) NOT NULL,
  `modified` datetime NOT NULL DEFAULT '1970-01-02 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_plg_system_cookiespolicynotificationbar_logs`
--

CREATE TABLE `jba8l_plg_system_cookiespolicynotificationbar_logs` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(100) DEFAULT NULL,
  `status` varchar(255) NOT NULL,
  `datetime` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `cookiesinfo` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_postinstall_messages`
--

CREATE TABLE `jba8l_postinstall_messages` (
  `postinstall_message_id` bigint(20) UNSIGNED NOT NULL,
  `extension_id` bigint(20) NOT NULL DEFAULT 700 COMMENT 'FK to #__extensions',
  `title_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'Lang key for the title',
  `description_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'Lang key for description',
  `action_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `language_extension` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'com_postinstall' COMMENT 'Extension holding lang keys',
  `language_client_id` tinyint(3) NOT NULL DEFAULT 1,
  `type` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'link' COMMENT 'Message type - message, link, action',
  `action_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT 'RAD URI to the PHP file containing action method',
  `action` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT 'Action method name or URL',
  `condition_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'RAD URI to file holding display condition method',
  `condition_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Display condition method, must return boolean',
  `version_introduced` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '3.2.0' COMMENT 'Version when this message was introduced',
  `enabled` tinyint(3) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_privacy_consents`
--

CREATE TABLE `jba8l_privacy_consents` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `state` int(10) NOT NULL DEFAULT 1,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `remind` tinyint(4) NOT NULL DEFAULT 0,
  `token` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_privacy_requests`
--

CREATE TABLE `jba8l_privacy_requests` (
  `id` int(10) UNSIGNED NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `requested_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `request_type` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `confirm_token` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `confirm_token_created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_quix`
--

CREATE TABLE `jba8l_quix` (
  `id` int(11) UNSIGNED NOT NULL,
  `asset_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `title` varchar(255) NOT NULL,
  `catid` int(11) NOT NULL,
  `builder` enum('classic','frontend') NOT NULL DEFAULT 'classic',
  `builder_version` varchar(10) NOT NULL DEFAULT '',
  `data` longtext NOT NULL,
  `metadata` longtext NOT NULL,
  `language` varchar(5) NOT NULL,
  `ordering` int(11) NOT NULL,
  `state` tinyint(1) NOT NULL,
  `access` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `checked_out` int(11) NOT NULL,
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `params` longtext NOT NULL,
  `version` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `hits` int(11) NOT NULL,
  `xreference` varchar(50) NOT NULL COMMENT 'A reference to enable linkages to external data sets.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_quix_collections`
--

CREATE TABLE `jba8l_quix_collections` (
  `id` int(11) UNSIGNED NOT NULL,
  `asset_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `uid` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'section',
  `catid` int(11) NOT NULL,
  `builder` enum('classic','frontend') NOT NULL DEFAULT 'classic',
  `builder_version` varchar(10) NOT NULL DEFAULT '',
  `data` longtext NOT NULL,
  `metadata` longtext NOT NULL,
  `language` varchar(5) NOT NULL,
  `ordering` int(11) NOT NULL,
  `state` tinyint(1) NOT NULL,
  `access` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `checked_out` int(11) NOT NULL,
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `params` longtext NOT NULL,
  `version` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `hits` int(11) NOT NULL,
  `xreference` varchar(50) NOT NULL COMMENT 'A reference to enable linkages to external data sets.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_quix_collection_map`
--

CREATE TABLE `jba8l_quix_collection_map` (
  `id` int(11) UNSIGNED NOT NULL,
  `cid` int(11) UNSIGNED NOT NULL,
  `pid` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_quix_conditions`
--

CREATE TABLE `jba8l_quix_conditions` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `item_type` varchar(100) NOT NULL,
  `component` varchar(100) NOT NULL,
  `condition_type` varchar(100) NOT NULL COMMENT 'articles, categories, menus',
  `condition_id` int(11) NOT NULL COMMENT 'type id',
  `condition_info` varchar(100) NOT NULL COMMENT 'type info direct to search',
  `params` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_quix_configs`
--

CREATE TABLE `jba8l_quix_configs` (
  `name` varchar(255) NOT NULL,
  `params` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Store any configuration in key => params maps';

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_quix_editor_map`
--

CREATE TABLE `jba8l_quix_editor_map` (
  `id` int(11) NOT NULL,
  `context` varchar(100) NOT NULL,
  `context_id` int(11) NOT NULL,
  `collection_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `params` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_quix_elements`
--

CREATE TABLE `jba8l_quix_elements` (
  `id` smallint(6) NOT NULL,
  `alias` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `params` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_quix_imgstats`
--

CREATE TABLE `jba8l_quix_imgstats` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `item_type` varchar(100) NOT NULL,
  `images_count` int(11) NOT NULL,
  `original_size` int(11) NOT NULL,
  `optimise_size` int(11) NOT NULL,
  `mobile_size` int(11) NOT NULL,
  `params` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_redirect_links`
--

CREATE TABLE `jba8l_redirect_links` (
  `id` int(10) UNSIGNED NOT NULL,
  `old_url` varchar(2048) COLLATE utf8mb4_unicode_ci NOT NULL,
  `new_url` varchar(2048) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `referer` varchar(2048) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `hits` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `published` tinyint(4) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `header` smallint(3) NOT NULL DEFAULT 301
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_rokcommon_configs`
--

CREATE TABLE `jba8l_rokcommon_configs` (
  `id` int(11) NOT NULL,
  `extension` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `type` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `priority` int(10) NOT NULL DEFAULT 10
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_roksprocket_items`
--

CREATE TABLE `jba8l_roksprocket_items` (
  `id` int(11) NOT NULL,
  `module_id` varchar(45) NOT NULL,
  `provider` varchar(45) NOT NULL,
  `provider_id` varchar(45) NOT NULL,
  `order` int(10) UNSIGNED NOT NULL,
  `params` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_rsfirewall_configuration`
--

CREATE TABLE `jba8l_rsfirewall_configuration` (
  `name` varchar(255) NOT NULL,
  `value` text NOT NULL,
  `type` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_rsfirewall_exceptions`
--

CREATE TABLE `jba8l_rsfirewall_exceptions` (
  `id` int(11) NOT NULL,
  `type` varchar(4) NOT NULL,
  `regex` tinyint(1) NOT NULL,
  `match` text NOT NULL,
  `php` tinyint(1) NOT NULL,
  `sql` tinyint(1) NOT NULL,
  `js` tinyint(1) NOT NULL,
  `uploads` tinyint(1) NOT NULL,
  `reason` text DEFAULT NULL,
  `date` datetime NOT NULL,
  `published` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_rsfirewall_hashes`
--

CREATE TABLE `jba8l_rsfirewall_hashes` (
  `id` int(11) NOT NULL,
  `file` text NOT NULL,
  `hash` varchar(32) NOT NULL,
  `type` varchar(64) NOT NULL,
  `flag` varchar(1) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_rsfirewall_ignored`
--

CREATE TABLE `jba8l_rsfirewall_ignored` (
  `path` text NOT NULL,
  `type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_rsfirewall_lists`
--

CREATE TABLE `jba8l_rsfirewall_lists` (
  `id` int(11) NOT NULL,
  `ip` varchar(255) NOT NULL,
  `type` tinyint(1) NOT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `date` datetime NOT NULL,
  `published` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_rsfirewall_logs`
--

CREATE TABLE `jba8l_rsfirewall_logs` (
  `id` int(11) NOT NULL,
  `level` enum('low','medium','high','critical') NOT NULL,
  `date` datetime NOT NULL,
  `ip` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `page` text DEFAULT NULL,
  `referer` text DEFAULT NULL,
  `code` varchar(255) NOT NULL,
  `debug_variables` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_rsfirewall_offenders`
--

CREATE TABLE `jba8l_rsfirewall_offenders` (
  `id` int(11) NOT NULL,
  `ip` varchar(255) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_rsfirewall_signatures`
--

CREATE TABLE `jba8l_rsfirewall_signatures` (
  `signature` varchar(255) NOT NULL,
  `type` varchar(16) NOT NULL,
  `reason` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_rsfirewall_snapshots`
--

CREATE TABLE `jba8l_rsfirewall_snapshots` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `snapshot` text NOT NULL,
  `type` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_rsform_calculations`
--

CREATE TABLE `jba8l_rsform_calculations` (
  `id` int(11) NOT NULL,
  `formId` int(11) NOT NULL,
  `total` varchar(255) NOT NULL,
  `expression` text NOT NULL,
  `ordering` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_rsform_components`
--

CREATE TABLE `jba8l_rsform_components` (
  `ComponentId` int(11) NOT NULL,
  `FormId` int(11) NOT NULL DEFAULT 0,
  `ComponentTypeId` int(11) NOT NULL DEFAULT 0,
  `Order` int(11) NOT NULL DEFAULT 0,
  `Published` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_rsform_component_types`
--

CREATE TABLE `jba8l_rsform_component_types` (
  `ComponentTypeId` int(11) NOT NULL,
  `ComponentTypeName` text NOT NULL,
  `CanBeDuplicated` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_rsform_component_type_fields`
--

CREATE TABLE `jba8l_rsform_component_type_fields` (
  `ComponentTypeId` int(11) NOT NULL DEFAULT 0,
  `FieldName` text NOT NULL,
  `FieldType` varchar(32) NOT NULL DEFAULT 'hidden',
  `FieldValues` text NOT NULL,
  `Properties` text NOT NULL,
  `Ordering` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_rsform_conditions`
--

CREATE TABLE `jba8l_rsform_conditions` (
  `id` int(11) NOT NULL,
  `form_id` int(11) NOT NULL,
  `action` varchar(16) NOT NULL,
  `block` tinyint(1) NOT NULL,
  `component_id` text NOT NULL,
  `condition` varchar(16) NOT NULL,
  `lang_code` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_rsform_condition_details`
--

CREATE TABLE `jba8l_rsform_condition_details` (
  `id` int(11) NOT NULL,
  `condition_id` int(11) NOT NULL,
  `component_id` int(11) NOT NULL,
  `operator` varchar(16) NOT NULL,
  `value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_rsform_config`
--

CREATE TABLE `jba8l_rsform_config` (
  `SettingName` varchar(64) NOT NULL DEFAULT '',
  `SettingValue` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_rsform_directory`
--

CREATE TABLE `jba8l_rsform_directory` (
  `formId` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL DEFAULT 'export.pdf',
  `csvfilename` varchar(255) NOT NULL DEFAULT '{alias}.csv',
  `enablepdf` tinyint(1) NOT NULL,
  `enablecsv` tinyint(1) NOT NULL,
  `HideEmptyValues` tinyint(1) NOT NULL,
  `ShowGoogleMap` tinyint(1) NOT NULL,
  `ViewLayout` longtext NOT NULL,
  `ViewLayoutName` text NOT NULL,
  `ViewLayoutAutogenerate` tinyint(1) NOT NULL,
  `CSS` mediumtext NOT NULL,
  `JS` mediumtext NOT NULL,
  `ListScript` mediumtext NOT NULL,
  `DetailsScript` mediumtext NOT NULL,
  `EmailsScript` mediumtext NOT NULL,
  `EmailsCreatedScript` mediumtext NOT NULL,
  `groups` text NOT NULL,
  `DeletionGroups` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_rsform_directory_fields`
--

CREATE TABLE `jba8l_rsform_directory_fields` (
  `formId` int(11) NOT NULL,
  `componentId` int(11) NOT NULL,
  `viewable` tinyint(1) NOT NULL,
  `searchable` tinyint(1) NOT NULL,
  `editable` tinyint(1) NOT NULL,
  `indetails` tinyint(1) NOT NULL,
  `incsv` tinyint(1) NOT NULL,
  `ordering` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_rsform_emails`
--

CREATE TABLE `jba8l_rsform_emails` (
  `id` int(11) NOT NULL,
  `formId` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `from` varchar(255) NOT NULL,
  `fromname` varchar(255) NOT NULL,
  `replyto` varchar(255) NOT NULL,
  `replytoname` varchar(255) NOT NULL,
  `to` varchar(255) NOT NULL,
  `cc` varchar(255) NOT NULL,
  `bcc` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `mode` tinyint(1) NOT NULL,
  `message` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_rsform_forms`
--

CREATE TABLE `jba8l_rsform_forms` (
  `FormId` int(11) NOT NULL,
  `FormName` text NOT NULL,
  `FormLayout` longtext NOT NULL,
  `GridLayout` mediumtext NOT NULL,
  `FormLayoutName` text NOT NULL,
  `LoadFormLayoutFramework` tinyint(1) NOT NULL DEFAULT 1,
  `FormLayoutAutogenerate` tinyint(1) NOT NULL DEFAULT 1,
  `FormLayoutFlow` tinyint(1) NOT NULL DEFAULT 0,
  `DisableSubmitButton` tinyint(1) NOT NULL DEFAULT 0,
  `RemoveCaptchaLogged` tinyint(1) NOT NULL DEFAULT 0,
  `CSS` mediumtext NOT NULL,
  `JS` mediumtext NOT NULL,
  `FormTitle` text NOT NULL,
  `ShowFormTitle` tinyint(1) NOT NULL DEFAULT 1,
  `Published` tinyint(1) NOT NULL DEFAULT 1,
  `Lang` varchar(255) NOT NULL DEFAULT '',
  `ReturnUrl` text NOT NULL,
  `ShowSystemMessage` tinyint(1) NOT NULL DEFAULT 1,
  `ShowThankyou` tinyint(1) NOT NULL DEFAULT 1,
  `ScrollToThankYou` tinyint(1) NOT NULL DEFAULT 0,
  `ThankYouMessagePopUp` tinyint(1) NOT NULL DEFAULT 0,
  `Thankyou` mediumtext NOT NULL,
  `ShowContinue` tinyint(1) NOT NULL DEFAULT 1,
  `UserEmailText` mediumtext NOT NULL,
  `UserEmailTo` text NOT NULL,
  `UserEmailCC` varchar(255) NOT NULL,
  `UserEmailBCC` varchar(255) NOT NULL,
  `UserEmailFrom` varchar(255) NOT NULL DEFAULT '',
  `UserEmailReplyTo` varchar(255) NOT NULL,
  `UserEmailReplyToName` varchar(255) NOT NULL,
  `UserEmailFromName` varchar(255) NOT NULL DEFAULT '',
  `UserEmailSubject` varchar(255) NOT NULL DEFAULT '',
  `UserEmailMode` tinyint(1) NOT NULL DEFAULT 1,
  `UserEmailAttach` tinyint(1) NOT NULL,
  `UserEmailAttachFile` varchar(255) NOT NULL,
  `UserEmailGenerate` tinyint(1) NOT NULL DEFAULT 0,
  `AdminEmailText` mediumtext NOT NULL,
  `AdminEmailTo` text NOT NULL,
  `AdminEmailCC` varchar(255) NOT NULL,
  `AdminEmailBCC` varchar(255) NOT NULL,
  `AdminEmailFrom` varchar(255) NOT NULL DEFAULT '',
  `AdminEmailReplyTo` varchar(255) NOT NULL,
  `AdminEmailReplyToName` varchar(255) NOT NULL,
  `AdminEmailFromName` varchar(255) NOT NULL DEFAULT '',
  `AdminEmailSubject` varchar(255) NOT NULL DEFAULT '',
  `AdminEmailMode` tinyint(1) NOT NULL DEFAULT 1,
  `AdminEmailGenerate` tinyint(1) NOT NULL DEFAULT 0,
  `DeletionEmailText` mediumtext NOT NULL,
  `DeletionEmailTo` text NOT NULL,
  `DeletionEmailCC` varchar(255) NOT NULL,
  `DeletionEmailBCC` varchar(255) NOT NULL,
  `DeletionEmailFrom` varchar(255) NOT NULL DEFAULT '',
  `DeletionEmailReplyTo` varchar(255) NOT NULL,
  `DeletionEmailReplyToName` varchar(255) NOT NULL,
  `DeletionEmailFromName` varchar(255) NOT NULL DEFAULT '',
  `DeletionEmailSubject` varchar(255) NOT NULL DEFAULT '',
  `DeletionEmailMode` tinyint(1) NOT NULL DEFAULT 1,
  `ScriptProcess` mediumtext NOT NULL,
  `ScriptProcess2` mediumtext NOT NULL,
  `ScriptBeforeDisplay` mediumtext NOT NULL,
  `ScriptBeforeValidation` mediumtext NOT NULL,
  `ScriptDisplay` mediumtext NOT NULL,
  `UserEmailScript` mediumtext NOT NULL,
  `AdminEmailScript` mediumtext NOT NULL,
  `AdditionalEmailsScript` mediumtext NOT NULL,
  `MetaTitle` tinyint(1) NOT NULL,
  `MetaDesc` text NOT NULL,
  `MetaKeywords` text NOT NULL,
  `Required` varchar(255) NOT NULL DEFAULT '(*)',
  `ErrorMessage` text NOT NULL,
  `MultipleSeparator` varchar(64) NOT NULL DEFAULT '\\n',
  `TextareaNewLines` tinyint(1) NOT NULL DEFAULT 1,
  `CSSClass` varchar(255) NOT NULL,
  `CSSId` varchar(255) NOT NULL DEFAULT 'userForm',
  `CSSName` varchar(255) NOT NULL,
  `CSSAction` text NOT NULL,
  `CSSAdditionalAttributes` text NOT NULL,
  `AjaxValidation` tinyint(1) NOT NULL,
  `ScrollToError` tinyint(1) NOT NULL,
  `Keepdata` tinyint(1) NOT NULL DEFAULT 1,
  `KeepIP` tinyint(1) NOT NULL DEFAULT 1,
  `DeleteSubmissionsAfter` int(11) NOT NULL DEFAULT 0,
  `Backendmenu` tinyint(1) NOT NULL,
  `ConfirmSubmission` tinyint(1) NOT NULL DEFAULT 0,
  `ConfirmSubmissionUrl` text NOT NULL,
  `Access` varchar(5) NOT NULL,
  `LimitSubmissions` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_rsform_mappings`
--

CREATE TABLE `jba8l_rsform_mappings` (
  `id` int(11) NOT NULL,
  `formId` int(11) NOT NULL,
  `connection` tinyint(1) NOT NULL,
  `host` varchar(255) NOT NULL,
  `driver` varchar(16) NOT NULL,
  `port` int(10) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `database` varchar(255) NOT NULL,
  `method` tinyint(1) NOT NULL,
  `table` varchar(255) NOT NULL,
  `data` mediumtext NOT NULL,
  `wheredata` mediumtext NOT NULL,
  `extra` mediumtext NOT NULL,
  `andor` text NOT NULL,
  `ordering` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_rsform_posts`
--

CREATE TABLE `jba8l_rsform_posts` (
  `form_id` int(11) NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `method` tinyint(1) NOT NULL,
  `fields` mediumtext NOT NULL,
  `headers` mediumtext NOT NULL,
  `silent` tinyint(1) NOT NULL,
  `url` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_rsform_properties`
--

CREATE TABLE `jba8l_rsform_properties` (
  `PropertyId` int(11) NOT NULL,
  `ComponentId` int(11) NOT NULL DEFAULT 0,
  `PropertyName` text NOT NULL,
  `PropertyValue` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_rsform_submissions`
--

CREATE TABLE `jba8l_rsform_submissions` (
  `SubmissionId` int(11) NOT NULL,
  `FormId` int(11) NOT NULL DEFAULT 0,
  `DateSubmitted` datetime NOT NULL,
  `UserIp` varchar(255) NOT NULL DEFAULT '',
  `Username` varchar(255) NOT NULL DEFAULT '',
  `UserId` int(11) NOT NULL DEFAULT 0,
  `Lang` varchar(255) NOT NULL,
  `confirmed` tinyint(1) NOT NULL,
  `SubmissionHash` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_rsform_submission_columns`
--

CREATE TABLE `jba8l_rsform_submission_columns` (
  `FormId` int(11) NOT NULL,
  `ColumnName` varchar(255) NOT NULL,
  `ColumnStatic` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_rsform_submission_values`
--

CREATE TABLE `jba8l_rsform_submission_values` (
  `SubmissionValueId` int(11) NOT NULL,
  `FormId` int(11) NOT NULL,
  `SubmissionId` int(11) NOT NULL DEFAULT 0,
  `FieldName` text NOT NULL,
  `FieldValue` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_rsform_translations`
--

CREATE TABLE `jba8l_rsform_translations` (
  `id` int(11) NOT NULL,
  `form_id` int(11) NOT NULL,
  `lang_code` varchar(32) NOT NULL,
  `reference` varchar(255) NOT NULL,
  `reference_id` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_scheduler_jobs`
--

CREATE TABLE `jba8l_scheduler_jobs` (
  `uuid` char(36) NOT NULL,
  `identifier` varchar(255) NOT NULL DEFAULT '',
  `package` varchar(64) NOT NULL DEFAULT '',
  `frequency` varchar(128) NOT NULL DEFAULT '',
  `status` int(11) NOT NULL DEFAULT 0,
  `queue` tinyint(4) NOT NULL DEFAULT 0,
  `ordering` int(11) NOT NULL DEFAULT 0,
  `state` text DEFAULT NULL,
  `modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `completed_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_scheduler_metadata`
--

CREATE TABLE `jba8l_scheduler_metadata` (
  `type` varchar(32) NOT NULL DEFAULT '',
  `sleep_until` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_run` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_schemas`
--

CREATE TABLE `jba8l_schemas` (
  `extension_id` int(11) NOT NULL,
  `version_id` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_session`
--

CREATE TABLE `jba8l_session` (
  `session_id` varbinary(192) NOT NULL,
  `client_id` tinyint(3) UNSIGNED DEFAULT NULL,
  `guest` tinyint(3) UNSIGNED DEFAULT 1,
  `time` int(11) NOT NULL DEFAULT 0,
  `data` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `userid` int(11) DEFAULT 0,
  `username` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_spmedia`
--

CREATE TABLE `jba8l_spmedia` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT '',
  `path` varchar(255) NOT NULL DEFAULT '',
  `thumb` varchar(255) NOT NULL DEFAULT '',
  `alt` varchar(255) NOT NULL DEFAULT '',
  `caption` varchar(2048) NOT NULL DEFAULT '',
  `description` mediumtext NOT NULL,
  `type` varchar(100) NOT NULL DEFAULT 'image',
  `media_attr` varchar(5120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '{}',
  `extension` varchar(100) NOT NULL DEFAULT '',
  `created_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` bigint(20) NOT NULL DEFAULT 0,
  `modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` bigint(20) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_sppagebuilder`
--

CREATE TABLE `jba8l_sppagebuilder` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `asset_id` int(11) NOT NULL DEFAULT 0,
  `title` varchar(255) NOT NULL DEFAULT '',
  `text` mediumtext NOT NULL,
  `extension` varchar(255) NOT NULL DEFAULT 'com_sppagebuilder',
  `extension_view` varchar(255) NOT NULL DEFAULT 'page',
  `view_id` bigint(20) NOT NULL DEFAULT 0,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `published` tinyint(3) NOT NULL DEFAULT 1,
  `catid` int(10) NOT NULL DEFAULT 0,
  `access` int(10) NOT NULL DEFAULT 0,
  `ordering` int(11) NOT NULL DEFAULT 0,
  `created_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` bigint(20) NOT NULL DEFAULT 0,
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` bigint(20) NOT NULL DEFAULT 0,
  `checked_out` int(10) NOT NULL DEFAULT 0,
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `attribs` varchar(5120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '[]',
  `og_title` varchar(255) NOT NULL DEFAULT '',
  `og_image` varchar(255) NOT NULL DEFAULT '',
  `og_description` varchar(255) NOT NULL DEFAULT '',
  `language` char(7) NOT NULL DEFAULT '',
  `hits` bigint(20) NOT NULL DEFAULT 0,
  `css` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_sppagebuilder_addons`
--

CREATE TABLE `jba8l_sppagebuilder_addons` (
  `id` int(5) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT '',
  `code` mediumtext NOT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` bigint(20) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_sppagebuilder_integrations`
--

CREATE TABLE `jba8l_sppagebuilder_integrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT '',
  `description` mediumtext NOT NULL,
  `component` varchar(255) NOT NULL DEFAULT '',
  `plugin` mediumtext NOT NULL,
  `state` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_sppagebuilder_languages`
--

CREATE TABLE `jba8l_sppagebuilder_languages` (
  `id` int(5) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT '',
  `description` mediumtext NOT NULL,
  `lang_tag` varchar(255) NOT NULL DEFAULT '',
  `lang_key` varchar(100) DEFAULT NULL,
  `version` varchar(255) NOT NULL DEFAULT '',
  `state` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_sppagebuilder_sections`
--

CREATE TABLE `jba8l_sppagebuilder_sections` (
  `id` int(5) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT '',
  `section` mediumtext NOT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` bigint(20) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_survey_force_authors`
--

CREATE TABLE `jba8l_survey_force_authors` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_survey_force_cats`
--

CREATE TABLE `jba8l_survey_force_cats` (
  `id` int(11) NOT NULL,
  `sf_catname` varchar(250) NOT NULL DEFAULT '',
  `sf_catdescr` text NOT NULL,
  `published` tinyint(4) NOT NULL DEFAULT 1,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `ordering` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_survey_force_config`
--

CREATE TABLE `jba8l_survey_force_config` (
  `config_var` varchar(50) NOT NULL DEFAULT '',
  `config_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_survey_force_dashboard_items`
--

CREATE TABLE `jba8l_survey_force_dashboard_items` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `published` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_survey_force_def_answers`
--

CREATE TABLE `jba8l_survey_force_def_answers` (
  `id` int(11) NOT NULL,
  `survey_id` int(11) NOT NULL DEFAULT 0,
  `quest_id` int(11) NOT NULL DEFAULT 0,
  `answer` int(11) NOT NULL DEFAULT 0,
  `ans_field` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_survey_force_emails`
--

CREATE TABLE `jba8l_survey_force_emails` (
  `id` int(11) NOT NULL,
  `email_subject` varchar(100) NOT NULL DEFAULT '',
  `email_body` text NOT NULL,
  `email_reply` varchar(100) NOT NULL DEFAULT '',
  `user_id` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_survey_force_fields`
--

CREATE TABLE `jba8l_survey_force_fields` (
  `id` int(11) NOT NULL,
  `quest_id` int(11) NOT NULL DEFAULT 0,
  `ftext` text NOT NULL,
  `alt_field_id` int(11) NOT NULL DEFAULT 0,
  `is_main` int(11) NOT NULL DEFAULT 0,
  `is_true` int(11) NOT NULL DEFAULT 0,
  `ordering` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_survey_force_invitations`
--

CREATE TABLE `jba8l_survey_force_invitations` (
  `id` int(11) NOT NULL,
  `invite_num` varchar(32) NOT NULL DEFAULT '',
  `user_id` int(11) NOT NULL DEFAULT 0,
  `inv_status` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_survey_force_iscales`
--

CREATE TABLE `jba8l_survey_force_iscales` (
  `id` int(11) NOT NULL,
  `iscale_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_survey_force_iscales_fields`
--

CREATE TABLE `jba8l_survey_force_iscales_fields` (
  `id` int(11) NOT NULL,
  `iscale_id` int(11) NOT NULL,
  `isf_name` varchar(50) NOT NULL,
  `ordering` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_survey_force_listusers`
--

CREATE TABLE `jba8l_survey_force_listusers` (
  `id` int(11) NOT NULL,
  `listname` varchar(50) NOT NULL DEFAULT '',
  `survey_id` int(11) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_invited` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_remind` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `is_invited` tinyint(4) NOT NULL DEFAULT 0,
  `sf_author_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_survey_force_previews`
--

CREATE TABLE `jba8l_survey_force_previews` (
  `id` int(11) NOT NULL,
  `start_id` int(11) NOT NULL DEFAULT 0,
  `survey_id` int(11) NOT NULL DEFAULT 0,
  `unique_id` varchar(32) NOT NULL DEFAULT '',
  `preview_id` varchar(32) NOT NULL DEFAULT '',
  `time` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_survey_force_qsections`
--

CREATE TABLE `jba8l_survey_force_qsections` (
  `id` int(11) NOT NULL,
  `sf_name` varchar(250) NOT NULL DEFAULT '',
  `addname` tinyint(4) NOT NULL DEFAULT 0,
  `ordering` tinyint(4) NOT NULL DEFAULT 0,
  `sf_survey_id` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_survey_force_qtypes`
--

CREATE TABLE `jba8l_survey_force_qtypes` (
  `id` int(11) NOT NULL,
  `sf_qtype` varchar(50) NOT NULL DEFAULT '',
  `sf_plg_name` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_survey_force_quests`
--

CREATE TABLE `jba8l_survey_force_quests` (
  `id` int(11) NOT NULL,
  `sf_survey` int(11) NOT NULL DEFAULT 0,
  `sf_qtype` int(11) NOT NULL DEFAULT 0,
  `sf_qtext` text NOT NULL,
  `sf_impscale` int(11) NOT NULL DEFAULT 0,
  `sf_rule` int(11) NOT NULL DEFAULT 0,
  `sf_fieldtype` varchar(255) NOT NULL DEFAULT '',
  `ordering` int(11) NOT NULL DEFAULT 0,
  `sf_compulsory` tinyint(4) NOT NULL DEFAULT 1,
  `sf_section_id` int(11) NOT NULL DEFAULT 0,
  `published` tinyint(4) NOT NULL DEFAULT 0,
  `sf_qstyle` int(11) NOT NULL DEFAULT 0,
  `sf_num_options` tinyint(4) NOT NULL DEFAULT 0,
  `sf_default_hided` tinyint(4) NOT NULL DEFAULT 0,
  `is_final_question` tinyint(3) NOT NULL DEFAULT 0,
  `is_shuffle` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `sf_qdescr` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_survey_force_quest_show`
--

CREATE TABLE `jba8l_survey_force_quest_show` (
  `id` int(11) NOT NULL,
  `quest_id` int(11) NOT NULL DEFAULT 0,
  `survey_id` int(11) NOT NULL DEFAULT 0,
  `quest_id_a` int(11) NOT NULL DEFAULT 0,
  `answer` int(11) NOT NULL DEFAULT 0,
  `ans_field` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_survey_force_rules`
--

CREATE TABLE `jba8l_survey_force_rules` (
  `id` int(11) NOT NULL,
  `quest_id` int(11) NOT NULL DEFAULT 0,
  `answer_id` int(11) NOT NULL DEFAULT 0,
  `next_quest_id` int(11) NOT NULL DEFAULT 0,
  `alt_field_id` int(11) NOT NULL DEFAULT 0,
  `priority` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_survey_force_scales`
--

CREATE TABLE `jba8l_survey_force_scales` (
  `id` int(11) NOT NULL,
  `quest_id` int(11) NOT NULL DEFAULT 0,
  `stext` varchar(250) NOT NULL DEFAULT '',
  `ordering` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_survey_force_survs`
--

CREATE TABLE `jba8l_survey_force_survs` (
  `id` int(11) NOT NULL,
  `sf_name` varchar(250) NOT NULL DEFAULT '',
  `sf_descr` text NOT NULL,
  `sf_image` varchar(250) NOT NULL DEFAULT '',
  `sf_cat` int(11) NOT NULL DEFAULT 0,
  `sf_lang` int(11) NOT NULL DEFAULT 0,
  `sf_author` int(11) NOT NULL DEFAULT 0,
  `sf_public` tinyint(4) NOT NULL DEFAULT 0,
  `sf_invite` tinyint(4) NOT NULL DEFAULT 0,
  `sf_reg` tinyint(4) NOT NULL DEFAULT 0,
  `published` tinyint(4) NOT NULL DEFAULT 0,
  `sf_fpage_type` tinyint(4) NOT NULL DEFAULT 0,
  `sf_fpage_text` text DEFAULT NULL,
  `sf_special` text NOT NULL,
  `sf_auto_pb` tinyint(4) NOT NULL DEFAULT 1,
  `sf_progressbar` tinyint(4) NOT NULL DEFAULT 1,
  `sf_progressbar_type` tinyint(1) NOT NULL DEFAULT 0,
  `asset_id` int(10) NOT NULL DEFAULT 0,
  `sf_use_css` tinyint(4) NOT NULL DEFAULT 0,
  `sf_enable_descr` tinyint(4) NOT NULL DEFAULT 1,
  `sf_reg_voting` tinyint(4) NOT NULL DEFAULT 0,
  `sf_inv_voting` tinyint(4) NOT NULL DEFAULT 1,
  `sf_template` int(11) NOT NULL DEFAULT 1,
  `sf_pub_voting` tinyint(4) NOT NULL DEFAULT 0,
  `sf_pub_control` tinyint(4) NOT NULL DEFAULT 0,
  `surv_short_descr` text DEFAULT NULL,
  `sf_after_start` tinyint(4) NOT NULL DEFAULT 0,
  `sf_redirect_enable` tinyint(3) NOT NULL DEFAULT 0,
  `sf_redirect_url` varchar(250) DEFAULT '',
  `sf_redirect_delay` int(15) NOT NULL DEFAULT 0,
  `sf_prev_enable` tinyint(3) NOT NULL DEFAULT 1,
  `sf_anonymous` tinyint(4) NOT NULL DEFAULT 0,
  `sf_friend` tinyint(4) NOT NULL DEFAULT 0,
  `sf_friend_voting` tinyint(4) NOT NULL DEFAULT 0,
  `sf_random` tinyint(4) NOT NULL DEFAULT 0,
  `sf_step` int(3) NOT NULL,
  `sf_date_started` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `sf_date_expired` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_survey_force_templates`
--

CREATE TABLE `jba8l_survey_force_templates` (
  `id` int(11) NOT NULL,
  `sf_name` varchar(250) NOT NULL DEFAULT '',
  `sf_display_name` varchar(255) NOT NULL,
  `display` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_survey_force_users`
--

CREATE TABLE `jba8l_survey_force_users` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL DEFAULT '',
  `lastname` varchar(50) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL DEFAULT '',
  `list_id` int(11) NOT NULL DEFAULT 0,
  `invite_id` int(11) NOT NULL DEFAULT 0,
  `is_invited` int(11) NOT NULL DEFAULT 0,
  `is_reminded` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_survey_force_user_answers`
--

CREATE TABLE `jba8l_survey_force_user_answers` (
  `id` int(11) NOT NULL,
  `start_id` int(11) NOT NULL DEFAULT 0,
  `survey_id` int(11) NOT NULL DEFAULT 0,
  `quest_id` int(11) NOT NULL DEFAULT 0,
  `answer` int(11) NOT NULL DEFAULT 0,
  `ans_field` int(11) NOT NULL DEFAULT 0,
  `next_quest_id` int(11) NOT NULL DEFAULT 0,
  `sf_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_survey_force_user_answers_imp`
--

CREATE TABLE `jba8l_survey_force_user_answers_imp` (
  `id` int(11) NOT NULL,
  `start_id` int(11) NOT NULL,
  `survey_id` int(11) NOT NULL,
  `quest_id` int(11) NOT NULL,
  `iscale_id` int(11) NOT NULL,
  `iscalefield_id` int(11) NOT NULL,
  `sf_imptime` datetime DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_survey_force_user_ans_txt`
--

CREATE TABLE `jba8l_survey_force_user_ans_txt` (
  `id` int(11) NOT NULL,
  `start_id` int(11) NOT NULL DEFAULT 0,
  `ans_txt` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_survey_force_user_chain`
--

CREATE TABLE `jba8l_survey_force_user_chain` (
  `id` int(11) NOT NULL,
  `start_id` int(11) NOT NULL DEFAULT 0,
  `survey_id` int(11) NOT NULL DEFAULT 0,
  `unique_id` varchar(32) DEFAULT '',
  `invite_id` int(11) NOT NULL DEFAULT 0,
  `sf_time` int(11) NOT NULL DEFAULT 0,
  `sf_chain` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_survey_force_user_starts`
--

CREATE TABLE `jba8l_survey_force_user_starts` (
  `id` int(11) NOT NULL,
  `unique_id` varchar(32) NOT NULL DEFAULT '',
  `usertype` tinyint(4) NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `invite_id` int(11) NOT NULL DEFAULT 0,
  `sf_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `survey_id` int(11) NOT NULL DEFAULT 0,
  `is_complete` tinyint(4) NOT NULL DEFAULT 0,
  `sf_ip_address` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_tags`
--

CREATE TABLE `jba8l_tags` (
  `id` int(10) UNSIGNED NOT NULL,
  `parent_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `lft` int(11) NOT NULL DEFAULT 0,
  `rgt` int(11) NOT NULL DEFAULT 0,
  `level` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `path` varchar(400) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alias` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '',
  `note` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `description` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT 0,
  `checked_out` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `access` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `params` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `metadesc` varchar(1024) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'The meta description for the page.',
  `metakey` varchar(1024) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'The meta keywords for the page.',
  `metadata` varchar(2048) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'JSON encoded metadata properties.',
  `created_user_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by_alias` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `modified_user_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `modified_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `images` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `urls` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `hits` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `language` char(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `version` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_template_styles`
--

CREATE TABLE `jba8l_template_styles` (
  `id` int(10) UNSIGNED NOT NULL,
  `template` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `client_id` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `home` char(7) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `params` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_ucm_base`
--

CREATE TABLE `jba8l_ucm_base` (
  `ucm_id` int(10) UNSIGNED NOT NULL,
  `ucm_item_id` int(10) NOT NULL,
  `ucm_type_id` int(11) NOT NULL,
  `ucm_language_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_ucm_content`
--

CREATE TABLE `jba8l_ucm_content` (
  `core_content_id` int(10) UNSIGNED NOT NULL,
  `core_type_alias` varchar(400) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'FK to the content types table',
  `core_title` varchar(400) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `core_alias` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '',
  `core_body` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `core_state` tinyint(1) NOT NULL DEFAULT 0,
  `core_checked_out_time` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0000-00-00 00:00:00',
  `core_checked_out_user_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `core_access` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `core_params` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `core_featured` tinyint(4) UNSIGNED NOT NULL DEFAULT 0,
  `core_metadata` varchar(2048) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'JSON encoded metadata properties.',
  `core_created_user_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `core_created_by_alias` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `core_created_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `core_modified_user_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Most recent user that modified',
  `core_modified_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `core_language` char(7) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `core_publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `core_publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `core_content_item_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'ID from the individual type table',
  `asset_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'FK to the #__assets table.',
  `core_images` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `core_urls` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `core_hits` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `core_version` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `core_ordering` int(11) NOT NULL DEFAULT 0,
  `core_metakey` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `core_metadesc` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `core_catid` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `core_xreference` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'A reference to enable linkages to external data sets.',
  `core_type_id` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Contains core content data in name spaced fields';

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_ucm_history`
--

CREATE TABLE `jba8l_ucm_history` (
  `version_id` int(10) UNSIGNED NOT NULL,
  `ucm_item_id` int(10) UNSIGNED NOT NULL,
  `ucm_type_id` int(10) UNSIGNED NOT NULL,
  `version_note` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'Optional version name',
  `save_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `editor_user_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `character_count` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Number of characters in this version.',
  `sha1_hash` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'SHA1 hash of the version_data column.',
  `version_data` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'json-encoded string of version data',
  `keep_forever` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0=auto delete; 1=keep'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_updates`
--

CREATE TABLE `jba8l_updates` (
  `update_id` int(11) NOT NULL,
  `update_site_id` int(11) DEFAULT 0,
  `extension_id` int(11) DEFAULT 0,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `element` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `type` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `folder` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `client_id` tinyint(3) DEFAULT 0,
  `version` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `detailsurl` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `infourl` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `extra_query` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Available Updates';

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_update_sites`
--

CREATE TABLE `jba8l_update_sites` (
  `update_site_id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `type` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `location` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `enabled` int(11) DEFAULT 0,
  `last_check_timestamp` bigint(20) DEFAULT 0,
  `extra_query` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Update Sites';

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_update_sites_extensions`
--

CREATE TABLE `jba8l_update_sites_extensions` (
  `update_site_id` int(11) NOT NULL DEFAULT 0,
  `extension_id` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Links extensions to update sites';

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_usergroups`
--

CREATE TABLE `jba8l_usergroups` (
  `id` int(10) UNSIGNED NOT NULL COMMENT 'Primary Key',
  `parent_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Adjacency List Reference Id',
  `lft` int(11) NOT NULL DEFAULT 0 COMMENT 'Nested set lft.',
  `rgt` int(11) NOT NULL DEFAULT 0 COMMENT 'Nested set rgt.',
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_users`
--

CREATE TABLE `jba8l_users` (
  `id` int(11) NOT NULL,
  `name` varchar(400) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `username` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `password` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `block` tinyint(4) NOT NULL DEFAULT 0,
  `sendEmail` tinyint(4) DEFAULT 0,
  `registerDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `lastvisitDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `activation` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `params` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastResetTime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Date of last password reset',
  `resetCount` int(11) NOT NULL DEFAULT 0 COMMENT 'Count of password resets since lastResetTime',
  `otpKey` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'Two factor authentication encrypted keys',
  `otep` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'One time emergency passwords',
  `requireReset` tinyint(4) NOT NULL DEFAULT 0 COMMENT 'Require user to reset password on next login'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_user_keys`
--

CREATE TABLE `jba8l_user_keys` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `series` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `invalid` tinyint(4) NOT NULL,
  `time` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uastring` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_user_notes`
--

CREATE TABLE `jba8l_user_notes` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `catid` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `subject` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` tinyint(3) NOT NULL DEFAULT 0,
  `checked_out` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_user_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_user_id` int(10) UNSIGNED NOT NULL,
  `modified_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `review_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_user_profiles`
--

CREATE TABLE `jba8l_user_profiles` (
  `user_id` int(11) NOT NULL,
  `profile_key` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile_value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ordering` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Simple user profile storage table';

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_user_usergroup_map`
--

CREATE TABLE `jba8l_user_usergroup_map` (
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Foreign Key to #__users.id',
  `group_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Foreign Key to #__usergroups.id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_utf8_conversion`
--

CREATE TABLE `jba8l_utf8_conversion` (
  `converted` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_viewlevels`
--

CREATE TABLE `jba8l_viewlevels` (
  `id` int(10) UNSIGNED NOT NULL COMMENT 'Primary Key',
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `ordering` int(11) NOT NULL DEFAULT 0,
  `rules` varchar(5120) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'JSON encoded access control.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_vvisit_counter`
--

CREATE TABLE `jba8l_vvisit_counter` (
  `time` int(10) UNSIGNED NOT NULL,
  `visits` mediumint(8) UNSIGNED NOT NULL DEFAULT 0,
  `guests` mediumint(8) UNSIGNED NOT NULL DEFAULT 0,
  `bots` mediumint(8) UNSIGNED NOT NULL DEFAULT 0,
  `members` mediumint(8) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_wf_profiles`
--

CREATE TABLE `jba8l_wf_profiles` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `users` text NOT NULL,
  `types` text NOT NULL,
  `components` text NOT NULL,
  `area` tinyint(3) NOT NULL,
  `device` varchar(255) NOT NULL,
  `rows` text NOT NULL,
  `plugins` text NOT NULL,
  `published` tinyint(3) NOT NULL,
  `ordering` int(11) NOT NULL,
  `checked_out` int(10) UNSIGNED DEFAULT NULL,
  `checked_out_time` datetime DEFAULT NULL,
  `params` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jba8l_widgetkit`
--

CREATE TABLE `jba8l_widgetkit` (
  `id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `data` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jba8l_action_logs`
--
ALTER TABLE `jba8l_action_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_user_id_logdate` (`user_id`,`log_date`),
  ADD KEY `idx_user_id_extension` (`user_id`,`extension`),
  ADD KEY `idx_extension_item_id` (`extension`,`item_id`);

--
-- Indexes for table `jba8l_action_logs_extensions`
--
ALTER TABLE `jba8l_action_logs_extensions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jba8l_action_logs_users`
--
ALTER TABLE `jba8l_action_logs_users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `idx_notify` (`notify`);

--
-- Indexes for table `jba8l_action_log_config`
--
ALTER TABLE `jba8l_action_log_config`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jba8l_activities_resources`
--
ALTER TABLE `jba8l_activities_resources`
  ADD PRIMARY KEY (`activities_resource_id`),
  ADD KEY `idx_package` (`package`),
  ADD KEY `idx_name` (`name`),
  ADD KEY `idx_package-name` (`package`,`name`);

--
-- Indexes for table `jba8l_admintools_acl`
--
ALTER TABLE `jba8l_admintools_acl`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `jba8l_admintools_adminiplist`
--
ALTER TABLE `jba8l_admintools_adminiplist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jba8l_admintools_badwords`
--
ALTER TABLE `jba8l_admintools_badwords`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `word` (`word`(100)),
  ADD UNIQUE KEY `word_2` (`word`(100)),
  ADD UNIQUE KEY `word_3` (`word`(100));

--
-- Indexes for table `jba8l_admintools_cookies`
--
ALTER TABLE `jba8l_admintools_cookies`
  ADD PRIMARY KEY (`series`(100));

--
-- Indexes for table `jba8l_admintools_customperms`
--
ALTER TABLE `jba8l_admintools_customperms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jba8l_admintools_customperms_path` (`path`(100));

--
-- Indexes for table `jba8l_admintools_filescache`
--
ALTER TABLE `jba8l_admintools_filescache`
  ADD PRIMARY KEY (`admintools_filescache_id`);

--
-- Indexes for table `jba8l_admintools_ipautoban`
--
ALTER TABLE `jba8l_admintools_ipautoban`
  ADD PRIMARY KEY (`ip`(100));

--
-- Indexes for table `jba8l_admintools_ipautobanhistory`
--
ALTER TABLE `jba8l_admintools_ipautobanhistory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jba8l_admintools_ipblock`
--
ALTER TABLE `jba8l_admintools_ipblock`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jba8l_admintools_log`
--
ALTER TABLE `jba8l_admintools_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jba8l_admintools_log_logdate_reason` (`logdate`,`reason`);

--
-- Indexes for table `jba8l_admintools_profiles`
--
ALTER TABLE `jba8l_admintools_profiles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jba8l_admintools_redirects`
--
ALTER TABLE `jba8l_admintools_redirects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jba8l_admintools_scanalerts`
--
ALTER TABLE `jba8l_admintools_scanalerts`
  ADD PRIMARY KEY (`admintools_scanalert_id`);

--
-- Indexes for table `jba8l_admintools_scans`
--
ALTER TABLE `jba8l_admintools_scans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_stale` (`status`,`origin`);

--
-- Indexes for table `jba8l_admintools_storage`
--
ALTER TABLE `jba8l_admintools_storage`
  ADD PRIMARY KEY (`key`(100));

--
-- Indexes for table `jba8l_admintools_tempsupers`
--
ALTER TABLE `jba8l_admintools_tempsupers`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `jba8l_admintools_wafblacklists`
--
ALTER TABLE `jba8l_admintools_wafblacklists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jba8l_admintools_wafexceptions`
--
ALTER TABLE `jba8l_admintools_wafexceptions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jba8l_admintools_waftemplates`
--
ALTER TABLE `jba8l_admintools_waftemplates`
  ADD PRIMARY KEY (`admintools_waftemplate_id`),
  ADD UNIQUE KEY `jba8l_admintools_waftemplate_keylang` (`reason`(100),`language`);

--
-- Indexes for table `jba8l_akeeba_common`
--
ALTER TABLE `jba8l_akeeba_common`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `jba8l_ak_profiles`
--
ALTER TABLE `jba8l_ak_profiles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jba8l_ak_stats`
--
ALTER TABLE `jba8l_ak_stats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_fullstatus` (`filesexist`,`status`),
  ADD KEY `idx_stale` (`status`,`origin`);

--
-- Indexes for table `jba8l_ak_storage`
--
ALTER TABLE `jba8l_ak_storage`
  ADD PRIMARY KEY (`tag`(100));

--
-- Indexes for table `jba8l_ampz`
--
ALTER TABLE `jba8l_ampz`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jba8l_ampz_stats`
--
ALTER TABLE `jba8l_ampz_stats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jba8l_assets`
--
ALTER TABLE `jba8l_assets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_asset_name` (`name`),
  ADD KEY `idx_lft_rgt` (`lft`,`rgt`),
  ADD KEY `idx_parent_id` (`parent_id`);

--
-- Indexes for table `jba8l_associations`
--
ALTER TABLE `jba8l_associations`
  ADD PRIMARY KEY (`context`,`id`),
  ADD KEY `idx_key` (`key`);

--
-- Indexes for table `jba8l_banners`
--
ALTER TABLE `jba8l_banners`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_state` (`state`),
  ADD KEY `idx_own_prefix` (`own_prefix`),
  ADD KEY `idx_banner_catid` (`catid`),
  ADD KEY `idx_language` (`language`),
  ADD KEY `idx_metakey_prefix` (`metakey_prefix`(100));

--
-- Indexes for table `jba8l_banner_clients`
--
ALTER TABLE `jba8l_banner_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_own_prefix` (`own_prefix`),
  ADD KEY `idx_metakey_prefix` (`metakey_prefix`(100));

--
-- Indexes for table `jba8l_banner_tracks`
--
ALTER TABLE `jba8l_banner_tracks`
  ADD PRIMARY KEY (`track_date`,`track_type`,`banner_id`),
  ADD KEY `idx_track_date` (`track_date`),
  ADD KEY `idx_track_type` (`track_type`),
  ADD KEY `idx_banner_id` (`banner_id`);

--
-- Indexes for table `jba8l_categories`
--
ALTER TABLE `jba8l_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cat_idx` (`extension`,`published`,`access`),
  ADD KEY `idx_access` (`access`),
  ADD KEY `idx_checkout` (`checked_out`),
  ADD KEY `idx_left_right` (`lft`,`rgt`),
  ADD KEY `idx_language` (`language`),
  ADD KEY `idx_path` (`path`(100)),
  ADD KEY `idx_alias` (`alias`(100));

--
-- Indexes for table `jba8l_coalaweb_common`
--
ALTER TABLE `jba8l_coalaweb_common`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `jba8l_contact_details`
--
ALTER TABLE `jba8l_contact_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_access` (`access`),
  ADD KEY `idx_checkout` (`checked_out`),
  ADD KEY `idx_state` (`published`),
  ADD KEY `idx_catid` (`catid`),
  ADD KEY `idx_createdby` (`created_by`),
  ADD KEY `idx_featured_catid` (`featured`,`catid`),
  ADD KEY `idx_language` (`language`),
  ADD KEY `idx_xreference` (`xreference`);

--
-- Indexes for table `jba8l_content`
--
ALTER TABLE `jba8l_content`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_access` (`access`),
  ADD KEY `idx_checkout` (`checked_out`),
  ADD KEY `idx_state` (`state`),
  ADD KEY `idx_catid` (`catid`),
  ADD KEY `idx_createdby` (`created_by`),
  ADD KEY `idx_featured_catid` (`featured`,`catid`),
  ADD KEY `idx_language` (`language`),
  ADD KEY `idx_xreference` (`xreference`),
  ADD KEY `idx_alias` (`alias`(191));

--
-- Indexes for table `jba8l_contentitem_tag_map`
--
ALTER TABLE `jba8l_contentitem_tag_map`
  ADD UNIQUE KEY `uc_ItemnameTagid` (`type_id`,`content_item_id`,`tag_id`),
  ADD KEY `idx_tag_type` (`tag_id`,`type_id`),
  ADD KEY `idx_date_id` (`tag_date`,`tag_id`),
  ADD KEY `idx_core_content_id` (`core_content_id`);

--
-- Indexes for table `jba8l_content_frontpage`
--
ALTER TABLE `jba8l_content_frontpage`
  ADD PRIMARY KEY (`content_id`);

--
-- Indexes for table `jba8l_content_rating`
--
ALTER TABLE `jba8l_content_rating`
  ADD PRIMARY KEY (`content_id`);

--
-- Indexes for table `jba8l_content_types`
--
ALTER TABLE `jba8l_content_types`
  ADD PRIMARY KEY (`type_id`),
  ADD KEY `idx_alias` (`type_alias`(100));

--
-- Indexes for table `jba8l_cwgears`
--
ALTER TABLE `jba8l_cwgears`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jba8l_cwgears_schedule`
--
ALTER TABLE `jba8l_cwgears_schedule`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jba8l_cwtraffic`
--
ALTER TABLE `jba8l_cwtraffic`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_tm_ip` (`tm`,`ip`),
  ADD UNIQUE KEY `unique_tm_iphash` (`tm`,`iphash`),
  ADD KEY `idx_ip` (`ip`),
  ADD KEY `idx_iphash` (`iphash`),
  ADD KEY `idx_tm` (`tm`),
  ADD KEY `idx_iptm` (`ip`,`tm`),
  ADD KEY `idx_iphashtm` (`iphash`,`tm`);

--
-- Indexes for table `jba8l_cwtraffic_knownips`
--
ALTER TABLE `jba8l_cwtraffic_knownips`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_checkout` (`checked_out`),
  ADD KEY `idx_state` (`state`),
  ADD KEY `idx_catid` (`catid`),
  ADD KEY `idx_createdby` (`created_by`);

--
-- Indexes for table `jba8l_cwtraffic_locations`
--
ALTER TABLE `jba8l_cwtraffic_locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jba8l_cwtraffic_storage`
--
ALTER TABLE `jba8l_cwtraffic_storage`
  ADD PRIMARY KEY (`tag`(100));

--
-- Indexes for table `jba8l_cwtraffic_whoisonline`
--
ALTER TABLE `jba8l_cwtraffic_whoisonline`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ip` (`ip`),
  ADD UNIQUE KEY `unique_dt_ip` (`dt`,`ip`),
  ADD UNIQUE KEY `unique_dt_iphash` (`dt`,`iphash`),
  ADD KEY `countrycode` (`country_code`),
  ADD KEY `idx_ip` (`ip`),
  ADD KEY `idx_iphash` (`iphash`),
  ADD KEY `idx_dt` (`dt`),
  ADD KEY `idx_ipdt` (`ip`,`dt`),
  ADD KEY `idx_iphashdt` (`iphash`,`dt`);

--
-- Indexes for table `jba8l_djimageslider`
--
ALTER TABLE `jba8l_djimageslider`
  ADD PRIMARY KEY (`id`),
  ADD KEY `catid` (`catid`,`published`);

--
-- Indexes for table `jba8l_dpcalendar_bookings`
--
ALTER TABLE `jba8l_dpcalendar_bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uid` (`uid`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `state` (`state`);

--
-- Indexes for table `jba8l_dpcalendar_caldav_calendarchanges`
--
ALTER TABLE `jba8l_dpcalendar_caldav_calendarchanges`
  ADD PRIMARY KEY (`id`),
  ADD KEY `calendarid_synctoken` (`calendarid`,`synctoken`);

--
-- Indexes for table `jba8l_dpcalendar_caldav_calendarinstances`
--
ALTER TABLE `jba8l_dpcalendar_caldav_calendarinstances`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `principaluri` (`principaluri`,`uri`),
  ADD UNIQUE KEY `calendarid` (`calendarid`,`principaluri`),
  ADD UNIQUE KEY `calendarid_2` (`calendarid`,`share_href`);

--
-- Indexes for table `jba8l_dpcalendar_caldav_calendarobjects`
--
ALTER TABLE `jba8l_dpcalendar_caldav_calendarobjects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `calendarid` (`calendarid`,`uri`),
  ADD KEY `calendarid_time` (`calendarid`,`firstoccurence`);

--
-- Indexes for table `jba8l_dpcalendar_caldav_calendars`
--
ALTER TABLE `jba8l_dpcalendar_caldav_calendars`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jba8l_dpcalendar_caldav_calendarsubscriptions`
--
ALTER TABLE `jba8l_dpcalendar_caldav_calendarsubscriptions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `principaluri` (`principaluri`,`uri`);

--
-- Indexes for table `jba8l_dpcalendar_caldav_groupmembers`
--
ALTER TABLE `jba8l_dpcalendar_caldav_groupmembers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `principal_id` (`principal_id`,`member_id`);

--
-- Indexes for table `jba8l_dpcalendar_caldav_principals`
--
ALTER TABLE `jba8l_dpcalendar_caldav_principals`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uri` (`uri`);

--
-- Indexes for table `jba8l_dpcalendar_caldav_propertystorage`
--
ALTER TABLE `jba8l_dpcalendar_caldav_propertystorage`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `path_property` (`path`(600),`name`);

--
-- Indexes for table `jba8l_dpcalendar_caldav_schedulingobjects`
--
ALTER TABLE `jba8l_dpcalendar_caldav_schedulingobjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jba8l_dpcalendar_events`
--
ALTER TABLE `jba8l_dpcalendar_events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_access` (`access`),
  ADD KEY `idx_start_date` (`start_date`),
  ADD KEY `idx_end_date` (`end_date`),
  ADD KEY `idx_checkout` (`checked_out`),
  ADD KEY `idx_state` (`state`),
  ADD KEY `idx_catid` (`catid`),
  ADD KEY `idx_createdby` (`created_by`),
  ADD KEY `idx_featured_catid` (`featured`,`catid`),
  ADD KEY `idx_language` (`language`),
  ADD KEY `idx_xreference` (`xreference`);

--
-- Indexes for table `jba8l_dpcalendar_events_location`
--
ALTER TABLE `jba8l_dpcalendar_events_location`
  ADD PRIMARY KEY (`event_id`,`location_id`);

--
-- Indexes for table `jba8l_dpcalendar_extcalendars`
--
ALTER TABLE `jba8l_dpcalendar_extcalendars`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_plugin` (`plugin`),
  ADD KEY `idx_state` (`state`),
  ADD KEY `idx_createdby` (`created_by`),
  ADD KEY `idx_language` (`language`);

--
-- Indexes for table `jba8l_dpcalendar_locations`
--
ALTER TABLE `jba8l_dpcalendar_locations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_checkout` (`checked_out`),
  ADD KEY `idx_state` (`state`),
  ADD KEY `idx_createdby` (`created_by`),
  ADD KEY `idx_language` (`language`);

--
-- Indexes for table `jba8l_dpcalendar_tickets`
--
ALTER TABLE `jba8l_dpcalendar_tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uid` (`uid`),
  ADD KEY `booking_id` (`booking_id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `state` (`state`),
  ADD KEY `notify` (`reminder_sent_date`,`state`);

--
-- Indexes for table `jba8l_extensions`
--
ALTER TABLE `jba8l_extensions`
  ADD PRIMARY KEY (`extension_id`),
  ADD KEY `element_clientid` (`element`,`client_id`),
  ADD KEY `element_folder_clientid` (`element`,`folder`,`client_id`),
  ADD KEY `extension` (`type`,`element`,`folder`,`client_id`);

--
-- Indexes for table `jba8l_falang_content`
--
ALTER TABLE `jba8l_falang_content`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idxFalang1` (`reference_id`,`reference_field`,`reference_table`),
  ADD KEY `falangContent` (`language_id`,`reference_id`,`reference_table`),
  ADD KEY `falangContentLanguage` (`reference_id`,`reference_field`,`reference_table`,`language_id`),
  ADD KEY `reference_id` (`reference_id`),
  ADD KEY `language_id` (`language_id`),
  ADD KEY `reference_table` (`reference_table`),
  ADD KEY `reference_field` (`reference_field`);

--
-- Indexes for table `jba8l_falang_tableinfo`
--
ALTER TABLE `jba8l_falang_tableinfo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jba8l_fields`
--
ALTER TABLE `jba8l_fields`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_checkout` (`checked_out`),
  ADD KEY `idx_state` (`state`),
  ADD KEY `idx_created_user_id` (`created_user_id`),
  ADD KEY `idx_access` (`access`),
  ADD KEY `idx_language` (`language`),
  ADD KEY `idx_context` (`context`(191));

--
-- Indexes for table `jba8l_fields_categories`
--
ALTER TABLE `jba8l_fields_categories`
  ADD PRIMARY KEY (`field_id`,`category_id`);

--
-- Indexes for table `jba8l_fields_groups`
--
ALTER TABLE `jba8l_fields_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_checkout` (`checked_out`),
  ADD KEY `idx_state` (`state`),
  ADD KEY `idx_created_by` (`created_by`),
  ADD KEY `idx_access` (`access`),
  ADD KEY `idx_language` (`language`),
  ADD KEY `idx_context` (`context`(191));

--
-- Indexes for table `jba8l_fields_values`
--
ALTER TABLE `jba8l_fields_values`
  ADD KEY `idx_field_id` (`field_id`),
  ADD KEY `idx_item_id` (`item_id`(191));

--
-- Indexes for table `jba8l_files_containers`
--
ALTER TABLE `jba8l_files_containers`
  ADD PRIMARY KEY (`files_container_id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `jba8l_files_mimetypes`
--
ALTER TABLE `jba8l_files_mimetypes`
  ADD PRIMARY KEY (`mimetype`,`extension`);

--
-- Indexes for table `jba8l_finder_filters`
--
ALTER TABLE `jba8l_finder_filters`
  ADD PRIMARY KEY (`filter_id`);

--
-- Indexes for table `jba8l_finder_links`
--
ALTER TABLE `jba8l_finder_links`
  ADD PRIMARY KEY (`link_id`),
  ADD KEY `idx_type` (`type_id`),
  ADD KEY `idx_md5` (`md5sum`),
  ADD KEY `idx_url` (`url`(75)),
  ADD KEY `idx_published_list` (`published`,`state`,`access`,`publish_start_date`,`publish_end_date`,`list_price`),
  ADD KEY `idx_published_sale` (`published`,`state`,`access`,`publish_start_date`,`publish_end_date`,`sale_price`),
  ADD KEY `idx_title` (`title`(100));

--
-- Indexes for table `jba8l_finder_links_terms0`
--
ALTER TABLE `jba8l_finder_links_terms0`
  ADD PRIMARY KEY (`link_id`,`term_id`),
  ADD KEY `idx_term_weight` (`term_id`,`weight`),
  ADD KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`);

--
-- Indexes for table `jba8l_finder_links_terms1`
--
ALTER TABLE `jba8l_finder_links_terms1`
  ADD PRIMARY KEY (`link_id`,`term_id`),
  ADD KEY `idx_term_weight` (`term_id`,`weight`),
  ADD KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`);

--
-- Indexes for table `jba8l_finder_links_terms2`
--
ALTER TABLE `jba8l_finder_links_terms2`
  ADD PRIMARY KEY (`link_id`,`term_id`),
  ADD KEY `idx_term_weight` (`term_id`,`weight`),
  ADD KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`);

--
-- Indexes for table `jba8l_finder_links_terms3`
--
ALTER TABLE `jba8l_finder_links_terms3`
  ADD PRIMARY KEY (`link_id`,`term_id`),
  ADD KEY `idx_term_weight` (`term_id`,`weight`),
  ADD KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`);

--
-- Indexes for table `jba8l_finder_links_terms4`
--
ALTER TABLE `jba8l_finder_links_terms4`
  ADD PRIMARY KEY (`link_id`,`term_id`),
  ADD KEY `idx_term_weight` (`term_id`,`weight`),
  ADD KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`);

--
-- Indexes for table `jba8l_finder_links_terms5`
--
ALTER TABLE `jba8l_finder_links_terms5`
  ADD PRIMARY KEY (`link_id`,`term_id`),
  ADD KEY `idx_term_weight` (`term_id`,`weight`),
  ADD KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`);

--
-- Indexes for table `jba8l_finder_links_terms6`
--
ALTER TABLE `jba8l_finder_links_terms6`
  ADD PRIMARY KEY (`link_id`,`term_id`),
  ADD KEY `idx_term_weight` (`term_id`,`weight`),
  ADD KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`);

--
-- Indexes for table `jba8l_finder_links_terms7`
--
ALTER TABLE `jba8l_finder_links_terms7`
  ADD PRIMARY KEY (`link_id`,`term_id`),
  ADD KEY `idx_term_weight` (`term_id`,`weight`),
  ADD KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`);

--
-- Indexes for table `jba8l_finder_links_terms8`
--
ALTER TABLE `jba8l_finder_links_terms8`
  ADD PRIMARY KEY (`link_id`,`term_id`),
  ADD KEY `idx_term_weight` (`term_id`,`weight`),
  ADD KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`);

--
-- Indexes for table `jba8l_finder_links_terms9`
--
ALTER TABLE `jba8l_finder_links_terms9`
  ADD PRIMARY KEY (`link_id`,`term_id`),
  ADD KEY `idx_term_weight` (`term_id`,`weight`),
  ADD KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`);

--
-- Indexes for table `jba8l_finder_links_termsa`
--
ALTER TABLE `jba8l_finder_links_termsa`
  ADD PRIMARY KEY (`link_id`,`term_id`),
  ADD KEY `idx_term_weight` (`term_id`,`weight`),
  ADD KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`);

--
-- Indexes for table `jba8l_finder_links_termsb`
--
ALTER TABLE `jba8l_finder_links_termsb`
  ADD PRIMARY KEY (`link_id`,`term_id`),
  ADD KEY `idx_term_weight` (`term_id`,`weight`),
  ADD KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`);

--
-- Indexes for table `jba8l_finder_links_termsc`
--
ALTER TABLE `jba8l_finder_links_termsc`
  ADD PRIMARY KEY (`link_id`,`term_id`),
  ADD KEY `idx_term_weight` (`term_id`,`weight`),
  ADD KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`);

--
-- Indexes for table `jba8l_finder_links_termsd`
--
ALTER TABLE `jba8l_finder_links_termsd`
  ADD PRIMARY KEY (`link_id`,`term_id`),
  ADD KEY `idx_term_weight` (`term_id`,`weight`),
  ADD KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`);

--
-- Indexes for table `jba8l_finder_links_termse`
--
ALTER TABLE `jba8l_finder_links_termse`
  ADD PRIMARY KEY (`link_id`,`term_id`),
  ADD KEY `idx_term_weight` (`term_id`,`weight`),
  ADD KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`);

--
-- Indexes for table `jba8l_finder_links_termsf`
--
ALTER TABLE `jba8l_finder_links_termsf`
  ADD PRIMARY KEY (`link_id`,`term_id`),
  ADD KEY `idx_term_weight` (`term_id`,`weight`),
  ADD KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`);

--
-- Indexes for table `jba8l_finder_taxonomy`
--
ALTER TABLE `jba8l_finder_taxonomy`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_id` (`parent_id`),
  ADD KEY `state` (`state`),
  ADD KEY `ordering` (`ordering`),
  ADD KEY `access` (`access`),
  ADD KEY `idx_parent_published` (`parent_id`,`state`,`access`);

--
-- Indexes for table `jba8l_finder_taxonomy_map`
--
ALTER TABLE `jba8l_finder_taxonomy_map`
  ADD PRIMARY KEY (`link_id`,`node_id`),
  ADD KEY `link_id` (`link_id`),
  ADD KEY `node_id` (`node_id`);

--
-- Indexes for table `jba8l_finder_terms`
--
ALTER TABLE `jba8l_finder_terms`
  ADD PRIMARY KEY (`term_id`),
  ADD UNIQUE KEY `idx_term` (`term`),
  ADD KEY `idx_term_phrase` (`term`,`phrase`),
  ADD KEY `idx_stem_phrase` (`stem`,`phrase`),
  ADD KEY `idx_soundex_phrase` (`soundex`,`phrase`);

--
-- Indexes for table `jba8l_finder_terms_common`
--
ALTER TABLE `jba8l_finder_terms_common`
  ADD KEY `idx_word_lang` (`term`,`language`),
  ADD KEY `idx_lang` (`language`);

--
-- Indexes for table `jba8l_finder_tokens`
--
ALTER TABLE `jba8l_finder_tokens`
  ADD KEY `idx_word` (`term`),
  ADD KEY `idx_context` (`context`);

--
-- Indexes for table `jba8l_finder_tokens_aggregate`
--
ALTER TABLE `jba8l_finder_tokens_aggregate`
  ADD KEY `token` (`term`),
  ADD KEY `keyword_id` (`term_id`);

--
-- Indexes for table `jba8l_finder_types`
--
ALTER TABLE `jba8l_finder_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title` (`title`);

--
-- Indexes for table `jba8l_flexicontent_advsearch_index`
--
ALTER TABLE `jba8l_flexicontent_advsearch_index`
  ADD PRIMARY KEY (`field_id`,`item_id`,`extraid`),
  ADD KEY `sid` (`sid`),
  ADD KEY `field_id` (`field_id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `value_id` (`value_id`);
ALTER TABLE `jba8l_flexicontent_advsearch_index` ADD FULLTEXT KEY `search_index` (`search_index`);

--
-- Indexes for table `jba8l_flexicontent_advsearch_index_field_2`
--
ALTER TABLE `jba8l_flexicontent_advsearch_index_field_2`
  ADD PRIMARY KEY (`field_id`,`item_id`,`extraid`),
  ADD KEY `sid` (`sid`),
  ADD KEY `field_id` (`field_id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `value_id` (`value_id`);
ALTER TABLE `jba8l_flexicontent_advsearch_index_field_2` ADD FULLTEXT KEY `search_index` (`search_index`);

--
-- Indexes for table `jba8l_flexicontent_advsearch_index_field_117`
--
ALTER TABLE `jba8l_flexicontent_advsearch_index_field_117`
  ADD PRIMARY KEY (`field_id`,`item_id`,`extraid`),
  ADD KEY `sid` (`sid`),
  ADD KEY `field_id` (`field_id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `value_id` (`value_id`);
ALTER TABLE `jba8l_flexicontent_advsearch_index_field_117` ADD FULLTEXT KEY `search_index` (`search_index`);

--
-- Indexes for table `jba8l_flexicontent_authors_ext`
--
ALTER TABLE `jba8l_flexicontent_authors_ext`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `jba8l_flexicontent_cats_item_relations`
--
ALTER TABLE `jba8l_flexicontent_cats_item_relations`
  ADD PRIMARY KEY (`catid`,`itemid`),
  ADD KEY `catid` (`catid`),
  ADD KEY `itemid` (`itemid`);

--
-- Indexes for table `jba8l_flexicontent_download_coupons`
--
ALTER TABLE `jba8l_flexicontent_download_coupons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `file_id` (`file_id`),
  ADD KEY `token` (`token`),
  ADD KEY `expire_on` (`expire_on`);

--
-- Indexes for table `jba8l_flexicontent_download_history`
--
ALTER TABLE `jba8l_flexicontent_download_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `file_id` (`file_id`);

--
-- Indexes for table `jba8l_flexicontent_edit_coupons`
--
ALTER TABLE `jba8l_flexicontent_edit_coupons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jba8l_flexicontent_favourites`
--
ALTER TABLE `jba8l_flexicontent_favourites`
  ADD PRIMARY KEY (`id`,`itemid`,`userid`,`type`),
  ADD KEY `id` (`id`),
  ADD KEY `itemid` (`itemid`),
  ADD KEY `userid` (`userid`),
  ADD KEY `type` (`type`);

--
-- Indexes for table `jba8l_flexicontent_fields`
--
ALTER TABLE `jba8l_flexicontent_fields`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jba8l_flexicontent_fields_item_relations`
--
ALTER TABLE `jba8l_flexicontent_fields_item_relations`
  ADD PRIMARY KEY (`field_id`,`item_id`,`valueorder`,`suborder`),
  ADD KEY `field_id` (`field_id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `valueorder` (`valueorder`),
  ADD KEY `value` (`value`(32)),
  ADD KEY `value_integer` (`value_integer`),
  ADD KEY `value_decimal` (`value_decimal`),
  ADD KEY `value_datetime` (`value_datetime`);

--
-- Indexes for table `jba8l_flexicontent_fields_type_relations`
--
ALTER TABLE `jba8l_flexicontent_fields_type_relations`
  ADD PRIMARY KEY (`field_id`,`type_id`),
  ADD KEY `field_id` (`field_id`),
  ADD KEY `type_id` (`type_id`);

--
-- Indexes for table `jba8l_flexicontent_files`
--
ALTER TABLE `jba8l_flexicontent_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jba8l_flexicontent_items_ext`
--
ALTER TABLE `jba8l_flexicontent_items_ext`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `lang_parent_id` (`lang_parent_id`),
  ADD KEY `type_id` (`type_id`);
ALTER TABLE `jba8l_flexicontent_items_ext` ADD FULLTEXT KEY `search_index` (`search_index`);

--
-- Indexes for table `jba8l_flexicontent_items_extravote`
--
ALTER TABLE `jba8l_flexicontent_items_extravote`
  ADD PRIMARY KEY (`content_id`,`field_id`),
  ADD KEY `extravote_idx` (`content_id`);

--
-- Indexes for table `jba8l_flexicontent_items_tmp`
--
ALTER TABLE `jba8l_flexicontent_items_tmp`
  ADD PRIMARY KEY (`id`),
  ADD KEY `alias` (`alias`(64)),
  ADD KEY `state` (`state`),
  ADD KEY `catid` (`catid`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `access` (`access`),
  ADD KEY `language` (`language`),
  ADD KEY `featured` (`featured`),
  ADD KEY `type_id` (`type_id`),
  ADD KEY `lang_parent_id` (`lang_parent_id`);
ALTER TABLE `jba8l_flexicontent_items_tmp` ADD FULLTEXT KEY `title` (`title`);

--
-- Indexes for table `jba8l_flexicontent_items_versions`
--
ALTER TABLE `jba8l_flexicontent_items_versions`
  ADD PRIMARY KEY (`version`,`field_id`,`item_id`,`valueorder`,`suborder`),
  ADD KEY `version` (`version`),
  ADD KEY `field_id` (`field_id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `valueorder` (`valueorder`);
ALTER TABLE `jba8l_flexicontent_items_versions` ADD FULLTEXT KEY `value` (`value`);

--
-- Indexes for table `jba8l_flexicontent_layouts_conf`
--
ALTER TABLE `jba8l_flexicontent_layouts_conf`
  ADD PRIMARY KEY (`template`,`cfgname`,`layout`);

--
-- Indexes for table `jba8l_flexicontent_reviews`
--
ALTER TABLE `jba8l_flexicontent_reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `content_id` (`content_id`,`user_id`,`type`),
  ADD KEY `content_id_2` (`content_id`,`type`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `jba8l_flexicontent_tags`
--
ALTER TABLE `jba8l_flexicontent_tags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`),
  ADD KEY `alias` (`alias`),
  ADD KEY `published` (`published`),
  ADD KEY `jtag_id` (`jtag_id`);

--
-- Indexes for table `jba8l_flexicontent_tags_item_relations`
--
ALTER TABLE `jba8l_flexicontent_tags_item_relations`
  ADD PRIMARY KEY (`tid`,`itemid`),
  ADD KEY `tid` (`tid`),
  ADD KEY `itemid` (`itemid`);

--
-- Indexes for table `jba8l_flexicontent_templates`
--
ALTER TABLE `jba8l_flexicontent_templates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `configuration` (`template`,`cfgname`,`layout`,`position`);

--
-- Indexes for table `jba8l_flexicontent_types`
--
ALTER TABLE `jba8l_flexicontent_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`),
  ADD KEY `alias` (`alias`),
  ADD KEY `published` (`published`),
  ADD KEY `access` (`access`);

--
-- Indexes for table `jba8l_flexicontent_versions`
--
ALTER TABLE `jba8l_flexicontent_versions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `version2item` (`item_id`,`version_id`);

--
-- Indexes for table `jba8l_j2xml_websites`
--
ALTER TABLE `jba8l_j2xml_websites`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jba8l_jevents_catmap`
--
ALTER TABLE `jba8l_jevents_catmap`
  ADD UNIQUE KEY `key_event_category` (`evid`,`catid`),
  ADD KEY `key_evid` (`evid`);

--
-- Indexes for table `jba8l_jevents_exception`
--
ALTER TABLE `jba8l_jevents_exception`
  ADD PRIMARY KEY (`ex_id`),
  ADD KEY `eventid` (`eventid`),
  ADD KEY `rp_id` (`rp_id`);

--
-- Indexes for table `jba8l_jevents_filtermap`
--
ALTER TABLE `jba8l_jevents_filtermap`
  ADD PRIMARY KEY (`fid`),
  ADD KEY `md5` (`md5`);

--
-- Indexes for table `jba8l_jevents_icsfile`
--
ALTER TABLE `jba8l_jevents_icsfile`
  ADD PRIMARY KEY (`ics_id`),
  ADD UNIQUE KEY `label` (`label`),
  ADD KEY `stateidx` (`state`);

--
-- Indexes for table `jba8l_jevents_repetition`
--
ALTER TABLE `jba8l_jevents_repetition`
  ADD PRIMARY KEY (`rp_id`),
  ADD UNIQUE KEY `duplicatecheck` (`duplicatecheck`),
  ADD KEY `eventid` (`eventid`),
  ADD KEY `eventstart` (`eventid`,`startrepeat`),
  ADD KEY `eventend` (`eventid`,`endrepeat`),
  ADD KEY `eventdetail` (`eventdetail_id`),
  ADD KEY `startrepeat` (`startrepeat`),
  ADD KEY `startend` (`startrepeat`,`endrepeat`),
  ADD KEY `endrepeat` (`endrepeat`);

--
-- Indexes for table `jba8l_jevents_rrule`
--
ALTER TABLE `jba8l_jevents_rrule`
  ADD PRIMARY KEY (`rr_id`),
  ADD KEY `eventid` (`eventid`);

--
-- Indexes for table `jba8l_jevents_translation`
--
ALTER TABLE `jba8l_jevents_translation`
  ADD PRIMARY KEY (`translation_id`),
  ADD KEY `evdet_id` (`evdet_id`),
  ADD KEY `langdetail` (`evdet_id`,`language`);

--
-- Indexes for table `jba8l_jevents_vevdetail`
--
ALTER TABLE `jba8l_jevents_vevdetail`
  ADD PRIMARY KEY (`evdet_id`),
  ADD KEY `location` (`location`),
  ADD KEY `loc_id` (`loc_id`),
  ADD KEY `multiday` (`multiday`);

--
-- Indexes for table `jba8l_jevents_vevent`
--
ALTER TABLE `jba8l_jevents_vevent`
  ADD PRIMARY KEY (`ev_id`),
  ADD KEY `icsid` (`icsid`),
  ADD KEY `stateidx` (`state`),
  ADD KEY `evaccess` (`access`);

--
-- Indexes for table `jba8l_jev_defaults`
--
ALTER TABLE `jba8l_jev_defaults`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`),
  ADD KEY `langcodename` (`language`,`catid`,`name`);

--
-- Indexes for table `jba8l_jev_users`
--
ALTER TABLE `jba8l_jev_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user` (`user_id`);

--
-- Indexes for table `jba8l_jmap`
--
ALTER TABLE `jba8l_jmap`
  ADD PRIMARY KEY (`id`),
  ADD KEY `published` (`published`);

--
-- Indexes for table `jba8l_jmap_canonicals`
--
ALTER TABLE `jba8l_jmap_canonicals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jba8l_jmap_cats_priorities`
--
ALTER TABLE `jba8l_jmap_cats_priorities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jba8l_jmap_datasets`
--
ALTER TABLE `jba8l_jmap_datasets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `published` (`published`);

--
-- Indexes for table `jba8l_jmap_dss_relations`
--
ALTER TABLE `jba8l_jmap_dss_relations`
  ADD PRIMARY KEY (`datasetid`,`datasourceid`);

--
-- Indexes for table `jba8l_jmap_headings`
--
ALTER TABLE `jba8l_jmap_headings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jba8l_jmap_menu_priorities`
--
ALTER TABLE `jba8l_jmap_menu_priorities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jba8l_jmap_metainfo`
--
ALTER TABLE `jba8l_jmap_metainfo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `robots` (`robots`),
  ADD KEY `published` (`published`);

--
-- Indexes for table `jba8l_jmap_pingomatic`
--
ALTER TABLE `jba8l_jmap_pingomatic`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jba8l_languages`
--
ALTER TABLE `jba8l_languages`
  ADD PRIMARY KEY (`lang_id`),
  ADD UNIQUE KEY `idx_sef` (`sef`),
  ADD UNIQUE KEY `idx_langcode` (`lang_code`),
  ADD KEY `idx_access` (`access`),
  ADD KEY `idx_ordering` (`ordering`);

--
-- Indexes for table `jba8l_logman_activities`
--
ALTER TABLE `jba8l_logman_activities`
  ADD PRIMARY KEY (`logman_activity_id`),
  ADD UNIQUE KEY `uuid` (`uuid`),
  ADD KEY `package` (`package`),
  ADD KEY `name` (`name`),
  ADD KEY `ip` (`ip`);

--
-- Indexes for table `jba8l_logman_activities_impressions`
--
ALTER TABLE `jba8l_logman_activities_impressions`
  ADD PRIMARY KEY (`logman_activity_id`,`logman_impression_id`),
  ADD KEY `logman_impression_id` (`logman_impression_id`);

--
-- Indexes for table `jba8l_logman_impressions`
--
ALTER TABLE `jba8l_logman_impressions`
  ADD PRIMARY KEY (`logman_impression_id`),
  ADD KEY `idx:name-package` (`name`,`package`),
  ADD KEY `idx:session_hash` (`session_hash`),
  ADD KEY `idx:internal` (`internal`);

--
-- Indexes for table `jba8l_logman_routes`
--
ALTER TABLE `jba8l_logman_routes`
  ADD PRIMARY KEY (`logman_route_id`);

--
-- Indexes for table `jba8l_logman_synchronization`
--
ALTER TABLE `jba8l_logman_synchronization`
  ADD UNIQUE KEY `uuid` (`uuid`);

--
-- Indexes for table `jba8l_menu`
--
ALTER TABLE `jba8l_menu`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_client_id_parent_id_alias_language` (`client_id`,`parent_id`,`alias`(100),`language`),
  ADD KEY `idx_componentid` (`component_id`,`menutype`,`published`,`access`),
  ADD KEY `idx_menutype` (`menutype`),
  ADD KEY `idx_left_right` (`lft`,`rgt`),
  ADD KEY `idx_language` (`language`),
  ADD KEY `idx_alias` (`alias`(100)),
  ADD KEY `idx_path` (`path`(100));

--
-- Indexes for table `jba8l_menu_types`
--
ALTER TABLE `jba8l_menu_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_menutype` (`menutype`);

--
-- Indexes for table `jba8l_messages`
--
ALTER TABLE `jba8l_messages`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `useridto_state` (`user_id_to`,`state`);

--
-- Indexes for table `jba8l_messages_cfg`
--
ALTER TABLE `jba8l_messages_cfg`
  ADD UNIQUE KEY `idx_user_var_name` (`user_id`,`cfg_name`);

--
-- Indexes for table `jba8l_modules`
--
ALTER TABLE `jba8l_modules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `published` (`published`,`access`),
  ADD KEY `newsfeeds` (`module`,`published`),
  ADD KEY `idx_language` (`language`);

--
-- Indexes for table `jba8l_modules_menu`
--
ALTER TABLE `jba8l_modules_menu`
  ADD PRIMARY KEY (`moduleid`,`menuid`);

--
-- Indexes for table `jba8l_newsfeeds`
--
ALTER TABLE `jba8l_newsfeeds`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_access` (`access`),
  ADD KEY `idx_checkout` (`checked_out`),
  ADD KEY `idx_state` (`published`),
  ADD KEY `idx_catid` (`catid`),
  ADD KEY `idx_createdby` (`created_by`),
  ADD KEY `idx_language` (`language`),
  ADD KEY `idx_xreference` (`xreference`);

--
-- Indexes for table `jba8l_overrider`
--
ALTER TABLE `jba8l_overrider`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jba8l_pagebuilderck_elements`
--
ALTER TABLE `jba8l_pagebuilderck_elements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jba8l_pagebuilderck_pages`
--
ALTER TABLE `jba8l_pagebuilderck_pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jba8l_plg_system_cookiespolicynotificationbar_logs`
--
ALTER TABLE `jba8l_plg_system_cookiespolicynotificationbar_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jba8l_postinstall_messages`
--
ALTER TABLE `jba8l_postinstall_messages`
  ADD PRIMARY KEY (`postinstall_message_id`);

--
-- Indexes for table `jba8l_privacy_consents`
--
ALTER TABLE `jba8l_privacy_consents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_id` (`user_id`);

--
-- Indexes for table `jba8l_privacy_requests`
--
ALTER TABLE `jba8l_privacy_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jba8l_quix`
--
ALTER TABLE `jba8l_quix`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_access` (`access`),
  ADD KEY `idx_catid` (`catid`),
  ADD KEY `idx_state` (`state`),
  ADD KEY `idx_createdby` (`created_by`),
  ADD KEY `idx_xreference` (`xreference`);

--
-- Indexes for table `jba8l_quix_collections`
--
ALTER TABLE `jba8l_quix_collections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_access` (`access`),
  ADD KEY `idx_catid` (`catid`),
  ADD KEY `idx_state` (`state`),
  ADD KEY `idx_createdby` (`created_by`),
  ADD KEY `idx_xreference` (`xreference`);

--
-- Indexes for table `jba8l_quix_collection_map`
--
ALTER TABLE `jba8l_quix_collection_map`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jba8l_quix_conditions`
--
ALTER TABLE `jba8l_quix_conditions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jba8l_quix_editor_map`
--
ALTER TABLE `jba8l_quix_editor_map`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jba8l_quix_elements`
--
ALTER TABLE `jba8l_quix_elements`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `alias` (`alias`);

--
-- Indexes for table `jba8l_quix_imgstats`
--
ALTER TABLE `jba8l_quix_imgstats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jba8l_redirect_links`
--
ALTER TABLE `jba8l_redirect_links`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_link_modifed` (`modified_date`),
  ADD KEY `idx_old_url` (`old_url`(100));

--
-- Indexes for table `jba8l_rokcommon_configs`
--
ALTER TABLE `jba8l_rokcommon_configs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jba8l_roksprocket_items`
--
ALTER TABLE `jba8l_roksprocket_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_module` (`module_id`),
  ADD KEY `idx_module_order` (`module_id`,`order`);

--
-- Indexes for table `jba8l_rsfirewall_configuration`
--
ALTER TABLE `jba8l_rsfirewall_configuration`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `jba8l_rsfirewall_exceptions`
--
ALTER TABLE `jba8l_rsfirewall_exceptions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jba8l_rsfirewall_hashes`
--
ALTER TABLE `jba8l_rsfirewall_hashes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jba8l_rsfirewall_lists`
--
ALTER TABLE `jba8l_rsfirewall_lists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `published` (`published`),
  ADD KEY `type` (`type`),
  ADD KEY `ip` (`ip`);

--
-- Indexes for table `jba8l_rsfirewall_logs`
--
ALTER TABLE `jba8l_rsfirewall_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ip` (`ip`);

--
-- Indexes for table `jba8l_rsfirewall_offenders`
--
ALTER TABLE `jba8l_rsfirewall_offenders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jba8l_rsfirewall_signatures`
--
ALTER TABLE `jba8l_rsfirewall_signatures`
  ADD PRIMARY KEY (`signature`,`type`);

--
-- Indexes for table `jba8l_rsfirewall_snapshots`
--
ALTER TABLE `jba8l_rsfirewall_snapshots`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jba8l_rsform_calculations`
--
ALTER TABLE `jba8l_rsform_calculations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `formId` (`formId`),
  ADD KEY `ordering` (`ordering`),
  ADD KEY `formId_2` (`formId`,`ordering`);

--
-- Indexes for table `jba8l_rsform_components`
--
ALTER TABLE `jba8l_rsform_components`
  ADD UNIQUE KEY `ComponentId` (`ComponentId`),
  ADD KEY `ComponentTypeId` (`ComponentTypeId`),
  ADD KEY `FormId` (`FormId`);

--
-- Indexes for table `jba8l_rsform_component_types`
--
ALTER TABLE `jba8l_rsform_component_types`
  ADD PRIMARY KEY (`ComponentTypeId`);

--
-- Indexes for table `jba8l_rsform_component_type_fields`
--
ALTER TABLE `jba8l_rsform_component_type_fields`
  ADD KEY `ComponentTypeId` (`ComponentTypeId`);

--
-- Indexes for table `jba8l_rsform_conditions`
--
ALTER TABLE `jba8l_rsform_conditions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `form_id` (`form_id`);

--
-- Indexes for table `jba8l_rsform_condition_details`
--
ALTER TABLE `jba8l_rsform_condition_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `condition_id` (`condition_id`),
  ADD KEY `component_id` (`component_id`);

--
-- Indexes for table `jba8l_rsform_config`
--
ALTER TABLE `jba8l_rsform_config`
  ADD PRIMARY KEY (`SettingName`);

--
-- Indexes for table `jba8l_rsform_directory`
--
ALTER TABLE `jba8l_rsform_directory`
  ADD PRIMARY KEY (`formId`);

--
-- Indexes for table `jba8l_rsform_directory_fields`
--
ALTER TABLE `jba8l_rsform_directory_fields`
  ADD UNIQUE KEY `formId` (`formId`,`componentId`);

--
-- Indexes for table `jba8l_rsform_emails`
--
ALTER TABLE `jba8l_rsform_emails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jba8l_rsform_forms`
--
ALTER TABLE `jba8l_rsform_forms`
  ADD PRIMARY KEY (`FormId`);

--
-- Indexes for table `jba8l_rsform_mappings`
--
ALTER TABLE `jba8l_rsform_mappings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jba8l_rsform_posts`
--
ALTER TABLE `jba8l_rsform_posts`
  ADD PRIMARY KEY (`form_id`);

--
-- Indexes for table `jba8l_rsform_properties`
--
ALTER TABLE `jba8l_rsform_properties`
  ADD UNIQUE KEY `PropertyId` (`PropertyId`),
  ADD KEY `ComponentId` (`ComponentId`);

--
-- Indexes for table `jba8l_rsform_submissions`
--
ALTER TABLE `jba8l_rsform_submissions`
  ADD PRIMARY KEY (`SubmissionId`),
  ADD KEY `FormId` (`FormId`),
  ADD KEY `SubmissionId` (`SubmissionId`,`FormId`,`DateSubmitted`),
  ADD KEY `SubmissionHash` (`SubmissionHash`);

--
-- Indexes for table `jba8l_rsform_submission_columns`
--
ALTER TABLE `jba8l_rsform_submission_columns`
  ADD PRIMARY KEY (`FormId`,`ColumnName`,`ColumnStatic`);

--
-- Indexes for table `jba8l_rsform_submission_values`
--
ALTER TABLE `jba8l_rsform_submission_values`
  ADD PRIMARY KEY (`SubmissionValueId`),
  ADD KEY `FormId` (`FormId`),
  ADD KEY `SubmissionId` (`SubmissionId`);

--
-- Indexes for table `jba8l_rsform_translations`
--
ALTER TABLE `jba8l_rsform_translations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `form_id` (`form_id`),
  ADD KEY `lang_code` (`lang_code`),
  ADD KEY `reference` (`reference`),
  ADD KEY `lang_search` (`form_id`,`lang_code`,`reference`);

--
-- Indexes for table `jba8l_scheduler_jobs`
--
ALTER TABLE `jba8l_scheduler_jobs`
  ADD UNIQUE KEY `name` (`identifier`),
  ADD UNIQUE KEY `uuid` (`uuid`);

--
-- Indexes for table `jba8l_scheduler_metadata`
--
ALTER TABLE `jba8l_scheduler_metadata`
  ADD UNIQUE KEY `unique_type` (`type`);

--
-- Indexes for table `jba8l_schemas`
--
ALTER TABLE `jba8l_schemas`
  ADD PRIMARY KEY (`extension_id`,`version_id`);

--
-- Indexes for table `jba8l_session`
--
ALTER TABLE `jba8l_session`
  ADD PRIMARY KEY (`session_id`),
  ADD KEY `userid` (`userid`),
  ADD KEY `time` (`time`),
  ADD KEY `client_id_guest` (`client_id`,`guest`);

--
-- Indexes for table `jba8l_spmedia`
--
ALTER TABLE `jba8l_spmedia`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jba8l_sppagebuilder`
--
ALTER TABLE `jba8l_sppagebuilder`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jba8l_sppagebuilder_addons`
--
ALTER TABLE `jba8l_sppagebuilder_addons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jba8l_sppagebuilder_integrations`
--
ALTER TABLE `jba8l_sppagebuilder_integrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jba8l_sppagebuilder_languages`
--
ALTER TABLE `jba8l_sppagebuilder_languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jba8l_sppagebuilder_sections`
--
ALTER TABLE `jba8l_sppagebuilder_sections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jba8l_survey_force_authors`
--
ALTER TABLE `jba8l_survey_force_authors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jba8l_survey_force_cats`
--
ALTER TABLE `jba8l_survey_force_cats`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sf_catname` (`sf_catname`);

--
-- Indexes for table `jba8l_survey_force_dashboard_items`
--
ALTER TABLE `jba8l_survey_force_dashboard_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jba8l_survey_force_def_answers`
--
ALTER TABLE `jba8l_survey_force_def_answers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jba8l_survey_force_emails`
--
ALTER TABLE `jba8l_survey_force_emails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jba8l_survey_force_fields`
--
ALTER TABLE `jba8l_survey_force_fields`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quest_id` (`quest_id`);

--
-- Indexes for table `jba8l_survey_force_invitations`
--
ALTER TABLE `jba8l_survey_force_invitations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `jba8l_survey_force_iscales`
--
ALTER TABLE `jba8l_survey_force_iscales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jba8l_survey_force_iscales_fields`
--
ALTER TABLE `jba8l_survey_force_iscales_fields`
  ADD PRIMARY KEY (`id`),
  ADD KEY `iscale_id` (`iscale_id`);

--
-- Indexes for table `jba8l_survey_force_listusers`
--
ALTER TABLE `jba8l_survey_force_listusers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jba8l_survey_force_previews`
--
ALTER TABLE `jba8l_survey_force_previews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `start_id` (`start_id`);

--
-- Indexes for table `jba8l_survey_force_qsections`
--
ALTER TABLE `jba8l_survey_force_qsections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jba8l_survey_force_qtypes`
--
ALTER TABLE `jba8l_survey_force_qtypes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jba8l_survey_force_quests`
--
ALTER TABLE `jba8l_survey_force_quests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sf_survey` (`sf_survey`);

--
-- Indexes for table `jba8l_survey_force_quest_show`
--
ALTER TABLE `jba8l_survey_force_quest_show`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quest_id` (`quest_id`);

--
-- Indexes for table `jba8l_survey_force_rules`
--
ALTER TABLE `jba8l_survey_force_rules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quest_id` (`quest_id`);

--
-- Indexes for table `jba8l_survey_force_scales`
--
ALTER TABLE `jba8l_survey_force_scales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quest_id` (`quest_id`);

--
-- Indexes for table `jba8l_survey_force_survs`
--
ALTER TABLE `jba8l_survey_force_survs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sf_cat` (`sf_cat`);

--
-- Indexes for table `jba8l_survey_force_templates`
--
ALTER TABLE `jba8l_survey_force_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jba8l_survey_force_users`
--
ALTER TABLE `jba8l_survey_force_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `list_id` (`list_id`);

--
-- Indexes for table `jba8l_survey_force_user_answers`
--
ALTER TABLE `jba8l_survey_force_user_answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `start_id` (`start_id`),
  ADD KEY `ua_index` (`quest_id`,`survey_id`,`start_id`);

--
-- Indexes for table `jba8l_survey_force_user_answers_imp`
--
ALTER TABLE `jba8l_survey_force_user_answers_imp`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ua_imp_index` (`quest_id`,`survey_id`,`iscale_id`,`start_id`);

--
-- Indexes for table `jba8l_survey_force_user_ans_txt`
--
ALTER TABLE `jba8l_survey_force_user_ans_txt`
  ADD PRIMARY KEY (`id`),
  ADD KEY `start_id` (`start_id`);

--
-- Indexes for table `jba8l_survey_force_user_chain`
--
ALTER TABLE `jba8l_survey_force_user_chain`
  ADD PRIMARY KEY (`id`),
  ADD KEY `start_id` (`start_id`);

--
-- Indexes for table `jba8l_survey_force_user_starts`
--
ALTER TABLE `jba8l_survey_force_user_starts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `survey_id` (`survey_id`);

--
-- Indexes for table `jba8l_tags`
--
ALTER TABLE `jba8l_tags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tag_idx` (`published`,`access`),
  ADD KEY `idx_access` (`access`),
  ADD KEY `idx_checkout` (`checked_out`),
  ADD KEY `idx_left_right` (`lft`,`rgt`),
  ADD KEY `idx_language` (`language`),
  ADD KEY `idx_path` (`path`(100)),
  ADD KEY `idx_alias` (`alias`(100));

--
-- Indexes for table `jba8l_template_styles`
--
ALTER TABLE `jba8l_template_styles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_template` (`template`),
  ADD KEY `idx_client_id` (`client_id`),
  ADD KEY `idx_client_id_home` (`client_id`,`home`);

--
-- Indexes for table `jba8l_ucm_base`
--
ALTER TABLE `jba8l_ucm_base`
  ADD PRIMARY KEY (`ucm_id`),
  ADD KEY `idx_ucm_item_id` (`ucm_item_id`),
  ADD KEY `idx_ucm_type_id` (`ucm_type_id`),
  ADD KEY `idx_ucm_language_id` (`ucm_language_id`);

--
-- Indexes for table `jba8l_ucm_content`
--
ALTER TABLE `jba8l_ucm_content`
  ADD PRIMARY KEY (`core_content_id`),
  ADD KEY `tag_idx` (`core_state`,`core_access`),
  ADD KEY `idx_access` (`core_access`),
  ADD KEY `idx_language` (`core_language`),
  ADD KEY `idx_modified_time` (`core_modified_time`),
  ADD KEY `idx_created_time` (`core_created_time`),
  ADD KEY `idx_core_modified_user_id` (`core_modified_user_id`),
  ADD KEY `idx_core_checked_out_user_id` (`core_checked_out_user_id`),
  ADD KEY `idx_core_created_user_id` (`core_created_user_id`),
  ADD KEY `idx_core_type_id` (`core_type_id`),
  ADD KEY `idx_alias` (`core_alias`(100)),
  ADD KEY `idx_title` (`core_title`(100)),
  ADD KEY `idx_content_type` (`core_type_alias`(100));

--
-- Indexes for table `jba8l_ucm_history`
--
ALTER TABLE `jba8l_ucm_history`
  ADD PRIMARY KEY (`version_id`),
  ADD KEY `idx_ucm_item_id` (`ucm_type_id`,`ucm_item_id`),
  ADD KEY `idx_save_date` (`save_date`);

--
-- Indexes for table `jba8l_updates`
--
ALTER TABLE `jba8l_updates`
  ADD PRIMARY KEY (`update_id`);

--
-- Indexes for table `jba8l_update_sites`
--
ALTER TABLE `jba8l_update_sites`
  ADD PRIMARY KEY (`update_site_id`);

--
-- Indexes for table `jba8l_update_sites_extensions`
--
ALTER TABLE `jba8l_update_sites_extensions`
  ADD PRIMARY KEY (`update_site_id`,`extension_id`);

--
-- Indexes for table `jba8l_usergroups`
--
ALTER TABLE `jba8l_usergroups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_usergroup_parent_title_lookup` (`parent_id`,`title`),
  ADD KEY `idx_usergroup_title_lookup` (`title`),
  ADD KEY `idx_usergroup_adjacency_lookup` (`parent_id`),
  ADD KEY `idx_usergroup_nested_set_lookup` (`lft`,`rgt`);

--
-- Indexes for table `jba8l_users`
--
ALTER TABLE `jba8l_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_username` (`username`),
  ADD KEY `idx_block` (`block`),
  ADD KEY `email` (`email`),
  ADD KEY `idx_name` (`name`(100));

--
-- Indexes for table `jba8l_user_keys`
--
ALTER TABLE `jba8l_user_keys`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `series` (`series`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `jba8l_user_notes`
--
ALTER TABLE `jba8l_user_notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_category_id` (`catid`);

--
-- Indexes for table `jba8l_user_profiles`
--
ALTER TABLE `jba8l_user_profiles`
  ADD UNIQUE KEY `idx_user_id_profile_key` (`user_id`,`profile_key`);

--
-- Indexes for table `jba8l_user_usergroup_map`
--
ALTER TABLE `jba8l_user_usergroup_map`
  ADD PRIMARY KEY (`user_id`,`group_id`);

--
-- Indexes for table `jba8l_viewlevels`
--
ALTER TABLE `jba8l_viewlevels`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_assetgroup_title_lookup` (`title`);

--
-- Indexes for table `jba8l_vvisit_counter`
--
ALTER TABLE `jba8l_vvisit_counter`
  ADD PRIMARY KEY (`time`),
  ADD UNIQUE KEY `time` (`time`);

--
-- Indexes for table `jba8l_wf_profiles`
--
ALTER TABLE `jba8l_wf_profiles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jba8l_widgetkit`
--
ALTER TABLE `jba8l_widgetkit`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jba8l_action_logs`
--
ALTER TABLE `jba8l_action_logs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_action_logs_extensions`
--
ALTER TABLE `jba8l_action_logs_extensions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_action_log_config`
--
ALTER TABLE `jba8l_action_log_config`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_activities_resources`
--
ALTER TABLE `jba8l_activities_resources`
  MODIFY `activities_resource_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_admintools_adminiplist`
--
ALTER TABLE `jba8l_admintools_adminiplist`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_admintools_badwords`
--
ALTER TABLE `jba8l_admintools_badwords`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_admintools_customperms`
--
ALTER TABLE `jba8l_admintools_customperms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_admintools_filescache`
--
ALTER TABLE `jba8l_admintools_filescache`
  MODIFY `admintools_filescache_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_admintools_ipautobanhistory`
--
ALTER TABLE `jba8l_admintools_ipautobanhistory`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_admintools_ipblock`
--
ALTER TABLE `jba8l_admintools_ipblock`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_admintools_log`
--
ALTER TABLE `jba8l_admintools_log`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_admintools_profiles`
--
ALTER TABLE `jba8l_admintools_profiles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_admintools_redirects`
--
ALTER TABLE `jba8l_admintools_redirects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_admintools_scanalerts`
--
ALTER TABLE `jba8l_admintools_scanalerts`
  MODIFY `admintools_scanalert_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_admintools_scans`
--
ALTER TABLE `jba8l_admintools_scans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_admintools_wafblacklists`
--
ALTER TABLE `jba8l_admintools_wafblacklists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_admintools_wafexceptions`
--
ALTER TABLE `jba8l_admintools_wafexceptions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_admintools_waftemplates`
--
ALTER TABLE `jba8l_admintools_waftemplates`
  MODIFY `admintools_waftemplate_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_ak_profiles`
--
ALTER TABLE `jba8l_ak_profiles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_ak_stats`
--
ALTER TABLE `jba8l_ak_stats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_ampz`
--
ALTER TABLE `jba8l_ampz`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_ampz_stats`
--
ALTER TABLE `jba8l_ampz_stats`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_assets`
--
ALTER TABLE `jba8l_assets`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Primary Key';

--
-- AUTO_INCREMENT for table `jba8l_banners`
--
ALTER TABLE `jba8l_banners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_banner_clients`
--
ALTER TABLE `jba8l_banner_clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_categories`
--
ALTER TABLE `jba8l_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_contact_details`
--
ALTER TABLE `jba8l_contact_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_content`
--
ALTER TABLE `jba8l_content`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_content_types`
--
ALTER TABLE `jba8l_content_types`
  MODIFY `type_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_cwgears`
--
ALTER TABLE `jba8l_cwgears`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Primary Key';

--
-- AUTO_INCREMENT for table `jba8l_cwgears_schedule`
--
ALTER TABLE `jba8l_cwgears_schedule`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Primary Key';

--
-- AUTO_INCREMENT for table `jba8l_cwtraffic`
--
ALTER TABLE `jba8l_cwtraffic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_cwtraffic_knownips`
--
ALTER TABLE `jba8l_cwtraffic_knownips`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_cwtraffic_locations`
--
ALTER TABLE `jba8l_cwtraffic_locations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_cwtraffic_whoisonline`
--
ALTER TABLE `jba8l_cwtraffic_whoisonline`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_djimageslider`
--
ALTER TABLE `jba8l_djimageslider`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_dpcalendar_bookings`
--
ALTER TABLE `jba8l_dpcalendar_bookings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_dpcalendar_caldav_calendarchanges`
--
ALTER TABLE `jba8l_dpcalendar_caldav_calendarchanges`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_dpcalendar_caldav_calendarinstances`
--
ALTER TABLE `jba8l_dpcalendar_caldav_calendarinstances`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_dpcalendar_caldav_calendarobjects`
--
ALTER TABLE `jba8l_dpcalendar_caldav_calendarobjects`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_dpcalendar_caldav_calendars`
--
ALTER TABLE `jba8l_dpcalendar_caldav_calendars`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_dpcalendar_caldav_calendarsubscriptions`
--
ALTER TABLE `jba8l_dpcalendar_caldav_calendarsubscriptions`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_dpcalendar_caldav_groupmembers`
--
ALTER TABLE `jba8l_dpcalendar_caldav_groupmembers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_dpcalendar_caldav_principals`
--
ALTER TABLE `jba8l_dpcalendar_caldav_principals`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_dpcalendar_caldav_propertystorage`
--
ALTER TABLE `jba8l_dpcalendar_caldav_propertystorage`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_dpcalendar_caldav_schedulingobjects`
--
ALTER TABLE `jba8l_dpcalendar_caldav_schedulingobjects`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_dpcalendar_events`
--
ALTER TABLE `jba8l_dpcalendar_events`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_dpcalendar_extcalendars`
--
ALTER TABLE `jba8l_dpcalendar_extcalendars`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_dpcalendar_locations`
--
ALTER TABLE `jba8l_dpcalendar_locations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_dpcalendar_tickets`
--
ALTER TABLE `jba8l_dpcalendar_tickets`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_extensions`
--
ALTER TABLE `jba8l_extensions`
  MODIFY `extension_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_falang_content`
--
ALTER TABLE `jba8l_falang_content`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_falang_tableinfo`
--
ALTER TABLE `jba8l_falang_tableinfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_fields`
--
ALTER TABLE `jba8l_fields`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_fields_groups`
--
ALTER TABLE `jba8l_fields_groups`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_files_containers`
--
ALTER TABLE `jba8l_files_containers`
  MODIFY `files_container_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_finder_filters`
--
ALTER TABLE `jba8l_finder_filters`
  MODIFY `filter_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_finder_links`
--
ALTER TABLE `jba8l_finder_links`
  MODIFY `link_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_finder_taxonomy`
--
ALTER TABLE `jba8l_finder_taxonomy`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_finder_terms`
--
ALTER TABLE `jba8l_finder_terms`
  MODIFY `term_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_finder_types`
--
ALTER TABLE `jba8l_finder_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_flexicontent_advsearch_index`
--
ALTER TABLE `jba8l_flexicontent_advsearch_index`
  MODIFY `sid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_flexicontent_advsearch_index_field_2`
--
ALTER TABLE `jba8l_flexicontent_advsearch_index_field_2`
  MODIFY `sid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_flexicontent_advsearch_index_field_117`
--
ALTER TABLE `jba8l_flexicontent_advsearch_index_field_117`
  MODIFY `sid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_flexicontent_download_coupons`
--
ALTER TABLE `jba8l_flexicontent_download_coupons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_flexicontent_download_history`
--
ALTER TABLE `jba8l_flexicontent_download_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_flexicontent_edit_coupons`
--
ALTER TABLE `jba8l_flexicontent_edit_coupons`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_flexicontent_favourites`
--
ALTER TABLE `jba8l_flexicontent_favourites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_flexicontent_fields`
--
ALTER TABLE `jba8l_flexicontent_fields`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_flexicontent_files`
--
ALTER TABLE `jba8l_flexicontent_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_flexicontent_reviews`
--
ALTER TABLE `jba8l_flexicontent_reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_flexicontent_tags`
--
ALTER TABLE `jba8l_flexicontent_tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_flexicontent_templates`
--
ALTER TABLE `jba8l_flexicontent_templates`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_flexicontent_types`
--
ALTER TABLE `jba8l_flexicontent_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_flexicontent_versions`
--
ALTER TABLE `jba8l_flexicontent_versions`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_j2xml_websites`
--
ALTER TABLE `jba8l_j2xml_websites`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_jevents_catmap`
--
ALTER TABLE `jba8l_jevents_catmap`
  MODIFY `evid` int(12) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_jevents_exception`
--
ALTER TABLE `jba8l_jevents_exception`
  MODIFY `ex_id` int(12) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_jevents_filtermap`
--
ALTER TABLE `jba8l_jevents_filtermap`
  MODIFY `fid` int(12) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_jevents_icsfile`
--
ALTER TABLE `jba8l_jevents_icsfile`
  MODIFY `ics_id` int(12) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_jevents_repetition`
--
ALTER TABLE `jba8l_jevents_repetition`
  MODIFY `rp_id` int(12) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_jevents_rrule`
--
ALTER TABLE `jba8l_jevents_rrule`
  MODIFY `rr_id` int(12) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_jevents_translation`
--
ALTER TABLE `jba8l_jevents_translation`
  MODIFY `translation_id` int(12) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_jevents_vevdetail`
--
ALTER TABLE `jba8l_jevents_vevdetail`
  MODIFY `evdet_id` int(12) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_jevents_vevent`
--
ALTER TABLE `jba8l_jevents_vevent`
  MODIFY `ev_id` int(12) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_jev_defaults`
--
ALTER TABLE `jba8l_jev_defaults`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_jev_users`
--
ALTER TABLE `jba8l_jev_users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_jmap`
--
ALTER TABLE `jba8l_jmap`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_jmap_canonicals`
--
ALTER TABLE `jba8l_jmap_canonicals`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_jmap_datasets`
--
ALTER TABLE `jba8l_jmap_datasets`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_jmap_headings`
--
ALTER TABLE `jba8l_jmap_headings`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_jmap_metainfo`
--
ALTER TABLE `jba8l_jmap_metainfo`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_jmap_pingomatic`
--
ALTER TABLE `jba8l_jmap_pingomatic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_languages`
--
ALTER TABLE `jba8l_languages`
  MODIFY `lang_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_logman_activities`
--
ALTER TABLE `jba8l_logman_activities`
  MODIFY `logman_activity_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_logman_impressions`
--
ALTER TABLE `jba8l_logman_impressions`
  MODIFY `logman_impression_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_logman_routes`
--
ALTER TABLE `jba8l_logman_routes`
  MODIFY `logman_route_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_menu`
--
ALTER TABLE `jba8l_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_menu_types`
--
ALTER TABLE `jba8l_menu_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_messages`
--
ALTER TABLE `jba8l_messages`
  MODIFY `message_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_modules`
--
ALTER TABLE `jba8l_modules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_newsfeeds`
--
ALTER TABLE `jba8l_newsfeeds`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_overrider`
--
ALTER TABLE `jba8l_overrider`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'Primary Key';

--
-- AUTO_INCREMENT for table `jba8l_pagebuilderck_elements`
--
ALTER TABLE `jba8l_pagebuilderck_elements`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_pagebuilderck_pages`
--
ALTER TABLE `jba8l_pagebuilderck_pages`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_plg_system_cookiespolicynotificationbar_logs`
--
ALTER TABLE `jba8l_plg_system_cookiespolicynotificationbar_logs`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_postinstall_messages`
--
ALTER TABLE `jba8l_postinstall_messages`
  MODIFY `postinstall_message_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_privacy_consents`
--
ALTER TABLE `jba8l_privacy_consents`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_privacy_requests`
--
ALTER TABLE `jba8l_privacy_requests`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_quix`
--
ALTER TABLE `jba8l_quix`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_quix_collections`
--
ALTER TABLE `jba8l_quix_collections`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_quix_collection_map`
--
ALTER TABLE `jba8l_quix_collection_map`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_quix_conditions`
--
ALTER TABLE `jba8l_quix_conditions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_quix_editor_map`
--
ALTER TABLE `jba8l_quix_editor_map`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_quix_elements`
--
ALTER TABLE `jba8l_quix_elements`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_quix_imgstats`
--
ALTER TABLE `jba8l_quix_imgstats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_redirect_links`
--
ALTER TABLE `jba8l_redirect_links`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_rokcommon_configs`
--
ALTER TABLE `jba8l_rokcommon_configs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_roksprocket_items`
--
ALTER TABLE `jba8l_roksprocket_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_rsfirewall_exceptions`
--
ALTER TABLE `jba8l_rsfirewall_exceptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_rsfirewall_hashes`
--
ALTER TABLE `jba8l_rsfirewall_hashes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_rsfirewall_lists`
--
ALTER TABLE `jba8l_rsfirewall_lists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_rsfirewall_logs`
--
ALTER TABLE `jba8l_rsfirewall_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_rsfirewall_offenders`
--
ALTER TABLE `jba8l_rsfirewall_offenders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_rsfirewall_snapshots`
--
ALTER TABLE `jba8l_rsfirewall_snapshots`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_rsform_calculations`
--
ALTER TABLE `jba8l_rsform_calculations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_rsform_components`
--
ALTER TABLE `jba8l_rsform_components`
  MODIFY `ComponentId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_rsform_component_types`
--
ALTER TABLE `jba8l_rsform_component_types`
  MODIFY `ComponentTypeId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_rsform_conditions`
--
ALTER TABLE `jba8l_rsform_conditions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_rsform_condition_details`
--
ALTER TABLE `jba8l_rsform_condition_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_rsform_emails`
--
ALTER TABLE `jba8l_rsform_emails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_rsform_forms`
--
ALTER TABLE `jba8l_rsform_forms`
  MODIFY `FormId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_rsform_mappings`
--
ALTER TABLE `jba8l_rsform_mappings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_rsform_properties`
--
ALTER TABLE `jba8l_rsform_properties`
  MODIFY `PropertyId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_rsform_submissions`
--
ALTER TABLE `jba8l_rsform_submissions`
  MODIFY `SubmissionId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_rsform_submission_values`
--
ALTER TABLE `jba8l_rsform_submission_values`
  MODIFY `SubmissionValueId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_rsform_translations`
--
ALTER TABLE `jba8l_rsform_translations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_spmedia`
--
ALTER TABLE `jba8l_spmedia`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_sppagebuilder`
--
ALTER TABLE `jba8l_sppagebuilder`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_sppagebuilder_addons`
--
ALTER TABLE `jba8l_sppagebuilder_addons`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_sppagebuilder_integrations`
--
ALTER TABLE `jba8l_sppagebuilder_integrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_sppagebuilder_languages`
--
ALTER TABLE `jba8l_sppagebuilder_languages`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_sppagebuilder_sections`
--
ALTER TABLE `jba8l_sppagebuilder_sections`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_survey_force_authors`
--
ALTER TABLE `jba8l_survey_force_authors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_survey_force_cats`
--
ALTER TABLE `jba8l_survey_force_cats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_survey_force_dashboard_items`
--
ALTER TABLE `jba8l_survey_force_dashboard_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_survey_force_def_answers`
--
ALTER TABLE `jba8l_survey_force_def_answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_survey_force_emails`
--
ALTER TABLE `jba8l_survey_force_emails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_survey_force_fields`
--
ALTER TABLE `jba8l_survey_force_fields`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_survey_force_invitations`
--
ALTER TABLE `jba8l_survey_force_invitations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_survey_force_iscales`
--
ALTER TABLE `jba8l_survey_force_iscales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_survey_force_iscales_fields`
--
ALTER TABLE `jba8l_survey_force_iscales_fields`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_survey_force_listusers`
--
ALTER TABLE `jba8l_survey_force_listusers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_survey_force_previews`
--
ALTER TABLE `jba8l_survey_force_previews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_survey_force_qsections`
--
ALTER TABLE `jba8l_survey_force_qsections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_survey_force_qtypes`
--
ALTER TABLE `jba8l_survey_force_qtypes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_survey_force_quests`
--
ALTER TABLE `jba8l_survey_force_quests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_survey_force_quest_show`
--
ALTER TABLE `jba8l_survey_force_quest_show`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_survey_force_rules`
--
ALTER TABLE `jba8l_survey_force_rules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_survey_force_scales`
--
ALTER TABLE `jba8l_survey_force_scales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_survey_force_survs`
--
ALTER TABLE `jba8l_survey_force_survs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_survey_force_templates`
--
ALTER TABLE `jba8l_survey_force_templates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_survey_force_users`
--
ALTER TABLE `jba8l_survey_force_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_survey_force_user_answers`
--
ALTER TABLE `jba8l_survey_force_user_answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_survey_force_user_answers_imp`
--
ALTER TABLE `jba8l_survey_force_user_answers_imp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_survey_force_user_ans_txt`
--
ALTER TABLE `jba8l_survey_force_user_ans_txt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_survey_force_user_chain`
--
ALTER TABLE `jba8l_survey_force_user_chain`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_survey_force_user_starts`
--
ALTER TABLE `jba8l_survey_force_user_starts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_tags`
--
ALTER TABLE `jba8l_tags`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_template_styles`
--
ALTER TABLE `jba8l_template_styles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_ucm_content`
--
ALTER TABLE `jba8l_ucm_content`
  MODIFY `core_content_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_ucm_history`
--
ALTER TABLE `jba8l_ucm_history`
  MODIFY `version_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_updates`
--
ALTER TABLE `jba8l_updates`
  MODIFY `update_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_update_sites`
--
ALTER TABLE `jba8l_update_sites`
  MODIFY `update_site_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_usergroups`
--
ALTER TABLE `jba8l_usergroups`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Primary Key';

--
-- AUTO_INCREMENT for table `jba8l_users`
--
ALTER TABLE `jba8l_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_user_keys`
--
ALTER TABLE `jba8l_user_keys`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_user_notes`
--
ALTER TABLE `jba8l_user_notes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_viewlevels`
--
ALTER TABLE `jba8l_viewlevels`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Primary Key';

--
-- AUTO_INCREMENT for table `jba8l_wf_profiles`
--
ALTER TABLE `jba8l_wf_profiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jba8l_widgetkit`
--
ALTER TABLE `jba8l_widgetkit`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `jba8l_logman_activities_impressions`
--
ALTER TABLE `jba8l_logman_activities_impressions`
  ADD CONSTRAINT `logman_activities_impressions_ibfk_1` FOREIGN KEY (`logman_activity_id`) REFERENCES `jba8l_logman_activities` (`logman_activity_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `logman_activities_impressions_ibfk_2` FOREIGN KEY (`logman_impression_id`) REFERENCES `jba8l_logman_impressions` (`logman_impression_id`) ON DELETE CASCADE;

--
-- Constraints for table `jba8l_logman_synchronization`
--
ALTER TABLE `jba8l_logman_synchronization`
  ADD CONSTRAINT `logman_synchronization_ibfk_1` FOREIGN KEY (`uuid`) REFERENCES `jba8l_logman_activities` (`uuid`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
