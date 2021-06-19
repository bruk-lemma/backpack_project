<?php

namespace App\Http\Controllers\Admin\Charts;

use Backpack\CRUD\app\Http\Controllers\ChartController;
use ConsoleTVs\Charts\Classes\Chartjs\Chart;
use App\Models\Communication;
use App\Models\Product;
use vendor\backpack\crud\src\resources\views\crud\filters\date_range_refresh;
/**
 * Class CatagoryChartController
 * @package App\Http\Controllers\Admin\Charts
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CatagoryChartController extends ChartController
{
    public function setup()
    {

      $Product_Id=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=',13)->count();
      $Product_Id2=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=',11)->count();
       //->Where([['product_id', '>=','25'],['product_id','<=','38'],['product_id','>=','70', 'and']])->count();//pluck('product_id');
      //  foreach($Product_Id as $pi){
        echo $Product_Id;
      //$match=Product::Where('id','=',$pi)->Where('catagory_id','=',1)->count();
      //$match=Product::Where('catagory_id','=','1')->count();
     // MANDATORY. Set the labels for the dataset points
        $this->chart = new Chart();
        $this->chart->labels(['Machine_Stock_Out','hjhjhjhj']);
        $this->chart->dataset('My dataset','pie',[$Product_Id,$Product_Id2])
        ->backgroundcolor([
            'rgb(255,140,0)',
        ]);


        // RECOMMENDED. Set URL that the ChartJS library should call, to get its data using AJAX.
        $this->chart->load(backpack_url('charts/catagory'));

        // OPTIONAL
        // $this->chart->minimalist(false);
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

}
