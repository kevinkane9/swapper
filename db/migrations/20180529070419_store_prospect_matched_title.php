<?php


use Phinx\Migration\AbstractMigration;

class StoreProspectMatchedTitle extends AbstractMigration
{
    public function up()
    {
        $this->query(
            'ALTER TABLE `sap_prospect`
             ADD `group_title_id` INT NULL DEFAULT NULL AFTER `stage_id`,
             ADD INDEX `group_title_id` (`group_title_id`)'
        );

        $this->query(
            'UPDATE `sap_prospect` SET `outreach_created_at` = NULL where CAST(`outreach_created_at` AS CHAR(20)) = "0000-00-00 00:00:00"'
        );

        $this->query(
            'UPDATE `sap_prospect` SET `outreach_optedout_at` = NULL where CAST(`outreach_optedout_at` AS CHAR(20)) = "0000-00-00 00:00:00"'
        );

        $this->query(
            'UPDATE `sap_prospect` SET `outreach_updated_at` = NULL where CAST(`outreach_updated_at` AS CHAR(20)) = "0000-00-00 00:00:00"'
        );

        $this->query(
            'ALTER TABLE `sap_prospect`
             ADD CONSTRAINT `prospect_group_title_id` FOREIGN KEY (`group_title_id`) REFERENCES `sap_group_title`(`id`) ON DELETE SET NULL ON UPDATE SET NULL'
        );
    }

    public function down()
    {
        $this->query('ALTER TABLE `sap_prospect` DROP FOREIGN KEY `prospect_group_title_id`');
        $this->query('ALTER TABLE `sap_prospect` DROP COLUMN `group_title_id`');
    }
}
