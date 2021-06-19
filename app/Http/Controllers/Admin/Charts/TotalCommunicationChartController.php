<?php

namespace App\Http\Controllers\Admin\Charts;


use Backpack\CRUD\app\Http\Controllers\ChartController;
//use ConsoleTVs\Charts\Classes\Chartjs\Chart;
use ConsoleTVs\Charts\Classes\Echarts\Chart;
//use ConsoleTVs\Charts\Classes\Chartjs\Chart;
//use ConsoleTVs\Charts\Classes\Echarts\Chart;
//use ConsoleTVs\Charts\Classes\Fusioncharts\Chart;
//use ConsoleTVs\Charts\Classes\Highcharts\Chart;
//use ConsoleTVs\Charts\Classes\C3\Chart;
//use ConsoleTVs\Charts\Classes\Frappe\Chart;

use App\Models\User;
use App\Models\Communication;
use App\Models\Product;
use Backpack\CRUD\app\Library\Widget;
use App\Http\Requests\CommunicationRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Http\Controllers\Admin;

/**
 * Class UsersdataChartController
 * @package App\Http\Controllers\Admin\Charts
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
//class user
//class UsersdataChartController extends ChartController{
class TotalCommunicationChartController extends ChartController
{
    public function setup ()
    {
       /* Widget::add([
            'name'  => 'updated_from_to',
            'label' => trans('common.updated_range'),
            'type'  => 'date_range',
            ],
            false,
            function ($value) { // if the filter is active, apply these constraints
                $dates = json_decode($value);
                $this->crud->addClause('where', 'updated_at', '>=', $dates->from);
                $this->crud->addClause('where', 'updated_at', '<=', $dates->to . ' 23:59:59');
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
        $total = Communication::all()->count();

        $complaint_rate=round((($complaint/$total)*100.00),1);
        $sells_rate=round((($sells/$total)*100.00),1);
        $price_rate=round((($price/$total)*100.00),1);
        $evaluation_rate=round((($evaluation/$total)*100.00),1);
        $OutOfStock_rate=round((($out_of_stock/$total)*100.00),1);
        $OutOfList_rate=round((($out_of_List/$total)*100.00),1);
        $preorder_rate=round((($preorder/$total)*100.00),1);
        $service_rate=round((($service/$total)*100.00),1);
        //$c_r=round($complaint_rate,2);
        $this->chart = new Chart();
       // $this->chart='fusion';
       // $this->chart->displayLegend(false);
        $this->chart->labels(['Complaint '.$complaint.' -- '.$complaint_rate."%",
         'Sells '.$sells.' -- '.$sells_rate."%",
         'Evaluation '.$evaluation.' -- '.$evaluation_rate."%",
         'Out of Stock '.$out_of_stock.' -- '.$OutOfStock_rate."%",
         'Out of List '.$out_of_List.' -- '.$OutOfList_rate."%",
         'Price '.$price.' -- '.$price_rate."%",
         'Preorder '.$preorder.' -- '.$preorder_rate."%",
         'Service '.$service.' -- '.$service_rate."%",
         ]);
        //$this->chart->colors();
        $this->chart->dataset('My dataset', 'pie', [$complaint, $sells,$evaluation,$out_of_stock,$out_of_List,$price,$preorder,$service])
        /*->backgroundcolor([
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
                        ])*/;
            // RECOMMENDED. Set URL that the ChartJS library should call, to get its data using AJAX.
            $this->chart->load(backpack_url('charts/total-communication'));
            // OPTIONAL
            $this->chart->minimalist(true);
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

