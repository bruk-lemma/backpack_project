<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use DB;

/**
 * Class HomeControllerCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class HomeControllerCrudController extends CrudController
{
    function index()
    {
     return view('dashboard');
    }

    function action(Request $request)
    {
     if($request->ajax())
     {
      $output = '';
      $query = $request->get('query');
      if($query != '')
      {
       $data = DB::table('people')
         ->where('company_name', 'like', '%'.$query.'%')
         ->orWhere('name', 'like', '%'.$query.'%')
         ->orWhere('phone_number', 'like', '%'.$query.'%')
         ->orWhere('mobile_number', 'like', '%'.$query.'%')
        
         ->get();
         
      }
      else
      {
       $data = DB::table('people')
         ->orderBy('id', 'desc')
         ->get();
      }
      $total_row = $data->count();
      if($total_row > 0)
      {
        '<thead>'.
        '<tr>'.
         '<th>company</th>'.
         '<th>Lead</th>'.
         '<th>Phone Number</th>'.
        '<th>Mobile Number</th>'.
         '<th> Type</th>'.
        '</tr>'.
       '</thead>'.
       '<tbody>';
       foreach($data as $row)
       {
        $output .= '
        <tr>
         <td>'.$row->company_name.'</td>
         <td>'.$row->name.'</td>
         <td>'.$row->phone_number.'</td>
         <td>'.$row->mobile_number.'</td>
         <td>'.$row->type.'</td>
        </tr>
        ';
       }
       '</tbody>';
      }
      else
      {
       $output = '
       <tbody>
       <tr>
        <td align="center" colspan="5">No Data Found</td>
        <tr>
       </tbody>
       ';
      }
      $data = array(
       'table_data'  => $output,
       'total_data'  => $total_row
      );

      echo json_encode($data);
     }
    }
}

