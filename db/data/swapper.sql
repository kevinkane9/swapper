/*
Navicat MySQL Data Transfer

Source Server         : Vagrant
Source Server Version : 50722
Source Host           : 192.168.10.10:3306
Source Database       : swapper

Target Server Type    : MYSQL
Target Server Version : 50722
File Encoding         : 65001

Date: 2018-06-04 16:49:33
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for phinxlog
-- ----------------------------
DROP TABLE IF EXISTS `phinxlog`;
CREATE TABLE `phinxlog` (
  `version` bigint(20) NOT NULL,
  `migration_name` varchar(100) DEFAULT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `breakpoint` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of phinxlog
-- ----------------------------
INSERT INTO `phinxlog` VALUES ('20180130102716', 'InitialSchema', '2018-06-01 20:29:10', '2018-06-01 20:29:31', '0');
INSERT INTO `phinxlog` VALUES ('20180130163555', 'ExceptionNotifications', '2018-06-01 20:29:31', '2018-06-01 20:29:31', '0');
INSERT INTO `phinxlog` VALUES ('20180130171936', 'IncreaseProspectEmailLength', '2018-06-01 20:29:31', '2018-06-01 20:29:31', '0');
INSERT INTO `phinxlog` VALUES ('20180206152309', 'IncreaseGmailEventIdLength', '2018-06-01 20:29:31', '2018-06-01 20:29:31', '0');
INSERT INTO `phinxlog` VALUES ('20180208132615', 'StoreBackgroundProcessPid', '2018-06-01 20:29:31', '2018-06-01 20:29:31', '0');
INSERT INTO `phinxlog` VALUES ('20180311115131', 'MultipleSurveysPerEvent', '2018-06-01 20:29:31', '2018-06-01 20:29:31', '0');
INSERT INTO `phinxlog` VALUES ('20180312152611', 'AddClientStats', '2018-06-01 20:29:31', '2018-06-01 20:29:31', '0');
INSERT INTO `phinxlog` VALUES ('20180319160809', 'AddClientStatsUnique', '2018-06-01 20:29:31', '2018-06-01 20:29:32', '0');
INSERT INTO `phinxlog` VALUES ('20180320170115', 'AddClientUniqueStats', '2018-06-01 20:29:32', '2018-06-01 20:29:32', '0');
INSERT INTO `phinxlog` VALUES ('20180321231801', 'ImproveCsmAndPod', '2018-06-01 20:29:32', '2018-06-01 20:29:33', '0');
INSERT INTO `phinxlog` VALUES ('20180325003345', 'AddMoreZoominfoData', '2018-06-01 20:29:33', '2018-06-01 20:29:37', '0');
INSERT INTO `phinxlog` VALUES ('20180328012243', 'AttachPodToUserNotClient', '2018-06-01 20:29:37', '2018-06-01 20:29:37', '0');
INSERT INTO `phinxlog` VALUES ('20180404225139', 'AddGmailCalendarColorDefinitions', '2018-06-01 20:29:37', '2018-06-01 20:29:38', '0');
INSERT INTO `phinxlog` VALUES ('20180405014659', 'AddGmailEventColors', '2018-06-01 20:29:38', '2018-06-01 20:29:38', '0');
INSERT INTO `phinxlog` VALUES ('20180405101139', 'MysqlDbCleanup', '2018-06-01 20:29:38', '2018-06-01 20:29:41', '0');
INSERT INTO `phinxlog` VALUES ('20180406005654', 'AddClientHistory', '2018-06-01 20:29:41', '2018-06-01 20:29:41', '0');
INSERT INTO `phinxlog` VALUES ('20180409005812', 'AddEventsWithoutValidRecipients', '2018-06-01 20:29:41', '2018-06-01 20:29:41', '0');
INSERT INTO `phinxlog` VALUES ('20180411131239', 'AdditionalDbTables', '2018-06-01 20:29:41', '2018-06-01 20:29:42', '0');
INSERT INTO `phinxlog` VALUES ('20180424143411', 'IncreaseFilenameLengths', '2018-06-01 20:29:42', '2018-06-01 20:29:43', '0');
INSERT INTO `phinxlog` VALUES ('20180429150131', 'OutreachV2MongoSync', '2018-06-01 20:29:43', '2018-06-01 20:29:43', '0');
INSERT INTO `phinxlog` VALUES ('20180513155714', 'AddProsperworksIdToClient', '2018-06-01 20:29:43', '2018-06-01 20:29:43', '0');
INSERT INTO `phinxlog` VALUES ('20180516194731', 'AssignmentConstraintChange', '2018-06-01 20:29:43', '2018-06-01 20:29:43', '0');
INSERT INTO `phinxlog` VALUES ('20180521211211', 'ProsperworksP2', '2018-06-01 20:29:43', '2018-06-01 20:29:43', '0');
INSERT INTO `phinxlog` VALUES ('20180521213517', 'ProsperworksP3', '2018-06-01 20:29:43', '2018-06-01 20:29:44', '0');
INSERT INTO `phinxlog` VALUES ('20180522102319', 'MailingDataInMysql', '2018-06-01 20:29:44', '2018-06-01 20:29:44', '0');
INSERT INTO `phinxlog` VALUES ('20180522152319', 'TemplatesDataInMysql', '2018-06-01 20:29:44', '2018-06-01 20:29:44', '0');
INSERT INTO `phinxlog` VALUES ('20180528191811', 'StoreReplyTimestamps', '2018-06-01 20:29:44', '2018-06-01 20:29:44', '0');
INSERT INTO `phinxlog` VALUES ('20180528201215', 'StoreConvertingTemplate', '2018-06-01 20:29:44', '2018-06-01 20:29:44', '0');
INSERT INTO `phinxlog` VALUES ('20180529070419', 'StoreProspectMatchedTitle', '2018-06-01 20:29:44', '2018-06-01 20:29:45', '0');
INSERT INTO `phinxlog` VALUES ('20180531172031', 'StoreLinkedinIndustries', '2018-06-01 20:29:45', '2018-06-01 20:29:46', '0');
INSERT INTO `phinxlog` VALUES ('20180531201411', 'RepairIncorrectIndustries', '2018-06-01 20:29:46', '2018-06-01 20:29:46', '0');
INSERT INTO `phinxlog` VALUES ('20180601192849', 'AddClientStatus', '2018-06-01 21:54:54', '2018-06-01 21:54:54', '0');

-- ----------------------------
-- Table structure for sap_background_job
-- ----------------------------
DROP TABLE IF EXISTS `sap_background_job`;
CREATE TABLE `sap_background_job` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) DEFAULT NULL,
  `status` varchar(15) NOT NULL DEFAULT 'ready',
  `data` longtext NOT NULL,
  `error` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `started_at` timestamp NULL DEFAULT NULL,
  `finished_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sap_background_job
-- ----------------------------

-- ----------------------------
-- Table structure for sap_client
-- ----------------------------
DROP TABLE IF EXISTS `sap_client`;
CREATE TABLE `sap_client` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(80) NOT NULL,
  `status` varchar(40) NOT NULL DEFAULT 'active',
  `user_id` int(11) DEFAULT NULL,
  `prosperworks_id` int(11) DEFAULT NULL,
  `sign_on_date` date DEFAULT NULL,
  `launch_date` date DEFAULT NULL,
  `expiration_date` date DEFAULT NULL,
  `contract_goal` int(11) DEFAULT NULL,
  `monthly_goal` int(11) DEFAULT NULL,
  `target_profiles_summary` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `user_id` (`user_id`),
  KEY `prosperworks_id` (`prosperworks_id`),
  CONSTRAINT `sap_client_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `sap_user` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `sap_client_ibfk_3` FOREIGN KEY (`prosperworks_id`) REFERENCES `sap_client_prosperworks` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sap_client
-- ----------------------------
INSERT INTO `sap_client` VALUES ('1', 'Name', 'archived', '3', '1', null, null, null, null, null, null, '2018-06-01 19:06:09');
INSERT INTO `sap_client` VALUES ('2', 'Kautzer', 'archived', '3', '1', null, null, null, null, null, null, '2018-06-01 22:26:03');

-- ----------------------------
-- Table structure for sap_client_account_gmail
-- ----------------------------
DROP TABLE IF EXISTS `sap_client_account_gmail`;
CREATE TABLE `sap_client_account_gmail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `survey_email` varchar(100) DEFAULT NULL,
  `survey_results_email` varchar(100) DEFAULT NULL,
  `access_token` text,
  `status` varchar(20) NOT NULL DEFAULT 'connected',
  `retry_after` timestamp NULL DEFAULT NULL,
  `disconnect_reason` text,
  `label_id_scheduling_in_progress` varchar(30) NOT NULL,
  `label_id_reschedule_cancel` varchar(30) NOT NULL,
  `label_id_referral` varchar(30) NOT NULL,
  `label_id_confused` varchar(30) NOT NULL,
  `label_id_closed_lost` varchar(30) NOT NULL,
  `label_id_bad_email` varchar(30) NOT NULL,
  `label_id_unknown` varchar(30) NOT NULL,
  `label_count_scheduling_in_progress` int(11) DEFAULT NULL,
  `label_count_reschedule_cancel` int(11) DEFAULT NULL,
  `label_count_referral` int(11) DEFAULT NULL,
  `label_count_confused` int(11) DEFAULT NULL,
  `label_count_closed_lost` int(11) DEFAULT NULL,
  `label_count_bad_email` int(11) DEFAULT NULL,
  `label_count_unknown` int(11) DEFAULT NULL,
  `label_id_flop` varchar(30) DEFAULT NULL,
  `label_id_referral_new` varchar(30) DEFAULT NULL,
  `label_id_referral_reached_out` varchar(30) DEFAULT NULL,
  `label_id_check_in` varchar(30) DEFAULT NULL,
  `label_id_check_in_jan` varchar(30) DEFAULT NULL,
  `label_id_check_in_feb` varchar(30) DEFAULT NULL,
  `label_id_check_in_mar` varchar(30) DEFAULT NULL,
  `label_id_check_in_apr` varchar(30) DEFAULT NULL,
  `label_id_check_in_may` varchar(30) DEFAULT NULL,
  `label_id_check_in_jun` varchar(30) DEFAULT NULL,
  `label_id_check_in_jul` varchar(30) DEFAULT NULL,
  `label_id_check_in_aug` varchar(30) DEFAULT NULL,
  `label_id_check_in_sep` varchar(30) DEFAULT NULL,
  `label_id_check_in_oct` varchar(30) DEFAULT NULL,
  `label_id_check_in_nov` varchar(30) DEFAULT NULL,
  `label_id_check_in_dec` varchar(30) DEFAULT NULL,
  `label_id_closed_lost_retired` varchar(30) DEFAULT NULL,
  `label_id_closed_lost_out_of_territory` varchar(30) DEFAULT NULL,
  `label_id_meeting_scheduled` varchar(30) DEFAULT NULL,
  `label_id_rescheduled` varchar(30) DEFAULT NULL,
  `label_id_client_collateral` varchar(30) DEFAULT NULL,
  `label_id_need_phone_no` varchar(30) DEFAULT NULL,
  `label_id_waiting_on_client_response` varchar(30) DEFAULT NULL,
  `label_id_out_of_office` varchar(30) DEFAULT NULL,
  `default_color_id` int(11) DEFAULT NULL,
  `last_scanned_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `client_id` (`client_id`),
  KEY `survey_email` (`survey_email`) USING BTREE,
  KEY `default_color_id` (`default_color_id`),
  CONSTRAINT `sap_client_account_gmail_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `sap_client` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `sap_client_account_gmail_ibfk_2` FOREIGN KEY (`default_color_id`) REFERENCES `sap_gmail_event_colors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sap_client_account_gmail
-- ----------------------------

-- ----------------------------
-- Table structure for sap_client_account_outreach
-- ----------------------------
DROP TABLE IF EXISTS `sap_client_account_outreach`;
CREATE TABLE `sap_client_account_outreach` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `access_token` text,
  `refresh_token` text,
  `token_expires` int(11) DEFAULT NULL,
  `request_index` int(11) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'disconnected',
  `status_v2` varchar(20) NOT NULL DEFAULT 'disconnected',
  `under_process_by` varchar(100) DEFAULT '0',
  `disconnect_reason` varchar(256) DEFAULT NULL,
  `last_pulled_at` timestamp NULL DEFAULT NULL,
  `last_pulled_at_v2` timestamp NULL DEFAULT NULL,
  `sync_stage_prospects_last_page` int(11) DEFAULT '0',
  `sync_stage_prospects_updated_at` datetime DEFAULT NULL,
  `outreach_scanned_end_date` datetime DEFAULT NULL,
  `outreach_scanned_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_unique` (`email`),
  KEY `client_id` (`client_id`),
  KEY `IDK_SYNC_STAGE` (`sync_stage_prospects_updated_at`),
  CONSTRAINT `foreign_client_id` FOREIGN KEY (`client_id`) REFERENCES `sap_client` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sap_client_account_outreach
-- ----------------------------

-- ----------------------------
-- Table structure for sap_client_assignment
-- ----------------------------
DROP TABLE IF EXISTS `sap_client_assignment`;
CREATE TABLE `sap_client_assignment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `starts_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ends_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `client_id` (`client_id`),
  CONSTRAINT `sap_client_assignment_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `sap_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `sap_client_assignment_ibfk_2` FOREIGN KEY (`client_id`) REFERENCES `sap_client` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sap_client_assignment
-- ----------------------------
INSERT INTO `sap_client_assignment` VALUES ('1', '3', '2', '2018-06-01 22:26:03', null);
INSERT INTO `sap_client_assignment` VALUES ('2', '3', '1', '2018-06-01 22:26:30', null);

-- ----------------------------
-- Table structure for sap_client_dne
-- ----------------------------
DROP TABLE IF EXISTS `sap_client_dne`;
CREATE TABLE `sap_client_dne` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `domain` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `client_id_domain_unique` (`client_id`,`domain`),
  KEY `client_id` (`client_id`) USING BTREE,
  KEY `client_id_domain` (`domain`,`client_id`) USING BTREE,
  CONSTRAINT `client_id` FOREIGN KEY (`client_id`) REFERENCES `sap_client` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sap_client_dne
-- ----------------------------

-- ----------------------------
-- Table structure for sap_client_health_score
-- ----------------------------
DROP TABLE IF EXISTS `sap_client_health_score`;
CREATE TABLE `sap_client_health_score` (
  `score_id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL DEFAULT '0',
  `year` int(4) DEFAULT NULL,
  `gmail_account_id` int(11) DEFAULT '0',
  `deal_closed` int(11) DEFAULT '0',
  `deal_closed_av` int(11) DEFAULT '0',
  `weeks_ago` int(11) DEFAULT '0',
  `weeks_ago_av` int(11) DEFAULT '0',
  `total_meetings` int(11) DEFAULT '0',
  `total_meetings_av` int(11) DEFAULT '0',
  `contract_meetings` int(11) DEFAULT '0',
  `contract_meetings_av` int(11) DEFAULT '0',
  `total_weeks` int(11) DEFAULT '0',
  `total_weeks_av` int(11) DEFAULT '0',
  `weeks_last_meeting` int(5) DEFAULT '0',
  `weeks_last_meeting_av` int(11) DEFAULT '0',
  `opp_in_progress` int(5) DEFAULT '0',
  `opp_in_progress_av` int(11) DEFAULT '0',
  `right_prospect_noip` int(5) DEFAULT '0',
  `right_prospect_noip_av` int(11) DEFAULT '0',
  `wrong_prospect_oip` int(5) DEFAULT '0',
  `wrong_prospect_oip_av` int(11) DEFAULT '0',
  `wrong_prospect` int(5) DEFAULT '0',
  `wrong_prospect_av` int(11) DEFAULT '0',
  `no_prospect` int(5) DEFAULT '0',
  `no_prospect_av` int(11) DEFAULT '0',
  `impression_score` int(5) DEFAULT '0',
  `notification_email_count` int(4) DEFAULT '0',
  `notification_email_sent_on` datetime DEFAULT NULL,
  `status` varchar(25) CHARACTER SET utf8 DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  PRIMARY KEY (`score_id`),
  UNIQUE KEY `UNQ_HS` (`client_id`,`year`,`gmail_account_id`),
  KEY `client_id` (`client_id`),
  KEY `gmail_account_id` (`gmail_account_id`),
  CONSTRAINT `sap_client_health_score_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `sap_client` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `sap_client_health_score_ibfk_2` FOREIGN KEY (`gmail_account_id`) REFERENCES `sap_client_account_gmail` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of sap_client_health_score
-- ----------------------------

-- ----------------------------
-- Table structure for sap_client_history
-- ----------------------------
DROP TABLE IF EXISTS `sap_client_history`;
CREATE TABLE `sap_client_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) DEFAULT NULL,
  `name` varchar(80) NOT NULL,
  `status` varchar(40) NOT NULL DEFAULT 'active',
  `sign_on_date` date DEFAULT NULL,
  `launch_date` date DEFAULT NULL,
  `expiration_date` date DEFAULT NULL,
  `contract_goal` int(11) DEFAULT NULL,
  `monthly_goal` int(11) DEFAULT NULL,
  `target_profiles_summary` text,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `client_id` (`client_id`),
  CONSTRAINT `sap_client_history_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `sap_client` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sap_client_history
-- ----------------------------
INSERT INTO `sap_client_history` VALUES ('3', '2', 'Kautzer', 'active', null, null, null, null, null, null, '2018-06-04 22:24:57');
INSERT INTO `sap_client_history` VALUES ('4', '2', 'Kautzer', 'paused', null, null, null, null, null, null, '2018-06-04 22:26:26');
INSERT INTO `sap_client_history` VALUES ('5', '2', 'Kautzer', 'archived', null, null, null, null, null, null, '2018-06-04 22:26:53');

-- ----------------------------
-- Table structure for sap_client_meetings_per_month
-- ----------------------------
DROP TABLE IF EXISTS `sap_client_meetings_per_month`;
CREATE TABLE `sap_client_meetings_per_month` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `year` int(10) NOT NULL DEFAULT '2017',
  `meetings_jan` int(11) NOT NULL DEFAULT '0',
  `meetings_feb` int(11) NOT NULL DEFAULT '0',
  `meetings_mar` int(11) NOT NULL DEFAULT '0',
  `meetings_apr` int(11) NOT NULL DEFAULT '0',
  `meetings_may` int(11) NOT NULL DEFAULT '0',
  `meetings_jun` int(11) NOT NULL DEFAULT '0',
  `meetings_jul` int(11) NOT NULL DEFAULT '0',
  `meetings_aug` int(11) NOT NULL DEFAULT '0',
  `meetings_sep` int(11) NOT NULL DEFAULT '0',
  `meetings_oct` int(11) NOT NULL DEFAULT '0',
  `meetings_nov` int(11) NOT NULL DEFAULT '0',
  `meetings_dec` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `client_id` (`client_id`),
  CONSTRAINT `sap_client_meetings_per_month_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `sap_client` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of sap_client_meetings_per_month
-- ----------------------------

-- ----------------------------
-- Table structure for sap_client_profile
-- ----------------------------
DROP TABLE IF EXISTS `sap_client_profile`;
CREATE TABLE `sap_client_profile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `name` varchar(75) NOT NULL,
  `states` text,
  `countries` text,
  `max_prospects` mediumint(9) DEFAULT NULL,
  `max_prospects_scope` varchar(15) DEFAULT NULL,
  `geotarget` varchar(200) DEFAULT NULL,
  `geotarget_lat` float DEFAULT NULL,
  `geotarget_lng` float DEFAULT NULL,
  `radius` mediumint(9) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `client_id_2` (`client_id`,`name`),
  KEY `client_id` (`client_id`),
  CONSTRAINT `sap_client_profile_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `sap_client` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sap_client_profile
-- ----------------------------

-- ----------------------------
-- Table structure for sap_client_profile_department
-- ----------------------------
DROP TABLE IF EXISTS `sap_client_profile_department`;
CREATE TABLE `sap_client_profile_department` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_profile_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `client_profile_id` (`client_profile_id`),
  KEY `department_id` (`department_id`),
  CONSTRAINT `sap_client_profile_department_ibfk_1` FOREIGN KEY (`client_profile_id`) REFERENCES `sap_client_profile` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `sap_client_profile_department_ibfk_2` FOREIGN KEY (`department_id`) REFERENCES `sap_department` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sap_client_profile_department
-- ----------------------------

-- ----------------------------
-- Table structure for sap_client_profile_title
-- ----------------------------
DROP TABLE IF EXISTS `sap_client_profile_title`;
CREATE TABLE `sap_client_profile_title` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_profile_id` int(11) NOT NULL,
  `title_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `client_profile_id` (`client_profile_id`),
  KEY `title_id` (`title_id`),
  CONSTRAINT `sap_client_profile_title_ibfk_1` FOREIGN KEY (`client_profile_id`) REFERENCES `sap_client_profile` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `sap_client_profile_title_ibfk_2` FOREIGN KEY (`title_id`) REFERENCES `sap_group_title` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sap_client_profile_title
-- ----------------------------

-- ----------------------------
-- Table structure for sap_client_prosperworks
-- ----------------------------
DROP TABLE IF EXISTS `sap_client_prosperworks`;
CREATE TABLE `sap_client_prosperworks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `prosperworks_ext_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `postal_code` varchar(100) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `company_revenue` varchar(80) DEFAULT NULL,
  `number_of_employees` varchar(80) DEFAULT NULL,
  `company_age` varchar(80) DEFAULT NULL,
  `industry` varchar(120) DEFAULT NULL,
  `last_meeting_booked` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1963 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sap_client_prosperworks
-- ----------------------------
INSERT INTO `sap_client_prosperworks` VALUES ('1', '1', 'Testing company', '123 Street', 'new york', 'new york', '12345', 'United States', '124000', '12', '8', 'Textile', '');
INSERT INTO `sap_client_prosperworks` VALUES ('2', '12813006', 'Sapper Consulting, LLC', '8112 Maryland Ave, Ste 400', 'St. Louis, Missouri', 'Missouri', '63105', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('3', '7031876', 'Sapper Consulting, LLC', '8112 Maryland Ave, Ste 400', 'St. Louis, Missouri', 'Missouri', '63105', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('4', '23321605', 'Takadu', '4 Derech Hahoresh', 'Yehud', null, null, 'IL', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('5', '22635777', 'WTB Accounting', '514 Americas Way #6753', 'Box Elder', 'South Dakota', '57719', null, '$1M-$5M', '10-19', null, 'Accounting', null);
INSERT INTO `sap_client_prosperworks` VALUES ('6', '25144048', 'LHI', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('7', '16568867', 'Wintellect LLC', '990 Hammond Drive Building One, Suite 760', 'Atlanta', 'Georgia', '30328', null, '$5M-$10M', '20-49', '18', 'Computer Software', null);
INSERT INTO `sap_client_prosperworks` VALUES ('8', '25025880', 'Amazing Traditions, LLC', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('9', '11439632', 'Hygrade Business Group', '30 Seaview Drive', 'Secaucus', 'New Jersey', '07094', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('10', '24956731', 'Avalon Technologies Inc', null, 'Bodmin', null, 'PL31 2HR', 'GB', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('11', '25027676', 'Rock Town Consulting', '4001 N. Perryville Rd.', 'Loves Park', 'Illinois', '61111', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('12', '24380837', 'M-Files Corporation', null, 'Tampere', 'Western Finland', null, 'FI', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('13', '12750902', 'PowerFilm Solar', '1287 XE Place', 'Ames', 'Iowa', '50014-6304', null, '$5M-$10M', '50-99', '30', 'Electrical/Electronic Manufacturing', null);
INSERT INTO `sap_client_prosperworks` VALUES ('14', '24870888', 'On Top of I.T.', null, 'Tucson', 'Arizona', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('15', '24688379', 'Entasis Asset Management', null, 'Brookfield', 'Wisconsin', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('16', '24641840', 'National PEO LLC', '5745 N. Scottsdale Road', 'Scottsdale', 'Arizona', '85250', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('17', '25182808', 'Good Farms', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('18', '25180494', 'Goji Labs LLC', null, 'Los Angeles', 'California', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('19', '25182494', 'Qwest Credit Enhancement', null, 'Wilmington', 'North Carolina', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('20', '7608163', 'TeamLogic IT of Ft. Myers', '10501 Six Mile Cypress Pkwy, Suite 118', 'Fort Myers', 'Florida', '33966', null, '$50M-$100M', '250-499', '4', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('21', '24689520', 'KPA LLC', '1380 Forest Park Circle, Suite 140', 'Lafayette', 'Colorado', '80026', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('22', '24722316', 'Zelant Software, Inc.', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('23', '25092944', 'Altaflux Corporation', '3250 West Big Beaver Road', 'Troy', 'Michigan', '48084', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('24', '25090762', 'Force Multiplier Ventures', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('25', '23605663', 'Swartzendruber Agency | Colonial Life', '5701 Kentucky Ave N, Ste 209', 'Minneapolis', 'Minnesota', '55428', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('26', '24857789', 'Palo Media Group LLC', '1025 Plain St', 'Marshfield', 'Massachusetts', '02050', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('27', '25086942', 'Wave Analytics Consulting', null, null, null, null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('28', '22403308', 'Graham C. Peck\'s Company', null, 'Chicago', 'Illinois', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('29', '24889657', 'PacerPro', null, 'San Francisco', 'California', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('30', '25120145', 'ProAssisting', null, 'Rochester', 'New York', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('31', '24050529', 'Sharphat', null, 'New York', 'New York', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('32', '25149794', 'VIP Business and Executive Coaching', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('33', '25096272', 'LeadSmith', null, 'Miami Beach', 'Florida', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('34', '25144743', 'RosinCloud Inc.', null, 'Florence', 'Oregon', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('35', '24269096', 'HIBBS ELECTROMECHANICAL , INC.', '1300 Industrial Road', 'Madisonville', 'Kentucky', '42431', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('36', '15985645', 'BaxterKrause Retained Executive Recruiters', '301 Heritage Walk, Suite 105', 'Woodstock', 'Georgia', '30188', null, '$1M-$5M', '5-9', '12', 'Staffing and Recruiting', null);
INSERT INTO `sap_client_prosperworks` VALUES ('37', '25147529', 'Toniq LLC', null, null, 'New York', '10036-7328', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('38', '7394468', 'TeamLogic IT', '26722 Plaza', 'Mission Viejo', 'California', '92691', null, '$50M-$100M', '100-249', '14', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('39', '15933833', 'JumpStart Inc.', '6701 Carnegie Avenue, Suite 100', 'Cleveland', 'Ohio', '44103', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('40', '25147156', 'RingCentral Inc', '20 Davis Drive', 'Belmont', 'California', '94002', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('41', '25089042', 'T.H. Easter Consulting LLC', null, 'Chevy Chase', 'Maryland', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('42', '24968523', 'Bowers & Associates', null, null, 'Saint Louis', null, 'SC', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('43', '24855302', 'Arlex Technologies Inc', null, 'Chicago', 'Illinois', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('44', '23385866', 'MarawanAziz', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('45', '24588956', 'MediaMax Network LLC', null, 'Valhalla', 'New York', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('46', '15305581', 'Sales Xceleration', '10475 Crosspoint Boulevard Suite 250', 'Indianapolis', 'Indiana', '46256', null, '$1M-$5M', '5-9', '7', 'Management Consulting', null);
INSERT INTO `sap_client_prosperworks` VALUES ('47', '24549394', 'YourCFOtoGo', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('48', '24970422', 'Archer Malmo inc', '65 Union Ave', 'Memphis', 'Tennessee', '38103', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('49', '15144942', 'Influence & Co.', null, 'Columbia', 'Missouri', '65201', null, '$25M-$50M', '100-249', '7', 'Marketing and Advertising', null);
INSERT INTO `sap_client_prosperworks` VALUES ('50', '24367202', 'The Asia Group, LLC', '2101 L Street NW, Suite 300', 'Washington', 'District Of Columbia', '20037', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('51', '24636318', 'Eichhorn Printing , Inc.', '109 Beaver Ct # 1', 'Cockysvl Hnt Vly', 'Maryland', '21030-2104', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('52', '23673458', 'New England Staffing', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('53', '25136019', 'TrustSphere Pte. Ltd', '#13-03 Royal Group Building', 'Singapore', 'California', '048693', 'SG', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('54', '24647029', 'Decimal Point Analytics', '5A, B-Wing, Trade Star Building', 'Mumbai', 'Maharashtra', '400059', 'IN', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('55', '24994270', 'SquareWorks', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('56', '9843765', '2W Technologies, INC', '10 South Riverside Plaza', 'Chicago', 'Illinois', '606076', null, '$5M-$10M', '20-49', '33', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('57', '24097586', 'Sterling Sanitary Supply Corp.', '3210 57th St', 'Flushing', 'New York', '11377-1919', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('58', '25119083', 'Cost Containment Strategies', null, 'Fort Lauderdale', 'Florida', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('59', '24956146', 'Brian Cowell', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('60', '25098169', 'CloudScale Corporation', null, 'Los Angeles', 'California', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('61', '25135079', 'Sunline Capital Management', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('62', '24886258', 'Fractional CISO', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('63', '24050020', 'Mapcon', null, 'Johnston', 'Iowa', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('64', '25026051', 'Samex', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('65', '25133930', 'American Carolina Insurance Inc', '213 Three Bridges Rd', 'Greenville', 'South Carolina', '29611', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('66', '23531582', 'Enterprise Systems', '10910 W. Sam Houston Parkway N.', 'Houston', 'Texas', '77064', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('67', '25134604', 'Prosperity Funding , Inc.', '308 W Millbrook Rd, Ste 200', 'Raleigh', 'North Carolina', '27609', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('68', '24995325', 'CORBET CONSULTING LTD', null, 'Houston', 'Texas', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('69', '25122306', 'Qualitech', '30100 Telegraph Rd Ste 387', 'Franklin', 'Michigan', '48025', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('70', '24594298', 'Avitus Group', null, 'Indianapolis', 'Indiana', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('71', '24602281', 'SoftNet Search Partners LLC', null, 'Denver', 'Colorado', '80231', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('72', '25094694', 'Zoom Marketing Partners', null, 'Chapel Hill', 'North Carolina', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('73', '25089355', 'RAHILL Capital', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('74', '24598679', 'Psymaxsolutions', null, 'Cleveland', 'Ohio', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('75', '25123232', 'Boston Portfolio Advisors, Inc.', '800 Corporate Drive', 'Fort Lauderdale', 'Florida', '33334', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('76', '25084949', 'Ohio Indemnity', '250 E Broad St Fl 7', 'Columbus', 'Ohio', '43215', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('77', '25086723', 'MedBillit', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('78', '24705076', 'Rigid Bits', null, 'Denver', 'Colorado', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('79', '25097509', 'Results Driven Marketing, LLC', null, 'Philadelphia', 'Pennsylvania', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('80', '24599538', 'Intuitive Reason', null, 'Jacksonville', 'Florida', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('81', '25086349', 'Bader Insurance Consultants', null, 'Phoenix', 'Arizona', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('82', '15551253', 'BLR Capital Management', '100 Winners Circle, Suite 300', 'Brentwood', 'Tennessee', '37027', null, '$100M-$250M', '500-999', '41', 'Publishing', null);
INSERT INTO `sap_client_prosperworks` VALUES ('83', '22333367', 'The Long Term Care Planning Group', '1000 Circle 75 Parkway SE', 'Atlanta', 'Georgia', '30339', null, '<$500K', '1-4', '7', 'Insurance', null);
INSERT INTO `sap_client_prosperworks` VALUES ('84', '24571913', 'EZ Pay', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('85', '24604531', 'Youtech & Associates Inc', '387 Shuman Blvd', 'Naperville', 'Illinois', '60563', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('86', '24410366', 'Blue Matrix Media', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('87', '25094650', 'Halbert Brothers Garage', null, 'Martin', 'Kentucky', '41649-0000', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('88', '25092654', 'OppGenetix', '1018 Proprietors Road', 'Worthington', 'Ohio', '43085', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('89', '24558521', 'Keith Ellis (Multi Company)', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('90', '24192672', 'VISTX Corporation', '7047 E. Greenway Parkway', 'Scottsdale', 'Arizona', '85254', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('91', '22214812', 'People Driven Solutions', '249 Highway 101 #351', 'Solana Beach', 'California', '92075', null, '$5M-$10M', '20-49', '2', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('92', '24485086', 'View Imaging', '137 Varick St, suite 606', 'New York', 'New York', '10013', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('93', '24600252', 'Freight Saver', '7755 Center Ave', 'Huntington Beach', 'California', '92647', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('94', '24648164', 'Accelerated Innovations', '366 Jackson St', 'Saint Paul', 'Minnesota', '55101', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('95', '15032815', 'TechBlue, Inc.', '322 North Shore Drive', 'Pittsburgh', 'Pennsylvania', '15212', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('96', '24889373', 'The CEO University', 'P.O. Box 370', 'Seal Beach', 'California', '90740', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('97', '24864717', 'Exstratus', '3507 Lakeland Drive', 'Austin', 'Texas', '78731', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('98', '25093984', 'TCE GLOBAL Inc.', null, 'Hurst', 'Texas', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('99', '24872374', 'Devise Interactive', '2400 Main St Suite 202', 'Irvine', 'California', '92614', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('100', '24480965', 'kununu US', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('101', '24973057', 'Ensunet Technology Group', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('102', '24882829', 'Evy Tea LLC', null, 'Boston', 'Massachusetts', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('103', '24590221', 'Hi-Line Inc', '2121 Valley View Lane', 'Dallas', 'Texas', '75234', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('104', '25090565', 'jlBrand Marketing', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('105', '24573626', 'DreamMaker Ventures', null, null, 'New Jersey', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('106', '24730592', 'Fosina Marketing Group , Inc.', null, 'New York', 'New York', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('107', '24641682', 'Fulcrum Financial Group, LLC', null, 'Spokane', 'Washington', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('108', '23282460', 'Integrated Communications', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('109', '24958742', 'Quinox', null, 'Fresno', 'California', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('110', '12137271', 'C3/CustomerContactChannels, Inc.', '1200 South Pine Island Road', 'Plantation', 'Florida', '33324', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('111', '25032894', 'Total Lender Solutions Inc', '10855 Sorrento Valley Rd Ste 102', 'San Diego', 'California', '92121', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('112', '24425260', 'Increase Media', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('113', '24735570', 'GmPly, Inc.', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('114', '24600361', 'Jarhead Marketing', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('115', '25086992', 'Concierge Sales Network', null, 'New York', 'New York', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('116', '25086653', 'Stealth Mode Startup', null, 'San Francisco', 'California', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('117', '24866628', 'Trustmarq Global Services', null, 'South River', 'New Jersey', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('118', '25085792', 'Transportation Insight, LLC', '310 Main Avenue Way SE', 'Hickory', 'North Carolina', '28602', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('119', '24855241', 'TGA Capital Managament', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('120', '24959999', 'Capitol Presence Consulting Group', '8607 Westwood Center Dr #250', 'Vienna', 'Virginia', '22182', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('121', '25085456', 'Reich & Tang', '25 Comly Ave', 'Greenwich', 'Connecticut', '6831', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('122', '24254738', 'ChoiceHR', null, 'Saint Petersburg', 'Florida', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('123', '25027843', 'globalvillageagency', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('124', '19054690', 'ActionBar', 'Tel Aviv area', 'Tel Aviv', null, null, null, null, null, '2', 'Internet', null);
INSERT INTO `sap_client_prosperworks` VALUES ('125', '24479374', 'The Truth in IT', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('126', '24562807', 'Seth & Lucas', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('127', '25001613', 'Lief Hands', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('128', '15305948', 'HEARST COMMUNICATIONS INC. DBA 46MILE', '901 Mission Street', 'San Francisco', 'California', '94117', null, '$5M-$10M', '20-49', '4', 'Marketing and Advertising', null);
INSERT INTO `sap_client_prosperworks` VALUES ('129', '23111821', 'Executive Forums, NJ', '2001 Route 46 East, Suite 310', 'Parsippany', 'New Jersey', '7054', null, '$500K-$1M', '5-9', '21', 'Professional Training & Coaching', null);
INSERT INTO `sap_client_prosperworks` VALUES ('130', '20538741', 'Cureo', '1909 Old Mansfield Road', 'Wooster', 'Ohio', '44691', null, '$5M-$10M', '20-49', '8', 'Internet', null);
INSERT INTO `sap_client_prosperworks` VALUES ('131', '10594531', 'Lighthouse Technologies', '1430 Oak Court, Suite 101', 'Dayton', 'Ohio', '45430', null, '$5M-$10M', '100-249', '18', 'Computer Software', null);
INSERT INTO `sap_client_prosperworks` VALUES ('132', '24886329', 'WeLocals', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('133', '24854804', 'WeLocals', null, 'Brooklyn', 'New York', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('134', '24694780', 'SureFloor', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('135', '24632967', 'Physician Revenue Managament Service', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('136', '24958743', 'ETAP - Operation Technology, Inc.', '17 Goodyear', 'Irvine', 'California', '92618', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('137', '24369478', 'The Automotive Marketing Group', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('138', '15859375', 'Schooley Mitchell', '1030 Erie Street', 'Stratford', 'ON', 'N4Z 0A1', null, '$25M-$50M', '100-249', '14', 'Telecommunications', null);
INSERT INTO `sap_client_prosperworks` VALUES ('139', '24883203', 'Prestige Capital Corporation', '400 Kelby Street, 14th Floor', 'Fort Lee', 'New Jersey', '07024', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('140', '22537307', 'Banyanventures', null, 'Salt Lake', 'Utah', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('141', '24995207', 'HRFix, Inc. | Specializing in Helping Small to Mid-Sized Companies with their HR Needs', '1512 Bray Central', 'McKinney', 'Texas', '75071', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('142', '24993922', 'Capstone Retirement Group, LLC', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('143', '20984172', 'Moo IT', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('144', '24445088', 'Intersoft Group', '26380 Curtiss Wright Parkway', 'Richmond Hts.', 'Ohio', '44143', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('145', '24962160', 'Mindseyetech', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('146', '22939756', 'Oliver Construction Incorporated', null, 'Norristown', 'Pennsylvania', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('147', '24452430', 'NOLA DroneWORX LLC', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('148', '23546355', 'Tribune Online Content', '435 N. Michigan Ave', 'Chicago', 'Illinois', '60611', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('149', '18985401', 'Advaiya Inc', '14575 NE Bel Red Rd,\nSte 201', 'Bellevue', 'Washington', '98005', null, '$10M-$25M', '100-249', '13', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('150', '24958402', 'ETAP', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('151', '23729467', 'Outside Source', null, 'Indianapolis', 'Indiana', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('152', '22638366', 'BT Strategic Media', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('153', '24885402', 'Phelan Design Group LLC', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('154', '22784863', 'Infolio.co', null, 'New York', 'New York', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('155', '24873085', 'IMG Advisors LLC', '5444 Westheimer Road', 'Houston', 'Texas', '77056', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('156', '23482461', 'Securlinx', null, 'Morgantown', 'West Virginia', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('157', '22608046', 'On Shift', '1621 Euclid Avenue, #1500', 'Cleveland', 'Ohio', '44115', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('158', '24648281', 'Interim HR Consulting', '29 East Madison', 'Chicago', 'Illinois', '60602', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('159', '24485666', 'KickFire', '2290 N 1st Street', 'San Jose', 'California', '95131', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('160', '24891091', 'American Cleaning Concepts', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('161', '22838261', 'Enerconnex', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('162', '24599074', 'CIV LED Lighting Solutions, LLC/ CIV Consulting Services, LLC', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('163', '24872270', 'Hausmann Professional Services, L.L.C.', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('164', '24485062', 'Threads Studio', 'Northland', 'Kansas City', 'Missouri', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('165', '24639480', 'SW HR Consulting', null, 'Las Vegas', 'Nevada', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('166', '24855180', 'Lotus Marketing Group / Lotus energy and solar', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('167', '24566874', 'CITI', '7799 Leesburg Pike', 'Falls Church', 'Virginia', '22043', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('168', '24600466', 'Raymond James & Associates , Inc.', '592 Dodge Ave NW', 'Elk River', 'Minnesota', '55330-1919', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('169', '24759781', 'Orbiter', null, 'Tacoma', 'Washington', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('170', '24368053', 'UMS Group , Inc.', 'Joop Geesinkweg 901 - 999', 'Amsterdam', null, '1114 AB', 'NL', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('171', '23865375', 'Sonitrol of Louisville (Western Ky)', null, 'Louisville', 'Kentucky', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('172', '24412255', 'Peak Pro Staffing', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('173', '21707367', 'Breaking Through Consulting, LLC', null, 'Naperville', 'Illinois', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('174', '24873182', 'Sunita manufacturers & Traders (kashay)', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('175', '20277370', 'BOTique', null, 'Newark', 'New Jersey', null, null, null, null, '2', 'Computer Software', null);
INSERT INTO `sap_client_prosperworks` VALUES ('176', '24336978', 'Bluejireh Inc.', null, 'Birmingham', 'Alabama', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('177', '24569175', 'Staff Solutions', '704 Broadway Ave', 'Mattoon', 'Illinois', '61938', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('178', '24422357', 'Furman Roth Advertising', '801 2nd Avenue', 'New York', 'New York', '10017', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('179', '7300792', 'JTP Audit (now Verisave)', '225 South 200 East #140', 'Salt Lake City', 'Utah', '84111', null, '$1M-$5M', '10-19', '16', 'Accounting', null);
INSERT INTO `sap_client_prosperworks` VALUES ('180', '21837187', 'Silicon Valley Risk and Insurance, L', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('181', '14482868', 'IkeGPS', '350 Interlocken Blvd, Suite 390', 'Broomfield', 'Colorado', '80021', null, '$5M-$10M', '50-99', '12', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('182', '8952914', 'Silicon Valley Risk and Insurance, LP (See Wood Guttman)', '226 Airport Parkway, Suite 420', 'San Jose', 'California', '95110', null, null, null, '8', null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('183', '11133634', 'People Driven Solutions International- same as above??', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('184', '10980434', 'Kennion & Co.', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('185', '10705405', 'Lynx Solutions', '919 Garnet Avenue Suite 215', 'San Diego', 'California', '92109', null, '$5M-$10M', '20-49', null, 'Computer Software', null);
INSERT INTO `sap_client_prosperworks` VALUES ('186', '13286621', 'Kablooe Design Inc', '8560 Cottonwood St.', 'Minneapolis', 'Minnesota', '55433', null, '$1M-$5M', '20-49', '27', 'Design', null);
INSERT INTO `sap_client_prosperworks` VALUES ('187', '11800377', 'Dusobox', '1330 Central Florida Parkway', 'Orlando', 'Florida', '32837', null, '$5M-$10M', '20-49', '67', 'Packaging and Containers', null);
INSERT INTO `sap_client_prosperworks` VALUES ('188', '11619233', 'Elect Energy, Inc.', '5068 W. Plano Pkwy', 'Plano', 'Texas', '75093', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('189', '21837189', 'Continuum', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('190', '14592182', 'Valuation Services, Inc.', '3000 Wilson Boulevard\nSuite 220', 'Arlington', 'Virginia', '22201', null, '$1M-$5M', '20-49', '23', 'Financial Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('191', '21837191', 'AM Data', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('192', '7119520', 'Safety Facility Services', '5 West 37th Street', 'New York', 'New York', '10018', null, '$50M-$100M', '250-499', '26', 'Facilities Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('193', '7050306', 'Westmark Management Co', '1720 Louisana Blvd Ne 402', 'Albuquerque', 'New Mexico', '87110', null, '$1M-$5M', null, null, 'Real Estate', null);
INSERT INTO `sap_client_prosperworks` VALUES ('194', '17652541', 'Interactive Touchscreen Solutions, Inc.', '1655 Crofton Blvd, Suite 103', 'Crofton', 'Maryland', '21114', null, '$1M-$5M', '20-49', '19', 'Computer Software', null);
INSERT INTO `sap_client_prosperworks` VALUES ('195', '17538875', 'Beehive Media', '85 Main Street', 'Hopkinton', 'Massachusetts', '1748', null, '$5M-$10M', '20-49', '24', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('196', '21837192', 'Internetwork Experts Corporation', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('197', '13518129', 'Perfect PlanIT', '317 Tiffany Court', 'Gibsonia', 'Pennsylvania', '15044', null, '$1M-$5M', '5-9', '19', 'Marketing and Advertising', null);
INSERT INTO `sap_client_prosperworks` VALUES ('198', '15018291', 'HMGLLC', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('199', '13444411', 'Frylow Sales', null, null, null, null, null, '$5M-$10M', '20-49', '5', 'Food & Beverages', null);
INSERT INTO `sap_client_prosperworks` VALUES ('200', '24016565', 'Analyze My App', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('201', '21629528', 'Sology Solutions', '850 E Arapaho Rd, Suite 210', 'Richardson', 'Texas', '75081', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('202', '24552485', 'V3 Information Management', null, 'Fort Worth', 'Texas', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('203', '23898327', 'Plato Advisors', '270 Madison Ave Fl 19', 'New York', 'New York', '10016', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('204', '24407451', 'Stormwind LLC', null, 'Scottsdale', 'Arizona', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('205', '24700169', 'Bartley Construction, Inc', '226th St', 'Cambria Heights', 'New York', '11411', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('206', '17029738', 'TeamLogic IT of Sacramento', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('207', '16224666', 'B2B CFO®', '3850 E. Baseline Road, No. 105', 'Mesa', 'Arizona', '85206', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('208', '22387593', 'Conquest Recruiting', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('209', '12139339', 'Key Lime Interactive', '8750 NW 36th Street', 'Doral', 'Florida', '33178', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('210', '12139333', 'MulticulturalCX', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('211', '22884331', 'ALMEA Insurance, Inc.', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('212', '24042925', 'Foresight Intelligence, Inc.', '7077 E Marilyn Rd', 'Scottsdale', 'Arizona', '85254', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('213', '24699516', 'ID.me', null, 'Washington', 'District Of Columbia', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('214', '23696031', 'Checkpoint', '1688 Kimberly Rd # 3', 'Twin Falls', 'Idaho', '83301-7300', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('215', '24761969', 'Golf Dev', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('216', '24485577', 'Genworth Financial Inc', null, 'Gurgaon', 'Haryana', null, 'IN', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('217', '24544004', 'Anastoscoaching', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('218', '23205362', 'Hrbutler', '63 Corbins Mill Dr', 'Dublin', 'Ohio', '43017', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('219', '24270138', 'BitCot INC', '16870 W Bernardo Dr #400', 'San Diego', 'California', '92127', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('220', '23385987', 'Northern Bank', null, 'Woburn', null, null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('221', '23722500', 'Suttle Solutions', null, 'Westwood', 'Massachusetts', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('222', '24427072', 'xtDirect, LLC', null, 'Omaha', 'Nebraska', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('223', '24709048', 'Nahai Insurance Services, Inc.', '465 S Beverly Dr, Ste 200', 'Beverly Hills', 'California', '90212-4434', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('224', '23728129', 'John Ryan', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('225', '23963970', 'Reaume Insurance Solutions', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('226', '19376214', 'McFadden/Gavender Advertising , Inc.', '2951 N. Swan Rd., Suite 185', 'Tucson', 'Arizona', '85712', null, '$5M-$10M', '20-49', '18', 'Marketing and Advertising', null);
INSERT INTO `sap_client_prosperworks` VALUES ('227', '18089246', 'Express Employment Professionals', null, 'Orem', 'Utah', null, null, '$1B-$5B', '10,000+', '35', 'Staffing and Recruiting', null);
INSERT INTO `sap_client_prosperworks` VALUES ('228', '24588191', 'PivotalPath', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('229', '24691894', 'Propelmybiz', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('230', '19159653', 'Tripointins', '21C Arts Center Court', 'Avon', 'Connecticut', '6001', null, '$5M-$10M', '20-49', '101', 'Insurance', null);
INSERT INTO `sap_client_prosperworks` VALUES ('231', '24370791', 'TANGOELLA', null, 'Boston', 'Massachusetts', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('232', '24641552', 'Questige', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('233', '19140124', 'NewVector Group', '1936 46th Ave SW, Suite 100', 'Seattle', 'Washington', '98116', null, '$1M-$5M', '5-9', '5', 'Staffing and Recruiting', null);
INSERT INTO `sap_client_prosperworks` VALUES ('234', '24550243', 'MDI Investments Inc', null, null, 'Illinois', '60301', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('235', '7991884', 'CNP Staffing', '33 N. Dearborn Suite 1610', 'Chicago', 'Illinois', '60602', null, '$5M-$10M', '20-49', '12', 'Staffing and Recruiting', null);
INSERT INTO `sap_client_prosperworks` VALUES ('236', '24652275', 'Lorser Industries', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('237', '22789546', 'Amerifi', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('238', '23115589', 'Streamline Realty Funding', '1120 Avenue of the Americas, 4th Floor', 'New York', 'New York', '10036', null, '$5M-$10M', '20-49', null, 'Commercial Real Estate', null);
INSERT INTO `sap_client_prosperworks` VALUES ('239', '24469911', 'HONE Marketing', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('240', '24610339', 'FrameMe.com iPhone App for FrameShops', null, 'Morris Plains', 'New Jersey', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('241', '22167233', 'Signallamp Health , LLC', '321 Spruce Street \nSuite 800', 'Scranton', 'Pennsylvania', '18503', null, '$1M-$5M', '10-19', '3', 'Hospital & Health Care', null);
INSERT INTO `sap_client_prosperworks` VALUES ('242', '11874829', 'X1 Consulting, LLC', '4701 Cox Rd', 'Glen Allen', 'Virginia', '23060', null, '$1M-$5M', '5-9', '4', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('243', '23112156', 'Medman', 'PO Box 5328', 'Boise', 'Idaho', '83705', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('244', '24109600', 'Business Consulting Resources, Inc.', null, null, 'Hawaii', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('245', '7301726', 'Vision 360', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('246', '20751298', 'Technology Partners , Inc.', '707 Spirit 40 Park Drive', 'Chesterfield', 'Missouri', '63005', null, '$50M-$100M', '250-499', '24', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('247', '22462632', 'Fresco Data LLC', '3991 MacArthur Boulevard #400', 'Newport Beach', 'California', '92660', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('248', '24445077', 'Titan Growth', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('249', '13648643', 'TeamLogic IT of Schaumburg, IL', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('250', '21607888', 'TeenLife Media LLC', '77 N. Washington Street, 2nd Fl.', 'Boston', 'Massachusetts', '02114', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('251', '18423173', 'Ballantine', '55 Lane Rd,', 'Fairfield', 'New Jersey', '7004', null, '$1M-$5M', '20-49', '52', 'Marketing and Advertising', null);
INSERT INTO `sap_client_prosperworks` VALUES ('252', '24334523', 'Intuitive TEK', null, 'Denver', 'Colorado', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('253', '23174460', 'Cipher', '2661 Riva Road, Building 1000', 'Annapolis', 'Maryland', '21401', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('254', '24459995', 'CompuSight Corporation', '93 S. Jackson Street', 'Seattle', 'Washington', '98104', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('255', '24330587', 'Hodge, Hart & Schleifer, Inc.', null, 'Chevy Chase', 'Maryland', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('256', '24175007', 'ConDati, Inc.', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('257', '22106033', 'IvyLead', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('258', '24098028', 'Rippler Revenue', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('259', '6990373', 'RetroFit Technologies, Inc.', '455 Fortune Boulevard', 'Milford', 'Massachusetts', '01757', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('260', '8853563', 'Blue Wheel Media', '330 Hamilton Row, Suite 330', 'Birmingham', 'Michigan', '48009', null, '$5M-$10M', '20-49', '7', 'Marketing and Advertising', null);
INSERT INTO `sap_client_prosperworks` VALUES ('261', '8578281', 'Land Shark Shredding, LLC', '1017 Shive Ln, Ste A', 'Bowling Green', 'Kentucky', '42103', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('262', '7708392', 'The Wolff Company', null, null, null, null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('263', '7114229', 'VoiceFriend', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('264', '7300071', 'Cailean CPA', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('265', '7119557', 'KaJ Labs', null, 'Minnesota City', 'Minnesota', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('266', '7300746', 'Mind and Media', '901 N Pitt St, Ste 310', 'Alexandria', 'Virginia', '22314', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('267', '6998849', 'EDC Group', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('268', '6990610', 'WingSwept', '800 Benson Rd', 'Garner', 'North Carolina', '27529', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('269', '7971844', 'HJ3 Composite Technologies', '2440 W. Majestic Park Way', 'Tucson', 'Arizona', '87505', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('270', '6990311', 'Dorado Systems Inc', '30 Washington Avenue Suite D', 'Haddonfield', 'New Jersey', '08033', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('271', '7300326', 'We Got Lites', '360 Industrial Loop', 'Staten Island', 'New York', '10309', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('272', '8578292', 'FinGlobe', '200 S Church St', 'Schaefferstown', 'Pennsylvania', '17088', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('273', '6998783', 'Orion Tech', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('274', '7119497', 'Wyant Computer Services', '1760 Forest Ridge Dr, Ste A', 'Traverse City', 'Michigan', '49686', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('275', '8134503', 'Sprinklermatic Fire Protection Systems Inc.', '4740 Davie Road', 'Davie', 'Florida', '33314', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('276', '7890182', 'Salestactix', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('277', '7300641', 'NarraSoft', '.', 'Cary', 'North Carolina', '27518', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('278', '8134441', 'Norton Staffing, Inc', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('279', '24097988', 'PAX Financial Group, LLC', null, 'San Antonio', 'Texas', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('280', '24330484', 'RISE Global Solutions LLC', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('281', '24412296', 'Field Waldo Insurance Agencies', '1016 Niles Cortland Rd NE', 'Warren', 'Ohio', '44484-1005', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('282', '24098934', 'Cherry', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('283', '22821160', 'Smart Energy Water', '4700 New Horizon Boulevard', 'Bakersfield', 'California', '93303', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('284', '24175398', 'FORT Systems, Inc', null, 'San Francisco', 'California', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('285', '24555297', 'Logical Green Solutions LLC', null, 'Waukesha', 'Wisconsin', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('286', '24108196', 'Carbonsys', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('287', '23133182', 'XPRO Supply', '360 Quecreek Circle', 'Smyrna', 'Tennessee', '37167', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('288', '24411368', 'MobileSmith Inc', '5400 Trinity Road', 'Raleigh', 'North Carolina', '27607', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('289', '22613043', 'Nexgen, Inc', null, 'San Diego', 'California', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('290', '23670421', 'Chimera Innovations, LLC', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('291', '24481200', 'Integrated Coverage Group', null, 'New York', 'New York', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('292', '7119568', 'MARQUIS', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('293', '20817015', 'Xumulus, Inc.', '8 West Campbell Street', 'Arlington Heights', 'Illinois', '60005', null, null, null, '9', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('294', '23486715', 'Confidence Coach', null, 'Hillsboro', 'Oregon', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('295', '19658010', 'Perfect Video Conferencing', '4065 Watts St, 2nd Floor', 'Emeryville', 'California', '94608', null, '$5M-$10M', '20-49', '9', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('296', '15858439', 'VitalPoint', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('297', '7301576', 'Stack FM', '812 N. Sierra Bonita Avenue #200', 'Los Angeles', 'California', '90046', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('298', '23783822', 'Versant Medical Physics and Radiation Safety', '116 S. Riverview Dr.', 'Kalamazoo', 'Michigan', '49004', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('299', '7119465', 'Rkiaccounting', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('300', '7300683', 'Decisive Data', '4116 148th Ave NE, Bldg G', 'Redmond', 'Washington', '98052', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('301', '23887255', 'Brookwood Associates LLC', '3575 Piedmont Rd Ne 15-820', 'Atlanta', 'Georgia', '30305', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('302', '23485304', 'The Fortune Group LLC', null, 'St. Louis', 'Missouri', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('303', '24103071', 'Rauch?Heim Commercial Real Estate LLC', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('304', '23284374', 'Ekhosoft', '7005 Taschereau Blvd', 'Brossard', 'Quebec', 'J4Z 1A7', 'CA', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('305', '19658029', 'GMH Ventures', '10 Campus Boulevard', 'Newtown Square', 'Pennsylvania', '19073', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('306', '7973260', 'Safe Rack', null, 'Sumter', 'South Carolina', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('307', '16600172', 'The Inman Company', '325 East Paces Ferry Rd', 'Atlanta', 'Georgia', '30305', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('308', '19594998', 'Canyon Pipeline Construction, Inc.', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('309', '16330933', 'Jerry\'s Hats', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('310', '9866958', 'Centeric, Inc', '10620 West 87th Street', 'Overland Park', 'Kansas', '66214', null, null, '20-49', null, 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('311', '13037299', 'Kirchner Private Capital Group', 'P.O. Box 977', 'Gadsden', 'Alabama', '35902', null, '$5M-$10M', '20-49', '33', 'Venture Capital & Private Equity', null);
INSERT INTO `sap_client_prosperworks` VALUES ('312', '12752772', 'Rudish Health Solutions, LLC', null, 'Boca Raton', 'Florida', null, null, '$5M-$10M', '20-49', '4', 'Management Consulting', null);
INSERT INTO `sap_client_prosperworks` VALUES ('313', '11576786', 'Dallas Courier Service, Inc', null, 'Dallas', 'Texas', null, null, '$1M-$5M', '10-19', '35', 'Transportation/Trucking/Railroad', null);
INSERT INTO `sap_client_prosperworks` VALUES ('314', '8190147', 'TenisiTech', null, 'San Jose', 'California', null, null, null, null, '6', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('315', '24124056', 'TouchPoint One', '101 W Ohio St, Suite 2000', 'Indianapolis', 'Indiana', '46204', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('316', '19139875', 'Madison Avenue Marketing Group', '1600 Madison Ave, Fl 4th', 'Toledo', 'Ohio', '43604', null, '$1M-$5M', '10-19', '29', 'Marketing and Advertising', null);
INSERT INTO `sap_client_prosperworks` VALUES ('317', '22855045', 'Unearthcampaigns', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('318', '23385973', 'Charter Financial Group', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('319', '23485274', 'Osmworldwide', '651 Supreme Drive', 'Bensenville', 'Illinois', '60106', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('320', '21243553', 'Managed Methods Inc', '719 Walnut St', 'Boulder', 'Colorado', '80302', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('321', '23508074', 'Information & Technology Management , Inc.', '6 Kilmer Road', 'Edison', 'New Jersey', '08817', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('322', '22281496', 'Interphase Systems', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('323', '24047106', 'Compete Marketing Group', null, 'San Diego', 'California', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('324', '24109651', 'SmartChoice Renewables', null, 'Saint George', 'Utah', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('325', '24332324', 'Swenson He', null, 'Marina Del Rey', 'California', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('326', '24178773', 'Ellinger Riggs Insurance', '813 Westfield Rd', 'Noblesville', 'Indiana', '46062-8901', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('327', '24328789', 'Lee Tilford Agency', null, 'Austin', 'Texas', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('328', '23517493', 'Alldyn', null, 'San Francisco', 'California', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('329', '24347517', 'GCG Financial Inc', 'Three Parkway North', 'Deerfield', 'Illinois', '60015-2567', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('330', '24105717', 'ClubBRG (Business Resource Group)', '2885 Sanford Avenue SW #41039', 'Grandville', 'Michigan', '49418-9416', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('331', '21020684', 'InXpress Ltd', '5 Blueberry Business Park', 'Rochdale', 'Lancashire', 'OL16 5AF', null, '$100M-$250M', '500-999', '19', 'Package/Freight Delivery', null);
INSERT INTO `sap_client_prosperworks` VALUES ('332', '22941476', 'HR Value Partners', '5802 Washington Ave, Ste. 201', 'Mount Pleasant', 'Wisconsin', '53406', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('333', '22027315', 'Advantage Performance Group', null, 'Fort Lauderdale', 'Florida', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('334', '23670137', 'Project One', null, 'New York', 'New York', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('335', '23831826', 'BlueIQ', '470 N 500 W', 'Bountiful', 'Utah', '84010', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('336', '23606759', 'Intervision', null, 'Santa Monica', 'California', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('337', '23270949', 'The Barnes Agency', '500 Corporate Center Dr # 515', 'Scott Depot', 'West Virginia', '25560', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('338', '23274021', 'VSI Global, LLC', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('339', '23885235', 'Luna360', '8935 North Meridian St.', 'Indianapolis', 'Indiana', '46260', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('340', '23650844', 'SKW & Assoc.', '6060 N. Central Expressway\nSuite 500', 'Dallas', 'Texas', '75206', null, null, null, '3', 'Management Consulting', null);
INSERT INTO `sap_client_prosperworks` VALUES ('341', '23961855', 'ALLJANI INC', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('342', '24172441', 'HUNTER Digital', '5 Harbor Park Drive', 'Port Washington', 'New York', '11050', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('343', '23402220', 'Resource 1', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('344', '22071137', 'TalentStream', 'P.O. Box 9638', 'Greenville', 'South Carolina', '29604', null, '$5M-$10M', '20-49', '5', 'Staffing and Recruiting', null);
INSERT INTO `sap_client_prosperworks` VALUES ('345', '24010712', 'CPM Solutions', null, 'Colorado Springs', 'Colorado', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('346', '23961149', 'EPMA, Inc', null, 'Houston', 'Texas', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('347', '20859852', 'Engineered Tax Services, Inc', '303 Evernia Street', 'West Palm Beach', 'Florida', '33401', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('348', '21531116', 'Triple E Partners', '222 E 14th Street', 'Cincinnati', 'Ohio', '45202', null, '$1M-$5M', '50-99', null, 'Staffing and Recruiting', null);
INSERT INTO `sap_client_prosperworks` VALUES ('349', '22788388', 'Savethedate', '429 Greenwich St Apt 9a', 'New York', 'New York', '10013', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('350', '23010352', 'Trusthcs', '2042 South Brentwood', 'Springfield', 'Missouri', '65804', null, '$50M-$100M', '250-499', '8', 'Hospital & Health Care', null);
INSERT INTO `sap_client_prosperworks` VALUES ('351', '21359688', 'McGovern & Greene LLP', '200 W. Jackson Blvd.', 'Chicago', 'Illinois', '60606', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('352', '16011163', 'YYAnne Virtual Desktop Services', '10242 NW 47th Street.\nSuite. 19', 'Sunrise', 'Florida', '33351', null, '$1M-$5M', '10-19', '1', 'Staffing and Recruiting', null);
INSERT INTO `sap_client_prosperworks` VALUES ('353', '18993977', 'Yes Solar Solutions', '202 N Dixon Ave', 'Cary', 'North Carolina', '27513', null, '$1M-$5M', '10-19', '9', 'Renewables & Environment', null);
INSERT INTO `sap_client_prosperworks` VALUES ('354', '7828824', 'Xinnovation', '51 Melcher Street Floor 1', 'Boston', 'Massachusetts', '2210', null, '$1M-$5M', '20-49', '16', 'Computer Software', null);
INSERT INTO `sap_client_prosperworks` VALUES ('355', '8867099', 'Xcellerated Solutions', 'P.O. Box 372', 'Kaysville', 'Utah', '84037', null, '$1M-$5M', '5-9', null, 'Computer Software', null);
INSERT INTO `sap_client_prosperworks` VALUES ('356', '19983997', 'Xceed Solutions, Inc.', '4240 Duncan Avenue,\nSuite 200', 'St. Louis', 'Missouri', '63110', null, '$5M-$10M', '20-49', '3', 'Computer Software', null);
INSERT INTO `sap_client_prosperworks` VALUES ('357', '14348463', 'Work Titan, LLC', '550 Pekin St', 'Lincoln', 'Illinois', '62656', null, '$1M-$5M', '10-19', '2', 'Human Resources', null);
INSERT INTO `sap_client_prosperworks` VALUES ('358', '12322816', 'Wood Gutmann & Bogart Insurance Brokers', '15901 Red Hill Avenue, Suite 100', 'Tustin', 'California', '92780', null, '$25M-$50M', '100-249', '33', 'Insurance', null);
INSERT INTO `sap_client_prosperworks` VALUES ('359', '20284661', 'WJM Associates Inc', '165 Broadway, Suite 2301', 'New York', 'New York', '10006', null, '$25M-$50M', '100-249', '22', 'Management Consulting', null);
INSERT INTO `sap_client_prosperworks` VALUES ('360', '6986691', 'WinMill Software', '420 Lexington Avenue Suite 455', 'New York', 'New York', '10170', null, '$5M-$10M', '100-249', '24', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('361', '21287100', 'Westlake Risk & Insurance Services, Inc', '2659 Townsgate Rd', 'Westlake Village', 'California', '91361', null, '$1M-$5M', '5-9', null, 'Insurance', null);
INSERT INTO `sap_client_prosperworks` VALUES ('362', '19339561', 'WEBLEY SYSTEMS INC.', '3000 Lakeside Dr.', 'Bannockburn', 'Illinois', '60015', null, '$1M-$5M', '20-49', '21', 'Telecommunications', null);
INSERT INTO `sap_client_prosperworks` VALUES ('363', '13095798', 'Wattsmedia Inc', '101 Yesler Way Suite 401', 'Seattle', 'Washington', '98104', null, '$5M-$10M', '20-49', '17', 'Media Production', null);
INSERT INTO `sap_client_prosperworks` VALUES ('364', '16519640', 'Waste Consultants, Inc.', '140 Appalachian St', 'Boone', 'North Carolina', '28607', null, '$1M-$5M', '10-19', '16', 'Environmental Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('365', '19920448', 'Visual Workforce', '6800 Paragon Place, Suite 100', 'Richmond', 'Virginia', '23230', null, '$1M-$5M', '10-19', '1', 'Human Resources', null);
INSERT INTO `sap_client_prosperworks` VALUES ('366', '11630537', 'VIE Healthcare Analytics & Advisory', '1973 Route 34, Suite 3', 'Wall', 'New Jersey', '7719', null, '$1M-$5M', '20-49', '19', 'Hospital & Health Care', null);
INSERT INTO `sap_client_prosperworks` VALUES ('367', '22332851', 'Vest Financial Group', '655 Madison Avenue, 3rd Floor', 'New York', 'New York', '10065', null, null, null, '2', 'Financial Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('368', '21408543', 'Vertical Elevation', '8662 Pawnee Rd', 'Parker', 'Colorado', '80134', null, '$1M-$5M', '5-9', '9', 'Staffing and Recruiting', null);
INSERT INTO `sap_client_prosperworks` VALUES ('369', '20622561', 'Vat It', null, 'Norfolk', 'Virginia', null, null, null, null, '18', 'Financial Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('370', '17705486', 'Varazo, Inc.', '2635 North 1st St., Suite 242', 'San Jose', 'California', '95134', null, '$1M-$5M', '20-49', '13', 'Marketing and Advertising', null);
INSERT INTO `sap_client_prosperworks` VALUES ('371', '13395872', 'Utcainc', '1350 Main Street', 'Springfield', 'Massachusetts', '1103', null, '$5M-$10M', '20-49', '28', 'Human Resources', null);
INSERT INTO `sap_client_prosperworks` VALUES ('372', '15934711', 'Universal Atlantic Systems Inc', '45 West Industrial Boulevard', 'Paoli', 'Pennsylvania', '19301', null, '$5M-$10M', '100-249', '46', 'Security and Investigations', null);
INSERT INTO `sap_client_prosperworks` VALUES ('373', '20209098', 'Twisthink, LLC', '43 East 8th Street', 'Holland', 'Michigan', '49423', null, '$1M-$5M', '20-49', '17', 'Design', null);
INSERT INTO `sap_client_prosperworks` VALUES ('374', '8209511', 'TrueIT LLC', null, '745 31ST Avenue East, \nSuite 120', 'North Dakota', '58078', null, '$1M-$5M', '20-49', '6', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('375', '17420577', 'TravelStore Inc', '11601 Wilshire Blvd', 'Los Angeles', 'California', '90025', null, '$25M-$50M', '250-499', '43', 'Leisure, Travel & Tourism', null);
INSERT INTO `sap_client_prosperworks` VALUES ('376', '14650221', 'Traction Matters', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('377', '11466678', 'Titus Talent Strategies', '309 N Water Street', 'Milwaukee', 'Wisconsin', '53202', null, '$25M-$50M', '100-249', '17', 'Management Consulting', null);
INSERT INTO `sap_client_prosperworks` VALUES ('378', '20233770', 'Timeline', '911 Washington Ave', 'St. Louis', 'Missouri', '63101', null, null, null, '1', 'Marketing and Advertising', null);
INSERT INTO `sap_client_prosperworks` VALUES ('379', '20527935', 'Thinc Strategy', '101 S. Water Street, Unit #2', 'Wilmington', 'North Carolina', '28401', null, '$5M-$10M', '20-49', '5', 'Management Consulting', null);
INSERT INTO `sap_client_prosperworks` VALUES ('380', '12040193', 'The Trinity Design Group, LLC', '1107 Dowzer Avenue', 'Pell City', 'Alabama', '35125', null, '$25M-$50M', '100-249', '14', 'Environmental Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('381', '7054408', 'The Silk Initiative', null, 'Shanghai', null, null, null, '<$500K', '1-4', '4', 'Management Consulting', null);
INSERT INTO `sap_client_prosperworks` VALUES ('382', '10282222', 'The Northlake Partners', '22635 NE Marketplace Drive', 'Redmond', 'Washington', '98053', null, '$1M-$5M', '5-9', '10', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('383', '17537428', 'The New Flat Rate, Inc.', '404 McGhee Drive', 'Dalton', 'Georgia', '30721', null, '$1M-$5M', '5-9', '8', 'Management Consulting', null);
INSERT INTO `sap_client_prosperworks` VALUES ('384', '18050339', 'The Myerson Agency, Inc.', '11835 W. Olympic Blvd., Suite 465E', 'Los Angeles', 'California', '90064', null, '$1M-$5M', '5-9', '19', 'Financial Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('385', '20284616', 'The Lavazza Company', null, 'Torino', null, null, null, '$500M-$1B', '1,000-4,999', '123', 'Food & Beverages', null);
INSERT INTO `sap_client_prosperworks` VALUES ('386', '20399242', 'The Kodiak Group Inc', '10200 N. Rodney Parham Rd', 'Little Rock', 'Arkansas', '72227', null, '$5M-$10M', '20-49', null, 'Management Consulting', null);
INSERT INTO `sap_client_prosperworks` VALUES ('387', '14067544', 'The Four Group LLC', null, 'Houston', 'Texas', null, null, '$1M-$5M', '5-9', '4', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('388', '21126183', 'The Baer Group LLC', '100 Ashford Center N\nSuite 460', 'Atlanta', 'Georgia', '30338', null, '$25M-$50M', '100-249', '21', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('389', '17010519', 'Tex-Trude L.P', '2001 Sheldon Rd', 'Channelview', 'Texas', '77530', null, '$5M-$10M', '20-49', null, 'Plastics', null);
INSERT INTO `sap_client_prosperworks` VALUES ('390', '18587662', 'Telliant Systems, LLC', '3180 North Point Parkway\nSuite 108', 'Alpharetta', 'Georgia', '30005', null, '$25M-$50M', '100-249', '8', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('391', '22571995', 'Tell and Train', null, 'Rancho Santa Margarita', 'California', null, null, null, null, '5', 'Marketing and Advertising', null);
INSERT INTO `sap_client_prosperworks` VALUES ('392', '18705743', 'Technijian Inc', '18 Technology Drive', 'Irvine', 'California', '92618', null, '$1M-$5M', '20-49', '17', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('393', '12654184', 'Tech Squad, Inc.', '616 Central Ave S', 'Tifton', 'Georgia', '31794', null, '$1M-$5M', '5-9', '4', 'Computer & Network Security', null);
INSERT INTO `sap_client_prosperworks` VALUES ('394', '20528677', 'Tec Services Consulting Inc.', '1620 Pebblewood Lane\nSuite 270', 'Naperville', 'Illinois', '60563', null, '$5M-$10M', '20-49', '27', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('395', '16606699', 'TeamLogic IT of Wyckoff', '45 N. Broad Street', 'Ridgewood', 'New Jersey', '7450', null, '$50M-$100M', '250-499', '14', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('396', '19041687', 'TeamLogic IT of Winston Salem', '1100 South Stratford Road, Bldg C, Suite 190', 'Winston-Salem', 'North Carolina', '27103', null, '$50M-$100M', '250-499', '14', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('397', '14947740', 'TeamLogic IT of San Jose', null, 'San Jose', 'California', null, null, '$50M-$100M', '250-499', '14', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('398', '14065613', 'TeamLogic IT of San Diego', '9089 Clairemont Mesa Blvd., Suite 105', 'San Diego', 'California', '92123', null, '$50M-$100M', '250-499', '14', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('399', '14892497', 'TeamLogic IT of Rockwall, TX', '500 Turtle Cove Blvd., Suite 130', 'Rockwell', 'Texas', '75087', null, '$50M-$100M', '250-499', '14', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('400', '18267814', 'TeamLogic IT of Phoenix', '99 E Virginia Ave #255', 'Phoenix', 'Arizona', '85004', null, '$50M-$100M', '250-499', '14', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('401', '7410033', 'TeamLogic IT of Naples, FL', '1016 Collier Center Way, Suite 105', 'Naples', 'Florida', '34110', null, '$50M-$100M', '250-499', '8', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('402', '14718607', 'TeamLogic IT of Naperville, IL', '1240 Iroquois Avenue, Suite 204', 'Naperville', 'Illinois', '60563', null, '$50M-$100M', '250-499', '14', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('403', '7410168', 'TeamLogic IT of Morristown, NJ', '7 Campus Drive, Suite 150', 'Parsippany', 'New Jersey', '7054', null, '$50M-$100M', '250-499', '7', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('404', '14262880', 'TeamLogic IT of Houston Texas', '11511 Katy Fwy, Suite 409', 'Houston', 'Texas', '77079', null, '$50M-$100M', '250-499', '14', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('405', '13944426', 'TeamLogic IT of Houston Bay Area', '721 E. Texas Avenue', 'Baytown', 'Texas', '77520', null, '$50M-$100M', '250-499', '14', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('406', '13845729', 'TeamLogic IT of Draper, Utah', null, 'Draper', 'Utah', null, null, '$50M-$100M', '250-499', '14', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('407', '8139894', 'TeamLogic IT of Des Moines, Iowa', '102 Southeast 30th Street #2,', 'Ankeny', 'Iowa', '50021', null, '$50M-$100M', '250-499', '14', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('408', '7394621', 'TeamLogic IT of Columbia SC', '810 Dutch Square Blvd, Suite 234', 'Columbia', 'South Carolina', '29210', null, '$50M-$100M', '250-499', '14', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('409', '16232567', 'TeamLogic IT of Canton', '42180 Ford Road, Suite 250', 'Canton', 'Michigan', '48187', null, '$50M-$100M', '250-499', '14', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('410', '20539184', 'TeamLogic IT of Baltimore, Maryland', '8441 Belair Rd., Suite 201', 'North Baltimore', 'Maryland', '21236', null, '$50M-$100M', '250-499', '14', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('411', '18249154', 'TeamLogic IT of Ashburn', '45240 Business Court Suite 140', 'Sterling', 'Virginia', '20166', null, '$50M-$100M', '250-499', '14', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('412', '18358035', 'TeamLogic IT', '26722 Plaza', 'Mission Viejo', 'California', '92691', null, '$50M-$100M', '250-499', '14', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('413', '13510319', 'Team Logic IT of North Milwaukee', 'W175N11081 Stonewood Dr Suite 102', 'Germantown', 'Wisconsin', '53022', null, '$50M-$100M', '250-499', '14', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('414', '13123429', 'Team Logic IT - Northridge', '5850 Canoga Ave 4', 'Woodland Hills', 'California', '91367', null, '$50M-$100M', '250-499', '14', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('415', '19145098', 'TDA Group - Integrated Content Marketing', '3 Lagoon Drive', 'Redwood City', 'California', '94065', null, '$5M-$10M', '20-49', '31', 'Marketing and Advertising', null);
INSERT INTO `sap_client_prosperworks` VALUES ('416', '16773210', 'TCLogic LLC', '429 N Pennsylvania Suite 300', 'Indianapolis', 'Indiana', '46204', null, '$1M-$5M', '5-9', '21', 'Computer Software', null);
INSERT INTO `sap_client_prosperworks` VALUES ('417', '22178180', 'Tailwind Voice and Data', '3500 Holly Lane North Suite 10', 'Plymouth', 'Minnesota', '55447', null, '$10M-$25M', '100-249', '13', 'Telecommunications', null);
INSERT INTO `sap_client_prosperworks` VALUES ('418', '22603349', 'Systrangroup', '5F. STX R&S Center, 163 Yangjaecheon-Ro, Gangnam-Gu', 'SEOUL', null, '135-855', null, '$25M-$50M', '100-249', '50', 'Computer Software', null);
INSERT INTO `sap_client_prosperworks` VALUES ('419', '8257293', 'Systemadix Technologies, LLC', '122 East Patrick Street, Suite 120', 'Frederick', 'Maryland', '21701', null, '$5M-$10M', '20-49', '14', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('420', '18593983', 'Superior Office Systems', '49 West 37th Street', 'New York', 'New York', '10018', null, '$10M-$25M', '100-249', '19', 'Business Supplies and Equipment', null);
INSERT INTO `sap_client_prosperworks` VALUES ('421', '15470315', 'Sullivan and Cogliano, Inc.', '4 Lan Drive', 'Westford', 'Massachusetts', '1886', null, '$10M-$25M', '100-249', '52', 'Staffing and Recruiting', null);
INSERT INTO `sap_client_prosperworks` VALUES ('422', '20815126', 'Stymulus Industries Inc.', '80 Orville Drive, Suite 100, Room 202', 'Bohemia', 'New York', '11716', null, '$1M-$5M', '10-19', '6', 'Electrical/Electronic Manufacturing', null);
INSERT INTO `sap_client_prosperworks` VALUES ('423', '21362909', 'Strelcheck and Associates Inc', '1009 W Glen Oaks Ln #211', 'Mequon', 'Wisconsin', '53092', null, '$5M-$10M', '20-49', '30', 'Staffing and Recruiting', null);
INSERT INTO `sap_client_prosperworks` VALUES ('424', '20285709', 'Strategic Solutions NW LLC', '11200 SW Allen Blvd.', 'Beaverton', 'Oregon', '97005', null, '$5M-$10M', '20-49', '16', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('425', '20945276', 'Stirling Technologies', '1 Mount Vernon St, Ste 302', 'Winchester', 'Massachusetts', '1890', null, '$1M-$5M', '5-9', '10', 'Internet', null);
INSERT INTO `sap_client_prosperworks` VALUES ('426', '15987051', 'Standing Partnership', '1610 Des Peres Road Suite 200', 'St. Louis', 'Missouri', '63131', null, '$1M-$5M', '20-49', '27', 'Marketing and Advertising', null);
INSERT INTO `sap_client_prosperworks` VALUES ('427', '8336413', 'Stand Up Pouches', '159 Crocker Park Blvd, 4th Floor', 'Westlake', 'Ohio', '44145', null, '$5M-$10M', '20-49', '11', 'Packaging and Containers', null);
INSERT INTO `sap_client_prosperworks` VALUES ('428', '21027710', 'ST Media Group International Inc', '11262 Cornell Park Drive', 'Cincinnati', 'Ohio', '45242', null, '$25M-$50M', '100-249', '112', 'Publishing', null);
INSERT INTO `sap_client_prosperworks` VALUES ('429', '10713308', 'Spokephone', null, 'Auckland', null, null, null, null, null, '2', 'Telecommunications', null);
INSERT INTO `sap_client_prosperworks` VALUES ('430', '20438473', 'Spend Management Partners', '123 Nieman Street', 'Sunman', 'Indiana', '47041', null, null, null, '85', 'Telecommunications', null);
INSERT INTO `sap_client_prosperworks` VALUES ('431', '22728551', 'Speed and Function', '1243 S 7th St', 'Philadelphia', 'Pennsylvania', '19147', null, '$10M-$25M', '50-99', '12', 'Internet', null);
INSERT INTO `sap_client_prosperworks` VALUES ('432', '16500413', 'Spectrum Virtual', '35 Thorpe Ave Ste 107', 'Wallingford', 'Connecticut', '6492', null, '$5M-$10M', '20-49', '5', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('433', '20340729', 'Source Logistics', '812 Union Street', 'Montebello', 'California', '90640', null, '$25M-$50M', '100-249', '19', 'Logistics and Supply Chain', null);
INSERT INTO `sap_client_prosperworks` VALUES ('434', '8906528', 'SmartProcure', '700 W. Hillsboro Blvd Suite 4-100', 'Deerfield Beach', 'Florida', '33441', null, '$25M-$50M', '100-249', '7', 'Information Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('435', '23255271', 'Six Disciplines', '1219 West Main Cross, Suite 205', 'Findlay', 'Ohio', '45840', null, '$1M-$5M', '20-49', '17', 'Management Consulting', null);
INSERT INTO `sap_client_prosperworks` VALUES ('436', '20676031', 'Sirius Solutions', '1233 West Loop South', 'Houston', 'Texas', '77027', null, '$25M-$50M', '250-499', '20', 'Management Consulting', null);
INSERT INTO `sap_client_prosperworks` VALUES ('437', '7190152', 'ServerSide, Inc.', '10150 Lantern Road Suite 275', 'Fishers', 'Indiana', '46037', null, '$1M-$5M', null, '19', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('438', '11441382', 'SEO Inc', '5841 Edison Place', 'Carlsbad', 'California', '92008', null, null, null, '21', 'Marketing and Advertising', null);
INSERT INTO `sap_client_prosperworks` VALUES ('439', '7018268', 'SeeLevel HX', '1718 Peachtree St. Suite 550', 'Atlanta', 'Georgia', '30309', null, '$25M-$50M', '100-249', null, 'Market Research', null);
INSERT INTO `sap_client_prosperworks` VALUES ('440', '22728922', 'Scoperecruiting', '3001 9th Ave SW, Suite 205A', 'Huntsville', 'Alabama', '35805', null, null, null, null, 'Staffing and Recruiting', null);
INSERT INTO `sap_client_prosperworks` VALUES ('441', '19628904', 'Satori Energy', '300 S. Wacker Dr.', 'Chicago', 'Illinois', '60606', null, '$5M-$10M', '20-49', '12', 'Oil & Energy', null);
INSERT INTO `sap_client_prosperworks` VALUES ('442', '14174941', 'Sandler Training', '300 Red Brook Blvd', 'Baltimore', 'Maryland', '21117', null, null, null, '51', 'Professional Training & Coaching', null);
INSERT INTO `sap_client_prosperworks` VALUES ('443', '13167148', 'Salient Process Inc', '3031 F St Suite 101', 'Sacramento', 'California', '95816', null, '$5M-$10M', '20-49', '7', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('444', '14772086', 'Safe Harbors Travel Group, Inc.', '126 S. Main Street', 'Bel Air', 'Maryland', '21014', null, '$5M-$10M', '20-49', '33', 'Leisure, Travel & Tourism', null);
INSERT INTO `sap_client_prosperworks` VALUES ('445', '16406825', 'Ryan Kovach Advertising\'s Company', '112 NW 24th St. Suite 120-1', 'Fort Worth', 'Texas', '76164', null, null, null, null, 'Marketing and Advertising', null);
INSERT INTO `sap_client_prosperworks` VALUES ('446', '19588078', 'RPI Consultants', '101 N Haven St', 'Baltimore', 'Maryland', '21224', null, '$10M-$25M', '100-249', '19', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('447', '16365121', 'Royal Alliances', '8600 Freeport Pkwy', 'Irving', 'Texas', '75063', null, '$1M-$5M', '5-9', '6', 'Computer Software', null);
INSERT INTO `sap_client_prosperworks` VALUES ('448', '16707197', 'RiverRoad Waste Solutions, Inc.', '106 Apple Street, Suite 225', 'Tinton Falls', 'New Jersey', '7724', null, '$50M-$100M', '100-249', '14', 'Environmental Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('449', '16707203', 'River Road Waste Solutions, Inc. (Same as Below)', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('450', '16567453', 'RINA Systems, LLC', '8180 Corporate Park Dr', 'Cincinnati', 'Ohio', '45242', null, '$5M-$10M', '20-49', '24', 'Computer Software', null);
INSERT INTO `sap_client_prosperworks` VALUES ('451', '10378020', 'Right Height', '1590 S Lewis St', 'Anaheim', 'California', '92805-6423', null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('452', '15467731', 'Rhenium Capital', '1030 NE 11th Ave, Suite 305', 'Fort Lauderdale', 'Florida', '33304', null, '$1M-$5M', '10-19', '3', 'Real Estate', null);
INSERT INTO `sap_client_prosperworks` VALUES ('453', '7890176', 'Rev1 Ventures', '1275 Kinnear Road', 'Columbus', 'Ohio', '43212', null, '$5M-$10M', '20-49', '13', 'Venture Capital & Private Equity', null);
INSERT INTO `sap_client_prosperworks` VALUES ('454', '8227785', 'Repointtech', null, 'Potomac', 'Maryland', null, null, '$500K-$1M', '1-4', '5', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('455', '8731766', 'Renew Alert', '501 N 37Th Drive Suite #105', 'Phoenix', 'Arizona', '85009', null, '$1M-$5M', '10-19', '6', 'Internet', null);
INSERT INTO `sap_client_prosperworks` VALUES ('456', '21925000', 'Renaissance Personnel Group INC', '8414 N. 90th Street Suite 103', 'Scottsdale', 'Arizona', '85258', null, '$5M-$10M', '20-49', '24', 'Staffing and Recruiting', null);
INSERT INTO `sap_client_prosperworks` VALUES ('457', '9272305', 'Renaissance EXECUTIVE FORUMS', '7855 Ivanhoe Avenue Suite 300', 'La Jolla', 'California', '92037', null, '$25M-$50M', '100-249', '24', 'Management Consulting', null);
INSERT INTO `sap_client_prosperworks` VALUES ('458', '17724874', 'Reese Yeatman Financial LLC', '4704 Highland Avenue', 'Bethesda', 'Maryland', '20814', null, '$1M-$5M', '10-19', null, 'Insurance', null);
INSERT INTO `sap_client_prosperworks` VALUES ('459', '14880092', 'Recruiting Pros', '1215 Village Crossing Dr.', 'Chapel Hill', 'North Carolina', '27517', null, '$1M-$5M', '5-9', '7', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('460', '20513996', 'Reach Nash', '611 Commerce St Ste 2705', 'Nashville', 'Tennessee', '37203', null, '$5M-$10M', '20-49', '7', 'Entertainment', null);
INSERT INTO `sap_client_prosperworks` VALUES ('461', '7971713', 'Ramco Refrigeration & Air Conditioning Inc.', '3921 E. Miraloma Avenue', 'Anaheim', 'California', '92806', null, '$1M-$5M', '20-49', '40', 'Facilities Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('462', '17657216', 'Quovant', '732 Melrose Avenue', 'Nashville', 'Tennessee', '37211', null, '$25M-$50M', '100-249', '26', 'Legal Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('463', '21233446', 'ProTech', '4800 N Federal Hwy, Ste 304E', 'Boca Raton', 'Florida', '33431', null, null, null, '22', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('464', '19360355', 'Proof', null, 'Scottdale', 'Arizona', null, null, '$1M-$5M', '10-19', '3', 'Computer Software', null);
INSERT INTO `sap_client_prosperworks` VALUES ('465', '21196957', 'ProFound Staffing, Inc.', '10131 FM 2920', 'Tomball', 'Texas', '77375', null, '$1M-$5M', '5-9', '11', 'Staffing and Recruiting', null);
INSERT INTO `sap_client_prosperworks` VALUES ('466', '17249271', 'Proficient Corporation', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('467', '21012895', 'Proactive Data Consulting, LLC.', '4399 Commons Dr. E \nSuite 100B', 'Destin', 'Florida', '32541', null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('468', '21294443', 'Pro Select', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('469', '9273392', 'Pro Link Systems', null, 'Woodland Hills', 'California', '91367', null, '$1M-$5M', '5-9', '19', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('470', '7113686', 'Privcap', '261 Madison Ave', 'New York', 'New York', '10016', null, '$5M-$10M', '20-49', '8', 'Media Production', null);
INSERT INTO `sap_client_prosperworks` VALUES ('471', '19162334', 'PRIVATE WEALTH SYSTEMS', '401 North Tryon Street', 'Charlotte', 'North Carolina', '28202', null, '$5M-$10M', '20-49', '4', 'Computer Software', null);
INSERT INTO `sap_client_prosperworks` VALUES ('472', '15496274', 'Pristine Environments, Inc.', '7925 Jones Branch Drive', 'McLean', 'Virginia', '22102', null, '$100M-$250M', '500-999', '8', 'Facilities Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('473', '22965609', 'Presentation.Solutions', null, 'Washington', 'District of Columbia', null, null, null, null, null, 'Marketing and Advertising', null);
INSERT INTO `sap_client_prosperworks` VALUES ('474', '7393775', 'Powerfront', '5405 Wilshire Blvd', 'Los Angeles', 'California', '90036', null, '$25M-$50M', '100-249', '18', 'Computer Software', null);
INSERT INTO `sap_client_prosperworks` VALUES ('475', '20643725', 'PlaceValue', '150 Turtle Creek Boulevard Suite 205', 'Dallas', 'Texas', '75207', null, '$5M-$10M', '20-49', null, 'Commercial Real Estate', null);
INSERT INTO `sap_client_prosperworks` VALUES ('476', '16326851', 'Phoenix Online Advertising', '4848 E. Cactus Road, Suite 505-410,', 'Scottsdale', 'Arizona', '85254', null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('477', '11826335', 'PhaseAlpha, LLC', '16 South Broadway #42', 'Louisburg', 'Kansas', '66053', null, '$5M-$10M', '20-49', '8', 'Computer Software', null);
INSERT INTO `sap_client_prosperworks` VALUES ('478', '23248216', 'Pharma Touch', '2501 Seaport Drive, Suite SH-310', 'Chester', 'Pennsylvania', '19013', null, null, null, null, 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('479', '13266989', 'PerdiaEducation', '261 West Main Street', 'Monterey', 'Virginia', '24465', null, '$1M-$5M', '10-19', null, 'Marketing and Advertising', null);
INSERT INTO `sap_client_prosperworks` VALUES ('480', '21830228', 'PeopleSense', '780 McArdle Drive, Suite D', 'Crystal Lake', 'Illinois', '60014', null, '$1M-$5M', '5-9', '16', 'Human Resources', null);
INSERT INTO `sap_client_prosperworks` VALUES ('481', '11466175', 'Pelnik Insurance', '100 Ridge View Dr # 100', 'Cary', 'North Carolina', '27511', null, '$1M-$5M', '5-9', '24', 'Insurance', null);
INSERT INTO `sap_client_prosperworks` VALUES ('482', '14782189', 'Peak360 IT', '1550 Wewatta Street', 'Denver', 'Colorado', '80202', null, null, null, '4', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('483', '8953037', 'PC Results Inc.', '635 Clinton Square', 'Rochester', 'New York', '14604', null, '$1M-$5M', '5-9', '14', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('484', '11355304', 'Patrice & Associates, Inc.', '10020 Southern Maryland Blvd', 'Dunkirk', 'Maryland', '20754', null, '$25M-$50M', '100-249', '29', 'Staffing and Recruiting', null);
INSERT INTO `sap_client_prosperworks` VALUES ('485', '22730823', 'Paramount Staffing', '1200 Shermer Rd.', 'Northbrook', 'Illinois', '60062', null, '$10M-$25M', '100-249', '19', 'Staffing and Recruiting', null);
INSERT INTO `sap_client_prosperworks` VALUES ('486', '17584304', 'Parallels', 'Seattle', 'Bellevue', 'Washington', '98004', null, '$100M-$250M', '500-999', '19', 'Computer Software', null);
INSERT INTO `sap_client_prosperworks` VALUES ('487', '20010141', 'Owen-Dunn Insurance Services', '1455 Response Road, Suite 260', 'Sacramento', 'California', '95815', null, null, null, '69', 'Insurance', null);
INSERT INTO `sap_client_prosperworks` VALUES ('488', '7708409', 'Pace Butler', '5915 NW 23rd Street', 'Oklahoma City', 'Oklahoma', '73127', null, '$25M-$50M', '100-249', '31', 'Telecommunications', null);
INSERT INTO `sap_client_prosperworks` VALUES ('489', '19162040', 'Ovis Technologies', '483 Tenth Avenue\nSuite 230', 'New York', 'New York', '10018', null, '$5M-$10M', '20-49', null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('490', '19362014', 'Outcode Sofware', '12441 South 900 East, Room 210', 'Draper', 'Utah', '84020', null, null, null, '2', 'Computer Software', null);
INSERT INTO `sap_client_prosperworks` VALUES ('491', '12816867', 'OSS Integrators, Inc.', '610 Market Street', 'Kirkland', 'Washington', '98033', null, '$5M-$10M', '20-49', '16', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('492', '19638265', 'OneSpace.com', '33 Bronze Pointe N', 'Swansea', 'Illinois', '62226', null, '$25M-$50M', '100-249', '8', 'Internet', null);
INSERT INTO `sap_client_prosperworks` VALUES ('493', '16326607', 'OnSeen', '274 Marconi Blvd # 400', 'Columbus', 'Ohio', '43215', null, '$1M-$5M', '10-19', null, 'Marketing and Advertising', null);
INSERT INTO `sap_client_prosperworks` VALUES ('494', '20600885', 'OneDigital Health and Benefits', '200 Galleria Parkway, Suite 1950', 'Atlanta', 'Georgia', '30039', null, '$100M-$250M', '500-999', '18', 'Insurance', null);
INSERT INTO `sap_client_prosperworks` VALUES ('495', '11177781', 'Objectiva Software Solutions, Inc.', 'El Camino Real Suite 300,', 'San Diego', 'California', '92130', null, '$100M-$250M', '500-999', '17', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('496', '9843535', 'Oakwood Systems Group', '622 Emerson Road Suite 350', 'St. Louis', 'Missouri', '63141', null, '$10M-$25M', '100-249', '37', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('497', '17078178', 'Noxigen LLC', '1550 W McEwen Dr Ste 300', 'Franklin', 'Tennessee', '37067', null, '<$500K', '1-4', '6', 'Computer Software', null);
INSERT INTO `sap_client_prosperworks` VALUES ('498', '16967763', 'Northlich', '720 East Pete Rose Way', 'Cincinnati', 'Ohio', '45202', null, '$10M-$25M', '100-249', '69', 'Marketing and Advertising', null);
INSERT INTO `sap_client_prosperworks` VALUES ('499', '18005929', 'Nieminski Robbins & Associates CPAs LLC', '10 Executive Ct #2', 'S Barrington', 'Illinois', '60010', null, '$1M-$5M', '5-9', null, 'Accounting', null);
INSERT INTO `sap_client_prosperworks` VALUES ('500', '15749884', 'Nesco', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('501', '16903267', 'National Pavement', '19 Commerce Lane, Ste #3', 'Canton', 'New York', '13617', null, '$5M-$10M', '20-49', '24', 'Facilities Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('502', '15304944', 'My 3D Rendering', '47 W Division', 'Chicago', 'Illinois', '60610', null, null, null, '6', 'Computer Software', null);
INSERT INTO `sap_client_prosperworks` VALUES ('503', '13269781', 'MVRetail (Movista)', '406 SE 5th St #12', 'Bentonville', 'Arkansas', '72712', null, '$5M-$10M', '20-49', '8', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('504', '18894900', 'Murphy Business & Financial Corporation', '513 North Belcher Road', 'Clearwater', 'Florida', '33765', null, '$50M-$100M', '250-499', '26', 'Capital Markets', null);
INSERT INTO `sap_client_prosperworks` VALUES ('505', '23224306', 'Msstech', '1555 E. Orangewood Avenue', 'Phoenix', 'Arizona', '85020', null, '$5M-$10M', '100-249', '32', 'Management Consulting', null);
INSERT INTO `sap_client_prosperworks` VALUES ('506', '8064366', 'Morphis Technologies', 'Av. 5 de Outubro, 146-9', 'Lisbon', null, '1050-061', null, '$10M-$25M', '100-249', '5', 'Computer Software', null);
INSERT INTO `sap_client_prosperworks` VALUES ('507', '23125226', 'Moosylvania', '7303 Marietta Avenue', 'St. Louis', 'Missouri', '63143', null, '$10M-$25M', '100-249', '15', 'Marketing and Advertising', null);
INSERT INTO `sap_client_prosperworks` VALUES ('508', '18985350', 'Modular Industrial Computers', '6634 Lee Highway', 'Chattanooga', 'Tennessee', '37421', null, '$5M-$10M', '100-249', '26', 'Computer Hardware', null);
INSERT INTO `sap_client_prosperworks` VALUES ('509', '23129967', 'Mobiz', '1345 Parker Ct.', 'Redlands', 'California', '92373', null, '$5M-$10M', '20-49', '10', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('510', '14689451', 'Minding your Business', '200 East Ohio Street, Suite 200', 'Chicago', 'Illinois', '60611', null, '$1M-$5M', '20-49', '24', 'Management Consulting', null);
INSERT INTO `sap_client_prosperworks` VALUES ('511', '8978276', 'MindActive', '7803 Clayton Rd', 'St. Louis, Missouri', 'Missouri', '63117', null, '$500K-$1M', '5-9', '20', 'Marketing and Advertising', null);
INSERT INTO `sap_client_prosperworks` VALUES ('512', '17659221', 'Midas', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('513', '12649669', 'Meyers', '7277 Boone Ave North', 'Minneapolis', 'Minnesota', '55428', null, null, null, '69', 'Printing', null);
INSERT INTO `sap_client_prosperworks` VALUES ('514', '19014701', 'Metta Marketing Solutions', null, 'Phoenix', 'Arizona', null, null, null, null, '1', 'Marketing and Advertising', null);
INSERT INTO `sap_client_prosperworks` VALUES ('515', '16318713', 'Medoff Inc', '41 E. 11th Street 11th Floor', 'New York', 'New York', '10003', null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('516', '17026219', 'McIntyre Global Executive Search', '175 S. 3rd St, Suite 820', 'Columbus', 'Ohio', '43215', null, '$1M-$5M', '10-19', '28', 'Staffing and Recruiting', null);
INSERT INTO `sap_client_prosperworks` VALUES ('517', '21929523', 'MCF Technology Solutions', '445 California Ave,', 'Lorain', 'Ohio', '44052', null, '$25M-$50M', '100-249', '11', 'Computer Software', null);
INSERT INTO `sap_client_prosperworks` VALUES ('518', '15531810', 'Maru/Matchbox', '2 Bloor Street East, Suite 1600', 'Toronto', 'Ontario', null, null, null, null, '2', 'Market Research', null);
INSERT INTO `sap_client_prosperworks` VALUES ('519', '20643453', 'Marking Systems Inc', '2601 Market St', 'Garland', 'Texas', '75041', null, '$10M-$25M', '100-249', '48', 'Printing', null);
INSERT INTO `sap_client_prosperworks` VALUES ('520', '11464263', 'Lux Scientiae, Incorporated', '15 Brook Street', 'Medfield', 'Massachusetts', '2052', null, '$5M-$10M', '20-49', '19', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('521', '7019793', 'Lumesse', null, 'Guildford', 'Surrey', null, null, '$100M-$250M', '500-999', '19', 'Computer Software', null);
INSERT INTO `sap_client_prosperworks` VALUES ('522', '23113267', 'Lockton', '3 Derby Rd', 'Ripley', null, 'DE5 3EA', null, '$1B-$5B', '5,000-9,999', '52', 'Insurance', null);
INSERT INTO `sap_client_prosperworks` VALUES ('523', '8286554', 'Linked LLC', null, 'Sterling Heights', 'Michigan', null, null, null, null, null, 'Human Resources', null);
INSERT INTO `sap_client_prosperworks` VALUES ('524', '11587307', 'Lewis Fowler', '383 Inverness Pkwy, Suite 475', 'Englewood', 'Colorado', '80112', null, '$5M-$10M', '100-249', '16', 'Management Consulting', null);
INSERT INTO `sap_client_prosperworks` VALUES ('525', '15448998', 'Level 10', 'Emiliano Zapata #21-B Bodega 1 Col. San Jerónimo', null, null, '54090', null, '$25M-$50M', '100-249', '17', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('526', '17784009', 'Lean Technologies, Inc.', '1109 Washington Street', 'Pella', 'Iowa', '50219', null, '$1M-$5M', '5-9', '15', 'Computer Software', null);
INSERT INTO `sap_client_prosperworks` VALUES ('527', '19388072', 'Leadership Dialogues', '10472 Frontenac Woods Lane', 'St. Louis', 'Missouri', '63131', null, null, null, '17', 'Professional Training & Coaching', null);
INSERT INTO `sap_client_prosperworks` VALUES ('528', '20425619', 'Leader\'s Edge Consulting Inc', null, 'Denver', 'Colorado', null, null, '<$500K', '1-4', '27', null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('529', '21404680', 'Kore1', '47 Discovery', 'Irvine', 'California', '92618', null, '$10M-$25M', '100-249', '13', 'Staffing and Recruiting', null);
INSERT INTO `sap_client_prosperworks` VALUES ('530', '19646593', 'Ketch', null, 'Virginia Beach', 'Virginia', null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('531', '21362947', 'Kem Sports Management', null, 'Jacksonville', 'Oregon', null, null, null, null, '3', 'Public Relations and Communications', null);
INSERT INTO `sap_client_prosperworks` VALUES ('532', '17076279', 'KBRG', '56 Depot St. #1617', 'Duxbury', 'Massachusetts', '02332-1617', null, '$500K-$1M', '5-9', '7', 'Management Consulting', null);
INSERT INTO `sap_client_prosperworks` VALUES ('533', '17076050', 'Katalyst Network Group', '200 1st Avenue NW', 'Hickory', 'North Carolina', '28601', null, null, '100-249', '12', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('534', '22329983', 'Jungclaus-Campbell', '825 Massachusetts Avenue', 'Indianapolis', 'Indiana', '46204', null, '$5M-$10M', '100-249', '145', 'Construction', null);
INSERT INTO `sap_client_prosperworks` VALUES ('535', '22922740', 'Juhll', '123 Lomita St.', 'El Segundo', 'California', '90245', null, '$5M-$10M', '20-49', '13', 'Marketing and Advertising', null);
INSERT INTO `sap_client_prosperworks` VALUES ('536', '22458865', 'JMJ Internet Consulting (might have changed their name?)', '106 S Bouldin Street', 'Baltimore', 'Maryland', '21224', null, '$1M-$5M', '10-19', null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('537', '21821191', 'JM Films', '2705 Dougherty Ferry Rd. Suite 103', 'St. Louis', 'Missouri', '63122', null, '$1M-$5M', '5-9', '3', 'Marketing and Advertising', null);
INSERT INTO `sap_client_prosperworks` VALUES ('538', '14148429', 'James D. Klote & Associates, Inc.', '103 Park Washington Court', 'Falls Church', 'Virginia', '22046', null, '$5M-$10M', '20-49', null, 'Fund-Raising', null);
INSERT INTO `sap_client_prosperworks` VALUES ('539', '14431516', 'J.D. Young Company', '116 West Third Street', 'Tulsa', 'Oklahoma', '74103', null, '$25M-$50M', '100-249', '69', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('540', '13882904', 'Jade Track', '1275 Kinnear Rd', 'Columbus', 'Ohio', '43212', null, '$1M-$5M', '5-9', '7', 'Computer Software', null);
INSERT INTO `sap_client_prosperworks` VALUES ('541', '22065396', 'J. DEMPSEY, INC.', '1304 S. Main Street', 'Ann Arbor', 'Michigan', '48104', null, '$500K-$1M', '5-9', '50', 'Insurance', null);
INSERT INTO `sap_client_prosperworks` VALUES ('542', '17938877', 'Ittrium', '339 Second Street Suite 200', 'Excelsior', 'Minnesota', '55331', null, '$1M-$5M', '5-9', '17', 'Computer Software', null);
INSERT INTO `sap_client_prosperworks` VALUES ('543', '7410162', 'iProcess Data Systems LLC', '1804 Rosalie St', 'Houston', 'Texas', '77004', null, '$1M-$5M', '10-19', '11', 'Computer Software', null);
INSERT INTO `sap_client_prosperworks` VALUES ('544', '17411001', 'IntraTek LLC', '1530 E Williamsfield Rd', 'Gilbert', 'Arizona', '85295', null, '$5M-$10M', '20-49', '7', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('545', '11713485', 'Intermark Group Inc', '101 25th St N', 'Birmingham', 'Alabama', '35203', null, '$10M-$25M', '100-249', '41', 'Marketing and Advertising', null);
INSERT INTO `sap_client_prosperworks` VALUES ('546', '22644015', 'Interactive Energy Group', null, 'Addison', 'Texas', null, null, '$5M-$10M', '20-49', '1', 'Oil & Energy', null);
INSERT INTO `sap_client_prosperworks` VALUES ('547', '20622416', 'Integritas Group, LLC', '1173 Pittsford Victor Road, Suite 250', 'Pittsford', 'New York', '14534', null, '$1M-$5M', '5-9', '3', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('548', '14002172', 'Integrated Solutions Management', '12471 W Linebaugh Ave', 'Tampa', 'Florida', '33626', null, '$25M-$50M', '100-249', '27', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('549', '17804067', 'Integrated Building Systems', '950 Michigan Avenue', 'Columbus', 'Ohio', '43215', null, '$1M-$5M', '20-49', '25', 'Telecommunications', null);
INSERT INTO `sap_client_prosperworks` VALUES ('550', '20292886', 'Insurance Office of America', '1855 West SR 434', 'Longwood', 'Florida', '32750', null, '$100M-$250M', '1,000-4,999', '30', 'Insurance', null);
INSERT INTO `sap_client_prosperworks` VALUES ('551', '21919542', 'Insperity', '19001 Crescent Springs Drive', 'Humble', 'Texas', '77339-3802', null, '$250M-$500M', '1,000-4,999', '32', 'Human Resources', null);
INSERT INTO `sap_client_prosperworks` VALUES ('552', '8730920', 'Insperia, Inc', '600 Chestnut St\nSuite 1046', 'Philadelphia', 'Pennsylvania', '19106', null, '$500K-$1M', '5-9', '17', 'Computer Software', null);
INSERT INTO `sap_client_prosperworks` VALUES ('553', '17956978', 'Inseev Interactive', '3565 Del Rey Street Suite 202', 'San Diego', 'California', '92109', null, '$500K-$1M', '5-9', '5', 'Marketing and Advertising', null);
INSERT INTO `sap_client_prosperworks` VALUES ('554', '21749269', 'Innovative Cost Solutions LLC', '863 Turnpike Street, Unit 224', 'North Andover', 'Massachusetts', '1845', null, '$1M-$5M', '5-9', '12', 'Management Consulting', null);
INSERT INTO `sap_client_prosperworks` VALUES ('555', '19073724', 'Innovare Technologies, Inc', '1879 Lundy Ave, Suite 122', 'San Jose', 'California', '95131', null, '$5M-$10M', '20-49', '7', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('556', '16435467', 'Inhouse Printing', '5340 Cameron St Suite 20', 'Las Vegas', 'Nevada', '89118', null, null, null, null, 'Printing', null);
INSERT INTO `sap_client_prosperworks` VALUES ('557', '16295058', 'InFocus Medical Billing', null, 'Charlotte', 'North Carolina', null, null, '<$500K', null, '1', 'Hospital & Health Care', null);
INSERT INTO `sap_client_prosperworks` VALUES ('558', '22951869', 'Industryweapon', '900 Parish Street', 'Pittsburgh', 'Pennsylvania', '15220', null, '$25M-$50M', '100-249', '15', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('559', '10060768', 'IMS Software Solutions', '401 S. Boston Ave', 'Tulsa', 'Oklahoma', '74103', null, '$5M-$10M', '20-49', '6', 'Computer Software', null);
INSERT INTO `sap_client_prosperworks` VALUES ('560', '16623279', 'Improvizations Inc', '60401 Hanes Road', 'Bend', 'Oregon', '97702', null, '$5M-$10M', '20-49', '30', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('561', '7030615', 'Immersive llc', '3411 High Cliff Road', 'Panama City', 'Florida', '32409', null, '$5M-$10M', '20-49', '8', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('562', '7916925', 'Imagine it, Inc.', '2950 Metro Drive #308', 'Bloomington', 'Minnesota', '55425', null, '$5M-$10M', '20-49', '20', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('563', '17143677', 'iFocus Marketing', '7450 W. 130th St.', 'Overland Park', 'Kansas', '66213', null, '$5M-$10M', '20-49', '2', 'Marketing and Advertising', null);
INSERT INTO `sap_client_prosperworks` VALUES ('564', '8710039', 'IDACOMP', '1243 E Iron Eagle Dr Suite 110', 'Eagle', 'Idaho', '83616', null, '$1M-$5M', '5-9', '16', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('565', '13997853', 'Iconectiv', '100 Somerset Corporate Blvd.', 'Bridgewater', 'New Jersey', '8854', null, '$50M-$100M', '250-499', '34', 'Telecommunications', null);
INSERT INTO `sap_client_prosperworks` VALUES ('566', '11341793', 'ICC Logistics Services, Inc.', '960 South Broadway - Suite 110', 'Hicksville', 'New York', '11801', null, '$5M-$10M', '20-49', '43', 'Transportation/Trucking/Railroad', null);
INSERT INTO `sap_client_prosperworks` VALUES ('567', '8730146', 'I Get it! Development', '1750 Meridian Ave', 'San Jose', 'California', '95125', null, '$500K-$1M', '5-9', '19', 'Computer Software', null);
INSERT INTO `sap_client_prosperworks` VALUES ('568', '16565961', 'HyQuality', null, 'New York', 'New York', null, null, '$500K-$1M', '5-9', '21', 'Marketing and Advertising', null);
INSERT INTO `sap_client_prosperworks` VALUES ('569', '22225168', 'HRPro', '1423 E. 11 Mile Rd.', 'Royal Oak', 'Michigan', '48067', null, '$5M-$10M', '20-49', '29', 'Human Resources', null);
INSERT INTO `sap_client_prosperworks` VALUES ('570', '15896331', 'Hosted America', '410 S Salisbury St.', 'Raleigh', 'North Carolina', '27601', null, '$1M-$5M', '5-9', '36', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('571', '14683793', 'Horton International-NA', '29 South Main Street', 'West Hartford', 'Connecticut', '6107', null, '$50M-$100M', '250-499', '40', 'Staffing and Recruiting', null);
INSERT INTO `sap_client_prosperworks` VALUES ('572', '22540493', 'Honest Projects', null, 'Grand Rapids', 'Michigan', null, null, null, null, '1', 'Design', null);
INSERT INTO `sap_client_prosperworks` VALUES ('573', '13027902', 'Holt and Patterson', '260 Chesterfield Industrial Blvd', 'Chesterfield', 'Missouri', '63005', null, '$5M-$10M', '20-49', '58', 'Accounting', null);
INSERT INTO `sap_client_prosperworks` VALUES ('574', '18448976', 'Holden Advisors', 'Concord', 'Massachusetts', null, null, null, '$1M-$5M', '20-49', '16', 'Management Consulting', null);
INSERT INTO `sap_client_prosperworks` VALUES ('575', '20539664', 'Heath Benefit Partners Inc', '26522 La Alameda, Suite 130', 'Mission Viejo', 'California', '92691', null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('576', '8578299', 'HealthSystems - GE Healthcare Centricity EMR and PM (Quatris)', null, 'Bedford', 'Texas', '76022', null, '$10M-$25M', '100-249', '5', 'Hospital & Health Care', null);
INSERT INTO `sap_client_prosperworks` VALUES ('577', '19592967', 'HCRC Staffing', '111 Forrest Ave\nSuite 1', 'Narberth', 'Pennsylvania', '19072', null, '$1M-$5M', '10-19', '12', 'Staffing and Recruiting', null);
INSERT INTO `sap_client_prosperworks` VALUES ('578', '7708365', 'Harvest Strategy Group, Inc.', '1776 Lincoln St Ste 900', 'Denver', 'Colorado', '80203', null, '$5M-$10M', '20-49', '19', 'Financial Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('579', '14463826', 'Hancock & Poole Security Inc.', '625 North Washington Street', 'Alexandria', 'Virginia', '22314', null, '$1M-$5M', '10-19', '7', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('580', '16680622', 'Griffin Solutions Group LLC', '3655 Brookside Pkwy Suite 210', 'Alpharetta', 'Georgia', '30022', null, '$1M-$5M', '20-49', null, 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('581', '23325996', 'GreenFoot', '10100 West 87th Street', 'Overland Park', 'Kansas', '66212', null, '$5M-$10M', '20-49', '14', 'Staffing and Recruiting', null);
INSERT INTO `sap_client_prosperworks` VALUES ('582', '7953557', 'Green Street Solar Power', '1360 Garrison Ave.', 'Bronx', 'New York', '10474', null, '$5M-$10M', '20-49', '4', 'Renewables & Environment', null);
INSERT INTO `sap_client_prosperworks` VALUES ('583', '15897430', 'GREEN CLEAN COMMERCIAL', '1520 South Fifth Street, suite 301', 'St. Charles', 'Missouri', '63303', null, '$50M-$100M', '250-499', '10', 'Facilities Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('584', '21004937', 'Gordon Advisors P.C', '1301 W. Long Lake Rd', 'Troy', 'Michigan', '48098', null, '$5M-$10M', '100-249', '64', 'Accounting', null);
INSERT INTO `sap_client_prosperworks` VALUES ('585', '18436669', 'GlobalDoc, Inc.', '1800 Peachtree Street NW', 'Atlanta', 'Georgia', '30309', null, '$500M-$1B', '1,000-4,999', '25', 'Translation and Localization', null);
INSERT INTO `sap_client_prosperworks` VALUES ('586', '7523235', 'Geoscape Solar', '160 S Livingston Ave, Ste 113', 'Livingston', 'New Jersey', '7039', null, '$5M-$10M', '20-49', '10', 'Renewables & Environment', null);
INSERT INTO `sap_client_prosperworks` VALUES ('587', '10854462', 'Gang Of Three Inc.', '1810 E. Sahara Ave Ste. 1339', 'Las Vegas', 'Nevada', '89104', null, '$5M-$10M', '20-49', '5', 'Hospitality', null);
INSERT INTO `sap_client_prosperworks` VALUES ('588', '19888232', 'Fuel Insights, Inc.', '3198 Raccoon Valley Rd', 'Granville', 'Ohio', '43023', null, '<$500K', '1-4', '6', 'Market Research', null);
INSERT INTO `sap_client_prosperworks` VALUES ('589', '22635918', 'Frsco', '80 Wesley St.', 'S. Hackensack', 'New Jersey', '7606', null, '$5M-$10M', '20-49', '10', 'Financial Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('590', '19365499', 'Front Analytics', '10 W Broadway, 7th Floor', 'Salt Lake City', 'Utah', '84101', null, '$5M-$10M', '20-49', '2', 'Management Consulting', null);
INSERT INTO `sap_client_prosperworks` VALUES ('591', '22351301', 'Frendli', null, 'Miami', 'Florida', null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('592', '12002902', 'Fortimize', '57 West 57th Street', 'New York', 'New York', '10019', null, '$5M-$10M', '20-49', '6', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('593', '20600259', 'Forefront Media Marketing', '1016 Sunny Acres Ave', 'North Las Vegas', 'Nevada', '89081', null, null, null, '1', 'Marketing and Advertising', null);
INSERT INTO `sap_client_prosperworks` VALUES ('594', '16016089', 'Focus Investment Banking', '1133 20th Street NW, Suite 200', 'Washington', 'District Of Columbia', '20036', null, '$25M-$50M', '100-249', '26', 'Investment Banking', null);
INSERT INTO `sap_client_prosperworks` VALUES ('595', '7326210', 'FocalPoint Business Coaching', '5740 S. Eastern Avenue', 'Las Vegas', 'Nevada', '89119-3037', null, '$25M-$50M', '100-249', '21', 'Professional Training & Coaching', null);
INSERT INTO `sap_client_prosperworks` VALUES ('596', '11469147', 'First Alliance Logistics Management', '205 Regency Executive Park Drive', 'Charlotte', 'North Carolina', '28217', null, '$5M-$10M', '20-49', '23', 'Logistics and Supply Chain', null);
INSERT INTO `sap_client_prosperworks` VALUES ('597', '20431802', 'Fire Rover', '21455 Melrose Ave', 'Southfield', 'Michigan', '48075', null, '$5M-$10M', '20-49', '17', 'Public Safety', null);
INSERT INTO `sap_client_prosperworks` VALUES ('598', '23101772', 'fig Media Inc.', null, 'Chicago', 'Illinois', null, null, '$5M-$10M', '20-49', '19', 'Events Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('599', '11410324', 'Fair Pattern', '1460 Broadway', 'New York', 'New York', '10036', null, '$10M-$25M', '50-99', '8', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('600', '17711508', 'Evoke Technologies', '7106 Corporate Way', 'Dayton', 'Ohio', '45459', null, '$50M-$100M', '500-999', '15', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('601', '16133646', 'Ethic Advertising', '600 Iron City Dr, Suite 200', 'Pittsburgh', 'Pennsylvania', '15205', null, '<$500K', '1-4', '4', 'Marketing and Advertising', null);
INSERT INTO `sap_client_prosperworks` VALUES ('602', '20753192', 'ERTechnologies Inc', '100 Pacifica', 'Irvine', 'California', '92618', null, '$5M-$10M', '20-49', '17', null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('603', '14067852', 'EnviroMerica Inc', '4906 El Camino Real.\nSuite 206', 'Los Altos', 'California', '94022', null, '$1M-$5M', '10-19', '19', 'Management Consulting', null);
INSERT INTO `sap_client_prosperworks` VALUES ('604', '15073650', 'Endeavor Consulting Group, LLC', '303 W. Lancaster Ave', 'Wayne', 'Pennsylvania', '19087', null, '$25M-$50M', '100-249', '12', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('605', '10594702', 'Emtec Inc.', '555 East Lancaster Avenue', 'Radnor', 'Pennsylvania', '19087', null, '$100M-$250M', '500-999', '23', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('606', '16115960', 'Emmanuel insurance and financial services', null, 'Utica', 'New York', null, null, null, null, '1', 'Internet', null);
INSERT INTO `sap_client_prosperworks` VALUES ('607', '20978582', 'EMERGYS CORPORATION', '6104 Fayeteville Road', 'Durham', 'North Carolina', '27713', null, '$25M-$50M', '250-499', '20', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('608', '14432756', 'Elite Workforce Management', '4527 E 31st Street', 'Tulsa', 'Oklahoma', '74135', null, '$5M-$10M', '20-49', '22', 'Staffing and Recruiting', null);
INSERT INTO `sap_client_prosperworks` VALUES ('609', '18005469', 'E&L Construction LLC', null, null, null, null, null, null, null, null, 'Construction', null);
INSERT INTO `sap_client_prosperworks` VALUES ('610', '16557932', 'Document Access Systems', '703 Westchester Drive Suite 105', 'Richmond', 'Virginia', '23235', null, '$1M-$5M', '10-19', '27', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('611', '16922397', 'Divergence', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('612', '19639220', 'DG3 Group Limited', '100 Burma Road', 'Jersey City', 'New Jersey', '7305', null, '$250M-$500M', '500-999', '35', 'Printing', null);
INSERT INTO `sap_client_prosperworks` VALUES ('613', '6962480', 'Dextro Analytics Inc.', '701 Fifth Avenue 2nd Floor', 'Seattle', 'Washington', '98104', null, '$1M-$5M', '5-9', '3', 'Management Consulting', null);
INSERT INTO `sap_client_prosperworks` VALUES ('614', '19581874', 'Devico Solutions', null, null, null, null, null, null, null, '6', 'Computer Software', null);
INSERT INTO `sap_client_prosperworks` VALUES ('615', '15768871', 'Design Me Stuff', '2321 Wengler Ave', 'St.Louis', 'Missouri', '63114', null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('616', '22786802', 'Delta Bravo!', null, 'Rock Hill', 'South Carolina', null, null, null, null, '2', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('617', '17535952', 'DELT', '8125 Michigan Ave. Ste 100', 'St. Louis', 'Missouri', '63129', null, '$1M-$5M', '10-19', '4', 'Marketing and Advertising', null);
INSERT INTO `sap_client_prosperworks` VALUES ('618', '10418662', 'Datotel', null, 'Chicago', 'Illinois', null, null, '$10M-$25M', '50-99', '14', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('619', '14949570', 'DataComm Networks, Inc.', '6801 North 54th Street', 'Tampa', 'Florida', '33610', null, '$5M-$10M', '20-49', '34', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('620', '22304986', 'Darwinhealth', '17470 N. Pacesetter Way', 'Scottsdale', 'Arizona', '85255', null, '$1M-$5M', '10-19', '10', 'Management Consulting', null);
INSERT INTO `sap_client_prosperworks` VALUES ('621', '22304987', 'Darwin Health- same as below???', '3960 Broadway, Suite 540', 'New York', 'New York', '10032', null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('622', '19137843', 'DaoIsTheWay', '77 Alberti Aisle', 'Irvine', 'California', '92614', null, null, null, '27', 'E-Learning', null);
INSERT INTO `sap_client_prosperworks` VALUES ('623', '13001954', 'Cult Marketing LLC', '175 S 3rd St', 'Columbus', 'Ohio', '43215', null, '$5M-$10M', '20-49', '14', 'Marketing and Advertising', null);
INSERT INTO `sap_client_prosperworks` VALUES ('624', '15073214', 'CrystalVoxx Ltd', null, 'Larenceville', 'Georgia', null, null, null, null, null, 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('625', '19144629', 'Crossroads RMC', '800-762-2077', 'Lisle', 'Illinois', '60532', null, null, null, '34', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('626', '19625720', 'Creata', '1801 South Meyers Road, Suite 400', 'Oakbrook Terrace', 'Illinois', '60181', null, '$50M-$100M', '250-499', '45', 'Marketing and Advertising', null);
INSERT INTO `sap_client_prosperworks` VALUES ('627', '7327536', 'Cpohr', null, 'Tucson', 'Arizona', null, null, '$5M-$10M', '20-49', '17', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('628', '19434054', 'CPGToolBox', '125 Townpark Drive • Suite 300', 'Kennesaw', 'Georgia', '30144', null, '$1M-$5M', '10-19', '6', 'Consumer Goods', null);
INSERT INTO `sap_client_prosperworks` VALUES ('629', '12799423', 'Cosenta LLC', '36 Commerce Way', 'Woburn', 'Massachusetts', '1801', null, '$1M-$5M', '5-9', '6', 'Computer Software', null);
INSERT INTO `sap_client_prosperworks` VALUES ('630', '21708666', 'Corporate Tax Incentives', '10860 Gold Center Drive', 'Rancho Cordova', 'California', '95670', null, '$5M-$10M', '20-49', '17', 'Accounting', null);
INSERT INTO `sap_client_prosperworks` VALUES ('631', '21359158', 'Cornerstone Companies', '4400 College Blvd Suite 350', 'Overland Park', 'Kansas', '66211', null, null, null, '5', 'Insurance', null);
INSERT INTO `sap_client_prosperworks` VALUES ('632', '21080907', 'CoreCentive Inc', '1313 S. Pennsylvania Ave.', 'Morrisville', 'Pennsylvania', '19067', null, '$5M-$10M', '20-49', '9', 'Human Resources', null);
INSERT INTO `sap_client_prosperworks` VALUES ('633', '12941754', 'Cordea Consulting', '1131 East 9th Street #100', 'Edmund', 'Oklahoma', '73034', null, '$5M-$10M', '20-49', '10', 'Hospital & Health Care', null);
INSERT INTO `sap_client_prosperworks` VALUES ('634', '23166757', 'Consultants in Corporate Innovation', null, 'Marina Del Rey', 'California', null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('635', '15857363', 'Con Edison Solutions', null, 'Overland Park', 'Kansas', '66214', null, null, null, null, 'Utilities', null);
INSERT INTO `sap_client_prosperworks` VALUES ('636', '10418675', 'Computer SI Corporation', '22 High Street', 'Norwalk', 'Connecticut', '6851', null, '$5M-$10M', '20-49', '33', 'Computer Software', null);
INSERT INTO `sap_client_prosperworks` VALUES ('637', '12041325', 'Computer Services Group of Long Island', null, 'Garden City', 'New York', null, null, '$1M-$5M', '5-9', '15', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('638', '14550368', 'Computer Pros On Call', '516D River Highway', 'Mooresville', 'North Carolina', '28117', null, '$1M-$5M', '5-9', '15', 'Computer & Network Security', null);
INSERT INTO `sap_client_prosperworks` VALUES ('639', '22813349', 'Commercial Programming Systems, Inc', '4400 Coldwater Canyon Avenue', 'Los Angeles', 'California', '91604', null, '$10M-$25M', '100-249', '40', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('640', '10841276', 'Coeo Solutions, LLC', '1901 Butterfield Rd Suite 150', 'Downers Grove', 'Illinois', '60515', null, '$5M-$10M', '20-49', '4', 'Telecommunications', null);
INSERT INTO `sap_client_prosperworks` VALUES ('641', '10039767', 'CMIT Solutions, Inc.', '500 N Capital of Texas Hwy, Bldg 6, Ste 200', 'Austin', 'Texas', '78746', null, '$100M-$250M', '500-999', '22', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('642', '16017033', 'CMGMS', 'PO BOX 10', 'West Frankfort', 'Illinois', '62896', null, '$50M-$100M', '250-499', '21', 'Online Media', null);
INSERT INTO `sap_client_prosperworks` VALUES ('643', '15554550', 'Clientek Inc', '417 2nd Avenue North', 'Minneapolis', 'Minnesota', '55401', null, '$5M-$10M', '20-49', '26', 'Computer Software', null);
INSERT INTO `sap_client_prosperworks` VALUES ('644', '17657229', 'ClickNotices', '77 West Street – Suite 305', 'Annapolis', 'Maryland', '21401', null, '$5M-$10M', '20-49', '8', 'Legal Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('645', '13585161', 'Clear Peak', null, 'Barcelona', 'Catalonia', null, null, '$5M-$10M', '20-49', '18', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('646', '8257748', 'CIAN Inc.', '1803 W. Detweiller Drive', 'Peoria', 'Illinois', '61615', null, '$5M-$10M', '20-49', '28', 'Computer & Network Security', null);
INSERT INTO `sap_client_prosperworks` VALUES ('647', '15904788', 'Choice Local', '8200 Sweet Valley Dr.', 'Valley View', 'Ohio', '44125', null, '$1M-$5M', '5-9', '5', 'Marketing and Advertising', null);
INSERT INTO `sap_client_prosperworks` VALUES ('648', '16602197', 'Charter Bank', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('649', '18964861', 'ChARM EHR', '4141 Hacienda Dr.', 'Pleasanton', 'California', '94566', null, '$10M-$25M', '50-99', '11', 'Hospital & Health Care', null);
INSERT INTO `sap_client_prosperworks` VALUES ('650', '13349965', 'Champion Risk & Insurance Services', '2250 El Camino Real, Suite 375', 'San Diego', 'California', '92130', null, '$5M-$10M', '20-49', '14', 'Insurance', null);
INSERT INTO `sap_client_prosperworks` VALUES ('651', '15705218', 'Centennial Data Group', '425 S. Cherry St.\nSuite 720', 'Denver', 'Colorado', '80246', null, '$5M-$10M', '20-49', '5', 'Computer Software', null);
INSERT INTO `sap_client_prosperworks` VALUES ('652', '20860578', 'Cendrowski Corporate Advisors', '4111 Andover Rd Fl 3', 'Bloomfield Township', 'Michigan', '48302', null, '$1M-$5M', '20-49', '35', 'Accounting', null);
INSERT INTO `sap_client_prosperworks` VALUES ('653', '22543325', 'Capella Solutions', null, 'Houston', 'Texas', null, null, '$1M-$5M', '5-9', '7', 'Computer Software', null);
INSERT INTO `sap_client_prosperworks` VALUES ('654', '23486701', 'Canvas IT', '704 Berkeley Ave NW,\nSuite C', 'Atlanta', 'Georgia', '30318', null, '$25M-$50M', '100-249', '9', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('655', '23320641', 'Bytagig', null, 'Estacada', 'Oregon', null, null, null, '5-9', '9', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('656', '22822662', 'Brightwork Consulting', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('657', '12753010', 'Bridgetown Trucking Inc', '3901 Union Blvd Ste 135A', 'St. Louis', 'Missouri', '63115', null, '$10M-$25M', '50-99', '19', 'Transportation/Trucking/Railroad', null);
INSERT INTO `sap_client_prosperworks` VALUES ('658', '22278825', 'BPJ', '1637 S Enterprise Ave', 'Springfield', 'Missouri', '65804', null, '$10M-$25M', '50-99', '58', 'Insurance', null);
INSERT INTO `sap_client_prosperworks` VALUES ('659', '16556221', 'BMG Media Co.', '30777 Northwestern Hwy.', 'Farmington Hills', 'Michigan', '48334', null, '$5M-$10M', '20-49', '8', 'Graphic Design', null);
INSERT INTO `sap_client_prosperworks` VALUES ('660', '23732286', 'Bit Lever', '6111 South Pointe Blvd.', 'Fort Myers', 'FL', '33919', null, null, null, '2', 'Computer Software', null);
INSERT INTO `sap_client_prosperworks` VALUES ('661', '15644229', 'Big MKTG (Sonora Offshore)', null, 'San Diego', 'California', null, null, null, null, null, 'Computer Software', null);
INSERT INTO `sap_client_prosperworks` VALUES ('662', '11390092', 'Bestpass, Inc.', '500 New Karner Road', 'Albany', 'New York', '12205', null, '$5M-$10M', '20-49', '17', 'Transportation/Trucking/Railroad', null);
INSERT INTO `sap_client_prosperworks` VALUES ('663', '7018758', 'Banyan Medical Systems,Inc.', '8701 F St', 'Omaha', 'Nebraska', '68127', null, '$25M-$50M', '100-249', '10', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('664', '10139018', 'Bajra Technologies', 'Thirbam Sadak, Dillibazar', 'Kathmandu', null, null, null, '$1M-$5M', '20-49', '7', 'Computer Software', null);
INSERT INTO `sap_client_prosperworks` VALUES ('665', '20276398', 'Authority Partners Inc', '200 Spectrum Center Dr. Suite 300', 'Irvine', 'California', '92618', null, '$50M-$100M', '250-499', '20', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('666', '12273523', 'Austin Labs', null, 'Austin', 'Texas', null, null, null, null, null, 'Computer Software', null);
INSERT INTO `sap_client_prosperworks` VALUES ('667', '12870888', 'AuditSolv', '1809 Clarkson Rd', 'Chesterfield', 'Missouri', '63017', null, '$1M-$5M', '10-19', null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('668', '9876142', 'Atlas Systems', '101 Poor Farm Road,', 'Princeton', 'New Jersey', '8540', null, '$100M-$250M', '500-999', '15', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('669', '13117798', 'ATILUS LLC', '28440 Old 41 Road', 'Bonita Springs', 'Florida', '34135', null, '$1M-$5M', '5-9', '13', 'Internet', null);
INSERT INTO `sap_client_prosperworks` VALUES ('670', '15981192', 'ASA LOGISTICS LLC', '8828 Commerce Loop Drive', 'Columbus', 'Ohio', '43240', null, '$1M-$5M', '20-49', '7', 'Transportation/Trucking/Railroad', null);
INSERT INTO `sap_client_prosperworks` VALUES ('671', '11932949', 'Arnold Packaging', '3101 Washington Blvd', 'Baltimore', 'Maryland', '21230', null, '$5M-$10M', '100-249', '85', 'Packaging and Containers', null);
INSERT INTO `sap_client_prosperworks` VALUES ('672', '16482510', 'Ark LLC', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('673', '22302557', 'American Business Consulting Group LLC', '242524 Hayes Rd, Suite 700', 'Clinton', 'Michigan', '48038', null, '$1M-$5M', '10-19', null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('674', '23509409', 'Am Data Service, Inc', '33097 Schoolcraft Rd', 'Livonia', 'Michigan', '48150', null, '$5M-$10M', '20-49', '13', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('675', '15467776', 'Alyx Technologies Inc', '11410 Isaac Newton Square, Suite 100', 'Reston', 'Virginia', '20190', null, '$5M-$10M', '20-49', '24', 'Computer Software', null);
INSERT INTO `sap_client_prosperworks` VALUES ('676', '19514652', 'Alpine Investors', 'Two Embarcadero Center Suite 2320', 'San Francisco', 'CA', '94111', null, null, null, '17', 'Investment Management', null);
INSERT INTO `sap_client_prosperworks` VALUES ('677', '15473158', 'Alpha Consulting Firm LLC', '1407 Elmwood Ave', 'Columbia', 'South Carolina', '29201', null, null, null, '2', 'Management Consulting', null);
INSERT INTO `sap_client_prosperworks` VALUES ('678', '21916687', 'Align Business Advisory Services', null, 'Winter Park', 'Florida', null, null, null, null, '8', 'Management Consulting', null);
INSERT INTO `sap_client_prosperworks` VALUES ('679', '8906529', 'Agilis Systems, LLC', '16305 Swingley Ridge Road, Suite 100', 'St. Louis', 'Missouri', '63088', null, '$25M-$50M', '100-249', '15', 'Computer Software', null);
INSERT INTO `sap_client_prosperworks` VALUES ('680', '13401136', 'Agelix Consulting LLC', '8500 W. 110th St., Suite 575', 'Overland Park', 'Kansas', '66210', null, '$5M-$10M', '20-49', null, 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('681', '17077306', 'Advoqt Technology Group', '5 Middlesex Avenue, Suite 400', 'Somerville', 'Massachusetts', '2145', null, '$5M-$10M', '20-49', '6', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('682', '14892479', 'Advocate - the Cloud & Connectivity Insiders', '6200 The Corners Parkway', 'Norcross', 'Georgia', '30092', null, '$25M-$50M', '100-249', '17', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('683', '15537745', 'Adi/Pomodo Tech', '414 Ferndale Avenue', 'Johnstown', 'PA', '15905', null, '$1M-$5M', '5-9', '20', 'Program Development', null);
INSERT INTO `sap_client_prosperworks` VALUES ('684', '13761166', 'Ad Hoc Communication Resources LLC', '6 Benevolo Drive', 'Henderson', 'Nevada', '89011', null, '$25M-$50M', '100-249', '22', 'Management Consulting', null);
INSERT INTO `sap_client_prosperworks` VALUES ('685', '19645970', 'Actioneers Mobile', '421 W 3rd St', 'Austin', 'Texas', '78701', null, '$1M-$5M', '10-19', '8', 'Computer Software', null);
INSERT INTO `sap_client_prosperworks` VALUES ('686', '17076527', 'Accurate Building Maintenance Llc', '4435 W Sunset Road', 'Las Vegas', 'Nevada', '89118', null, '$50M-$100M', '250-499', '24', 'Facilities Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('687', '8134377', 'Accelogix', '8000 Regency Parkway Suite 515', 'Cary', 'North Carolina', '27518', null, '$5M-$10M', '20-49', '6', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('688', '16119302', '9throot', '1305 N Commerce Dr Suite 110', 'Saratoga Springs', 'Utah', '84045', null, '$5M-$10M', '20-49', '8', 'Marketing and Advertising', null);
INSERT INTO `sap_client_prosperworks` VALUES ('689', '11670075', '3z.net', '100 E Rivercenter Blvd Suite 300', 'Covington', 'Kentucky', '41011', null, '$5M-$10M', '20-49', '26', 'Information Technology and Services', null);
INSERT INTO `sap_client_prosperworks` VALUES ('690', '15475423', '1106 Design', '610 E Bell Rd', 'Phoenix', 'Arizona', '85022', null, null, null, '17', 'Publishing', null);
INSERT INTO `sap_client_prosperworks` VALUES ('691', '22961075', 'Red Apples Media', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('692', '16964659', 'Delivery Nation', 'PO BOX 246', 'Absecon', 'New Jersey', '08201', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('693', '23164677', 'ASG Strategies', null, 'Hendersonville', 'North Carolina', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('694', '23642999', 'Triradialsolutions', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('695', '24009015', 'American Dream Excavating', null, 'Osage Beach', 'Missouri', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('696', '24168328', 'RAPindex', null, 'Greenville', 'South Carolina', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('697', '23722874', 'Centra360', null, 'Westbury', 'New York', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('698', '23485410', 'TalentSumo', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('699', '22789779', 'The Silver Telegram', null, 'Long Beach', 'California', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('700', '23013137', 'Image Works', null, null, 'Washington', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('701', '23383519', 'Centurion Software Group', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('702', '22726977', 'Treatment Lead Concierges', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('703', '24017004', 'Clutch Technologies', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('704', '23910003', 'Fresh Leads, Inc.', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('705', '21748143', 'The Business Advantage Group Plc', 'Pel House', 'Petts Wood', 'Kent', 'BR5 1LZ', 'GB', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('706', '22768671', 'Leaselock', null, 'Los Angeles', 'California', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('707', '24102794', 'Perlinski & Company', null, 'Laguna Niguel', 'California', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('708', '23484372', 'Bottom Line Safety', null, 'Roscoe', 'Illinois', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('709', '23480537', 'CGT Marketing LLC', null, 'Amityville', 'New York', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('710', '21352460', 'Elite Insurance Services, Inc.', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('711', '23606217', 'Craig Wolynez', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('712', '23531188', 'Pixami', '6754 BERNAL AVENUE, #740-106', 'PLEASANTON', 'California', '94566', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('713', '24030004', 'Smart Energy Decisions', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('714', '23896906', 'ISOutsource', '19119 North Creek Parkway', 'Bothell', 'Washington', '98011', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('715', '21939500', 'Alcor Technical Solutions, LLC', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('716', '24101870', 'Outreach IT Services LLC', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('717', '20275069', 'DidgeBridge LLC', '10401 North Meridian', 'Indianapolis', 'Indiana', '46290', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('718', '21602348', 'Enterprise Unified Solutions', null, 'Indianapolis', 'Indiana', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('719', '23114815', 'Surface Technology, Inc.', null, 'Lancaster', 'Pennsylvania', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('720', '23831819', 'jsagroupllc', null, null, null, null, null, null, null, null, null, '1524456000');
INSERT INTO `sap_client_prosperworks` VALUES ('721', '21235982', 'ScottMadden , Inc.', '750 N Rush St APT 2502', 'Chicago', 'Illinois', '60611', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('722', '24100132', 'Johnson Sterling, Inc.', null, 'Birmingham', 'Alabama', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('723', '24099903', 'No Limit Staffing, Inc.', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('724', '23647279', 'Leegoff', null, 'Dahlonega', 'Georgia', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('725', '22942245', 'Rainmaker Advisory LLC', null, 'Portland', 'Oregon', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('726', '24030011', 'Bbasolutions', '12123 Kanis Rd', 'Little Rock', 'Arkansas', '72211', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('727', '23722210', 'Aaron Capital', '5180 Park Ave', 'Memphis', 'Tennessee', '38119', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('728', '14645088', 'Sapper Consulting, LLC', '8112 Maryland Ave, Ste 400', 'St. Louis, Missouri', 'Missouri', '63105', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('729', '23672421', 'Century Park Capital Partners', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('730', '23283399', 'Area 101', 'PO 8153', 'Breckenridge', 'Colorado', '80424', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('731', '23386554', 'Microsan Consultancy Services', null, 'Ogden', 'Utah', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('732', '18974279', 'Teague Insurance Agency, Inc.', '318 Main St', 'Teague', 'Texas', '75860-1622', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('733', '20977908', 'TK Interactive', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('734', '22228752', 'Gauge Capital', '1256 Main Street, Suite 256', 'Southlake', 'Texas', '76092', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('735', '24016400', 'Respondsive.com', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('736', '23202377', 'Fearless Media', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('737', '23607154', 'SeverSim', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('738', '23886392', 'EVERMETHOD, Inc.', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('739', '21913499', 'Morales Group', '5628 W 74th Street', 'Indianapolis', 'Indiana', '46278', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('740', '21292689', 'Chapman Farrell Group', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('741', '23322816', 'Connections Marketing', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('742', '21706108', 'Southwest Risk Management, LLC', '2855 E. Brown Rd., STE #28', 'Mesa', 'Arizona', '85213', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('743', '18985540', 'The Ebco', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('744', '23836135', 'Flagler Financial, Inc.', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('745', '22540557', 'ReconaSense', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('746', '22315863', '4 Way Logistics, Inc.', '2303 Camino Ramon, Suite 135', 'San Ramon', 'California', '94583', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('747', '23831377', 'Summerlin Benefits Consulting', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('748', '23249467', 'GPI Networks', null, 'Plano', 'Texas', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('749', '15792112', 'BioLogix Systems Corporation', null, 'St. Louis', 'Missouri', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('750', '23895976', 'Summerlin Roberts', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('751', '20977974', 'Mentoring Minds LP', 'P.O. Box 8843', 'Tyler', 'Texas', '75703', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('752', '23890469', 'REAL Controls, Inc.', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('753', '21023807', 'Dynamic System Solutions, LLC', '2604 10th Street', 'Wyandotte', 'Michigan', '48192', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('754', '21840062', 'Acronym Media Inc', 'Empire State Building', 'New York', 'New York', '10118', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('755', '23550219', 'Top2d3d Studios', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('756', '23550773', 'TriPax Resources', null, 'Taylorsville', 'North Carolina', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('757', '10011741', 'Des Plaines Office Equipment', '1020 Bonaventure Drive', 'Elk Grove Village', 'Illinois', '60007', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('758', '23604127', 'Strategic E Marketing', '4368 RIDGECREST PL.', 'EUREKA', 'California', '95503', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('759', '21939345', 'Apteam', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('760', '20643820', 'Tax Savings Pros', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('761', '22271172', 'Mohr Partners, Inc.', null, 'Dallas', 'Texas', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('762', '21703978', 'Local Reputation Management LLC', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('763', '23783484', 'Fbssystems', null, 'Atlanta', 'Georgia', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('764', '23443375', 'Access Marketing Company', '6855 S Havana Street, Suite 400', 'Centennial', 'Colorado', '80112', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('765', '21769802', 'Receiving Company', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('766', '22965366', 'Kruseassoc', '8596 East 101st Street', 'Tulsa', 'Oklahoma', '74133', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('767', '23402266', 'Windy City Marketing', '1336 W Grand Ave Ste 1', 'Chicago', 'Illinois', '60642', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('768', '23647539', 'Hippocharging', '724 E 1st St, Ste 300', 'Los Angeles', 'California', '90012', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('769', '23644038', 'Terawatt Roofing LLC', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('770', '22781085', 'Consumer Clarity', null, 'Cincinnati', 'Ohio', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('771', '23105893', 'Qualiware', null, 'New York', 'New York', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('772', '23383137', 'Mtci', '11260 Chester Road', 'Cincinnati', 'Ohio', '45246', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('773', '21053394', 'Avaria Networks', '5540 Centerview Drive', 'Raleigh', 'North Carolina', '27606', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('774', '23678422', 'goodideaZS', null, 'Montclair', 'New Jersey', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('775', '23677971', 'PCA Audio Design', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('776', '22846025', 'Structureexhibits', '4548 Calimesa Street', 'Las Vegas', 'Nevada', '89115', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('777', '23330492', 'Industrial Skins', '500 W 2nd St', 'Cozad', 'Nebraska', '69130', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('778', '22541200', 'Olympicequipment', '3401 Etiwanda Avenue', 'Mira Loma', 'California', '91752', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('779', '21822799', 'Efinancial LLC', null, 'Seattle', 'Washington', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('780', '23543587', 'Entrinsik', null, 'Raleigh', 'North Carolina', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('781', '20691901', 'NDI (Network Documentation and Implementation Inc)', null, 'Bogota', 'New Jersey', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('782', '22560893', 'TruLine Driver Solutions', null, 'Florence', 'Kentucky', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('783', '20209590', 'Silverback Insights', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('784', '21234678', 'AuthorIT Software Corporation', null, 'Seattle', 'Washington', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('785', '23283288', 'Sprocketexpress', '23 W Bacon St Ste 5', 'Plainville', 'Massachusetts', '02762', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('786', '22940622', 'Ifsworld', 'Flight Forum 3450', 'Eindhoven', 'Noord-brabant', '5657 EW', 'NL', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('787', '21187816', 'Lake Norman Benefits Inc', '109 Professional Park Drive', 'Mooresville', 'North Carolina', '28117', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('788', '21356810', 'Advanced Systems Inc', '8280 Willow Oaks Corporate Drive', 'Fairfax', 'Virginia', '22031', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('789', '23256829', 'Hydrasat', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('790', '21825302', 'BPK Technologies', null, 'Savage', 'Minnesota', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('791', '23605459', 'College of Saint Benedict and Saint John’s University', null, 'Saint Joseph', 'Minnesota', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('792', '23603069', 'Vision-e', null, 'Greenville', 'South Carolina', null, 'US', null, null, null, null, '1523595600');
INSERT INTO `sap_client_prosperworks` VALUES ('793', '23603487', 'NuPulse Pro', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('794', '21408986', 'Angeles Investment Advisors, LLC', '429 Santa Monica Boulevard', 'Santa Monica', 'California', '90401', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('795', '23249284', 'Jahani & Associates', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('796', '22136896', 'Connect the Dots Consulting', '5930 Wilcox Place', 'Dublin', 'Ohio', '43016', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('797', '21820101', 'Garnier Group', null, 'San Diego', 'California', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('798', '22810535', 'Pacific Street Capital', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('799', '23207027', 'Rxcinternational', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('800', '22969480', 'Artemis Partners', null, 'Houston', 'Texas', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('801', '21954250', 'Zventus', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('802', '23514868', 'Corporate Synergies Group, LLC', '5000 Dearborn Circle', 'Mount Laurel', 'New Jersey', '08054', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('803', '21279657', 'Stout Advisory', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('804', '22610670', 'Legence Bank', '1200 US HIGHWAY 45 N', 'ELDORADO', 'Illinois', '62930-3765', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('805', '22278852', 'Dadee Manufacturing', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('806', '23453700', 'Ameritext HQ', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('807', '20348491', 'Chase Cost Management Inc', 'One Penn Plaza', 'New York', 'New York', '10119', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('808', '22915665', 'Twparchitects', '4125 Lakeland Ave N Ste. 200', 'Minneapolis', 'MN', '55422', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('809', '22814007', 'CommerceWest Bank', null, null, null, null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('810', '23383225', 'Earlybird Software', null, 'Chicago', 'Illinois', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('811', '20677218', 'Waterlogic Plc', null, 'Gilbert', 'Arizona', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('812', '23126020', 'TeamTrinet', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('813', '22914520', 'Pingmobile', null, 'Beverly Hills', 'California', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('814', '22182489', 'Prager Creative', null, 'New York', 'New York', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('815', '22950605', 'Visual Computer Solutions, Inc.', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('816', '23246402', 'The Meyer Group', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('817', '22970425', 'EasyCare, Inc.', '6010 Atlantic Boulevard', 'Norcross', 'Georgia', '30071', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('818', '23057761', 'PFS Insurance Group', '4848 Thompson Pkwy, # 200', 'Johnstown', 'Colorado', '80534', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('819', '21051794', 'Critical Environments Group', '104 Maple Leaf Court', 'Glassboro', 'New Jersey', '08028', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('820', '22689264', 'Assisted Networks, LLC', null, 'Charlotte', 'North Carolina', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('821', '23322659', 'Marketing Connections', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('822', '22919614', 'Service Management Group Inc', null, 'Hattiesburg', 'Mississippi', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('823', '19639253', 'Ideal Content', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('824', '23172064', 'SGNY', null, 'New York', 'New York', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('825', '22542949', 'GGC Synergy, LLC', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('826', '23169641', 'One Source Screening', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('827', '21705987', 'Bolstra', '12400 N. Meridian St.', 'Carmel', 'Indiana', '46032', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('828', '22064335', 'TechZone Networks Inc', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('829', '22571372', 'Ameri100', '100 Canal Pointe BLVD,STE 108', 'Princeton', 'New Jersey', '08540', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('830', '22384854', 'Bonobo', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('831', '13254285', 'Sysazzle, Inc.', '1225 W. 190th St.', 'Gardena', 'California', '90248', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('832', '23057344', 'Valeocon', null, 'New York', 'New York', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('833', '23251654', 'Re-Vision Management Consulting', null, 'Houston', 'Texas', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('834', '23249236', 'Edifecs', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('835', '20817416', 'Industrial Visions Company LLC', '2400 Oxford Drive', 'Bethel Park', 'Pennsylvania', '15102', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('836', '23217238', 'Onmicrosoft', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('837', '23217263', 'Continuum Systems', '501 New Karner Rd', 'Albany', 'New York', '12205-3882', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('838', '18238383', 'Gravity Benefits', '26701 Dublin Woods Cir, Fl 2nd', 'Bonita Springs', 'Florida', '34135', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('839', '21623466', 'Cosmos IT Solutions Inc', '6103 Sw 26th St Apt A', 'Topeka', 'Kansas', '66614', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('840', '23165341', 'Royal4', '5000 E Spring St Ste 415', 'Long Beach', 'California', '90815', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('841', '19013616', 'Friedlander Group, Inc.', 'Suite 400A', 'Purchase', 'New York', '10577', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('842', '23207055', 'Controlgroupusa', '500 Walnut St.', 'Norwood', 'New Jersey', '07648', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('843', '23129361', 'MIMIKIDZ', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('844', '22811276', 'Solutions North Bank', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('845', '21704378', 'Pharmica Consulting LLC.', '5744 Berkshire Valley Rd #266', 'Oak Ridge', 'New Jersey', '07438', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('846', '13510341', 'TeamLogic IT of North Milwaukee', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('847', '23162948', 'Ameex Technologies Corp.', null, 'Chicago', 'Illinois', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('848', '22113681', 'Catalog Data Solutions', null, 'Cupertino', 'California', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('849', '23040219', 'Zorallabs', '88 Wood Street', 'London', null, 'EC2V 7RS', 'GB', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('850', '21601630', 'ButcherJoseph & Co.', '101 S. Hanley Rd., Suite 1450', 'St. Louis', 'Missouri', '63105', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('851', '22819235', 'Enteractive Solutions Group', '1612 West Olive Avenue, Suite 300', 'Burbank', 'California', '91506', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('852', '22314559', 'Rastrac Net, Inc.', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('853', '22847780', 'Prime Building & Construction, LLC', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('854', '22313316', 'Preferred Communication Systems', '18521 Spring Creek Drive', 'Tinley Park', 'Illinois', '60477', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('855', '23051555', 'Devil Tech', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('856', '13978152', 'TeamLogic IT of Jackson, Mississippi', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('857', '20645044', 'TOTALogistix', '191 Woodport Rd', 'Sparta', 'New Jersey', '07871', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('858', '23040413', 'call Steve', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('859', '18623473', 'Insight Equity', '1400 Civic Place, Suite 250', 'Southlake', 'Texas', '76092', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('860', '18237173', 'Powerhouse Retail Services, LLC', '13044 Ne 14th St', 'Alleman', 'Iowa', '50007', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('861', '21953369', 'Compact Solutions', null, null, 'New Jersey', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('862', '20527724', 'Indigo Slate', '14475 NE 24th st, Suite 110', 'Bellevue', 'Washington', '98007', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('863', '20526080', 'Joandunard', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('864', '22945850', 'Vision Path Marketing', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('865', '21872079', 'In-Sys Solutions, Inc.', null, null, null, '60048', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('866', '21859426', 'Admiral Consulting Group LLC', null, 'East Brunswick', 'New Jersey', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('867', '22168478', 'Municipal Revenue Service Inc', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('868', '21533460', 'Wrkit', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('869', '22460076', 'Maintenance One', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('870', '20396530', 'Lippincott', null, 'New York', 'New York', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('871', '21920851', 'Documents & Design (D2)', null, 'North Sioux', 'South Dakota', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('872', '22635941', 'Figmarketing', '19520 W Catwba Ave #112', 'Cornelius', 'North Carolina', '28031', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('873', '21239646', 'InSite Search', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('874', '21939529', 'Gabriel Group', '3190 Rider Trail South', 'Earth City', 'Missouri', '63045', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('875', '22635909', 'Rheacom', '2055 Gateway Pl Ste 400', 'San Jose', 'California', '95110', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('876', '22635851', 'Ciotalknetwork', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('877', '21939522', 'Dino-Associates', '..', 'Orlando, FL', 'Florida', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('878', '22330008', 'Tekdynamics Inc.', '1425 Greenway Dr Ste 290', 'Irving', 'Texas', '75038', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('879', '22328605', 'KAIZEN Sales Strategy', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('880', '22936613', 'Solar Age USA', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('881', '22570747', 'RESTRAT', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('882', '21648380', 'Liquiddatasystems', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('883', '20643750', 'Business Data Record Services', null, 'New Brighton', 'Pennsylvania', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('884', '22737917', 'Lifetimebenefitsolutions', '115 Continuum Drive', 'Liverpool', 'New York', '13088', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('885', '22611367', 'Compassdesign', '1061G Serpentine Lane', 'Pleasanton', 'California', '94566', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('886', '22787668', 'Rushcode IT Solutions Pvt Ltd', null, 'Nagar', 'Rajasthan', null, 'IN', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('887', '22780495', 'FHS Associates', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('888', '22227633', 'The AME Group', null, 'Indianapolis', 'Indiana', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('889', '16365725', 'DCRS', '2605 Metro Blvd', 'Maryland Heights', 'Missouri', '63043', 'United States', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('890', '22847715', 'Primebc', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('891', '14874578', 'White Ware, Inc.', '2222 Wealthy St SE', 'East Grand Rapids', 'Michigan', '49506', 'United States', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('892', '15522214', 'PinPoint Resources', '6350 Shadeland Ave', 'Indianapolis', 'Indiana', '46220', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('893', '14087948', 'CRU Solutions', '7261 Engle Rd, Ste 305', 'Cleveland', 'Ohio', '44130', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('894', '22329305', 'ICAP-Intellectual Capitol', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('895', '20013517', 'New Road Capital Partners', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('896', '21817477', 'Kovair Inc.', '2410 Camino Ramon, STE 230', 'San Ramon', 'California', '94583', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('897', '22543285', 'Cts3solutions', '3845 Investment Lane', 'WPB', 'Florida', '33404', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('898', '22808266', 'MSalesLeads', null, 'Miami', 'Florida', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('899', '21194415', 'Boyden Corporation', null, 'San Francisco', 'California', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('900', '20811137', 'Skelia sarl', null, 'Keerbergen', 'Flanders', null, 'BE', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('901', '20229209', 'Tandem Group, Inc.', '161 North Clark Street', 'Chicago', 'Illinois', '60601', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('902', '20036145', 'Anchor Computer, Inc.', '1900 New Hwy', 'Farmingdale', 'New York', '11735', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('903', '18105854', 'S&P Consultants, Inc.', null, null, 'Massachusetts', '2184', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('904', '22387642', 'EMPO Corporation', '3100 West Lake Street', 'Minneapolis', 'Minnesota', '55416', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('905', '22057687', 'Total IT Inc', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('906', '21662231', 'Interactive Metronome', '13798 NW 4th St', 'Sunrise', 'Florida', '33325', 'United States', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('907', '22788694', 'Bremen Group, Inc.', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('908', '21768424', 'SXN Strategy Partners', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('909', '21629545', 'AP Professionals', '5110 Main Street, Suite 200', 'Williamsville', 'New York', '14221', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('910', '22639485', 'Insightpartners', '401 E 83rd St Apt 4b', 'New York', 'New York', '10028-6192', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('911', '21017854', 'NorthStar Solutions Group LLC', '12424 Res Pkwy Ste 260', 'Orlando', 'Florida', '32826', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('912', '22689587', 'The Ayta Group', null, 'Greenville', 'South Carolina', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('913', '22730027', 'Tolleson Audio Visual', null, 'Houston', 'Texas', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('914', '22620337', 'iTNETWORX Corporation', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('915', '22726790', 'Swattage', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('916', '11617489', 'Design Master Software', null, null, null, '98155', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('917', '16712229', 'Cuttercroix', '16600 Sprague Road', 'Middleburg Heights', 'Ohio', '44130', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('918', '22280314', 'GAWK INC', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('919', '20705099', 'Case Pearlman LLC', '7780 Cambridge Manor Place', 'Fort Myers', 'Florida', '33907', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('920', '22397442', 'Commercial Maintenance Services, LLC', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('921', '21840002', 'HealthEdge Investment Partners LLC', '100 S Ashley Dr Ste 650', 'Tampa', 'Florida', '33602', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('922', '21939485', 'DATAPROSE INC', '1122 W Bethel Rd Ste 100', 'Coppell', 'Texas', '75019', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('923', '21939510', 'Nytec Inc', '416 6th Street South', 'Kirkland', 'Washington', '98033', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('924', '21054058', 'Flowerpot Media LLC', null, 'San Francisco', 'California', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('925', '21362266', 'Avery Partners LLC', '1805 Old Alabama Rd, Ste 200', 'Roswell', 'Georgia', '30076', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('926', '21301162', 'Exegy Inc', '349 Marshall Ave', 'St. Louis', 'Missouri', '63119', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('927', '21871826', 'Atlantic Talent Acquisition Consultants, Inc', null, 'Durham', 'North Carolina', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('928', '22218618', 'D4 Insight', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('929', '22611368', 'Molded Devices Inc', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('930', '18897002', 'GLS Staffing Inc.', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('931', '21919750', 'ForeverLawn at the Shore', '99 Derby St.', 'Hingham', 'Massachusetts', '02043', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('932', '21005682', 'T Squared Group', null, 'Area', 'Illinois', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('933', '22541983', 'Executive Decisions Search Group', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('934', '20826205', 'Birlasoft Enterprises Ltd.', 'H-9, Sector-63', 'Noida', 'Up', '201306', 'India', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('935', '20085394', 'Competitive Solutions, Inc.', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('936', '22462166', 'Sterling Search and Consulting', null, 'Jacksonville', 'Florida', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('937', '21820725', 'Tvisha Technologies Inc', '505 Thornall St', 'Edison', 'New Jersey', '08837', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('938', '21606507', 'Banister International', '1363 Shermer Road', 'Northbrook', 'Illinois', '60062', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('939', '21977054', 'AimSmart', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('940', '22388241', 'Tulfra Real Estate', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('941', '21926743', 'Eb3systems L.L.C', null, 'Scottsdale', 'Arizona', '85251', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('942', '19519242', 'Fiserv Inc', '255 Fiserv Drive', 'Brookfield', 'Wisconsin', '53045', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('943', '22131454', 'Joule Smart, LLC', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('944', '16546961', 'Quaero Corporation', null, 'Charlotte', 'North Carolina', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('945', '21666824', 'Resource Alliance LLC', '1725 Windward Concourse', 'Alpharetta', 'Georgia', '30005', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('946', '21934284', 'Curtis Perry\'s Company', null, 'Quincy', 'Massachusetts', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('947', '22214900', 'Westwood Partners LLC', '51 West 52nd Street', 'New York', 'New York', '10019', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('948', '18450629', 'The Agency Project', null, 'Fort Worth', 'Texas', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('949', '21701646', 'Tranxition Corporation', null, 'Phoenix', 'Arizona', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('950', '22352804', 'GBS Corporation', '7233 Freedom Ave NW', 'North Canton', 'Ohio', '44720', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('951', '22265428', 'Social-Apps.Co', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('952', '21947922', 'Quantum Flow Coaching', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('953', '21082479', 'BDO USA, LLP', 'Immeuble Ennour 3ème étage Centre Urbain Nord', null, null, '1082', 'TN', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('954', '13815199', 'Botsaris Morris Realty Group', null, null, null, null, 'United States', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('955', '17707808', 'USL Cargo Services', '3501 Jamboree Rd', 'Newport Beach', 'California', '92660', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('956', '22314553', 'Manning NavComp, Inc.', '13809 Research Blvd.', 'Austin', 'Texas', '78750', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('957', '18434646', 'Kinsey & Kinsey Inc', '26 N park Blvd', 'Glen Ellyn', 'Illinois', '60137', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('958', '20092001', 'Frontier Capital LLC', '45 Mahogany Dr', 'Buffalo', 'New York', '14221-2420', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('959', '20294276', 'The Pepper Group', '220 N. Smith Street', 'Palatine', 'Illinois', '60067', 'United States', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('960', '21977324', 'West Industries', '2158 Beaumont Dr.', 'Baton Rouge', 'Louisiana', '70806', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('961', '17410282', 'APP Design, Inc.', '555 W Pierce Rd Ste 195', 'Itasca', 'Illinois', '60143', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('962', '12430130', 'American Consultants', '9359 W. 75th Street', 'Overland Park', 'Kansas', '66204', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('963', '21826137', 'Interactive Advantage Corporation', '2920 Horizon Park Drive', 'Suwanee', 'Georgia', '30024', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('964', '17575165', 'Relevant Healthcare', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('965', '21817506', 'Medical Doctor Associates', '3056 Cherokee St NW', 'Kennesaw', 'Georgia', '30144-2828', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('966', '21818964', 'Blue Forest Technologies LLC', '14 Wall St', 'New York', 'New York', '10005', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('967', '21918925', 'Mobile IT', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('968', '19070171', 'Allstar Consulting Group', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('969', '21856578', 'Pella of St. Louis', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('970', '21231187', 'NAVOMI Inc', '760 Old Roswell Rd #126', 'Roswell', 'Georgia', '30076', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('971', '19146052', 'Beltech', null, 'Grand Rapids', 'Michigan', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('972', '20003610', 'TeamLogic IT of Vancouver, WA', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('973', '22065606', 'Integris Group', null, 'Peoria', 'Illinois', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('974', '21230269', 'Discovery Search Partners Inc', null, 'Haddonfield', 'New Jersey', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('975', '22061222', 'C-Vision Inc', null, 'Detroit', 'Michigan', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('976', '22172398', 'Scooley Mitchell Scottsdale', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('977', '20875654', 'Pharmacy Development Services', '2459 S. Congress Avenue', 'Palm Springs', 'Florida', '33406', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('978', '16326411', 'Oldham Goodwin Group, LLC', '2800 South Texas Avenue, Suite 401', 'Bryan', 'Texas', '77802', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('979', '20537504', 'Executive Partners Inc', null, 'North Barrington', 'Illinois', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('980', '21939549', 'WalzIT', '2929 Lititz Pike', 'Lancaster', 'Pennsylvania', '19606-5555', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('981', '20723802', 'Bedford Energy Consultants', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('982', '18032032', 'Femi Fashakin\'s Company', null, 'Orlando', 'Florida', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('983', '21018933', 'Premier Business Advantage', null, 'Ballwin', 'Missouri', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('984', '20435919', 'Brandywine Insurance Advisors, LLC', null, 'Devon', 'Pennsylvania', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('985', '20986378', 'Automation Trainer, LLC', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('986', '20747514', 'Gymney', null, 'Denham Springs', 'Louisiana', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('987', '20596061', 'Surveillance Solutions', null, 'San Antonio', 'Texas', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('988', '20814651', 'Mehco Custom Printing', null, 'North Ridgeville', 'Ohio', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('989', '20895454', 'NeoTek Labs, LLC', null, 'Austin', 'Texas', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('990', '20285788', 'Image Relay', '1 Lawson Ln', 'Burlington', 'Vermont', '05401', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('991', '20091939', 'Brightly', '1430 Monroe Ave NW #180', 'Grand Rapids', 'MI', '49505', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('992', '20278468', 'Easyworkorder.com, Inc', null, 'Oakland', 'California', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('993', '19437529', 'Tal Iashiv\'s Company', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('994', '20596830', 'Floodbrothers', '610 Waterfront Dr Sw', 'Atlanta', 'Georgia', '30336', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('995', '22075602', 'MX Strategies', null, 'West Chester', 'Pennsylvania', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('996', '21854900', 'Custom Business Solutions , Inc.', null, null, null, null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('997', '22060867', 'True North', '70 NE Loop 410, Suite 850', 'San Antonio', 'Texas', '78216', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('998', '20505042', 'Expense Reduction Analysts', '16415 Addison Road', 'Addison', 'Texas', '75001', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('999', '16047759', 'MC Sign Company', '8959 Tyler Blvd', 'Mentor', 'Ohio', '44060', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1000', '21407521', 'Health Data & Management Solutions , Inc.', '550 West Washington Ave', 'Chicago', 'Illinois', '60661', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1001', '20978603', 'Kahn , Litwin , Renza & Co. , Ltd.', '951 North Main Street', 'Providence', 'Rhode Island', '02904', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1002', '21239808', 'UtiliWorks Consulting LLC', '2351 Energy Drive', 'Baton Rouge', 'Louisiana', '70808', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1003', '21005450', 'Gosset Group Planning', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1004', '15467770', 'Globiox', '10200 US Hwy 290 W', 'Austin', 'Texas', '78736', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1005', '21920473', 'Brädo Creative Insight', '1000 Clark Avenue', 'Saint Louis', 'Missouri', '63102', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1006', '21825889', 'EugeneLogan.com', null, 'Columbia', 'Missouri', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1007', '18490775', 'FASTSIGNS®', '2542 Highalnder Way', 'Carrollton', 'Texas', '75006', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1008', '21555205', 'Awning and Sign Contractors', '203 W Harcourt Rd', 'Angola', 'Indiana', '46703', 'United States', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1009', '20874071', 'Window Book, Inc.', '300 Franklin St', 'Cambridge', 'Massachusetts', '02139-3781', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1010', '18197266', 'Nytera Internet Technologies, LLC', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1011', '16883264', 'Global Partners, Inc.', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1012', '21816789', 'Franchise Test 1', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1013', '18018871', 'Kelser Corporation', '43 Western Boulevard', 'Glastonbury', 'Connecticut', '06033', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1014', '21352155', 'True Incentive', null, 'Fort Lauderdale', 'Florida', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1015', '21665436', 'Global Blue DVBE INC', '3715 Atherton Drive #2', 'Rocklin', 'California', '95765', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1016', '18251525', 'Ponder & Co.', null, null, 'Illinois', '60601', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1017', '19146287', 'The Kerry Group', '44 Soccer Park Drive', 'Fenton', 'Missouri', '63026', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1018', '14400150', 'Drake Consulting Group, LLC', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1019', '16289460', 'Lake Street Capital Markets', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1020', '16045266', 'Creative Print Products Inc', '243 Whitney Street', 'Leominster', null, '01453', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1021', '15495862', 'Modern Postcard', '1675 Faraday Ave', 'Carlsbad', 'California', '92008', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1022', '17803862', 'Tri Tuns, LLC', '7625 Wisconsin Ave.', 'Bethesda', 'Maryland', '20814', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1023', '18005845', 'Verinovum LLC', '16 E 16th St', 'Tulsa', 'Oklahoma', '74119', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1024', '18362653', 'PG Exhibits Inc', null, null, 'Colorado', '80011', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1025', '17565197', 'Cyberspect', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1026', '16973075', 'Corporate Screening Services, Inc.', '16530 Commerce Court', 'Cleveland', 'Ohio', '44130', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1027', '18212703', 'McDermott Costa Insurance', '1045 MacArthur Boulevard', 'San Leandro', 'California', '94577', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1028', '16416872', 'Sheer Logistics', '530 Maryville Centre Dr', 'St. Louis', 'Missouri', '63141', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1029', '17416197', 'Imagineer Technology Group, Inc.', '551 Madison Avenue', 'New York', 'New York', '10022', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1030', '15467727', 'ADMARK Branding, Marketing, Web & Apps', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1031', '15447582', 'Michaels Wilder, Inc.', '7773 West Golden Lane', 'Peoria', 'Arizona', '85345', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1032', '14772924', 'Liberty Insurance Agency', null, 'Pittsburgh', 'Pennsylvania', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1033', '14684372', 'Mindstack Consulting', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1034', '14550788', 'The Colibri Group', null, 'Providence', 'Rhode Island', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1035', '14355340', 'CD1 price cleaners', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1036', '14334185', 'G100', '630 Fifth Avenue', 'New York', 'New York', '10111', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1037', '14179498', 'Unvired, Inc.', null, 'Houston', 'Texas', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1038', '14177818', 'Xpolinate', null, 'Los Angeles', 'California', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1039', '14684133', 'FRANKLIN COVEY CO', '1131 Cumberland Mall SE', 'Atlanta', 'Georgia', '30339-3134', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1040', '20094654', 'Stern Stewart & Co.', null, 'New York', 'New York', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1041', '19975294', 'Tenco Assemblies, Inc.', '620 Nolan Ave', 'Morrisville', 'Pennsylvania', '19067', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1042', '19165048', 'The Answer Company', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1043', '21080745', 'Liberty Technology Advisors Inc', '3100 Dundee Road', 'Northbrook', 'Illinois', '60062', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1044', '21234823', 'Pragmatyxs Inc', '20415 72nd Ave South', 'Kent', 'Washington', '98032', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1045', '16480127', 'Workforce IT', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1046', '19071807', 'Wildmor Advisors', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1047', '18712009', 'WholeStack Solutions LLC', '1906 Wyandotte Street', 'Kansas City', 'Missouri', '64108', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1048', '19066553', 'Volk Company', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1049', '18317112', 'Virtual Tech Gurus, Inc.', '5050 Quorum Drive', 'Dallas', 'Texas', '75254', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1050', '18325476', 'TriCap Technology Group', '35 Harrison Street', 'Jamestown', 'New York', '14701', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1051', '18895418', 'Thomas Financial Group LLC', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1052', '18238162', 'Technology Integration Group', '5800 Granite Pkwy', 'Plano', 'Texas', '75024-6614', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1053', '16186153', 'Technology Concepts Group, Inc.', '1701 Broadmoor Drive', 'Champaign', 'Illinois', '61821', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1054', '18586997', 'Tarkington & Harwell Company', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1055', '18703938', 'Target Electric', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1056', '16187333', 'Ran Meriaz\'s Company', null, 'Warner Robins', 'Georgia', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1057', '12119540', 'Entre Technology Services, LLC', 'Evergreen Center North', 'Billings', 'Montana', '59102', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1058', '21750149', 'Clearwave', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1059', '19433198', '1LL Design', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1060', '16136259', 'Global Guardian, LLC', '8280 Greensboro Drive', 'McLean', 'Virginia', '22102', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1061', '20713762', 'Automated Logistics Systems LLC', '3517 Scheele Dr', 'Jackson, MI 49202', 'Michigan', '49202', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1062', '17781791', 'SpeedyIT360', '13980 Nw 58th Ct', 'Miami Lakes', 'Florida', '33014', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1063', '19064537', 'SIMPLIFIED LOGISTICS LLC', '28915 Clemens Rd', 'Westlake', 'Ohio', '44145', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1064', '18237099', 'Reprints Desk Inc', '5435 Balboa Blvd., Suite 202', 'Encino', 'California', '91316', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1065', '19302336', 'murdockpro', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1066', '18702358', 'Landmark Ventures', '475 Park Avenue South', 'New York', 'New York', '10016', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1067', '16964750', 'Kirtland Capital Partners', '3201 Enterprise Parkway', 'Beachwood', 'Ohio', '44122', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1068', '17755219', 'Jayroe, Lordo & Catalano P.A.', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1069', '16180791', 'Graemouse Technologies LLC', '10116 36th Ave CT SW #308', 'Lakewood', 'Washington', '98499', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1070', '18707314', 'Entrepid', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1071', '18047458', 'DBM Communications', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1072', '15697282', 'Davis Capital', null, 'Chicago', 'Illinois', null, 'United States', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1073', '16319650', 'Outsource Freight Inc', '72 Sharp St Ste C11', 'Hingham', 'Massachusetts', '02043', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1074', '19137577', 'Clayton Kendall Inc', '167 Dexter Drive', 'Monroeville', 'Pennsylvania', '15146', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1075', '19515791', 'Big Fish Payroll Services, Llc', null, null, 'California', '92867-5036', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1076', '15858634', 'MRS Associates , Inc.', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1077', '17718577', 'Betesh Media', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1078', '18316288', 'Beirne Wealth Consulting LLC', '3 Enterprise Drive', 'Shelton', 'Connecticut', '06484', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1079', '18470161', 'Applied Information Sciences, Inc.', '11400 Commerce Park Drive Suite 600', 'Reston', 'Virginia', '20191', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1080', '19623790', 'Barracuda Networks Inc', 'Rennweg 97-99', 'Vienna', null, 'A-1030', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1081', '17699461', 'Wilks Communications Group', '1033 South Boulevard', 'Oak Park', 'Illinois', '60302', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1082', '15638030', 'Secura Consultants Inc', '6465 Wayzata Boulevard', 'Minneapolis', 'Minnesota', '55426', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1083', '17028464', 'Mazumausa', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1084', '18117773', 'Asterand Bioscience Inc', null, null, 'Herefordshire', null, 'GB', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1085', '19972909', 'Marturano Recreation Company', null, 'Spring Lake', 'New Jersey', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1086', '15472166', 'Infosurv, Inc.', '980 Hammond Drive', 'Atlanta', 'Georgia', '30328', 'United States', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1087', '16963023', 'Dmorph, Inc', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1088', '18451162', 'DFS Solutions', null, 'Winston Salem', 'North Carolina', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1089', '20046909', 'FMFA Inc', null, 'Bangalore', 'Karnataka', null, 'IN', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1090', '19434724', 'Overdrive Brands, LLC', null, 'Brecksville', 'Ohio', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1091', '14892553', 'Environmental Testing & Consulting, Inc (the ETC Group)', null, null, 'Michigan', '48174-1159', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1092', '19620109', 'First Source Consulting', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1093', '19011112', 'Ajax Union Inc', null, 'Brooklyn', 'New York', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1094', '15750941', 'Loop Communications LLC', '1000 NC Music Factory Blvd', 'Charlotte', 'North Carolina', '28206', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1095', '19064530', 'Marketery Media, LLC', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1096', '16374479', 'Connections for Business', '49 Avon Road', 'Altrincham', null, null, 'GB', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1097', '19082044', 'Nexiix Marketing', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1098', '18899758', 'Commercial Real Estate Solutions Of Jacksonville', '514-1 Chaffee Point Boulevard', 'Jacksonville', 'Florida', '32221', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1099', '16227184', 'BioPet Vet Lab', '6727 Baum Drive', 'Knoxville', 'Tennessee', '37919', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1100', '19083994', 'Queue Technologies', null, 'San Francisco', 'California', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1101', '15305618', 'MK Tech Group , Inc.', null, 'Coral Springs', 'Florida', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1102', '12437307', 'RMS Hospitality Group', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1103', '16566259', 'BPO Systems Inc.', '2099 Mt. Diablo Blvd.', 'Walnut Creek', 'California', '94596', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1104', '16623833', 'Medical Delivery Systems', '7070 S 220th St', 'Kent', 'Washington', '98032', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1105', '13430652', 'CirrusWorks Inc', '510 N Washington St', 'Falls Church', 'Virginia', '22046', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1106', '18248592', 'Ashton Feller\'s Company', null, 'Phoenix', 'Arizona', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1107', '14690958', '14 West LLC', '1121 Marlin Court, Suite A', 'Waukesha', 'Wisconsin', '53186', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1108', '7579568', 'Pilgrim Mat Services', '1815 Fellowship Road', 'Tucker', 'Georgia', '30084', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1109', '14416514', 'Levelx Consulting', 'Two Prudential Plaza', 'Chicago', 'Illinois', '60601', 'United States', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1110', '12815565', 'Group 50', '2576 Euclid Crescent East', 'Upland', 'California', '91784', 'United States', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1111', '18002995', 'Rich Berland\'s Company', null, 'San Diego', 'California', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1112', '18466404', 'Veebidisainer', null, 'Tallinn', 'Harjumaa', null, 'EE', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1113', '12874677', 'The Floriss Group LLC', 'PO Box 113', 'Columbus', 'Ohio', '43035', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1114', '15985793', 'Lincoln Waste Solutions, LLC', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1115', '12751168', 'ArthurBiz Advisors', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1116', '16793445', 'Antra', '21355 Ridgetop Circle', 'Dulles', 'Virginia', '20166', 'United States', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1117', '16586993', 'BAM Social Business', '1009 16th Avenue S.', 'Nashville', 'Tennessee', '37212', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1118', '13854151', 'ChefTec Software', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1119', '15467900', 'Scalable Software Inc', null, null, 'Texas', '78701', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1120', '20860147', 'Maru/edr', 'The HUB', 'Hedge End', 'Hampshire', 'SO30 2UN', 'GB', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1121', '21190784', 'Tax Help MD Inc', '8409 N Military Trl #109', 'West Palm Beach', 'Florida', '33410', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1122', '20681235', 'Astoundry Inc', '2441 Bartlett St', 'Houston', 'Texas', '77098', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1123', '21749307', 'Prescott\'s, Inc', '18940 Emigrant Trail East', 'Monument', 'Colorado', '80132', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1124', '21746158', 'Blake Widgets', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1125', '20229810', 'Riverlake Partners, LLC', null, null, 'Oregon', '97205', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1126', '21408121', 'Fraxcion', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1127', '21119038', 'Florida Alarm', 'Seffner St.', 'Seffner', 'Florida', '33584', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1128', '21093014', 'Harris Technologies', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1129', '21194998', 'Coyle Hospitality Group', '244 Madison Ave #369', 'New York', 'New York', '10016', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1130', '20877737', 'Marimon Business Systems Inc', '7300 North Gessner', 'Houston', 'Texas', '77040', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1131', '20860132', 'Health Care Technical Solutions', '211 Warren Street', 'Newark', 'New Jersey', '07103', 'United States', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1132', '20728249', 'Impact 21 Group LLC', '2700 Old Rosebud Road', 'Lexington', 'Kentucky', '40509', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1133', '20643778', 'SourceOne Payroll Services LLC', '43141 Business Center Pkwy', 'Lancaster', 'California', '93535', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1134', '16747198', 'BLACKFORD CAPITAL INC', '190 Monroe Ave NW Suite 600', 'Grand Rapids', 'Michigan', '49503', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1135', '20623075', 'Alliant Technology Group Inc', '205 North 2nd Avenue', 'Arcadia', 'California', '91006', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1136', '21026459', 'Bay Area Techworkers Inc', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1137', '16103924', 'MC Power Companies, Inc.', '4031 NE Lakewood Way', 'Lee\'s Summit', 'Missouri', '64064', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1138', '16321717', 'goCharge', '750 3rd Ave', 'New York', 'New York', '10017', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1139', '16016527', 'Energy Security Analysis Inc.', null, null, 'Massachusetts', '1880', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1140', '21194353', '2 Bridge Partners', null, 'New York', 'New York', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1141', '14689452', 'Smithers Quality Assessments , Inc.', null, null, 'Virginia', '22030', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1142', '20897108', 'PeopleForce Solutions , Inc.', null, 'Ann Arbor', 'Michigan', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1143', '20226330', 'Huffy Corporation', '6551 Centerville Business Pkwy', 'Centerville', 'Ohio', '45459', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1144', '20285727', 'Itero Labs', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1145', '16598955', 'Lima Consulting', null, 'Philadelphia', 'Pennsylvania', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1146', '19649247', 'Adams Benefit Corporation', '600 Corporate Drive', 'Fort Lauderdale', 'Florida', '33334', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1147', '18002242', 'eDoc America', null, 'Little Rock', 'Arkansas', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1148', '19660473', 'AscentCRM LLC', null, 'Denver', 'Colorado', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1149', '21377192', 'SpenDifference LLC', '2000 Clay Street Ste 300', 'Denver', 'Colorado', '80021', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1150', '18314972', 'Intermarket Forecasting, Inc.', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1151', '18626518', 'Artisan Software Consulting LLC', '4027 Arbour Circle', 'Lafayette Hill', 'Pennsylvania', '19444', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1152', '20817328', 'Evolution Capital Partners, LLC', '3333 Richmond Road, Suite 480', 'Cleveland', 'Ohio', '44122', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1153', '12816067', 'Secure Networks', '110 Breeds Hill Road', 'Hyannis', 'Massachusetts', '02601', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1154', '16702161', 'Bursch Travel', '220 Division St', 'St. Cloud', 'Minnesota', '56387', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1155', '15448883', 'PTL Automotive Group', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1156', '18595936', 'COGENICS CONSULTING GROUP INC', null, 'Morrisville', 'North Carolina', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1157', '17756551', 'Lever Interactive, Inc.', '701 Warrenville Rd, Suite 200', 'Lisle', 'Illinois', '60532', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1158', '15550265', 'Click4Corp', '115 Richardson Ct', 'Allen', 'Texas', '75002', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1159', '20896735', 'Amtech Insurance Brokers, Inc', '8 Stanley Circle', 'Latham', 'New York', '12110', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1160', '21405188', 'Fusion Wealth Management', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1161', '20242451', 'Brunner Inc', '11 Stanwix Street', 'Pittsburgh', 'Pennsylvania', '15222', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1162', '20901588', 'WolfeRich', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1163', '19583584', 'Vitale Web Solutions', null, 'Tucson', 'Arizona', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1164', '16557910', 'MRI Companies', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1165', '17768855', 'Corecon Technologies, Inc.', '5912 Bolsa Ave, Suite 109', 'Huntington Beach', 'California', '92649', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1166', '16924255', 'GPS Capital', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1167', '21301168', 'Midtown Consulting Group Inc', '75 5th St. NW', 'Atlanta', 'Georgia', '30308', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1168', '17996364', 'East View Information Services, Inc.', '10601 Wayzata Boulevard', 'Minnetonka', 'Minnesota', '55305', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1169', '17367209', 'driveservicesites', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1170', '18266541', 'DocuWare Corporation', null, 'Germering', 'Bayern', null, 'DE', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1171', '16589160', 'Clearsight Advisors Inc', '1650 Tysons Blvd.', 'McLean', 'Virginia', '22102', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1172', '16920294', 'Courier Express', '2051 Franklin Way', 'Atlanta', 'Georgia', '30067', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1173', '17007816', 'Clinical Compensation Consultants LLC', '12400 State Highway 71 West', 'Austin', 'Texas', '78738', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1174', '15941894', 'Chapman Associates', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1175', '17146908', 'C2 Solutions Group, Inc.', '1881 Campus Commons Drive', 'Reston', 'Virginia', '20191', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1176', '15935844', 'Bruckmann, Rosser, Sherrill & Co., Inc.', null, 'New York', 'New York', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1177', '18110078', 'Birst Company', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1178', '20747773', 'Wilkinson & Bidinger, P.c.', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1179', '16702416', 'American Thermal Instruments, Inc.', '2400 E River Road', 'Dayton', 'Ohio', '45439', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1180', '16962155', 'Accedia', 'Alpha Center, 89 Alexander Malinov Blvd', 'Sofia', null, '1715', 'BG', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1181', '17396368', 'Academic Insurance Solutions, LLC', null, 'Tampa', 'Florida', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1182', '20985680', 'The Mann Group', '157 Green Ridge Road', 'Weaverville', 'North Carolina', '28787', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1183', '15772602', 'AdMedia Partners Inc', '3 Park Avenue, 31st Floor', 'New York', 'New York', '10016', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1184', '14425970', 'JBE Inc', null, null, 'South Carolina', '29551', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1185', '15943027', 'OrNsoft Corporation', '141 NE 3th Avenue #300', 'Miami', 'Florida', '33132', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1186', '13935841', 'Icimo, Llc', '3434 Kildaire Farm Road, Suite 310', 'Cary', 'North Carolina', '27518', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1187', '15979175', 'Chesterfield Faring', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1188', '12405884', 'M & M Designs, Inc', '1981 Quality Blvd.', 'Huntsville', 'Texas', '77320', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1189', '15978781', 'Chatsworth Securities LLC', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1190', '15985831', 'All 3 IT, Inc.', null, null, null, '92618', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1191', '16907378', 'DatCom LLC', '16623 FM 2493, Suite C', 'Tyler', 'Texas', '75703', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1192', '17689042', 'Roventini Philip C CPA', '246 N Main St', 'New City', 'New York', '10956', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1193', '16557095', 'Excel Partners , Inc.', null, 'Madrid', 'Madrid', null, 'ES', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1194', '15245203', 'Gilmore Solutions, Inc.', '115 S. Broadway Ave, Suite B', 'Sterling', 'Kansas', '67579', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1195', '16331605', 'mindSHIFT Technologies, Inc.', null, 'Waltham', 'Massachusetts', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1196', '16224904', 'Nerd Crossing', '400 Appian Way', 'El Sobrante', 'California', '94803', 'United States', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1197', '16512900', 'Investor Direct Capital', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1198', '21056391', 'HRANEC', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1199', '16412896', 'Nationwide Transportation, Inc.', 'PO Box 5537', 'Woodridge', 'Illinois', '60517', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1200', '15331436', 'Awesome Office Interiors Inc', '2 Aspen Pl', 'Passaic', 'New Jersey', '07055', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1201', '14041287', 'CRI Company', '6026 Shallowford Rd', 'Chattanooga', 'Tennessee', '37421', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1202', '15355444', 'Supreme Opti', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1203', '21235983', 'ScottMadden', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1204', '20879335', 'Woods Insurance', '108 W Sierra St', 'Portola', 'California', '96122-8633', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1205', '20883091', 'PRIMUS Global Services Inc', 'Earlswood Rd', 'Cardiff', 'Cardiff', 'CF14 5GH', 'GB', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1206', '20897370', 'KOMPSYS Inc.', '4080 Mcginnis Ste 1002', 'Alpharetta', 'Georgia', '30005', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1207', '21120937', 'CHIPS Computer Services', '14491 Forest Blvd.', 'Hugo', 'Minnesota', '55038', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1208', '20860158', 'Conversion Technologies International Inc', '7000 Atrium Way', 'Mount Laurel', 'New Jersey', '08054', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1209', '21081600', 'Masterpiece Graphix Inc', '1500 Fenpark Drive', 'Fenton', 'Missouri', '63026', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1210', '20545823', 'Wikimotive', null, 'Winchendon', 'Massachusetts', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1211', '17789994', 'Gochman Group Inc', '95 Morton St', 'New York', 'New York', '10014-3336', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1212', '21135014', 'Gmail', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1213', '19983033', 'Blue Sky Tower', '158 Main Street', 'Norfolk', 'Massachusetts', '02056', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1214', '20528467', 'The Valdan Group', '1669 World Trade Center Loop', 'Laredo', 'Texas', '78045', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1215', '19307916', 'Court Square Group Inc', null, 'Springfield', 'Massachusetts', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1216', '16921670', 'Makor Solutions Inc', '7430 W 27th Street', 'Saint Louis Park', 'Minnesota', '55426', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1217', '20209742', 'Sleeve A Message', '543 Hanley Industrial Ct', 'Brentwood', 'Missouri', '63144', 'United States', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1218', '20004668', 'People Strategy Partners', null, null, null, null, 'United States', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1219', '16603686', 'Manhattan Associates Inc', '3 FOREST EDGE', 'BUCKHURST HILL', 'Essex', 'IG9 5AA', 'GB', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1220', '21080182', 'Midwest Color Printing Inc.', '2458 S. Walnut Street', 'Bloomington', 'Indiana', '47401', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1221', '20039779', 'Cable One', '210 E. Earll Drive', 'Phoenix', 'Arizona', '85012', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1222', '19307953', 'Court Square Data', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1223', '20693129', 'Transom Capital Group', '10990 Wilshire Boulevard', 'Los Angeles', 'California', '90024', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1224', '20813561', 'VLN Partners', '1212 East Carson Street', 'Pittsburgh', 'Pennsylvania', '15203', 'United States', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1225', '18929558', 'Marathon Capital LLC', '200 West Madison St.', 'Chicago', 'Illinois', '60606', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1226', '21026345', 'Techworkers', '2000 Crow Canyon Place', 'San Ramon', 'California', '94583', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1227', '20502367', 'Topshelf Custom Embroidery and Screen Printing', '470 Mundet Pl', 'Hillside', 'New Jersey', '07205-1115', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1228', '20704735', 'RevCult', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1229', '20371050', 'High Definition Logistics', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1230', '20424982', 'QUALITY ONE AUTOMATION', '1160 VIERLING DRIVE', 'SHAKOPEE', 'Minnesota', '55379', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1231', '20745081', 'Supplypointe', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1232', '16365095', 'Brink\'s Inc', '1 Robert Speck Parkway', 'Mississauga', 'On', 'L4Z 3M3', 'CA', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1233', '13250615', 'Humantech', '1161 Oak Valley Drive', 'Ann Arbor', 'Michigan', '48108', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1234', '20371046', 'Arke Systems, LLC', '3400 Peachtree Road', 'Atlanta', 'Georgia', '30326', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1235', '14946500', 'Self Service Merchant Solutions', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1236', '19146273', 'Auctus Group, Inc.', '125 S Wacker Drive', 'Chicago', 'Illinois', '60606', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1237', '19638878', 'BOST Benefits', null, 'Charleston', 'South Carolina', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1238', '19645423', 'Radius', 'Whitefriars, Lewins Mead', 'Bristol', null, 'BS1 2NT', 'GB', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1239', '20188905', 'SM Transport, LLC.', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1240', '20510792', '3E Cleaning Company', 'P.O. Box 140002', 'Austin', 'Texas', '78714-0002', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1241', '20294877', 'Apex Financial Services Group LLC', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1242', '20441063', 'GLOBAL PACKAGING, INC', '3214 Lacy St', 'Los Angeles', 'California', '90031-1838', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1243', '20814264', 'iPresent Ltd.', null, 'Alton', 'St. Helens', null, 'GB', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1244', '20432152', 'TranStrategy Partners Inc', 'PO Box 222', 'Ridgefield', 'Washington', '98642', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1245', '14898286', 'VFP Business Solutions, LLC', null, 'Fort Lauderdale', 'Florida', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1246', '19592632', 'GetonlineNola', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1247', '19983569', 'Sea-Level Solutions', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1248', '20897371', 'Komplete Systems Integrator', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1249', '20896737', 'Assured Partners', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1250', '20875754', 'Elite Graphics LLC', '500 Horton Ct', 'Lexington', 'Kentucky', '40511', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1251', '20527583', 'Communication Graphics, Inc.', '1787 Sentry Parkway West, Bldg 16', 'Blue Bell', 'Pennsylvania', '19422', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1252', '20883093', 'RailcarRx', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1253', '19522457', 'Synergy X Consulting', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1254', '19660517', 'ClearRCM', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1255', '17584369', 'SMB Technologies', null, 'Portland', 'Oregon', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1256', '20003619', 'The IT Architect', null, 'Washington, D.C.', null, null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1257', '19515877', 'Steel Estimating Solutions', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1258', '20201741', 'RedPeg Marketing', '727 N Washington St', 'Alexandria', 'Virginia', '22314', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1259', '19587355', 'Prime Manhattan Realty', null, 'New York', 'New York', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1260', '20004599', 'Innuvo', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1261', '20874783', 'Control Products Inc Company', '1668 Headland Dr', 'Fenton', 'Missouri', '63026', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1262', '20226773', 'Goldstar Energy Group Inc.', null, null, 'New Jersey', '8330', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1263', '20441084', 'Direct Logic Solutions Inc', '4507 N. Sterling Ave', 'Peoria', 'Illinois', '61615', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1264', '20441074', 'ACCESS Event Solutions', '1410 Greg Street', 'Reno', 'Nevada', '89431', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1265', '20849780', 'Graphx Connection, Inc', '4730 Lamar Avenue', 'Mission', 'Kansas', '66202', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1266', '20235582', 'GovPilot', '79 Hudson Street', 'Hoboken', null, '07030', 'United States', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1267', '20280525', 'Links Medical Products, Inc.', '9247 Research Dr', 'Irvine', 'California', '92618', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1268', '20684107', 'Kalos Consulting, Inc', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1269', '20723244', 'Adamy Valuation Advisors', '50 Louis St. NW, Suite 405', 'Grand Rapids', 'Michigan', '49503', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1270', '20497616', 'ROI Rocket', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1271', '20704383', 'Chortek LLP', 'N16W23217 Stone Ridge Drive, Suite 350', 'Waukesha', 'Wisconsin', '53188', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1272', '15540492', 'PeopleNet', '5163 Roswell Road', 'Atlanta', 'Georgia', '30342', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1273', '20694993', 'Jakoba Software Inc', '700 NW 42nd Street #215', 'Seattle', 'Washington', '98107', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1274', '19972072', 'On the Avenue Marketing Group', '391 Totten Pond Rd #304', 'Waltham', 'Massachusetts', '02451', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1275', '19630765', 'Preferred Shipping, Inc.', '12714 Settemont Road', 'Missouri City', 'Texas', '77489', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1276', '20814036', 'Stan Liberatore\'s Company', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1277', '20004661', 'Metova', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1278', '20751502', 'Bunker Hill Capital L.P', '260 Franklin St Ste 1860', 'Boston', 'Massachusetts', '02110', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1279', '20747774', 'BEC Partners', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1280', '20745082', 'Supply Pointe', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1281', '20278350', 'ITKM Systems LLC', '814 W Broad St', 'Richmond', 'Virginia', '23104', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1282', '19630897', 'Cambridge Benefit Solutions', '1467 West Elliot Road', 'Gilbert', 'Arizona', '85233', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1283', '20201784', 'Waterfield Mortgage Company , Inc.', null, null, 'Indiana', '95901-9507', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1284', '20009411', 'Big Rhino', '2709 N PACE BLVD', 'Pensacola', 'Florida', '32505', 'United States', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1285', '20723717', 'Bedford Cost Segregation, LLC', null, 'Louisville', 'Kentucky', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1286', '20704686', 'RevCult - Obsessed with your Revenue Culture', '12555 High Bluff Dr.', 'San Diego', 'California', '92130', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1287', '17824536', 'Gas Station TV Inc', null, 'Birmingham', 'Birmingham', null, 'GB', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1288', '20681236', 'Yvonne Donohoe', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1289', '19300400', 'Crosswood Technology Group LLC', null, 'Houston', 'Texas', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1290', '19515104', 'Ground/Water Treatment & Technology', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1291', '19977941', 'Filmwithpps', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1292', '17408675', 'VHI Transport Inc', '4525 Lee St', 'Chester', 'Virginia', '23831', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1293', '19385411', 'Baudville Inc', '5380 52nd Street SE', 'Grand Rapids', 'Michigan', '49512', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1294', '20407453', 'Dukebizadvisors', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1295', '18941134', 'Amoskeag Network Consulting Group LLC', '75 Gilcreast Rd Ste 306', 'Londonderry', 'New Hampshire', '03053', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1296', '15858273', 'Starpoint Solutions', '22 Cortlandt Street, Fourteenth Floor', 'New York', 'New York', '10007-3152', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1297', '20294381', 'Aagami, Inc.', '2135 City Gate Lane, Suite 300', 'Naperville', 'Illinois', '60564', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1298', '16703743', 'Scabrou', 'Next to Jumeriah Business Center 5', 'Dubai', null, null, 'AE', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1299', '19399147', 'V Digital Services', '969 Broadway', 'Denver', 'Colorado', '80203', 'United States', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1300', '19583389', 'RPI Consultants', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1301', '18059515', 'E4healthcare', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1302', '18265759', 'Equity Construction Solutions', '4653 Trueman Boulevard', 'Hilliard', 'Ohio', '4323506', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1303', '20227201', 'SPBS, Inc.', 'SPBS INC', 'Lubbock', 'Texas', '79407', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1304', '19323678', 'Blayzer Digital Marketing Group', null, 'St. Louis', 'Missouri', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1305', '20397366', 'Johnson & Dugan Company', 'Svc Corp', 'San Bruno', 'California', '94066', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1306', '20208641', 'Five Star Food Service, Inc.', '661 Sussex St', 'Kinston', 'North Carolina', '28504', 'United States', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1307', '18975703', 'AtWork Group', '3215 W Governor John Svr Hwy', 'Knoxville', 'Tennessee', '37921', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1308', '19146071', 'Gompers, Cornish & Barr', '22955 21 Mile Road', 'Macomb', 'Michigan', '48042', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1309', '20004740', 'Image X Inc.', null, 'San Francisco', 'California', null, 'United States', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1310', '20235279', 'Crave InfoTech', '15 Corporate Pl S', 'Piscataway', 'New Jersey', '08854', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1311', '18899477', 'SailPlay', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1312', '20279465', 'Richard LaNeve Jr', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1313', '20004684', '24/7 Enterprises LLC', '1101 Bristol Road', 'Mountainside', 'New Jersey', '07092', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1314', '20283955', 'Profit Or Savings Enterprise, LLC ( AKA PO$E )', null, 'Akron', 'Ohio', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1315', '17027374', 'Square Peg Packaging and Printing', '5260 Anna Avenue', 'San Diego', 'California', '92110', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1316', '18977065', 'Pegasus Logistics Group Inc', '306 Airline Drive', 'Coppell', 'Texas', '75019', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1317', '19643712', 'Dito LLC', '9913 Sugarwood Lane', 'Manassas', 'Virginia', '20110', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1318', '16615560', 'Welcomemat Services', null, 'Fort Lauderdale', 'Florida', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1319', '20203961', 'Shield Screening', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1320', '20085579', 'RegDocs365', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1321', '19359550', 'USA Phone.com/VoIP Products and Services', null, 'Cherry Hill', 'New Jersey', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1322', '15768110', 'Mera Investments', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1323', '20013038', 'WB Wood', null, null, 'New Jersey', '07920-1657', 'United States', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1324', '19594062', 'Grayscale Entertainment', '310 Jefferson St', 'Nashville', 'Tennessee', '37208', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1325', '19012858', 'Setnor Buyer', null, null, 'Florida', '33324-3920', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1326', '16672099', 'NVision Advertising', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1327', '16115473', 'Imantics Inc', null, null, null, null, 'IQ', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1328', '16770727', 'SHIELDS PRODUCTS INC.', null, 'Las Vegas', 'Nevada', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1329', '18948170', 'Cortgrp', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1330', '19191718', 'Search Rankings', '11399 S Belmont St.', 'Olathe', 'Kansas', '66061', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1331', '16315136', 'Dasi Solutions', null, 'Detroit', 'Michigan', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1332', '18249384', 'SEXTON & SCHNOLL, INC.', null, 'Gainesville', 'Florida', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1333', '17657207', 'Sopriscapitalholdings', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1334', '18267629', 'Southwestern Consulting', null, 'Omaha', 'Nebraska', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1335', '15630698', 'Strategic Account Management Association', null, 'Chicago', 'Illinois', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1336', '16500614', 'Systems Connection Group', null, 'Atlanta', 'Georgia', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1337', '16591082', 'Technology Solutions Consulting, Inc.', null, 'Tulsa', 'Oklahoma', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1338', '16515354', 'Perlinski Design', null, 'Somerset', 'New Jersey', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1339', '19164499', 'Mediamorphosis Advertising & Technology Inc', '35-37 36th Street', 'Astoria', 'New York', '11106', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1340', '16498181', 'Luminaire Marketing', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1341', '19658060', 'Integrated Project Resources, LLC', '55 East Jackson Blvd', 'Chicago', 'Illinois', '60604', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1342', '16188529', 'Kindsound', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1343', '19143409', 'Kelly M J Realty', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1344', '16800338', 'IRCS Studio', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1345', '16680310', 'Byrne', null, 'Grand Rapids', 'Michigan', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1346', '18251338', 'Bedrock Technology Partners', null, 'San Diego', 'California', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1347', '18059467', 'Azimuth', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1348', '19522899', 'Inde Global Advisory Private Limited', 'One Lake Side Commons, Suite 850,', 'Atlanta', 'Georgia', '30328', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1349', '19622227', 'Schur Success', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1350', '19522575', 'Stoltenberg Consulting , Inc.', '5815 Library Road', 'Bethel Park', 'Pennsylvania', '15102', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1351', '11465917', 'Trinau Inc', '2 King Arthur Court', 'North Brunswick', 'New Jersey', '08902', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1352', '11598607', 'Moblico', '1719 1/2 39th West', 'Kansas City', 'Missouri', '64111', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1353', '13442643', 'INPROCESS INC', null, null, null, null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1354', '11293342', 'SnapStreak, Inc.', null, null, null, '77014', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1355', '14546162', 'Phoenix Energy Technologies', '165 Technology', 'Irvine', 'California', '92618', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1356', '14431769', 'Simplified Solutions LLC', '150 North Michigan Ave.', 'Chicago', 'Illinois', '60601', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1357', '17010667', 'Datawatch Corporation', '9896 BISSONNET ST STE 450', 'Houston', 'Texas', '77036-8202', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1358', '19591129', 'Giant Media Online', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1359', '19973956', 'Synergy Micro Solutions, LLC', '15 Chrysler', 'Irvine', 'California', '92618', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1360', '19630875', 'Virtuox, Inc.', '5850 Coral Ridge Drive', 'Coral Springs', 'Florida', '33076', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1361', '19646995', 'Movers, not Shakers , Inc.', '131 3rd St', 'Brooklyn', 'New York', '11231', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1362', '19646756', 'Wise Pelican LLC', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1363', '19323220', 'J.D. Chapman Agency, Inc.', '66 Main St', 'Macedon', 'N', '14502', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1364', '16980414', 'Rsignite', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1365', '18636648', 'Miick', '3855 Norwood Court', 'Boulder', 'Colorado', '80304', 'United States', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1366', '19626567', 'Vector International', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1367', '11404110', 'The Wentworth Company', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1368', '15496952', 'The Garibaldi Group, LLC', null, null, 'New Jersey', '7928', 'United States', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1369', '15552915', 'M Systems International, Inc.', '3608 Shannon Road', 'Durham', 'North Carolina', '27707', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1370', '8620921', 'Leading Principals', '1624 Market Street Suite 202', 'Denver', 'Colorado', '80202', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1371', '16331573', 'Constellation Partners LLC', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1372', '11099369', 'Turning Technologies', '255 West Federal Street', 'Youngstown', 'Ohio', '44503', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1373', '16964644', 'Ryan and Bell Realty Partners', '5757 Alpha Road', 'Dallas', 'Texas', '75240', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1374', '19594063', 'Grayscale Entertainment', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1375', '18898693', 'Bridge POS', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1376', '19428392', 'TCI Transportation', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1377', '17710931', 'The Hotaling Group', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1378', '19146315', 'Dickinson Press Inc.', '5100 33rd St SE', 'Grand Rapids', 'Michigan', '49512', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1379', '19431137', 'Mutual Trust Corporate Real Estate', '8500 Bluffstone Cv, Ste B102', 'Austin', 'Texas', '78759', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1380', '19431427', '1LL!', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1381', '18130938', 'Marsh & McLennan Agency LLC', '409 E. Monument Ave.', 'Dayton', 'Ohio', '45402', 'United States', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1382', '17146711', 'GreatForce Insurance', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1383', '14178694', 'Bright Ideas Supply Chain Solutions', null, 'San Diego', 'California', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1384', '14555218', 'Classidocs', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1385', '19138438', 'Rentigo Inc', null, 'New York', 'New York', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1386', '15781763', 'MVP Capital Partners', '259 N. Radnor Chester Road', 'Radnor', 'Pennsylvania', '19087', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1387', '18248959', 'eXalt Solutions , Inc.', '767 Main St', 'Boxford', 'Massachusetts', '01921', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1388', '18005800', 'Maryland Telephone Company', '1014 Cromwell Bridge Road', 'Baltimore', 'Maryland', '21286', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1389', '18941151', 'Infinite Computing Systems Inc', '425 Second St SE', 'Cedar Rapids', 'Iowa', '52401', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1390', '18897588', 'Premier Relocations LLC', '25 Truman Dr S', 'Edison', 'New Jersey', '08817', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1391', '18746441', 'B.E.S.T', '3120 S Meridian Ave', 'Oklahoma City', 'Oklahoma', '73119', 'United States', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1392', '19146184', 'St. Louis Blues', '1401 Clark Avenue', 'St. Louis', 'Missouri', '63103', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1393', '16708528', 'Strauss Consulting Group, LLC', '68 Chuckanutt Drive', 'Oakland', 'New Jersey', '07436', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1394', '15754939', 'JobTarget LLC', '15 Thames Street', 'Groton', 'Connecticut', '06340', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1395', '16226850', 'Zingtree LLC', '700 Larkspur Landing Circle', 'Larkspur', 'California', '94939', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1396', '16521109', 'KinderCare Learning Centers , Inc.', '650 NE Holladay St', 'Portland', 'Oregon', '97232', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1397', '18005869', 'GRN Naperville South (Global Recruiters) - \\\"Extraordinary Taste In Talent\\\"', '1315 Macom Drive', 'Naperville', 'Illinois', '60564', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1398', '12752960', 'Accupoint Software LLC', '241 West Federal Street', 'Youngstown', 'Ohio', '44503', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1399', '18926698', 'Group C Communications , Inc.', '44 Apple Street', 'Tinton Falls', 'New Jersey', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1400', '14814039', 'Bluewave Sales', 'P.O. Box 3057', 'Granite Bay', 'California', '95746', 'United States', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1401', '18005666', 'Premio Inc.', '918 Radecki Court', 'City of Industry', 'Ca - California', '91748', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1402', '18005818', 'Neal/Settle Printing Inc.', '14004 Norby Road', 'Grandview', 'Missouri', '64030', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1403', '18715135', 'Jetset Magazine LLC', '15220 N. 75th Street', 'Scottsdale', 'Arizona', '85260', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1404', '14785993', 'Smart Image Systems', '2709 S I-35 Service Road', 'Oklahoma City', 'Oklahoma', '73129', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1405', '18625506', 'ITAC Solutions', '700 Montgomery Highway, Suite 148', 'Birmingham', 'Alabama', '35216', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1406', '14205320', 'ALC SOUTHWEST', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1407', '13392877', 'AlphaTrust Corporation', '6305 Northwood Rd', 'Dallas', 'Texas', '75225-2824', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1408', '18361546', 'Syringa Networks', '12301 W Explorer Dr', 'Boise', 'Idaho', '83713', 'United States', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1409', '18926702', 'Group C Media', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1410', '18715125', 'McCue Systems Inc.', '13 Centennial Drive', 'Peabody', 'Massachusetts', '01960', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1411', '11939168', 'Honey Bear Digital', '621 East 6th Street', 'Austin', 'Texas', '78701', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1412', '18497063', 'Envisionet', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1413', '14675490', 'Altanova Energy + Sustainability', '1105 44th Drive', 'Long Island CIty', 'New York', '11101', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1414', '17790353', 'Bearce Insurance Agency Inc', '90 Main St', 'Bridgewater', 'Massachusetts', '02324', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1415', '12975602', 'Lanspeed Inc', '100 North Hope Avenue, Suite 20', 'Santa Barbara', 'California', '93110', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1416', '14557947', 'CCG Catalyst Consulting Group', '40 North Central Avenue', 'Phoenix', 'Arizona', '85004', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1417', '15947731', 'Solution21, Inc.', null, 'Irvine', 'California', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1418', '7814279', 'All Copy Products', '4141 Colorado Blvd', 'Denver', 'Colorado', '80216', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1419', '16615478', 'Medley Company', '4201 Will Rogers Parkway', 'Oklahoma City', 'Oklahoma', '73108', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1420', '16768693', 'Workuments', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1421', '17660303', 'Digital Marketing Services, Inc.', '100 Cahaba Valley Parkway W', 'Pelham', 'Alabama', '35124', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1422', '18637649', 'Smart Source', '1250 Broadway', 'New York', 'N.y.', '10001', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1423', '13844480', 'HandCraft Linen Services', '2810 Cofer Rd', 'Richmond', 'Virginia', '23224', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1424', '18206269', 'TransLytix', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1425', '18483881', 'Giamboi Partners', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1426', '14069077', 'Ctuit Software', '773 San Marin Dr, Ste 2320', 'Novato', 'California', '94945', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1427', '15332727', 'BCI Computers', '231 Quaker Lane', 'West Warwick', 'Rhode Island', '02893', 'United States', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1428', '17925413', 'Ignite Media', null, 'Los Angeles', 'California', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1429', '18265937', 'MAudit', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1430', '18363328', 'The LaSalle Network Inc.', '200 N La Salle St #2500', 'Chicago', 'Illinois', '60601', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1431', '18124480', 'Janas Associates', '141 S Lake Ave Ste 102', 'Pasadena', 'California', '91101', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1432', '18209782', 'SpotRight Inc.', '500 President Clinton Ave', 'Little Rock', 'Arkansas', '72201', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1433', '18248895', 'New Direction IRA', '1070 W Century Dr Ste 101', 'Louisville', 'Colorado', '80027', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1434', '17926938', 'Internetwork Experts Corporation (IEC)', '7346 S Alton Way Suite 10K', 'Centennial', 'Colorado', '80112', 'United States', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1435', '17076904', 'HiQo Solutions, Inc', '11258 Ford Ave', 'Richmond Hill', 'Georgia', '31324', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1436', '18238168', 'Technical Integration Group', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1437', '18123865', 'Janas Associates', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1438', '15469560', 'Montana Root Applications', null, 'Victor', 'Montana', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1439', '18051577', 'ARC Medical Billing', null, 'Dumont', 'New Jersey', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1440', '18053034', 'ACT Medical Billing', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1441', '16615636', 'Prime Rigging LLC', null, null, null, '68507', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1442', '17570779', 'Southwestern Microsystems Inc', '3038 S Jacob St', 'Gilbert', 'Arizona', '85295', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1443', '18000463', 'Kesler Corporation', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1444', '18005534', 'Jet Letter Corporation', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1445', '18002798', 'ConnectedSign, LLC', null, 'Lancaster', 'Pennsylvania', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1446', '14675417', 'Garnet River LLC', '60 Railroad Place', 'Saratoga Springs', 'New York', '12866', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1447', '14268999', 'Leadpoint Business Services LLC', '5310 E. High Street', 'Phoenix', 'Arizona', '85054', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1448', '13697575', 'GlobaLogix', '13831 Northwest Freeway', 'Houston', 'Texas', '77040', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1449', '15703414', 'Health Brand Group', null, 'Chicago', 'Illinois', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1450', '13751657', 'Addo', 'Central Ave', 'Indianapolis', 'Indiana', '46205', 'United States', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1451', '14051728', 'Arapaho Asset Management LLC', '3900 East Mexico Avenue', 'Denver', 'Colorado', '80210', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1452', '17080515', 'TeamLogicIT Southern NH', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1453', '17573754', 'Boston Benefit Partners, LLC', '177 Milk St', 'Boston', 'Massachusetts', '02109', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1454', '12816854', '2logical', '500 Linden Oaks', 'Rochester', 'New York', '14625', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1455', '16702159', 'Franchise Logistics', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1456', '17139723', 'Geek in NY', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1457', '16973821', 'GPS Capital Markets, Inc.', '10813 S Rvr Frnt Pkwy #410', 'South Jordan', 'Utah', '84095', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1458', '16799426', 'Penmac Staffing Services, Inc.', '447 South Ave.', 'Springfield', 'Missouri', '65806', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1459', '17555917', 'Liftech Equipment Companies', null, null, 'New York', '13057-1140', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1460', '17551754', 'E442', null, 'Dallas', 'Texas', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1461', '16708070', 'rcfglobal', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1462', '16806282', 'cFAIR Technologies, LLC', null, 'Boston', 'Massachusetts', '02116', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1463', '17082711', 'Williamette Building', '5 Bernini Ct', 'Lake Oswego', 'Oregon', '97035', 'United States', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1464', '17073601', 'Santo Nino', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1465', '12835533', 'JFQ Consulting', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1466', '16903303', 'Parker Line Striping, Inc.', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1467', '15721350', 'Optus Inc', '3423 One Place', 'Jonesboro', 'Arkansas', '72404', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1468', '14360959', 'Greenlighting Services, LLC', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1469', '17385557', 'Antra, Inc', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1470', '16700000', 'Drive Service Sites', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1471', '16117228', 'Credit International Corporation', '10413 Beardslee Blvd', 'Bothell', 'Washington', '98011', 'United States', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1472', '16968489', 'Eyeforce Inc.', null, null, null, null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1473', '15984403', 'Client Command', '410 Peachtree Parkway', 'Cumming', 'Georgia', '30041', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1474', '16700497', 'Wealth Preservation Solutions, LLC', null, null, 'New Jersey', '7450', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1475', '15849915', 'Apex Technology Management, Inc.', null, null, 'South Carolina', '29414', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1476', '15555735', 'The Insurance Exchange Inc', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1477', '16406151', 'Leidos Inc', '11951 Freedom Dr', 'Reston', 'Virginia', '20190', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1478', '15979170', 'Secure Anchor Consulting', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1479', '15859940', 'NetStandard, Inc.', '2000 Merriam Ln,', 'Kansas City', 'Kansas', '66106', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1480', '16682475', 'ITque, Inc.', '587 Division Street', 'Campbell', 'California', '95008', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1481', '16569278', 'LawSourceLive', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1482', '16560458', 'Koski Research, Inc.', '7 Joost Avenue', 'San Francisco', 'California', '94131', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1483', '13035810', 'Future Point Of View', '3540 S. Boulevard', 'Edmond', 'Oklahoma', '73013', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1484', '13347474', 'Creekwood Energy', null, 'Cincinnati', 'Ohio', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1485', '13753906', 'Mid South Pick & Pack (WFS)', null, null, null, '37209', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1486', '13425556', 'Celerit', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1487', '16915605', 'Web Team Management', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1488', '13936995', 'LeadershipOne', '777 Campus Commons Rd #200', 'Sacramento', 'California', '95825', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1489', '16903300', 'Parker Line Striping', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1490', '14067058', 'RocketDog Communications', '911 Western Ave., #230', 'Seattle', 'Washington', '98104', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1491', '13189682', 'The Oliver Group', '13500 Oliver Station Court', 'Louisville', 'Kentucky', '40245', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1492', '13811686', 'Dolven Enterprises Inc', '1317 Transport Dr', 'Raleigh', 'North Carolina', '27603', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1493', '14463208', 'FleetBoss Global Positioning Solutions, Inc.', '1066 Wildwood Ave', 'Thousand Oaks', 'California', '91360', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1494', '14268944', 'iDrive Logistics', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1495', '9924106', 'Mindgrub Technologies', '1215 E Fort Ave', 'Baltimore', 'Maryland', '21230', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1496', '13972298', 'D Diversified Services', '30150 Telegraph Road', 'Bingham Farms', 'Michigan', '48025', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1497', '13236406', 'Idea Hall', '611 Anton Blvd., Suite 140', 'Costa Mesa', 'California', '92626', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1498', '16885743', 'Interior Office Systems, Inc.', null, 'Thousand Oaks', 'California', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1499', '16363387', 'HCS Healthcare', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1500', '16498778', 'SRF Accounting Group, LLC', 'One University Plaza Drive Ste 311', 'Hackensack', 'New Jersey', '07601', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1501', '16618932', 'Align4Profit Inc', null, 'Dallas', 'Texas', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1502', '15325587', 'SONIFI Health', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1503', '16733558', 'Muratek', '75 Maiden Ln.', 'New York', 'New York', '10038', 'United States', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1504', '15851839', 'Americom Imaging Systems, Inc.', '100 Green Park Industrial Court', 'St Louis', 'Missouri', '63123', 'United States', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1505', '16558534', 'Castle Lanterra Properties LLC', 'One Executive Blvd; Suite 204', 'Suffern', 'New York', '10901', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1506', '16712341', 'Hoopernova Fitness', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1507', '16700544', 'Legacy State Bank', '3825 Harrison Rd SW', 'Loganville', 'Georgia', '30052', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1508', '16155662', 'PageDNA Inc', null, 'San Mateo', 'California', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1509', '15729069', 'Vertex Software Corporation', '1515 S. Capital of Texas Hwy.', 'Austin', 'Texas', '78746', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1510', '15455096', 'RedSeal, Inc.', null, null, 'California', '95054-1206', 'United States', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1511', '16688635', 'Supranormal Solutions', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1512', '16412912', 'JLT Mobile Computers', 'Isbjörnsvägen 3', 'Växjö', null, '35245', 'SE', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1513', '16683090', 'McCalister Rocha\'s Company', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1514', '16622795', 'Queen of Raw', null, 'New York', 'New York', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1515', '12041717', 'Optex, Inc.', '18730 s. Wilmington Ave #100', 'Rancho Dominguez', 'California', '90220', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1516', '12701963', 'Specialized Office Systems, Inc.', '19235 N. Cave Creek Road, Suite 100', 'Phoenix', 'Arizona', '85024', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1517', '12390857', 'Custom Sign Creations', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1518', '12314263', 'The Strathmore Company', '2000 Gary Lane', 'Geneva', 'Illinois', '60134', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1519', '13845568', 'DEG (Digital Evolution Group)', null, 'Overland Park', 'Kansas', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1520', '16016657', 'STRUNK CONSULTING, LLC.', '906 16th Street Suite 3', 'Bedford', 'Indiana', '47421', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1521', '16569255', 'Oniel Polanco\'s Company', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1522', '16365101', 'EdgeConneX Inc', '2201 Cooperative Way', 'Herndon', 'Virginia', '20171', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1523', '13935733', 'Market Momentum (SC)', 'Greenville', 'Greenville', 'South Carolina', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1524', '15447788', 'Quick Copper LLC', '29 N Fullerton Ave', 'Montclair', 'New Jersey', '07042', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1525', '14780726', 'James Branson\'s Company', null, 'Indianapolis', 'Indiana', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1526', '16107538', 'Benefit Plans Plus', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1527', '13262693', 'IntellecTechs Inc', '195 S Rosemont Road', 'Virginia Beach', 'Virginia', '23452', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1528', '16415551', 'Insouciance Abroad LLC', '59 Bowden Lane', 'Freeport', 'Maine', '04032', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1529', '13515152', 'Mobideo Technologies Ltd', '11811 North Freeway', 'Houston', 'Texas', '77060', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1530', '12163232', 'Solscient Energy, LLC', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1531', '15754555', 'Diedrich Drill , Inc.', '5 Fisher Street', 'La Porte', 'Indiana', '46350', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1532', '14076924', 'ThisQuarter', 'PO Box 163661', 'Austin', 'Texas', '78716', 'United States', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1533', '16290751', 'Tech 2 Resources', '14460 New Falls of Neuse Road', 'Raleigh', 'North Carolina', '27614', 'United States', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1534', '15727544', 'Steele Compliance Solutions, Inc.', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1535', '16328347', 'Graham\'s Crackers', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1536', '15523417', 'Alexander Open Systems', '12980 Foster St., Ste. 300', 'Overland Park', 'Kansas', '66213', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1537', '15049452', 'ExeterStudios', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1538', '16305739', 'Elephanta Coaching', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1539', '12974935', 'Rocus Networks', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1540', '15384283', 'Bioserv Corporation', '5340 Eastgate Mall', 'San Diego', 'California', '92121', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1541', '15773620', 'Arete Software, Inc', '5625 N. Post Rd. Suite 13', 'Indianapolis', 'Indiana', '46216', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1542', '13755455', 'Enlighten Writing', null, 'Beaverton', 'Oregon', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1543', '14144802', 'Blue River Financial Group Inc', '1668 S. Telegraph Rd.', 'Bloomfield Hills', 'Michigan', '48302', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1544', '13760054', 'SourceCode Partners', '605 N 100 E', 'Springville', 'Utah', '84663', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1545', '15781249', 'Mediprocity', '707 Spirit 40 Park Dr #140', 'Chesterfield', 'Missouri', '63005', 'United States', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1546', '15773124', 'Cejka Search', 'Suite 300', 'Saint Louis', 'Missouri', '63141', 'United States', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1547', '15468581', 'Red Team Consulting LLC', '11710 Plaza America Drive', 'Reston', 'Virginia', '20190', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1548', '16011751', 'Staff On Site', '1406 Willowbrook Rd.', 'Beloit', 'Wisconsin', '53511', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1549', '14199167', 'M-Shred', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1550', '16156950', 'The Declaration Stage Co.', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1551', '14943625', 'Uvation Inc', 'UVATION', 'Dallas', 'Texas', '75201', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1552', '13232219', '10,000ft', '619 Western Ave, Suite 500', 'Seattle', 'Washington', '98104', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1553', '13091856', 'Donovan Logistics', '145 Constitution Blvd', 'Franklin', 'Massachusetts', '02038', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1554', '15794864', 'HVAC Business Solutions LLC', '10701 Corporate Drive', 'Stafford', 'Texas', '77477', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1555', '16052824', 'TeamLogic IT-Canton', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1556', '13597532', 'Onfloor Technologies, LLC', '777 South Street', 'Newburgh', 'New York', '12550', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1557', '14149294', 'WinSystems, Inc.', '715 Stadium Drive', 'Arlington', 'Texas', '76011', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1558', '15899765', 'Business-Team', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1559', '15978915', 'Privo', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1560', '15972538', 'Advanced Label WORX', null, 'Oak Ridge', 'Tennessee', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1561', '13026214', 'QRD Tech', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1562', '13846367', 'RadialSpark', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1563', '12135984', 'Wilmac Co', null, null, 'New York', '13202', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1564', '15061767', 'Freeway Logistics', 'PMB', 'San Juan', 'Puerto Rico', '00907-1420', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1565', '15219723', 'The Keane Insurance Group, Inc.', '135 W Adams Ave', 'St. Louis', 'Missouri', '63122', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1566', '13390362', 'Hexagonal Industries', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1567', '15242885', 'Netzero USA of Columbus', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1568', '15727717', 'James Thomas Productions', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1569', '15767465', 'Lovell & Mercier Inc', null, 'Washington, D.C.', null, null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1570', '14551454', 'National Billing Partners LP', '4515 Seton Center Parkway', 'Austin', 'Texas', '78759', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1571', '15772698', 'Native MSG', '155 N. Wacker Drive', 'Chicago', 'Illinois', '60606', 'United States', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1572', '15244333', 'Bluegrass Supply Chain Services', '350 Scotty\'s Way', 'Bowling Green', 'Kentucky', '42103', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1573', '14180312', 'Minipack', null, 'College Park', 'Maryland', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1574', '15751039', 'HCI Equity Partners L.L.C', '1730 Pennsylvania Ave NW', 'Washington', 'District Of Columbia', '20006', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1575', '15749610', 'JCR Capital', '1225 17th Street', 'Denver', 'Colorado', '80202', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1576', '15727706', 'James Thomas', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1577', '15397429', 'Hoff & Leigh Inc', '1259 Lake Plaza Drive', 'Colorado Springs', 'Colorado', '80906', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1578', '15495951', 'Mediaspot, Inc.', 'Bayside Drive', 'Corona del Mar', null, '92625', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1579', '15303766', 'RelProg, LLC', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1580', '14783236', 'Campbell Insurance', '801 Main Street', 'Lynchburg', 'Virginia', '24505', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1581', '15062809', 'Babel Health', null, 'Pittsburgh', 'Pennsylvania', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1582', '15005467', 'Lyncstream', '13131 W Dodge Rd', 'Omaha', 'Nebraska', '68154', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1583', '15005790', 'Vital Health Links', 'St. Paul/Minneapolis', 'St. Paul/Minneapolis', 'Minnesota', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1584', '15317266', 'Captiva Containers', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1585', '15359796', 'Minds On Inc.', '8864 Whitney Drive', 'Lewis Center', 'Ohio', '43035', 'United States', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1586', '15455309', 'iSymmetry', '3780 Mansell Rd.', 'Alpharetta', 'Georgia', '30022', 'United States', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1587', '12429951', 'Hudson Printing', '241 W. 1700 S.', 'Salt Lake City', 'Utah', '84115', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1588', '15540967', 'Baker Group Merger and Acquisition Consultants, Inc.', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1589', '15472576', 'DogHouse IT Solutions', '1549 Wilma Rudolph Blvd', 'Clarksville', 'Tennessee', '37040', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1590', '14895904', 'Specific-Group - Software Solutions', '1111 Park Centre Blvd, Suite 200', 'Miami', 'Florida', '33169', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1591', '13002995', 'P&H Equipment', null, 'Austin', 'Texas', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1592', '13001850', 'Forecast Energy, Inc.', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1593', '14160499', 'HealthCare Synergy, Inc.', '5555 Corporate Ave.', 'Cypress', 'California', '90630', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1594', '13187755', 'UpBeat Inc', '211 N Lindbergh Blvd', 'St. Louis', 'Missouri', '63141', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1595', '15304502', 'Thrive Insurance', '13230 Pawnee Dr.', 'Oklahoma City', 'Oklahoma', '73114', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1596', '13223748', 'Andrea Electronics Corporation', '65 Orville Drive, Suite One', 'Bohemia', 'New York', '11716', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1597', '14430279', 'Trak-1 Technology Company', null, null, 'Oklahoma', '74152', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1598', '14067706', 'Insight', null, null, 'Arizona', '85284', 'United States', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1599', '15448799', 'Vera Networks, LLC', '2980 McFarlane Road', 'Miami', 'Florida', '33133', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1600', '15448471', 'Airprofan', '425 W Davenport Street', 'Rhinelander', 'Wisconsin', '54501', 'United States', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1601', '12854874', 'Harris Group', '300 Elliott Avenue West', 'Seattle', 'Washington', '98119', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1602', '12951607', 'Trinity Logistics LLC', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1603', '15382108', 'Igetitusa', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1604', '13999679', 'Bradley\'s Hard Surface Cleaning', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1605', '13917275', 'Medical Management Resources , Inc.', '5000 Brittonfield Parkway Suite 500', 'East Syracuse', 'New York', '13057', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1606', '13822494', 'AIS Media, Inc.', '3340 Peachtree Rd.', 'Atlanta', 'Georgia', '30326', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1607', '13605443', 'Theconsultery', null, 'Humble', null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1608', '13451099', 'GraVoc Associates Inc', null, null, 'Massachusetts', '01960-5550', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1609', '13190235', 'WorldEdge Technology', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1610', '13160782', 'OMiga Inc', '1101 Lucas Ave, Ste 202', 'St. Louis, Missouri', 'Missouri', '63101', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1611', '13116193', 'Shoptelligence', '330 E Liberty St', 'Ann Arbor', 'Michigan', '48104', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1612', '13055674', 'Wattabyte IT Consultancy LLP', '805 1st floor 2nd cross HRBR,', 'Bangalore', 'Karnataka', '560043', 'IN', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1613', '13054713', 'Frontline Logistics, Inc.', '10315 Grand River Rd', 'Brighton', 'Michigan', '48116', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1614', '13008893', 'Roxi Stapleton\'s Company', null, 'Saint Louis', 'Missouri', '63130', null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1615', '13008886', 'Outlook', 'One Microsoft Way', 'Redmond', 'Washington', '98052-6401', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1616', '13008883', 'Glenn Jones\' Company', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1617', '13008868', 'David Otto\'s Company', null, 'Las Vegas', 'Nevada', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1618', '12967917', 'Urban Digital Solutions', '2702 Grand Avenue', 'Bellmore', 'New York', '11710', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1619', '12949377', 'The MPI Group', null, 'Shaker Heights', 'Ohio', '44122', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1620', '12888185', 'Ehlers Investment Prtnr', '3060 Centre Pointe Drive', 'Roseville', 'Minnesota', '55113', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1621', '12813669', 'Wanted Shoes Inc', '1370 6th Ave Ste 1101', 'New York', 'New York', '10019-4602', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1622', '12735196', 'Cargoways Logistics, Inc.', '1201 Hahlo St.', 'Houston', 'Texas', '77020', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1623', '12733340', 'GoAhead Solutions, LLC', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1624', '12697765', 'Lake City Printing', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1625', '12696539', 'Specialty Print Communications', '6019 W Howard St', 'Niles', 'Illinois', '60714', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1626', '12521086', 'HalfPriceBanners.com Inc.', null, null, null, '66286', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1627', '12493148', 'TKM Print Solutions, Inc.', '760 Killian Road', 'Akron', 'Ohio', '44319', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1628', '12466566', 'Zeriva', '6590 Shiloh Rd East', 'Alpharetta', 'Georgia', '30005', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1629', '12436530', 'Bloom Group LLC', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1630', '12431116', 'GCI Funding', null, null, null, '80134', 'United States', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1631', '12419020', 'gEHRiMed Electronic Health Record', '16 Biltmore Ave #300', 'Asheville', 'North Carolina', '28801', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1632', '12406050', 'American Diamond Logistics', '5751 Kroger Dr #259', 'Keller', 'Texas', '76244', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1633', '12395241', 'GMCPS', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1634', '12275345', 'TigerPress', '50 Industrial Dr', 'East Longmeadow', 'Massachusetts', '01028', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1635', '12274851', 'The Collective Group, LLC', '9433 Bee Caves Rd', 'Austin', 'Texas', '78733', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1636', '12163794', 'Shiphwf', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1637', '12136042', 'Dispatchr', null, 'San Francisco', 'California', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1638', '12084652', 'Loan Protector Insurance Services, A Willis North America Company', '6001 Cochran Road', 'Solon', 'Ohio', '44139', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1639', '12045125', 'Fistnerconsulting', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1640', '12040438', 'Optimera, Inc', 'NYP', 'New York City', 'New York', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1641', '11834390', 'Saginaw Bay Underwriters', '1258 S. Washington Ave.', 'Saginaw', 'Michigan', '48601', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1642', '11804635', 'Tusco Display', 'P O Box 175', 'Gnadenhutten', 'Ohio', '44629', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1643', '11647692', 'BizAssure', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1644', '11629980', 'L&M Healthcare Communications', '1450 Route 22 West', 'Mountainside', 'New Jersey', '07092', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1645', '11600512', 'Broad Street Valuations', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1646', '11599942', 'KDM Enterprises', '820 Commerce Pkwy', 'Carpentersville', 'Illinois', '60110', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1647', '11597203', 'Printingforless.com', '100 PFL Way', 'Livingston', 'Montana', '59047', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1648', '11549590', 'Quantigen Genomic Services', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1649', '11547545', 'Smith & Wilkinson', '383 US Route One', 'Scarborough, ME', 'Maine', '04074', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1650', '11445141', 'Epic Scan', '908 N Riverside', 'Medford', 'Oregon', '97501', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1651', '11441790', 'BLI Accounting', '9559 Center Ave. Sutie A', 'Rancho Cucamonga', 'California', '91730', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1652', '11296620', 'Econoday Inc', '3730 Mt Diablo Blvd', 'Lafayette', 'California', '94549', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1653', '10810973', 'Readdle', null, 'Folsom', 'California', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1654', '10608658', 'Monarch Teaching Technologies, Inc.', '23625 Commerce Park Suite 150', 'Beachwood', 'Ohio', '44122', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1655', '10591978', '/alert', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1656', '10572924', 'Gibbons Aquaria Inc', '1 Melvin St # B', 'Wakefield', 'Massachusetts', '01880-2570', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1657', '10568334', 'DoctuSoft', 'Gizella út 42-44.', 'Budapest', null, '1143', 'HU', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1658', '10395426', 'Northfork Web/Standard Software', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1659', '10373908', 'Yolon Energy', 'One Hartfield Boulevard', 'East Windsor', 'Connecticut', '06088', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1660', '10224206', 'unityledlighting', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1661', '10191414', 'Innovative Bio-Science Solutions', '2328 Colonial Dr.', 'Atlanta', 'Georgia', '30319', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1662', '9924852', 'Silicon Valley Cloud IT', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1663', '13004057', 'BizWonk Inc.', '25 N Washington St', 'Rochester', 'New York', '14614', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1664', '12798628', 'Restoration Systems LLC', '1605 Audubon Rd', 'Chaska', 'Minnesota', '55318-9513', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1665', '11466329', 'Updike Distribution Logistics, LLC', '435 S 59th Ave, Ste 100', 'Phoenix', 'Arizona', '85043', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1666', '10857664', 'Ice Air', '80 Hartford Ave', 'Mount Vernon', 'New York', '10553', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1667', '10835103', 'Fraudlens', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1668', '10611780', 'The Glitterati', '8020 S Rainbow Blvd #100-153', 'Las Vegas', 'Nevada', '89139', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1669', '10569113', 'Snow Software', null, 'Austin', 'Texas', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1670', '10405466', 'Dreamcatcher-Software.com', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1671', '9865224', 'LS', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1672', '15242875', 'FP Mailing Solutions', '140 N Mitchell Ct #200', 'Addison', 'Illinois', '60101', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1673', '12742592', 'Long Business Advisors, LLC', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1674', '8358436', 'Cook Consulting, Inc.', '409 4th Street SW', 'Hickory', 'North Carolina', '28602', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1675', '7860448', 'GOPARK, U.S.', '701 Poydras St. Suite 250A', 'New Orleans', 'Louisiana', '70139', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1676', '6988835', 'Manalto Inc.', '11730 Plaza America Drive Suite 200', 'Reston', 'Virginia', '20190', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1677', '10289556', 'Hub City Marketing', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1678', '12274398', 'National Traffic Systems Inc', '125 Carlsbad St', 'Cranston', 'Rhode Island', '02920-7357', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1679', '12275077', 'The Kyle David Group LLC', '1575 Pond Rd, Ste 201', 'Allentown', 'Pennsylvania', '18104', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1680', '12675115', 'eDriving, LLC', null, null, 'California', '92008', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1681', '14828924', 'Secure Channels Inc.', '16400 Bake Pkwy Suite100', 'Irvine', 'California', '92618', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1682', '12373845', 'West Michigan Technology and Design Solutions', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1683', '10854356', 'Bay Area Computer Soulutions, LLC', null, null, null, null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1684', '11410990', 'Access Development', '1012 W Beardsley Pl', 'Salt Lake City', 'Utah', '84119', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1685', '12428253', 'Envision Creative Group', '3400 Northland Dr.', 'Austin', 'Texas', '78731', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1686', '12801040', 'Standard Dynamics, Inc.', '1800 Cliff Rd E, Ste e', 'Burnsville', 'Minnesota', '55337', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1687', '14958413', 'Francorp, Inc.', null, null, 'Illinois', '60461', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1688', '11974387', 'Bytlogic', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1689', '14485422', 'Single Point Global', '21720 Red Rum Drive', 'Ashburn', 'Virginia', '20147', 'United States', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1690', '14175751', 'Community Bankers Merchant Services', '908 S Old Missouri Rd', 'Springdale', 'Arkansas', '72764', 'United States', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1691', '14941411', 'TeamLogic IT of Tyler, TX', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1692', '14941228', 'TeamLogic IT of Tampa, FL', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1693', '14941222', 'TeamLogic IT of Alpharetta, GA', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1694', '13886534', 'Vigilance Health Inc', '699 Hampshire Rd.', 'Westlake Village', 'California', '91361', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1695', '13813071', 'Modern Graphics', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1696', '13697511', 'Envision Inc', null, 'Seattle', 'Washington', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1697', '14600843', 'AHS, LLC', '4861 Duck Creek Road', 'Cincinnati', 'Ohio', '45227', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1698', '13001913', 'Allied Logistics', null, 'Atlanta', 'Georgia', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1699', '11730767', 'Element 502', '105 Daventry Lane', 'Louisville', 'Kentucky', '40223', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1700', '14147535', 'Veratics, Inc.', '2194 Highway A1A, Suite 206', 'Indian Harbour Beach', 'Florida', '32937', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1701', '14649653', 'Embassy Global, LLC', 'PO Box 105', 'Orchard Park', 'New York', '14127', 'United States', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1702', '14645089', 'Jeff\'s LuLuLemon', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1703', '10995166', 'Telapprise, LLC', '6920 Santa Teresa Blvd, Ste 208', 'San Jose', 'California', '95119', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1704', '13887023', 'OperationsInc', '535 Connecticut Avenue', 'Norwalk', 'Connecticut', '06854', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1705', '12137852', 'Synaptic Advisory Partners', '41 Old Solomons Island Rd', 'Annapolis', 'Maryland', '21401', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1706', '10231964', 'ORPA Consulting', '500 Old Bremen Rd', 'Carrollton', 'Georgia', '30117', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1707', '13168443', 'Southwest Office Supply & Interiors', '3205 NW Yeon Avenue', 'Portland', 'Oregon', '97210', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1708', '13266398', 'predictiveIT', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1709', '13886360', 'Digital Nirvana, Inc.', '39899 Balentine Dr Suite 200', 'Newark', 'California', '94560', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1710', '13843534', 'Momentum Solar', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1711', '13826640', 'Advanced Transportation Services', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1712', '13595209', 'Test Company from Website', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1713', '9677611', 'Projekt202', '5080 Spectrum Drive', 'Dallas', 'Texas', '75001', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1714', '11282652', '898 Marketing', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1715', '13594634', 'Home Revolution', '777 South Street', 'Newburgh', 'New York', '12550', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1716', '8906526', 'Idmloco', '1717 I Street', 'Sacramento', 'California', '95811', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1717', '12109368', 'nGROUP', '1184 Springmaid Ave', 'Fort Mill', 'South Carolina', '29708', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1718', '8763524', 'CrowdReach', '164 Market Street Suite 238', 'Charleston', 'South Carolina', '29401', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1719', '9843690', 'GM Nameplate', '2040 15th Ave West', 'Seattle', 'Washington', '98119', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1720', '10704522', 'Contact Management, LLC', '22 Village Sq, Ste 23', 'New Hope', 'Pennsylvania', '18938', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1721', '11917587', 'Chairseven Creative, LLC', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1722', '11315171', 'Brady Risk Management', '202 E. Main Street Suite 303', 'Huntington', 'New York', '11743', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1723', '13168369', 'MAGNET', null, null, 'Ohio', '44103', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1724', '10633497', 'SolutionsX LLC', '301 Artillery Park Drive', 'Ft. Mitchell', 'Kentucky', '41017', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1725', '12390582', 'Recruiting Pro Software Llc', '26 Hawk Feather Cir', 'Madison', 'Wisconsin', '53717-2744', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1726', '12735447', 'Oceanstar, Inc.', '20212 South Rancho Way,', 'Los Angeles', 'California', '90220', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1727', '10900315', 'Wheelhouse IT', '2890 West State Rd. 84', 'Fort Lauderdale', 'Florida', '33312', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1728', '12832175', 'Central Data Systems', null, null, 'Michigan', '48335', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1729', '11450396', 'The Cobalt Company', '2800 Eisenhower Ave, Ste 100', 'Alexandria', 'Virginia', '22314', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1730', '11450470', 'SeaChange International, Inc.', null, null, 'Massachusetts', '1720', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1731', '10899086', 'HIC Network Security Solutions, LLC', '325 West 38th Street Suite 1004', 'New York', 'New York', '10018', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1732', '11444001', 'FORTUNE3 Inc', null, 'Doral', 'Florida', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1733', '7865330', 'Status Not Quo Inc.', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1734', '9328250', 'Rjakes LLC.', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1735', '10595531', 'Terra Drive Systems', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1736', '10570172', 'Internet Payment Exchange, Inc. (IPayX)', '1946 N. 13th St.', 'Toledo', 'Ohio', '43604', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1737', '13150985', 'Center for Personal Protection & Safety', '1881 Campus Commons Road, Suite 203', 'Reston', 'Virginia', '20191', 'United States', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1738', '10752031', 'BTech Group', '1600 Golf Rd', 'Rolling Meadows', 'Illinois', '60008', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1739', '10397599', 'The NERDS Group', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1740', '12735565', 'Paskr Inc', '545 Mainstream Drive', 'Nashville', 'Tennessee', '37228', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1741', '13012195', 'Eligha Lacy\'s Company', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1742', '13012101', 'Marlene Johnson\'s Company', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1743', '13008860', 'PEL Associates', null, 'Groton', 'Connecticut', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1744', '11445757', 'Core Augmented Reality Education LLC', '335 Madison Avenue 16th Fl', 'New York', 'New York', '10017', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1745', '11251961', 'Ideagility', '16280 SW Upper Boones Ferry Rd', 'Portland', 'Oregon', '97224', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1746', '11574636', 'Medix Dental - Dental Technology Integration', '300 Brady Street #3', 'Davenport', 'Iowa', '52801', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1747', '12812742', 'Schoox, Inc.', '701 Brazos Street Ste 539', 'Austin', 'Texas', '78701', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1748', '12476074', 'DrivenBI, LLC', '221 East Walnut Street Suite 229', 'Pasadena', 'California', '91101', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1749', '12751668', 'Cornerstone Processing Solutions, Inc', '1600 S. Main Street', 'Oshkosh', 'Wisconsin', '54902', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1750', '12162196', 'Knight Facilities Management, Inc.', '5360 Hampton Place', 'Saginaw', 'Michigan', '48604', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1751', '8104399', 'Aerie Engineering', '804 Pendelton Street', 'Greenville', 'South Carolina', '29601', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1752', '12110226', 'XO Marketing', '8661 Sandy Parkway', 'Sandy', 'Utah', '84070', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1753', '11443984', 'Comtrade Group', 'Savski nasip 7', 'Belgrade', null, '11070', 'RS', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1754', '12546223', 'Mode Transportation', '17330 Preston Road Suite 200C', 'Dallas', 'Texas', '75252', 'United States', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1755', '9272408', 'Peakey Enterprise LLC', '114 E. Center St.', 'Warsaw', 'Indiana', '46580', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1756', '7483116', 'Foster & Morris, LLC', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1757', '9677552', 'DroneView Technologies LLC', null, 'New York', 'New York', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1758', '12371094', 'Calendly', '3423 Piedmont Rd NE', 'Atlanta', 'Georgia', '30305', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1759', '11870723', 'SUNation Solar Systems', '171 Remington Blvd.', 'Ronkonkoma', 'New York', '11779', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1760', '11631343', 'Vivant Corporation.', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1761', '11975400', 'Solutions 21', '152 Wabash St', 'Pittsburgh', 'Pennsylvania', '15220', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1762', '11414856', 'The Daniel Group- the Customer Feedback Company', '400 Clarice Ave.', 'Charlotte', 'North Carolina', '28204', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1763', '11626183', 'Marketly LLC', null, 'Redmond', 'Washington', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1764', '12041321', 'Csgnyc', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1765', '11941548', 'OMEP – Oregon Manufacturing Extension Partnership', '7650 SW Beveland Street', 'Portland', 'Oregon', '97223', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1766', '10741528', 'Pollinate', '315 SW 11th Ave.', 'Portland', 'Oregon', '97205', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1767', '11915090', 'Chairseven', '700 SE Hawthorne Blvd', 'Portland', 'Oregon', '97214', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1768', '11581825', 'Reagan Companies', '8 E. Main Street', 'Marcellus', 'New York', '13108', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1769', '11632235', 'LG Networks, Inc.', '8111 LBJ Fwy', 'Dallas', 'Texas', '75243', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1770', '9867165', 'Veden Media', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1771', '8448769', 'Torusoft', '1496 Lower Water St. Suite 423', 'Halifax', 'Nova Scotia', 'B3J1R9', 'CA', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1772', '11840119', 'Energy Media Group', null, null, null, null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1773', '11693895', 'Cleland Marketing', null, null, null, '97330', 'United States', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1774', '10636303', 'ClaimFox, Inc.', '905 MARCONI AVE CLAIMFOX INC', 'RONKONKOMA', null, '11779', null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1775', '7115648', 'Rickey Conradt, Inc', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1776', '9597600', 'Haider Shnawa', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1777', '9608824', 'Synertech', '1400 Corporate Center Curve', 'Eagan', 'Minnesota', '55121', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1778', '9001155', 'Emotive Analytics', '5862 Delor St.', 'St. Louis', 'Missouri', '63109', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1779', '7294199', 'Backtrend', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1780', '9995425', 'Federalgraphics', '135 W Oxmoor Rd, Ste 319', 'Birmingham', 'Alabama', '35209', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1781', '8135696', 'Accelytics Inc.', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1782', '10817248', 'Big Fish Technology', 'P.O. Box 681553', 'Marietta', 'Georgia', '30068', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1783', '11589951', 'Morgan Stanley & Co', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1784', '10704497', 'Serrano Search, LLC', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1785', '11574619', 'Medixtech', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1786', '10214376', 'Something Digital', '58 W 40th St, Fl 7th', 'New York', 'New York', '10018', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1787', '11316267', 'Flex-Team, Inc.', '753 W Waterloo Rd.', 'Akron', 'Ohio', '44314', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1788', '10831637', 'Aspire-Consulting', '14567 North Outer Forty Dr', 'Chesterfield', 'Missouri', '63017', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1789', '11297098', 'The Happy Roof', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1790', '11316349', 'Phoenix Web Group, Inc.', '10824 N 142nd St', 'Waverly', 'Nebraska', '68462', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1791', '10853207', 'Imaginovation, LLC', '8369 Creedmoor Road., Suite 100', 'Raleigh', 'North Carolina', '27613', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1792', '11258733', 'Iscential', '8220 Jones Road', 'Houston', 'Texas', '77065', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1793', '11133633', 'PM Talent Global', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1794', '10704504', 'Dataedge Solutions', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1795', '10423908', 'PacMin, Inc.', '2021 Raymer Avenue', 'Fullerton', 'California', '92833', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1796', '10214374', 'Xybion Corporation', 'Two Greenwood Square', 'Bensalem', 'Pennsylvania', '19020', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1797', '10542295', 'Snow Plus Inc.', '24 W 600 St. Charles Rd.', 'Carol Stream', 'Illinois', '60188', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1798', '8842335', 'Knetik', '1180 Harwood Ave Suite 1000', 'Altamonte Springs', 'Florida', '32714', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1799', '7330887', 'Aztalan Engineering Inc.', '100 S. Industrial Drive', 'Lake Mills', 'Wisconsin', '53551', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1800', '10782391', 'Vernos Infernos LLC', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1801', '10373389', 'Miller Ad Agency', '2711 Valley View Ln', 'Dallas', 'Texas', '75234', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1802', '9868676', 'Test Company', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1803', '10289635', 'Pinnacle Rock Facility Solutions LLC', '28 Jones Road Suite 9', 'Milford', 'New Hampshire', '03055', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1804', '10040393', 'Improve Group', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1805', '8730139', 'Optimera Group', '30700 Russell Ranch Rd Suite 250', 'Westlake Village', 'California', '91362', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1806', '9677777', 'CGE Energy', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1807', '9866937', 'Rhino Equipment Sales and Service,LLC', '99 Cordell Road', 'Schenectady', 'New York', '12304', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1808', '10039995', 'Trinity Hunt Partners', '2001 Ross Ave., Ste 4250', 'Dallas', 'Texas', '75201', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1809', '8998783', 'Computer Consultants, Inc.', '1075 Cherry Creek Rd', 'Marquette', 'Michigan', '49855-9408', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1810', '9843563', 'Inter-Global, Inc', null, null, null, null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1811', '9843548', 'Orion Health', 'Orion House, 181 Grafton Road, Grafton', 'Auckland', null, '1010', 'NZ', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1812', '8742998', 'Conversion Logic', '12300 Wilshire Blvd suite 200', 'Los Angeles', 'California', '90025', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1813', '9677669', 'ADC Wastewater Engineering', '729 Court C', 'Tacoma', 'Washington', '98402', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1814', '8455093', 'Huffman Associates LLC', 'The Applied Technology Center 111 West Main Street', 'Bay Shore', 'New York', '11706', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1815', '8876099', 'Operations Assistance LLC', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1816', '9335591', 'Majestic Sales', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1817', '9677556', 'Kczalesin', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1818', '9604615', 'Richmond Casting Company Inc.', '1775 Rich Rd', 'Richmond', 'Indiana', '47374-1479', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1819', '8257144', 'Solvit Software, Inc', 'Atlanta', 'Atlanta', 'Georgia', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1820', '8578305', 'Rackspace Hosting, Inc', '1 Fanatical Place', 'San Antonio', 'Texas', '78218', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1821', '8906540', 'Saxon Remote Systems', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1822', '8811134', 'I2i (Infrastructure Insights, Inc. )', '800 Central Parkway East Suite 300', 'Plano', 'Texas', '75074', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1823', '7846899', 'Alliance Worldwide Investigative Group Inc.', '4 Executive Park Drive', 'Clifton Park', 'New York', '12065', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1824', '7252098', 'Total Facility Solutions, Inc.', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1825', '7626508', 'COPsync, Inc.', null, 'Canyon Lake', 'Texas', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1826', '6975689', 'Dynamic Quest', '4821 Koger Blvd.', 'Greensboro', 'North Carolina', '27407', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1827', '6962515', 'Morgan IDS Inc', 'Morgan IDS Inc 1579 Wilson Ave Mingo Jct Ohio', 'Mingo Junction', 'Ohio', '43938', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1828', '8032451', 'People With Chemistry', 'Levels 32-34 286 Euston Road', 'London', null, 'NW1 3DP', 'GB', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1829', '7019786', 'Finsync', '100 Galleria Parkway Suite 240', 'Atlanta', 'Georgia', '30339', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1830', '8978127', 'TDM & Associates', '204 N Main St', 'St Joseph', 'Illinois', '61873', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1831', '8842361', 'Woven Measure, Inc', '105 Ambler Way ste 100', 'Alpharetta', 'Georgia', '30022', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1832', '8747063', 'RSKM Executive Recruitment', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1833', '8978720', 'GollyGood Software', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1834', '8842206', 'Sawyer Mailing Systems', null, null, null, '63011', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1835', '7916911', 'Thomas H. Heist Insurance Agency', '700 West Avenue', 'Ocean City', 'New Jersey', '08226', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1836', '8975581', 'Winfosoft', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1837', '8641525', 'Maine Technology Group', '120 Augusta Rd', 'Winslow', 'Maine', '04901', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1838', '7972991', 'Advanticom', '191 Wyngate Drive', 'Monroeville', 'Pennsylvania', '15146', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1839', '8139812', 'Falcon Waterfree Technologies', '2255 Barry Ave', 'Los Angeles', 'California', '90064', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1840', '7558741', 'Greyson Technologies Inc.', '6350 N Andrew Avenue Suite 200', 'Fort Lauderdale', 'Florida', '33309', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1841', '8205543', '@properties', '618 W Fulton St', 'Chicago', 'Illinois', '60661', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1842', '8105373', 'Citadel Blue', '500 W Putnam Ave Suite 400', 'Greenwich', 'Connecticut', '06830', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1843', '7861662', 'BioStar Renewables', '9400 Reeds, Suite 150', 'Overland Park', 'Kansas', '66207', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1844', '7618714', 'Modern Impressions', '5029 W WT Harris Blvd', 'Charlotte', 'North Carolina', '28269', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1845', '8194207', 'Devscape', '5870 Wind Cave Ln. Suite 3B', 'Jacksonville', 'Florida', '32258', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1846', '7403439', 'Brightwing', '431 Stephenson Hwy', 'Troy', 'Michigan', '48083', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1847', '7507023', 'HOSTEK.COM', 'PO Box 701048', 'Tulsa', 'Oklahoma', '74170', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1848', '7485488', 'Inland Insurance', '16760 Boyle Ave', 'Fontana', 'California', '92337-7503', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1849', '7130943', 'Aperio CI', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1850', '7030653', 'ITTI PVT LTD', '4/1, IBC Knowledge Park, Phase 2, \"D\" Block, 9th Floor Bannerghatta Road', 'Bangalore', 'Karnataka', '560029', 'IN', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1851', '6982319', 'TECNEX Systems', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1852', '7126513', 'Iosue Associates', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1853', '8842862', 'StreamBright', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1854', '8818689', 'Technical Financial Solutions', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1855', '7529690', 'SunWize Power & Battery, LLC', 'US Highway 1 S', 'Aberdeen', 'North Carolina', '28315', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1856', '8637669', 'Quick Right, Inc.', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1857', '8447458', '7i Operations Group', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1858', '8747061', 'RSKM', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1859', '8336459', 'iPatientCare, Inc.', 'iPatientCare, Inc. One Woodbridge Center, Suite 812', 'Woodbridge', 'New Jersey', '07095', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1860', '7936369', 'Maseke', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1861', '8730165', 'BBCR Consulting', 'Cambridge Innovation Center', 'Cambridge', 'Massachusetts', '02142', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1862', '8472078', 'CustomerFirst Renewables', '1425 K Street, N.W., Suite 350', 'Washington', 'District Of Columbia', '20005', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1863', '8598662', 'EnergyLogic, Inc.', '309 Mountain Ave', 'Berthoud', 'Colorado', '80513', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1864', '8578412', 'ACBM Solutions', '110 Springfield Ave', 'Berkeley Heights', 'New Jersey', '07922', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1865', '8285041', 'TivaCloud - DOT & OSHA Compliance Software', null, 'Houston', 'Texas', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1866', '7934032', 'ProBusinessTools®', '732 3rd Street', 'New Martinsville, WV', 'West Virginia', '26155', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1867', '7977826', 'Encartele', '8210 South 109th Street', 'LaVista', 'Nebraska', '68128', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1868', '8134348', 'Comnexia', '590 W Crossville Rd, Ste 201', 'Roswell', 'Georgia', '30075', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1869', '7031986', 'cHb Advisors pc', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1870', '8076979', 'The Wiseman Agency', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1871', '7952567', 'Viyu', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1872', '7902668', 'SRC Technologies', '3148 Mid Valley Drive', 'De Pere', 'Wisconsin', '54115', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1873', '7708370', 'Arrow Strategies', '30300 Telegraph Rd. Suite 117', 'Bingham Farms', 'Michigan', '48025', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1874', '8227773', 'CopyFax', null, null, null, null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1875', '7019743', 'Semantify', null, 'Chicago', 'Illinois', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1876', '7953589', 'iBusinessSolutions', '7020 Professional Parkway E', 'Sarasota', 'Florida', '34240', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1877', '7897961', 'Nottingham Insurance', '2277 Route 33 Suite 404', 'Hamilton', 'New Jersey', '08690', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1878', '7403601', 'WealthTechs Inc.', '711 North Ditmar Street Unit C', 'Oceanside', 'California', '92054', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1879', '7952891', 'NSD IT', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1880', '8160901', 'bBooth', null, 'West Hollywood', 'California', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1881', '7996549', 'Renodis Communications Managed Services', '476 Robert Street N', 'St. Paul', 'Minnesota', '55101', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1882', '7692317', 'Business World Inc.', '920 S. Spring St.', 'Little Rock', 'Arkansas', '72201', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1883', '8136178', 'Simmitri', '1999 Bascom Ave. Ste. 700', 'Campbell', 'California', '95008', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1884', '8134323', 'nResult', '903 NE 88th Circle', 'Vancouver', 'Washington', '98665', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1885', '7894319', 'Business Mobility Partners', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1886', '6963860', 'Credit Damage Experts', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1887', '8134459', 'PREMIER System Integrators', '140 Weakley Ln.', 'Smyrna', 'Tennessee', '37167', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1888', '7529184', 'Somethingcool.com', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1889', '8063306', 'Executive Business Services, Makers of PROPRICER™', '43398 Business Park Drive', 'Temecula', 'California', '92590', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1890', '8029899', 'Auctoro Staffing Solutions', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1891', '7861060', 'Viking Mechanical Systems, Inc', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1892', '7953564', 'Batts Communications Services, Inc.', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1893', '7986564', 'Atlanta Baggage Storage', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1894', '7986573', 'Munger Technical Services', '3832 N Hubbard St.', 'Milwaukee', 'Wisconsin', '53222', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1895', '7754740', 'Power Home Solar and Roofing', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1896', '7869431', 'Aegis Insurance Markets', '40169 Truckee Airport Rd. Suite 203', 'Truckee', 'California', '96161', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1897', '7313619', 'Magnets', '51 Pacific Avenue Suite 4', 'Jersey City', 'New Jersey', '07304', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1898', '7900218', 'Magill HR', '11714 Meadow Falls', 'Houston', 'Texas', '77377', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1899', '7300850', 'Fluid Imaging', '200 Enterprise Drive', 'Scarborough', 'Maine', '04074', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1900', '7891454', 'Computer Sales & Services', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1901', '7428530', 'APMissouri', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1902', '7300150', 'Devine Consulting LLC', '419 Macek Rd', 'Richmond', 'Texas', '77469', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1903', '7193475', 'BUILDINGSTARS', '33 Worthington Access Dr.', 'Saint Louis', 'Missouri', '63043', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1904', '7809840', 'ProWasteUSA', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1905', '7589855', 'Vanguard Dealer Services', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1906', '7476159', 'Dalechek Technology Group', '2 Cityplace Dr, Ste 200', 'St. Louis, Missouri', 'Missouri', '63141', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1907', '6962482', 'Nucheckcorp', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1908', '7695973', 'Channel Media Solutions', '112 W. 34th Street', 'New York', 'New York', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1909', '7403489', 'Persolvent', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1910', '7523206', 'Sharkansky LLP', '1350 Belmont Street', 'Brockton', 'Massachusetts', '02301', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1911', '7391193', 'INSUREtrust', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1912', '7643167', 'CNI Technology Services', '7000 South Yosemite Street Suite 125', 'Centennial', 'Colorado', '80112', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1913', '7371506', 'Alesco Advisors LLC', 'Tobey Village Office Park 120 Office Park Way', 'Pittsford', 'New York', '14534', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1914', '7501289', 'Cube Management', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1915', '7476398', 'Information Systems Security Association (ISSA)', null, 'Aurora', 'Colorado', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1916', '7488850', 'iSalesman.com', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1917', '7108446', 'Origami Risk', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1918', '7554376', 'JSI Telecom', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1919', '7393998', 'General Medicine', '21333 Haggerty Rd Suite 150', 'Novi', 'Michigan', '48375', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1920', '7500358', 'Slone Partners', '14001-C Saint Germain Drive #165', 'Centreville', 'Virginia', '20121', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1921', '7078032', 'intellX Solutions', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1922', '7138291', 'Miller & Associates CPAs', '9800 Mt. Pyramid Ct., Suite 400', 'Englewood', 'Colorado (co)', '80112', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1923', '7371534', 'BSM Facility Services Group', null, null, null, '94520', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1924', '7015286', 'TechWise Group', '441 East Hector Street Third Floor', 'Conshohocken', 'Pennsylvania', '19428', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1925', '7371485', 'TeleBright Software Corporation', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1926', '7301054', 'Network Guidance 2.0 LLC', '401 North 3rd Street Suite 680', 'Minneapolis', 'Minnesota', '55401', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1927', '7119477', 'Wallace Welch & Willingham', '300 1st Avenue South 5th Floor', 'Saint Petersburg', 'Florida', '33701', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1928', '6982342', 'Wessel Accounting', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1929', '6962461', 'Path Works Inc', '800 NW Starker Ave # 24', 'Corvallis', 'Oregon', '97330-4563', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1930', '7428422', 'Firmament Solutions Inc.', '.510 Plaza dr', 'Atlanta', 'Georgia', '30349', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1931', '7315397', 'The ENERGY PRACTICE GROUP of Allen Austin Global Executive Search', '4543 Post Oak Place Dr, Ste 217', 'Houston', 'Texas', '77027', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1932', '7000632', 'F3 Partners', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1933', '7015608', 'Trident Consulting Inc.', '6990 Village Parkway, Suite 212', 'Dublin', 'California', '94568', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1934', '7338270', 'inventiv', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1935', '7332200', 'Cisco Systems, Inc.', 'Tasman Way', 'San Jose', 'California', '95134', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1936', '7300095', 'G Squared Studios', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1937', '7299960', 'Beckles CPA', '14 NE 1St Avenue Suite 805', 'Miami', 'Florida', '33132', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1938', '7130886', 'SLD CPAs', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1939', '7120926', 'Fully Functional Technology', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1940', '7314260', 'Blocher Consulting', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1941', '7134775', 'Intuitive Technology Partners', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1942', '7050314', 'GNH Services, Inc.', '600 Trade Center Blvd.', 'Chesterfield', 'Missouri', '63005', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1943', '7260268', 'Diverse Technologies Coporation', '4355 Nicole Drive', 'Lanham', 'Maryland', '20706', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1944', '6963395', 'Commercial Acceptance Company', '2300 Gettysburg Road', 'Camp Hill', 'Pennsylvania', '17011', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1945', '6962791', 'EnosiX, Inc.', '1500 Chiquita Center 250 East Fifth Street', 'Cincinnati', 'Ohio', '45202', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1946', '7125381', 'PMG GLOBAL', '2325 Dulles Corner Boulevard Suite 500', 'Herndon', 'Virginia', '20171', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1947', '7114134', 'Panera Bread Company', 'P.O. Box 2817', 'Wichita', 'Kansas', '67201-2817', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1948', '7113815', 'Botkeeper', null, 'Boston', 'Massachusetts', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1949', '7019641', 'Bir Ventures', null, 'Bloomington', 'Minnesota', null, 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1950', '7019256', 'The Murkin Group, LLC', '14004 Roosevelt Blvd, Ste 613', 'Clearwater', 'Florida', '33762', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1951', '6988420', 'LinkedSelling', null, 'LinkedUniversity.com', null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1952', '6975702', 'Dunbrooke Sportswear', '219 W Industrial Ave', 'El Dorado Spgs', 'Missouri', '64744-0000', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1953', '6962498', 'ReppertFactor, LLC', '621 Bristol Pike Suite B', 'Bensalem', 'Pennsylvania', '19020', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1954', '6986795', 'CFO Solutions', 'N14 W23755 Stone Ridge Drive Suite 290', 'Waukesha', 'Wisconsin', '53188', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1955', '6963430', 'Adaptivealt', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1956', '6963688', 'Seerion Sales', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1957', '6963435', 'Applied Asset Management', '36311 Detroit Rd, Ste 205A', 'Avon', 'Ohio', '44011', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1958', '6963427', 'KS Tech Holdings', null, null, null, null, null, null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1959', '6963294', 'Marketing Architects', '110 Cheshire Ln, Ste 200', 'Hopkins', 'Minnesota', '55305', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1960', '6963251', 'MOS Creative', '8945 Guilford Rd, Ste 130', 'Columbia', 'Maryland', '21046', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1961', '6962510', 'Omnitrol Networks', '3945 Freedom Circle Suite 560', 'Santa Clara', 'California', '95054', 'US', null, null, null, null, null);
INSERT INTO `sap_client_prosperworks` VALUES ('1962', '6962488', 'Christopher G. Fox', null, null, null, null, null, null, null, null, null, null);

-- ----------------------------
-- Table structure for sap_client_stats
-- ----------------------------
DROP TABLE IF EXISTS `sap_client_stats`;
CREATE TABLE `sap_client_stats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `accepted_meetings` smallint(6) NOT NULL,
  `outbound_messages` int(11) NOT NULL,
  `outbound_messages_unique` int(11) NOT NULL,
  `bounced_messages` int(11) NOT NULL,
  `bounced_messages_unique` int(11) NOT NULL,
  `mcr` decimal(8,2) NOT NULL,
  `ppm` decimal(8,2) NOT NULL,
  `date_calculated` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `client_date_calculated` (`client_id`,`date_calculated`),
  KEY `client_id` (`client_id`),
  CONSTRAINT `sap_client_stats_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `sap_client` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of sap_client_stats
-- ----------------------------

-- ----------------------------
-- Table structure for sap_client_targeting_profiles
-- ----------------------------
DROP TABLE IF EXISTS `sap_client_targeting_profiles`;
CREATE TABLE `sap_client_targeting_profiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `title` varchar(250) DEFAULT NULL,
  `industries` text,
  `industry_keywords` text,
  `naics` varchar(150) DEFAULT NULL,
  `departments` text,
  `employee_size_from` varchar(50) DEFAULT NULL,
  `employee_size_to` varchar(50) DEFAULT NULL,
  `revenue_from` varchar(50) DEFAULT NULL,
  `revenue_to` varchar(50) DEFAULT NULL,
  `company_attr` varchar(50) DEFAULT NULL,
  `company_attr_txt` varchar(150) DEFAULT NULL,
  `prospect_management_level` text,
  `titles` text,
  `titles_keywords` text,
  `city` varchar(75) DEFAULT NULL,
  `states` text,
  `countries` text,
  `geotarget` text,
  `geotarget_lat` text,
  `geotarget_lng` text,
  `radius` int(5) DEFAULT NULL,
  `link_notes` text,
  `build_to` varchar(150) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNQ_CLIENT` (`client_id`),
  KEY `created_by` (`created_by`),
  CONSTRAINT `sap_client_targeting_profiles_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `sap_client` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `sap_client_targeting_profiles_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `sap_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of sap_client_targeting_profiles
-- ----------------------------

-- ----------------------------
-- Table structure for sap_client_targeting_requests
-- ----------------------------
DROP TABLE IF EXISTS `sap_client_targeting_requests`;
CREATE TABLE `sap_client_targeting_requests` (
  `request_id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `title` varchar(250) DEFAULT NULL,
  `industries` text,
  `industry_keywords` text,
  `naics` varchar(150) DEFAULT NULL,
  `departments` text,
  `employee_size_from` varchar(50) DEFAULT NULL,
  `employee_size_to` varchar(50) DEFAULT NULL,
  `revenue_from` varchar(50) DEFAULT NULL,
  `revenue_to` varchar(50) DEFAULT NULL,
  `company_attr` varchar(50) DEFAULT NULL,
  `company_attr_txt` varchar(150) DEFAULT NULL,
  `prospect_management_level` text,
  `titles` text,
  `titles_keywords` text,
  `city` varchar(75) DEFAULT NULL,
  `states` text,
  `countries` text,
  `geotarget` text,
  `geotarget_lat` text,
  `geotarget_lng` text,
  `radius` int(5) DEFAULT NULL,
  `link_notes` text,
  `build_to` varchar(150) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`request_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of sap_client_targeting_requests
-- ----------------------------

-- ----------------------------
-- Table structure for sap_dashboard_stat
-- ----------------------------
DROP TABLE IF EXISTS `sap_dashboard_stat`;
CREATE TABLE `sap_dashboard_stat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `clients` int(11) NOT NULL,
  `accounts_syncing` int(11) NOT NULL,
  `prospects` int(11) NOT NULL,
  `prospect_events` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sap_dashboard_stat
-- ----------------------------
INSERT INTO `sap_dashboard_stat` VALUES ('1', '0', '0', '0', '0');

-- ----------------------------
-- Table structure for sap_department
-- ----------------------------
DROP TABLE IF EXISTS `sap_department`;
CREATE TABLE `sap_department` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `department` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `industry` (`department`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sap_department
-- ----------------------------

-- ----------------------------
-- Table structure for sap_department_keyword
-- ----------------------------
DROP TABLE IF EXISTS `sap_department_keyword`;
CREATE TABLE `sap_department_keyword` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `department_id` int(11) NOT NULL,
  `keyword` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `industry_id` (`department_id`),
  CONSTRAINT `department_id` FOREIGN KEY (`department_id`) REFERENCES `sap_department` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sap_department_keyword
-- ----------------------------

-- ----------------------------
-- Table structure for sap_download
-- ----------------------------
DROP TABLE IF EXISTS `sap_download`;
CREATE TABLE `sap_download` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `list_request_id` int(11) DEFAULT NULL,
  `created_on` date NOT NULL,
  `filename` varchar(255) NOT NULL,
  `row_count` int(11) NOT NULL,
  `filtered` varchar(255) NOT NULL,
  `filtered_count` int(11) NOT NULL,
  `purged` varchar(255) NOT NULL,
  `purged_count` int(11) NOT NULL,
  `saved_to_db` tinyint(1) NOT NULL DEFAULT '0',
  `uploaded_to_outreach` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `list_request_id` (`list_request_id`),
  KEY `t3` (`created_on`,`row_count`,`filtered_count`),
  CONSTRAINT `sap_download_ibfk_1` FOREIGN KEY (`list_request_id`) REFERENCES `sap_list_request` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sap_download
-- ----------------------------

-- ----------------------------
-- Table structure for sap_download_filtered
-- ----------------------------
DROP TABLE IF EXISTS `sap_download_filtered`;
CREATE TABLE `sap_download_filtered` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `list_request_id` int(11) DEFAULT NULL,
  `created_on` date NOT NULL,
  `filename` varchar(255) NOT NULL,
  `row_count` int(11) NOT NULL,
  `nidb` varchar(255) NOT NULL,
  `nidb_count` int(45) DEFAULT NULL,
  `idbnor` varchar(255) NOT NULL,
  `idbnor_count` int(11) DEFAULT NULL,
  `idbior` varchar(100) DEFAULT NULL,
  `idbior_count` int(11) DEFAULT NULL,
  `filtered` varchar(255) NOT NULL,
  `filtered_count` int(11) DEFAULT NULL,
  `purged` varchar(255) NOT NULL,
  `purged_count` int(11) DEFAULT NULL,
  `saved_to_db` tinyint(1) DEFAULT '0',
  `uploaded_to_outreach` tinyint(1) DEFAULT '0',
  `client_id` int(11) DEFAULT NULL,
  `client_name` varchar(255) NOT NULL,
  `search_criteria` text,
  `saved_to_db_count` int(11) DEFAULT NULL,
  `saved_to_db_ids` text,
  `status` varchar(45) DEFAULT 'In Queue',
  PRIMARY KEY (`id`),
  KEY `list_request_id` (`list_request_id`),
  KEY `client_id` (`client_id`),
  CONSTRAINT `sap_download_filtered_ibfk_1` FOREIGN KEY (`list_request_id`) REFERENCES `sap_list_request` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `sap_download_filtered_ibfk_2` FOREIGN KEY (`client_id`) REFERENCES `sap_client` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sap_download_filtered
-- ----------------------------

-- ----------------------------
-- Table structure for sap_download_filtered_prospect
-- ----------------------------
DROP TABLE IF EXISTS `sap_download_filtered_prospect`;
CREATE TABLE `sap_download_filtered_prospect` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `download_id` int(11) NOT NULL,
  `prospect_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `download_filtered_id` (`download_id`),
  KEY `prospect_filtered_id` (`prospect_id`),
  CONSTRAINT `sap_download_filtered_prospect_ibfk_1` FOREIGN KEY (`download_id`) REFERENCES `sap_download_filtered` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `sap_download_filtered_prospect_ibfk_2` FOREIGN KEY (`prospect_id`) REFERENCES `sap_prospect` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sap_download_filtered_prospect
-- ----------------------------

-- ----------------------------
-- Table structure for sap_download_prospect
-- ----------------------------
DROP TABLE IF EXISTS `sap_download_prospect`;
CREATE TABLE `sap_download_prospect` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `download_id` int(11) NOT NULL,
  `prospect_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `download_id` (`download_id`),
  KEY `prospect_id` (`prospect_id`),
  CONSTRAINT `sap_download_prospect_ibfk_1` FOREIGN KEY (`download_id`) REFERENCES `sap_download` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `sap_download_prospect_ibfk_2` FOREIGN KEY (`prospect_id`) REFERENCES `sap_prospect` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sap_download_prospect
-- ----------------------------

-- ----------------------------
-- Table structure for sap_employee_range
-- ----------------------------
DROP TABLE IF EXISTS `sap_employee_range`;
CREATE TABLE `sap_employee_range` (
  `employees_range` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `index` int(11) NOT NULL,
  `display_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  UNIQUE KEY `employees_range` (`employees_range`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of sap_employee_range
-- ----------------------------
INSERT INTO `sap_employee_range` VALUES ('Employees.1to4', '1', '1-4');
INSERT INTO `sap_employee_range` VALUES ('Employees.5to9', '2', '5-9');
INSERT INTO `sap_employee_range` VALUES ('Employees.10to19', '3', '10-19');
INSERT INTO `sap_employee_range` VALUES ('Employees.20to49', '4', '20-49');
INSERT INTO `sap_employee_range` VALUES ('Employees.50to99', '5', '50-99');
INSERT INTO `sap_employee_range` VALUES ('Employees.100to249', '6', '100-249');
INSERT INTO `sap_employee_range` VALUES ('Employees.250to499', '7', '250-499');
INSERT INTO `sap_employee_range` VALUES ('Employees.500to999', '8', '500-999');
INSERT INTO `sap_employee_range` VALUES ('Employees.1000to4999', '9', '1,000-4,999');
INSERT INTO `sap_employee_range` VALUES ('Employees.5000to9999', '10', '5,000-9,999');
INSERT INTO `sap_employee_range` VALUES ('Employees.10000plus', '11', '10,000+');

-- ----------------------------
-- Table structure for sap_gmail_account_snapshot
-- ----------------------------
DROP TABLE IF EXISTS `sap_gmail_account_snapshot`;
CREATE TABLE `sap_gmail_account_snapshot` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gmail_account_id` int(11) NOT NULL,
  `created_at` date NOT NULL,
  `label_count_scheduling_in_progress` int(11) NOT NULL,
  `label_count_reschedule_cancel` int(11) NOT NULL,
  `label_count_referral` int(11) NOT NULL,
  `label_count_confused` int(11) NOT NULL,
  `label_count_closed_lost` int(11) NOT NULL,
  `label_count_bad_email` int(11) NOT NULL,
  `label_count_unknown` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `gmail_account_id_2` (`gmail_account_id`,`created_at`),
  KEY `gmail_account_id` (`gmail_account_id`),
  CONSTRAINT `sap_gmail_account_snapshot_ibfk_1` FOREIGN KEY (`gmail_account_id`) REFERENCES `sap_client_account_gmail` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sap_gmail_account_snapshot
-- ----------------------------

-- ----------------------------
-- Table structure for sap_gmail_account_stats
-- ----------------------------
DROP TABLE IF EXISTS `sap_gmail_account_stats`;
CREATE TABLE `sap_gmail_account_stats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gmail_account_id` int(11) NOT NULL,
  `label_count_inbox` int(11) NOT NULL,
  `label_count_scheduling_in_progress` int(11) NOT NULL,
  `label_count_reschedule_cancel` int(11) NOT NULL,
  `label_count_referral` int(11) NOT NULL,
  `label_count_confused` int(11) NOT NULL,
  `label_count_closed_lost` int(11) NOT NULL,
  `label_count_bad_email` int(11) NOT NULL,
  `label_count_unknown` int(11) NOT NULL,
  `label_count_check_back_in_now` int(11) NOT NULL,
  `label_count_check_back_in_1_month` int(11) NOT NULL,
  `label_count_check_back_in_2_months` int(11) NOT NULL,
  `label_count_check_back_in_3_months` int(11) NOT NULL,
  `label_count_check_back_in_4_months` int(11) NOT NULL,
  `label_count_check_back_in_6_months` int(11) NOT NULL,
  `label_count_check_back_in_8_months` int(11) NOT NULL,
  `label_count_check_back_in_12_months` int(11) NOT NULL,
  `label_count_not_interested_fup` int(11) NOT NULL,
  `label_count_meeting_in_progress_fup` int(11) NOT NULL,
  `label_count_rescheduled_fup` int(11) NOT NULL,
  `label_count_meeting_scheduled` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `gmail_account_id_2` (`gmail_account_id`),
  KEY `gmail_account_id` (`gmail_account_id`),
  CONSTRAINT `sap_gmail_account_stats_ibfk_1` FOREIGN KEY (`gmail_account_id`) REFERENCES `sap_client_account_gmail` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sap_gmail_account_stats
-- ----------------------------

-- ----------------------------
-- Table structure for sap_gmail_event_colors
-- ----------------------------
DROP TABLE IF EXISTS `sap_gmail_event_colors`;
CREATE TABLE `sap_gmail_event_colors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gmail_account_id` int(11) NOT NULL,
  `type` enum('calendar','event') NOT NULL,
  `color_key` varchar(50) NOT NULL,
  `background_color` varchar(10) NOT NULL,
  `foreground_color` varchar(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `gmail_event_colors_unique_set` (`gmail_account_id`,`type`,`color_key`) USING BTREE,
  KEY `gmail_account_id` (`gmail_account_id`),
  CONSTRAINT `sap_gmail_event_colors_ibfk_1` FOREIGN KEY (`gmail_account_id`) REFERENCES `sap_client_account_gmail` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sap_gmail_event_colors
-- ----------------------------

-- ----------------------------
-- Table structure for sap_gmail_events
-- ----------------------------
DROP TABLE IF EXISTS `sap_gmail_events`;
CREATE TABLE `sap_gmail_events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL,
  `event_id` varchar(255) NOT NULL,
  `event_color_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `starts_at` datetime NOT NULL,
  `ends_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` varchar(20) NOT NULL,
  `title` varchar(150) DEFAULT NULL,
  `prospect_id` int(11) DEFAULT NULL,
  `has_valid_recipient` tinyint(1) NOT NULL DEFAULT '0',
  `template_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `event_id` (`event_id`),
  KEY `account_id` (`account_id`),
  KEY `prospect_id` (`prospect_id`),
  KEY `event_color_id` (`event_color_id`),
  CONSTRAINT `sap_gmail_events_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `sap_client_account_gmail` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `sap_gmail_events_ibfk_2` FOREIGN KEY (`prospect_id`) REFERENCES `sap_prospect` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `sap_gmail_events_ibfk_3` FOREIGN KEY (`event_color_id`) REFERENCES `sap_gmail_event_colors` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sap_gmail_events
-- ----------------------------

-- ----------------------------
-- Table structure for sap_gmail_message
-- ----------------------------
DROP TABLE IF EXISTS `sap_gmail_message`;
CREATE TABLE `sap_gmail_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gmail_account_id` int(11) NOT NULL,
  `message_id` varchar(16) NOT NULL,
  `thread_id` varchar(16) NOT NULL,
  `to` varchar(100) DEFAULT NULL,
  `prospect_id` int(11) DEFAULT NULL,
  `sent_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `processed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `label_applied` varchar(35) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `message_id` (`message_id`) USING BTREE,
  KEY `gmail_account_id` (`gmail_account_id`),
  KEY `prospect_id` (`prospect_id`),
  KEY `label_applied` (`label_applied`),
  KEY `thread_id` (`thread_id`),
  CONSTRAINT `sap_gmail_message_ibfk_1` FOREIGN KEY (`gmail_account_id`) REFERENCES `sap_client_account_gmail` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `sap_gmail_message_ibfk_2` FOREIGN KEY (`prospect_id`) REFERENCES `sap_prospect` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sap_gmail_message
-- ----------------------------

-- ----------------------------
-- Table structure for sap_gmail_retrain_queue
-- ----------------------------
DROP TABLE IF EXISTS `sap_gmail_retrain_queue`;
CREATE TABLE `sap_gmail_retrain_queue` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gmail_account_id` int(11) NOT NULL,
  `message_id` varchar(16) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `message_id` (`message_id`),
  KEY `gmail_account_id` (`gmail_account_id`),
  CONSTRAINT `sap_gmail_retrain_queue_ibfk_1` FOREIGN KEY (`gmail_account_id`) REFERENCES `sap_client_account_gmail` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sap_gmail_retrain_queue
-- ----------------------------

-- ----------------------------
-- Table structure for sap_group
-- ----------------------------
DROP TABLE IF EXISTS `sap_group`;
CREATE TABLE `sap_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `sort_order` mediumint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sap_group
-- ----------------------------

-- ----------------------------
-- Table structure for sap_group_title
-- ----------------------------
DROP TABLE IF EXISTS `sap_group_title`;
CREATE TABLE `sap_group_title` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `sort_order` mediumint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `group_id` (`group_id`),
  CONSTRAINT `group_id` FOREIGN KEY (`group_id`) REFERENCES `sap_group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sap_group_title
-- ----------------------------

-- ----------------------------
-- Table structure for sap_group_title_negative
-- ----------------------------
DROP TABLE IF EXISTS `sap_group_title_negative`;
CREATE TABLE `sap_group_title_negative` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_title_id` int(11) NOT NULL,
  `keyword` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `group_title_id` (`group_title_id`),
  CONSTRAINT `group_title_id_negative` FOREIGN KEY (`group_title_id`) REFERENCES `sap_group_title` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sap_group_title_negative
-- ----------------------------

-- ----------------------------
-- Table structure for sap_group_title_variation
-- ----------------------------
DROP TABLE IF EXISTS `sap_group_title_variation`;
CREATE TABLE `sap_group_title_variation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_title_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `group_title_id` (`group_title_id`),
  CONSTRAINT `group_title_id` FOREIGN KEY (`group_title_id`) REFERENCES `sap_group_title` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sap_group_title_variation
-- ----------------------------

-- ----------------------------
-- Table structure for sap_industry
-- ----------------------------
DROP TABLE IF EXISTS `sap_industry`;
CREATE TABLE `sap_industry` (
  `hierarchical_category` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `display_name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `level_1` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `level_2` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `level_3` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  UNIQUE KEY `hierarchical_category` (`hierarchical_category`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of sap_industry
-- ----------------------------
INSERT INTO `sap_industry` VALUES ('Undefined', 'Undefined', 'Undefined', null, null);
INSERT INTO `sap_industry` VALUES ('Industry.agriculture', 'agriculture', 'agriculture', null, null);
INSERT INTO `sap_industry` VALUES ('Industry.agriculture.animals', 'animals', 'agriculture', 'animals', null);
INSERT INTO `sap_industry` VALUES ('Industry.agriculture.crops', 'crops', 'agriculture', 'crops', null);
INSERT INTO `sap_industry` VALUES ('Industry.bizservice', 'bizservice', 'bizservice', null, null);
INSERT INTO `sap_industry` VALUES ('Industry.bizservice.accounting', 'accounting', 'bizservice', 'accounting', null);
INSERT INTO `sap_industry` VALUES ('Industry.bizservice.auction', 'auction', 'bizservice', 'auction', null);
INSERT INTO `sap_industry` VALUES ('Industry.bizservice.callcenter', 'callcenter', 'bizservice', 'callcenter', null);
INSERT INTO `sap_industry` VALUES ('Industry.bizservice.collection', 'collection', 'bizservice', 'collection', null);
INSERT INTO `sap_industry` VALUES ('Industry.bizservice.consulting', 'consulting', 'bizservice', 'consulting', null);
INSERT INTO `sap_industry` VALUES ('Industry.bizservice.datamgmt', 'datamgmt', 'bizservice', 'datamgmt', null);
INSERT INTO `sap_industry` VALUES ('Industry.bizservice.hr', 'hr', 'bizservice', 'hr', null);
INSERT INTO `sap_industry` VALUES ('Industry.bizservice.janitor', 'janitor', 'bizservice', 'janitor', null);
INSERT INTO `sap_industry` VALUES ('Industry.bizservice.language', 'language', 'bizservice', 'language', null);
INSERT INTO `sap_industry` VALUES ('Industry.bizservice.marketing', 'marketing', 'bizservice', 'marketing', null);
INSERT INTO `sap_industry` VALUES ('Industry.bizservice.printing', 'printing', 'bizservice', 'printing', null);
INSERT INTO `sap_industry` VALUES ('Industry.bizservice.security', 'security', 'bizservice', 'security', null);
INSERT INTO `sap_industry` VALUES ('Industry.chamber', 'chamber', 'chamber', null, null);
INSERT INTO `sap_industry` VALUES ('Industry.construction', 'construction', 'construction', null, null);
INSERT INTO `sap_industry` VALUES ('Industry.construction.architecture', 'architecture', 'construction', 'architecture', null);
INSERT INTO `sap_industry` VALUES ('Industry.construction.construction', 'construction', 'construction', 'construction', null);
INSERT INTO `sap_industry` VALUES ('Industry.consumerservices', null, 'consumerservices', null, null);
INSERT INTO `sap_industry` VALUES ('Industry.consumerservices.auto', 'auto', 'consumerservices', 'auto', null);
INSERT INTO `sap_industry` VALUES ('Industry.consumerservices.carrental', 'carrental', 'consumerservices', 'carrental', null);
INSERT INTO `sap_industry` VALUES ('Industry.consumerservices.funeralhome', 'funeralhome', 'consumerservices', 'funeralhome', null);
INSERT INTO `sap_industry` VALUES ('Industry.consumerservices.hairsalon', 'hairsalon', 'consumerservices', 'hairsalon', null);
INSERT INTO `sap_industry` VALUES ('Industry.consumerservices.laundry', 'laundry', 'consumerservices', 'laundry', null);
INSERT INTO `sap_industry` VALUES ('Industry.consumerservices.photo', 'photo', 'consumerservices', 'photo', null);
INSERT INTO `sap_industry` VALUES ('Industry.consumerservices.travel', 'travel', 'consumerservices', 'travel', null);
INSERT INTO `sap_industry` VALUES ('Industry.consumerservices.veterinary', 'veterinary', 'consumerservices', 'veterinary', null);
INSERT INTO `sap_industry` VALUES ('Industry.consumerservices.weight', 'weight', 'consumerservices', 'weight', null);
INSERT INTO `sap_industry` VALUES ('Industry.cultural', 'cultural', 'cultural', null, null);
INSERT INTO `sap_industry` VALUES ('Industry.cultural.museum', 'museum', 'cultural', 'museum', null);
INSERT INTO `sap_industry` VALUES ('Industry.education.k12', 'k12', 'education', 'k12', null);
INSERT INTO `sap_industry` VALUES ('Industry.education.training', 'training', 'education', 'training', null);
INSERT INTO `sap_industry` VALUES ('Industry.education.university', 'university', 'education', 'university', null);
INSERT INTO `sap_industry` VALUES ('Industry.energy', 'energy', 'energy', null, null);
INSERT INTO `sap_industry` VALUES ('Industry.energy.energy', 'energy', 'energy', 'energy', null);
INSERT INTO `sap_industry` VALUES ('Industry.energy.environment', 'environment', 'energy', 'environment', null);
INSERT INTO `sap_industry` VALUES ('Industry.energy.services', 'services', 'energy', 'services', null);
INSERT INTO `sap_industry` VALUES ('Industry.energy.water', 'water', 'energy', 'water', null);
INSERT INTO `sap_industry` VALUES ('Industry.finance', 'finance', 'finance', null, null);
INSERT INTO `sap_industry` VALUES ('Industry.finance.banking', 'banking', 'finance', 'banking', null);
INSERT INTO `sap_industry` VALUES ('Industry.finance.brokerage', 'brokerage', 'finance', 'brokerage', null);
INSERT INTO `sap_industry` VALUES ('Industry.finance.creditcards', 'creditcards', 'finance', 'creditcards', null);
INSERT INTO `sap_industry` VALUES ('Industry.finance.investment', 'investment', 'finance', 'investment', null);
INSERT INTO `sap_industry` VALUES ('Industry.finance.venturecapital', 'venturecapital', 'finance', 'venturecapital', null);
INSERT INTO `sap_industry` VALUES ('Industry.government', 'government', 'government', null, null);
INSERT INTO `sap_industry` VALUES ('Industry.healthcare', 'healthcare', 'healthcare', null, null);
INSERT INTO `sap_industry` VALUES ('Industry.healthcare.healthcare', 'healthcare', 'healthcare', 'healthcare', null);
INSERT INTO `sap_industry` VALUES ('Industry.healthcare.medicaltesting', 'medicaltesting', 'healthcare', 'medicaltesting', null);
INSERT INTO `sap_industry` VALUES ('Industry.healthcare.pharmaceuticals', 'pharmaceuticals', 'healthcare', 'pharmaceuticals', null);
INSERT INTO `sap_industry` VALUES ('Industry.healthcare.pharmaceuticals.biotech', 'biotech', 'healthcare', 'pharmaceuticals', 'biotech');
INSERT INTO `sap_industry` VALUES ('Industry.healthcare.pharmaceuticals.drugs', 'drugs', 'healthcare', 'pharmaceuticals', 'drugs');
INSERT INTO `sap_industry` VALUES ('Industry.hospitality', 'hospitality', 'hospitality', null, null);
INSERT INTO `sap_industry` VALUES ('Industry.hospitality.lodging', 'lodging', 'hospitality', 'lodging', null);
INSERT INTO `sap_industry` VALUES ('Industry.hospitality.recreation', 'recreation', 'hospitality', 'recreation', null);
INSERT INTO `sap_industry` VALUES ('Industry.hospitality.recreation.cinema', 'cinema', 'hospitality', 'recreation', 'cinema');
INSERT INTO `sap_industry` VALUES ('Industry.hospitality.recreation.fitness', 'fitness', 'hospitality', 'recreation', 'fitness');
INSERT INTO `sap_industry` VALUES ('Industry.hospitality.recreation.gaming', 'gaming', 'hospitality', 'recreation', 'gaming');
INSERT INTO `sap_industry` VALUES ('Industry.hospitality.recreation.park', 'park', 'hospitality', 'recreation', 'park');
INSERT INTO `sap_industry` VALUES ('Industry.hospitality.recreation.zoo', 'zoo', 'hospitality', 'recreation', 'zoo');
INSERT INTO `sap_industry` VALUES ('Industry.hospitality.restaurant', 'restaurant', 'hospitality', 'restaurant', null);
INSERT INTO `sap_industry` VALUES ('Industry.hospitality.sports', 'sports', 'hospitality', 'sports', null);
INSERT INTO `sap_industry` VALUES ('Industry.insurance', 'insurance', 'insurance', null, null);
INSERT INTO `sap_industry` VALUES ('Industry.legal', 'legal', 'legal', null, null);
INSERT INTO `sap_industry` VALUES ('Industry.media.broadcasting', 'broadcasting', 'media', 'broadcasting', null);
INSERT INTO `sap_industry` VALUES ('Industry.media.broadcasting.film', 'film', 'media', 'broadcasting', 'film');
INSERT INTO `sap_industry` VALUES ('Industry.media.broadcasting.radio', 'radio', 'media', 'broadcasting', 'radio');
INSERT INTO `sap_industry` VALUES ('Industry.media.broadcasting.tv', 'tv', 'media', 'broadcasting', 'tv');
INSERT INTO `sap_industry` VALUES ('Industry.media.information', 'information', 'media', 'information', null);
INSERT INTO `sap_industry` VALUES ('Industry.media.internet', 'internet', 'media', 'internet', null);
INSERT INTO `sap_industry` VALUES ('Industry.media.music', 'music', 'media', 'music', null);
INSERT INTO `sap_industry` VALUES ('Industry.media.news', 'news', 'media', 'news', null);
INSERT INTO `sap_industry` VALUES ('Industry.media.publishing', 'publishing', 'media', 'publishing', null);
INSERT INTO `sap_industry` VALUES ('Industry.mfg', 'mfg', 'mfg', null, null);
INSERT INTO `sap_industry` VALUES ('Industry.mfg.aerospace', 'aerospace', 'mfg', 'aerospace', null);
INSERT INTO `sap_industry` VALUES ('Industry.mfg.boat', 'boat', 'mfg', 'boat', null);
INSERT INTO `sap_industry` VALUES ('Industry.mfg.building', 'building', 'mfg', 'building', null);
INSERT INTO `sap_industry` VALUES ('Industry.mfg.building.concrete', 'concrete', 'mfg', 'building', 'concrete');
INSERT INTO `sap_industry` VALUES ('Industry.mfg.building.lumber', 'lumber', 'mfg', 'building', 'lumber');
INSERT INTO `sap_industry` VALUES ('Industry.mfg.building.other', 'other', 'mfg', 'building', 'other');
INSERT INTO `sap_industry` VALUES ('Industry.mfg.building.plumbing', 'plumbing', 'mfg', 'building', 'plumbing');
INSERT INTO `sap_industry` VALUES ('Industry.mfg.car', 'car', 'mfg', 'car', null);
INSERT INTO `sap_industry` VALUES ('Industry.mfg.chemicals', 'chemicals', 'mfg', 'chemicals', null);
INSERT INTO `sap_industry` VALUES ('Industry.mfg.chemicals.chemicals', 'chemicals', 'mfg', 'chemicals', 'chemicals');
INSERT INTO `sap_industry` VALUES ('Industry.mfg.chemicals.gas', 'gas', 'mfg', 'chemicals', 'gas');
INSERT INTO `sap_industry` VALUES ('Industry.mfg.chemicals.glass', 'glass', 'mfg', 'chemicals', 'glass');
INSERT INTO `sap_industry` VALUES ('Industry.mfg.chemicals.petrochemicals', 'petrochemicals', 'mfg', 'chemicals', 'petrochemicals');
INSERT INTO `sap_industry` VALUES ('Industry.mfg.computers', 'computers', 'mfg', 'computers', null);
INSERT INTO `sap_industry` VALUES ('Industry.mfg.computers.computers', 'computers', 'mfg', 'computers', 'computers');
INSERT INTO `sap_industry` VALUES ('Industry.mfg.computers.networking', 'networking', 'mfg', 'computers', 'networking');
INSERT INTO `sap_industry` VALUES ('Industry.mfg.computers.security', 'security', 'mfg', 'computers', 'security');
INSERT INTO `sap_industry` VALUES ('Industry.mfg.computers.storage', 'storage', 'mfg', 'computers', 'storage');
INSERT INTO `sap_industry` VALUES ('Industry.mfg.consumer', 'consumer', 'mfg', 'consumer', null);
INSERT INTO `sap_industry` VALUES ('Industry.mfg.consumer.appliances', 'appliances', 'mfg', 'consumer', 'appliances');
INSERT INTO `sap_industry` VALUES ('Industry.mfg.consumer.cleaning', 'cleaning', 'mfg', 'consumer', 'cleaning');
INSERT INTO `sap_industry` VALUES ('Industry.mfg.consumer.clothes', 'clothes', 'mfg', 'consumer', 'clothes');
INSERT INTO `sap_industry` VALUES ('Industry.mfg.consumer.electronics', 'electronics', 'mfg', 'consumer', 'electronics');
INSERT INTO `sap_industry` VALUES ('Industry.mfg.consumer.health', 'health', 'mfg', 'consumer', 'health');
INSERT INTO `sap_industry` VALUES ('Industry.mfg.consumer.household', 'household', 'mfg', 'consumer', 'household');
INSERT INTO `sap_industry` VALUES ('Industry.mfg.consumer.petproducts', 'petproducts', 'mfg', 'consumer', 'petproducts');
INSERT INTO `sap_industry` VALUES ('Industry.mfg.consumer.photo', 'photo', 'mfg', 'consumer', 'photo');
INSERT INTO `sap_industry` VALUES ('Industry.mfg.consumer.sport', 'sport', 'mfg', 'consumer', 'sport');
INSERT INTO `sap_industry` VALUES ('Industry.mfg.consumer.watch', 'watch', 'mfg', 'consumer', 'watch');
INSERT INTO `sap_industry` VALUES ('Industry.mfg.electronics', 'electronics', 'mfg', 'electronics', null);
INSERT INTO `sap_industry` VALUES ('Industry.mfg.electronics.batteries', 'batteries', 'mfg', 'electronics', 'batteries');
INSERT INTO `sap_industry` VALUES ('Industry.mfg.electronics.electronics', 'electronics', 'mfg', 'electronics', 'electronics');
INSERT INTO `sap_industry` VALUES ('Industry.mfg.electronics.powerequip', 'powerequip', 'mfg', 'electronics', 'powerequip');
INSERT INTO `sap_industry` VALUES ('Industry.mfg.electronics.semiconductors', 'semiconductors', 'mfg', 'electronics', 'semiconductors');
INSERT INTO `sap_industry` VALUES ('Industry.mfg.food', 'food', 'mfg', 'food', null);
INSERT INTO `sap_industry` VALUES ('Industry.mfg.food.food', 'food', 'mfg', 'food', 'food');
INSERT INTO `sap_industry` VALUES ('Industry.mfg.food.tobacco', 'tobacco', 'mfg', 'food', 'tobacco');
INSERT INTO `sap_industry` VALUES ('Industry.mfg.food.winery', 'winery', 'mfg', 'food', 'winery');
INSERT INTO `sap_industry` VALUES ('Industry.mfg.furniture', 'furniture', 'mfg', 'furniture', null);
INSERT INTO `sap_industry` VALUES ('Industry.mfg.industrialmachinery', 'industrialmachinery', 'mfg', 'industrialmachinery', null);
INSERT INTO `sap_industry` VALUES ('Industry.mfg.medical', 'medical', 'mfg', 'medical', null);
INSERT INTO `sap_industry` VALUES ('Industry.mfg.paper', 'paper', 'mfg', 'paper', null);
INSERT INTO `sap_industry` VALUES ('Industry.mfg.plastic', 'plastic', 'mfg', 'plastic', null);
INSERT INTO `sap_industry` VALUES ('Industry.mfg.rubber', 'rubber', 'mfg', 'rubber', null);
INSERT INTO `sap_industry` VALUES ('Industry.mfg.telecom', 'telecom', 'mfg', 'telecom', null);
INSERT INTO `sap_industry` VALUES ('Industry.mfg.testequipment', 'testequipment', 'mfg', 'testequipment', null);
INSERT INTO `sap_industry` VALUES ('Industry.mfg.toys', 'toys', 'mfg', 'toys', null);
INSERT INTO `sap_industry` VALUES ('Industry.mfg.wire', 'wire', 'mfg', 'wire', null);
INSERT INTO `sap_industry` VALUES ('Industry.mm.metals', 'metals', 'mm', 'metals', null);
INSERT INTO `sap_industry` VALUES ('Industry.mm.mining', 'mining', 'mm', 'mining', null);
INSERT INTO `sap_industry` VALUES ('Industry.municipal', 'municipal', 'municipal', null, null);
INSERT INTO `sap_industry` VALUES ('Industry.municipal.publicsafety', 'publicsafety', 'municipal', 'publicsafety', null);
INSERT INTO `sap_industry` VALUES ('Industry.orgs.association', 'association', 'orgs', 'association', null);
INSERT INTO `sap_industry` VALUES ('Industry.orgs.foundation', 'foundation', 'orgs', 'foundation', null);
INSERT INTO `sap_industry` VALUES ('Industry.orgs.religion', 'religion', 'orgs', 'religion', null);
INSERT INTO `sap_industry` VALUES ('Industry.realestate', 'realestate', 'realestate', null, null);
INSERT INTO `sap_industry` VALUES ('Industry.retail', 'retail', 'retail', null, null);
INSERT INTO `sap_industry` VALUES ('Industry.retail.auto', 'auto', 'retail', 'auto', null);
INSERT INTO `sap_industry` VALUES ('Industry.retail.autoparts', 'autoparts', 'retail', 'autoparts', null);
INSERT INTO `sap_industry` VALUES ('Industry.retail.book', 'book', 'retail', 'book', null);
INSERT INTO `sap_industry` VALUES ('Industry.retail.clothes', 'clothes', 'retail', 'clothes', null);
INSERT INTO `sap_industry` VALUES ('Industry.retail.conveniencestore', 'conveniencestore', 'retail', 'conveniencestore', null);
INSERT INTO `sap_industry` VALUES ('Industry.retail.departmentstore', 'departmentstore', 'retail', 'departmentstore', null);
INSERT INTO `sap_industry` VALUES ('Industry.retail.gifts', 'gifts', 'retail', 'gifts', null);
INSERT INTO `sap_industry` VALUES ('Industry.retail.grocery', 'grocery', 'retail', 'grocery', null);
INSERT INTO `sap_industry` VALUES ('Industry.retail.hardware', 'hardware', 'retail', 'hardware', null);
INSERT INTO `sap_industry` VALUES ('Industry.retail.health', 'health', 'retail', 'health', null);
INSERT INTO `sap_industry` VALUES ('Industry.retail.jewelry', 'jewelry', 'retail', 'jewelry', null);
INSERT INTO `sap_industry` VALUES ('Industry.retail.office', 'office', 'retail', 'office', null);
INSERT INTO `sap_industry` VALUES ('Industry.retail.pharmacy', 'pharmacy', 'retail', 'pharmacy', null);
INSERT INTO `sap_industry` VALUES ('Industry.retail.rental', 'rental', 'retail', 'rental', null);
INSERT INTO `sap_industry` VALUES ('Industry.retail.sports', 'sports', 'retail', 'sports', null);
INSERT INTO `sap_industry` VALUES ('Industry.retail.videorental', 'videorental', 'retail', 'videorental', null);
INSERT INTO `sap_industry` VALUES ('Industry.software.consulting', 'consulting', 'software', 'consulting', null);
INSERT INTO `sap_industry` VALUES ('Industry.software.mfg', 'mfg', 'software', 'mfg', null);
INSERT INTO `sap_industry` VALUES ('Industry.software.mfg.eng', 'eng', 'software', 'mfg', 'eng');
INSERT INTO `sap_industry` VALUES ('Industry.software.mfg.erp', 'erp', 'software', 'mfg', 'erp');
INSERT INTO `sap_industry` VALUES ('Industry.software.mfg.finance', 'finance', 'software', 'mfg', 'finance');
INSERT INTO `sap_industry` VALUES ('Industry.software.mfg.health', 'health', 'software', 'mfg', 'health');
INSERT INTO `sap_industry` VALUES ('Industry.software.mfg.network', 'network', 'software', 'mfg', 'network');
INSERT INTO `sap_industry` VALUES ('Industry.software.mfg.security', 'security', 'software', 'mfg', 'security');
INSERT INTO `sap_industry` VALUES ('Industry.telecom.cable', 'cable', 'telecom', 'cable', null);
INSERT INTO `sap_industry` VALUES ('Industry.telecom.internet', 'internet', 'telecom', 'internet', null);
INSERT INTO `sap_industry` VALUES ('Industry.telecom.telephone', 'telephone', 'telecom', 'telephone', null);
INSERT INTO `sap_industry` VALUES ('Industry.transportation', 'transportation', 'transportation', null, null);
INSERT INTO `sap_industry` VALUES ('Industry.transportation.airline', 'airline', 'transportation', 'airline', null);
INSERT INTO `sap_industry` VALUES ('Industry.transportation.freight', 'freight', 'transportation', 'freight', null);
INSERT INTO `sap_industry` VALUES ('Industry.transportation.marine', 'marine', 'transportation', 'marine', null);
INSERT INTO `sap_industry` VALUES ('Industry.transportation.moving', 'moving', 'transportation', 'moving', null);
INSERT INTO `sap_industry` VALUES ('Industry.transportation.railandbus', 'railandbus', 'transportation', 'railandbus', null);

-- ----------------------------
-- Table structure for sap_list_request
-- ----------------------------
DROP TABLE IF EXISTS `sap_list_request`;
CREATE TABLE `sap_list_request` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(15) NOT NULL,
  `status` varchar(15) DEFAULT 'new',
  `error` text,
  `sort_order` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text,
  `data` text,
  `created_by` int(11) DEFAULT NULL,
  `fulfilled_by` int(11) DEFAULT NULL,
  `closed_by` int(11) DEFAULT NULL,
  `assigned_to` int(11) DEFAULT NULL,
  `outreach_account_id` int(11) NOT NULL,
  `due_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fulfilled_at` timestamp NULL DEFAULT NULL,
  `closed_at` timestamp NULL DEFAULT NULL,
  `download_filtered_id` int(11) DEFAULT NULL,
  `saved_to_db` int(11) DEFAULT NULL,
  `saved_to_db_count` int(11) DEFAULT NULL,
  `saved_to_db_ids` text,
  `uploaded_to_outreach` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `status` (`status`),
  KEY `created_by` (`created_by`),
  KEY `fulfilled_by` (`fulfilled_by`),
  KEY `closed_by` (`closed_by`),
  KEY `assigned_to` (`assigned_to`),
  KEY `outreach_account_id` (`outreach_account_id`),
  CONSTRAINT `sap_list_request_ibfk_1` FOREIGN KEY (`fulfilled_by`) REFERENCES `sap_user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `sap_list_request_ibfk_2` FOREIGN KEY (`closed_by`) REFERENCES `sap_user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `sap_list_request_ibfk_3` FOREIGN KEY (`assigned_to`) REFERENCES `sap_user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `sap_list_request_ibfk_4` FOREIGN KEY (`outreach_account_id`) REFERENCES `sap_client_account_outreach` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `sap_list_request_ibfk_5` FOREIGN KEY (`created_by`) REFERENCES `sap_user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sap_list_request
-- ----------------------------

-- ----------------------------
-- Table structure for sap_list_request_comment
-- ----------------------------
DROP TABLE IF EXISTS `sap_list_request_comment`;
CREATE TABLE `sap_list_request_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `list_request_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`),
  KEY `list_request_id` (`list_request_id`) USING BTREE,
  CONSTRAINT `sap_list_request_comment_ibfk_1` FOREIGN KEY (`list_request_id`) REFERENCES `sap_list_request` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `sap_list_request_comment_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `sap_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sap_list_request_comment
-- ----------------------------

-- ----------------------------
-- Table structure for sap_list_request_prospect
-- ----------------------------
DROP TABLE IF EXISTS `sap_list_request_prospect`;
CREATE TABLE `sap_list_request_prospect` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `list_request_id` int(11) NOT NULL,
  `prospect_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `list_request_id` (`list_request_id`),
  KEY `prospect_id` (`prospect_id`),
  CONSTRAINT `sap_list_request_prospect_ibfk_1` FOREIGN KEY (`list_request_id`) REFERENCES `sap_list_request` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `sap_list_request_prospect_ibfk_2` FOREIGN KEY (`prospect_id`) REFERENCES `sap_prospect` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sap_list_request_prospect
-- ----------------------------

-- ----------------------------
-- Table structure for sap_outreach_prospect
-- ----------------------------
DROP TABLE IF EXISTS `sap_outreach_prospect`;
CREATE TABLE `sap_outreach_prospect` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `prospect_id` int(11) NOT NULL,
  `outreach_account_id` int(11) NOT NULL,
  `outreach_id` int(11) NOT NULL,
  `outreach_created_at` datetime DEFAULT NULL,
  `outreach_optedout_at` datetime DEFAULT NULL,
  `outreach_updated_at` datetime DEFAULT NULL,
  `mailings_sync_status` varchar(20) NOT NULL DEFAULT 'ready',
  `mailings_synced_until` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_outreach_account_prospect` (`outreach_account_id`,`prospect_id`),
  KEY `prospect_id` (`prospect_id`),
  KEY `outreach_account_id` (`outreach_account_id`),
  KEY `outreach_id` (`outreach_id`),
  KEY `mailings_sync_status` (`mailings_sync_status`),
  CONSTRAINT `foreign_outreach_account_id` FOREIGN KEY (`outreach_account_id`) REFERENCES `sap_client_account_outreach` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `foreign_prospect_id` FOREIGN KEY (`prospect_id`) REFERENCES `sap_prospect` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sap_outreach_prospect
-- ----------------------------

-- ----------------------------
-- Table structure for sap_outreach_prospect_event
-- ----------------------------
DROP TABLE IF EXISTS `sap_outreach_prospect_event`;
CREATE TABLE `sap_outreach_prospect_event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `outreach_prospect_id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `event_id` int(11) NOT NULL,
  `template_id` int(11) DEFAULT NULL,
  `mailing_id` int(11) DEFAULT NULL,
  `action` varchar(80) NOT NULL,
  `metadata` text NOT NULL,
  `occurred_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_outreach_prospect_event` (`outreach_prospect_id`,`event_id`),
  KEY `outreach_prospect_id` (`outreach_prospect_id`),
  KEY `outreach_prospect_id_2` (`outreach_prospect_id`,`mailing_id`,`action`),
  KEY `action_occurred_index` (`action`,`occurred_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sap_outreach_prospect_event
-- ----------------------------

-- ----------------------------
-- Table structure for sap_outreach_prospect_mailing
-- ----------------------------
DROP TABLE IF EXISTS `sap_outreach_prospect_mailing`;
CREATE TABLE `sap_outreach_prospect_mailing` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `outreach_prospect_id` int(11) NOT NULL,
  `mailing_id` int(11) NOT NULL,
  `delivered_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `replied_at` timestamp NULL DEFAULT NULL,
  `response_time_days` float DEFAULT NULL,
  `bounced` tinyint(1) NOT NULL,
  `template_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `outreach_prospect_id` (`outreach_prospect_id`),
  CONSTRAINT `sap_outreach_prospect_mailing_ibfk_1` FOREIGN KEY (`outreach_prospect_id`) REFERENCES `sap_outreach_prospect` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sap_outreach_prospect_mailing
-- ----------------------------

-- ----------------------------
-- Table structure for sap_outreach_prospect_stage
-- ----------------------------
DROP TABLE IF EXISTS `sap_outreach_prospect_stage`;
CREATE TABLE `sap_outreach_prospect_stage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `outreach_prospect_id` int(11) NOT NULL,
  `stage_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_client_prospect_id` (`outreach_prospect_id`),
  KEY `index_stage_id` (`stage_id`),
  CONSTRAINT `outreach_prospect_id` FOREIGN KEY (`outreach_prospect_id`) REFERENCES `sap_outreach_prospect` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `stage_id` FOREIGN KEY (`stage_id`) REFERENCES `sap_prospect_stage` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sap_outreach_prospect_stage
-- ----------------------------

-- ----------------------------
-- Table structure for sap_outreach_prospect_stage_v2
-- ----------------------------
DROP TABLE IF EXISTS `sap_outreach_prospect_stage_v2`;
CREATE TABLE `sap_outreach_prospect_stage_v2` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `outreach_prospect_id` int(11) NOT NULL,
  `stage_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_client_prospect_id` (`outreach_prospect_id`),
  KEY `index_stage_id` (`stage_id`),
  CONSTRAINT `sap_outreach_prospect_stage_v2_ibfk_1` FOREIGN KEY (`outreach_prospect_id`) REFERENCES `sap_outreach_prospect` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sap_outreach_prospect_stage_v2
-- ----------------------------

-- ----------------------------
-- Table structure for sap_outreach_prospect_tag
-- ----------------------------
DROP TABLE IF EXISTS `sap_outreach_prospect_tag`;
CREATE TABLE `sap_outreach_prospect_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `outreach_prospect_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `client_prospect_id` (`outreach_prospect_id`),
  KEY `tag_id` (`tag_id`),
  CONSTRAINT `foreign_outreach_prospect_id` FOREIGN KEY (`outreach_prospect_id`) REFERENCES `sap_outreach_prospect` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `foreign_tag_id` FOREIGN KEY (`tag_id`) REFERENCES `sap_prospect_tag` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sap_outreach_prospect_tag
-- ----------------------------

-- ----------------------------
-- Table structure for sap_outreach_template
-- ----------------------------
DROP TABLE IF EXISTS `sap_outreach_template`;
CREATE TABLE `sap_outreach_template` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `outreach_account_id` int(11) NOT NULL,
  `template_id` int(11) NOT NULL,
  `synced` tinyint(1) NOT NULL DEFAULT '0',
  `body_html` longtext,
  `body_text` longtext,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `outreach_account_id` (`outreach_account_id`),
  KEY `synced` (`synced`),
  CONSTRAINT `sap_outreach_template_ibfk_1` FOREIGN KEY (`outreach_account_id`) REFERENCES `sap_client_account_outreach` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sap_outreach_template
-- ----------------------------

-- ----------------------------
-- Table structure for sap_outreach_updated_prospects
-- ----------------------------
DROP TABLE IF EXISTS `sap_outreach_updated_prospects`;
CREATE TABLE `sap_outreach_updated_prospects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `outreach_account_id` int(11) NOT NULL,
  `prospect_email` varchar(75) NOT NULL,
  `label` varchar(100) DEFAULT NULL,
  `label_value` varchar(150) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `client_id` (`client_id`,`outreach_account_id`,`prospect_email`,`label`),
  KEY `outreach_account_id` (`outreach_account_id`),
  CONSTRAINT `sap_outreach_updated_prospects_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `sap_client` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `sap_outreach_updated_prospects_ibfk_2` FOREIGN KEY (`outreach_account_id`) REFERENCES `sap_client_account_outreach` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of sap_outreach_updated_prospects
-- ----------------------------

-- ----------------------------
-- Table structure for sap_pod
-- ----------------------------
DROP TABLE IF EXISTS `sap_pod`;
CREATE TABLE `sap_pod` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(80) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sap_pod
-- ----------------------------
INSERT INTO `sap_pod` VALUES ('1', 'eduma');
INSERT INTO `sap_pod` VALUES ('3', 'edumaPOD');
INSERT INTO `sap_pod` VALUES ('2', 'Pod');

-- ----------------------------
-- Table structure for sap_prospect
-- ----------------------------
DROP TABLE IF EXISTS `sap_prospect`;
CREATE TABLE `sap_prospect` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `first_name` varchar(20) DEFAULT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(25) DEFAULT NULL,
  `suffix` varchar(255) DEFAULT NULL,
  `salutation` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `title_code` varchar(255) DEFAULT NULL,
  `title_hierarchy_level` varchar(255) DEFAULT NULL,
  `job_function` varchar(255) DEFAULT NULL,
  `management_level` varchar(255) DEFAULT NULL,
  `source_count` varchar(255) DEFAULT NULL,
  `highest_level_job_function` varchar(255) DEFAULT NULL,
  `person_pro_url` varchar(255) DEFAULT NULL,
  `encrypted_email_address` varchar(255) DEFAULT NULL,
  `email_domain` varchar(255) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `company_revenue` varchar(100) DEFAULT NULL,
  `industry_id` int(11) DEFAULT NULL,
  `company_employees` varchar(50) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `address2` varchar(100) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `state_id` int(11) DEFAULT NULL,
  `zip` varchar(15) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `lat` float DEFAULT NULL,
  `lng` float DEFAULT NULL,
  `phone_work` varchar(50) DEFAULT NULL,
  `phone_personal` varchar(50) DEFAULT NULL,
  `source_id` int(11) DEFAULT NULL,
  `opted_out` tinyint(1) NOT NULL DEFAULT '0',
  `bounced` tinyint(1) NOT NULL DEFAULT '0',
  `zoominfo_id` varchar(50) DEFAULT NULL,
  `zoominfo_company_id` varchar(50) DEFAULT NULL,
  `stage_id` int(3) DEFAULT '0',
  `group_title_id` int(11) DEFAULT NULL,
  `last_emailed_at` timestamp NULL DEFAULT NULL,
  `outreach_created_at` datetime DEFAULT NULL,
  `outreach_optedout_at` datetime DEFAULT NULL,
  `outreach_updated_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_email` (`email`),
  KEY `company_id` (`company_id`),
  KEY `industry_id` (`industry_id`),
  KEY `city_id` (`city_id`),
  KEY `state_id` (`state_id`),
  KEY `country_id` (`country_id`),
  KEY `source_id` (`source_id`),
  KEY `IDK_CRT` (`outreach_created_at`),
  KEY `IDK_UPD` (`outreach_updated_at`),
  KEY `zoominfo_id` (`zoominfo_id`),
  KEY `zoominfo_company_id` (`zoominfo_company_id`),
  KEY `group_title_id` (`group_title_id`),
  CONSTRAINT `prospect_city_id` FOREIGN KEY (`city_id`) REFERENCES `sap_prospect_city` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `prospect_company_id` FOREIGN KEY (`company_id`) REFERENCES `sap_prospect_company` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `prospect_country_id` FOREIGN KEY (`country_id`) REFERENCES `sap_prospect_country` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `prospect_group_title_id` FOREIGN KEY (`group_title_id`) REFERENCES `sap_group_title` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `prospect_industry_id` FOREIGN KEY (`industry_id`) REFERENCES `sap_prospect_industry` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `prospect_source_id` FOREIGN KEY (`source_id`) REFERENCES `sap_prospect_source` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `prospect_state_id` FOREIGN KEY (`state_id`) REFERENCES `sap_prospect_state` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sap_prospect
-- ----------------------------

-- ----------------------------
-- Table structure for sap_prospect_city
-- ----------------------------
DROP TABLE IF EXISTS `sap_prospect_city`;
CREATE TABLE `sap_prospect_city` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sap_prospect_city
-- ----------------------------

-- ----------------------------
-- Table structure for sap_prospect_company
-- ----------------------------
DROP TABLE IF EXISTS `sap_prospect_company`;
CREATE TABLE `sap_prospect_company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `division_name` varchar(255) DEFAULT NULL,
  `sic1` varchar(255) DEFAULT NULL,
  `sic2` varchar(255) DEFAULT NULL,
  `naics1` varchar(255) DEFAULT NULL,
  `naics2` varchar(255) DEFAULT NULL,
  `domain_name` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `street_address` varchar(255) DEFAULT NULL,
  `city_id` varchar(255) DEFAULT NULL,
  `state_id` varchar(255) DEFAULT NULL,
  `zip` varchar(255) DEFAULT NULL,
  `country_id` varchar(255) DEFAULT NULL,
  `revenue` varchar(255) DEFAULT NULL,
  `revenue_range` varchar(255) DEFAULT NULL,
  `employees` varchar(255) DEFAULT NULL,
  `employees_range` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_name` (`name`),
  KEY `revenue_range` (`revenue_range`),
  KEY `employees_range` (`employees_range`),
  CONSTRAINT `sap_prospect_company_ibfk_1` FOREIGN KEY (`revenue_range`) REFERENCES `sap_revenue_range` (`revenue_range`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `sap_prospect_company_ibfk_2` FOREIGN KEY (`employees_range`) REFERENCES `sap_employee_range` (`employees_range`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sap_prospect_company
-- ----------------------------

-- ----------------------------
-- Table structure for sap_prospect_country
-- ----------------------------
DROP TABLE IF EXISTS `sap_prospect_country`;
CREATE TABLE `sap_prospect_country` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sap_prospect_country
-- ----------------------------

-- ----------------------------
-- Table structure for sap_prospect_industry
-- ----------------------------
DROP TABLE IF EXISTS `sap_prospect_industry`;
CREATE TABLE `sap_prospect_industry` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `hierarchical_category` varchar(255) DEFAULT NULL,
  `second_industry_label` varchar(255) DEFAULT NULL,
  `second_industry_hierarchical_category` varchar(255) DEFAULT NULL,
  `condensed_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_name` (`name`),
  KEY `hierarchical_category` (`hierarchical_category`),
  KEY `condensed_id` (`condensed_id`),
  CONSTRAINT `sap_prospect_industry_condensed_id` FOREIGN KEY (`condensed_id`) REFERENCES `sap_prospect_industry_condensed` (`id`),
  CONSTRAINT `sap_prospect_industry_ibfk_1` FOREIGN KEY (`hierarchical_category`) REFERENCES `sap_industry` (`hierarchical_category`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sap_prospect_industry
-- ----------------------------
INSERT INTO `sap_prospect_industry` VALUES ('1', 'Religious Institution', null, null, null, '100');

-- ----------------------------
-- Table structure for sap_prospect_industry_condensed
-- ----------------------------
DROP TABLE IF EXISTS `sap_prospect_industry_condensed`;
CREATE TABLE `sap_prospect_industry_condensed` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sap_prospect_industry_condensed
-- ----------------------------
INSERT INTO `sap_prospect_industry_condensed` VALUES ('1', 'Accounting');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('2', 'Airlines/Aviation');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('3', 'Alternative Medicine');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('4', 'Architecture & Planning');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('5', 'Automotive');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('6', 'Aviation & Aerospace');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('7', 'Banking');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('8', 'Biotechnology');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('9', 'Broadcast Media');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('10', 'Building Materials');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('11', 'Business Supplies and Equipment');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('12', 'Chemicals');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('13', 'Civil Engineering');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('14', 'Electronics');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('15', 'Computer & Network Security');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('16', 'Computer Hardware');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('17', 'Computer Networking');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('18', 'Computer Software');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('19', 'Construction');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('20', 'Consumer Electronics');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('21', 'Consumer Goods');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('22', 'Consumer Services');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('23', 'Cosmetics');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('24', 'Electrical/Electronic Manufacturing');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('25', 'Environmental Services');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('26', 'Facilities Services');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('27', 'Farming');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('28', 'Financial Services');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('29', 'Food & Beverages');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('30', 'Furniture');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('31', 'Gambling & Casinos');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('32', 'Glass, Ceramics & Concrete');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('33', 'Government Relations');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('34', 'Graphic Design');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('35', 'Health, Wellness and Fitness');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('36', 'Higher Education');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('37', 'Hospital & Health Care');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('38', 'Hospitality');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('39', 'Human Resources');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('40', 'Individual & Family Services');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('41', 'Information Technology and Services');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('42', 'Insurance');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('43', 'Internet');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('44', 'Investment Banking');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('45', 'Investment Management');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('46', 'Law Practice');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('47', 'Leisure, Travel & Tourism');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('48', 'Libraries');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('49', 'Logistics and Supply Chain');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('50', 'Luxury Goods & Jewelry');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('51', 'Machinery');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('52', 'Management Consulting');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('53', 'Maritime');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('54', 'Market Research');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('55', 'Marketing and Advertising');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('56', 'Mechanical or Industrial Engineering');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('57', 'Media Production');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('58', 'Medical Devices');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('59', 'Mining & Metals');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('60', 'Motion Pictures and Film');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('61', 'Museums and Institutions');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('62', 'Music');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('63', 'Newspapers');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('64', 'Non-Profit Organization Management');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('65', 'Oil & Energy');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('66', 'Online Media');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('67', 'Package/Freight Delivery');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('68', 'Paper & Forest Products');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('69', 'Pharmaceuticals');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('70', 'Photography');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('71', 'Plastics');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('72', 'Primary/Secondary Education');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('73', 'Printing');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('74', 'Professional Training & Coaching');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('75', 'Public Safety');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('76', 'Publishing');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('77', 'Real Estate');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('78', 'Recreational Facilities and Services');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('79', 'Religious Institutions');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('80', 'Renewables & Environment');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('81', 'Research');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('82', 'Restaurants');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('83', 'Retail');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('84', 'Semiconductors');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('85', 'Sporting Goods');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('86', 'Sports');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('87', 'Staffing & Recruiting');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('88', 'Staffing and Recruiting');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('89', 'Supermarkets');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('90', 'Telecommunications');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('91', 'Textiles');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('92', 'Tobacco');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('93', 'Translation and Localization');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('94', 'Transportation/Trucking/Railroad');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('95', 'Utilities');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('96', 'Venture Capital & Private Equity');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('97', 'Veterinary');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('98', 'Wholesale');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('99', 'Wine and Spirits');
INSERT INTO `sap_prospect_industry_condensed` VALUES ('100', 'Religious Institution');

-- ----------------------------
-- Table structure for sap_prospect_source
-- ----------------------------
DROP TABLE IF EXISTS `sap_prospect_source`;
CREATE TABLE `sap_prospect_source` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_name` (`name`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sap_prospect_source
-- ----------------------------

-- ----------------------------
-- Table structure for sap_prospect_stage
-- ----------------------------
DROP TABLE IF EXISTS `sap_prospect_stage`;
CREATE TABLE `sap_prospect_stage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sap_prospect_stage
-- ----------------------------

-- ----------------------------
-- Table structure for sap_prospect_stage_v2
-- ----------------------------
DROP TABLE IF EXISTS `sap_prospect_stage_v2`;
CREATE TABLE `sap_prospect_stage_v2` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sap_prospect_stage_v2
-- ----------------------------

-- ----------------------------
-- Table structure for sap_prospect_state
-- ----------------------------
DROP TABLE IF EXISTS `sap_prospect_state`;
CREATE TABLE `sap_prospect_state` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(2) NOT NULL,
  `label` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sap_prospect_state
-- ----------------------------

-- ----------------------------
-- Table structure for sap_prospect_tag
-- ----------------------------
DROP TABLE IF EXISTS `sap_prospect_tag`;
CREATE TABLE `sap_prospect_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sap_prospect_tag
-- ----------------------------

-- ----------------------------
-- Table structure for sap_revenue_range
-- ----------------------------
DROP TABLE IF EXISTS `sap_revenue_range`;
CREATE TABLE `sap_revenue_range` (
  `revenue_range` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `index` int(11) NOT NULL,
  `display_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  UNIQUE KEY `revenue_range` (`revenue_range`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of sap_revenue_range
-- ----------------------------
INSERT INTO `sap_revenue_range` VALUES ('Sales.under500K', '1', '<$500K');
INSERT INTO `sap_revenue_range` VALUES ('Sales.500Kto1M', '2', '$500K-$1M');
INSERT INTO `sap_revenue_range` VALUES ('Sales.1Mto5M', '3', '$1M-$5M');
INSERT INTO `sap_revenue_range` VALUES ('Sales.5Mto10M', '4', '$5M-$10M');
INSERT INTO `sap_revenue_range` VALUES ('Sales.10Mto25M', '5', '$10M-$25M');
INSERT INTO `sap_revenue_range` VALUES ('Sales.25Mto50M', '6', '$25M-$50M');
INSERT INTO `sap_revenue_range` VALUES ('Sales.50Mto100M', '7', '$50M-$100M');
INSERT INTO `sap_revenue_range` VALUES ('Sales.100MMto250M', '8', '$100M-$250M');
INSERT INTO `sap_revenue_range` VALUES ('Sales.250Mto500M', '9', '$250M-$500M');
INSERT INTO `sap_revenue_range` VALUES ('Sales.500Mto1G', '10', '$500M-$1B');
INSERT INTO `sap_revenue_range` VALUES ('Sales.1Gto5G', '11', '$1B-$5B');
INSERT INTO `sap_revenue_range` VALUES ('Sales.5GPlus', '12', '$5B+');

-- ----------------------------
-- Table structure for sap_role
-- ----------------------------
DROP TABLE IF EXISTS `sap_role`;
CREATE TABLE `sap_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `permissions` mediumtext NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sap_role
-- ----------------------------
INSERT INTO `sap_role` VALUES ('1', 'Super Admin', '[\"super-admin\"]');
INSERT INTO `sap_role` VALUES ('2', 'Admin', '[\"manage-users\",\"manage-clients\",\"view-gmail-accounts\",\"search-prospects\",\"fulfill-list-requests\",\"normalize-csv-files\",\"normalize-costar-files\"]');
INSERT INTO `sap_role` VALUES ('3', 'Tester', '[\"manage-users\",\"manage-clients\",\"search-prospects\"]');

-- ----------------------------
-- Table structure for sap_settings
-- ----------------------------
DROP TABLE IF EXISTS `sap_settings`;
CREATE TABLE `sap_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `settings` mediumtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sap_settings
-- ----------------------------
INSERT INTO `sap_settings` VALUES ('1', '{\"email-notifications\":\"user@host.com\",\"max-requests-per-day\":\"10\",\"list-certified-api-key\":\"76a9d38c-7a0c-4cab-8fea-c7825b8c03a1\",\"slack-api-key\":\"xoxp-6569438293-197668088033-199887878496-1609e054b76a1480aa10b2838e6056ea\",\"sendgrid-api-key\":\"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\",\"google-maps-api-key\":\"AIzaSyCtjAsX5y6Gobiq0YMZ3gnKbn9ygBjW4ZA\",\"mapquest-api-key\":\"AYIZAGQWFhCTI2UyxQ2XdFAmpc6JYeQ9\",\"geo-encoding\":\"1\",\"disconnect-notifications\":\"1\",\"exception-notifications\":1}');
INSERT INTO `sap_settings` VALUES ('2', '{\"amazon-ml-data-source-key\":\"0721330001500557947.csv\",\"amazon-ml-data-source-id\":\"0721330001500557947.csv\",\"amazon-ml-model-id\":\"ml0721330001500557947.csv\",\"amazon-ml-predict-endpoint\":\"https://realtime.machinelearning.us-east-1.amazonaws.com\",\"ai-last-trained\":1500540291}');

-- ----------------------------
-- Table structure for sap_suppression
-- ----------------------------
DROP TABLE IF EXISTS `sap_suppression`;
CREATE TABLE `sap_suppression` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `client_segment` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of sap_suppression
-- ----------------------------

-- ----------------------------
-- Table structure for sap_suppression_domain
-- ----------------------------
DROP TABLE IF EXISTS `sap_suppression_domain`;
CREATE TABLE `sap_suppression_domain` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `suppression_id` int(11) NOT NULL,
  `domain` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `suppression_id` (`suppression_id`),
  KEY `suppression_id_domain` (`domain`,`suppression_id`),
  CONSTRAINT `suppression_id` FOREIGN KEY (`suppression_id`) REFERENCES `sap_suppression` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of sap_suppression_domain
-- ----------------------------

-- ----------------------------
-- Table structure for sap_survey
-- ----------------------------
DROP TABLE IF EXISTS `sap_survey`;
CREATE TABLE `sap_survey` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` varchar(50) NOT NULL,
  `prospect_name` varchar(100) DEFAULT NULL,
  `prospect_attended` tinyint(1) NOT NULL,
  `feedback` varchar(40) NOT NULL,
  `feedback_other` text,
  `comments` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `feedback` (`feedback`),
  KEY `event_id` (`event_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sap_survey
-- ----------------------------

-- ----------------------------
-- Table structure for sap_targeting_request_comment
-- ----------------------------
DROP TABLE IF EXISTS `sap_targeting_request_comment`;
CREATE TABLE `sap_targeting_request_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `list_request_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`),
  KEY `list_request_id` (`list_request_id`) USING BTREE,
  CONSTRAINT `sap_targeting_request_comment_ibfk_1` FOREIGN KEY (`list_request_id`) REFERENCES `sap_list_request` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sap_targeting_request_comment
-- ----------------------------

-- ----------------------------
-- Table structure for sap_user
-- ----------------------------
DROP TABLE IF EXISTS `sap_user`;
CREATE TABLE `sap_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `salt` varchar(32) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `pod_id` int(11) DEFAULT NULL,
  `role_id` int(11) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'active',
  `permissions` mediumtext NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_login_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `role_id` (`role_id`),
  KEY `pod_id` (`pod_id`),
  CONSTRAINT `role_id` FOREIGN KEY (`role_id`) REFERENCES `sap_role` (`id`),
  CONSTRAINT `sap_user_ibfk_1` FOREIGN KEY (`pod_id`) REFERENCES `sap_pod` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sap_user
-- ----------------------------
INSERT INTO `sap_user` VALUES ('1', 'admin@sappersuite.com', 'ee7eb73958731cd6c77b1153e5889edc', 'c0b4a884fd30a5db69ebea7ed0532790', 'Mister', 'Admin', null, '2', 'active', '[\"manage-users\",\"manage-clients\",\"view-gmail-accounts\",\"search-prospects\",\"fulfill-list-requests\",\"normalize-csv-files\",\"normalize-costar-files\"]', '2017-12-28 06:57:09', '2018-06-04 11:46:57');
INSERT INTO `sap_user` VALUES ('2', 'Wolffdeckow+faker22805@storiqax.com', 'c9081b9de89a841244693b81b3492e6e', '95d3106d171506c291f8cccd0970bd06', 'Conrad', 'Bogisich', null, '2', 'active', '[\"manage-users\",\"manage-clients\",\"view-gmail-accounts\",\"search-prospects\",\"fulfill-list-requests\",\"normalize-csv-files\",\"normalize-costar-files\"]', '2018-06-01 18:53:48', null);
INSERT INTO `sap_user` VALUES ('3', 'Wolffdeckow+faker10194@storiqax.com', '647a8cac5f5b267a3ec8002de1679fb5', '6832e2e3cd01ceefd8592c13b59ab102', 'Fiona', 'Kuhn', '1', '2', 'active', '[\"manage-users\",\"manage-clients\",\"view-gmail-accounts\",\"search-prospects\",\"fulfill-list-requests\",\"normalize-csv-files\",\"normalize-costar-files\"]', '2018-06-01 21:26:44', null);

-- ----------------------------
-- View structure for report_client_data
-- ----------------------------
DROP VIEW IF EXISTS `report_client_data`;
CREATE ALGORITHM=UNDEFINED DEFINER=`homestead`@`%` SQL SECURITY DEFINER VIEW `report_client_data` AS select `c`.`id` AS `id`,`c`.`name` AS `name`,(select count(0) from `sap_client_dne` where (`sap_client_dne`.`client_id` = `c`.`id`)) AS `DNE_domains`,`c`.`sign_on_date` AS `sign_on_date`,`c`.`launch_date` AS `launch_date`,`c`.`expiration_date` AS `expiration_date`,`c`.`contract_goal` AS `contract_goal`,`c`.`target_profiles_summary` AS `target_profiles_summary` from `sap_client` `c` ;

-- ----------------------------
-- View structure for report_gmail_label_counts
-- ----------------------------
DROP VIEW IF EXISTS `report_gmail_label_counts`;
CREATE ALGORITHM=UNDEFINED DEFINER=`homestead`@`%` SQL SECURITY DEFINER VIEW `report_gmail_label_counts` AS select `s`.`id` AS `id`,`s`.`created_at` AS `date`,`s`.`label_count_scheduling_in_progress` AS `label_count_scheduling_in_progress`,`s`.`label_count_reschedule_cancel` AS `label_count_reschedule_cancel`,`s`.`label_count_referral` AS `label_count_referral`,`s`.`label_count_confused` AS `label_count_confused`,`s`.`label_count_closed_lost` AS `label_count_closed_lost`,`s`.`label_count_bad_email` AS `label_count_bad_email`,`s`.`label_count_unknown` AS `label_count_unknown`,`g`.`email` AS `email`,`c`.`name` AS `client_name` from ((`sap_gmail_account_snapshot` `s` left join `sap_client_account_gmail` `g` on((`s`.`gmail_account_id` = `g`.`id`))) left join `sap_client` `c` on((`g`.`client_id` = `c`.`id`))) order by `c`.`name`,`g`.`email`,`s`.`created_at` ;

-- ----------------------------
-- View structure for report_meetings
-- ----------------------------
DROP VIEW IF EXISTS `report_meetings`;
CREATE ALGORITHM=UNDEFINED DEFINER=`homestead`@`%` SQL SECURITY DEFINER VIEW `report_meetings` AS select `e`.`ends_at` AS `Date`,`e`.`title` AS `Description`,`c`.`name` AS `ClientName`,`a`.`email` AS `GmailAccount`,`pc`.`name` AS `Prospect_Company`,`pci`.`name` AS `Prospect_City`,`ps`.`name` AS `Prospect_State`,`pso`.`name` AS `Prospect_Source` from (((((((`sap_gmail_events` `e` left join `sap_client_account_gmail` `a` on((`e`.`account_id` = `a`.`id`))) left join `sap_client` `c` on((`a`.`client_id` = `c`.`id`))) left join `sap_prospect` `p` on((`e`.`prospect_id` = `p`.`id`))) left join `sap_prospect_company` `pc` on((`p`.`company_id` = `pc`.`id`))) left join `sap_prospect_city` `pci` on((`p`.`city_id` = `pci`.`id`))) left join `sap_prospect_state` `ps` on((`p`.`state_id` = `ps`.`id`))) left join `sap_prospect_source` `pso` on((`p`.`source_id` = `pso`.`id`))) where (`e`.`prospect_id` is not null) ;

-- ----------------------------
-- View structure for report_meetings_v2
-- ----------------------------
DROP VIEW IF EXISTS `report_meetings_v2`;
CREATE ALGORITHM=UNDEFINED DEFINER=`homestead`@`%` SQL SECURITY DEFINER VIEW `report_meetings_v2` AS select `e`.`created_at` AS `Date_Added`,`e`.`ends_at` AS `Date`,`e`.`title` AS `Description`,`c`.`name` AS `ClientName`,`a`.`email` AS `GmailAccount`,`p`.`email` AS `Prospect_Email`,`p`.`first_name` AS `Prospect_First_Name`,`p`.`last_name` AS `Prospect_Last_Name`,`p`.`phone_work` AS `Prospect_Phone`,`p`.`title` AS `Prospect_Title`,`pi`.`name` AS `Prospect_Industry`,`pc`.`name` AS `Prospect_Company`,`pci`.`name` AS `Prospect_City`,`ps`.`name` AS `Prospect_State`,`pso`.`name` AS `Prospect_Source` from ((((((((`sap_gmail_events` `e` left join `sap_client_account_gmail` `a` on((`e`.`account_id` = `a`.`id`))) left join `sap_client` `c` on((`a`.`client_id` = `c`.`id`))) left join `sap_prospect` `p` on((`e`.`prospect_id` = `p`.`id`))) left join `sap_prospect_company` `pc` on((`p`.`company_id` = `pc`.`id`))) left join `sap_prospect_city` `pci` on((`p`.`city_id` = `pci`.`id`))) left join `sap_prospect_state` `ps` on((`p`.`state_id` = `ps`.`id`))) left join `sap_prospect_source` `pso` on((`p`.`source_id` = `pso`.`id`))) left join `sap_prospect_industry` `pi` on((`p`.`industry_id` = `pi`.`id`))) ;

-- ----------------------------
-- View structure for report_prospect_events
-- ----------------------------
DROP VIEW IF EXISTS `report_prospect_events`;
CREATE ALGORITHM=UNDEFINED DEFINER=`homestead`@`%` SQL SECURITY DEFINER VIEW `report_prospect_events` AS select `e`.`action` AS `action`,cast(`e`.`occurred_at` as date) AS `event_date`,hour(`e`.`occurred_at`) AS `event_hour_of_day`,year(`e`.`occurred_at`) AS `event_year`,month(`e`.`occurred_at`) AS `event_month`,dayofmonth(`e`.`occurred_at`) AS `event_day_of_month`,dayofweek(`e`.`occurred_at`) AS `event_day_of_week`,`p`.`title` AS `title`,`pi`.`name` AS `industry`,`pc`.`name` AS `city`,`pst`.`name` AS `state`,`pso`.`name` AS `source`,`p`.`created_at` AS `prospect_added_at`,`c`.`name` AS `client`,`cao`.`email` AS `outreach_account` from ((((((((`sap_outreach_prospect_event` `e` left join `sap_outreach_prospect` `op` on((`e`.`outreach_prospect_id` = `op`.`id`))) left join `sap_prospect` `p` on((`op`.`prospect_id` = `p`.`id`))) left join `sap_prospect_industry` `pi` on((`p`.`industry_id` = `pi`.`id`))) left join `sap_prospect_city` `pc` on((`p`.`city_id` = `pc`.`id`))) left join `sap_prospect_state` `pst` on((`p`.`state_id` = `pst`.`id`))) left join `sap_prospect_source` `pso` on((`p`.`source_id` = `pso`.`id`))) left join `sap_client_account_outreach` `cao` on((`op`.`outreach_account_id` = `cao`.`id`))) left join `sap_client` `c` on((`cao`.`client_id` = `c`.`id`))) where (`e`.`action` in ('message_opened','bounced_message','inbound_message','outbound_message')) ;

-- ----------------------------
-- View structure for report_prospect_events_unique
-- ----------------------------
DROP VIEW IF EXISTS `report_prospect_events_unique`;
CREATE ALGORITHM=UNDEFINED DEFINER=`homestead`@`%` SQL SECURITY DEFINER VIEW `report_prospect_events_unique` AS select `e`.`action` AS `action`,cast(`e`.`occurred_at` as date) AS `event_date`,hour(`e`.`occurred_at`) AS `event_hour_of_day`,year(`e`.`occurred_at`) AS `event_year`,month(`e`.`occurred_at`) AS `event_month`,dayofmonth(`e`.`occurred_at`) AS `event_day_of_month`,dayofweek(`e`.`occurred_at`) AS `event_day_of_week`,`p`.`title` AS `title`,`pi`.`name` AS `industry`,`pc`.`name` AS `city`,`pst`.`name` AS `state`,`pso`.`name` AS `source`,`p`.`created_at` AS `prospect_added_at`,`c`.`name` AS `client`,`cao`.`email` AS `outreach_account` from ((((((((`sap_outreach_prospect_event` `e` left join `sap_outreach_prospect` `op` on((`e`.`outreach_prospect_id` = `op`.`id`))) left join `sap_prospect` `p` on((`op`.`prospect_id` = `p`.`id`))) left join `sap_prospect_industry` `pi` on((`p`.`industry_id` = `pi`.`id`))) left join `sap_prospect_city` `pc` on((`p`.`city_id` = `pc`.`id`))) left join `sap_prospect_state` `pst` on((`p`.`state_id` = `pst`.`id`))) left join `sap_prospect_source` `pso` on((`p`.`source_id` = `pso`.`id`))) left join `sap_client_account_outreach` `cao` on((`op`.`outreach_account_id` = `cao`.`id`))) left join `sap_client` `c` on((`cao`.`client_id` = `c`.`id`))) where (`e`.`action` in ('message_opened','bounced_message','inbound_message','outbound_message')) group by concat(`e`.`outreach_prospect_id`,`e`.`mailing_id`,`e`.`action`) ;
