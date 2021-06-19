<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Container_productsRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class Container_productsCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class Container_productsCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Container_products::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/container_products');
        CRUD::setEntityNameStrings('container_products', 'container_products');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        //CRUD::setFromDb(); // fields
        $this->crud->addColumn([
            'label' => 'Product Name',
            //'type' => 'select',
            'name' => 'product_id',
            'type'    => 'text',
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
                        'label' => 'Quantity',
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
        CRUD::setValidation(Container_productsRequest::class);

       // CRUD::setFromDb(); // fields
       $this->crud->addField([
        'label' => 'Product',
        //'type' => 'select',
        'name' => 'product_id',
        'type'    => 'select',
        'entity' => 'products',
        'attribute' =>'product_name',
        'model' => 'App\Models\Product'
         ]);

         $this->crud->addField([
            'label' => 'Container',
            //'type' => 'select',
            'name' => 'container_id',
            'type'    => 'select',
            'entity' => 'containers',
            'attribute' =>'container_name',
            'model' => 'App\Models\Container_information'
             ]);

             $this->crud->addField([
                'label' => 'Location',
                //'type' => 'select',
                'name' => 'locater',
                'type'    => 'select',
                'entity' => 'containers',
                'attribute' =>'address-input',
                'model' => 'App\Models\Coms'
                 ]);

             $this->crud->addField([
                'label' => 'Quantity',
                //'type' => 'select',
                'name' => 'quantity',
                //'type'    => 'select',

                 ]);

                 $this->crud->addField([
                    [
                        'label' => 'Quantity',
                    //'type' => 'select',
                    'name' => 'quantity',
                    //'type'    => 'select',
                    ],
                    [
                        'label' => 'Quantity',
                    //'type' => 'select',
                    'name' => 'quantity',
                    //'type'    => 'select',
                    ]

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
