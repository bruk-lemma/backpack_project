<?php

namespace App\Http\Controllers\Admin\Charts;

use Backpack\CRUD\app\Http\Controllers\ChartController;
//use ConsoleTVs\Charts\Classes\Chartjs\Chart;
//use ConsoleTVs\Charts\Classes\Echarts\Chart;
use ConsoleTVs\Charts\Classes\Echarts\Chart;
//use ConsoleTVs\Charts\Classes\Chartjs\Chart;
//use ConsoleTVs\Charts\Classes\Echarts\Chart;
//use ConsoleTVs\Charts\Classes\Fusioncharts\Chart;
//use ConsoleTVs\Charts\Classes\Highcharts\Chart;
//use ConsoleTVs\Charts\Classes\C3\Chart;
//use ConsoleTVs\Charts\Classes\Frappe\Chart;

use App\Models\Communication;

/**
 * Class XshopBrainChartController
 * @package App\Http\Controllers\Admin\Charts
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class XshopBrainChartController extends ChartController
{
    public function setup()
    {


        // MANDATORY. Set the labels for the dataset points

        $xshop_physical_sells=Communication::Where('communication_types_id','=','sells')->Where('sells_type', '=' ,'Physical Sells')->Where('branch', '=','Xshop')->count();
        $brain_physical_sells=Communication::Where('communication_types_id','=','sells')->Where('sells_type','=','Physical Sells')->Where('branch','=','Brain')->count();
        $total =$xshop_physical_sells+$brain_physical_sells;

        $xshop_rate=round((($xshop_physical_sells/$total)*100.00),1);
        $brain_rate=round((($brain_physical_sells/$total)*100.00),1);
        // MANDATORY. Set the labels for the dataset points

        $this->chart = new Chart();
        $this->chart->labels(['Xshop '.$xshop_rate."%",
        'Brain '.$brain_rate."%"
        ]);
        $this->chart->dataset('My dataset','pie',[$xshop_physical_sells,$brain_physical_sells])
        /*->backgroundcolor([
            'rgb(0,0,255)',
            'rgb(0,255,0)',
        ])*/;
        // RECOMMENDED. Set URL that the ChartJS library should call, to get its data using AJAX.
        $this->chart->load(backpack_url('charts/xshop_brain'));
       // $this->chart->minimalist(true);

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
