<?php

namespace App\Http\Controllers\Admin;
use Auth;
use App\Http\Requests\CreatesellsRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class CreateevaluationCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CreatesellsCrudController extends CrudController
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
        CRUD::setModel(\App\Models\communication::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/createsells');
        CRUD::setEntityNameStrings('Sells', 'Sells');
        // $this->crud->setUpdateView('vendor.backpack.base.rating');
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
        CRUD::setValidation(CreatesellsRequest::class);
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

                'label' => 'Company',
                'type' => 'hidden',
                'name' => 'person_id',
                'attribute' =>'company_name',
                'attributes' => [
                    'readonly'    => 'readonly',
                  ],
                'default' => request()->input('person_id', ''),

        ]);

        $this->crud->addfield([


            'type' => 'hidden',
            'name' => 'record_by',

            'value' => Auth::guard('backpack')->user()->name
          ]);
        $this->crud->addField([
            'label' => 'Type',
            'type' => 'hidden',
            'name' => 'sells_status',
            'options' => [
                          'Not Delivered' => 'Not Delivered',
                        ],
            'allows_null' => true,

        'value'=> 'Not Delivered',
        ]);
        $this->crud->addField([
            'label' => 'Type',
            'type' => 'hidden',
            'name' => 'sellsrecord_status',

            'options' => [
                          'Not Recorded' => 'Not Recorded',
                        ],
            'allows_null' => true,

        'value'=> 'Not Recorded',
        ]);
        $this->crud->addField([
            'label' => 'Sells By:',
            'type' => 'hidden',
            'name' => 'user_id',

            'value' => Auth::guard('backpack')->user()->id
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
        'label' => 'Product',
        'type' => 'select',
        'name' => 'product_id',
        'attribute' =>'product_name',
        'entity' => 'product',
        'model' => 'App\Models\product',
        'wrapper'   => [
        'class' => 'form-group col-md-6'
    ]
    ]);
    $this->crud->addField([
        'label' => 'Type',
        'type' => 'hidden',
        'name' => 'typ',
     'value' => 'S',
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
        'name' => 'sells_type',
        'type'        => 'radio',
        'options'     => [
            'Delivery' => "Delivery",
            'Physical Sells' => "Physical Sells"
        ],
        'label' => "Sells",
        'wrapper'   => [
          'class' => 'form-group col-md-6'
        ],
        'hide_when' => [
            'Physical Sells'  => ['status'],
            ],
]);
// 'type' => 'toggle', is not working
// $this->crud->addField([
// 'label' => 'Product Category',
// 'name' => 'choice', // can be a real db field, or unique name
// 'type' => 'toggle',
// 'options' => [ // same as radio, these act as the options, the key is the radio value
//     0 => 'Category',
//     1 => 'Product'
// ],
// 'hide_when' => [ // these fields hide (by name) when the key matches the radio value
//     0 => ['subject'],
//     1 => ['']
// ],
// 'default' => 0 // which option to select by default
// ])



// $this->crud->addField([
//     'label' => 'Price Group',
//     'type' => 'select_from_array',
//     'name' => 'price_group',
//     'allows_null' => true,
//     'options' => [
//         'Direct' => 'Direct',
//         'Special' => 'Special',
//         'Mass Order' => 'Mass Order',
//         'Agent Price' => 'Agent Price',
//         'Yale' => 'Yale',
//       ],
//     'wrapper'   => [
//     'class' => 'form-group col-md-6'
// ]
// ]);

// $this->crud->addField(
//     [   'label' => 'Vat Type',
//         'type' => 'select_from_array',
//             'name' => 'vat_type',
//             'allows_null' => true,
//             'options' => [
//                 'With Vat' => 'With Vat',
//                 'With Out Vat' => 'With Out Vat',

//               ],
//             'wrapper'   => [
//             'class' => 'form-group col-md-6'
//         ]

//     ]);
//     $this->crud->addField(
//         [
//             'label' => 'Payment Term',
//             'name' => 'payment_term',
//             'type' => 'select_from_array',

//                 'allows_null' => true,
//                 'options' => [
//                     'Cash' => "Cash",
//                     'Bank Transfer' => "Bank Transfer",

//                   ],
//                 'wrapper'   => [
//                 'class' => 'form-group col-md-6'
//             ]


//         ]);
    $this->crud->addField([
        'label' => 'Unit Price',
        'type' => 'TEXT',
        'name' => 'unit_price',
        'wrapper'   => [
            'class' => 'form-group col-md-6'
        ]
    ]);
$this->crud->addField([
    'label' => 'Total Price',
    'type' => 'TEXT',
    'name' => 'total_payment',
    'wrapper'   => [
        'class' => 'form-group col-md-6'
    ]
]);


$this->crud->addField(
            [
                'label' => 'Delivery_Date',
                'name' => '	delivery_date',
                'type' => 'select_from_array',
                'inline' => true,
                'options' => [
                   'Express' => "Express",
                    'Normal' => "Normal",
                ],
                'wrapper'   => [
                    'class' => 'form-group col-md-6'
                 ]
            ]);
            $this->crud->addField([
                'label' => 'Delivery Payment',
                'type' => 'TEXT',
                'name' => 'delivery_payment',
                'wrapper'   => [
                    'class' => 'form-group col-md-6'
                ]
            ]);
            $this->crud->addField(
                [
                    'label' => 'Delivered by',
                    'name' => '	delivered_by',
                    'type' => 'select_from_array',
                    'inline' => true,
                    'options' => [
                       'Outsource' => "Outsource",
                        'Company Property' => "Company Property",
                    ],
                    'wrapper'   => [
                        'class' => 'form-group col-md-6'
                     ]
                ]);
            $this->crud->addField([

                    'label' => 'Assigned Person',
                    'name' => 'assigned_person',
                    'type' => 'select',
                    'attribute' =>'name',
                    'entity' => 'user',
                    'model' => 'App\Models\user',

                  'wrapper'   => [
                    'class' => 'form-group col-md-6'
                  ],
                ]);


// '',
// 'assigned_person',
// '',
// '',
// 'Delivery_number',
// 'location',
// 'phone',
//    $this->crud->addField(
//         [
//             'label' => 'Delivery',
//             'name' => 'sells_status',
//             'type' => 'radio',
//             'inline' => true,
//             'options' => [
//                'Delivered' => "Delivered",
//                 'Not Delivered' => "Not Delivered",
//             ],
//             'wrapper'   => [
//                 'class' => 'form-group col-md-6'
//              ]
//         ]);

   $this->crud->addField([
        'label' => 'Branch',
        'type' => 'select_from_array',
        'name' => 'branch',
        'inline' => true,
        'options' => [
           'Xshop' => "Xshop",
            'Brain' => "Brain",
        ],
        'wrapper'   => [
            'class' => 'form-group col-md-6'
         ]

    ]);
    $this->crud->addField([
        'label' => 'Remarks',
        'type' => 'textarea',
        'name' => 'remarks',
        'wrapper'   => [
            'class' => 'form-group col-md-6'
        ]
    ]);
    $this->crud->addField([

        'name'  => 'status',
        'label' => 'Done',
        'type'  => 'checkbox',
        'wrapper'   => [
            'class' => 'form-group col-md-6'
          ],

    ]);
    $this->crud->addField([
        'label' => 'Type',
        'type' => 'hidden',
        'name' => 'communication_types_id',

        'options' => [
                      'Sells' => 'Sells',
                    ],
        'allows_null' => true,

    'value'=> 'Sells',
    ]);
    $this->crud->addField([
        'label' => 'Delivery_number',
        'type' => 'hidden',
        'name' => 'Delivery_number',
        'value' => \App\Models\Communication::where('sells_type','Delivery')->count()+1,
        'wrapper'   => [
            'class' => 'form-group col-md-6'
        ]
    ]);


    // $this->crud->addField([

    //     'label' => 'rating',
    //     'type' => 'text',
    //     'name' => 'rating',
    //     // 'attribute' =>'company_name',
    //     'attributes' => [
    //         'readonly'    => 'readonly',
    //       ],
    //       ]);
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
      CRUD::setValidation(CreatesellsRequest::class);
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
            'attributes' => [
                'readonly'    => 'readonly',
              ],
            'default' => request()->input('person_id', ''),

    ]);

    $this->crud->addfield([


        'type' => 'hidden',
        'name' => 'record_by',

        'value' => Auth::guard('backpack')->user()->name
      ]);
    $this->crud->addField([
        'label' => 'Type',
        'type' => 'hidden',
        'name' => 'sells_status',

        'options' => [
                      'Not Delivered ' => 'Not Delivered',
                    ],
        'allows_null' => true,

    'value'=> 'Not Delivered',
    ]);
    $this->crud->addField([
        'label' => 'Type',
        'type' => 'hidden',
        'name' => 'sellsrecord_status',

        'options' => [
                      'Not Recorded' => 'Not Recorded',
                    ],
        'allows_null' => true,

    'value'=> 'Not Recorded',
    ]);
    $this->crud->addField([
        'label' => 'Sells By:',
        'type' => 'hidden',
        'name' => 'user_id',

        'value' => Auth::guard('backpack')->user()->id
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
        ],

]);
$this->crud->addField([
    'label' => 'Product',
    'type' => 'select',
    'name' => 'product_id',
    'attribute' =>'product_name',
    'entity' => 'product',
    'model' => 'App\Models\product',
    'wrapper'   => [
    'class' => 'form-group col-md-6'
]
]);
$this->crud->addField([
    'label' => 'Type',
    'type' => 'hidden',
    'name' => 'typ',
 'value' => 'S',
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
/*$this->crud->addField([
    'name' => 'sells_type',
    'type'        => 'radio',
    'options'     => [
        'Delivery' => "Delivery",
        'Physical Sells' => "Physical Sells"
    ],
    'label' => "Sells",
    'wrapper'   => [
      'class' => 'form-group col-md-6'
    ],
    'hide_when' => [
        'Physical Sells'  => ['status'],
        ],
]);
*/
// $this->crud->addField([
//     'label' => 'Price Group',
//     'type' => 'select_from_array',
//     'name' => 'price_group',
//     'allows_null' => true,
//     'options' => [
//         'Direct' => 'Direct',
//         'Special' => 'Special',
//         'Mass Order' => 'Mass Order',
//         'Agent Price' => 'Agent Price',
//         'Yale' => 'Yale',
//       ],
//     'wrapper'   => [
//     'class' => 'form-group col-md-6'
// ]
// ]);

// $this->crud->addField(
//     [   'label' => 'Vat Type',
//         'type' => 'select_from_array',
//             'name' => 'vat_type',
//             'allows_null' => true,
//             'options' => [
//                 'With Vat' => 'With Vat',
//                 'With Out Vat' => 'With Out Vat',

//               ],
//             'wrapper'   => [
//             'class' => 'form-group col-md-6'
//         ]

//     ]);
//     $this->crud->addField(
//         [
//             'label' => 'Payment Term',
//             'name' => 'payment_term',
//             'type' => 'select_from_array',

//                 'allows_null' => true,
//                 'options' => [
//                     'Cash' => "Cash",
//                     'Bank Transfer' => "Bank Transfer",

//                   ],
//                 'wrapper'   => [
//                 'class' => 'form-group col-md-6'
//             ]
//         ]);
$this->crud->addField([
    'label' => 'Unit Price',
    'type' => 'TEXT',
    'name' => 'unit_price',
    'wrapper'   => [
        'class' => 'form-group col-md-6'
    ]
]);
$this->crud->addField([
'label' => 'Total Price',
'type' => 'TEXT',
'name' => 'total_payment',
'wrapper'   => [
    'class' => 'form-group col-md-6'
]
]);

$this->crud->addField(
        [
            'label' => 'Delivery_Date',
            'name' => '	delivery_date',
            'type' => 'select_from_array',
            'inline' => true,
            'options' => [
               'Express' => "Express",
                'Normal' => "Normal",
            ],
            'wrapper'   => [
                'class' => 'form-group col-md-6'
            ],
             'hide_when' => [
                'sells_type'  => ['Physical Sells'],
                ],
        ]);
        $this->crud->addField([
            'label' => 'Delivery Payment',
            'type' => 'TEXT',
            'name' => 'delivery_payment',
            'wrapper'   => [
                'class' => 'form-group col-md-6'
            ]
        ]);
        $this->crud->addField(
            [
                'label' => 'Delivered by',
                'name' => '	delivered_by',
                'type' => 'select_from_array',
                'inline' => true,
                'options' => [
                   'Outsource' => "Outsource",
                    'Company Property' => "Company Property",
                ],
                'wrapper'   => [
                    'class' => 'form-group col-md-6'
                 ]
            ]);
        $this->crud->addField([

                'label' => 'Assigned Person',
                'name' => 'assigned_person',
                'type' => 'select',
                'attribute' =>'name',
                'entity' => 'user',
                'model' => 'App\Models\user',

              'wrapper'   => [
                'class' => 'form-group col-md-6'
              ],
            ]);
// '',
// 'assigned_person',
// '',
// '',
// 'Delivery_number',
// 'location',
// 'phone',
//    $this->crud->addField(
//         [
//             'label' => 'Delivery',
//             'name' => 'sells_status',
//             'type' => 'radio',
//             'inline' => true,
//             'options' => [
//                'Delivered' => "Delivered",
//                 'Not Delivered' => "Not Delivered",
//             ],
//             'wrapper'   => [
//                 'class' => 'form-group col-md-6'
//              ]
//         ]);

$this->crud->addField([
    'label' => 'Branch',
    'type' => 'select_from_array',
    'name' => 'branch',
    'inline' => true,
    'options' => [
       'Xshop' => "Xshop",
        'Brain' => "Brain",
    ],
    'wrapper'   => [
        'class' => 'form-group col-md-6'
     ]

]);
$this->crud->addField([
    'label' => 'Remarks',
    'type' => 'textarea',
    'name' => 'remarks',
    'wrapper'   => [
        'class' => 'form-group col-md-6'
    ]
]);
$this->crud->addField([

    'name'  => 'status',
    'label' => 'Done',
    'type'  => 'checkbox',
    'wrapper'   => [
        'class' => 'form-group col-md-6'
      ],

]);
$this->crud->addField([
    'label' => 'Type',
    'type' => 'hidden',
    'name' => 'communication_types_id',
    'options' => [
                  'Sells' => 'Sells',
                ],
    'allows_null' => true,

'value'=> 'Sells',
]);
$this->crud->addField([
    'label' => 'Delivery_number',
    'type' => 'hidden',
    'name' => 'Delivery_number',
    'value' => \App\Models\Communication::where('sells_type','Delivery')->count()+1,
    'wrapper'   => [
        'class' => 'form-group col-md-6'
    ]
]);


// $this->crud->addField([

//     'label' => 'rating',
//     'type' => 'text',
//     'name' => 'rating',
//     // 'attribute' =>'company_name',
//     'attributes' => [
//         'readonly'    => 'readonly',
//       ],
//       ]);
}

}
