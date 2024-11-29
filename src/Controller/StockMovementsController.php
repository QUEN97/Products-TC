<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\I18n\FrozenTime;

/**
 * StockMovements Controller
 *
 * @property \App\Model\Table\StockMovementsTable $StockMovements
 * @method \App\Model\Entity\StockMovement[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class StockMovementsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Products'],
        ];
        $stockMovements = $this->paginate($this->StockMovements);

        $this->set(compact('stockMovements'));
    }

    /**
     * View method
     *
     * @param string|null $id Stock Movement id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $stockMovement = $this->StockMovements->get($id, [
            'contain' => ['Products'],
        ]);

        $this->set(compact('stockMovement'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add($productId)
{
    // Intentamos obtener el producto por el ID
    $product = $this->StockMovements->Products->findById($productId)->first();

    // Verificar si el producto existe
    if (!$product) {
        $this->Flash->error(__('El producto no existe.'));
        return $this->redirect(['controller' => 'Products', 'action' => 'index']);
    }
    
    // Crear una nueva instancia del modelo StockMovement
    $stockMovement = $this->StockMovements->newEmptyEntity();

    // Verificar si el formulario fue enviado
    if ($this->request->is('post')) {
        // Asignar los datos del formulario al objeto StockMovement
        $stockMovement = $this->StockMovements->patchEntity($stockMovement, $this->request->getData());

        // Verificar que el product_id coincide con el producto
        if ($stockMovement->product_id != $productId) {
            $this->Flash->error(__('El ID del producto no coincide.'));
            return $this->redirect(['controller' => 'Products', 'action' => 'index']);
        }

        // Guardar el movimiento de stock
        if ($this->StockMovements->save($stockMovement)) {
            // Actualizar la cantidad de stock del producto
            $product->stock_quantity += $stockMovement->quantity_changed;
            
            // Guardar el producto con la nueva cantidad de stock
            if ($this->StockMovements->Products->save($product)) {
                $this->Flash->success(__('El movimiento de stock ha sido registrado y la cantidad de stock ha sido actualizada.'));
                // Redirigir al listado de productos
                return $this->redirect(['controller' => 'Products', 'action' => 'index']);
            } else {
                $this->Flash->error(__('No se pudo actualizar el stock del producto. Intente nuevamente.'));
            }
        } else {
            $this->Flash->error(__('No se pudo registrar el movimiento de stock. Intente nuevamente.'));
        }
    }

    // Pasar el producto y el movimiento de stock a la vista
    $this->set(compact('product', 'stockMovement'));
}


    /**
     * Edit method
     *
     * @param string|null $id Stock Movement id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $stockMovement = $this->StockMovements->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $stockMovement = $this->StockMovements->patchEntity($stockMovement, $this->request->getData());
            if ($this->StockMovements->save($stockMovement)) {
                $this->Flash->success(__('The stock movement has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The stock movement could not be saved. Please, try again.'));
        }
        $products = $this->StockMovements->Products->find('list', ['limit' => 200])->all();
        $this->set(compact('stockMovement', 'products'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Stock Movement id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $stockMovement = $this->StockMovements->get($id);
        if ($this->StockMovements->delete($stockMovement)) {
            $this->Flash->success(__('The stock movement has been deleted.'));
        } else {
            $this->Flash->error(__('The stock movement could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
