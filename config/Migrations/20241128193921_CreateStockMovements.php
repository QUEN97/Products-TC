<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateStockMovements extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function change(): void
    {
        $table = $this->table('stock_movements');
        $table->addColumn('product_id', 'integer')
              ->addColumn('quantity_changed', 'integer')
              ->addColumn('reason', 'text', ['null' => true])
              ->addColumn('created', 'datetime')
              ->addForeignKey('product_id', 'products', 'id', ['delete'=> 'CASCADE', 'update'=> 'CASCADE'])
              ->create();
    }
}
