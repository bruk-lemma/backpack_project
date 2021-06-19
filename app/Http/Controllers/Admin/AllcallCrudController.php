<?php

namespace App\Http\Controllers\Admin;
use auth;
use App\Http\Requests\Person_callRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class Perosn_taskCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class AllcallCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
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
        CRUD::setModel(\App\Models\Person_call::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/lead/call');
        CRUD::setEntityNameStrings('call', 'call');
        CRUD::operation('list', function() {
            CRUD::removeButton('edit');
        });
        $this->crud->allowAccess('operation');
        $this->crud->allowAccess('operation1');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {   
        
        $this->crud->setCreateContentClass('col-md-12'); 
        $this->crud->addClause('where', 'person_id', '=', request()->input('person_id', ''));
        // CRUD::removeButton('edit');
        $this->crud->addColumn([
            'label' => 'Lead Name',
            'type' => 'select',
            'name' => "person_id",
            'entity' => 'person', 
            'model' => 'App\Models\person',    
            'wrapper'   => [ 
                'class' => 'form-group col-md-12',
                'font-weight' => 'bold'
                ]   
        ]);
                  $this->crud->addColumn([
                    'label' => 'Company',
                    'type' => 'select',
                    'name' => 'personcompany_id',
                    'attribute' =>'company_name', 
                    'entity' => 'person', 
                    'model' => 'App\Models\person',
            ]); 
      
        $this->crud->addColumn([
            'label' => 'Call Purpose',
            'type' => 'text',
            'name' => 'call_purpose',
            'wrapper'   => [ 
                'class' => 'form-group col-md-6'
            ]  
            
        ]);
        $this->crud->addColumn([
            'label' => 'Call Details',
            'type' => 'radio',
            'name' => 'call_detail',
            'options' => [
                0 => "Current Call",
                1=>"Completed Call",
                2=>"Schedule Call",
            ],
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
        CRUD::setValidation(Person_callRequest::class);
        $this->crud->setCreateContentClass('col-md-12');
        $this->crud->addfield([
            'label' => 'Owner',
          
                'type' => 'hidden',
                'name' => 'user_id',
    
                'value' => Auth::guard('backpack')->user()->id  
            ]);
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
        // $this->crud->addfield([
        //     'label' => 'Type',
        //     'type' => 'hidden',
        //     'name' => 'type',
        //     'attribute' =>'type', 
        //     'entity' => 'person', 
        //     'model' => 'App\Models\person',
        //  ]); 
        
            $this->crud->addfield([
                'label' => 'Call Purpose',
                'type' => 'text',
                'name' => 'call_purpose',
                'wrapper'   => [ 
                    'class' => 'form-group col-md-6'
                ]  
            ]);
           
            $this->crud->addField([
                'label' => 'Call Details',
                'type' => 'radio',
                'name' => 'call_detail',
                'options' => [
                    0 => "Current Call",
                    1=>"Completed Call",
                    2=>"Schedule Call",
                ],
                'wrapper'   => [ 
                'class' => 'form-group col-md-6'
            ]  
            ]);
            $this->crud->addfield([
                'label' => 'Call Description',
                'type' => 'textarea',
                'name' => 'call_desc',
                'wrapper'   => [ 
                    'class' => 'form-group col-md-6'
                ]
            ]);
            $this->crud->addfield([
                'label' => 'Call Result',
                'type' => 'textarea',
                'name' => 'call_result',
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
        
        $this->crud->setUpdateContentClass('col-md-12');
        $this->setupCreateOperation();
    }
    protected function setupShowOperation()
    {
         $this->crud->setShowContentClass('col-md-12');
         $this->crud->set('show.setFromDb', false);
         $this->crud->addColumn([
            'label' => 'Call Owner',
            'type' => 'select',
            'name' => 'user_id',
            'attribute' =>'name', 
    
                // 'value' => Auth::guard('backpack')->user()->id  
            ]);
            $this->crud->addColumn([
                'label' => 'Company',  
                'type' => 'select',
                'name' => 'person_id',
                'attribute' =>'company_name',   
                'attributes' => [
                    'readonly'    => 'readonly',
                    // 'disabled'    => 'disabled',
                  ], 
                'default' => request()->input('person_id', ''),
        ]);
        $this->crud->addColumn([
            'label' => 'Type',
            'type' => 'hidden',
            'name' => 'type',
            'attribute' =>'type', 
            'entity' => 'person', 
            'model' => 'App\Models\person',
         ]); 
        
            $this->crud->addColumn([
                'label' => 'Call Purpose',
                'type' => 'text',
                'name' => 'call_purpose',
                'wrapper'   => [ 
                    'class' => 'form-group col-md-6'
                ]  
            ]);
           
            $this->crud->addColumn([
                'label' => 'Call Details',
                'type' => 'radio',
                'name' => 'call_detail',
                'options' => [
                    0 => "Current Call",
                    1=>"Completed Call",
                    2=>"Schedule Call",
                ],
                'wrapper'   => [ 
                'class' => 'form-group col-md-6'
            ]  
            ]);
            $this->crud->addColumn([
                'label' => 'Call Description',
                'type' => 'textarea',
                'name' => 'call_desc',
                'wrapper'   => [ 
                    'class' => 'form-group col-md-6'
                ]
            ]);
            $this->crud->addColumn([
                'label' => 'Call Result',
                'type' => 'textarea',
                'name' => 'call_result',
                'wrapper'   => [ 
                    'class' => 'form-group col-md-6'
                ]
            ]);    
       
    }}