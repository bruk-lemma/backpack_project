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
class Create_customer_communicationCrudController extends CrudController
{
   
    
        use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
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
            CRUD::setRoute(config('backpack.base.route_prefix') . '/create_customer_communication');
            CRUD::setEntityNameStrings('Communication', 'Communications');
        }
    
        /**
         * Define what happens when the List operation is loaded.
         * 
         * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
         * @return void
         */
        protected function setupListOperation()
        {          
            // $this->crud->addButtonFromView('top', 'all_com', 'all_com', 'begining');
            $this->crud->addButtonFromView('top', 'complaint', 'complaint', 'begining');
            $this->crud->addButtonFromView('top', 'evaluation', 'evaluation', 'begining');
            $this->crud->addButtonFromView('top', 'price', 'price', 'begining');
            $this->crud->addButtonFromView('top', 'outofstock', 'outofstock', 'begining');
            $this->crud->addButtonFromView('top', 'outoflist', 'outoflist', 'begining');        
            $this->crud->addButtonFromView('top', 'sells', 'sells', 'begining');
      
       
            $this->crud->setCreateContentClass('col-md-12');
            $this->crud->addFilter([
                'name'  => 'communication_types_id',
                'type'  => 'dropdown',
                'label' => 'Communication Type'
              ], [
                'Out Of Stock' => 'Out Of Stock',
                'Out Of List' => 'Out Of List',
                'Complaint' => 'Complaint',
                'Price' => 'Price',
                'Evaluation' => 'Evaluation',
              ], function($value) { // if the filter is active
                $this->crud->addClause('where', 'communication_types_id', $value);
              });
          
            $this->crud->addColumn([
                'label' => 'Communication Type',
                'type' => 'select',
                'name' => 'communication_types_id',
                'type' => 'select_from_array',
                'options' => [
                              'Out Of Stock' => 'Out Of Stock',
                              'Out Of List' => 'Out Of List',
                              'Complaint' => 'Complaint',
                              'Price' => 'Price',
                              'Evaluation' => 'Evaluation',
                              'Sells' => 'Sells',
                            ],
              
            ]);
            $this->crud->addColumn([
                'label' => 'Case Number',
                'type' => 'text',
                'name' => 'id',
             
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
        // $this->crud->addColumn([
        //     'label' => 'Product',
        //     'type' => 'text',
        //     'name' => 'product',
            
        // ]);  
        //     $this->crud->addColumn([
        //         'label' => 'Quantity',
        //         'type' => 'number',
        //         'name' => 'quantity',
                 
        // ]);
        // $this->crud->addColumn([
        //     'label' => 'Second',
        //     'type' => 'time',
        //     'name' => 'second',
           
        // ]);
    
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
                    'type' => 'hidden',
                    'name' => 'person_id',
                    'attribute' =>'company_name',   
                    'attributes' => [
                        'readonly'    => 'readonly',
                        // 'disabled'    => 'disabled',
                      ], 
                    'default' => request()->input('person_id', ''),
                
            ]);
            $this->crud->addField([
                'label' => 'Type',
                'type' => 'select',
                'name' => 'communication_types_id',
                'type' => 'select_from_array',
                'options' => [
                              'Out Of Stock' => 'Out Of Stock',
                              'Out Of List' => 'Out Of List',
                              'Complaint' => 'Complaint',
                              'Price' => 'Price',
                              'Evaluation' => 'Evaluation',
                              'Sells' => 'Sells',
                            ],
                'allows_null' => true, 
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
            'label' => 'All Day(If Complaint)',
            'type' => 'radio',
            'name' => 'comp_type',
            'options' => [
                0 => "product",
                1 => "Service",
            ],
            'wrapper'   => [ 
            'class' => 'form-group col-md-6'
        ]  
        ]);
        $this->crud->addField([
            'label' => 'Product',
            'type' => 'text',
            'name' => 'product',
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
         $this->crud->addColumn([
             'label' => 'Case Number',
             'type' => 'text',
             'name' => 'code',
          
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
             'name' => 'communication_types_id',
             'type' => 'select_from_array',
             'options' => [
                           'Out Of Stock' => 'Out Of Stock',
                           'Out Of List' => 'Out Of List',
                           'Complaint' => 'Complaint',
                           'Price' => 'Price',
                           'Evaluation' => 'Evaluation',
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
     $this->crud->addColumn([
         'label' => 'Remarks',
         'type' => 'textarea',
         'name' => 'remarks',
         
     ]);
         
    }
}