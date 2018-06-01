<?php


use Phinx\Migration\AbstractMigration;

class AddEventsWithoutValidRecipients extends AbstractMigration
{
    public function up()
    {
        $this->query("ALTER TABLE `sap_gmail_events` ADD `has_valid_recipient` TINYINT(1) NOT NULL DEFAULT '0' AFTER `prospect_id`;");
        $this->query('UPDATE `sap_gmail_events` SET `has_valid_recipient` = 1;');
    }

    public function down()
    {
        $this->query('ALTER TABLE `sap_gmail_events` DROP `has_valid_recipient`;');
    }
}
