<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use DataTables;
use App\Charts\sample2;
use App\Models\communication;
use Backpack\CRUD\app\Library\Widget;
class StudentController extends Controller
{
    public function index()
    {
        Widget::add([
            //'name'  // if the filter is active, apply these constraints
            //$dates = json_deco=> 'updated_from_to',
            'label' => trans('common.updated_range'),
            'type'  => 'date_range_refresh',
            //'viewNamespace' => 'package::widgets',
            ],
            false,
            function ($value) { de($value);
                $this->crud->addClause('where', 'updated_at', '>=', $dates->from);
                $this->crud->addClause('where', 'updated_at', '<=', $dates->to . ' 23:59:59');
                $delivery=Communication::Where('communication_types_id','=','sells')->Where('sells_type', '=' ,'Delivery')
                ->Where('created_at', '>=', $dates->from)
                ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
                $walkin=Communication::Where('communication_types_id','=','sells')->Where('sells_type','=','Physical Sells')
                ->Where('created_at', '>=', $dates->from)
                ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            }
        );
       $delivery=Communication::Where('communication_types_id','=','sells')->Where('sells_type', '=' ,'Delivery')
        ->count();
       $walkin=Communication::Where('communication_types_id','=','sells')->Where('sells_type','=','Physical Sells')
       ->count();
       $bp=Communication::all();
       $chart=new sample2;
       $chart->labels(['Delivery', 'Walkin']);
//$chart->tooltip('value 20');
       $chart->dataset('Sample','pie', [$delivery, $walkin])
       ->backgroundcolor([
        'rgb(0,128,128)',
        'rgb(124,252,0)',]);
        return view('show',compact('chart'));
    }
    public function getStudents(Request $request)
    {

        if ($request->ajax()) {
            $data = Student::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
}
