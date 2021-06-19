<?php

namespace App\Http\Controllers\Admin\Charts;

use Backpack\CRUD\app\Http\Controllers\ChartController;
//use ConsoleTVs\Charts\Classes\Chartjs\Chart;
use ConsoleTVs\Charts\Classes\Echarts\Chart;
use App\Models\Communication;

/**
 * Class ProductComplaintChartController
 * @package App\Http\Controllers\Admin\Charts
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ProductComplaintChartController extends ChartController
{
    public function setup()
    {
        $Resolved_Product_Complaint=Communication::Where('communication_types_id','=','Complaint')->Where('comp_type', '=' ,'Product')->Where('complain_status','=','resolved')->count();
        $Unresolved_Product_Complaint=Communication::Where('communication_types_id','=','Complaint')->Where('comp_type', '=' ,'Product')->Where('complain_status','=','unresolved')->count();
        $total =$Resolved_Product_Complaint+$Unresolved_Product_Complaint;

        $resolved_rate=round((($Resolved_Product_Complaint/$total)*100.00),1);
        $unresolved_rate=round((($Unresolved_Product_Complaint/$total)*100.00),1);

        // MANDATORY. Set the labels for the dataset points

        $this->chart = new Chart();
        $this->chart->labels(['Resolved '.$resolved_rate."% "."-- ".$Resolved_Product_Complaint,
        'Unresolved '.$unresolved_rate."% "."-- ".$Unresolved_Product_Complaint
        ]);
        $this->chart->dataset('My dataset','pie',[ $Resolved_Product_Complaint,$Unresolved_Product_Complaint])
        /*->backgroundcolor([
            'rgb(0,128,128)',
            'rgb(124,252,0)',
        ])*/;

        // RECOMMENDED. Set URL that the ChartJS library should call, to get its data using AJAX.
        $this->chart->load(backpack_url('charts/product_complaint'));

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
