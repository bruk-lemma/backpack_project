<?php
namespace App\Http\Controllers\Admin;

use App\Http\Requests\FirstpageRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class FirstpageCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class FirstpageCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\person::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/firstpage');
        CRUD::setEntityNameStrings('Company', 'Companies');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->addColumn([
            'name' => 'id',
            'type' => 'text',
            'label' => "ID",
            ]);
            $this->crud->addColumn([
              'name' => 'company_name',
              'type' => 'text',
              'label' => "Company",
              'link' => function($entry) {
                return backpack_url('creator/'.$entry->id.'/snippet');
              }
            ]);
            $this->crud->addColumn([
                'label' => 'Lead Name',
                'type' => 'text',
                'name' => "name"
            ]);
            $this->crud->addColumn([
                'name' => 'type',
                'type' => 'text',
                'label' => "Type"
            ]);
            $this->crud->addColumn([
                'name' => 'phone_number',
                'type' => 'text',
                'label' => "Phone"
            ]);
            $this->crud->addColumn([
                'name' => 'email',
                'type' => 'text',
                'label' => "Email"
            ]);
            $this->crud->addColumn([
                'name' => 'source',
                'type' => 'text',
                'label' => "Lead Source"
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
              'label' => 'Created At',
              'type' => 'date',
              'name' => 'created_at',
          ]); 
        return view('dashboard');

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
}