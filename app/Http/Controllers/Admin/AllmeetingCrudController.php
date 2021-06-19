<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Person_meetingRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class Perosn_taskCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class AllmeetingCrudController extends CrudController
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
        CRUD::setModel(\App\Models\person_meeting::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/lead/meeting');
        CRUD::setEntityNameStrings('meeting', 'meeting');
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
            'label' => 'Meeting Title',
            'type' => 'text',
            'name' => 'name',
            'wrapper'   => [ 
                'class' => 'form-group col-md-6'
            ]  
        ]);
        $this->crud->addColumn([
            'label' => 'From',
            'type' => 'date',
            'name' => 'start_date',
            
        ]);
        $this->crud->addColumn([
            'label' => 'To',
            'type' => 'date',
            'name' => 'due_date',
            
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
         
        $this->crud->setCreateContentClass('col-md-12'); 
        CRUD::setValidation(Person_meetingRequest::class);
        $this->crud->addfield([
            'label' => 'Owner',
          
                'type' => 'hidden',
                'name' => 'user_id',
    
               
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
                'label' => 'Meeting Title',
                'type' => 'text',
                'name' => 'name',
                'wrapper'   => [ 
                    'class' => 'form-group col-md-6'
                ]  
            ]);
         
            $this->crud->addfield([
                'label' => 'Location',
                'type' => 'text',
                'name' => 'location',
                'wrapper'   => [ 
                    'class' => 'form-group col-md-6'
                ]  
            ]);
            $this->crud->addfield([
                'label' => 'From',
                'type' => 'datetime',
                'name' => 'start_date',
                'wrapper'   => [ 
                    'class' => 'form-group col-md-6'
                ]  
            ]);
            $this->crud->addfield([
                'label' => 'To',
                'type' => 'datetime',
                'name' => 'due_date',
                'wrapper'   => [ 
                    'class' => 'form-group col-md-6'
                ]  
            ]);
            $this->crud->addField([
                'label' => 'All Day',
                'type' => 'radio',
                'name' => 'all_day',
                'options' => [
                    0 => "all_day",
                ],
                'wrapper'   => [ 
                'class' => 'form-group col-md-6'
            ]  
            ]);
            $this->crud->addfield([
                'label' => 'Participant',
                'type' => 'select',
                'name' => 'participant',
                'attribute' =>'name', 
                'entity' => 'user', 
                'model' => 'App\Models\user',
                'wrapper'   => [ 
                    'class' => 'form-group col-md-6'
                ] 
            ]);    
            $this->crud->addfield([
                'label' => 'Meeting Description',
                'type' => 'textarea',
                'name' => 'desciption',
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
       
         $this->crud->addColumn([
            'label' => 'Meeting Owner',
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
               
            'attributes' => [
                'readonly'    => 'readonly',
                // 'disabled'    => 'disabled',
              ], 
            'default' => request()->input('person_id', ''),
    ]);
        $this->crud->addColumn([
            'label' => 'Meeting Title',
            'type' => 'text',
            'name' => 'name',
            
        ]);
     
        $this->crud->addColumn([
            'label' => 'Location',
            'type' => 'text',
            'name' => 'location',
         
        ]);
        $this->crud->addColumn([
            'label' => 'From',
            'type' => 'date',
            'name' => 'start_date',
            
        ]);
        $this->crud->addColumn([
            'label' => 'To',
            'type' => 'date',
            'name' => 'due_date',
            
        ]);
        $this->crud->addColumn([
            'label' => 'All Day',
            'type' => 'radio',
            'name' => 'all_day',
            'options' => [
                0 => "all_day",
            ],
        
        ]);
        $this->crud->addColumn([
            'label' => 'Participant',
            'type' => 'select',
            'name' => 'participant',
            'attribute' =>'name', 
            'entity' => 'user', 
            'model' => 'App\Models\user',
           
        ]);    
        $this->crud->addColumn([
            'label' => 'Meeting Description',
            'type' => 'textarea',
            'name' => 'desciption',
       
        ]);
  
    }}