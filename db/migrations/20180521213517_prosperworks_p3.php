<?php


use Phinx\Migration\AbstractMigration;

class ProsperworksP3 extends AbstractMigration
{
    public function up()
    {
        $this->query(
            "ALTER TABLE `sap_client`
              ADD FOREIGN KEY (`prosperworks_id`) REFERENCES `sap_client_prosperworks`(`id`) ON DELETE SET NULL ON UPDATE SET NULL;"
        );
    }

    public function down()
    {
        $this->query('ALTER TABLE sap_client DROP FOREIGN KEY sap_client_ibfk_3');
    }
}
