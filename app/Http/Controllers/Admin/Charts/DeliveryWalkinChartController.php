<?php

namespace App\Http\Controllers\Admin\Charts;

use Backpack\CRUD\app\Http\Controllers\ChartController;
//use ConsoleTVs\Charts\Classes\Chartjs\Chart;
use ConsoleTVs\Charts\Classes\Echarts\Chart;
//use ConsoleTVs\Charts\Classes\Fusioncharts\Chart;
//use ConsoleTVs\Charts\Classes\Highcharts\Chart;
//use ConsoleTVs\Charts\Classes\Frappe\Chart;
//use ConsoleTVs\Charts\Classes\C3\Chart;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\Communication;
use Backpack\CRUD\app\Library\Widget;
use vendor\backpack\crud\src\resources\views\crud\filters\date_range;
/**
 * Class DeliveyWalkinChartController
 * @package App\Http\Controllers\Admin\Charts
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class DeliveryWalkinChartController extends ChartController
{
    public function setup()
    {


         Widget::add([
            'name'  => 'updated_from_to',
            'label' => trans('common.updated_range'),
            'type'  => 'date_range_refresh',
            'viewNamespace' => 'package::widgets',
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
        $delivery=Communication::Where('communication_types_id','=','sells')->Where('sells_type', '=' ,'Delivery')->count();
       // ->Where('created_at', '>=', $dates->from)
        //->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $walkin=Communication::Where('communication_types_id','=','sells')->Where('sells_type','=','Physical Sells')->count();
        // MANDATORY. Set the labels for the dataset points
        $total=$delivery+$walkin;
        $delivery_rate=round((($delivery/$total)*100.00),1);
        $walkin_rate=round((($walkin/$total)*100.00),1);

        $this->chart = new Chart();
        $this->chart->labels(['Delivery '.$delivery."-- ".$delivery_rate."%",
        'Walkin '.$walkin."-- ".$walkin_rate."%"]);
        $this->chart->dataset('My dataset','pie',[$delivery,$walkin])
        /*->backgroundcolor([
            'rgb(255,255,0)',
            'rgb(255,0,0)',
        ])*/;

        // RECOMMENDED. Set URL that the ChartJS library should call, to get its data using AJAX.
        $this->chart->load(backpack_url('charts/delivery-walkin'));
       // $this->chart->minimalist(true);
       // echo $delivery;
        // OPTIONAL
         $this->chart->minimalist(true);
        // $this->chart->displayLegend(true);

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
