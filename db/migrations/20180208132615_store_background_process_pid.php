<?php


use Phinx\Migration\AbstractMigration;

class StoreBackgroundProcessPid extends AbstractMigration
{
    public function up()
    {
        $this->query(
            "ALTER TABLE `sap_background_job` ADD `pid` INT NULL DEFAULT NULL AFTER `id`"
        );
    }

    public function down()
    {
        $this->query(
            "ALTER TABLE `sap_background_job` DROP COLUMN `pid`"
        );
    }
}
