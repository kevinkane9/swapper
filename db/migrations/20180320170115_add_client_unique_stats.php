<?php

use Phinx\Migration\AbstractMigration;

class AddClientUniqueStats extends AbstractMigration
{
    public function up()
    {
        $this->query("ALTER TABLE `sap_client_stats` ADD `outbound_messages_unique` INT NOT NULL AFTER `outbound_messages`");
        $this->query("ALTER TABLE `sap_client_stats` ADD `bounced_messages_unique` INT NOT NULL AFTER `bounced_messages`");
    }

    public function down()
    {
        $this->query("ALTER TABLE `sap_client_stats` DROP COLUMN `outbound_messages_unique`");
        $this->query("ALTER TABLE `sap_client_stats` DROP COLUMN `bounced_messages_unique`");
    }
}
