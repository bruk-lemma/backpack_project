<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Container_informationRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\Container_information;

/**
 * Class Container_informationCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class Container_informationCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Container_information::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/container_information');
        CRUD::setEntityNameStrings('container_information', 'container_informations');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        //CRUD::setFromDb(); // columns

            $this->crud->addColumn([
               'label' => 'Container Information',
               'type' => 'text',
               'name' => 'container_name',

           ]);
           $this->crud->addColumn([
            'label' => 'Container delivery Date',
            'type' => 'date',
            'name' => 'delivery_date',

            ]);
            $this->crud->addColumn([
            'label' => 'Total Item',
            'type' => 'text',
            'name' => 'total_items',

            ]);
            $this->crud->addColumn([
            'label' => 'Status',
            //'type' => 'select',
            'name' => 'status',
            'type'    => 'select_from_array',
            'options' => [
                'Inprogress' => 'Inprogress', 'Future_Import' => 'Future_Import','Recieved' => 'recieved']
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
        CRUD::setValidation(Container_informationRequest::class);

        //CRUD::setFromDb(); // fields
        $this->crud->addField([
            'label' => 'Container Name',
            //'type' => 'text',
            'name' => 'container_name',
            

        ]);
        $this->crud->addField([
            'label' => 'Delivery Date',
            'type' => 'date',
            'name' => 'delivery_date',

        ]);

        $this->crud->addField([
            'label' => 'Total Items',
            //'type' => 'date',
            'name' => 'total_items',

        ]);

        $this->crud->addField([
            'label' => 'Status',
            'type'    => 'select_from_array',
            'options' => [
                'Inprogress' => 'Inprogress', 'Future_Import' => 'Future_Import','Recieved' => 'recieved'],


            'name' => 'status',
            'allows_null' => false,
            'default'     => 'InProgress',

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
