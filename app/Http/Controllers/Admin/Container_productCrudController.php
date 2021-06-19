<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Container_productRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class Container_productCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class Container_productCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Container_product::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/container_product');
        CRUD::setEntityNameStrings('container_product', 'container_products');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
       CRUD::setFromDb(); // columns
        $this->crud->addColumn([
            'label' => 'Product Name',
            //'type' => 'select',
            'name' => 'product_id',
            'type'    => 'select',
            'entity' => 'products',
            'attribute' =>'product_id',
            'model' => 'App\Models\Product'
             ]);

             $this->crud->addColumn([
                'label' => 'Container Name',
                //'type' => 'select',
                'name' => 'container_id',
                'type'    => 'select',
                'entity' => 'containers',
                'attribute' =>'container_id',
                'model' => 'App\Models\Container_information'
                 ]);

                 $this->crud->addColumn([
                    'label' => 'Quantity',
                    //'type' => 'select',
                    'name' => 'quantity',
                    //'type'    => 'select',

                     ]);

                     $this->crud->addColumn([
                        'label' => 'mapper',
                        'type' => 'map',
                        'name' => 'quantity',
                        //'type'    => 'select',

                         ]);

                           /**


         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(Container_productRequest::class);

       // CRUD::setFromDb(); // fields
        $this->crud->addField([
            'label' => 'Product New',
            //'type' => 'select',
            'name' => 'product_id',
            'type'    => 'select',
            'entity' => 'products',
            'attribute' =>'product_name',
            'model' => 'App\Models\Product'
             ]);

             $this->crud->addField([
                'label' => 'Container New',
                //'type' => 'select',
                'name' => 'container_id',
                'type'    => 'select',
                'entity' => 'containers',
                'attribute' =>'container_name',
                'model' => 'App\Models\Container_information'
                 ]);

                 $this->crud->addField([
                    'label' => 'Quantityjjj',
                    //'type' => 'select',
                    'name' => 'quantity',
                    //'type'    => 'select',
                     ]);

                     $this->crud->addField([
                        'label' => 'Location',
                        //'type' => 'select',
                        'name' => 'locater',
                        'type'    => 'select',
                        'entity' => 'containers',
                        'attribute' =>'address-input',
                        'model' => 'App\Models\Com'
                         ]);


                     $this->crud->addField([
                        'label' => 'Quantityjj',
                        'type' => 'map',
                        'name' => 'quantity',
                        //'type'    => 'select',

                         ]);


                     $this->crud->addField([
                        'label' => 'map',
                        'type' => 'map',
                        'name' => 'lo',
                        //'type'    => 'select',

                         ]);


        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
