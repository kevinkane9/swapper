<?php


use Phinx\Migration\AbstractMigration;

class OutreachV2MongoSync extends AbstractMigration
{
    public function up()
    {
        $this->query(
            "ALTER TABLE `sap_client_account_outreach` ADD `status_v2` VARCHAR(20) NOT NULL DEFAULT 'disconnected' AFTER `status`"
        );

        $this->query(
            "ALTER TABLE `sap_client_account_outreach` ADD `last_pulled_at_v2` TIMESTAMP NULL DEFAULT NULL AFTER `last_pulled_at`"
        );

        $this->query('UPDATE `sap_client_account_outreach` SET `status_v2` = `status`');
        $this->query('UPDATE `sap_client_account_outreach` SET `status_v2` = "connected" WHERE `status_v2` = "syncing"');
    }

    public function down()
    {
        $this->query('ALTER TABLE `sap_client_account_outreach` DROP `status_v2`');
        $this->query('ALTER TABLE `sap_client_account_outreach` DROP `last_pulled_at_v2`');
    }
}
