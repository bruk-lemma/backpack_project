<?php

namespace App\Http\Controllers\Admin\Charts;

use Backpack\CRUD\app\Http\Controllers\ChartController;
//use ConsoleTVs\Charts\Classes\Chartjs\Chart;
use ConsoleTVs\Charts\Classes\Echarts\Chart;
//use ConsoleTVs\Charts\Classes\Fusioncharts\Chart;
//use ConsoleTVs\Charts\Classes\Highcharts\Chart;
//use ConsoleTVs\Charts\Classes\C3\Chart;
//use ConsoleTVs\Charts\Classes\Frappe\Chart;
use App\Models\Communication;

/**
 * Class DeliveredbyChartController
 * @package App\Http\Controllers\Admin\Charts
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class DeliveredbyChartController extends ChartController
{
    public function setup()
    {

        $Company_Delivery=Communication::Where('communication_types_id','=','sells')->Where('sells_type', '=' ,'delivery')->Where('delivered_by', '=','Company Property')->count();
        $OutSource_Delivery=Communication::Where('communication_types_id','=','sells')->Where('sells_type','=','delivery')->Where('delivered_by','=','Outsource')->count();
        $total =$Company_Delivery+$OutSource_Delivery;

        $company_rate=round((($Company_Delivery/$total)*100.00),1);
        $outsource_rate=round((($OutSource_Delivery/$total)*100.00),1);
        // MANDATORY. Set the labels for the dataset points

        $this->chart = new Chart();
        $this->chart->labels(['Company Delivery '.$company_rate."%",
        'OutSource Delivery '.$outsource_rate."%"
        ]);
        $this->chart->dataset('My dataset','pie',[$Company_Delivery,$OutSource_Delivery])
        /*->backgroundcolor([
            'rgb(255,140,0)',
            'rgb(255,0,255)',
        ])
        */;

        // RECOMMENDED. Set URL that the ChartJS library should call, to get its data using AJAX.
        $this->chart->load(backpack_url('charts/deliveredby'));

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
