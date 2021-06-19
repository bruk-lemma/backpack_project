<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ComRequest;
use Backpack\CRUD\app\Library\Widget;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
//use vendor\backpack\crud\src\resources\views\crud\fields\customGoogleMaps;
use vendor\backpack\crud\src\resources\views\crud\fields\customGoogleMaps;
use vendor\backpack\crud\src\resources\views\crud\filters\date_range_refresh;
use App\Models\Communication;

/**
 * Class ComCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ComCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Com::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/com');
        CRUD::setEntityNameStrings('com', 'coms');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {

        //CRUD::setFromDb();
        $this->crud->addColumn([
            'name'  => 'address-input', // do not change this
            // 'type'  => 'customGoogleMaps', // do not change this
             'label' => "Google Maps",
             //'hint'  => 'Help text',
             ]);
        $this->crud->addColumn([
             'label' => 'other address',
           //'type' => 'json',
             'name' => 'address',
        ]);
    /*    $this->crud->addFilter([
            'name'  => 'updated_from_to',
            'label' => trans('common.updated_range'),
            'type'  => 'date_range',
            ],
            false,
            function ($value) { // if the filter is active, apply these constraints
                $dates = json_decode($value);
                $this->crud->addClause('where', 'updated_at', '>=', $dates->from);
                $this->crud->addClause('where', 'updated_at', '<=', $dates->to . ' 23:59:59');
                $Machinesd=Communication::Where('communication_types_id','=','Out Of Stock')
                ->whereIn('product_id', [25,26,27,28,29,30,31,32,33,34,35,36,37,38,70,71,72,73,74,75])
                ->Where('created_at', '>=', $dates->from)
                ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();

                $Other_Product=Communication::Where('communication_types_id','=','Out Of Stock')
                ->whereNotIn('product_id', [25,26,27,28,29,30,31,32,33,34,35,36,37,38,70,71,72,73,74,75])
                ->Where('created_at', '>=', $dates->from)
                ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
                Widget::add([
                    'type' => 'div',
                    'class' =>'row',
                    'content' => [
                        ['type' => 'chart','class' =>'Column', 'wrapper' => ['class'=> 'col-md-4'] ,'controller' => \App\Http\Controllers\Admin\Charts\CatalogChartController::class],],
                    'default' => \Request::has($Machinesd)?\Request::has('title'):false,
                   ]);
            });
        CRUD::setFromDb(); // columns
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
            'label' => 'Case_number',
            'type' => 'model_function',
            'function_name' => 'getcasenumber'
        ]);

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
*/
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
        CRUD::setValidation(ComRequest::class);
        $this->crud->addField([
            'label' => 'Is this a featured article?',
            'name' => 'featured', // can be a real db field, or unique name
            'type' => 'radio',
            'toggle' => true,
            'options' => [ // same as radio, these act as the options, the key is the radio value
                0 => 'Not Featured',
                1 => 'Yes Featured'
            ],
            'hide_when' => [ // these fields hide (by name) when the key matches the radio value
                0 => ['featured_image', 'featured_title'],
                1 => ['basic_title']
            ],
            'default' => 0 // which option to select by default
        ]);

        $this->crud->addfield([
            'name'  => 'featured_title',
            //'type'  => 'textarea',
            'label' => 'Article Description',
        ]);
        $this->crud->addfield([
            'name'  => 'basic_title',
            //'type'  => 'textarea',
            'label' => 'Article Description',
        ]);
         //CRUD::setFromDb(); // fields
         /*
         $this->crud->addField([   // Address google
            'name'          => 'address',
            'label'         => 'Address',
            'type'          => 'address_algolia',
            // optional
            'store_as_json' => true
         ]);
         $this->crud->addField([   // Address google
            'name'          => 'address',
            'label'         => 'Address',
            'type'          => 'address_google',
            // optional
            'store_as_json' => true
         ]);
     */
         /*$this->crud->addField([   // Address google
            'name'    => 'address',
            'label'   => 'Address',
            'type'    => 'address_google',
            //'store_as_json' => true,
            // optional
            ]);
*/
        /* $this->crud->addField([
            'name'  => 'address-input', // do not change this
            'type'  => 'customGoogleMaps', // do not change this
            'label' => "Google Maps",
            'hint'  => 'Help text',
            'store_as_json' => true,
            'attributes' => [
            'class' => 'form-control map-input', // do not change this, add more classes if needed
            ],
            //'store_as_json' => true,
            'view_namespace' => 'custom-google-maps-field-for-backpack::fields'
            ]);
*/
         /*$this->crud->addField(
            [   // Address google
                'name'          => 'address',
                'label'         => 'Address',
                'type'          => 'address_google',
                // optional
                'store_as_json' => true
            ],
         );*/
        /*$this->crud->addField([
            'name'  => 'address-input', // do not change this
            'type'  => 'customGoogleMaps', // do not change this
            'label' => "Google Maps",
            'hint'  => 'Help text',
            'attributes' => [
                'class' => 'form-control map-input', // do not change this, add more classes if needed
            ],
            'view_namespace' => 'custom-google-maps-field-for-backpack::fields',
        ]);
        */
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
