<?php


use Phinx\Migration\AbstractMigration;

class ImproveCsmAndPod extends AbstractMigration
{
    public function up()
    {
        $this->query(
            "CREATE TABLE `sap_client_pod_new` (
              `id` int(11) NOT NULL,
              `name` varchar(80) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
        );

        $this->query(
            "ALTER TABLE `sap_client_pod_new`
             ADD PRIMARY KEY (`id`),
             ADD UNIQUE KEY `name` (`name`);"
        );

        $this->query(
            "ALTER TABLE `sap_client_pod_new`
             MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;"
        );

        $this->query(
            "CREATE TABLE `sap_client_assignment` (
              `id` int(11) NOT NULL,
              `user_id` int(11) NOT NULL,
              `client_id` int(11) NOT NULL,
              `starts_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
              `ends_at` timestamp NULL DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
        );

        $this->query(
            "ALTER TABLE `sap_client_assignment`
             ADD PRIMARY KEY (`id`),
             ADD KEY `user_id` (`user_id`),
             ADD KEY `client_id` (`client_id`);"
        );

        $this->query(
            "ALTER TABLE `sap_client_assignment`
             MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;"
        );

        $this->query(
            "ALTER TABLE `sap_client_assignment`
             ADD CONSTRAINT `sap_client_assignment_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `sap_user` (`id`),
             ADD CONSTRAINT `sap_client_assignment_ibfk_2` FOREIGN KEY (`client_id`) REFERENCES `sap_client` (`id`);"
        );

        $this->query(
            "ALTER TABLE `sap_client` ADD `pod_id` INT NULL 
             AFTER `name`, ADD INDEX (`pod_id`);"
        );

        $this->query(
            "ALTER TABLE `sap_client` ADD `user_id` INT NULL 
             AFTER `pod_id`, ADD INDEX (`user_id`);"
        );

        $this->query(
            "ALTER TABLE `sap_client`
             ADD CONSTRAINT `sap_client_ibfk_1` FOREIGN KEY (`pod_id`)
             REFERENCES `sap_client_pod_new`(`id`) ON DELETE SET NULL ON UPDATE SET NULL;"
        );

        $this->query(
            "ALTER TABLE `sap_client`
             ADD CONSTRAINT `sap_client_ibfk_2` FOREIGN KEY (`user_id`)
             REFERENCES `sap_user`(`id`) ON DELETE SET NULL ON UPDATE SET NULL;"
        );

        $this->query("INSERT INTO `sap_client_pod_new` (`name`)
                      SELECT `pod` from `sap_client_pod` where `pod` IS NOT NULL and `pod` <> '';");

        $this->query("UPDATE `sap_client` cl 
                      LEFT JOIN `sap_client_pod` p ON p.`client_id` = cl.`id`
                      LEFT JOIN `sap_user` u ON CONCAT(u.`first_name`, ' ', u.`last_name`) = p.`client_strategist`
                      LEFT JOIN `sap_client_pod_new` pn ON pn.`name` = p.`pod`
                      SET cl.`pod_id` = pn.`id`, cl.`user_id` = u.`id`;");

        $this->query("INSERT INTO `sap_client_assignment` (`client_id`, `user_id`, `starts_at`)
                      SELECT `id`, `user_id`, `created_at` from `sap_client` where `user_id` IS NOT NULL;");

        $this->query("DROP TABLE `sap_client_pod`");

        $this->query("RENAME TABLE `sap_client_pod_new` TO `sap_client_pod`;");
    }

    public function down()
    {

    }
}
