<?php


use Phinx\Migration\AbstractMigration;

class StoreConvertingTemplate extends AbstractMigration
{
    public function up()
    {
        $this->query(
            'ALTER TABLE `sap_gmail_events` ADD `template_id` INT NULL DEFAULT NULL AFTER `has_valid_recipient`'
        );
    }

    public function down()
    {
        $this->query('ALTER TABLE sap_gmail_events DROP COLUMN `template_id`');
    }
}
