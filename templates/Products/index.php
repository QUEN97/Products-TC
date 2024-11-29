<?php

/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Product> $products
 */
?>
<div class="products index content p-6 mt-6">

    <!-- Botón para agregar nuevo producto -->
    <?= $this->Html->link(__('Nuevo Producto'), ['action' => 'add'], ['class' => 'bg-gray-700 text-white px-4 py-2 rounded-md float-right hover:bg-gray-400 transition']) ?>

    <h3 class="text-3xl font-semibold mb-6"><?= __('Listado de ') ?><span class="text-yellow-400 font-bold"> <?= __(' Productos') ?></span></h3>

    <!-- Formulario de filtros y búsqueda -->
    <?= $this->Form->create(null, ['type' => 'get', 'class' => 'mb-6']) ?>
    <div class="flex flex-col sm:flex-row items-center justify-between mb-6">
        <!-- Filtro por búsqueda -->
        <div class="flex-1 mb-4 sm:mb-0">
            <label for="search" class="block text-sm font-medium text-gray-700"><?= __('Buscar Producto:') ?></label>
            <?= $this->Form->input('search', ['value' => $search, 'placeholder' => 'Buscar por nombre...', 'class' => 'mt-1 block w-full sm:w-1/2 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500']) ?>
        </div>
    </div>

    <div class="flex flex-wrap gap-4 mb-4">
        <!-- Filtro por estado -->
        <div class="flex flex-col sm:w-1/6">
            <label for="status" class="block text-sm font-medium text-gray-700"><?= __('Estado:') ?></label>
            <?= $this->Form->select('status', ['' => 'Todos', 'activo' => 'Activo', 'inactivo' => 'Inactivo'], ['value' => $statusFilter, 'class' => 'mt-1 block  px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500']) ?>
        </div>

        <!-- Filtro por precio mínimo -->
        <div class="flex flex-col sm:w-1/6">
            <label for="price_min" class="block text-sm font-medium text-gray-700"><?= __('Precio Mínimo:') ?></label>
            <?= $this->Form->input('price_min', ['value' => $priceMin, 'class' => 'mt-1 block  px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500']) ?>
        </div>

        <!-- Filtro por precio máximo -->
        <div class="flex flex-col sm:w-1/6">
            <label for="price_max" class="block text-sm font-medium text-gray-700"><?= __('Precio Máximo:') ?></label>
            <?= $this->Form->input('price_max', ['value' => $priceMax, 'class' => 'mt-1 block  px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500']) ?>
        </div>

        <!-- Filtro por cantidad de stock -->
        <div class="flex flex-col sm:w-1/6">
            <label for="stock_quantity" class="block text-sm font-medium text-gray-700"><?= __('Stock Actual:') ?></label>
            <?= $this->Form->input('stock_quantity', ['value' => $stockFilter, 'class' => 'mt-1 block  px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500']) ?>
        </div>

        <!-- Botón de Filtrar -->
        <div class="flex flex-col">
            <?= $this->Form->button('Filtrar', ['class' => 'bg-gray-700 text-white px-3 py-2 mt-1 block rounded-md hover:bg-gray-400 transition']) ?>
        </div>
    </div>

    <?= $this->Form->end() ?>

    <!-- Tabla de productos -->
    <div class="overflow-auto bg-white rounded-lg shadow hidden md:block">
        <table class="min-w-full table-auto">
            <thead class="bg-gray-700">
                <tr>
                    <!-- <th class="px-4 py-2 text-left text-sm font-semibold text-gray-200"><?= __('ID') ?></th> -->
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-200"><?= __('NOMBRE') ?></th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-200"><?= __('PRECIO') ?></th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-200"><?= __('STOCK ACTUAL') ?></th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-200"><?= __('STATUS') ?></th>
                    <!-- <th class="px-4 py-2 text-left text-sm font-semibold text-gray-200"><?= $this->Paginator->sort('created') ?></th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-200"><?= $this->Paginator->sort('modified') ?></th> -->
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-200"><?= __('OPCIONES') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr class="border-t hover:bg-blue-100">
                        <!-- <td class="px-4 py-2"><?= $this->Number->format($product->id) ?></td> -->
                        <td class="px-4 py-2"><?= h($product->name) ?></td>
                        <td class="px-4 py-2">$<?= $this->Number->format($product->price) ?></td>
                        <td class="px-4 py-2"><?= $this->Number->format($product->stock_quantity) ?></td>
                        <td class="px-4 py-2">
                            <?php
                            // Verificamos el estado del producto y asignamos el color del badge
                            $statusClass = ($product->status === 'activo') ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800';
                            $statusText = ($product->status === 'activo') ? 'Activo' : 'Inactivo';
                            ?>
                            <span class="text-xs font-medium me-2 px-2.5 py-0.5 rounded <?= $statusClass ?>">
                                <?= h($statusText) ?>
                            </span>
                        </td>
                        <!-- <td class="px-4 py-2"><?= h($product->created) ?></td>
                    <td class="px-4 py-2"><?= h($product->modified) ?></td> -->
                        <td class="px-4 py-2">
                            <?= $this->Html->link(__('Ver'), ['action' => 'view', $product->id], ['class' => 'bg-blue-100 hover:bg-blue-200 text-blue-800 text-xs font-semibold me-2 px-2.5 py-0.5 rounded  border border-blue-400 inline-flex items-center justify-center']) ?>
                            <?= $this->Html->link(__('Editar'), ['action' => 'edit', $product->id], ['class' => 'bg-yellow-100 hover:bg-yellow-200 text-yellow-800 text-xs font-semibold me-2 px-2.5 py-0.5 rounded  border border-yellow-400 inline-flex items-center justify-center']) ?>
                            <?= $this->Form->postLink(__('Eliminar'), ['action' => 'delete', $product->id], ['confirm' => __('¿Estás seguro de que deseas desactivar este producto?'), 'class' => 'bg-red-100 hover:bg-red-200 text-red-800 text-xs font-semibold me-2 px-2.5 py-0.5 rounded  border border-red-400 inline-flex items-center justify-center']) ?>
                            <!-- <div>
                                
                                <?= $this->Html->link(__('Eliminar'), '#', [
                                    'class' => 'bg-red-100 hover:bg-red-200 text-red-800 text-xs font-semibold me-2 px-2.5 py-0.5 rounded border border-red-400 inline-flex items-center justify-center',
                                    'data-modal-id' => 'modal-' . $product->id
                                ]) ?>

                               
                                <div id="modal-<?= $product->id ?>" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
                                    <div class="bg-white rounded-lg p-6 w-96 max-w-md transform transition-all duration-300 ease-in-out">
                                        <h3 class="text-xl font-semibold text-center mb-4"><?= __('Confirmar eliminación') ?></h3>
                                        <p class="text-sm text-center mb-6"><?= __('¿Estás seguro de que deseas desactivar este producto?') ?></p>
                                        <div class="flex justify-between">
                                            
                                            <button class="close-modal bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400"><?= __('Cancelar') ?></button>
                                            
                                            <button onclick="document.getElementById('delete-product-form-<?= $product->id ?>').submit();" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600"><?= __('Confirmar') ?></button>
                                        </div>
                                    </div>
                                </div>

                                
                                <?= $this->Form->create(null, [
                                    'id' => 'delete-product-form-' . $product->id,
                                    'url' => ['action' => 'delete', $product->id],
                                    'type' => 'post',
                                    'style' => 'display:none;'
                                ]) ?>
                                <?= $this->Form->end() ?>
                            </div> -->
                            <?= $this->Html->link(__('Stock'), ['controller' => 'StockMovements', 'action' => 'add', $product->id], [
                                'class' => 'bg-indigo-100 hover:bg-indigo-200 text-indigo-800 text-xs font-semibold me-2 px-2.5 py-0.5 rounded border border-indigo-400 inline-flex items-center justify-center'
                            ]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <!-- grid de productos -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 md:hidden">
        <?php foreach ($products as $product): ?>
            <div class="bg-white dark:bg-slate-800 space-y-3 p-4 rounded-lg shadow">
                <div class="flex float-right">
                    <div x-data="{ isOpen: false }" class="relative">
                        <!-- Botón para abrir/cerrar el menú -->
                        <button @click="isOpen = !isOpen" class="focus:outline-none">
                            <!-- Icono de flecha hacia abajo cuando está cerrado, hacia arriba cuando está abierto -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6"
                                :class="{ 'transform rotate-180': isOpen }" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 12a.75.75 0 0 0 .53-.22l3.25-3.25a.75.75 0 0 0-1.06-1.06L10 10.94 7.28 8.22a.75.75 0 1 0-1.06 1.06l3.75 3.75a.75.75 0 0 0 .53.22z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>

                        <!-- Menú desplegable -->
                        <div x-show="isOpen" @click.away="isOpen = false"
                            class="absolute z-10 w-32 p-2 bg-white rounded-md overflow-hidden shadow-xl"
                            style="top: calc(-100% - 0.5rem); right: 2rem;">
                            <!-- Opciones del menú -->
                            <div class="flex flex-col justify-center items-center space-y-2">

                                <div class="flex gap-1">
                                    <?= $this->Html->link(__('Ver'), ['action' => 'view', $product->id], ['class' => 'bg-blue-100 hover:bg-blue-200 text-blue-800 text-xs font-semibold me-2 px-2.5 py-0.5 rounded  border border-blue-400 inline-flex items-center justify-center']) ?>

                                </div>
                                <div class="flex gap-1">
                                    <?= $this->Html->link(__('Editar'), ['action' => 'edit', $product->id], ['class' => 'bg-yellow-100 hover:bg-yellow-200 text-yellow-800 text-xs font-semibold me-2 px-2.5 py-0.5 rounded  border border-yellow-400 inline-flex items-center justify-center']) ?>

                                </div>
                                <div class="flex gap-1">
                                    <?= $this->Form->postLink(__('Eliminar'), ['action' => 'delete', $product->id], ['confirm' => __('¿Estás seguro de que deseas desactivar este producto?'), 'class' => 'bg-red-100 hover:bg-red-200 text-red-800 text-xs font-semibold me-2 px-2.5 py-0.5 rounded  border border-red-400 inline-flex items-center justify-center']) ?>
                                </div>
                                <div class="flex gap-1">
                                    <?= $this->Html->link(__('Stock'), ['controller' => 'StockMovements', 'action' => 'add', $product->id], [
                                        'class' => 'bg-indigo-100 hover:bg-indigo-200 text-indigo-800 text-xs font-semibold me-2 px-2.5 py-0.5 rounded border border-indigo-400 inline-flex items-center justify-center'
                                    ]) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex items-center space-x-2 text-sm">
                    <div class="font-bold">#<?= $this->Number->format($product->id) ?></div>
                    <div class="font-bold truncate">
                        <?= h($product->name) ?>
                    </div>
                </div>
                <div class="flex gap-4 justify-center items-center md:flex-row md:items-center md:justify-center ">
                    <?php
                    // Verificamos el estado del producto y asignamos el color del badge
                    $statusClass = ($product->status === 'activo') ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800';
                    $statusText = ($product->status === 'activo') ? 'Activo' : 'Inactivo';
                    ?>
                    <span class="text-xs font-medium me-2 px-2.5 py-0.5 rounded <?= $statusClass ?>">
                        <?= h($statusText) ?>
                    </span>
                    <div>
                        $<?= $this->Number->format($product->price) ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Paginación -->
<div class="paginator mt-6">
    <ul class="pagination flex space-x-4 justify-center">
        <li><?= $this->Paginator->first('<< ' . __('Inicio')) ?></li>
        <li><?= $this->Paginator->prev('< ' . __('Anterior')) ?></li>
        <li><?= $this->Paginator->numbers() ?></li>
        <li><?= $this->Paginator->next(__('Siguiente') . ' >') ?></li>
        <li><?= $this->Paginator->last(__('Final') . ' >>') ?></li>
    </ul>
    <p class="text-center mt-4"><?= $this->Paginator->counter(__('Página {{page}} de {{pages}}, mostrando {{current}} registro(s) de {{count}} en total')) ?></p>
</div>
</div>
<!-- <script>
    // Función para abrir el modal al hacer clic en el botón
    document.querySelectorAll('[data-modal-id]').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault(); // Evita el comportamiento por defecto del enlace
            const modalId = this.getAttribute('data-modal-id');
            const modal = document.getElementById(modalId);
            modal.classList.remove('hidden'); // Mostrar el modal
        });
    });

    // Cerrar el modal cuando se hace clic en el botón "Cancelar"
    document.querySelectorAll('.close-modal').forEach(button => {
        button.addEventListener('click', function() {
            const modal = this.closest('.fixed'); // Encontrar el modal más cercano
            modal.classList.add('hidden'); // Ocultar el modal
        });
    });

    // Cerrar el modal cuando se hace clic fuera de él
    window.addEventListener('click', function(event) {
        if (event.target.classList.contains('fixed')) {
            event.target.classList.add('hidden'); // Cerrar el modal al hacer clic fuera
        }
    });
</script> -->