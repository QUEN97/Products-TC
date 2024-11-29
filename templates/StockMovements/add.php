<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\StockMovement $stockmovement
 */
?>
<div class="flex flex-wrap mt-6">
    <!-- Navegación lateral -->
    <aside class="w-full sm:w-1/4 lg:w-1/5 p-4">
        <div class="bg-white p-4 rounded-md shadow-md">
            <h4 class="text-xl font-semibold text-gray-700"><?= __('Opciones') ?></h4>
            <?= $this->Html->link(__('Volver al listado de productos'), ['controller' => 'Products', 'action' => 'index'], ['class' => 'text-indigo-600 hover:text-indigo-800 mt-4 block']) ?>
        </div>
    </aside>

    <div class="w-full sm:w-3/4 lg:w-4/5 p-4">
        <div class="bg-white p-6 rounded-md shadow-md">
            <?= $this->Form->create($stockMovement, ['url' => ['controller' => 'StockMovements', 'action' => 'add', $product->id]]) ?>
            <div class="flex flex-col gap-4 mb-6">
                <!-- Producto -->
                <div class="flex flex-col sm:w-1/2">
                    <label for="product_id" class="block text-sm font-medium text-gray-700"><?= __('Producto') ?></label>
                    <input type="text" value="<?= h($product->name) ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" disabled>
                    <?= $this->Form->hidden('product_id', ['value' => $product->id]) ?>
                </div>

                <!-- Stock Actual -->
                <div class="flex flex-col sm:w-1/2">
                    <label for="current_stock" class="block text-sm font-medium text-gray-700"><?= __('Stock Actual') ?></label>
                    <input type="text" value="<?= h($product->stock_quantity) ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" disabled>
                </div>

                <!-- Cantidad Cambiada -->
                <div class="flex flex-col sm:w-1/2">
                    <label for="quantity_changed" class="block text-sm font-medium text-gray-700"><?= __('Cantidad Cambiada') ?></label>
                    <?= $this->Form->input('quantity_changed', [
                        'type' => 'number',
                        'min' => -9999, // Permitir cantidades negativas
                        'class' => 'mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500',
                        'required' => true,
                        'placeholder' => __('Ingrese un valor positivo para agregar stock, o negativo para quitar stock')
                    ]) ?>
                </div>

                <!-- Motivo -->
                <div class="flex flex-col sm:w-1/2">
                    <label for="reason" class="block text-sm font-medium text-gray-700"><?= __('Motivo') ?> <small>(Opcional)</small></label>
                    <?= $this->Form->textarea('reason', [
                        'class' => 'mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500',
                        'rows' => 3
                    ]) ?>
                </div>

                <!-- Botón Enviar -->
                <div>
                    <?= $this->Form->button(__('Registrar Movimiento'), ['class' => 'bg-gray-700 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition']) ?>
                </div>
            </div>
        </div>
    </div>

    <?= $this->Form->end() ?>
</div>
