<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Products Controller
 *
 * @property \App\Model\Table\ProductsTable $Products
 * @method \App\Model\Entity\Product[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProductsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        // Obtener los filtros desde la solicitud (parámetros de URL)
        $statusFilter = $this->request->getQuery('status');  // 'activo' o 'inactivo'
        $priceMin = $this->request->getQuery('price_min');  // Rango mínimo de precio
        $priceMax = $this->request->getQuery('price_max');  // Rango máximo de precio
        $stockFilter = $this->request->getQuery('stock_quantity'); // filtro por stock
        $search = $this->request->getQuery('search'); //busqueda por nombre de producto

        // Crear la consulta base
        $query = $this->Products->find()
            ->select(['id', 'name', 'price', 'stock_quantity', 'status']) // Seleccionar las columnas necesarias
            ->order(['id' => 'DESC']);  // Ordenar por id (de manera descendente para que devuelva el registro actual primero)

        // Aplicar el filtro por 'status' si está presente
        if ($statusFilter) {
            $query->where(['status' => $statusFilter]);
        }

        // Aplicar el filtro por rango de precios si está presente
        if ($priceMin) {
            $query->where(['price >=' => $priceMin]);
        }
        if ($priceMax) {
            $query->where(['price <=' => $priceMax]);
        }

        // Aplicar el filtro por 'stock' si está presente
        if ($stockFilter) {
            $query->where(['stock_quantity' => $stockFilter]);
        }

        // Barra de  búsqueda
        if ($search) {
            $query->where(['name LIKE' => '%' . $search . '%']);
        }

        // Configurar la paginación (10 productos por página)
        $this->paginate = [
            'limit' => 10,  // Número de productos por página
            'order' => ['id' => 'DESC'],  // Orden por nombre
        ];

        // Paginación y obtener los productos filtrados
        $products = $this->paginate($query);
        //$products = $this->paginate($this->Products);

        $this->set(compact('products', 'statusFilter', 'priceMin', 'priceMax','stockFilter','search'));
    }

    /**
     * View method
     *
     * @param string|null $id Product id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        // Obtener el producto junto con sus movimientos de stock
        $product = $this->Products->get($id, [
            'contain' => ['StockMovements'],
        ]);

        $this->set(compact('product'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $product = $this->Products->newEmptyEntity();
        if ($this->request->is('post')) {
            $product = $this->Products->patchEntity($product, $this->request->getData());
            if ($this->Products->save($product)) {
                $this->Flash->success(__('The product has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The product could not be saved. Please, try again.'));
        }
        $this->set(compact('product'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Product id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $product = $this->Products->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $product = $this->Products->patchEntity($product, $this->request->getData());
            if ($this->Products->save($product)) {
                $this->Flash->success(__('The product has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The product could not be saved. Please, try again.'));
        }
        $this->set(compact('product'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Product id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $product = $this->Products->get($id);
        // Cambiar el estado a "inactivo" para realizar la eliminación lógica
        $product->status = 'inactivo';
        if ($this->Products->save($product)) {
            $this->Flash->success(__('El producto ha sido marcado como inactivo.'));
        } else {
            $this->Flash->error(__('No se pudo actualizar el producto. Por favor, inténtalo de nuevo.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
