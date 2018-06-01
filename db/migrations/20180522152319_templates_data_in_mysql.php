<?php


use Phinx\Migration\AbstractMigration;

class TemplatesDataInMysql extends AbstractMigration
{
    public function up()
    {
        $this->query(
            'CREATE TABLE `sap_outreach_template` (
              `id` INT NOT NULL AUTO_INCREMENT,
              `outreach_account_id` INT NOT NULL,
              `template_id` INT NOT NULL,
              `synced` TINYINT(1) NOT NULL DEFAULT \'0\',
              `body_html` LONGTEXT NULL,
              `body_text` LONGTEXT NULL,
              `last_used_at` TIMESTAMP NULL,
              `subject` VARCHAR(255) NULL,
              PRIMARY KEY (`id`),
              INDEX `outreach_account_id` (`outreach_account_id`),
              INDEX `synced` (`synced`)) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;'
        );

       $this->query("ALTER TABLE `sap_outreach_template`
            ADD CONSTRAINT `sap_outreach_template_ibfk_1` FOREIGN KEY (`outreach_account_id`) REFERENCES `sap_client_account_outreach` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;"
        );

        $this->query(
            "INSERT INTO `sap_outreach_template` (`outreach_account_id`, `template_id`)
                  SELECT p.`outreach_account_id`, m.`template_id`
                    FROM `sap_outreach_prospect_mailing` m
               LEFT JOIN `sap_outreach_prospect` p ON m.`outreach_prospect_id` = p.`id`
                GROUP BY p.`outreach_account_id`, m.`template_id`"
        );
    }

    public function down()
    {
        $this->query('ALTER TABLE sap_outreach_template DROP FOREIGN KEY sap_outreach_template_ibfk_1');
        $this->query('DROP TABLE `sap_outreach_template`');
    }
}
