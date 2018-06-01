<?php

use Phinx\Migration\AbstractMigration;

class AddClientStats extends AbstractMigration
{
    public function up()
    {
        $this->query("ALTER TABLE `sap_outreach_prospect_event` ADD `client_id` INT NULL DEFAULT NULL AFTER `outreach_prospect_id`");
        $this->query("ALTER TABLE `sap_outreach_prospect_event` ADD INDEX `action_occurred_index` (`action`, `occurred_at`)");

        $this->query(
            "CREATE TABLE IF NOT EXISTS `sap_client_stats` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `client_id` int(11) NOT NULL,
              `accepted_meetings` smallint(6) NOT NULL,
              `outbound_messages` int(11) NOT NULL,
              `bounced_messages` int(11) NOT NULL,
              `mcr` decimal(8,2) NOT NULL,
              `ppm` decimal(8,2) NOT NULL,
              `date_calculated` date NOT NULL,
              PRIMARY KEY (`id`),
              KEY `client_id` (`client_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1;"
        );

        $this->query(
            "ALTER TABLE `sap_client_stats` ADD CONSTRAINT `sap_client_stats_ibfk_1`
              FOREIGN KEY (`client_id`) REFERENCES `sap_client` (`id`) ON DELETE CASCADE ON UPDATE CASCADE"
        );
    }

    public function down()
    {
        $this->query("ALTER TABLE `sap_outreach_prospect_event` DROP `client_id`");
        $this->query("ALTER TABLE `sap_outreach_prospect_event` DROP INDEX `action_occurred_index`");
        $this->query("DROP TABLE `sap_client_stats`");
    }
}
