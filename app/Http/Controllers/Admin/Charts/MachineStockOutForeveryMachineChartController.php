<?php

namespace App\Http\Controllers\Admin\Charts;

use Backpack\CRUD\app\Http\Controllers\ChartController;
//use ConsoleTVs\Charts\Classes\Chartjs\Chart;
//use ConsoleTVs\Charts\Classes\Chartjs\Chart;
//use ConsoleTVs\Charts\Classes\Chartjs\Chart;
//use ConsoleTVs\Charts\Classes\Echarts\Chart;
//use ConsoleTVs\Charts\Classes\Chartjs\Chart;
use ConsoleTVs\Charts\Classes\Echarts\Chart;
//use ConsoleTVs\Charts\Classes\Fusioncharts\Chart;
//use ConsoleTVs\Charts\Classes\Highcharts\Chart;
//use ConsoleTVs\Charts\Classes\C3\Chart;
//use ConsoleTVs\Charts\Classes\Frappe\Chart;
use App\Models\Communication;
use Illuminate\Support\Arr;

/**
 * Class MachineStockOutForeveryMachineChartController
 * @package App\Http\Controllers\Admin\Charts
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class MachineStockOutForeveryMachineChartController extends ChartController
{
    public function setup()
    {
        $this->chart = new Chart();

        $Binding_Machine=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','25')->count();
        $Mug_Machine=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','26')->count();
        $Lamination_Machine_A3=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','27')->count();
        $Heat_Press_Machine_38_A3=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','28')->count();
        $Portable_Heat_Press_Machine=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','29')->count();
        $Five_in_one_Heat_Press=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','30')->count();

        //[$Mug_Machine_Five_in_one,$Flash_Stamp_Machine,$Pen_Machine,$Id_Cutter,$Cap_Machine,$Desk_Mate_Stamp,$Epson_Printer_Machine_L382,$Epson_Printer_Machine_L805, $Transfer_Paper_Light,$Transfer_Paper_Dark]

        $Mug_Machine_Five_in_one=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','31')->count();
        $Flash_Stamp_Machine=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','32')->count();
        $Pen_Machine=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','33')->count();
        $Id_Cutter=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','34')->count();
        $Cap_Machine=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','35')->count();
        $Desk_Mate_Stamp=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','36')->count();
        $Epson_Printer_Machine_L382=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','37')->count();
        $Epson_Printer_Machine_L805=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','38')->count();
        $Heat_Press_Machine_40_60=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','70')->count();

        //[$Plotter_70cm,$Plotter_130cm, $Lamination_Machine_A2,$Eight_in_1_Heat_Press,$Two_in_1_Heat_Press, $Stamp_HB_42,$Stamp_20_40, $Stamp_Hy_42_Top_Ink,$Clear_Mason_Jar_Mug,$kids_Mug]
        $Plotter_70cm=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','71')->count();
        $Plotter_130cm=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','72')->count();
        $Lamination_Machine_A2=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','73')->count();
        $Eight_in_1_Heat_Press=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','74')->count();
        $Two_in_1_Heat_Press=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','75')->count();

$machine_label=array("Binding_Machine"," Mug_Machine","Lamination_Machine_A3","Heat_Press_Machine_38_A3"," Portable_Heat_Press_Machine","Five_in_one_Heat_Press","
Mug_Machine_Five_in_one","Flash_Stamp_Machine","Pen_Machine","Id_Cutter","Cap_Machine","Desk_Mate_Stamp","Epson_Printer_Machine_L382","Epson_Printer_Machine_L805","Heat_Press_Machine_40_60","
Plotter_70cm","Plotter_130cm"," Lamination_Machine_A2","Eight_in_1_Heat_Press","Two_in_1_Heat_Press");

$machine_variable=array($Binding_Machine,  $Mug_Machine,$Lamination_Machine_A3,$Heat_Press_Machine_38_A3, $Portable_Heat_Press_Machine,$Five_in_one_Heat_Press,
$Mug_Machine_Five_in_one,$Flash_Stamp_Machine,$Pen_Machine,$Id_Cutter,$Cap_Machine,$Desk_Mate_Stamp,$Epson_Printer_Machine_L382,$Epson_Printer_Machine_L805,$Heat_Press_Machine_40_60,
$Plotter_70cm,$Plotter_130cm, $Lamination_Machine_A2,$Eight_in_1_Heat_Press,$Two_in_1_Heat_Press);

$machine_value_counter=count($machine_variable);
$machine_label_count=count($machine_label);
$machine_label_left=array();
$machine_value_left=array();
for($x=0;$x<$machine_value_counter;$x++){
    if($machine_variable[$x] !==0)
    //echo $all_label[$x];
   array_push($machine_value_left,$machine_variable[$x]);
    else
    echo "";


}

for($x=0;$x<$machine_label_count;$x++){
    if($machine_variable[$x] !==0)
    //echo $all_label[$x];
   array_push($machine_label_left,$machine_label[$x]);
    else
    echo "";
    //array_push($left,$all_label[$x]);
}
        $this->chart->labels($machine_label_left);

        $this->chart->dataset('My dataset','pie',
        $machine_value_left);
        $this->chart->load(backpack_url('charts/machine_stock_out_forevery_machine'));
        // OPTIONAL
         $this->chart->minimalist(true);
        $this->chart->displayLegend(true);
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
