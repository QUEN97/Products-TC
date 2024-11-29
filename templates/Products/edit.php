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
            <?= $this->Form->postLink(
                __('Eliminar'),
                ['action' => 'delete', $product->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $product->id), 'class' => 'text-red-600 hover:text-red-800 mt-4 block']
            ) ?>
            <?= $this->Html->link(__('Listado de Productos'), ['action' => 'index'], ['class' => 'text-indigo-600 hover:text-indigo-800 mt-4 block']) ?>
        </div>
    </aside>

    <!-- Formulario de producto -->
    <div class="w-full sm:w-3/4 lg:w-4/5 p-4">
        <div class="bg-white p-6 rounded-md shadow-md">
            <?= $this->Form->create($product, ['class' => 'space-y-6', 'id' => 'productForm']) ?>
            <fieldset>
                <legend class="text-2xl font-semibold text-gray-800"><?= __('Editar Producto') ?></legend>
                
                <div class="space-y-4">
                    <!-- Nombre del producto -->
                    <div>
                        <?= $this->Form->control('name', [
                            'label' => 'Nombre', 
                            'class' => 'w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500'
                        ]) ?>
                    </div>
                    
                    <!-- Descripción del producto -->
                    <div>
                        <?= $this->Form->control('description', [
                            'label' => 'Descripción', 
                            'type' => 'textarea', 
                            'class' => 'w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500'
                        ]) ?>
                    </div>
                    
                    <!-- Precio del producto -->
                    <div>
                        <?= $this->Form->control('price', [
                            'label' => 'Precio', 
                            'type' => 'number', 
                            'class' => 'w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500',
                            'id' => 'priceInput'
                        ]) ?>
                        <div id="priceError" class="text-red-500 text-xs hidden">El precio debe ser mayor que 0.</div>
                    </div>
                    
                    <!-- Cantidad en stock -->
                    <div>
                        <?= $this->Form->control('stock_quantity', [
                            'label' => 'Stock', 
                            'type' => 'number', 
                            'class' => 'w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500',
                            'id' => 'stockInput'
                        ]) ?>
                        <div id="stockError" class="text-red-500 text-xs hidden">La cantidad de stock debe ser mayor o igual a 0.</div>
                    </div>

                    <!-- Estado del producto -->
                    <div>
                        <?= $this->Form->control('status', [
                            'label' => 'Status',
                            'options' => ['activo' => 'Activo', 'inactivo' => 'Inactivo'],
                            'class' => 'w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500'
                        ]) ?>
                    </div>
                </div>
            </fieldset>
            
            <!-- Botón de envío -->
            <div class="flex justify-end mt-6">
                <?= $this->Form->button(__('Actualizar'), [
                    'class' => 'bg-gray-700 text-white px-6 py-2 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition',
                    'id' => 'submitButton'
                ]) ?>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

<!-- Agregar validación en tiempo real con JavaScript -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const priceInput = document.getElementById('priceInput');
        const stockInput = document.getElementById('stockInput');
        const submitButton = document.getElementById('submitButton');
        
        const priceError = document.getElementById('priceError');
        const stockError = document.getElementById('stockError');
        
        function validatePrice() {
            const price = parseFloat(priceInput.value);
            if (price <= 0 || isNaN(price)) {
                priceInput.classList.add('border-red-500');
                priceInput.classList.remove('border-green-500');
                priceError.classList.remove('hidden');
                return false;
            } else {
                priceInput.classList.add('border-green-500');
                priceInput.classList.remove('border-red-500');
                priceError.classList.add('hidden');
                return true;
            }
        }

        function validateStock() {
            const stock = parseInt(stockInput.value);
            if (stock < 0 || isNaN(stock)) {
                stockInput.classList.add('border-red-500');
                stockInput.classList.remove('border-green-500');
                stockError.classList.remove('hidden');
                return false;
            } else {
                stockInput.classList.add('border-green-500');
                stockInput.classList.remove('border-red-500');
                stockError.classList.add('hidden');
                return true;
            }
        }

        priceInput.addEventListener('input', validatePrice);
        stockInput.addEventListener('input', validateStock);

        submitButton.addEventListener('click', function (e) {
            if (!validatePrice() || !validateStock()) {
                e.preventDefault();
                alert('Por favor, corrija los errores antes de enviar el formulario.');
            }
        });
    });
</script>

