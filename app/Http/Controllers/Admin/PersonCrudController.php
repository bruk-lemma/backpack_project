<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PersonRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\CRUD\app\Library\Widget;
use App\Http\Controllers\Admin\Charts\EvaluationForEveryProductChartController;
use App\Models\Communication;
use App\Models\Product;

/**
 * Class PersonCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PersonCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Person::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/person');
        CRUD::setEntityNameStrings('person', 'people');
        $this->crud->addFilter([
            'name'  => 'updated_from_to',
            'label' => trans('common.updated_range'),
            'type'  => 'date_range',
            ],
            false,
            function ($value) { // if the filter is active, apply these constraints
                $dates = json_decode($value);
                $this->crud->addClause('where', 'updated_at', '>=', $dates->from);
                $this->crud->addClause('where', 'updated_at', '<=', $dates->to . ' 23:59:59');
            });


           /* Widget::add([
                'type' => 'div',
                'class' =>'row',
                'content' => [
                    ['type' => 'chart','class' =>'Column','wrapper' => ['class'=> 'col-sm-12 col-md-12 '] ,['header' => 'Machine Stock Out'],'controller' => \App\Http\Controllers\Admin\Charts\EvaluationForEveryProductChartController::class,],
                   // ['type' => 'chart','class' =>'Column', 'wrapper' => ['class'=> 'col-md-4'] ,'controller' => \App\Http\Controllers\Admin\Charts\ProductComplaintChartController::class,],
                   // ['type' => 'chart','class' =>'Column', 'wrapper' => ['class'=> 'col-md-4'] ,'controller' => \App\Http\Controllers\Admin\Charts\ServiceComplaintChartController::class,],
                ]

               ]);*/


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
        CRUD::setValidation(PersonRequest::class);

        CRUD::setFromDb(); // fields
        $this->crud->addField([

            'label' => 'Company',
            'type' => 'hidden',
            'name' => 'person_id',
            'attribute' =>'company_name',
            'attributes' => [
                'readonly'    => 'readonly',
              ],
            'default' => request()->input('person_id', ''),

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
