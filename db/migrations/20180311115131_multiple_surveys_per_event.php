<?php


use Phinx\Migration\AbstractMigration;

class MultipleSurveysPerEvent extends AbstractMigration
{
    public function up()
    {
        $this->query('ALTER TABLE `sap_survey` DROP INDEX `event_id`, ADD INDEX `event_id` (`event_id`) USING BTREE;');
    }

    public function down()
    {
        $this->query('ALTER TABLE `sap_survey` DROP INDEX `event_id`, ADD UNIQUE `event_id` (`event_id`) USING BTREE;');
    }
}
