<?php

namespace App\Http\Controllers\Admin\Charts;

use Backpack\CRUD\app\Http\Controllers\ChartController;
//use ConsoleTVs\Charts\Classes\Echarts\Chart;
//use ConsoleTVs\Charts\Classes\Chartjs\Chart;
use ConsoleTVs\Charts\Classes\Echarts\Chart;
//use ConsoleTVs\Charts\Classes\Fusioncharts\Chart;
//use ConsoleTVs\Charts\Classes\Highcharts\Chart;
//use ConsoleTVs\Charts\Classes\C3\Chart;
//use ConsoleTVs\Charts\Classes\Frappe\Chart;
use App\Models\Communication;
/**
 * Class OtherStockOutForeveryNotMachineChartController
 * @package App\Http\Controllers\Admin\Charts
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class OtherStockOutForeveryNotMachineChartController extends ChartController
{
    public function setup()
    {
        $this->chart = new Chart();

        $White_Pen=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','1')->count();
        $Silver_Pen=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','2')->count();
        $Leo_Pen=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','3')->count();
        $Sublimation_Pen=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','4')->count();
        $Sanitizer_Pen=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','5')->count();
        $White_Mug=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','6')->count();
        $Magic_Mug=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','7')->count();
        $Color_Mug=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','8')->count();
        $Silver_Mug=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','9')->count();
        $Golden_Mug=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','10')->count();

        //[$Thermos_Mug,$Sport_Mug_300ml,$Travel_Mug_600ml,$Mirror_Silver_Mug ,$Mirror_Golden_Mug,$Black_Frame_Mug,$V_Shape_Mug,$Enamel_Mug,$Mason_jar_Mug,$Copper_Mug]
        $Thermos_Mug=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','11')->count();
        $Sport_Mug_300ml=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','12')->count();
        $Travel_Mug_600ml=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','13')->count();
        $Mirror_Silver_Mug=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','14')->count();
        $Mirror_Golden_Mug=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','15')->count();
        $Black_Frame_Mug=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','16')->count();
        $V_Shape_Mug=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','17')->count();
        $Enamel_Mug=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','18')->count();
        $Mason_jar_Mug=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','19')->count();
        $Copper_Mug=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','20')->count();

     //[$Sublimation_Metal_Key_Chain,$MDF_Key_Chain_1_Side,$MDF_Key_Chain_2_Side,$Key_Chain_Metal_1_Side,$Binding_Machine,  $Mug_Machine,$Lamination_Machine_A3,$Heat_Press_Machine_38_A3, $Portable_Heat_Press_Machine,$Five_in_one_Heat_Press]
        $Sublimation_Metal_Key_Chain=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','21')->count();
        $MDF_Key_Chain_1_Side=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','22')->count();
        $MDF_Key_Chain_2_Side=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','23')->count();
        $Key_Chain_Metal_1_Side=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','24')->count();

        $Transfer_Paper_Light=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','39')->count();
        $Transfer_Paper_Dark=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','40')->count();

     //[$Certificate, $Special_Paper,$ATM_Flash_8GB,$ATM_Flash_32GB,$Mouse_Pad_3mm,$Mouse_Pad_2mm,$Cup_Coaster, $MDF_1_Side_Board,$MDF_2_Side_Board,$Photo_Album]

        $Certificate=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','41')->count();
        $Special_Paper=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','42')->count();
        $ATM_Flash_8GB=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','43')->count();
        $ATM_Flash_32GB=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','44')->count();
        $Mouse_Pad_3mm=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','45')->count();
        $Mouse_Pad_2mm=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','46')->count();
        $Cup_Coaster=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','47')->count();
        $MDF_1_Side_Board=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','48')->count();
        $MDF_2_Side_Board=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','49')->count();
        $Photo_Album=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','50')->count();

       // [$Frame,$Door_Hanger_1_Side,$Door_Hanger_2_Side, $Glove_Pair,$Sublimation_ink_1L,$Tape_Plaster, $Cap,$One_Side_Menu,$Six_Side_Menu,$Three_Side_Menu]

        $Frame=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','51')->count();
        $Door_Hanger_1_Side=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','52')->count();
        $Door_Hanger_2_Side=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','53')->count();
        $Glove_Pair=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','54')->count();
        $Sublimation_ink_1L=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','55')->count();
        $Tape_Plaster=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','56')->count();
        $Cap=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','57')->count();
        $One_Side_Menu=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','58')->count();
        $Six_Side_Menu=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','59')->count();
        $Three_Side_Menu=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','60')->count();

       // [$Flag_Table_Stand, $Shopping_Bag,$Roll_Up,$Table_Stapler, $Executive_Agenda,$Lamination_Mate,$lamination_Glossy,$Business_Card_Holder,$Sublimation_Paper,$Heat_Press_Machine_40_60]

        $Flag_Table_Stand=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','61')->count();
        $Shopping_Bag=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','62')->count();
        $Roll_Up=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','63')->count();
        $Table_Stapler=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','64')->count();
        $Executive_Agenda=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','65')->count();
        $Lamination_Mate=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','66')->count();
        $lamination_Glossy=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','67')->count();
        $Business_Card_Holder=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','68')->count();
        $Sublimation_Paper=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','69')->count();

        $Stamp_HB_42=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','76')->count();
        $Stamp_20_40=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','77')->count();
        $Stamp_Hy_42_Top_Ink=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','78')->count();
        $Clear_Mason_Jar_Mug=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','79')->count();
        $kids_Mug=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','80')->count();

       // [$Bamboo_Frame_15_10, $Bamboo_Frame_17_17,$Bamboo_Aluminium_Sheet_15_25,$Silcon_Pad_38_38,$Silcon_Pad_40_60,$Mug_Box, $Stamp_Rubber,$Mold_11_oz_Long,$Mold_11_oz_Short,$Mold_9_oz]

        $Bamboo_Frame_15_10=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','81')->count();
        $Bamboo_Frame_17_17=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','82')->count();
        $Bamboo_Aluminium_Sheet_15_25=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','83')->count();
        $Silcon_Pad_38_38=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','84')->count();
        $Silcon_Pad_40_60=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','85')->count();
        $Mug_Box=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','86')->count();
        $Stamp_Rubber=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','87')->count();
        $Mold_11_oz_Long=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','88')->count();
        $Mold_11_oz_Short=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','89')->count();
        $Mold_9_oz=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','90')->count();

        //[$Mold_6_oz,$MDF_Wine_Box,$Art_Knife,$Name_Tag,$Stamp_20_50,$Stamp_30_60, $Crystal_Stamp,$Mold_V_Shaped,$T_Shirt_Guide,$Vinly_Tool,$Tagging_Gun,$Tag_Pin]

        $Mold_6_oz=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','91')->count();
        $MDF_Wine_Box=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','92')->count();
        $Art_Knife=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','93')->count();
        $Name_Tag=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','94')->count();
        $Stamp_20_50=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','95')->count();
        $Stamp_30_60=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','96')->count();
        $Crystal_Stamp=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','97')->count();
        $Mold_V_Shaped=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','98')->count();
        $T_Shirt_Guide=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','99')->count();
        $Vinly_Tool=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','100')->count();
        $Tagging_Gun=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','101')->count();
        $Tag_Pin=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','102')->count();

        $other_variable=array($White_Pen,$Silver_Pen,$Leo_Pen,$Sublimation_Pen,$Sanitizer_Pen,$White_Mug, $Magic_Mug,$Color_Mug, $Silver_Mug,$Golden_Mug,
        $Thermos_Mug,$Sport_Mug_300ml,$Travel_Mug_600ml,$Mirror_Silver_Mug ,$Mirror_Golden_Mug,$Black_Frame_Mug,$V_Shape_Mug,$Enamel_Mug,$Mason_jar_Mug,$Copper_Mug,
        $Sublimation_Metal_Key_Chain,$MDF_Key_Chain_1_Side,$MDF_Key_Chain_2_Side,$Key_Chain_Metal_1_Side, $Transfer_Paper_Light,$Transfer_Paper_Dark,
        $Certificate, $Special_Paper,$ATM_Flash_8GB,$ATM_Flash_32GB,$Mouse_Pad_3mm,$Mouse_Pad_2mm,$Cup_Coaster, $MDF_1_Side_Board,$MDF_2_Side_Board,$Photo_Album,
        $Frame,$Door_Hanger_1_Side,$Door_Hanger_2_Side, $Glove_Pair,$Sublimation_ink_1L,$Tape_Plaster, $Cap,$One_Side_Menu,$Six_Side_Menu,$Three_Side_Menu,
        $Flag_Table_Stand, $Shopping_Bag,$Roll_Up,$Table_Stapler, $Executive_Agenda,$Lamination_Mate,$lamination_Glossy,$Business_Card_Holder,$Sublimation_Paper, $Stamp_HB_42,$Stamp_20_40, $Stamp_Hy_42_Top_Ink,$Clear_Mason_Jar_Mug,$kids_Mug,
        $Bamboo_Frame_15_10, $Bamboo_Frame_17_17,$Bamboo_Aluminium_Sheet_15_25,$Silcon_Pad_38_38,$Silcon_Pad_40_60,$Mug_Box, $Stamp_Rubber,$Mold_11_oz_Long,$Mold_11_oz_Short,$Mold_9_oz,
        $Mold_6_oz,$MDF_Wine_Box,$Art_Knife,$Name_Tag,$Stamp_20_50,$Stamp_30_60, $Crystal_Stamp,$Mold_V_Shaped,$T_Shirt_Guide,$Vinly_Tool,$Tagging_Gun,$Tag_Pin,
        );

        $other_label=array("White_Pen","Silver_Pen","Leo_Pen","Sublimation_Pen","Sanitizer_Pen","White_Mug"," Magic_Mug","Color_Mug"," Silver_Mug","Golden_Mug",
        "Thermos_Mug","Sport_Mug_300ml","Travel_Mug_600ml","Mirror_Silver_Mug ","Mirror_Golden_Mug","Black_Frame_Mug","V_Shape_Mug","Enamel_Mug","Mason_jar_Mug","Copper_Mug","
        Sublimation_Metal_Key_Chain","MDF_Key_Chain_1_Side","MDF_Key_Chain_2_Side","Key_Chain_Metal_1_Side","Transfer_Paper_Light","Transfer_Paper_Dark","
        Certificate"," Special_Paper","ATM_Flash_8GB","ATM_Flash_32GB","Mouse_Pad_3mm","Mouse_Pad_2mm","Cup_Coaster"," MDF_1_Side_Board","MDF_2_Side_Board","Photo_Album","
        Frame","Door_Hanger_1_Side","Door_Hanger_2_Side"," Glove_Pair","Sublimation_ink_1L","Tape_Plaster"," Cap","One_Side_Menu","Six_Side_Menu","Three_Side_Menu","
        Flag_Table_Stand"," Shopping_Bag","Roll_Up","Table_Stapler"," Executive_Agenda","Lamination_Mate","lamination_Glossy","Business_Card_Holder","Sublimation_Paper"," Stamp_HB_42","Stamp_20_40"," Stamp_Hy_42_Top_Ink","Clear_Mason_Jar_Mug","kids_Mug","
        Bamboo_Frame_15_10"," Bamboo_Frame_17_17","Bamboo_Aluminium_Sheet_15_25","Silcon_Pad_38_38","Silcon_Pad_40_60","Mug_Box"," Stamp_Rubber","Mold_11_oz_Long","Mold_11_oz_Short","Mold_9_oz","
        Mold_6_oz","MDF_Wine_Box","Art_Knife","Name_Tag","Stamp_20_50","Stamp_30_60"," Crystal_Stamp","Mold_V_Shaped","T_Shirt_Guide","Vinly_Tool","Tagging_Gun","Tag_Pin");

        $counter_other_product=count($other_variable);
        $count_other_label=count($other_label);
        $other_label_left=array();
        $other_value_left=array();
        for($x=0;$x<$counter_other_product;$x++){
            if($other_variable[$x] !==0)
        array_push($other_value_left,$other_variable[$x]);
            else
            echo "";
}


for($x=0;$x<$count_other_label;$x++){
    if($other_variable[$x] !==0)
    //echo $all_label[$x];
   array_push($other_label_left,$other_label[$x]);
    else
    echo "";
}

        $this->chart->labels($other_label_left);
        $this->chart->dataset('My dataset','pie',
        $other_value_left);

        // RECOMMENDED. Set URL that the ChartJS library should call, to get its data using AJAX.
        $this->chart->load(backpack_url('charts/other_stock_out_forevery_not_machine'));

        // OPTIONAL
        $this->chart->minimalist(false);
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
