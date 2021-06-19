<?php

namespace App\Http\Controllers\Admin\Charts;


use Backpack\CRUD\app\Http\Controllers\ChartController;
use ConsoleTVs\Charts\Classes\Chartjs\Chart;
use App\Models\User;
use App\Models\Communication;
use App\Models\Product;
use Backpack\CRUD\app\Library\Widget;
use App\Http\Requests\CommunicationRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Http\Controllers\Admin;
//use Backpack\CRUD\app\Library\Widget;
//use App\Http\Controllers\Admin\Charts\UsersdataChartController;

//namespace App\Http\Controllers\Admin;

use App\Http\Requests\WomenRequest;
//use Backpack\CRUD\app\Http\Controllers\CrudController;
//use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class UsersdataChartController
 * @package App\Http\Controllers\Admin\Charts
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
//class user
//class UsersdataChartController extends ChartController{
class UsersdataChartController extends ChartController
{
    public function setup ()
    {

       /* Widget::add([
            'type'       => 'chart',
            'controller' => \App\Http\Controllers\Admin\Charts\UsersdataChartController::class,
            //OPTIONALS
            'class'   => 'card mb-2',
            'wrapper' => ['class'=> 'col-md-6'] ,
            'content' => [
            'header' => '$all',
                 // 'body'   => 'This chart should make it obvious how many new users have signed up in the past 7 days.<br><br>',
             ],
        ]);*/

        Widget::add([
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
        //$this->crud->addColumn([]);
        // MANDATORY. Set the labels for the dataset points
        /*$this->chart->labels([
            'Today',
        ]);*/
        /*$this->crud->addFilter([
            'type'  => 'date_range',
            'name'  => 'created_at',
            'label' => 'Date range'
        ],
            false,
            function ($value) { // if the filter is active, apply these constraints
                 $dates = json_decode($value);
                 $this->crud->addClause('where', 'created_at', '>=', $dates->from);
                 $this->crud->addClause('where', 'created_at', '<=', $dates->to . ' 23:59:59');
        });*/

        $complaint= Communication::Where('communication_types_id','=','complaint')->count();
        $sells = Communication::Where('communication_types_id','=','sells')->count();
        $price = Communication::Where('communication_types_id','=','price')->count();
        $evaluation = Communication::Where('communication_types_id','=','evaluation')->count();
        $out_of_stock = Communication::Where('communication_types_id','=','Out Of Stock')->count();
        $out_of_List = Communication::Where('communication_types_id','=','Out Of List')->count();
        $preorder=Communication::Where('communication_types_id','=','preorder')->count();
        $service=Communication::Where('communication_types_id','=','service')->count();
        $total_phone_call=Communication::Where('communication_ways_id','=','phone')->count();
        $total_seconds=Communication::Where('communication_ways_id','=','phone')->sum('second')/60;
        //$total_seconds=Communication::sum(second)->Where('communication_ways_id','=','Facebook');




       // $total_seconds=Communication::sum('second')->Where('communication_ways_id','=','Facebook','&&','second','>=',0);
       // $total_seconds=Communication::Wherecommunication_ways_id('=','phone')->count(sum('second'));
        //$total=$complaint+$sells+$price+$evaluation+$out_of_List+$out_of_stock+$preorder+$service;
        $total = Communication::all()->count();

        $this->chart = new Chart();
        $this->chart->labels(['Complaint', 'Sells', 'Evaluation','Out of Stock','Out of List','Price','Preorder','Service','Total Phone Call','Total-Second','Total']);
        $this->chart->dataset('My dataset', 'pie', [$complaint, $sells,$evaluation,$out_of_stock,$out_of_List,$price,$preorder,$service,$total_phone_call,$total_seconds,$total])
                    ->backgroundColor([
                        'rgb(255,160,122)',
                        'rgb(0,255,0)',
                        'rgb(0,0,255)',
                        'rgb(255,0,0)',
                        'rgb(255,255,0)',
                        'rgb(210,105,30)',
                        'rgb(255,20,147)',
                        'rgb(0,255,255)',
                        'rgb(0,128,128)',
                        'rgb(128,0,128)',
                        'rgb(0,0,0)'
                        ]);
        // RECOMMENDED. Set URL that the ChartJS library should call, to get its data using AJAX.
        $this->chart->load(backpack_url('charts/usersdata'));

        // OPTIONAL
        //$this->chart->minimalist(false);
        //$this->chart->displayLegend(true);
    }

    /**
     * Respond to AJAX calls with all the chart data points.
     *
     * @return json
     */
    // public function data()
    // {
    //     $users_created_today = \App\User::whereDate('created_at', today())->count();

    //     $this->chart->dataset('Users Created', 'bar', [
    //                 $users_created_today,
    //             ])
    //         ->color('rgba(205, 32, 31, 1)')
    //         ->backgroundColor('rgba(205, 32, 31, 0.4)');
    // }
}

