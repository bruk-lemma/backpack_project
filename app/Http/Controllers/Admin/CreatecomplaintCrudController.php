<?php

namespace App\Http\Controllers\Admin;
use AUTH;
use App\Http\Requests\CreatecomplaintRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class CreatecomplaintCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CreatecomplaintCrudController extends CrudController
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
        CRUD::setModel(\App\Models\communication::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/createcomplaint');
        CRUD::setEntityNameStrings('complaint', 'complaints');
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
        CRUD::setValidation(CreatecomplaintRequest::class);

        // CRUD::setValidation(CommunicationRequest::class);
        $this->crud->setCreateContentClass('col-md-12');
        $this->crud->addField([
            'label' => 'Communication Type',
            'type' => 'hidden',
            'name' => 'communication_types_id',
            // 'type' => 'select_from_array',
            'options' => [
                          'Complaint' => 'Complaint',        
                        ],
            
                        'value'=> 'Complaint', 
        ]);
        $this->crud->addField([
            'label' => 'Communicated By:',
            'type' => 'hidden',
            'name' => 'user_id',

            'value' => Auth::guard('backpack')->user()->id
        ]);
        // $this->crud->addField([
        //     'label' => 'Case Number',
        //     'type' => 'text',
        //     'name' => 'code',
        //     'wrapper'   => [ 
        //     'class' => 'form-group col-md-6'
        // ]   
        // ]);  
     
            $this->crud->addField([
                'label' => 'Company',
                'type' => 'hidden',
                'name' => 'person_id',
                'attribute' =>'company_name', 
                'entity' => 'person', 
                'model' => 'App\Models\person',
     
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
            'label' => 'Type',
            'type' => 'hidden',
            'name' => 'typ',
         'value' => 'C',
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
        'type' => 'textarea',
        'name' => 'remarks',
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
