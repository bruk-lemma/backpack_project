<?php

namespace App\Http\Controllers\Admin;
USE Auth;
use App\Http\Requests\PersonRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class LeadConversionCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ContactConversionCrudController extends CrudController
{
    // use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Person::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/contactconversion');
        CRUD::setEntityNameStrings('', 'Are You Sure you want to converet Contact To Customer');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    
    {
        $this->crud->addClause('where', 'type', '=', 'Contact');
        
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
    {   $this->crud->addClause('where', 'type', '=', 'Contact');
        CRUD::setValidation(PersonRequest::class);
        $this->crud->setCreateContentClass('col-md-12');
       
     
      $this->crud->addField([
        'label' => 'Lead Owner',
        'type' => 'select',
        'name' => 'user_id',
        'attribute' =>'name', 
        'entity' => 'user', 
        'model' => 'App\Models\user',
      'wrapper'   => [ 
        'class' => 'form-group col-md-6'
      ], 
     'default' => request()->input('person_id', ''),   
]); 
     
      $this->crud->addField([
          'name' => 'company_name',
          'type' => 'text',
          'label' => "Company",
          'attributes' => [
            'class' => 'form-control',
          ],
          'wrapper'   => [ 
            'class' => 'form-group col-md-6'
        ],
        ]); 
        $this->crud->addField(['type' => 'hidden', 
        'name' => 'type',
    'default'=>'Customer']);
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
      $this->crud->addField(['type' => 'hidden', 
      'name' => 'type',
  'value'=>'Customer']);
  


  $this->crud->addField([
    'label' => 'Converted By',
    'type' => 'hidden',
    'name' => 'Contact_Converted_By',

  'value' => Auth::guard('backpack')->user()->name


    ]); 


$this->crud->addField([
  'name' => 'Contact_Converted_date',
  'label' => 'Converted Date',
  'type' => 'hidden',
  'default' => date("Y-m-d H:i:s"),
]);

}}
