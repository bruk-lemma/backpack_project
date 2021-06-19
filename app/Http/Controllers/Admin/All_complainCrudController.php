<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CommunicationRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class PersonCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class All_complainCrudController extends CrudController
{
        // use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
        use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
        use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
        use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    
        /**
         * Configure the CrudPanel object. Apply settings to all operations.
         * 
         * @return void
         */
        public function setup()
        {
            CRUD::setModel(\App\Models\Communication::class);
            CRUD::setRoute(config('backpack.base.route_prefix') . '/all_complain');
            CRUD::setEntityNameStrings('Complaint', 'Complaint');
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
            // $this->crud->addClause('where', 'communication_types_id', '=', 'Complaint');
            $this->crud->addClause('where', 'person_id', '=', request()->input('person_id', '')); 
            $this->crud->addClause('where', 'communication_types_id', '=', 'Complaint');       
                $this->crud->setCreateContentClass('col-md-12');
                $this->crud->add
                ([
                    'name'  => 'communication_ways_id',
                    'type'  => 'dropdown',
                    'label' => 'Communication'
                  ], [
                    
                    'Phone' => 'Phone',
                    'Telegram' => 'Telegram',
                    'Physical' => 'Physical',
                    'E-Mail' => 'E-Mail',
                    'Facebook' => 'Facebook',
                  ], function($value) { // if the filter is active
                    $this->crud->addClause('where', 'communication_ways_id', $value);
                  });
              
                  $this->crud->addColumn([
                    'label' => 'Case_number',
                    'type' => 'model_function',
                    'function_name' => 'getcasenumber'
                ]); 
                $this->crud->addColumn([
                    'label' => 'Communicated_By',
                    'type' => 'select',
                    'name' => 'user_id',
                    'attribute' =>'name', 
                    'entity' => 'user', 
                    'model' => 'App\Models\user',
                    
                ]); 
                //     $this->crud->addColumn([
                //         'label' => 'Company',
                //         'type' => 'select',
                //         'name' => 'person_id',
                //         'attribute' =>'name', 
                //         'entity' => 'person', 
                //         'model' => 'App\Models\person',
                     
                // // ]);
                // $this->crud->addColumn([
                //     'label' => 'Type',
                //     'type' => 'select',
                //     'name' => 'type',
                //     'attribute' =>'type', 
                //     'entity' => 'person', 
                //     'model' => 'App\Models\person',
                //  ]); 
                $this->crud->addColumn([
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
                    
            ]);
            $this->crud->addColumn([
                'label' => 'Product',
                'type' => 'text',
                'name' => 'product',
                
            ]);  
                $this->crud->addColumn([
                    'label' => 'Quantity',
                    'type' => 'number',
                    'name' => 'quantity',
                     
            ]);
            $this->crud->addColumn([
                'label' => 'Second',
                'type' => 'time',
                'name' => 'second',
               
            ]);
        
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
                $this->crud->addField([
                    'label' => 'Communication Type',
                    'type' => 'select',
                    'name' => 'communication_types_id',
                    'type' => 'select_from_array',
                    'options' => [
                                  'Complaint' => 'Complaint',        
                                ],
                    'wrapper'   => [ 
                    'class' => 'form-group col-md-6'
                                ], 
                                'value'=> 'Complaint', 
                ]);
                $this->crud->addField([
                    'label' => 'Owner',
                    'type' => 'select',
                    'name' => 'user_id',
                    'attribute' =>'name', 
                    'entity' => 'user', 
                    'model' => 'App\Models\user',
                  'wrapper'   => [ 
                    'class' => 'form-group col-md-6'
                 ]    
                ]);
                $this->crud->addColumn([
                    'label' => 'Case_number',
                    'type' => 'model_function',
                    'function_name' => 'getcasenumber'
                ]);

                $this->crud->addField([
                    'label' => 'Owner',
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
                        'label' => 'Company',
                        'type' => 'select',
                        'name' => 'person_id',
                        'attribute' =>'name', 
                        'entity' => 'person', 
                        'model' => 'App\Models\person',
                    'wrapper'   => [ 
                        'class' => 'form-group col-md-6'
                    ], 
                    'default' => request()->input('person_id', ''),
            ]);
           
                $this->crud->addField([
                    'label' => 'Type',
                    'type' => 'select',
                    'name' => 'comp_type',
                    'type' => 'select_from_array',
                    'options' => [
                                  'Product' => 'Product',     
                                  'Service' => 'Service',        
                                ],
                    'wrapper'   => [ 
                    'class' => 'form-group col-md-6'
                                ], 
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
                'label' => 'Second',
                'type' => 'number',
                'name' => 'second',
                'wrapper'   => [ 
                    'class' => 'form-group col-md-6'
                ]   
            ]);
            $this->crud->addField([
                'name' => 'status',
                'type'        => 'radio',
                'options'     => [
                   0 => "Resolved",
                    1 => "UnResolved"
                ],
                'label' => "Status",
                'wrapper'   => [ 
                  'class' => 'form-group col-md-6'
                ],
              ]);
            $this->crud->addField([
                'label' => 'Remarks',
                'type' => 'tinymce',
                'name' => 'remarks',
                'wrapper'   => [ 
                    'class' => 'form-group col-md-12'
                ]   
            ]);
    
                    // fields
        
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
                $this->crud->setUpdateContentClass('col-md-12');
                $this->setupCreateOperation();
            }
        
        protected function setupShowOperation()
        {
            $this->crud->setShowContentClass('col-md-12');
            $this->crud->set('show.setFromDb', false);
               $this->crud->addColumn([
                'label' => 'Case_number',
                'type' => 'model_function',
                'function_name' => 'getcasenumber'
            ]);
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
                     'attribute' =>'name', 
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
                 'label' => 'Communication Type',
                 'type' => 'select',
                 'name' => 'communication_types_id',
                 'type' => 'select_from_array',
                 'options' => [
                               'Complaint' => 'Complaint',
                             ],
               
             ]);
             $this->crud->addColumn([
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
                 
         ]);
   
         $this->crud->addColumn([
            'name' => 'status',
            'type'        => 'radio',
            'options'     => [
               0 => "Resolved",
                1 => "UnResolved"
            ],
            'label' => "Status",
            'wrapper'   => [ 
              'class' => 'form-group col-md-6'
            ],
                  
         ]);
         $this->crud->addColumn([
             'label' => 'Second',
             'type' => 'time',
             'name' => 'second',
            
         ]);
         $this->crud->addColumn([
             'label' => 'Remarks',
             'type' => 'textarea',
             'name' => 'remarks',
             
         ]);
             
        }
    }