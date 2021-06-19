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
 * Class ComplaintChartController
 * @package App\Http\Controllers\Admin\Charts
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ComplaintChartController extends ChartController
{
    public function setup()
    {

        // MANDATORY. Set the labels for the dataset points
        $Product_Complaint=Communication::Where('communication_types_id','=','Complaint')->Where('comp_type', '=' ,'Product')->count();
        $Service_Complaint=Communication::Where('communication_types_id','=','Complaint')->Where('comp_type','=','Service')->count();
        $total =$Product_Complaint+$Service_Complaint;

        $product_rate=round((($Product_Complaint/$total)*100.00),1);
        $service_rate=round((($Service_Complaint/$total)*100.00),1);
        // MANDATORY. Set the labels for the dataset points

        $this->chart = new Chart();
        $this->chart->labels(['Product'.$product_rate."%",
        'Service '.$service_rate."%"
        ]);
        $this->chart->dataset('My dataset','pie',[$Product_Complaint,$Service_Complaint])
        /*->backgroundcolor([
            'rgb(255,140,0)',
            'rgb(255,0,255)',
        ])*/;
       // $this->chart->displayLegend(true);
        // RECOMMENDED. Set URL that the ChartJS library should call, to get its data using AJAX.
        //$this->chart->load(backpack_url('charts/complaint'));

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
