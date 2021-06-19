<?php

namespace App\Http\Controllers\Admin;
use Auth;
use App\Http\Requests\CommunicationRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class CreateevaluationCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class Createout_of_listCrudController extends CrudController
{
    // use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\communication::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/createout_of_list');
        CRUD::setEntityNameStrings('Out Of List', 'Out Of List');
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
        CRUD::setValidation(CommunicationRequest::class);
        $this->crud->setCreateContentClass('col-md-12');
        // $this->crud->addField([
        //     'label' => 'Case Number',
        //     'type' => 'text',
        //     'name' => 'code',
        //     'wrapper'   => [ 
        //     'class' => 'form-group col-md-6'
        // ]   
        // ]);  
        $this->crud->addField([
            'label' => 'Communicated By:',
            'type' => 'hidden',
            'name' => 'user_id',

            'value' => Auth::guard('backpack')->user()->id  
        ]); 
            $this->crud->addField([
                
                'label' => 'Company',  
                'type' => 'hidden',
                'name' => 'person_id',
                'attribute' =>'company_name',   
                'attributes' => [
                    'readonly'    => 'readonly',
                  ], 
                'default' => request()->input('person_id', ''),
            
        ]);
        $this->crud->addField([
            'label' => 'Communication Type',
            'type' => 'hidden',
            'name' => 'communication_types_id',
            // 'type' => 'select_from_array',
            'options' => [
                'Out Of List' => 'Out Of List',   
                        ],
            
                        'value'=> 'Out Of List', 
        ]);
        $this->crud->addField([
            'label' => 'Type',
            'type' => 'hidden',
            'name' => 'typ',
         'value' => 'OL',
        ]);          
        $this->crud->addField([
            'label' => 'Communicated By:',
            'type' => 'select',
            'name' => 'user_id',
            'attribute' =>'name', 
            'entity' => 'user', 
            'model' => 'App\Models\user',
          'wrapper'   => [ 
            'class' => 'form-group col-md-6'
         ]    
        ]);
        $this->crud->addField([
            'label' => 'Communication',
            'type' => 'select_from_array',
            'name' => 'communication_ways_id',
            'allows_null' => true, 
            'options' => [
                'Phone' => 'Phone',
                'Telegram' => 'Telegram',
                'Physical' => 'Physical',
                'E-Mail' => 'E-Mail',
                'Facebook' => 'Facebook',
              ],
            'wrapper'   => [ 
            'class' => 'form-group col-md-6'
        ]    
    ]);
    $this->crud->addField([
        'label' => 'Product',
        'type' => 'select',
        'name' => 'product_id',
        'attribute' =>'product_name', 
        'entity' => 'product', 
        'model' => 'App\Models\product',
        'wrapper'   => [ 
        'class' => 'form-group col-md-6'
    ]   
    ]);   
        $this->crud->addField([
            'label' => 'Quantity',
            'type' => 'number',
            'name' => 'quantity',
            'wrapper'   => [ 
                'class' => 'form-group col-md-6'
            ]   
    ]);
    $this->crud->addField([
        'label' => 'Second',
        'type' => 'number',
        'name' => 'second',
        'wrapper'   => [ 
            'class' => 'form-group col-md-6'
        ]   
    ]);
    $this->crud->addField([
        'label' => 'Remarks',
        'type' => 'textarea',
        'name' => 'remarks',
        'wrapper'   => [ 
            'class' => 'form-group col-md-6'
        ]   
    ]);

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
