<?php

use Phinx\Migration\AbstractMigration;

class RepairIncorrectIndustries extends AbstractMigration
{
    public function up()
    {
        $this->insert(
            'sap_prospect_industry_condensed',
            ['name' => 'Religious Institution']
        );

        $match = $this->fetchRow(
            'SELECT * FROM `sap_prospect_industry_condensed` WHERE `name` = "Religious Institution"'
        );

        $this->insert(
            'sap_prospect_industry',
            [
                'name' => 'Religious Institution',
                'condensed_id' => $match['id']
            ]
        );

        $match = $this->fetchRow('SELECT * FROM `sap_prospect_industry` WHERE `condensed_id` = '. $match['id']);

        $updates = [
            'matt.litchfield@jdnorman.com'   => 463,
            'mben@taverm.com'                => 57,
            'bfassett@mccormick.edu'         => $match['id'],
            'jharlander@fmh-corp.com'        => 79,
            'kim@print-partners.com'         => 428,
            'matt.sorenson@payrollvault.com' => 60
        ];

        foreach ($updates as $email => $industryId) {
            $this->query(
                sprintf(
                    "UPDATE `sap_prospect` SET `industry_id` = %d WHERE `email` = '%s'",
                    $industryId,
                    $email
                )
            );
        }
    }

    public function down()
    {
    }
}
