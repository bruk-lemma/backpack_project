<?php

namespace App\Http\Controllers\Admin\Charts;
//namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\ChartController;
//use ConsoleTVs\Charts\Classes\Chartjs\Chart;
use ConsoleTVs\Charts\Classes\Echarts\Chart;
//use ConsoleTVs\Charts\Classes\Fusioncharts\Chart;
//use ConsoleTVs\Charts\Classes\Highcharts\Chart;
//use ConsoleTVs\Charts\Classes\C3\Chart;
//use ConsoleTVs\Charts\Classes\Frappe\Chart;
use App\Models\Communication;
use App\Models\Product;
use App\Http\Controllers\Admin\CommunicationCrudController;

/**
 * Class CatalogChartController
 * @package App\Http\Controllers\Admin\Charts
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */

/*Class Catalog extends crudController{
    public function me(){
        return "extend";
    }*/
class CatalogChartController extends ChartController
{
    public function setup()
    {
        $this->chart = new Chart();

        /*$users = DB::table('users')
            ->where('votes', '>', 100)
            ->orWhere(function($query) {
                $query->where('name', 'Abigail')
                      ->where('votes', '>', 50);
            })
            ->get();*/

         $Machine=Communication::Where('communication_types_id','=','Out Of Stock')
         ->whereIn('product_id', [25,26,27,28,29,30,31,32,33,34,35,36,37,38,70,71,72,73,74,75])->count();

         $Other_Product=Communication::Where('communication_types_id','=','Out Of Stock')
         ->whereNotIn('product_id', [25,26,27,28,29,30,31,32,33,34,35,36,37,38,70,71,72,73,74,75])->count();

         $total =$Machine+$Other_Product;
         $machine_rate=round((($Machine/$total)*100.00),1);
         $otherproduct_rate=round((($Other_Product/$total)*100.00),1);
         //$product2=Communication::Where('communication_types_id','=','Out Of Stock')
         //->whereBetween('product_id', [25, 38])->count();

            //->orwhereBetween('product_id', [25, 38])
            //->orwhereBetween('product_id', [70, 75])->count();
           /* ->Where(function($chain){
                $chain->orWhere('product_id','>=','25')
                      ->Where('product_id','<=','38')
                      ->Where('product_id','>=','70')
                      ->Where('product_id','<=','75');
            })*/

            //->value('product_id');
            //echo $product;

        // MANDATORY. Set the labels for the dataset points
        //$Product_Id=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=',13)->count();
        /*$Product_Id=Communication::Where('communication_types_id','=','Out Of Stock')
        ->Where('product_id','>=','25')->orWhere('product_id','<=','38')->orWhere('product_id','>=','70')->orWhere('product_id','<=','75')->count();*/
        //$Product_Id2=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=',11)->count();
        // RECOMMENDED. Set URL that the ChartJS library should call, to get its data using AJAX.
        $this->chart->labels(['Machine '.$machine_rate."% "."-- ".$Machine,
        'Other_Product '.$otherproduct_rate."% "."-- ".$Other_Product
        ]);
        $this->chart->dataset('My dataset','pie',[$Machine,$Other_Product])
        /*->backgroundcolor([
            'rgb(255,140,0)',
        ])*/;
        $this->chart->load(backpack_url('charts/catalog'));

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
 //}
