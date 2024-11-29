<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateProducts extends AbstractMigration
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
        $table = $this->table('products');
        $table->addColumn('name', 'string', [
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('description', 'text', [
            
            'null' => true,
        ]);

        $table->addColumn('price', 'decimal', ['precision' => 10, 'scale' => 2, 'null' => false]);

        $table->addColumn('stock_quantity', 'integer', [
            'null' => false,
        ]);
        
        $table->addColumn('status', 'string', ['limit' => 20, 'null' => false, 'default' => 'activo']);

        $table->addColumn('created', 'datetime', [
            'default' => 'CURRENT_TIMESTAMP',
            'null' => false,
        ]);
        $table->addColumn('modified', 'datetime', [
            'default' => 'CURRENT_TIMESTAMP',
            'null' => false,
        ]);
        $table->addIndex([
            'name',
        
            ], [
            'name' => 'UNIQUE_NAME',
            'unique' => true,
        ]);
        $table->create();
    }
}
