<?php

use Phinx\Migration\AbstractMigration;

class AddProsperworksIdToClient extends AbstractMigration
{
    public function change()
    {
        $this->table('sap_client')
            ->addColumn(
                'prosperworks_id',
                'integer',
                [
                    'null' => true,
                    'after' => 'user_id'
                ]
            )
            ->update();
    }
}
