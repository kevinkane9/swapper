<?php


use Phinx\Migration\AbstractMigration;

class StoreReplyTimestamps extends AbstractMigration
{
    public function up()
    {
        $this->query(
            'ALTER TABLE `sap_outreach_prospect_mailing`
              ADD `replied_at` TIMESTAMP NULL DEFAULT NULL AFTER `delivered_at`,
              ADD `response_time_days` FLOAT NULL DEFAULT NULL AFTER `replied_at`'
        );
    }

    public function down()
    {
        $this->query(
            'ALTER TABLE `sap_outreach_prospect_mailing` DROP COLUMN `replied_at`, DROP COLUMN `response_time_days`'
        );
    }
}
