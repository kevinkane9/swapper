<?php


use Phinx\Migration\AbstractMigration;

class ExceptionNotifications extends AbstractMigration
{
    public function up()
    {
        $settingsData = $this->fetchRow('SELECT * FROM `sap_settings` WHERE `id` = 1');
        $settings     = json_decode($settingsData['settings'], true);
        
        $settings['exception-notifications'] = 1;

        $this->query(
            sprintf(
                "UPDATE `sap_settings` SET `settings` = '%s' WHERE `id` = 1",
                json_encode($settings, JSON_UNESCAPED_SLASHES)
            )
        );
    }

    public function down()
    {

    }
}
