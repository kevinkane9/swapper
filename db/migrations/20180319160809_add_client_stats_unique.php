<?php

use Phinx\Migration\AbstractMigration;

class AddClientStatsUnique extends AbstractMigration
{
    public function up()
    {
        $this->query("ALTER TABLE `sap_client_stats` ADD UNIQUE `client_date_calculated` (`client_id`, `date_calculated`)");
    }

    public function down()
    {
        $this->query("ALTER TABLE `sap_client_stats` DROP INDEX `client_date_calculated`");
    }
}
