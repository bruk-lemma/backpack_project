<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\NoteRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class Perosn_taskCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class noteCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Note::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/note');
        CRUD::setEntityNameStrings('note', 'Note');
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
        $this->crud->setCreateContentClass('col-md-12');    
        // $this->crud->addClause('where', 'person_id', '=', request()->input('person_id', ''));
        CRUD::removeButton('edit');
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
            'label' => 'Note',
            'type' => 'textarea',
            'name' => 'note',
         
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
        CRUD::setValidation(NoteRequest::class);
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
            ]     
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
        $this->crud->addfield([
            'label' => 'Note',
            'type' => 'textarea',
            'name' => 'note',
         
    ]);
    // $this->crud->addfield([
    //     'label' => 'Type',
    //     'type' => 'hidden',
    //     'name' => 'type',
    //     'attribute' =>'type', 
    //     'entity' => 'person', 
    //     'model' => 'App\Models\person',
    //  ]); 
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
            'label' => 'Type',
            'type' => 'select',
            'name' => 'type',
            'attribute' =>'type', 
            'entity' => 'person', 
            'model' => 'App\Models\person',
    ]); 
        $this->crud->addColumn([
            'label' => 'Note',
            'type' => 'textarea',
            'name' => 'note',
         
    ]);}}