<?php


use Phinx\Migration\AbstractMigration;

class AddClientStatus extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        // sap_client and sap_client_history
        $this->table('sap_client')
            ->addColumn(
                'status',
                'string',
                [
                    'limit'=>40,
                    'after'=>'name',
                    'default'=>'active'
                ]
            )
            ->update();

        $this->table('sap_client_history')
            ->addColumn(
                'status',
                'string',
                [
                    'limit'=>40,
                    'after'=>'name',
                    'default'=>'active'
                ]
            )
            ->update();
    }
}
