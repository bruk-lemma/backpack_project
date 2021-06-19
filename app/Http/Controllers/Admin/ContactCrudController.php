<?php

namespace App\Http\Controllers\Admin;
use Auth;
use App\Http\Requests\PersonRequest;
use App\Http\Requests\PersonupdateRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class PersonCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ContactCrudController extends CrudController
{
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
        CRUD::setModel(\App\Models\Person::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/contact');
        CRUD::setEntityNameStrings('contact', 'contacts');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
      
    protected function setupListOperation()
    {
              $this->crud->addClause('where', 'type', '=', 'contact');
              $this->crud->addFilter([
                'name'  => 'statu',
                'type'  => 'dropdown',
                'label' => 'Lead Status'
              ], [
                  'Attempted to contact'=> 'Attempted to contact',
                  'Contact in future'=>'Contact in future',
                  'Junk Lead'=>'Junk Lead',
                  'Contacted'=>'Contacted',
              ], function($value) { // if the filter is active
                $this->crud->addClause('where', 'statu', $value);
              });
              $this->crud->addFilter([
                'name'  => 'source',
                'type'  => 'dropdown',
                'label' => 'Lead Source'
              ], [
                'Advertisement'=>'Advertisement',
                'Cold Call'=>'Cold Call',
                'Employee Referral'=> 'Employee Referral',
                'Online Store' =>'Online Store',
                'Partner'=> 'Partner',
                'Trade Show' =>'Trade Show',
                'Web Research'=> 'Web Research',
                'Physical sales'=> 'Physical sales',
                'Tele marketing'=> 'Tele marketing',
                'Campaign'=>'Campaign',
                'Telegram'=>'Telegram',
                'Facebook'=>'Facebook',
                'Flyer'=>'Flyer',
                'Other'=>'Other',
              ], function($value) { // if the filter is active
                $this->crud->addClause('where', 'source', $value);
              });
              $this->crud->addFilter([
                'name'  => 'rating',
                'type'  => 'dropdown',
                'label' => 'Rating'
              ], [  
                  
                  'Active'=>'Active',
                  'Market Failed'=> 'Market Failed',
                  'Shutdown'=> 'Shutdown',
              ], function($value) { // if the filter is active
                $this->crud->addClause('where', 'rating', $value);
              });
              $this->crud->addFilter([
                'name'  => 'user_id',
                'type'  => 'select2',
                'label' => 'Lead Owner'
              ], function() {
                  return \App\Models\User::all()->pluck('name', 'id')->toArray();
              }, function($value) { // if the filter is active
                  $this->crud->addClause('where', 'user_id', $value);
              });
              $this->crud->addFilter([
                'type'  => 'date',
                'name'  => 'created_at',
                'label' => 'Created Date'
              ],
                false,
              function ($value) { // if the filter is active, apply these constraints
                $this->crud->addClause('where', 'created_at', $value);
              });
              $this->crud->addFilter([
                'type'  => 'date',
                'name'  => 'updated_at',
                'label' => 'Modified Date'
              ],
                false,
              function ($value) { // if the filter is active, apply these constraints
                $this->crud->addClause('where', 'updated_at', $value);
              });
            //   $this->crud->addColumn([
            //     'name' => 'image',
            //     'type' => 'text',
            //     'label' => "Lead Image"
            // ]);
                 
                  $this->crud->addColumn([
                      'label' => 'Lead Name',
                      'type' => 'text',
                      'name' => "name"
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
                    'name' => 'Landline',
                    'type' => 'text',
                    'label' => "Landline"
                ]);
              
              $this->crud->addColumn([
                'name' => 'mobile_number',
                'type' => 'text',
                'label' => "Mobile"
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
        $this->crud->setCreateContentClass('col-md-12');
       
        // CRUD::setFromDb();
        // $this->crud->addField([
        //     'name' => 'lead_owner',
        //     'type' => 'text',
        //     'label' => "Lead Owner"
        //   ]);
        $this->crud->addField([
          'name' => 'image', 
          'aspect_ratio' => 1,      
          'crop' => true,
          'type' => 'image',
          'label' => "Lead Image",
        'wrapper'   => [ 
          'class' => 'form-group col-md-12'
       ],
      ]); 
      
  //       $this->crud->addField([
  //         'name' => 'phone_number',
  // $this->crud->addFilter([
  //   'type'  => 'text',
  //   'name'  => 'phone_number',
  //   'label' => 'Serch',
  // // function($value) { // if the filter is active
  //   // $this->crud->addClause('where', 'description', 'LIKE', "%$value%");
  //   'wrapper'   => [ 
  //     'class' => 'form-group col-md-6'
  //  ],auth::guard('backpack')->user()->name 
  // ]); 
  // $id=auth::guard('backpack')->user('name')->id;
      $this->crud->addField([
        'label' => 'Lead Owner',
        'type' => 'select',
        'name' => 'user_id',
        'attribute' =>'name', 
        'entity' => 'user', 
        'model' => 'App\Models\user',
      'wrapper'   => [ 
        'class' => 'form-group col-md-6'
     ]    
]); 
      // Hidden
      // $this->crud->request->request->add(['user_id' => \Auth::user()->id]);
      $this->crud->addField(['type' => 'hidden', 'name' => 'user_id']);
      
      // $response = $this->traitStore();
      //  return $response;   
      $this->crud->addField([
        'name' => 'facebook',
        'type' => 'text',
        'label' => "Facebook",
        'wrapper'   => [ 
          'class' => 'form-group col-md-6'
        ],
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
      
        $this->crud->addField([
          'name' => 'telegram',
          'type' => 'text',
          'label' => "Telegram",
          'wrapper'   => [ 
            'class' => 'form-group col-md-6'
          ],
        ]);
        $this->crud->addField([
          'name' => 'name',
          'type' => 'text',
          'attributes' => [
          'class' => 'form-control',

          ],
          'wrapper'   => [ 
            'class' => 'form-group col-md-6'
         ],
          'label' => "Name",

        ]);
        $this->crud->addField([
        'name' => 'email',
        'type' => 'text',
        'label' => "Email",
        'wrapper'   => [ 
              'class' => 'form-group col-md-6'
           ],
        ]);
      
        $this->crud->addField([
            'name' => 'gender',
            'type'        => 'radio',
            'options'     => [
               0 => "Female",
                1 => "Male"
            ],
            'label' => "Gender",
            'wrapper'   => [ 
              'class' => 'form-group col-md-6'
            ],
          ]);
          $this->crud->addField([
            'name' => 'tin_number',
            'type' => 'number',
            'label' => "Tin Number",
            'wrapper'   => [ 
              'class' => 'form-group col-md-6'
            ], 
         
          ]);
          $this->crud->addField([
            'name' => 'postion',
            'type' => 'select_from_array',
            'options' => [
                          'General Manager' => 'General Manager',
                          'Owner' => 'Owner',
                          'Marketing Manager' => 'Marketing Manager',
                          'Assistant Manager' => 'Assistant Manager',
                          'Sales Manager' => 'Sales Manager',
                          'finance' => 'finance',
                          'Accountant' => 'Accountant'
                        ],
            'allows_null' => false,
            'default' => 'None',
            'label' => "Position",
            'wrapper' => [ 
              'class' => 'form-group col-md-6'
           ],
          ]);
          $this->crud->addField([
            'name' => 'website',
            'type' => 'text',
            'label' => "Website",
            'wrapper'   => [ 
              'class' => 'form-group col-md-6'
            ],
          ]);
          $this->crud->addField([
            'name' => 'Landline',
            'type' => 'number',
            'label' => "Landline",
            'wrapper'   => [ 
              'class' => 'form-group col-md-6'
           ],
          //  'attributes'   => [ 
          //   'min' => '10',
          //   'max' => '10'
          // ], 
          ]);
          $this->crud->addField([
            'name' => 'mobile_number',
            'type' => 'number',
            'label' => "Mobile Number",
            'wrapper'   => [ 
              'class' => 'form-group col-md-6'
           ],
          //  'attributes'   => [ 
           
          //   'max' => '10'
          // ], 
          ]);
          $this->crud->addField([
            'label' => 'Lead Status',
            'type' => 'select2_from_array',
            'name' => 'statu',
            'options' => [
              // '-None-'=>'-None-',
              'Attempted to contact'=> 'Attempted to contact',
              'Contact in future'=>'Contact in future',
              'Junk Lead'=>'Junk Lead',
              'Contacted'=>'Contacted',
          ], 
            'wrapper'   => [ 
               'class' => 'form-group col-md-6'
             ]    
        ]);
        $this->crud->addField([
          'label' => 'Lead Source',
          'type' => 'select_from_array',
          'name' => 'source',
          'options' => [
            'Advertisement'=>'Advertisement',
            'Cold Call'=>'Cold Call',
            'Employee Referral'=> 'Employee Referral',
            'Online Store' =>'Online Store',
            'Partner'=> 'Partner',
            'Trade Show' =>'Trade Show',
            'Web Research'=> 'Web Research',
            'Physical sales'=> 'Physical sales',
            'Tele marketing'=> 'Tele marketing',
            'Campaign'=>'Campaign',
            'Telegram'=>'Telegram',
            'Facebook'=>'Facebook',
            'Flyer'=>'Flyer',
            'Other'=>'Other',
        ],
        'wrapper'   => [ 
          'class' => 'form-group col-md-6'
          ]    
        ]); 
        $this->crud->addField([
            'name' => 'groups',
            'type' => 'checklist',
            'attribute' =>'group_name', 
            'model' => "App\Models\group",
            'pivot' => true,
            'entity'  => "groups",
            'label' => "Group",
            'wrapper'   => [ 
              'class' => 'form-group col-md-6'
           ]
          ]);      
        $this->crud->addField([
          'label' => 'Lead Rating',
          'type' => 'select_from_array',
          'name' => 'rating',
          'options' => [
            'Active'=>'Active',
            'Market Failed'=> 'Market Failed',
            'Shutdown'=> 'Shutdown',
          ],
           
        'wrapper'   => [ 
          'class' => 'form-group col-md-6'
       ] 
        ]);   
          $this->crud->addField([
                'label' => 'Region',
                'type' => 'select',
                'name' => 'region_id',
                'attribute' =>'region', 
                'entity' => 'region',
                // 'allows_null' => true, 
                // 'model' => 'App\Models\region',
              'wrapper'   => [ 
                'class' => 'form-group col-md-6'
                ]    
          ]);
        //   $this->crud->addField([ 
        //     'label' => "City", 
        //     'type'=> 'select2_from_ajax',
        //     'name' => 'city_id',
        //     'entity' => 'city', 
        //     'model' => 'App\Models\city',
        //     'attribute'  => 'city',
        //     'data_source'  => url('api/city'),
        //     'placeholder' => 'Select an city', 
        //     'include_all_form_fields' => true, 
        //     'minimum_input_length' => 0, 
        //     'dependencies' => ['region_id'], 
        //     // 'method'=> 'GET', 
        //     'wrapper'   => [ 
        //             'class' => 'form-group col-md-6'
        //             ]    
        // ]);
            
          // $this->crud->addField([
          //       'label' => 'City',
          //       'type' => 'select',
          //       'name' => 'city_id',
          //       'attribute' =>'city', 
          //       'allows_null' => true,
          //       'entity' => 'city', 
          //       'model' => 'App\Models\city',
          //     'wrapper'   => [ 
          //       'class' => 'form-group col-md-6'
          //       ]    
          // ]);
          $this->crud->addField([
                'label' => 'City/Subcity',
                'type' => 'select',
                'name' => 'city_id',
                'attribute' =>'city', 
                'entity' => 'city', 
                'allows_null' => true,
                'model' => 'App\Models\city',
              'wrapper'   => [ 
                'class' => 'form-group col-md-6'
                ]    
                ]);
                $this->crud->addField([ 
            'name' => 'location_pin',
            'type'=> 'address_algolia',
            'label' => "Location Pin",
            'wrapper'   => [ 
              'class' => 'form-group col-md-6'
              ]    
              ]);
          $this->crud->addField([
            'name' => 'description',
            'type' => 'textarea',
            'label' => "Description",
            'wrapper'   => [ 
              'class' => 'form-group col-md-6'
              ]   
          ]);
              
    }
   
    
    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
  

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
      $this->crud->setUpdateContentClass('col-md-12');
        // $this->setupCreateOperation();
        CRUD::setValidation(PersonupdateRequest::class);
        // $this->crud->setCreateContentClass('col-md-12');
       
        // CRUD::setFromDb();
        // $this->crud->addField([
        //     'name' => 'lead_owner',
        //     'type' => 'text',
        //     'label' => "Lead Owner"
        //   ]);
      //   $this->crud->addField([
      //     'name' => 'image', 
      //     'aspect_ratio' => 1,      
      //     'crop' => true,
      //     'type' => 'image',
      //     'label' => "Lead Image",
      //   'wrapper'   => [ 
      //     'class' => 'form-group col-md-12'
      //  ],
      // ]); 
      
  //       $this->crud->addField([
  //         'name' => 'phone_number',
  // $this->crud->addFilter([
  //   'type'  => 'text',
  //   'name'  => 'phone_number',
  //   'label' => 'Serch',
  // // function($value) { // if the filter is active
  //   // $this->crud->addClause('where', 'description', 'LIKE', "%$value%");
  //   'wrapper'   => [ 
  //     'class' => 'form-group col-md-6'
  //  ],auth::guard('backpack')->user()->name 
  // ]); 
  // $id=auth::guard('backpack')->user('name')->id;
  $this->crud->addField([
    'name' => 'image', 
    'aspect_ratio' => 1,      
    'crop' => true,
    'type' => 'image',
    'label' => "Lead Image",
    'wrapper'   => [ 
      'class' => 'form-group col-md-6'
    ],
]); 
  
//       $this->crud->addField([
//         'name' => 'phone_number',
// $this->crud->addFilter([
//   'type'  => 'text',
//   'name'  => 'phone_number',
//   'label' => 'Serch',
// // function($value) { // if the filter is active
//   // $this->crud->addClause('where', 'description', 'LIKE', "%$value%");
//   'wrapper'   => [ 
//     'class' => 'form-group col-md-6'
//  ],auth::guard('backpack')->user()->name 
// ]); 
// $id=auth::guard('backpack')->user('name')->id;
$this->crud->addField([
  'label' => 'Lead Owner',
  'type' => 'select',
  'name' => 'user_id',
  'allows_null' => true,
  'attribute' =>'name', 
  'entity' => 'user', 
  'model' => 'App\Models\user',
'wrapper'   => [ 
  'class' => 'form-group col-md-6'
]    
]); 
$this->crud->addfield([


'type' => 'hidden',
'name' => 'updated_by',

'value' => Auth::guard('backpack')->user()->name
]);

      // Hidden
      // $this->crud->request->request->add(['user_id' => \Auth::user()->id]);
      $this->crud->addField(['type' => 'hidden', 'name' => 'user_id']);
      
      // $response = $this->traitStore();
      //  return $response;   
      $this->crud->addField([
        'name' => 'facebook',
        'type' => 'text',
        'label' => "Facebook",
        'wrapper'   => [ 
          'class' => 'form-group col-md-6'
        ],
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
      
        $this->crud->addField([
          'name' => 'telegram',
          'type' => 'text',
          'label' => "Telegram",
          'wrapper'   => [ 
            'class' => 'form-group col-md-6'
          ],
        ]);
        $this->crud->addField([
          'name' => 'name',
          'type' => 'text',
          'attributes' => [
          'class' => 'form-control',

          ],
          'wrapper'   => [ 
            'class' => 'form-group col-md-6'
         ],
          'label' => "Name",

        ]);
        $this->crud->addField([
        'name' => 'email',
        'type' => 'text',
        'label' => "Email",
        'wrapper'   => [ 
              'class' => 'form-group col-md-6'
           ],
        ]);
      
        $this->crud->addField([
            'name' => 'gender',
            'type'        => 'radio',
            'options'     => [
               0 => "Female",
                1 => "Male"
            ],
            'label' => "Gender",
            'wrapper'   => [ 
              'class' => 'form-group col-md-6'
            ],
          ]);
          $this->crud->addField([
            'name' => 'tin_number',
            'type' => 'text',
            'label' => "Tin Number",
            'wrapper'   => [ 
              'class' => 'form-group col-md-6'
            ], 
         
          ]);
          $this->crud->addField([
            'name' => 'postion',
            'type' => 'select_from_array',
            'options' => [
                          'General Manager' => 'General Manager',
                          'Owner' => 'Owner',
                          'Marketing Manager' => 'Marketing Manager',
                          'Assistant Manager' => 'Assistant Manager',
                          'Sales Manager' => 'Sales Manager',
                          'finance' => 'finance',
                          'Accountant' => 'Accountant'
                        ],
            'allows_null' => false,
            'default' => 'None',
            'label' => "Position",
            'wrapper' => [ 
              'class' => 'form-group col-md-6'
           ],
          ]);
          $this->crud->addField([
            'name' => 'website',
            'type' => 'text',
            'label' => "Website",
            'wrapper'   => [ 
              'class' => 'form-group col-md-6'
            ],
          ]);
          $this->crud->addField([
            'name' => 'Landline',
            'type' => 'text',
            'label' => "Landline",
            'wrapper'   => [ 
              'class' => 'form-group col-md-6'
           ],
          //  'attributes'   => [ 
          //   'min' => '10',
          //   'max' => '10'
          // ], 
          ]);
          $this->crud->addField([
            'name' => 'mobile_number',
            'type' => 'text',
            'label' => "Mobile Number",
            'wrapper'   => [ 
              'class' => 'form-group col-md-6'
           ],
          //  'attributes'   => [ 
           
          //   'max' => '10'
          // ], 
          ]);
          $this->crud->addField([
            'label' => 'Lead Status',
            'type' => 'select2_from_array',
            'name' => 'statu',
            'options' => [
              // '-None-'=>'-None-',
              'Attempted to contact'=> 'Attempted to contact',
              'Contact in future'=>'Contact in future',
              'Junk Lead'=>'Junk Lead',
              'Contacted'=>'Contacted',
          ], 
            'wrapper'   => [ 
               'class' => 'form-group col-md-6'
             ]    
        ]);
        $this->crud->addField([
          'label' => 'Lead Source',
          'type' => 'select_from_array',
          'name' => 'source',
          'options' => [
            'Advertisement'=>'Advertisement',
            'Cold Call'=>'Cold Call',
            'Employee Referral'=> 'Employee Referral',
            'Online Store' =>'Online Store',
            'Partner'=> 'Partner',
            'Trade Show' =>'Trade Show',
            'Web Research'=> 'Web Research',
            'Physical sales'=> 'Physical sales',
            'Tele marketing'=> 'Tele marketing',
            'Campaign'=>'Campaign',
            'Telegram'=>'Telegram',
            'Facebook'=>'Facebook',
            'Flyer'=>'Flyer',
            'Other'=>'Other',
        ],
        'wrapper'   => [ 
          'class' => 'form-group col-md-6'
          ]    
        ]); 
        $this->crud->addField([
            'name' => 'groups',
            'type' => 'checklist',
            'attribute' =>'group_name', 
            'model' => "App\Models\group",
            'pivot' => true,
            'entity'  => "groups",
            'label' => "Group",
            'wrapper'   => [ 
              'class' => 'form-group col-md-6'
           ]
          ]);      
        $this->crud->addField([
          'label' => 'Lead Rating',
          'type' => 'select_from_array',
          'name' => 'rating',
          'options' => [
            'Active'=>'Active',
            'Market Failed'=> 'Market Failed',
            'Shutdown'=> 'Shutdown',
          ],
           
        'wrapper'   => [ 
          'class' => 'form-group col-md-6'
       ] 
        ]);   
          $this->crud->addField([
                'label' => 'Region',
                'type' => 'select',
                'name' => 'region_id',
                'attribute' =>'region', 
                'entity' => 'region',
                // 'allows_null' => true, 
                // 'model' => 'App\Models\region',
              'wrapper'   => [ 
                'class' => 'form-group col-md-6'
                ]    
          ]);
        //   $this->crud->addField([ 
        //     'label' => "City", 
        //     'type'=> 'select2_from_ajax',
        //     'name' => 'city_id',
        //     'entity' => 'city', 
        //     'model' => 'App\Models\city',
        //     'attribute'  => 'city',
        //     'data_source'  => url('api/city'),
        //     'placeholder' => 'Select an city', 
        //     'include_all_form_fields' => true, 
        //     'minimum_input_length' => 0, 
        //     'dependencies' => ['region_id'], 
        //     // 'method'=> 'GET', 
        //     'wrapper'   => [ 
        //             'class' => 'form-group col-md-6'
        //             ]    
        // ]);
            
          // $this->crud->addField([
          //       'label' => 'City',
          //       'type' => 'select',
          //       'name' => 'city_id',
          //       'attribute' =>'city', 
          //       'allows_null' => true,
          //       'entity' => 'city', 
          //       'model' => 'App\Models\city',
          //     'wrapper'   => [ 
          //       'class' => 'form-group col-md-6'
          //       ]    
          // ]);
          $this->crud->addField([
                'label' => 'City/Subcity',
                'type' => 'select',
                'name' => 'city_id',
                'attribute' =>'city', 
                'entity' => 'city', 
                'allows_null' => true,
                'model' => 'App\Models\city',
              'wrapper'   => [ 
                'class' => 'form-group col-md-6'
                ]    
                ]);
                $this->crud->addField([ 
            'name' => 'location_pin',
            'type'=> 'address_algolia',
            'label' => "Location Pin",
            'wrapper'   => [ 
              'class' => 'form-group col-md-6'
              ]    
              ]);
          $this->crud->addField([
            'name' => 'description',
            'type' => 'textarea',
            'label' => "Description",
            'wrapper'   => [ 
              'class' => 'form-group col-md-6'
              ]   
          ]);
        
 
    
        // $this->crud->addButtonFromView('line', 'note', 'note', 'beginning');
        // $this->crud->addButtonFromView('line', 'meeting', 'meeting', 'beginning');
        // $this->crud->addButtonFromView('line', 'call', 'call', 'beginning');
        // $this->crud->addButtonFromView('line', 'task', 'task', 'beginning');
      

  
        // $this->crud->addButtonFromView('line', 'note', 'note', 'beginning');
        // $this->crud->addButtonFromView('line', 'meeting', 'meeting', 'beginning');
        // $this->crud->addButtonFromView('line', 'call', 'call', 'beginning');
        // $this->crud->addButtonFromView('line', 'task', 'task', 'beginning');
    }
      protected function setupShowOperation()
      {
         $this->crud->addButtonFromView('top', 'ContactConvert', 'ContactConvert', 'beginning');
        // $this->crud->addButtonFromView('right', 'note', 'note', 'beginning');
        $this->crud->addButtonFromView('right', 'meeting', 'meeting', 'beginning');
        $this->crud->addButtonFromView('right', 'call', 'call', 'beginning');
        $this->crud->addButtonFromView('right', 'task', 'task', 'beginning');
     
        // $this->crud->addButtonFromView('left', 'all_note', 'all_note', 'beginning');
        $this->crud->addButtonFromView('left', 'all_meeting', 'all_meeting', 'beginning');
        $this->crud->addButtonFromView('left', 'all_call', 'all_call', 'beginning');
        $this->crud->addButtonFromView('left', 'all_task', 'all_task', 'beginning');

        $this->crud->addButtonFromView('left1', 'all_complain', 'all_complain', 'beginning');
        $this->crud->addButtonFromView('left1', 'allevaluation', 'allevaluation', 'beginning');
        $this->crud->addButtonFromView('left1', 'allprice', 'allprice', 'beginning');
        $this->crud->addButtonFromView('left1', 'all_outofstock', 'all_outofstock', 'beginning');
        $this->crud->addButtonFromView('left1', 'all_outoflist', 'all_outoflist', 'beginning');

         $this->crud->addButtonFromView('right1', 'newcomplaints', 'newcomplaints', 'beginning');
        $this->crud->addButtonFromView('right1', 'newevaluation', 'newevaluation', 'beginning');
        $this->crud->addButtonFromView('right1', 'new_price', 'new_price', 'beginning');
        $this->crud->addButtonFromView('right1', 'new_outofstock', 'new_outofstock', 'beginning');
        $this->crud->addButtonFromView('right1', 'new_outoflist', 'new_outoflist', 'beginning');

        $this->crud->setShowContentClass('col-md-12');
        $this->crud->set('show.setFromDb', false);
        
        $this->crud->addColumn([
          'name' => 'image', 
          'aspect_ratio' => 1,      
          'crop' => true,
          'type' => 'image',
          'label' => "Lead Image",
    ]); 
    $this->crud->addColumn([
      'name' => 'name',
      'type' => 'text',
      'label' => "Lead Name",
      'attributes' => [
      'class' => 'form-control',

      ],
        ]); 
        $this->crud->addColumn([
          'name' => 'gender',
          'type'        => 'radio',
          'options'     => [
             0 => "Female",
              1 => "Male"
          ],
          'label' => "Gender",
         
        ]);
    $this->crud->addColumn([
        'name' => 'company_name',
        'type' => 'text',
        'label' => "Company",
        'attributes' => [
          'class' => 'form-control',
        ],
        ]); 
        $this->crud->addColumn([
          'name' => 'postion',
          'type' => 'select_from_array',
          'options' => [
                        'General Manager' => 'General Manager',
                        'Owner' => 'Owner',
                        'Marketing Manager' => 'Marketing Manager',
                        'Assistant Manager' => 'Assistant Manager',
                        'Sales Manager' => 'Sales Manager',
                        'finance' => 'finance',
                        'Accountant' => 'Accountant'
                      ],
          'allows_null' => false,
          'default' => 'None',
          'label' => "Position",
        
        ]);

    
  $this->crud->addColumn([
    'name' => 'email',
    'type' => 'email',
    'label' => "Email",
    
    ]);
        $this->crud->addColumn([
          'name' => 'Landline',
          'type' => 'text',
          'label' => "Landline",
          
        ]);
        $this->crud->addColumn([
          'name' => 'mobile_number',
          'type' => 'text',
          'label' => "Mobile",
        
        ]);
        $this->crud->addColumn([
          'name' => 'tin_number',
          'type' => 'text',
          'label' => "Tin Number",  
        ]);
 
        $this->crud->addColumn([
          'name' => 'website',
          'type' => 'text',
          'label' => "Website",
        ]);
    //  $this->crud->addColumn(['type' => 'hidden', 'name' => 'type']);
   $this->crud->addColumn([
      'name' => 'facebook',
      'type' => 'text',
      'label' => "Facebook",
    ]);
  $this->crud->addColumn([
        'name' => 'telegram',
        'type' => 'text',
        'label' => "Telegram",
      
      ]);
  $this->crud->addColumn([
          'label' => 'Lead Status',
          'type' => 'select_from_array',
          'name' => 'statu',
        
  ]);
  $this->crud->addColumn([
    'label' => 'Lead Source',
    'type' => 'select_from_array',
    'name' => 'source',
    
  ]);      
      // $this->crud->addColumn([
      //     'name' => 'group_people.group_name',
      //     'type' => 'checklist',
      //     'attribute' =>'group_name',
      //     'model' => "App\Models\person",
      //     'entity'  => "group_people",
      //     'label' => "Group",
      //   ]);      
  $this->crud->addColumn([
    'label' => 'Lead Rating',
    'type' => 'select_from_array',
    'name' => 'rating',
      
  ]);
            
  $this->crud->addColumn([
        'label' => 'Region',
        'type' => 'select',
        'name' => 'region_id',
        'attribute' =>'region', 
        'entity' => 'region',
        'allows_null' => true, 
        'model' => 'App\Models\region',    
  ]);    
  // $this->crud->addColumn([
  //       'label' => 'City',
  //       'type' => 'select2_from_ajax',
  //       'name' => 'city_id',
  //       'attribute' =>'city', 
  //       'allows_null' => true,
  //       'entity' => 'city', 
  //       'model' => 'App\Models\city',
  //       'dependencies' => ['region_id'], 
  // ]);
  $this->crud->addColumn([
        'label' => 'City/Subcity',
        'type' => 'select',
        'name' => 'subcity_id',
        'attribute' =>'subcity', 
        'entity' => 'subcity', 
        'allows_null' => true,
        'model' => 'App\Models\subcity',
        
        ]);
        $this->crud->addColumn([ 
    'name' => 'location_pin',
    'type'=> 'address_algolia',
    'label' => "Location Pin",
    
      ]);
      $this->crud->addColumn([
        'name' => 'description',
        'type' => 'text',
        'label' => "Description",
            
  ]);
 
    $this->crud->addColumn([
      'label' => 'Lead Owner',
      'type' => 'select',
      'name' => 'user_id',
      'attribute' =>'name', 
      'entity' => 'user', 
      'model' => 'App\Models\user',
      
 
  ]);    $this->crud->addColumn([
    'name' => 'created_at',
    'type' => 'datetime',
    'label' => "Created At",
    
  ]);

  $this->crud->addColumn([
    'name' => 'created_by',
    'type' => 'text',
    'label' => "Created By",
    
  ]); 
  $this->crud->addColumn([
    'name' => 'updated_at',
    'type' => 'text',
    'label' => "Updated At",
    
  ]); 
  $this->crud->addColumn([
    'name' => 'updated_by',
    'type' => 'text',
    'label' => "Updated By",
    
  ]);
   


  
  $this->crud->addColumn([
    'name' => 'Lead_Converted_By',
    'type' => 'text',
    'label' => "Lead Converted By",
  
  ]);
  $this->crud->addColumn([
    'name' => 'Lead_Converted_date',
    'type' => 'datetime',
    'label' => "Lead Converted Date",
        
]);

  }
}
