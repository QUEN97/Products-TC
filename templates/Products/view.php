<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product $product
 */
?>
<div class="flex flex-wrap mt-6">
    <!-- Navegación lateral -->
    <aside class="w-full sm:w-1/4 lg:w-1/5 p-4">
        <div class="bg-white p-4 rounded-md shadow-md">
            <h4 class="text-xl font-semibold text-gray-700"><?= __('Opciones') ?></h4>
            <?= $this->Html->link(__('Editar Producto'), ['action' => 'edit', $product->id], ['class' => 'text-blue-600 hover:text-blue-800 mt-4 block']) ?>
            <?= $this->Form->postLink(__('Eliminar Producto'), ['action' => 'delete', $product->id], [
                'confirm' => __('Are you sure you want to delete # {0}?', $product->id),
                'class' => 'text-red-600 hover:text-red-800 mt-4 block'
            ]) ?>
            <?= $this->Html->link(__('Listado de Productos'), ['action' => 'index'], ['class' => 'text-indigo-600 hover:text-indigo-800 mt-4 block']) ?>
            <?= $this->Html->link(__('Agregar Producto'), ['action' => 'add'], ['class' => 'text-green-600 hover:text-green-800 mt-4 block']) ?>
        </div>
    </aside>

    <!-- Contenido principal -->
    <div class="w-full sm:w-3/4 lg:w-4/5 p-4">
        <div class="bg-white p-6 rounded-md shadow-md">
            <h3 class="text-3xl font-semibold text-gray-800"><?= h($product->name) ?></h3>
            <table class="table-auto w-full mt-6">
                <tbody>
                    <tr class="border-b">
                        <th class="py-2 px-4 text-left font-medium text-gray-600"><?= __('Nombre') ?></th>
                        <td class="py-2 px-4 text-gray-800"><?= h($product->name) ?></td>
                    </tr>
                    <tr class="border-b">
                        <th class="py-2 px-4 text-left font-medium text-gray-600"><?= __('Status') ?></th>
                        <td class="py-2 px-4 text-gray-800">
                            <?php
                            // Verificamos el estado del producto y asignamos el color del badge
                            $statusClass = ($product->status === 'activo') ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800';
                            $statusText = ($product->status === 'activo') ? 'Activo' : 'Inactivo';
                            ?>
                            <span class="text-xs font-medium me-2 px-2.5 py-0.5 rounded <?= $statusClass ?>">
                                <?= h($statusText) ?>
                            </span>
                        </td>
                    </tr>
                    <!-- <tr class="border-b">
                        <th class="py-2 px-4 text-left font-medium text-gray-600"><?= __('Id') ?></th>
                        <td class="py-2 px-4 text-gray-800"><?= $this->Number->format($product->id) ?></td>
                    </tr> -->
                    <tr class="border-b">
                        <th class="py-2 px-4 text-left font-medium text-gray-600"><?= __('Precio') ?></th>
                        <td class="py-2 px-4 text-gray-800">$<?= $this->Number->format($product->price) ?></td>
                    </tr>
                    <tr class="border-b">
                        <th class="py-2 px-4 text-left font-medium text-gray-600"><?= __('Stock Actual') ?></th>
                        <td class="py-2 px-4 text-gray-800"><?= $this->Number->format($product->stock_quantity) ?></td>
                    </tr>
                    <tr class="border-b">
                        <th class="py-2 px-4 text-left font-medium text-gray-600"><?= __('Fecha Creación') ?></th>
                        <td class="py-2 px-4 text-gray-800"><?= h($product->created->format('d/m/Y H:i')) ?></td>
                    </tr>
                    <tr class="border-b">
                        <th class="py-2 px-4 text-left font-medium text-gray-600"><?= __('Fecha Actualización') ?></th>
                        <td class="py-2 px-4 text-gray-800"><?= h($product->modified->format('d/m/Y H:i')) ?></td>
                    </tr>
                </tbody>
            </table>

            <!-- Descripción del producto -->
            <div class="mt-6">
                <strong class="text-xl font-semibold text-gray-700"><?= __('Descripción') ?></strong>
                <blockquote class="mt-2 text-gray-600 italic">
                    <?= $this->Text->autoParagraph(h($product->description)); ?>
                </blockquote>
            </div>
<br>
            <!-- Historial de Movimientos de Stock -->
            <h4 class="text-2xl font-semibold mb-4">Historial de Movimientos de Stock</h4>

            <div class="overflow-auto bg-white rounded-lg shadow">
                <table class="min-w-full table-auto">
                    <thead class="bg-gray-700">
                        <tr>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-200"><?= __('Fecha') ?></th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-200"><?= __('Cantidad Cambiada') ?></th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-200"><?= __('Razón') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($product->stock_movements)): ?>
                            <tr>
                                <td colspan="3" class="px-4 py-2 text-center"><?= __('No hay movimientos de stock registrados') ?></td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($product->stock_movements as $movement): ?>
                                <tr class="border-t hover:bg-blue-100">
                                    <td class="px-4 py-2"><?= h($movement->created->format('d/m/Y H:i')) ?></td>
                                    <td class="px-4 py-2"><?= h($movement->quantity_changed) ?></td>
                                    <td class="px-4 py-2"><?= h($movement->reason) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>