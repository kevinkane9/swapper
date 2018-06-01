<?php


use Phinx\Migration\AbstractMigration;

class ProsperworksP2 extends AbstractMigration
{
    public function up()
    {
        $this->query(
            "CREATE TABLE IF NOT EXISTS `sap_client_prosperworks` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `prosperworks_ext_id` int(11) NOT NULL,
              `name` varchar(255) DEFAULT NULL,
              `street` varchar(255) DEFAULT NULL,
              `city` varchar(255) DEFAULT NULL,
              `state` varchar(255) DEFAULT NULL,
              `postal_code` varchar(100) DEFAULT NULL,
              `country` varchar(50) DEFAULT NULL,
              `company_revenue` varchar(80) DEFAULT NULL,
              `number_of_employees` varchar(80) DEFAULT NULL,
              `company_age` varchar(80) DEFAULT NULL,
              `industry` varchar(120) DEFAULT NULL,
              `last_meeting_booked` varchar(100) DEFAULT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8"
        );
    }

    public function down()
    {
        $this->query('DROP TABLE `sap_client_prosperworks`');
    }
}
