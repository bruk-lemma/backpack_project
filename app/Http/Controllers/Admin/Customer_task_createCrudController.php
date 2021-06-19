<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Person_taskRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class Perosn_taskCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class Customer_task_createCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
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
        CRUD::setModel(\App\Models\Person_task::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/customer_task_create');
        CRUD::setEntityNameStrings('task', 'task');
        CRUD::operation('list', function() {
            CRUD::removeButton('edit');
        });
    
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {   
            //  $this->crud->addClause('where', 'person_id', '=', request()->input('person_id', ''));  
        $this->crud->setCreateContentClass('col-md-12'); 
        // CRUD::removeButton('edit');
        $this->crud->addColumn([
            'label' => 'Owner',
            'type' => 'select',
            'name' => 'user_id',
            'attribute' =>'name', 
            'entity' => 'user', 
            'model' => 'App\Models\user',
            
        ]); 
        $this->crud->addColumn([
                'label' => 'Company',
                'type' => 'select',
                'name' => 'person_id',
                'attribute' =>'company_name', 
                'entity' => 'person', 
                'model' => 'App\Models\person',
        ]); 
        $this->crud->addColumn([
            'label' => 'Type',
            'type' => 'select',
            'name' => 'type',
            'attribute' =>'type', 
            'entity' => 'person', 
            'model' => 'App\Models\person',
         ]); 
        $this->crud->addColumn([
            'label' => 'Task Name',
            'type' => 'text',
            'name' => 'task_name',
            'wrapper'   => [ 
                'class' => 'form-group col-md-6'
            ]  
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
        CRUD::setValidation(Person_taskRequest::class);
        
        $this->crud->setCreateContentClass('col-md-12');
        $this->crud->addfield([
            'label' => 'Owner',
            'type' => 'select',
            'name' => 'user_id',
            'attribute' =>'name', 
            'entity' => 'user', 
            'model' => 'App\Models\user',    
            'wrapper'   => [ 
                'class' => 'form-group col-md-12'
            ]   ]); 
            $this->crud->addfield([
                'label' => 'Company',
                'type' => 'hidden',
                'name' => 'person_id',
                'attribute' =>'company_name', 
                   
                'attributes' => [
                    'readonly'    => 'readonly',
                    // 'disabled'    => 'disabled',
                  ], 
                'default' => request()->input('person_id', ''),
                ]);
                $this->crud->addfield([
                    'label' => 'Type',
                    'type' => 'hidden',
                    'name' => 'type_id',
                    'value' => '3',
                    'attribute' =>'type_id', 
                    'entity' => 'person', 
                    'model' => 'App\Models\person',
                 ]); 
                $this->crud->addfield([
                    'label' => 'Subject',
                    'type' => 'text',
                    'name' => 'task_name',
                    'wrapper'   => [ 
                        'class' => 'form-group col-md-6'
                    ]  
                ]);
                $this->crud->addfield([
                    'label' => 'Due Date',
                    'type' =>  'date',
                    'name' => 'due_date',
                    'wrapper'   => [ 
                        'class' => 'form-group col-md-6'
                    ]  
                ]);
                $this->crud->addField([
                    'label' => 'Priority',
                    'type' => 'select',
                    'name' => 'priority',
                    'type' => 'select_from_array',
                    'options' => [
                                'High' => 'High',
                                'Medium' => 'Medium',
                                'Low' => 'Low',
                        
                                ],
                    'wrapper'   => [ 
                    'class' => 'form-group col-md-6'
                ]  
                ]);
                $this->crud->addfield([
                    'name' => 'repeat',
                    'type' => 'radio',
                    'options' => [
                        0 => "yes",
                        1=>"no",
                    ],
                    'wrapper'   => [ 
                        'class' => 'form-group col-md-6'
                    ] 
                ] );
                $this->crud->addfield([
                    'label' => 'Task Description',
                    'type' => 'textarea',
                    'name' => 'task_desc',
                
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
        
        $this->crud->setCreateContentClass('col-md-12');
        $this->setupCreateOperation();
    }
    protected function setupShowOperation()
    {
         $this->crud->setShowContentClass('col-md-12');
       
         $this->crud->addColumn([
            'label' => 'Owner',
            'type' => 'select',
            'name' => 'user_id',
            'attribute' =>'name', 
            'entity' => 'user', 
            'model' => 'App\Models\user',
            
        ]); 
        $this->crud->addColumn([
                'label' => 'Company',
                'type' => 'select',
                'name' => 'person_id',
                'attribute' =>'company_name', 
                'entity' => 'person', 
                'model' => 'App\Models\person',
        ]); 
  
        $this->crud->addColumn([
            'name' => 'repeat',
            'type' => 'radio',
            'options' => [
                0 => "yes",
                1=>"no",
            ],
            ]);
            $this->crud->addColumn([
                'label' => 'Task Description',
                'type' => 'textarea',
                'name' => 'task_desc',
             
         ]);
        //  $this->crud->addButtonFromView('line', 'a', 'a', 'beginning');
}}