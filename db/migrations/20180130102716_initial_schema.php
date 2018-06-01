<?php

use Phinx\Migration\AbstractMigration;

class InitialSchema extends AbstractMigration
{
    public function up()
    {
        $appEnv = require_once(__DIR__. '/../../conf/env.php');

        $this->query(
            "CREATE TABLE `report_client_data` (
`id` int(11)
,`name` varchar(80)
,`DNE_domains` bigint(21)
,`sign_on_date` date
,`launch_date` date
,`expiration_date` date
,`contract_goal` varchar(255)
,`target_profiles_summary` text
);"
        );

        $this->query(
            "CREATE TABLE `report_gmail_label_counts` (
`id` int(11)
,`date` date
,`label_count_scheduling_in_progress` int(11)
,`label_count_reschedule_cancel` int(11)
,`label_count_referral` int(11)
,`label_count_confused` int(11)
,`label_count_closed_lost` int(11)
,`label_count_bad_email` int(11)
,`label_count_unknown` int(11)
,`email` varchar(100)
,`client_name` varchar(80)
);"
        );

        $this->query(
            "CREATE TABLE `report_meetings` (
`Date` timestamp
,`Description` varchar(150)
,`ClientName` varchar(80)
,`GmailAccount` varchar(100)
,`Prospect_Company` varchar(200)
,`Prospect_City` varchar(255)
,`Prospect_State` varchar(2)
,`Prospect_Source` varchar(50)
);"
        );

        $this->query(
            "CREATE TABLE `report_meetings_v2` (
`Date_Added` datetime
,`Date` timestamp
,`Description` varchar(150)
,`ClientName` varchar(80)
,`GmailAccount` varchar(100)
,`Prospect_Email` varchar(80)
,`Prospect_First_Name` varchar(20)
,`Prospect_Last_Name` varchar(25)
,`Prospect_Phone` varchar(50)
,`Prospect_Title` varchar(255)
,`Prospect_Industry` varchar(255)
,`Prospect_Company` varchar(200)
,`Prospect_City` varchar(255)
,`Prospect_State` varchar(2)
,`Prospect_Source` varchar(50)
);"
        );

        $this->query(
            "CREATE TABLE `report_prospect_events` (
`action` varchar(80)
,`event_date` date
,`event_hour_of_day` int(2)
,`event_year` int(4)
,`event_month` int(2)
,`event_day_of_month` int(2)
,`event_day_of_week` int(1)
,`title` varchar(255)
,`industry` varchar(255)
,`city` varchar(255)
,`state` varchar(2)
,`source` varchar(50)
,`prospect_added_at` timestamp
,`client` varchar(80)
,`outreach_account` varchar(50)
);"
        );

        $this->query(
            "CREATE TABLE `report_prospect_events_unique` (
`action` varchar(80)
,`event_date` date
,`event_hour_of_day` int(2)
,`event_year` int(4)
,`event_month` int(2)
,`event_day_of_month` int(2)
,`event_day_of_week` int(1)
,`title` varchar(255)
,`industry` varchar(255)
,`city` varchar(255)
,`state` varchar(2)
,`source` varchar(50)
,`prospect_added_at` timestamp
,`client` varchar(80)
,`outreach_account` varchar(50)
);"
        );

        $this->query(
            "CREATE TABLE `sap_background_job` (
  `id` int(11) NOT NULL,
  `status` varchar(15) NOT NULL DEFAULT 'ready',
  `data` longtext NOT NULL,
  `error` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `started_at` timestamp NULL DEFAULT NULL,
  `finished_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
        );

        $this->query(
            "CREATE TABLE `sap_client` (
  `id` int(11) NOT NULL,
  `name` varchar(80) NOT NULL,
  `sign_on_date` date DEFAULT NULL,
  `launch_date` date DEFAULT NULL,
  `expiration_date` date DEFAULT NULL,
  `contract_goal` varchar(255) DEFAULT NULL,
  `target_profiles_summary` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
        );

        $this->query(
            "CREATE TABLE `sap_client_account_gmail` (
  `id` int(11) NOT NULL,
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
  `last_scanned_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
        );

        $this->query(
            "CREATE TABLE `sap_client_account_outreach` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `access_token` text,
  `refresh_token` text,
  `token_expires` int(11) DEFAULT NULL,
  `request_index` int(11) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'disconnected',
  `under_process_by` varchar(100) DEFAULT '0',
  `disconnect_reason` varchar(256) DEFAULT NULL,
  `last_pulled_at` timestamp NULL DEFAULT NULL,
  `sync_stage_prospects_last_page` int(11) DEFAULT '0',
  `sync_stage_prospects_updated_at` datetime DEFAULT NULL,
  `outreach_scanned_end_date` datetime DEFAULT NULL,
  `outreach_scanned_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
        );

        $this->query(
            "CREATE TABLE `sap_client_comments` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `type` tinyint(1) DEFAULT NULL,
  `name` varchar(150) DEFAULT NULL,
  `comment_text` text,
  `status` varchar(10) DEFAULT 'ACTIVE',
  `date_created` datetime DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;"
        );

        $this->query(
            "CREATE TABLE `sap_client_dne` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `domain` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
        );

        $this->query(
            "CREATE TABLE `sap_client_health_score` (
  `score_id` int(11) NOT NULL,
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
  `modified_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;"
        );

        $this->query(
            "CREATE TABLE `sap_client_meetings_per_month` (
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
  `meetings_dec` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;"
        );

        $this->query(
            "CREATE TABLE `sap_client_pod` (
  `client_id` int(11) DEFAULT NULL,
  `client_name` varchar(75) DEFAULT NULL,
  `client_strategist` varchar(75) DEFAULT NULL,
  `pod` varchar(75) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;"
        );

        $this->query(
            "CREATE TABLE `sap_client_profile` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `name` varchar(75) NOT NULL,
  `states` text,
  `countries` text,
  `max_prospects` mediumint(9) DEFAULT NULL,
  `max_prospects_scope` varchar(15) DEFAULT NULL,
  `geotarget` varchar(200) DEFAULT NULL,
  `geotarget_lat` float DEFAULT NULL,
  `geotarget_lng` float DEFAULT NULL,
  `radius` mediumint(9) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
        );

        $this->query(
            "CREATE TABLE `sap_client_profile_department` (
  `id` int(11) NOT NULL,
  `client_profile_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
        );

        $this->query(
            "CREATE TABLE `sap_client_profile_title` (
  `id` int(11) NOT NULL,
  `client_profile_id` int(11) NOT NULL,
  `title_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
        );

        $this->query(
            "CREATE TABLE `sap_client_targeting_profiles` (
  `profile_id` int(11) NOT NULL,
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
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;"
        );

        $this->query(
            "CREATE TABLE `sap_client_targeting_requests` (
  `request_id` int(11) NOT NULL,
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
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
"
        );

        $this->query(
            "CREATE TABLE `sap_dashboard_stat` (
  `id` int(11) NOT NULL,
  `clients` int(11) NOT NULL,
  `accounts_syncing` int(11) NOT NULL,
  `prospects` int(11) NOT NULL,
  `prospect_events` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
        );

        $this->query(
            "INSERT INTO `sap_dashboard_stat` (`id`, `clients`, `accounts_syncing`, `prospects`, `prospect_events`) VALUES
(1, 0, 0, 0, 0);"
        );

        $this->query(
            "CREATE TABLE `sap_department` (
  `id` int(11) NOT NULL,
  `department` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
        );

        $this->query(
            "CREATE TABLE `sap_department_keyword` (
  `id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `keyword` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
        );

        $this->query(
            "CREATE TABLE `sap_download` (
  `id` int(11) NOT NULL,
  `list_request_id` int(11) DEFAULT NULL,
  `created_on` date NOT NULL,
  `filename` varchar(100) NOT NULL,
  `row_count` int(11) NOT NULL,
  `filtered` varchar(100) NOT NULL,
  `filtered_count` int(11) NOT NULL,
  `purged` varchar(100) NOT NULL,
  `purged_count` int(11) NOT NULL,
  `saved_to_db` tinyint(1) NOT NULL DEFAULT '0',
  `uploaded_to_outreach` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
        );

        $this->query(
            "CREATE TABLE `sap_download_filtered` (
  `id` int(11) NOT NULL,
  `list_request_id` int(11) DEFAULT NULL,
  `created_on` date NOT NULL,
  `filename` varchar(100) NOT NULL,
  `row_count` int(11) NOT NULL,
  `nidb` varchar(100) DEFAULT NULL,
  `nidb_count` int(45) DEFAULT NULL,
  `idbnor` varchar(100) DEFAULT NULL,
  `idbnor_count` int(11) DEFAULT NULL,
  `idbior` varchar(100) DEFAULT NULL,
  `idbior_count` int(11) DEFAULT NULL,
  `filtered` varchar(100) DEFAULT NULL,
  `filtered_count` int(11) DEFAULT NULL,
  `purged` varchar(100) DEFAULT NULL,
  `purged_count` int(11) DEFAULT NULL,
  `saved_to_db` tinyint(1) DEFAULT '0',
  `uploaded_to_outreach` tinyint(1) DEFAULT '0',
  `client_id` int(11) DEFAULT NULL,
  `client_name` varchar(100) DEFAULT NULL,
  `search_criteria` text,
  `saved_to_db_count` int(11) DEFAULT NULL,
  `saved_to_db_ids` text,
  `status` varchar(45) DEFAULT 'In Queue'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
        );

        $this->query(
            "CREATE TABLE `sap_download_filtered_prospect` (
  `id` int(11) NOT NULL,
  `download_id` int(11) NOT NULL,
  `prospect_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
        );

        $this->query(
            "CREATE TABLE `sap_download_prospect` (
  `id` int(11) NOT NULL,
  `download_id` int(11) NOT NULL,
  `prospect_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
        );

        $this->query(
            "CREATE TABLE `sap_gmail_account_snapshot` (
  `id` int(11) NOT NULL,
  `gmail_account_id` int(11) NOT NULL,
  `created_at` date NOT NULL,
  `label_count_scheduling_in_progress` int(11) NOT NULL,
  `label_count_reschedule_cancel` int(11) NOT NULL,
  `label_count_referral` int(11) NOT NULL,
  `label_count_confused` int(11) NOT NULL,
  `label_count_closed_lost` int(11) NOT NULL,
  `label_count_bad_email` int(11) NOT NULL,
  `label_count_unknown` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
        );

        $this->query(
            "CREATE TABLE `sap_gmail_account_stats` (
  `id` int(11) NOT NULL,
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
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
        );

        $this->query(
            "CREATE TABLE `sap_gmail_events` (
  `id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `event_id` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  `starts_at` datetime NOT NULL,
  `ends_at` timestamp NOT NULL,
  `status` varchar(20) NOT NULL,
  `title` varchar(150) DEFAULT NULL,
  `prospect_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
        );

        $this->query(
            "CREATE TABLE `sap_gmail_message` (
  `id` int(11) NOT NULL,
  `gmail_account_id` int(11) NOT NULL,
  `message_id` varchar(16) NOT NULL,
  `thread_id` varchar(16) NOT NULL,
  `to` varchar(100) DEFAULT NULL,
  `prospect_id` int(11) DEFAULT NULL,
  `sent_at` timestamp NOT NULL,
  `processed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `label_applied` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
        );

        $this->query(
            "CREATE TABLE `sap_gmail_retrain_queue` (
  `id` int(11) NOT NULL,
  `gmail_account_id` int(11) NOT NULL,
  `message_id` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
        );

        $this->query(
            "CREATE TABLE `sap_group` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `sort_order` mediumint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
        );

        $this->query(
            "CREATE TABLE `sap_group_title` (
  `id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `sort_order` mediumint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
        );

        $this->query(
            "CREATE TABLE `sap_group_title_negative` (
  `id` int(11) NOT NULL,
  `group_title_id` int(11) NOT NULL,
  `keyword` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
        );

        $this->query(
            "CREATE TABLE `sap_group_title_variation` (
  `id` int(11) NOT NULL,
  `group_title_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
        );

        $this->query(
            "CREATE TABLE `sap_list_request` (
  `id` int(11) NOT NULL,
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
  `uploaded_to_outreach` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
        );

        $this->query(
            "CREATE TABLE `sap_list_request_comment` (
  `id` int(11) NOT NULL,
  `list_request_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
        );

        $this->query(
            "CREATE TABLE `sap_list_request_prospect` (
  `id` int(11) NOT NULL,
  `list_request_id` int(11) NOT NULL,
  `prospect_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
        );

        $this->query(
            "CREATE TABLE `sap_outreach_prospect` (
  `id` int(11) NOT NULL,
  `prospect_id` int(11) NOT NULL,
  `outreach_account_id` int(11) NOT NULL,
  `outreach_id` int(11) NOT NULL,
  `outreach_created_at` datetime DEFAULT NULL,
  `outreach_optedout_at` datetime DEFAULT NULL,
  `outreach_updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
        );

        $this->query(
            "CREATE TABLE `sap_outreach_prospect_event` (
  `id` int(11) NOT NULL,
  `outreach_prospect_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `template_id` int(11) DEFAULT NULL,
  `mailing_id` int(11) DEFAULT NULL,
  `action` varchar(80) NOT NULL,
  `metadata` text NOT NULL,
  `occurred_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
        );

        $this->query(
            "CREATE TABLE `sap_outreach_prospect_stage` (
  `id` int(11) NOT NULL,
  `outreach_prospect_id` int(11) NOT NULL,
  `stage_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
        );

        $this->query(
            "CREATE TABLE `sap_outreach_prospect_stage_v2` (
  `id` int(11) NOT NULL,
  `outreach_prospect_id` int(11) NOT NULL,
  `stage_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
        );

        $this->query(
            "CREATE TABLE `sap_outreach_prospect_tag` (
  `id` int(11) NOT NULL,
  `outreach_prospect_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
        );

        $this->query(
            "CREATE TABLE `sap_outreach_templates` (
  `id` bigint(11) NOT NULL,
  `template_id` bigint(11) NOT NULL,
  `bounce_count` int(11) DEFAULT '0',
  `click_count` int(11) DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `deliver_count` int(11) DEFAULT '0',
  `failure_count` int(11) DEFAULT '0',
  `last_used_at` datetime DEFAULT NULL,
  `name` text NOT NULL,
  `open_count` int(11) DEFAULT '0',
  `opt_out_count` int(11) DEFAULT '0',
  `reply_count` int(11) DEFAULT '0',
  `updated_at` datetime DEFAULT NULL,
  `meta_data` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;"
        );

        $this->query(
            "CREATE TABLE `sap_outreach_updated_prospects` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `outreach_account_id` int(11) NOT NULL,
  `prospect_email` varchar(75) NOT NULL,
  `label` varchar(100) DEFAULT NULL,
  `label_value` varchar(150) NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;"
        );

        $this->query(
            "CREATE TABLE `sap_prospect` (
  `id` int(11) NOT NULL,
  `email` varchar(80) NOT NULL,
  `first_name` varchar(20) DEFAULT NULL,
  `last_name` varchar(25) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
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
  `last_emailed_at` timestamp NULL DEFAULT NULL,
  `outreach_created_at` datetime DEFAULT NULL,
  `outreach_optedout_at` datetime DEFAULT NULL,
  `outreach_updated_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
        );

        $this->query(
            "CREATE TABLE `sap_prospect_city` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
        );

        $this->query(
            "CREATE TABLE `sap_prospect_company` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
        );

        $this->query(
            "CREATE TABLE `sap_prospect_country` (
  `id` int(11) NOT NULL,
  `name` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
        );

        $this->query(
            "CREATE TABLE `sap_prospect_industry` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
        );

        $this->query(
            "CREATE TABLE `sap_prospect_mailings` (
  `id` bigint(11) NOT NULL,
  `mailing_id` bigint(11) NOT NULL,
  `outreach_account_id` bigint(11) NOT NULL,
  `bounced_at` datetime DEFAULT NULL,
  `click_count` int(11) DEFAULT '0',
  `clicked_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `delivered_at` datetime DEFAULT NULL,
  `mailbox_address` varchar(50) DEFAULT NULL,
  `mailing_type` varchar(50) DEFAULT NULL,
  `open_count` int(11) DEFAULT '0',
  `opened_at` datetime DEFAULT NULL,
  `replied_at` datetime DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `state_changed_at` datetime DEFAULT NULL,
  `unsubscribed_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `meta_data` text,
  `prospect_id` bigint(11) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;"
        );

        $this->query(
            "CREATE TABLE `sap_prospect_source` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
        );

        $this->query(
            "CREATE TABLE `sap_prospect_stage` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
        );

        $this->query(
            "CREATE TABLE `sap_prospect_stage_v2` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
        );

        $this->query(
            "CREATE TABLE `sap_prospect_state` (
  `id` int(11) NOT NULL,
  `name` varchar(2) NOT NULL,
  `label` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
        );

        $this->query(
            "CREATE TABLE `sap_prospect_tag` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
        );

        $this->query(
            "CREATE TABLE `sap_role` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `permissions` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
        );

        $this->query(
            "INSERT INTO `sap_role` (`id`, `name`, `permissions`) VALUES
(1, 'Super Admin', '[\"super-admin\"]'),
(2, 'Admin', '[\"manage-users\",\"manage-clients\",\"view-gmail-accounts\",\"search-prospects\",\"fulfill-list-requests\",\"normalize-csv-files\",\"normalize-costar-files\"]');"
        );

        $this->query(
            "CREATE TABLE `sap_settings` (
  `id` int(11) NOT NULL,
  `settings` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
        );

        $this->query(
            "INSERT INTO `sap_settings` (`id`, `settings`) VALUES
(1, '{\"email-notifications\":\"user@host.com\",\"max-requests-per-day\":\"10\",\"list-certified-api-key\":\"76a9d38c-7a0c-4cab-8fea-c7825b8c03a1\",\"slack-api-key\":\"xoxp-6569438293-197668088033-199887878496-1609e054b76a1480aa10b2838e6056ea\",\"sendgrid-api-key\":\"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\",\"google-maps-api-key\":\"AIzaSyCtjAsX5y6Gobiq0YMZ3gnKbn9ygBjW4ZA\",\"mapquest-api-key\":\"AYIZAGQWFhCTI2UyxQ2XdFAmpc6JYeQ9\",\"geo-encoding\":\"1\",\"disconnect-notifications\":\"1\"}'),
(2, '{\"amazon-ml-data-source-key\":\"0721330001500557947.csv\",\"amazon-ml-data-source-id\":\"0721330001500557947.csv\",\"amazon-ml-model-id\":\"ml0721330001500557947.csv\",\"amazon-ml-predict-endpoint\":\"https://realtime.machinelearning.us-east-1.amazonaws.com\",\"ai-last-trained\":1500540291}');"
        );

        $this->query(
            "CREATE TABLE `sap_suppression` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `client_segment` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;"
        );

        $this->query(
            "CREATE TABLE `sap_suppression_domain` (
  `id` int(11) NOT NULL,
  `suppression_id` int(11) NOT NULL,
  `domain` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;"
        );

        $this->query(
            "CREATE TABLE `sap_survey` (
  `id` int(11) NOT NULL,
  `event_id` varchar(50) NOT NULL,
  `prospect_name` varchar(100) DEFAULT NULL,
  `prospect_attended` tinyint(1) NOT NULL,
  `feedback` varchar(40) NOT NULL,
  `feedback_other` text,
  `comments` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
        );

        $this->query(
            "CREATE TABLE `sap_targeting_request_comment` (
  `id` int(11) NOT NULL,
  `list_request_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
        );

        $this->query(
            "CREATE TABLE `sap_user` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `salt` varchar(32) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `role_id` int(11) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'active',
  `permissions` mediumtext NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_login_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
        );

        $this->query(
            "INSERT INTO `sap_user` (`id`, `email`, `password`, `salt`, `first_name`, `last_name`, `role_id`, `status`, `permissions`, `created_at`, `last_login_at`) VALUES
(1, 'admin@sappersuite.com', 'ee7eb73958731cd6c77b1153e5889edc', 'c0b4a884fd30a5db69ebea7ed0532790', 'Mister', 'Admin', 2, 'active', '[\"manage-users\",\"manage-clients\",\"view-gmail-accounts\",\"search-prospects\",\"fulfill-list-requests\",\"normalize-csv-files\",\"normalize-costar-files\"]', '2017-12-28 06:57:09', '2018-01-30 09:23:05');"
        );

        $this->query(
            "DROP TABLE IF EXISTS `report_client_data`;"
        );

        $this->query(
            "CREATE ALGORITHM=UNDEFINED DEFINER=`". $appEnv['DB_USER'] ."`@`%` SQL SECURITY DEFINER VIEW `report_client_data`  AS  select `c`.`id` AS `id`,`c`.`name` AS `name`,(select count(0) from `sap_client_dne` where (`sap_client_dne`.`client_id` = `c`.`id`)) AS `DNE_domains`,`c`.`sign_on_date` AS `sign_on_date`,`c`.`launch_date` AS `launch_date`,`c`.`expiration_date` AS `expiration_date`,`c`.`contract_goal` AS `contract_goal`,`c`.`target_profiles_summary` AS `target_profiles_summary` from `sap_client` `c` ;"
        );

        $this->query(
            "DROP TABLE IF EXISTS `report_gmail_label_counts`;"
        );

        $this->query(
            "CREATE ALGORITHM=UNDEFINED DEFINER=`". $appEnv['DB_USER'] ."`@`%` SQL SECURITY DEFINER VIEW `report_gmail_label_counts`  AS  select `s`.`id` AS `id`,`s`.`created_at` AS `date`,`s`.`label_count_scheduling_in_progress` AS `label_count_scheduling_in_progress`,`s`.`label_count_reschedule_cancel` AS `label_count_reschedule_cancel`,`s`.`label_count_referral` AS `label_count_referral`,`s`.`label_count_confused` AS `label_count_confused`,`s`.`label_count_closed_lost` AS `label_count_closed_lost`,`s`.`label_count_bad_email` AS `label_count_bad_email`,`s`.`label_count_unknown` AS `label_count_unknown`,`g`.`email` AS `email`,`c`.`name` AS `client_name` from ((`sap_gmail_account_snapshot` `s` left join `sap_client_account_gmail` `g` on((`s`.`gmail_account_id` = `g`.`id`))) left join `sap_client` `c` on((`g`.`client_id` = `c`.`id`))) order by `c`.`name`,`g`.`email`,`s`.`created_at` ;"
        );

        $this->query(
            "DROP TABLE IF EXISTS `report_meetings`;"
        );

        $this->query(
            "CREATE ALGORITHM=UNDEFINED DEFINER=`". $appEnv['DB_USER'] ."`@`%` SQL SECURITY DEFINER VIEW `report_meetings`  AS  select `e`.`ends_at` AS `Date`,`e`.`title` AS `Description`,`c`.`name` AS `ClientName`,`a`.`email` AS `GmailAccount`,`pc`.`name` AS `Prospect_Company`,`pci`.`name` AS `Prospect_City`,`ps`.`name` AS `Prospect_State`,`pso`.`name` AS `Prospect_Source` from (((((((`sap_gmail_events` `e` left join `sap_client_account_gmail` `a` on((`e`.`account_id` = `a`.`id`))) left join `sap_client` `c` on((`a`.`client_id` = `c`.`id`))) left join `sap_prospect` `p` on((`e`.`prospect_id` = `p`.`id`))) left join `sap_prospect_company` `pc` on((`p`.`company_id` = `pc`.`id`))) left join `sap_prospect_city` `pci` on((`p`.`city_id` = `pci`.`id`))) left join `sap_prospect_state` `ps` on((`p`.`state_id` = `ps`.`id`))) left join `sap_prospect_source` `pso` on((`p`.`source_id` = `pso`.`id`))) where (`e`.`prospect_id` is not null) ;"
        );

        $this->query(
            "DROP TABLE IF EXISTS `report_meetings_v2`;"
        );

        $this->query(
            "CREATE ALGORITHM=UNDEFINED DEFINER=`". $appEnv['DB_USER'] ."`@`%` SQL SECURITY DEFINER VIEW `report_meetings_v2`  AS  select `e`.`created_at` AS `Date_Added`,`e`.`ends_at` AS `Date`,`e`.`title` AS `Description`,`c`.`name` AS `ClientName`,`a`.`email` AS `GmailAccount`,`p`.`email` AS `Prospect_Email`,`p`.`first_name` AS `Prospect_First_Name`,`p`.`last_name` AS `Prospect_Last_Name`,`p`.`phone_work` AS `Prospect_Phone`,`p`.`title` AS `Prospect_Title`,`pi`.`name` AS `Prospect_Industry`,`pc`.`name` AS `Prospect_Company`,`pci`.`name` AS `Prospect_City`,`ps`.`name` AS `Prospect_State`,`pso`.`name` AS `Prospect_Source` from ((((((((`sap_gmail_events` `e` left join `sap_client_account_gmail` `a` on((`e`.`account_id` = `a`.`id`))) left join `sap_client` `c` on((`a`.`client_id` = `c`.`id`))) left join `sap_prospect` `p` on((`e`.`prospect_id` = `p`.`id`))) left join `sap_prospect_company` `pc` on((`p`.`company_id` = `pc`.`id`))) left join `sap_prospect_city` `pci` on((`p`.`city_id` = `pci`.`id`))) left join `sap_prospect_state` `ps` on((`p`.`state_id` = `ps`.`id`))) left join `sap_prospect_source` `pso` on((`p`.`source_id` = `pso`.`id`))) left join `sap_prospect_industry` `pi` on((`p`.`industry_id` = `pi`.`id`))) ;"
        );

        $this->query(
            "DROP TABLE IF EXISTS `report_prospect_events`;"
        );

        $this->query(
            "CREATE ALGORITHM=UNDEFINED DEFINER=`". $appEnv['DB_USER'] ."`@`%` SQL SECURITY DEFINER VIEW `report_prospect_events`  AS  select `e`.`action` AS `action`,cast(`e`.`occurred_at` as date) AS `event_date`,hour(`e`.`occurred_at`) AS `event_hour_of_day`,year(`e`.`occurred_at`) AS `event_year`,month(`e`.`occurred_at`) AS `event_month`,dayofmonth(`e`.`occurred_at`) AS `event_day_of_month`,dayofweek(`e`.`occurred_at`) AS `event_day_of_week`,`p`.`title` AS `title`,`pi`.`name` AS `industry`,`pc`.`name` AS `city`,`pst`.`name` AS `state`,`pso`.`name` AS `source`,`p`.`created_at` AS `prospect_added_at`,`c`.`name` AS `client`,`cao`.`email` AS `outreach_account` from ((((((((`sap_outreach_prospect_event` `e` left join `sap_outreach_prospect` `op` on((`e`.`outreach_prospect_id` = `op`.`id`))) left join `sap_prospect` `p` on((`op`.`prospect_id` = `p`.`id`))) left join `sap_prospect_industry` `pi` on((`p`.`industry_id` = `pi`.`id`))) left join `sap_prospect_city` `pc` on((`p`.`city_id` = `pc`.`id`))) left join `sap_prospect_state` `pst` on((`p`.`state_id` = `pst`.`id`))) left join `sap_prospect_source` `pso` on((`p`.`source_id` = `pso`.`id`))) left join `sap_client_account_outreach` `cao` on((`op`.`outreach_account_id` = `cao`.`id`))) left join `sap_client` `c` on((`cao`.`client_id` = `c`.`id`))) where (`e`.`action` in ('message_opened','bounced_message','inbound_message','outbound_message')) ;"
        );

        $this->query(
            "DROP TABLE IF EXISTS `report_prospect_events_unique`;"
        );

        $this->query(
            "CREATE ALGORITHM=UNDEFINED DEFINER=`". $appEnv['DB_USER'] ."`@`%` SQL SECURITY DEFINER VIEW `report_prospect_events_unique`  AS  select `e`.`action` AS `action`,cast(`e`.`occurred_at` as date) AS `event_date`,hour(`e`.`occurred_at`) AS `event_hour_of_day`,year(`e`.`occurred_at`) AS `event_year`,month(`e`.`occurred_at`) AS `event_month`,dayofmonth(`e`.`occurred_at`) AS `event_day_of_month`,dayofweek(`e`.`occurred_at`) AS `event_day_of_week`,`p`.`title` AS `title`,`pi`.`name` AS `industry`,`pc`.`name` AS `city`,`pst`.`name` AS `state`,`pso`.`name` AS `source`,`p`.`created_at` AS `prospect_added_at`,`c`.`name` AS `client`,`cao`.`email` AS `outreach_account` from ((((((((`sap_outreach_prospect_event` `e` left join `sap_outreach_prospect` `op` on((`e`.`outreach_prospect_id` = `op`.`id`))) left join `sap_prospect` `p` on((`op`.`prospect_id` = `p`.`id`))) left join `sap_prospect_industry` `pi` on((`p`.`industry_id` = `pi`.`id`))) left join `sap_prospect_city` `pc` on((`p`.`city_id` = `pc`.`id`))) left join `sap_prospect_state` `pst` on((`p`.`state_id` = `pst`.`id`))) left join `sap_prospect_source` `pso` on((`p`.`source_id` = `pso`.`id`))) left join `sap_client_account_outreach` `cao` on((`op`.`outreach_account_id` = `cao`.`id`))) left join `sap_client` `c` on((`cao`.`client_id` = `c`.`id`))) where (`e`.`action` in ('message_opened','bounced_message','inbound_message','outbound_message')) group by concat(`e`.`outreach_prospect_id`,`e`.`mailing_id`,`e`.`action`) ;"
        );

        $this->query(
            "ALTER TABLE `sap_background_job`
  ADD PRIMARY KEY (`id`);"
        );

        $this->query(
            "ALTER TABLE `sap_client`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);"
        );

        $this->query(
            "ALTER TABLE `sap_client_account_gmail`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `survey_email` (`survey_email`) USING BTREE;"
        );

        $this->query(
            "ALTER TABLE `sap_client_account_outreach`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_unique` (`email`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `IDK_SYNC_STAGE` (`sync_stage_prospects_updated_at`);"
        );

        $this->query(
            "ALTER TABLE `sap_client_comments`
  ADD PRIMARY KEY (`id`);"
        );

        $this->query(
            "ALTER TABLE `sap_client_dne`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `client_id_domain_unique` (`client_id`,`domain`),
  ADD KEY `client_id` (`client_id`) USING BTREE,
  ADD KEY `client_id_domain` (`domain`,`client_id`) USING BTREE;"
        );

        $this->query(
            "ALTER TABLE `sap_client_health_score`
  ADD PRIMARY KEY (`score_id`),
  ADD UNIQUE KEY `UNQ_HS` (`client_id`,`year`,`gmail_account_id`);"
        );

        $this->query(
            "ALTER TABLE `sap_client_pod`
  ADD KEY `client_id` (`client_id`);"
        );

        $this->query(
            "ALTER TABLE `sap_client_profile`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `client_id_2` (`client_id`,`name`),
  ADD KEY `client_id` (`client_id`);"
        );

        $this->query(
            "ALTER TABLE `sap_client_profile_department`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_profile_id` (`client_profile_id`),
  ADD KEY `department_id` (`department_id`);"
        );

        $this->query(
            "ALTER TABLE `sap_client_profile_title`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_profile_id` (`client_profile_id`),
  ADD KEY `title_id` (`title_id`);"
        );

        $this->query(
            "ALTER TABLE `sap_client_targeting_profiles`
  ADD PRIMARY KEY (`profile_id`),
  ADD UNIQUE KEY `UNQ_CLIENT` (`client_id`);"
        );

        $this->query(
            "ALTER TABLE `sap_client_targeting_requests`
  ADD PRIMARY KEY (`request_id`);"
        );

        $this->query(
            "ALTER TABLE `sap_dashboard_stat`
  ADD PRIMARY KEY (`id`);"
        );

        $this->query(
            "ALTER TABLE `sap_department`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `industry` (`department`);"
        );

        $this->query(
            "ALTER TABLE `sap_department_keyword`
  ADD PRIMARY KEY (`id`),
  ADD KEY `industry_id` (`department_id`);"
        );

        $this->query(
            "ALTER TABLE `sap_download`
  ADD PRIMARY KEY (`id`),
  ADD KEY `list_request_id` (`list_request_id`),
  ADD KEY `t3` (`created_on`,`row_count`,`filtered_count`);"
        );

        $this->query(
            "ALTER TABLE `sap_download_filtered`
  ADD PRIMARY KEY (`id`),
  ADD KEY `list_request_id` (`list_request_id`);"
        );

        $this->query(
            "ALTER TABLE `sap_download_filtered_prospect`
  ADD PRIMARY KEY (`id`),
  ADD KEY `download_filtered_id` (`download_id`),
  ADD KEY `prospect_filtered_id` (`prospect_id`);"
        );

        $this->query(
            "ALTER TABLE `sap_download_prospect`
  ADD PRIMARY KEY (`id`),
  ADD KEY `download_id` (`download_id`),
  ADD KEY `prospect_id` (`prospect_id`);"
        );

        $this->query(
            "ALTER TABLE `sap_gmail_account_snapshot`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `gmail_account_id_2` (`gmail_account_id`,`created_at`),
  ADD KEY `gmail_account_id` (`gmail_account_id`);"
        );

        $this->query(
            "ALTER TABLE `sap_gmail_account_stats`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `gmail_account_id_2` (`gmail_account_id`),
  ADD KEY `gmail_account_id` (`gmail_account_id`);"
        );

        $this->query(
            "ALTER TABLE `sap_gmail_events`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `event_id` (`event_id`),
  ADD KEY `account_id` (`account_id`),
  ADD KEY `prospect_id` (`prospect_id`);"
        );

        $this->query(
            "ALTER TABLE `sap_gmail_message`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `message_id` (`message_id`) USING BTREE,
  ADD KEY `gmail_account_id` (`gmail_account_id`),
  ADD KEY `prospect_id` (`prospect_id`),
  ADD KEY `label_applied` (`label_applied`),
  ADD KEY `thread_id` (`thread_id`);"
        );

        $this->query(
            "ALTER TABLE `sap_gmail_retrain_queue`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `message_id` (`message_id`),
  ADD KEY `gmail_account_id` (`gmail_account_id`);"
        );

        $this->query(
            "ALTER TABLE `sap_group`
  ADD PRIMARY KEY (`id`);"
        );

        $this->query(
            "ALTER TABLE `sap_group_title`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_id` (`group_id`);"
        );

        $this->query(
            "ALTER TABLE `sap_group_title_negative`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_title_id` (`group_title_id`);"
        );

        $this->query(
            "ALTER TABLE `sap_group_title_variation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_title_id` (`group_title_id`);"
        );

        $this->query(
            "ALTER TABLE `sap_list_request`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`status`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `fulfilled_by` (`fulfilled_by`),
  ADD KEY `closed_by` (`closed_by`),
  ADD KEY `assigned_to` (`assigned_to`),
  ADD KEY `outreach_account_id` (`outreach_account_id`);"
        );

        $this->query(
            "ALTER TABLE `sap_list_request_comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `list_request_id` (`list_request_id`) USING BTREE;"
        );

        $this->query(
            "ALTER TABLE `sap_list_request_prospect`
  ADD PRIMARY KEY (`id`),
  ADD KEY `list_request_id` (`list_request_id`),
  ADD KEY `prospect_id` (`prospect_id`);"
        );

        $this->query(
            "ALTER TABLE `sap_outreach_prospect`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_outreach_account_prospect` (`outreach_account_id`,`prospect_id`),
  ADD KEY `prospect_id` (`prospect_id`),
  ADD KEY `outreach_account_id` (`outreach_account_id`),
  ADD KEY `outreach_id` (`outreach_id`);"
        );

        $this->query(
            "ALTER TABLE `sap_outreach_prospect_event`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_outreach_prospect_event` (`outreach_prospect_id`,`event_id`),
  ADD KEY `outreach_prospect_id` (`outreach_prospect_id`),
  ADD KEY `outreach_prospect_id_2` (`outreach_prospect_id`,`mailing_id`,`action`);"
        );

        $this->query(
            "ALTER TABLE `sap_outreach_prospect_stage`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index_client_prospect_id` (`outreach_prospect_id`),
  ADD KEY `index_stage_id` (`stage_id`);"
        );

        $this->query(
            "ALTER TABLE `sap_outreach_prospect_stage_v2`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index_client_prospect_id` (`outreach_prospect_id`),
  ADD KEY `index_stage_id` (`stage_id`);"
        );

        $this->query(
            "ALTER TABLE `sap_outreach_prospect_tag`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_prospect_id` (`outreach_prospect_id`),
  ADD KEY `tag_id` (`tag_id`);"
        );

        $this->query(
            "ALTER TABLE `sap_outreach_templates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_IDX` (`template_id`);"
        );

        $this->query(
            "ALTER TABLE `sap_outreach_updated_prospects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `client_id` (`client_id`,`outreach_account_id`,`prospect_email`,`label`);"
        );

        $this->query(
            "ALTER TABLE `sap_prospect`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_email` (`email`),
  ADD KEY `company_id` (`company_id`),
  ADD KEY `industry_id` (`industry_id`),
  ADD KEY `city_id` (`city_id`),
  ADD KEY `state_id` (`state_id`),
  ADD KEY `country_id` (`country_id`),
  ADD KEY `source_id` (`source_id`),
  ADD KEY `IDK_CRT` (`outreach_created_at`),
  ADD KEY `IDK_UPD` (`outreach_updated_at`),
  ADD KEY `zoominfo_id` (`zoominfo_id`),
  ADD KEY `zoominfo_company_id` (`zoominfo_company_id`);"
        );

        $this->query(
            "ALTER TABLE `sap_prospect_city`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_name` (`name`);"
        );

        $this->query(
            "ALTER TABLE `sap_prospect_company`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_name` (`name`);"
        );

        $this->query(
            "ALTER TABLE `sap_prospect_country`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_name` (`name`);"
        );

        $this->query(
            "ALTER TABLE `sap_prospect_industry`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_name` (`name`);"
        );

        $this->query(
            "ALTER TABLE `sap_prospect_mailings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_IDX` (`mailing_id`,`outreach_account_id`),
  ADD KEY `IDX_DLV` (`delivered_at`),
  ADD KEY `IDX_CRT` (`created_at`),
  ADD KEY `IDK_OPN` (`opened_at`),
  ADD KEY `IDK_RPL` (`replied_at`),
  ADD KEY `IDK_UNSUB` (`unsubscribed_at`),
  ADD KEY `IDK_UPD` (`updated_at`),
  ADD KEY `IDK_BON` (`bounced_at`),
  ADD KEY `IDK_PROSP` (`prospect_id`),
  ADD KEY `IDK_OUTID` (`outreach_account_id`),
  ADD KEY `IDK_STATE` (`state`);"
        );

        $this->query(
            "ALTER TABLE `sap_prospect_source`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_name` (`name`),
  ADD KEY `id` (`id`);"
        );

        $this->query(
            "ALTER TABLE `sap_prospect_stage`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_name` (`name`);"
        );

        $this->query(
            "ALTER TABLE `sap_prospect_stage_v2`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_name` (`name`);"
        );

        $this->query(
            "ALTER TABLE `sap_prospect_state`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_name` (`name`);"
        );

        $this->query(
            "ALTER TABLE `sap_prospect_tag`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_name` (`name`);"
        );

        $this->query(
            "ALTER TABLE `sap_role`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);"
        );

        $this->query(
            "ALTER TABLE `sap_settings`
  ADD PRIMARY KEY (`id`);"
        );

        $this->query(
            "ALTER TABLE `sap_suppression`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);"
        );

        $this->query(
            "ALTER TABLE `sap_suppression_domain`
  ADD PRIMARY KEY (`id`),
  ADD KEY `suppression_id` (`suppression_id`),
  ADD KEY `suppression_id_domain` (`domain`,`suppression_id`);"
        );

        $this->query(
            "ALTER TABLE `sap_survey`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `event_id` (`event_id`),
  ADD KEY `feedback` (`feedback`);"
        );

        $this->query(
            "ALTER TABLE `sap_targeting_request_comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `list_request_id` (`list_request_id`) USING BTREE;"
        );

        $this->query(
            "ALTER TABLE `sap_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `role_id` (`role_id`);"
        );

        $this->query(
            "ALTER TABLE `sap_background_job`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;"
        );

        $this->query(
            "ALTER TABLE `sap_client`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;"
        );

        $this->query(
            "ALTER TABLE `sap_client_account_gmail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;"
        );

        $this->query(
            "ALTER TABLE `sap_client_account_outreach`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;"
        );

        $this->query(
            "ALTER TABLE `sap_client_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;"
        );

        $this->query(
            "ALTER TABLE `sap_client_dne`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;"
        );

        $this->query(
            "ALTER TABLE `sap_client_health_score`
  MODIFY `score_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;"
        );

        $this->query(
            "ALTER TABLE `sap_client_profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;"
        );

        $this->query(
            "ALTER TABLE `sap_client_profile_department`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;"
        );

        $this->query(
            "ALTER TABLE `sap_client_profile_title`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;"
        );

        $this->query(
            "ALTER TABLE `sap_client_targeting_profiles`
  MODIFY `profile_id` int(11) NOT NULL AUTO_INCREMENT;"
        );

        $this->query(
            "ALTER TABLE `sap_client_targeting_requests`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;"
        );

        $this->query(
            "ALTER TABLE `sap_dashboard_stat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;"
        );

        $this->query(
            "ALTER TABLE `sap_department`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;"
        );

        $this->query(
            "ALTER TABLE `sap_department_keyword`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;"
        );

        $this->query(
            "ALTER TABLE `sap_download`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;"
        );

        $this->query(
            "ALTER TABLE `sap_download_filtered`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;"
        );

        $this->query(
            "ALTER TABLE `sap_download_filtered_prospect`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;"
        );

        $this->query(
            "ALTER TABLE `sap_download_prospect`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;"
        );

        $this->query(
            "ALTER TABLE `sap_gmail_account_snapshot`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;"
        );

        $this->query(
            "ALTER TABLE `sap_gmail_account_stats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;"
        );

        $this->query(
            "ALTER TABLE `sap_gmail_events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;"
        );

        $this->query(
            "ALTER TABLE `sap_gmail_message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;"
        );

        $this->query(
            "ALTER TABLE `sap_gmail_retrain_queue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;"
        );

        $this->query(
            "ALTER TABLE `sap_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;"
        );

        $this->query(
            "ALTER TABLE `sap_group_title`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;"
        );

        $this->query(
            "ALTER TABLE `sap_group_title_negative`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;"
        );

        $this->query(
            "ALTER TABLE `sap_group_title_variation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;"
        );

        $this->query(
            "ALTER TABLE `sap_list_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;"
        );

        $this->query(
            "ALTER TABLE `sap_list_request_comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;"
        );

        $this->query(
            "ALTER TABLE `sap_list_request_prospect`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;"
        );

        $this->query(
            "ALTER TABLE `sap_outreach_prospect`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;"
        );

        $this->query(
            "ALTER TABLE `sap_outreach_prospect_event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;"
        );

        $this->query(
            "ALTER TABLE `sap_outreach_prospect_stage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;"
        );

        $this->query(
            "ALTER TABLE `sap_outreach_prospect_stage_v2`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;"
        );

        $this->query(
            "ALTER TABLE `sap_outreach_prospect_tag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;"
        );

        $this->query(
            "ALTER TABLE `sap_outreach_templates`
  MODIFY `id` bigint(11) NOT NULL AUTO_INCREMENT;"
        );

        $this->query(
            "ALTER TABLE `sap_outreach_updated_prospects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;"
        );

        $this->query(
            "ALTER TABLE `sap_prospect`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;"
        );

        $this->query(
            "ALTER TABLE `sap_prospect_city`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;"
        );

        $this->query(
            "ALTER TABLE `sap_prospect_company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;"
        );

        $this->query(
            "ALTER TABLE `sap_prospect_country`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;"
        );

        $this->query(
            "ALTER TABLE `sap_prospect_industry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;"
        );

        $this->query(
            "ALTER TABLE `sap_prospect_mailings`
  MODIFY `id` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;"
        );

        $this->query(
            "ALTER TABLE `sap_prospect_source`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;"
        );

        $this->query(
            "ALTER TABLE `sap_prospect_stage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;"
        );

        $this->query(
            "ALTER TABLE `sap_prospect_stage_v2`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;"
        );

        $this->query(
            "ALTER TABLE `sap_prospect_state`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;"
        );

        $this->query(
            "ALTER TABLE `sap_prospect_tag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;"
        );

        $this->query(
            "ALTER TABLE `sap_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;"
        );

        $this->query(
            "ALTER TABLE `sap_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;"
        );

        $this->query(
            "ALTER TABLE `sap_suppression`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;"
        );

        $this->query(
            "ALTER TABLE `sap_suppression_domain`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;"
        );

        $this->query(
            "ALTER TABLE `sap_survey`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;"
        );

        $this->query(
            "ALTER TABLE `sap_targeting_request_comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;"
        );

        $this->query(
            "ALTER TABLE `sap_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;"
        );

        $this->query(
            "ALTER TABLE `sap_client_account_gmail`
  ADD CONSTRAINT `sap_client_account_gmail_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `sap_client` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;"
        );

        $this->query(
            "ALTER TABLE `sap_client_account_outreach`
  ADD CONSTRAINT `foreign_client_id` FOREIGN KEY (`client_id`) REFERENCES `sap_client` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;"
        );

        $this->query(
            "ALTER TABLE `sap_client_dne`
  ADD CONSTRAINT `client_id` FOREIGN KEY (`client_id`) REFERENCES `sap_client` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;"
        );

        $this->query(
            "ALTER TABLE `sap_client_profile`
  ADD CONSTRAINT `sap_client_profile_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `sap_client` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;"
        );

        $this->query(
            "ALTER TABLE `sap_client_profile_department`
  ADD CONSTRAINT `sap_client_profile_department_ibfk_1` FOREIGN KEY (`client_profile_id`) REFERENCES `sap_client_profile` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sap_client_profile_department_ibfk_2` FOREIGN KEY (`department_id`) REFERENCES `sap_department` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;"
        );

        $this->query(
            "ALTER TABLE `sap_client_profile_title`
  ADD CONSTRAINT `sap_client_profile_title_ibfk_1` FOREIGN KEY (`client_profile_id`) REFERENCES `sap_client_profile` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sap_client_profile_title_ibfk_2` FOREIGN KEY (`title_id`) REFERENCES `sap_group_title` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;"
        );

        $this->query(
            "ALTER TABLE `sap_department_keyword`
  ADD CONSTRAINT `department_id` FOREIGN KEY (`department_id`) REFERENCES `sap_department` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;"
        );

        $this->query(
            "ALTER TABLE `sap_download`
  ADD CONSTRAINT `sap_download_ibfk_1` FOREIGN KEY (`list_request_id`) REFERENCES `sap_list_request` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;"
        );

        $this->query(
            "ALTER TABLE `sap_download_prospect`
  ADD CONSTRAINT `sap_download_prospect_ibfk_1` FOREIGN KEY (`download_id`) REFERENCES `sap_download` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sap_download_prospect_ibfk_2` FOREIGN KEY (`prospect_id`) REFERENCES `sap_prospect` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;"
        );

        $this->query(
            "ALTER TABLE `sap_gmail_events`
  ADD CONSTRAINT `sap_gmail_events_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `sap_client_account_gmail` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sap_gmail_events_ibfk_2` FOREIGN KEY (`prospect_id`) REFERENCES `sap_prospect` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;"
        );

        $this->query(
            "ALTER TABLE `sap_gmail_message`
  ADD CONSTRAINT `sap_gmail_message_ibfk_1` FOREIGN KEY (`gmail_account_id`) REFERENCES `sap_client_account_gmail` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sap_gmail_message_ibfk_2` FOREIGN KEY (`prospect_id`) REFERENCES `sap_prospect` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;"
        );

        $this->query(
            "ALTER TABLE `sap_gmail_retrain_queue`
  ADD CONSTRAINT `sap_gmail_retrain_queue_ibfk_1` FOREIGN KEY (`gmail_account_id`) REFERENCES `sap_client_account_gmail` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;"
        );

        $this->query(
            "ALTER TABLE `sap_group_title`
  ADD CONSTRAINT `group_id` FOREIGN KEY (`group_id`) REFERENCES `sap_group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;"
        );

        $this->query(
            "ALTER TABLE `sap_group_title_negative`
  ADD CONSTRAINT `group_title_id_negative` FOREIGN KEY (`group_title_id`) REFERENCES `sap_group_title` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;"
        );

        $this->query(
            "ALTER TABLE `sap_group_title_variation`
  ADD CONSTRAINT `group_title_id` FOREIGN KEY (`group_title_id`) REFERENCES `sap_group_title` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;"
        );

        $this->query(
            "ALTER TABLE `sap_list_request`
  ADD CONSTRAINT `sap_list_request_ibfk_1` FOREIGN KEY (`fulfilled_by`) REFERENCES `sap_user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `sap_list_request_ibfk_2` FOREIGN KEY (`closed_by`) REFERENCES `sap_user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `sap_list_request_ibfk_3` FOREIGN KEY (`assigned_to`) REFERENCES `sap_user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `sap_list_request_ibfk_4` FOREIGN KEY (`outreach_account_id`) REFERENCES `sap_client_account_outreach` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sap_list_request_ibfk_5` FOREIGN KEY (`created_by`) REFERENCES `sap_user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;"
        );

        $this->query(
            "ALTER TABLE `sap_list_request_comment`
  ADD CONSTRAINT `sap_list_request_comment_ibfk_1` FOREIGN KEY (`list_request_id`) REFERENCES `sap_list_request` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sap_list_request_comment_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `sap_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;"
        );

        $this->query(
            "ALTER TABLE `sap_list_request_prospect`
  ADD CONSTRAINT `sap_list_request_prospect_ibfk_1` FOREIGN KEY (`list_request_id`) REFERENCES `sap_list_request` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sap_list_request_prospect_ibfk_2` FOREIGN KEY (`prospect_id`) REFERENCES `sap_prospect` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;"
        );

        $this->query(
            "ALTER TABLE `sap_outreach_prospect`
  ADD CONSTRAINT `foreign_outreach_account_id` FOREIGN KEY (`outreach_account_id`) REFERENCES `sap_client_account_outreach` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `foreign_prospect_id` FOREIGN KEY (`prospect_id`) REFERENCES `sap_prospect` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;"
        );

        $this->query(
            "ALTER TABLE `sap_outreach_prospect_stage`
  ADD CONSTRAINT `outreach_prospect_id` FOREIGN KEY (`outreach_prospect_id`) REFERENCES `sap_outreach_prospect` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `stage_id` FOREIGN KEY (`stage_id`) REFERENCES `sap_prospect_stage` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;"
        );

        $this->query(
            "ALTER TABLE `sap_outreach_prospect_tag`
  ADD CONSTRAINT `foreign_outreach_prospect_id` FOREIGN KEY (`outreach_prospect_id`) REFERENCES `sap_outreach_prospect` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `foreign_tag_id` FOREIGN KEY (`tag_id`) REFERENCES `sap_prospect_tag` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;"
        );

        $this->query(
            "ALTER TABLE `sap_prospect`
  ADD CONSTRAINT `prospect_city_id` FOREIGN KEY (`city_id`) REFERENCES `sap_prospect_city` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `prospect_company_id` FOREIGN KEY (`company_id`) REFERENCES `sap_prospect_company` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `prospect_country_id` FOREIGN KEY (`country_id`) REFERENCES `sap_prospect_country` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `prospect_industry_id` FOREIGN KEY (`industry_id`) REFERENCES `sap_prospect_industry` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `prospect_source_id` FOREIGN KEY (`source_id`) REFERENCES `sap_prospect_source` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `prospect_state_id` FOREIGN KEY (`state_id`) REFERENCES `sap_prospect_state` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;"
        );

        $this->query(
            "ALTER TABLE `sap_suppression_domain`
  ADD CONSTRAINT `suppression_id` FOREIGN KEY (`suppression_id`) REFERENCES `sap_suppression` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;"
        );

        $this->query(
            "ALTER TABLE `sap_user`
  ADD CONSTRAINT `role_id` FOREIGN KEY (`role_id`) REFERENCES `sap_role` (`id`);"
        );
    }

    public function down()
    {

    }
}
