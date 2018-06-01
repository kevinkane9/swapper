<?php


use Phinx\Migration\AbstractMigration;

class IncreaseFilenameLengths extends AbstractMigration
{
    public function up()
    {
        // sap_download.filename
        $this->query(
            "ALTER TABLE `sap_download` CHANGE `filename` `filename` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL"
        );

        // sap_download.filtered
        $this->query(
            "ALTER TABLE `sap_download` CHANGE `filtered` `filtered` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL"
        );

        // sap_download.purged
        $this->query(
            "ALTER TABLE `sap_download` CHANGE `purged` `purged` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL"
        );

        // sap_download_filtered.filename
        $this->query(
            "ALTER TABLE `sap_download_filtered` CHANGE `filename` `filename` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL"
        );

        // sap_download_filtered.nidb
        $this->query(
            "ALTER TABLE `sap_download_filtered` CHANGE `nidb` `nidb` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL"
        );

        // sap_download_filtered.idbnor
        $this->query(
            "ALTER TABLE `sap_download_filtered` CHANGE `idbnor` `idbnor` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL"
        );

        // sap_download_filtered.filtered
        $this->query(
            "ALTER TABLE `sap_download_filtered` CHANGE `filtered` `filtered` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL"
        );

        // sap_download_filtered.purged
        $this->query(
            "ALTER TABLE `sap_download_filtered` CHANGE `purged` `purged` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL"
        );

        // sap_download_filtered.client_name
        $this->query(
            "ALTER TABLE `sap_download_filtered` CHANGE `client_name` `client_name` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL"
        );
    }

    public function down()
    {
        // sap_download.filename
        $this->query(
            "ALTER TABLE `sap_download` CHANGE `filename` `filename` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL"
        );

        // sap_download.filtered
        $this->query(
            "ALTER TABLE `sap_download` CHANGE `filtered` `filtered` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL"
        );

        // sap_download.purged
        $this->query(
            "ALTER TABLE `sap_download` CHANGE `purged` `purged` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL"
        );

        // sap_download_filtered.filename
        $this->query(
            "ALTER TABLE `sap_download_filtered` CHANGE `filename` `filename` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL"
        );

        // sap_download_filtered.nidb
        $this->query(
            "ALTER TABLE `sap_download_filtered` CHANGE `nidb` `nidb` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL"
        );

        // sap_download_filtered.idbnor
        $this->query(
            "ALTER TABLE `sap_download_filtered` CHANGE `idbnor` `idbnor` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL"
        );

        // sap_download_filtered.filtered
        $this->query(
            "ALTER TABLE `sap_download_filtered` CHANGE `filtered` `filtered` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL"
        );

        // sap_download_filtered.purged
        $this->query(
            "ALTER TABLE `sap_download_filtered` CHANGE `purged` `purged` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL"
        );

        // sap_download_filtered.client_name
        $this->query(
            "ALTER TABLE `sap_download_filtered` CHANGE `client_name` `client_name` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL"
        );
    }
}
