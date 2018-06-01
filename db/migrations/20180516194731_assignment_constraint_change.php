<?php


use Phinx\Migration\AbstractMigration;

class AssignmentConstraintChange extends AbstractMigration
{
    public function up()
    {
        $this->query(
            "ALTER TABLE `sap_client_assignment` DROP FOREIGN KEY `sap_client_assignment_ibfk_1`"
        );

        $this->query(
            "ALTER TABLE `sap_client_assignment` ADD CONSTRAINT `sap_client_assignment_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `sap_user`(`id`) ON DELETE CASCADE ON UPDATE CASCADE"
        );
    }

    public function down()
    {
    }
}
