<?php


use Phinx\Migration\AbstractMigration;

class AddGmailCalendarColorDefinitions extends AbstractMigration
{
    public function up()
    {
        $this->query(
            "CREATE TABLE `sap_gmail_event_colors` (
              `id` int(11) NOT NULL,
              `gmail_account_id` int(11) NOT NULL,
              `type` enum('calendar','event') NOT NULL,
              `color_key` varchar(50) NOT NULL,
              `background_color` varchar(10) NOT NULL,
              `foreground_color` varchar(10) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
        );

        $this->query(
            'ALTER TABLE `sap_gmail_event_colors`
              ADD PRIMARY KEY (`id`),
              ADD UNIQUE KEY `gmail_event_colors_unique_set` (`gmail_account_id`,`type`,`color_key`) USING BTREE,
              ADD KEY `gmail_account_id` (`gmail_account_id`);'
        );

        $this->query('ALTER TABLE `sap_gmail_event_colors` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;');

        $this->query(
            'ALTER TABLE `sap_gmail_event_colors`
            ADD CONSTRAINT `sap_gmail_event_colors_ibfk_1` FOREIGN KEY (`gmail_account_id`) 
            REFERENCES `sap_client_account_gmail` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;'
        );

        $this->query(
            'ALTER TABLE `sap_client_account_gmail`
            ADD `default_color_id` INT NULL AFTER `label_id_out_of_office`, ADD INDEX (`default_color_id`);'
        );

        $this->query(
            'ALTER TABLE `sap_client_account_gmail`
            ADD CONSTRAINT `sap_client_account_gmail_ibfk_2` FOREIGN KEY (`default_color_id`)
            REFERENCES `sap_gmail_event_colors`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;'
        );
    }

    public function down()
    {
        $this->query('ALTER TABLE `sap_client_account_gmail` DROP FOREIGN KEY `sap_client_account_gmail_ibfk_2`;');

        $this->query('ALTER TABLE `sap_client_account_gmail` DROP `default_color_id`;');

        $this->query('DROP TABLE `sap_gmail_event_colors`');
    }
}
