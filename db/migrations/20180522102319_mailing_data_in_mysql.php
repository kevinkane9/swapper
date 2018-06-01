<?php


use Phinx\Migration\AbstractMigration;

class MailingDataInMysql extends AbstractMigration
{
    public function up()
    {
        $this->query(
            "ALTER TABLE `sap_outreach_prospect`
              ADD `mailings_sync_status` VARCHAR(20) NOT NULL DEFAULT 'ready' AFTER `outreach_updated_at`,
              ADD `mailings_synced_until` VARCHAR(50) NULL DEFAULT NULL AFTER `mailings_sync_status`,
              ADD INDEX (`mailings_sync_status`)"
        );

        $this->query(
            "CREATE TABLE IF NOT EXISTS `sap_outreach_prospect_mailing` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `outreach_prospect_id` int(11) NOT NULL,
              `mailing_id` int(11) NOT NULL,
              `delivered_at` timestamp NOT NULL,
              `bounced` tinyint(1) NOT NULL,
              `template_id` int(11) NOT NULL,
              PRIMARY KEY (`id`),
              KEY `outreach_prospect_id` (`outreach_prospect_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8"
        );

        $this->query(
            "ALTER TABLE `sap_outreach_prospect_mailing`
              ADD CONSTRAINT `sap_outreach_prospect_mailing_ibfk_1` FOREIGN KEY (`outreach_prospect_id`) REFERENCES `sap_outreach_prospect` (`id`) ON DELETE CASCADE ON UPDATE CASCADE"
        );
    }

    public function down()
    {
        $this->query(
            'ALTER TABLE `sap_outreach_prospect`
              DROP `mailings_sync_status`,
              DROP `mailings_synced_until`'
        );

        $this->query(
            'ALTER TABLE sap_outreach_prospect_mailing DROP FOREIGN KEY sap_outreach_prospect_mailing_ibfk_1'
        );

        $this->query('DROP TABLE `sap_outreach_prospect_mailing`');
    }
}
