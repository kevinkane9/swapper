<?php


use Phinx\Migration\AbstractMigration;

class IncreaseGmailEventIdLength extends AbstractMigration
{
    public function up()
    {
        $this->query(
            "ALTER TABLE `sap_gmail_events` CHANGE `event_id` `event_id` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL"
        );
    }

    public function down()
    {
        $this->query(
            "ALTER TABLE `sap_gmail_events` CHANGE `event_id` `event_id` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL"
        );
    }
}
