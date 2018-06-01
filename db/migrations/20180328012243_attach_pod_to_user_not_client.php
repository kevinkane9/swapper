<?php


use Phinx\Migration\AbstractMigration;

class AttachPodToUserNotClient extends AbstractMigration
{
    public function up()
    {
        $this->query(
            "ALTER TABLE `sap_user` ADD `pod_id` INT NULL 
             AFTER `last_name`, ADD INDEX (`pod_id`);"
        );

        $this->query(
            "ALTER TABLE `sap_user`
             ADD CONSTRAINT `sap_user_ibfk_1` FOREIGN KEY (`pod_id`)
             REFERENCES `sap_client_pod`(`id`) ON DELETE SET NULL ON UPDATE SET NULL;"
        );

        $this->query("UPDATE `sap_user` u 
                      LEFT JOIN `sap_client` c ON c.`user_id` = u.`id` AND c.`pod_id` IS NOT NULL AND c.`pod_id` <> ''
                      SET u.`pod_id` = c.`pod_id`;");

        $this->query("ALTER TABLE `sap_client` DROP FOREIGN KEY `sap_client_ibfk_1`;");
        $this->query("ALTER TABLE `sap_client` DROP COLUMN `pod_id`;");

        $this->query("RENAME TABLE `sap_client_pod` TO `sap_pod`;");
    }

    public function down()
    {

    }
}
