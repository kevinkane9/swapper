<?php


use Phinx\Migration\AbstractMigration;

class MysqlDbCleanup extends AbstractMigration
{
    public function up()
    {
        // sap_client_comments
        $this->query('DROP TABLE `sap_client_comments`');

        // sap_client_health_score
        $this->query('ALTER TABLE `sap_client_health_score` ADD INDEX `client_id` (`client_id`)');
        $this->query('ALTER TABLE `sap_client_health_score` ADD INDEX `gmail_account_id` (`gmail_account_id`)');
        $this->query(
            'DELETE hs FROM `sap_client_health_score` hs
            LEFT JOIN `sap_client` c ON hs.`client_id` = c.`id`
            WHERE c.`id` IS NULL'
        );
        $this->query(
            'DELETE hs FROM `sap_client_health_score` hs
            LEFT JOIN `sap_client_account_gmail` g ON hs.`gmail_account_id` = g.`id`
            WHERE g.`id` IS NULL'
        );
        $this->query(
            'UPDATE `sap_client_health_score` set `notification_email_sent_on` = null'
        );
        $this->query(
            'ALTER TABLE `sap_client_health_score`
            ADD FOREIGN KEY (`client_id`) REFERENCES `sap_client`(`id`) ON DELETE CASCADE ON UPDATE CASCADE'
        );
        $this->query(
            'ALTER TABLE `sap_client_health_score`
            ADD FOREIGN KEY (`gmail_account_id`) REFERENCES `sap_client_account_gmail`(`id`) ON DELETE CASCADE ON UPDATE CASCADE'
        );

        // sap_client_meetings_per_month
        $this->query(
            'ALTER TABLE `sap_client_meetings_per_month` ADD `id` INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (`id`)'
        );
        $this->query(
            'ALTER TABLE `sap_client_meetings_per_month` ADD INDEX `client_id` (`client_id`)'
        );
        $this->query(
            'DELETE m FROM `sap_client_meetings_per_month` m
            LEFT JOIN `sap_client` c ON m.`client_id` = c.`id`
            WHERE c.`id` IS NULL'
        );
        $this->query(
            'ALTER TABLE `sap_client_meetings_per_month`
            ADD FOREIGN KEY (`client_id`) REFERENCES `sap_client`(`id`) ON DELETE CASCADE ON UPDATE CASCADE'
        );

        // sap_client_targeting_profiles
        $this->query(
            'ALTER TABLE `sap_client_targeting_profiles` CHANGE `profile_id` `id` INT(11) NOT NULL AUTO_INCREMENT'
        );
        $this->query(
            'DELETE tp FROM `sap_client_targeting_profiles` tp
            LEFT JOIN `sap_client` c ON tp.`client_id` = c.`id`
            WHERE c.`id` IS NULL'
        );
        $this->query(
            'ALTER TABLE `sap_client_targeting_profiles`
            ADD FOREIGN KEY (`client_id`) REFERENCES `sap_client`(`id`) ON DELETE CASCADE ON UPDATE CASCADE'
        );
        $this->query(
            'DELETE tp FROM `sap_client_targeting_profiles` tp
            LEFT JOIN `sap_user` u ON tp.`created_by` = u.`id`
            WHERE u.`id` IS NULL'
        );
        $this->query(
            'ALTER TABLE `sap_client_targeting_profiles`
            ADD FOREIGN KEY (`created_by`) REFERENCES `sap_user`(`id`) ON DELETE CASCADE ON UPDATE CASCADE'
        );

        // sap_download_filtered
        $this->query(
            'DELETE df FROM `sap_download_filtered` df
            LEFT JOIN `sap_list_request` r ON df.`list_request_id` = r.`id`
            WHERE r.`id` IS NULL'
        );
        $this->query(
            'ALTER TABLE `sap_download_filtered`
            ADD FOREIGN KEY (`list_request_id`) REFERENCES `sap_list_request`(`id`) ON DELETE CASCADE ON UPDATE CASCADE'
        );
        $this->query(
            'DELETE df FROM `sap_download_filtered` df
            LEFT JOIN `sap_client` c ON df.`client_id` = c.`id`
            WHERE c.`id` IS NULL'
        );
        $this->query(
            'ALTER TABLE `sap_download_filtered`
            ADD FOREIGN KEY (`client_id`) REFERENCES `sap_client`(`id`) ON DELETE CASCADE ON UPDATE CASCADE'
        );

        // sap_download_filtered_prospect
        $this->query(
            'DELETE fp FROM `sap_download_filtered_prospect` fp
            LEFT JOIN `sap_download_filtered` df ON fp.`download_id` = df.`id`
            WHERE df.`id` IS NULL'
        );
        $this->query(
            'ALTER TABLE `sap_download_filtered_prospect`
            ADD FOREIGN KEY (`download_id`) REFERENCES `sap_download_filtered`(`id`) ON DELETE CASCADE ON UPDATE CASCADE'
        );
        $this->query(
            'DELETE fp FROM `sap_download_filtered_prospect` fp
            LEFT JOIN `sap_prospect` p ON fp.`prospect_id` = p.`id`
            WHERE p.`id` IS NULL'
        );
        $this->query(
            'ALTER TABLE `sap_download_filtered_prospect`
            ADD FOREIGN KEY (`prospect_id`) REFERENCES `sap_prospect`(`id`) ON DELETE CASCADE ON UPDATE CASCADE'
        );

        // sap_gmail_account_snapshot
        $this->query(
            'DELETE s FROM `sap_gmail_account_snapshot` s
            LEFT JOIN `sap_client_account_gmail` g ON s.`gmail_account_id` = g.`id`
            WHERE g.`id` IS NULL'
        );
        $this->query(
            'ALTER TABLE `sap_gmail_account_snapshot`
            ADD FOREIGN KEY (`gmail_account_id`) REFERENCES `sap_client_account_gmail`(`id`) ON DELETE CASCADE ON UPDATE CASCADE'
        );

        // sap_gmail_account_stats
        $this->query(
            'DELETE s FROM `sap_gmail_account_stats` s
            LEFT JOIN `sap_client_account_gmail` g ON s.`gmail_account_id` = g.`id`
            WHERE g.`id` IS NULL'
        );
        $this->query(
            'ALTER TABLE `sap_gmail_account_stats`
            ADD FOREIGN KEY (`gmail_account_id`) REFERENCES `sap_client_account_gmail`(`id`) ON DELETE CASCADE ON UPDATE CASCADE'
        );

        // sap_outreach_prospect_stage_v2
        $this->query(
            'DELETE s FROM `sap_outreach_prospect_stage_v2` s
            LEFT JOIN `sap_outreach_prospect` p ON s.`outreach_prospect_id` = p.`id`
            WHERE p.`id` IS NULL'
        );
        $this->query(
            'ALTER TABLE `sap_outreach_prospect_stage_v2`
            ADD FOREIGN KEY (`outreach_prospect_id`) REFERENCES `sap_outreach_prospect`(`id`) ON DELETE CASCADE ON UPDATE CASCADE'
        );

        // sap_outreach_templates
        $this->query('DROP TABLE `sap_outreach_templates`');

        // sap_outreach_updated_prospects
        $this->query(
            'DELETE up FROM `sap_outreach_updated_prospects` up
            LEFT JOIN `sap_client` c ON up.`client_id` = c.`id`
            WHERE c.`id` IS NULL'
        );
        $this->query(
            'ALTER TABLE `sap_outreach_updated_prospects`
            ADD FOREIGN KEY (`client_id`) REFERENCES `sap_client`(`id`) ON DELETE CASCADE ON UPDATE CASCADE'
        );
        $this->query(
            'DELETE up FROM `sap_outreach_updated_prospects` up
            LEFT JOIN `sap_client_account_outreach` a ON up.`outreach_account_id` = a.`id`
            WHERE a.`id` IS NULL'
        );
        $this->query(
            'ALTER TABLE `sap_outreach_updated_prospects`
            ADD FOREIGN KEY (`outreach_account_id`) REFERENCES `sap_client_account_outreach`(`id`) ON DELETE CASCADE ON UPDATE CASCADE'
        );

        // sap_prospect_mailings
        $this->query('DROP TABLE `sap_prospect_mailings`');

        // sap_targeting_request_comment
        $this->query(
            'DELETE rc FROM `sap_targeting_request_comment` rc
            LEFT JOIN `sap_list_request` r ON rc.`list_request_id` = r.`id`
            WHERE r.`id` IS NULL'
        );
        $this->query(
            'ALTER TABLE `sap_targeting_request_comment`
            ADD FOREIGN KEY (`list_request_id`) REFERENCES `sap_list_request`(`id`) ON DELETE CASCADE ON UPDATE CASCADE'
        );
    }

    public function down()
    {

    }
}
