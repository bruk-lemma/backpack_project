<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\sample2;
use App\Models\communication;
use Backpack\CRUD\app\Library\Widget;

class sample extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //


        Widget::add([
            'name'  => 'updated_from_to',
            'label' => trans('common.updated_range'),
            'type'  => 'date_range_refresh',
            //'viewNamespace' => 'package::widgets',
            ],
            false,
            function ($value) { // if the filter is active, apply these constraints
                $dates = json_decode($value);
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
