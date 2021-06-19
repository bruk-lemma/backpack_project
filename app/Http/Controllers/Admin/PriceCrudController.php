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
class PriceCrudController extends CrudController
{
   
   
    
   
        // use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
        use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
        // use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
        use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    
        /**
         * Configure the CrudPanel object. Apply settings to all operations.
         * 
         * @return void
         */
        public function setup()
        {
            CRUD::setModel(\App\Models\Communication::class);
            CRUD::setRoute(config('backpack.base.route_prefix') . '/Price');
            CRUD::setEntityNameStrings('Price', 'Price');
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
            $this->crud->addButtonFromView('top', 'complaint', 'complaint', 'begining');
            $this->crud->addButtonFromView('top', 'evaluation', 'evaluation', 'begining');
            $this->crud->addButtonFromView('top', 'price', 'price', 'begining');
            $this->crud->addButtonFromView('top', 'outofstock', 'outofstock', 'begining');
            $this->crud->addButtonFromView('top', 'outoflist', 'outoflist', 'begining');        
            $this->crud->addButtonFromView('top', 'sells', 'sells', 'begining');
      
            $this->crud->addClause('where', 'communication_types_id', '=', 'Price');
                
            $this->crud->addFilter([
              'name'  => 'communication_ways_id',
              'type'  => 'dropdown',
              'label' => 'Communication',
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
              
        //     $this->crud->addColumn([
        //       'label' => 'Communication',
        //       'type' => 'select',
        //       'name' => 'communication_types_id',
        //       'type' => 'select_from_array',
        //       'options' => [
        //                     'Out Of Stock' => 'Out Of Stock',
        //                     'Out Of List' => 'Out Of List',
        //                     'Complaint' => 'Complaint',
        //                     'Price' => 'Price',
        //                     'Evaluation' => 'Evaluation',
        //                   ],
            
        //   ]);
                  //   $this->crud->addColumn([
            //     'label' => 'Case Number',
            //     'type' => 'text',
            //     'name' => 'id',
            // ]);  
            
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
              'type' => 'select',
              'label' => "Landline",
              'name' => 'personphone_id',
              'attribute' =>'landline', 
              'entity' => 'person', 
              'model' => 'App\Models\person',
          ]);
          $this->crud->addColumn([
            'name' => 'personemail_id',
            'type' => 'select',
            'label' => "Mobile",
            'entity' => 'person', 
            'attribute' =>'mobile_number', 
            'model' => 'App\Models\person',    
            'wrapper'   => [ 
                'class' => 'form-group col-md-12'
            ]   
          ]);
          $this->crud->addColumn([
              'name' => 'personsource_id',
              'type' => 'select',
              'label' => "lead Source",
              'entity' => 'person', 
              'attribute' =>'source', 
              'model' => 'App\Models\person',    
              'wrapper'   => [ 
                  'class' => 'form-group col-md-12'
              ]   
              ]); 
          $this->crud->addColumn([
              'label' => 'Lead Owner',
              'type' => 'select',
              'name' => 'user_id',
              'attribute' =>'name', 
              'entity' => 'user', 
              'model' => 'App\Models\user',
          ]); 
          $this->crud->addColumn([
            'name' => 'person_id',
            'type' => 'select',
            'label' => "Email",
            'entity' => 'person', 
            'attribute' =>'created_at', 
            'model' => 'App\Models\person',    
            'wrapper'   => [ 
                'class' => 'form-group col-md-12'
            ]   
          ]); 
            
    
        
            // $this->crud->addColumn([
            //     'label' => 'Communicated_By',
            //     'type' => 'select',
            //     'name' => 'user_id',
            //     'attribute' =>'name', 
            //     'entity' => 'user', 
            //     'model' => 'App\Models\user',
                
            // ]); 
            //     $this->crud->addColumn([
            //         'label' => 'Company',
            //         'type' => 'select',
            //         'name' => 'person_id',
            //         'attribute' =>'company_name', 
            //         'entity' => 'person', 
            //         'model' => 'App\Models\person',
                 
            // ]);
            // $this->crud->addColumn([
            //     'label' => 'Type',
            //     'type' => 'select',
            //     'name' => 'type',
            //     'attribute' =>'type', 
            //     'entity' => 'person', 
            //     'model' => 'App\Models\person',
            //  ]); 
        //     $this->crud->addColumn([
        //         'label' => 'Communication',
        //         'type' => 'select_from_array',
        //         'name' => 'communication_ways_id',
        //         'allows_null' => true, 
        //         'options' => [
        //             'Phone' => 'Phone',
        //             'Telegram' => 'Telegram',
        //             'Physical' => 'Physical',
        //             'E-Mail' => 'E-Mail',
        //             'Facebook' => 'Facebook',
        //           ],
                
        // ]);
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
        //  $this->crud->addButtonFromView('top', 'see_detail', 'see_detail', 'beginning');
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
                 'attribute' =>'company_name', 
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