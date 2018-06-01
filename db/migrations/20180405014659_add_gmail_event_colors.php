<?php


use Phinx\Migration\AbstractMigration;

class AddGmailEventColors extends AbstractMigration
{
    public function up()
    {
        $this->query(
            'ALTER TABLE `sap_gmail_events` ADD `event_color_id` INT NULL AFTER `event_id`,
            ADD INDEX (`event_color_id`);'
        );

        $this->query(
            'ALTER TABLE `sap_gmail_events` ADD CONSTRAINT `sap_gmail_events_ibfk_3` FOREIGN KEY (`event_color_id`)
            REFERENCES `sap_gmail_event_colors`(`id`) ON DELETE SET NULL ON UPDATE SET NULL;'
        );
    }

    public function down()
    {
        $this->query('ALTER TABLE `sap_gmail_events` DROP FOREIGN KEY `sap_gmail_events_ibfk_3`;');
        $this->query('ALTER TABLE `sap_gmail_events` DROP `event_color_id`;');
    }
}
