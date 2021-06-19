<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SubcityRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class SubcityCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class SubcityCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Subcity::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/subcity');
        CRUD::setEntityNameStrings('subcity', 'subcities');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->addColumn([
            'label' => 'Region',
            'type' => 'text',
            'name' => 'region_id',
      
        ]);
        // $this->crud->addColumn([
        //     'label' => 'City',
        //     'type' => 'select',
        //     'name' => 'city_id',
        //     'attribute' =>'city', 
        //     'entity' => 'city', 
        //     'model' => 'App\Models\city',
        // ])
        $this->crud->addColumn([
            'label' => 'Subcity',
            'type' => 'text',
            'name' => 'subcity',
            
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
        CRUD::setValidation(SubcityRequest::class);

        $this->crud->addfield([
            'label' => 'Region',
            'type' => 'hidden',
            'name' => 'region_id',
            'attribute' =>'region', 
            'attributes' => [
                'readonly'    => 'readonly',
                // 'disabled'    => 'disabled',
              ], 
            'value' => '1',
            ]);
    //     $this->crud->addField([
    //         'label' => 'City',
    //         'type' => 'select',
    //         'name' => 'city_id',
    //         'attribute' =>'city', 
    //         'entity' => 'city', 
    //         'model' => 'App\Models\city',
    //       'wrapper'   => [ 
    //         'class' => 'form-group col-md-6'
    //         ]  
      
    // ]); 
    $this->crud->addField([
        'label' => 'Subcity',
        'type' => 'text',
        'name' => 'subcity',
        'wrapper'   => [ 
            'class' => 'form-group col-md-12'
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
