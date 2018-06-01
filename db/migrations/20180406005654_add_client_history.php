<?php


use Phinx\Migration\AbstractMigration;

class AddClientHistory extends AbstractMigration
{
    public function up()
    {
        $this->query("UPDATE `sap_client` SET `contract_goal` = NULL WHERE `contract_goal` = ''");

        $this->query('ALTER TABLE `sap_client` CHANGE `contract_goal` `contract_goal` INT NULL DEFAULT NULL;');

        $this->query('ALTER TABLE `sap_client` ADD `monthly_goal` INT NULL AFTER `contract_goal`;');

        $this->query(
            'CREATE TABLE `sap_client_history` (
              `id` int(11) NOT NULL,
              `client_id` int(11) DEFAULT NULL,
              `name` varchar(80) NOT NULL,
              `sign_on_date` date DEFAULT NULL,
              `launch_date` date DEFAULT NULL,
              `expiration_date` date DEFAULT NULL,
              `contract_goal` int(11) DEFAULT NULL,
              `monthly_goal` int(11) DEFAULT NULL,
              `target_profiles_summary` text,
              `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;'
        );

        $this->query(
            'ALTER TABLE `sap_client_history`
            ADD PRIMARY KEY (`id`),
            ADD KEY `client_id` (`client_id`);'
        );

        $this->query('ALTER TABLE `sap_client_history` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;');

        $this->query(
            'ALTER TABLE `sap_client_history` ADD CONSTRAINT `sap_client_history_ibfk_1` FOREIGN KEY (`client_id`)
            REFERENCES `sap_client` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;'
        );

        $this->query(
            'INSERT INTO `sap_client_history`
            (`client_id`, `name`, `sign_on_date`, `launch_date`, `expiration_date`, `contract_goal`, `monthly_goal`, `target_profiles_summary`, `updated_at`)
            SELECT `id`, `name`, `sign_on_date`, `launch_date`, `expiration_date`, `contract_goal`, `monthly_goal`, `target_profiles_summary`, `created_at` FROM sap_client``'
        );
    }

    public function down()
    {
        $this->query('DROP TABLE `sap_client_history`');

        $this->query('ALTER TABLE `sap_client` DROP `monthly_goal`;');

        $this->query('ALTER TABLE `sap_client` CHANGE `contract_goal` `contract_goal` VARCHAR(255) NULL DEFAULT NULL;');
    }
}
