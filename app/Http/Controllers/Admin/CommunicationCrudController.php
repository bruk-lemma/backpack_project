<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CommunicationRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\CRUD\app\Library\Widget;
use App\Http\Controllers\Admin\Charts\TotalCommunicationChartController;
use App\Http\Controllers\Admin\Charts\DeliveryWalkinChartController;
use App\Http\Controllers\Admin\Charts\XshopBrainChartController;
use App\Http\Controllers\Admin\Charts\DeliveredbyChartController;
use App\Http\Controllers\Admin\Charts\ComplaintChartController;
use App\Http\Controllers\Admin\Charts\ProductComplaintChartController;
use App\Http\Controllers\Admin\Charts\ServiceComplaintChartController;
use App\Http\Controllers\Admin\Charts\CatalogChartController;
use App\Http\Controllers\Admin\Charts\EvaluationForEveryProductChartController;
use Backpack\CRUD\app\Http\Controllers\ChartController;
//use App\Models\Communication;
use App\Models\Communication;
use App\Models\Product;
/**
 * Class PersonCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CommunicationCrudController extends CrudController
{
        // use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
        use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
        // use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
        //use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

        /**
         * Configure the CrudPanel object. Apply settings to all operations.
         *
         * @return void
         */
        public function setup()
        {

            CRUD::setModel(\App\Models\Communication::class);
            CRUD::setRoute(config('backpack.base.route_prefix') . '/Communication');
            CRUD::setEntityNameStrings('Communication', 'Communications');
            $this->crud->allowAccess('operation');
            $this->crud->allowAccess('operation1');

                $this->crud->addFilter([
                'name'  => 'updated_from_to',
                'label' => trans('common.updated_range'),
                'type'  => 'date_range_refresh',
                ],
                false,
                 function ($value)
                 { // if the filter is active, apply these constraints
                    $dates = json_decode($value);
                    $this->crud->addClause('where', 'updated_at', '>=', $dates->from);
                    $this->crud->addClause('where', 'updated_at', '<=', $dates->to . ' 23:59:59');

                    $complaint= Communication::Where('communication_types_id','=','complaint')
                    ->Where('created_at', '>=', $dates->from)
                    ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
                    $sells = Communication::Where('communication_types_id','=','sells')
                    ->Where('created_at', '>=', $dates->from)
                    ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
                    $price = Communication::Where('communication_types_id','=','price')
                    ->Where('created_at', '>=', $dates->from)
                    ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
                    $evaluation = Communication::Where('communication_types_id','=','evaluation')
                    ->Where('created_at', '>=', $dates->from)
                    ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
                    $out_of_stock = Communication::Where('communication_types_id','=','Out Of Stock')
                    ->Where('created_at', '>=', $dates->from)
                    ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
                    $out_of_List = Communication::Where('communication_types_id','=','Out Of List')
                    ->Where('created_at', '>=', $dates->from)
                    ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
                    $preorder=Communication::Where('communication_types_id','=','preorder')
                    ->Where('created_at', '>=', $dates->from)
                    ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
                    $service=Communication::Where('communication_types_id','=','service')
                    ->Where('created_at', '>=', $dates->from)
                    ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
                    $total_phone_call=Communication::Where('communication_ways_id','=','phone')
                    ->Where('created_at', '>=', $dates->from)
                    ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
                    $total_seconds=Communication::Where('communication_ways_id','=','phone')->sum('second')/60;


                        $delivery=Communication::Where('communication_types_id','=','sells')->Where('sells_type', '=' ,'Delivery')
                        ->Where('created_at', '>=', $dates->from)
                        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
                        $walkin=Communication::Where('communication_types_id','=','sells')->Where('sells_type','=','Physical Sells')
                        ->Where('created_at', '>=', $dates->from)
                        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
                        $xshop_physical_sells=Communication::Where('communication_types_id','=','sells')->Where('sells_type', '=' ,'Physical Sells')->Where('branch', '=','Xshop')
                        ->Where('created_at', '>=', $dates->from)
                        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
                        $brain_physical_sells=Communication::Where('communication_types_id','=','sells')->Where('sells_type','=','Physical Sells')->Where('branch','=','Brain')
                        ->Where('created_at', '>=', $dates->from)
                        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
                        $Company_Delivery=Communication::Where('communication_types_id','=','sells')->Where('sells_type', '=' ,'delivery')->Where('delivered_by', '=','Company Property')
                        ->Where('created_at', '>=', $dates->from)
                        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
                        $OutSource_Delivery=Communication::Where('communication_types_id','=','sells')->Where('sells_type','=','delivery')->Where('delivered_by','=','Outsource')
                        ->Where('created_at', '>=', $dates->from)
                        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();

                        $Product_Complaint=Communication::Where('communication_types_id','=','Complaint')->Where('comp_type', '=' ,'Product')
                        ->Where('created_at', '>=', $dates->from)
                        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
                        $Service_Complaint=Communication::Where('communication_types_id','=','Complaint')->Where('comp_type','=','Service')
                        ->Where('created_at', '>=', $dates->from)
                        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
                        $Resolved_Product_Complaint=Communication::Where('communication_types_id','=','Complaint')->Where('comp_type', '=' ,'Product')->Where('complain_status','=','resolved')
                        ->Where('created_at', '>=', $dates->from)
                        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
                        $Unresolved_Product_Complaint=Communication::Where('communication_types_id','=','Complaint')->Where('comp_type', '=' ,'Product')->Where('complain_status','=','unresolved')
                        ->Where('created_at', '>=', $dates->from)
                        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
                        $Resolved_Service_Complaint=Communication::Where('communication_types_id','=','Complaint')->Where('comp_type', '=' ,'Service')->Where('complain_status','=','resolved')
                        ->Where('created_at', '>=', $dates->from)
                        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
                        $Unresolved_Service_Complaint=Communication::Where('communication_types_id','=','Complaint')->Where('comp_type', '=' ,'Service')->Where('complain_status','=','unresolved')
                        ->Where('created_at', '>=', $dates->from)
                        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();


                        $Machinesd=Communication::Where('communication_types_id','=','Out Of Stock')
                        ->whereIn('product_id', [25,26,27,28,29,30,31,32,33,34,35,36,37,38,70,71,72,73,74,75])
                        ->Where('created_at', '>=', $dates->from)
                        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();

                        $Other_Product=Communication::Where('communication_types_id','=','Out Of Stock')
                        ->whereNotIn('product_id', [25,26,27,28,29,30,31,32,33,34,35,36,37,38,70,71,72,73,74,75])
                        ->Where('created_at', '>=', $dates->from)
                        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
/******************************************************************************************************************** */

            $White_Pen=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','1')->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $Silver_Pen=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','2')->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $Leo_Pen=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','3')->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $Sublimation_Pen=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','4')->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $Sanitizer_Pen=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','5')->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $White_Mug=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','6')->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $Magic_Mug=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','7')->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $Color_Mug=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','8')->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $Silver_Mug=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','9')->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $Golden_Mug=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','10')->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();

            //[$Thermos_Mug,$Sport_Mug_300ml,$Travel_Mug_600ml,$Mirror_Silver_Mug ,$Mirror_Golden_Mug,$Black_Frame_Mug,$V_Shape_Mug,$Enamel_Mug,$Mason_jar_Mug,$Copper_Mug]
            $Thermos_Mug=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','11')->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $Sport_Mug_300ml=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','12')->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $Travel_Mug_600ml=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','13')->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $Mirror_Silver_Mug=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','14')->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $Mirror_Golden_Mug=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','15')->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $Black_Frame_Mug=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','16')->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $V_Shape_Mug=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','17')->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $Enamel_Mug=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','18')->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $Mason_jar_Mug=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','19')->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $Copper_Mug=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','20')->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();

            //[$Sublimation_Metal_Key_Chain,$MDF_Key_Chain_1_Side,$MDF_Key_Chain_2_Side,$Key_Chain_Metal_1_Side,$Binding_Machine,  $Mug_Machine,$Lamination_Machine_A3,$Heat_Press_Machine_38_A3, $Portable_Heat_Press_Machine,$Five_in_one_Heat_Press]
            $Sublimation_Metal_Key_Chain=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','21')->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $MDF_Key_Chain_1_Side=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','22')->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $MDF_Key_Chain_2_Side=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','23')->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $Key_Chain_Metal_1_Side=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','24')->count();

            $Transfer_Paper_Light=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','39')->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $Transfer_Paper_Dark=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','40')->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();

            //[$Certificate, $Special_Paper,$ATM_Flash_8GB,$ATM_Flash_32GB,$Mouse_Pad_3mm,$Mouse_Pad_2mm,$Cup_Coaster, $MDF_1_Side_Board,$MDF_2_Side_Board,$Photo_Album]

            $Certificate=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','41')->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $Special_Paper=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','42')->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $ATM_Flash_8GB=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','43')->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $ATM_Flash_32GB=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','44')->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $Mouse_Pad_3mm=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','45')->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $Mouse_Pad_2mm=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','46')->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $Cup_Coaster=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','47')->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $MDF_1_Side_Board=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','48')->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $MDF_2_Side_Board=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','49')->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $Photo_Album=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','50')->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();

            // [$Frame,$Door_Hanger_1_Side,$Door_Hanger_2_Side, $Glove_Pair,$Sublimation_ink_1L,$Tape_Plaster, $Cap,$One_Side_Menu,$Six_Side_Menu,$Three_Side_Menu]

            $Frame=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','51')->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $Door_Hanger_1_Side=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','52')->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $Door_Hanger_2_Side=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','53')->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $Glove_Pair=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','54')->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $Sublimation_ink_1L=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','55')->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $Tape_Plaster=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','56')->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $Cap=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','57')->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $One_Side_Menu=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','58')->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $Six_Side_Menu=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','59')->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $Three_Side_Menu=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','60')->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();

            // [$Flag_Table_Stand, $Shopping_Bag,$Roll_Up,$Table_Stapler, $Executive_Agenda,$Lamination_Mate,$lamination_Glossy,$Business_Card_Holder,$Sublimation_Paper,$Heat_Press_Machine_40_60]

            $Flag_Table_Stand=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','61')->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $Shopping_Bag=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','62')->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $Roll_Up=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','63')->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $Table_Stapler=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','64')->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $Executive_Agenda=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','65')->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $Lamination_Mate=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','66')->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $lamination_Glossy=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','67')->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $Business_Card_Holder=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','68')->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $Sublimation_Paper=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','69')->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();

            $Stamp_HB_42=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','76')->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $Stamp_20_40=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','77')->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $Stamp_Hy_42_Top_Ink=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','78')->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $Clear_Mason_Jar_Mug=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','79')->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $kids_Mug=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','80')->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();

            // [$Bamboo_Frame_15_10, $Bamboo_Frame_17_17,$Bamboo_Aluminium_Sheet_15_25,$Silcon_Pad_38_38,$Silcon_Pad_40_60,$Mug_Box, $Stamp_Rubber,$Mold_11_oz_Long,$Mold_11_oz_Short,$Mold_9_oz]

            $Bamboo_Frame_15_10=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','81')->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $Bamboo_Frame_17_17=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','82')->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $Bamboo_Aluminium_Sheet_15_25=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','83')->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $Silcon_Pad_38_38=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','84')->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $Silcon_Pad_40_60=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','85')->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $Mug_Box=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','86')->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $Stamp_Rubber=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','87')->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $Mold_11_oz_Long=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','88')->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $Mold_11_oz_Short=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','89')->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $Mold_9_oz=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','90')->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();

            //[$Mold_6_oz,$MDF_Wine_Box,$Art_Knife,$Name_Tag,$Stamp_20_50,$Stamp_30_60, $Crystal_Stamp,$Mold_V_Shaped,$T_Shirt_Guide,$Vinly_Tool,$Tagging_Gun,$Tag_Pin]

            $Mold_6_oz=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','91')->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $MDF_Wine_Box=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','92')->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $Art_Knife=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','93')->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $Name_Tag=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','94')->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $Stamp_20_50=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','95')->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $Stamp_30_60=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','96')->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $Crystal_Stamp=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','97')->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $Mold_V_Shaped=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','98')->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $T_Shirt_Guide=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','99')->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $Vinly_Tool=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','100')->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $Tagging_Gun=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','101')->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $Tag_Pin=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','102')->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();



            $other_variable=array($White_Pen,$Silver_Pen,$Leo_Pen,$Sublimation_Pen,$Sanitizer_Pen,$White_Mug, $Magic_Mug,$Color_Mug, $Silver_Mug,$Golden_Mug,
            $Thermos_Mug,$Sport_Mug_300ml,$Travel_Mug_600ml,$Mirror_Silver_Mug ,$Mirror_Golden_Mug,$Black_Frame_Mug,$V_Shape_Mug,$Enamel_Mug,$Mason_jar_Mug,$Copper_Mug,
            $Sublimation_Metal_Key_Chain,$MDF_Key_Chain_1_Side,$MDF_Key_Chain_2_Side,$Key_Chain_Metal_1_Side, $Transfer_Paper_Light,$Transfer_Paper_Dark,
            $Certificate, $Special_Paper,$ATM_Flash_8GB,$ATM_Flash_32GB,$Mouse_Pad_3mm,$Mouse_Pad_2mm,$Cup_Coaster, $MDF_1_Side_Board,$MDF_2_Side_Board,$Photo_Album,
            $Frame,$Door_Hanger_1_Side,$Door_Hanger_2_Side, $Glove_Pair,$Sublimation_ink_1L,$Tape_Plaster, $Cap,$One_Side_Menu,$Six_Side_Menu,$Three_Side_Menu,
            $Flag_Table_Stand, $Shopping_Bag,$Roll_Up,$Table_Stapler, $Executive_Agenda,$Lamination_Mate,$lamination_Glossy,$Business_Card_Holder,$Sublimation_Paper, $Stamp_HB_42,$Stamp_20_40, $Stamp_Hy_42_Top_Ink,$Clear_Mason_Jar_Mug,$kids_Mug,
            $Bamboo_Frame_15_10, $Bamboo_Frame_17_17,$Bamboo_Aluminium_Sheet_15_25,$Silcon_Pad_38_38,$Silcon_Pad_40_60,$Mug_Box, $Stamp_Rubber,$Mold_11_oz_Long,$Mold_11_oz_Short,$Mold_9_oz,
            $Mold_6_oz,$MDF_Wine_Box,$Art_Knife,$Name_Tag,$Stamp_20_50,$Stamp_30_60, $Crystal_Stamp,$Mold_V_Shaped,$T_Shirt_Guide,$Vinly_Tool,$Tagging_Gun,$Tag_Pin,
            );

            $other_label=array("White_Pen","Silver_Pen","Leo_Pen","Sublimation_Pen","Sanitizer_Pen","White_Mug"," Magic_Mug","Color_Mug"," Silver_Mug","Golden_Mug","
            Thermos_Mug","Sport_Mug_300ml","Travel_Mug_600ml","Mirror_Silver_Mug ","Mirror_Golden_Mug","Black_Frame_Mug","V_Shape_Mug","Enamel_Mug","Mason_jar_Mug","Copper_Mug","
            Sublimation_Metal_Key_Chain","MDF_Key_Chain_1_Side","MDF_Key_Chain_2_Side","Key_Chain_Metal_1_Side","Transfer_Paper_Light","Transfer_Paper_Dark","
            Certificate"," Special_Paper","ATM_Flash_8GB","ATM_Flash_32GB","Mouse_Pad_3mm","Mouse_Pad_2mm","Cup_Coaster"," MDF_1_Side_Board","MDF_2_Side_Board","Photo_Album","
            Frame","Door_Hanger_1_Side","Door_Hanger_2_Side"," Glove_Pair","Sublimation_ink_1L","Tape_Plaster"," Cap","One_Side_Menu","Six_Side_Menu","Three_Side_Menu","
            Flag_Table_Stand"," Shopping_Bag","Roll_Up","Table_Stapler"," Executive_Agenda","Lamination_Mate","lamination_Glossy","Business_Card_Holder","Sublimation_Paper"," Stamp_HB_42","Stamp_20_40"," Stamp_Hy_42_Top_Ink","Clear_Mason_Jar_Mug","kids_Mug","
            Bamboo_Frame_15_10"," Bamboo_Frame_17_17","Bamboo_Aluminium_Sheet_15_25","Silcon_Pad_38_38","Silcon_Pad_40_60","Mug_Box"," Stamp_Rubber","Mold_11_oz_Long","Mold_11_oz_Short","Mold_9_oz","
            Mold_6_oz","MDF_Wine_Box","Art_Knife","Name_Tag","Stamp_20_50","Stamp_30_60"," Crystal_Stamp","Mold_V_Shaped","T_Shirt_Guide","Vinly_Tool","Tagging_Gun","Tag_Pin");

           /* $counter=count($all_variable);
            $count=count($all_label);

            $left=array();
            $right=array();

            for($x=0;$x<$counter;$x++){
            if($all_variable[$x] !==0)
            array_push($right,$all_variable[$x]);
            else
            echo "";
            }
            $total_stock_out=array_sum($right);
            $right_len=count($right);

            for($x=0;$x<$count;$x++){
            if($all_variable[$x] !==0)

            array_push($left,$all_label[$x]);
            else
            echo "";
            }

            for($y=0;$y<$right_len;$y++){
            echo ($right[$y]." ".$left[$y]);
            }*/
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

            $Binding_Machine=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','25')
            ->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $Mug_Machine=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','26')
            ->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $Lamination_Machine_A3=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','27')
            ->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $Heat_Press_Machine_38_A3=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','28')
            ->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $Portable_Heat_Press_Machine=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','29')
            ->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $Five_in_one_Heat_Press=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','30')
            ->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();

            //[$Mug_Machine_Five_in_one,$Flash_Stamp_Machine,$Pen_Machine,$Id_Cutter,$Cap_Machine,$Desk_Mate_Stamp,$Epson_Printer_Machine_L382,$Epson_Printer_Machine_L805, $Transfer_Paper_Light,$Transfer_Paper_Dark]

            $Mug_Machine_Five_in_one=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','31')
            ->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $Flash_Stamp_Machine=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','32')
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $Pen_Machine=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','33')
            ->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $Id_Cutter=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','34')
            ->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $Cap_Machine=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','35')
            ->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $Desk_Mate_Stamp=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','36')
            ->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $Epson_Printer_Machine_L382=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','37')
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $Epson_Printer_Machine_L805=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','38')
            ->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $Heat_Press_Machine_40_60=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','70')
            ->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();

            //[$Plotter_70cm,$Plotter_130cm, $Lamination_Machine_A2,$Eight_in_1_Heat_Press,$Two_in_1_Heat_Press, $Stamp_HB_42,$Stamp_20_40, $Stamp_Hy_42_Top_Ink,$Clear_Mason_Jar_Mug,$kids_Mug]
            $Plotter_70cm=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','71')
            ->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $Plotter_130cm=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','72')
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $Lamination_Machine_A2=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','73')
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $Eight_in_1_Heat_Press=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','74')
            ->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
            $Two_in_1_Heat_Press=Communication::Where('communication_types_id','=','Out Of Stock')->Where('product_id','=','75')
            ->Where('created_at', '>=', $dates->from)
            ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();

            $machine_label=array("Binding_Machine"," Mug_Machine","Lamination_Machine_A3","Heat_Press_Machine_38_A3"," Portable_Heat_Press_Machine","Five_in_one_Heat_Press","
            Mug_Machine_Five_in_one","Flash_Stamp_Machine","Pen_Machine","Id_Cutter","Cap_Machine","Desk_Mate_Stamp","Epson_Printer_Machine_L382","Epson_Printer_Machine_L805","Heat_Press_Machine_40_60","
            Plotter_70cm","Plotter_130cm"," Lamination_Machine_A2","Eight_in_1_Heat_Press","Two_in_1_Heat_Press");

            $machine_variable=array($Binding_Machine,$Mug_Machine,$Lamination_Machine_A3,$Heat_Press_Machine_38_A3, $Portable_Heat_Press_Machine,$Five_in_one_Heat_Press,
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

            /***********************************************************************************************************************************************************************************
             ***************************************************************************************************************************
             */
        $White_Pen=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','1')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $Silver_Pen=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','2')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $Leo_Pen=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','3')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $Sublimation_Pen=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','4')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $Sanitizer_Pen=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','5')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $White_Mug=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','6')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $Magic_Mug=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','7')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $Color_Mug=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','8')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $Silver_Mug=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','9')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $Golden_Mug=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','10')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();

        //[$Thermos_Mug,$Sport_Mug_300ml,$Travel_Mug_600ml,$Mirror_Silver_Mug ,$Mirror_Golden_Mug,$Black_Frame_Mug,$V_Shape_Mug,$Enamel_Mug,$Mason_jar_Mug,$Copper_Mug]
        $Thermos_Mug=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','11')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $Sport_Mug_300ml=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','12')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $Travel_Mug_600ml=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','13')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $Mirror_Silver_Mug=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','14')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $Mirror_Golden_Mug=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','15')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $Black_Frame_Mug=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','16')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $V_Shape_Mug=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','17')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $Enamel_Mug=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','18')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $Mason_jar_Mug=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','19')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $Copper_Mug=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','20')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();

     //[$Sublimation_Metal_Key_Chain,$MDF_Key_Chain_1_Side,$MDF_Key_Chain_2_Side,$Key_Chain_Metal_1_Side,$Binding_Machine,  $Mug_Machine,$Lamination_Machine_A3,$Heat_Press_Machine_38_A3, $Portable_Heat_Press_Machine,$Five_in_one_Heat_Press]
        $Sublimation_Metal_Key_Chain=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','21')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $MDF_Key_Chain_1_Side=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','22')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $MDF_Key_Chain_2_Side=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','23')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $Key_Chain_Metal_1_Side=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','24')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $Binding_Machine=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','25')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $Mug_Machine=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','26')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $Lamination_Machine_A3=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','27')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $Heat_Press_Machine_38_A3=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','28')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $Portable_Heat_Press_Machine=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','29')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $Five_in_one_Heat_Press=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','30')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();

        //[$Mug_Machine_Five_in_one,$Flash_Stamp_Machine,$Pen_Machine,$Id_Cutter,$Cap_Machine,$Desk_Mate_Stamp,$Epson_Printer_Machine_L382,$Epson_Printer_Machine_L805, $Transfer_Paper_Light,$Transfer_Paper_Dark]

        $Mug_Machine_Five_in_one=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','31')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $Flash_Stamp_Machine=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','32')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $Pen_Machine=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','33')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $Id_Cutter=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','34')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $Cap_Machine=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','35')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $Desk_Mate_Stamp=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','36')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $Epson_Printer_Machine_L382=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','37')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $Epson_Printer_Machine_L805=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','38')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $Transfer_Paper_Light=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','39')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $Transfer_Paper_Dark=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','40')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();

     //[$Certificate, $Special_Paper,$ATM_Flash_8GB,$ATM_Flash_32GB,$Mouse_Pad_3mm,$Mouse_Pad_2mm,$Cup_Coaster, $MDF_1_Side_Board,$MDF_2_Side_Board,$Photo_Album]

        $Certificate=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','41')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $Special_Paper=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','42')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $ATM_Flash_8GB=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','43')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $ATM_Flash_32GB=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','44')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $Mouse_Pad_3mm=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','45')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $Mouse_Pad_2mm=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','46')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $Cup_Coaster=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','47')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $MDF_1_Side_Board=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','48')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $MDF_2_Side_Board=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','49')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $Photo_Album=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','50')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();

       // [$Frame,$Door_Hanger_1_Side,$Door_Hanger_2_Side, $Glove_Pair,$Sublimation_ink_1L,$Tape_Plaster, $Cap,$One_Side_Menu,$Six_Side_Menu,$Three_Side_Menu]

        $Frame=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','51')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $Door_Hanger_1_Side=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','52')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $Door_Hanger_2_Side=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','53')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $Glove_Pair=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','54')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $Sublimation_ink_1L=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','55')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $Tape_Plaster=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','56')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $Cap=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','57')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $One_Side_Menu=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','58')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $Six_Side_Menu=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','59')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $Three_Side_Menu=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','60')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();

       // [$Flag_Table_Stand, $Shopping_Bag,$Roll_Up,$Table_Stapler, $Executive_Agenda,$Lamination_Mate,$lamination_Glossy,$Business_Card_Holder,$Sublimation_Paper,$Heat_Press_Machine_40_60]

        $Flag_Table_Stand=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','61')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $Shopping_Bag=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','62')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $Roll_Up=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','63')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $Table_Stapler=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','64')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $Executive_Agenda=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','65')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $Lamination_Mate=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','66')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $lamination_Glossy=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','67')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $Business_Card_Holder=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','68')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $Sublimation_Paper=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','69')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $Heat_Press_Machine_40_60=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','70')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();

        //[$Plotter_70cm,$Plotter_130cm, $Lamination_Machine_A2,$Eight_in_1_Heat_Press,$Two_in_1_Heat_Press, $Stamp_HB_42,$Stamp_20_40, $Stamp_Hy_42_Top_Ink,$Clear_Mason_Jar_Mug,$kids_Mug]
        $Plotter_70cm=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','71')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $Plotter_130cm=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','72')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $Lamination_Machine_A2=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','73')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $Eight_in_1_Heat_Press=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','74')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $Two_in_1_Heat_Press=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','75')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $Stamp_HB_42=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','76')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $Stamp_20_40=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','77')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $Stamp_Hy_42_Top_Ink=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','78')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $Clear_Mason_Jar_Mug=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','79')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $kids_Mug=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','80')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();

       // [$Bamboo_Frame_15_10, $Bamboo_Frame_17_17,$Bamboo_Aluminium_Sheet_15_25,$Silcon_Pad_38_38,$Silcon_Pad_40_60,$Mug_Box, $Stamp_Rubber,$Mold_11_oz_Long,$Mold_11_oz_Short,$Mold_9_oz]

        $Bamboo_Frame_15_10=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','81')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $Bamboo_Frame_17_17=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','82')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $Bamboo_Aluminium_Sheet_15_25=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','83')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $Silcon_Pad_38_38=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','84')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $Silcon_Pad_40_60=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','85')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $Mug_Box=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','86')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $Stamp_Rubber=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','87')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $Mold_11_oz_Long=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','88')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $Mold_11_oz_Short=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','89')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $Mold_9_oz=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','90')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();

        //[$Mold_6_oz,$MDF_Wine_Box,$Art_Knife,$Name_Tag,$Stamp_20_50,$Stamp_30_60, $Crystal_Stamp,$Mold_V_Shaped,$T_Shirt_Guide,$Vinly_Tool,$Tagging_Gun,$Tag_Pin]

        $Mold_6_oz=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','91')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $MDF_Wine_Box=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','92')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $Art_Knife=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','93')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $Name_Tag=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','94')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $Stamp_20_50=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','95')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $Stamp_30_60=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','96')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $Crystal_Stamp=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','97')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $Mold_V_Shaped=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','98')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $T_Shirt_Guide=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','99')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $Vinly_Tool=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','100')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $Tagging_Gun=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','101')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();
        $Tag_Pin=Communication::Where('communication_types_id','=','Evaluation')->Where('product_id','=','102')->Where('created_at', '>=', $dates->from)
        ->Where('created_at', '<=', $dates->to . ' 23:59:59')->count();

        $evaluation_label=array("White_Pen","Silver_Pen","Leo_Pen","Sublimation_Pen","Sanitizer_Pen","White_Mug"," Magic_Mug","Color_Mug"," Silver_Mug","Golden_Mug","
        Thermos_Mug","Sport_Mug_300ml","Travel_Mug_600ml","Mirror_Silver_Mug ","Mirror_Golden_Mug","Black_Frame_Mug","V_Shape_Mug","Enamel_Mug","Mason_jar_Mug","Copper_Mug","
        Sublimation_Metal_Key_Chain","MDF_Key_Chain_1_Side","MDF_Key_Chain_2_Side","Key_Chain_Metal_1_Side","Binding_Machine","  Mug_Machine","Lamination_Machine_A3","Heat_Press_Machine_38_A3"," Portable_Heat_Press_Machine","Five_in_one_Heat_Press","
        Mug_Machine_Five_in_one","Flash_Stamp_Machine","Pen_Machine","Id_Cutter","Cap_Machine","Desk_Mate_Stamp","Epson_Printer_Machine_L382","Epson_Printer_Machine_L805"," Transfer_Paper_Light","Transfer_Paper_Dark","
        Certificate"," Special_Paper","ATM_Flash_8GB","ATM_Flash_32GB","Mouse_Pad_3mm","Mouse_Pad_2mm","Cup_Coaster"," MDF_1_Side_Board","MDF_2_Side_Board","Photo_Album","
        Frame","Door_Hanger_1_Side","Door_Hanger_2_Side"," Glove_Pair","Sublimation_ink_1L","Tape_Plaster"," Cap","One_Side_Menu","Six_Side_Menu","Three_Side_Menu","
        Flag_Table_Stand"," Shopping_Bag","Roll_Up","Table_Stapler"," Executive_Agenda","Lamination_Mate","lamination_Glossy","Business_Card_Holder","Sublimation_Paper","Heat_Press_Machine_40_60","
        Plotter_70cm","Plotter_130cm"," Lamination_Machine_A2","Eight_in_1_Heat_Press","Two_in_1_Heat_Press"," Stamp_HB_42","Stamp_20_40"," Stamp_Hy_42_Top_Ink","Clear_Mason_Jar_Mug","kids_Mug","
        Bamboo_Frame_15_10"," Bamboo_Frame_17_17","Bamboo_Aluminium_Sheet_15_25","Silcon_Pad_38_38","Silcon_Pad_40_60","Mug_Box"," Stamp_Rubber","Mold_11_oz_Long","Mold_11_oz_Short","Mold_9_oz","
        Mold_6_oz","MDF_Wine_Box","Art_Knife","Name_Tag","Stamp_20_50","Stamp_30_60"," Crystal_Stamp","Mold_V_Shaped","T_Shirt_Guide","Vinly_Tool","Tagging_Gun","Tag_Pin");

        $evaluation_variable=array($White_Pen,$Silver_Pen,$Leo_Pen,$Sublimation_Pen,$Sanitizer_Pen,$White_Mug, $Magic_Mug,$Color_Mug, $Silver_Mug,$Golden_Mug,
        $Thermos_Mug,$Sport_Mug_300ml,$Travel_Mug_600ml,$Mirror_Silver_Mug ,$Mirror_Golden_Mug,$Black_Frame_Mug,$V_Shape_Mug,$Enamel_Mug,$Mason_jar_Mug,$Copper_Mug,
        $Sublimation_Metal_Key_Chain,$MDF_Key_Chain_1_Side,$MDF_Key_Chain_2_Side,$Key_Chain_Metal_1_Side,$Binding_Machine,  $Mug_Machine,$Lamination_Machine_A3,$Heat_Press_Machine_38_A3, $Portable_Heat_Press_Machine,$Five_in_one_Heat_Press,
        $Mug_Machine_Five_in_one,$Flash_Stamp_Machine,$Pen_Machine,$Id_Cutter,$Cap_Machine,$Desk_Mate_Stamp,$Epson_Printer_Machine_L382,$Epson_Printer_Machine_L805, $Transfer_Paper_Light,$Transfer_Paper_Dark,
        $Certificate, $Special_Paper,$ATM_Flash_8GB,$ATM_Flash_32GB,$Mouse_Pad_3mm,$Mouse_Pad_2mm,$Cup_Coaster, $MDF_1_Side_Board,$MDF_2_Side_Board,$Photo_Album,
        $Frame,$Door_Hanger_1_Side,$Door_Hanger_2_Side, $Glove_Pair,$Sublimation_ink_1L,$Tape_Plaster, $Cap,$One_Side_Menu,$Six_Side_Menu,$Three_Side_Menu,
        $Flag_Table_Stand, $Shopping_Bag,$Roll_Up,$Table_Stapler, $Executive_Agenda,$Lamination_Mate,$lamination_Glossy,$Business_Card_Holder,$Sublimation_Paper,$Heat_Press_Machine_40_60,
        $Plotter_70cm,$Plotter_130cm, $Lamination_Machine_A2,$Eight_in_1_Heat_Press,$Two_in_1_Heat_Press, $Stamp_HB_42,$Stamp_20_40, $Stamp_Hy_42_Top_Ink,$Clear_Mason_Jar_Mug,$kids_Mug,
        $Bamboo_Frame_15_10, $Bamboo_Frame_17_17,$Bamboo_Aluminium_Sheet_15_25,$Silcon_Pad_38_38,$Silcon_Pad_40_60,$Mug_Box, $Stamp_Rubber,$Mold_11_oz_Long,$Mold_11_oz_Short,$Mold_9_oz,
        $Mold_6_oz,$MDF_Wine_Box,$Art_Knife,$Name_Tag,$Stamp_20_50,$Stamp_30_60, $Crystal_Stamp,$Mold_V_Shaped,$T_Shirt_Guide,$Vinly_Tool,$Tagging_Gun,$Tag_Pin);

                $evaluation_counter=count($evaluation_variable);
                $evaluation_count=count($evaluation_label);
                $evaluation_label_left=array();
                $evaluation_value_left=array();
                for($x=0;$x<$evaluation_counter;$x++){
                    if($evaluation_variable[$x] !==0)
                array_push( $evaluation_value_left,$evaluation_variable[$x]);
                    else
                    echo "";
        }


        for($x=0;$x<$evaluation_count;$x++){
            if($evaluation_variable[$x] !==0)
            //echo $all_label[$x];
           array_push( $evaluation_label_left,$evaluation_label[$x]);
            else
            echo "";
        }

                     Widget::add([
                        'type' => 'chart',
                        'controller' => \App\Http\Controllers\Admin\Charts\TotalCommunicationChartController::class,
                        // OPTIONALS
                        // 'class'   => 'card mb-2',
                         'wrapper' => ['class'=> 'col-md-12'],
                         //'style' => 'border-radius: 10px',
                         //'class'   => 'column',

                         'content' => [
                              'header' => 'Total Communication Data',
                             // 'body'   => 'This chart should make it obvious how many new users have signed up in the past 7 days.<br><br>',
                            ],
                        ]);
                     Widget::add([
                        'type' => 'div',
                        'class' =>'row',
                        //'wrapper' => ['class'=> 'col-md-'],
                        'content' => [
                            [ 'type' => 'card','class'=>'card bg-success text-white', 'content' => ['header' => 'Sells','body' => $sells]],
                            [ 'type' => 'card','class'=>'card bg-success text-white', 'content' => ['header' => 'Complaint','body' => $complaint] ],
                            [ 'type' => 'card','class'=>'card bg-success text-white', 'content' => ['header' => 'Price','body' => $price] ],
                            [ 'type' => 'card','class'=>'card bg-success text-white','content'  => ['header' => 'Evaluation','body' => $evaluation] ],
                            [ 'type' => 'card','class'=>'card bg-success text-white', 'content' => ['header' => 'Outof_stock','body' => $out_of_stock] ],
                            [ 'type' => 'card','class'=>'card bg-success text-white', 'content' => ['header' => 'Outof_List','body' => $out_of_List] ],
                            [ 'type' => 'card','class'=>'card bg-success text-white', 'content' => ['header' => 'Preorder','body' => $preorder] ],
                            [ 'type' => 'card','class'=>'card bg-success text-white','content'  => ['header' => 'Service','body' => $service] ],
                            [ 'type' => 'card','class'=>'card bg-success text-white','content'  => ['header' => 'Total Phone Call','body' => $total_phone_call] ],
                            [ 'type' => 'card','class'=>'card bg-success text-white', 'content' => ['header' => 'Total Minutes','body' =>  $total_seconds."      Minutes"] ],

                        ]
                       ]);

                           Widget::add([
                            'type' => 'div',
                            'class' =>'column',
                            'content' => [
                                ['type' => 'chart','class' =>'Column', 'wrapper' => ['class'=> 'col-md-8'] ,'content' => [
                                    'header' => 'Sells Type'] ,'controller' => \App\Http\Controllers\Admin\Charts\DeliveryWalkinChartController::class,],
                                ['type' => 'chart','class' =>'Column', 'wrapper' => ['class'=> 'col-md-8'] ,'content' => [
                                    'header' => 'Xshop Brain physical Sells'],'controller' => \App\Http\Controllers\Admin\Charts\XshopBrainChartController::class,],
                                ['type' => 'chart','class' =>'Column', 'wrapper' => ['class'=> 'col-md-10'] ,'content' => [
                                    'header' => 'Delivery Type'],'controller' => \App\Http\Controllers\Admin\Charts\DeliveredbyChartController::class,],
                            ]
                           ]);
                           Widget::add([
                            'type' => 'div',
                            'class' =>'row',
                            'content' => [
                                [ 'type' => 'card','class'=>'card bg-success text-white','wrapper' => ['class' => 'col-sm-4'],'content'  => ['header' => 'Walkin','body' => $walkin] ],
                                [ 'type' => 'card','class'=>'card bg-success text-white','content'  => ['header' => 'Xshop Physical Sells','body' => $xshop_physical_sells ] ],
                                [ 'type' => 'card','class'=>'card bg-success text-white','content'  => ['header' => 'Company Delivery','body' => $Company_Delivery ] ],
                            ]
                           ]);
                           Widget::add([
                            'type' => 'div',
                            'class' =>'row',
                            'content' => [
                                [ 'type' => 'card','class'=>'card bg-success text-white','content'  => ['header' => 'Delivery','body' => $delivery ] ],
                                [ 'type' => 'card','class'=>'card bg-success text-white','content'  => ['header' => 'Brain Physical Sells','body' => $brain_physical_sells ] ],
                                [ 'type' => 'card','class'=>'card bg-success text-white','content'  => ['header' => 'OutSource Delivery','body' => $OutSource_Delivery] ],
                            ]
                           ]);
                           Widget::add([
                            'type' => 'div',
                            'class' =>'column',
                            'content' => [
                                ['type' => 'chart','class' =>'Column', 'wrapper' => ['class'=> 'col-md-12'] ,'content' => [
                                    'header' => 'Complaint'],'controller' => \App\Http\Controllers\Admin\Charts\ComplaintChartController::class,],
                                ['type' => 'chart','class' =>'Column', 'wrapper' => ['class'=> 'col-md-8'] ,'content' => [
                                    'header' => 'Product Complaint'],'controller' => \App\Http\Controllers\Admin\Charts\ProductComplaintChartController::class,],
                                ['type' => 'chart','class' =>'Column', 'wrapper' => ['class'=> 'col-md-8 '] ,'content' => [
                                'header' => 'Service Complaint'],'controller' => \App\Http\Controllers\Admin\Charts\ServiceComplaintChartController::class,],
                            ]
                           ]);
                           Widget::add([
                            'type' => 'div',
                            'class' =>'row',
                            'content' => [
                                [ 'type' => 'card','class'=>'card bg-success text-white','content'  => ['header' => 'Product Complaint','body' => $Product_Complaint ] ],
                                [ 'type' => 'card','class'=>'card bg-success text-white','content'  => ['header' => 'Resolved Product Complaint','body' => $Resolved_Product_Complaint ] ],
                                [ 'type' => 'card','class'=>'card bg-success text-white','content'  => ['header' => 'Resolved Service Complaint','body' =>$Resolved_Service_Complaint] ],
                            ]
                           ]);
                           Widget::add([
                            'type' => 'div',
                            'class' =>'row',
                            'content' => [
                                [ 'type' => 'card','class'=>'card bg-success text-white','content'  => ['header' => 'Service Complaint','body' =>  $Service_Complaint ] ],
                                [ 'type' => 'card','class'=>'card bg-success text-white','content'  => ['header' => 'Unresolved Product Complaint','body' => $Unresolved_Product_Complaint ] ],
                                [ 'type' => 'card','class'=>'card bg-success text-white','content'  => ['header' => 'Unresolved Service Complaint','body' =>$Unresolved_Service_Complaint] ],
                            ]
                           ]);
                           Widget::add([
                            'type' => 'div',
                            'class' =>'row',
                            'content' => [
                                ['type' => 'chart','class' =>'Column', 'wrapper' => ['class'=> 'col-md-12'],'content' => [
                                    'header' => 'Stock Out'] ,'controller' => \App\Http\Controllers\Admin\Charts\CatalogChartController::class,],

                            ],
                            'default' => \Request::has($Machinesd)?\Request::has('title'):false,
                           ]);

                           Widget::add([
                            'type' => 'div',
                            'class' =>'row',
                            'content' => [
                                [ 'type' => 'card','class'=>'card bg-success text-white','content'  => ['header' => 'Machine Stock Out','body' =>  $Machinesd ] ],
                                [ 'type' => 'card','class'=>'card bg-success text-white','content'  => ['header' => 'Other Product Stock Out','body' => $Other_Product] ],
                            ]
                           ]);

                           Widget::add([
                            'type' => 'div',
                            'class' =>'row',
                            'content' => [
                                ['type' => 'chart','class' =>'Column','wrapper' => ['class'=> 'col-md-12' ],['header' => 'Machine Stock Out'],'content' => [
                                'header' => 'Evaluation OF Products'] ,'height' => 800,'controller' => \App\Http\Controllers\Admin\Charts\EvaluationForEveryProductChartController::class,],
                                //['type' => 'chart','class' =>'Column','wrapper' => ['class'=> 'col-md-12' ],['header' => 'Machine Stock Out'],'content' => [
                                //'header' => 'Stock Out For Every Product'] ,'height' => 800,'controller' => \App\Http\Controllers\Admin\Charts\StockOutForeveryProductChartController::class,],
                                ['type' => 'chart','class' =>'Column','wrapper' => ['class'=> 'col-md-6' ],['header' => 'Machine Stock Out'],'content' => [
                                'header' => 'Machine Stock Out '] ,'height' => 800,'controller' => \App\Http\Controllers\Admin\Charts\MachineStockOutForeveryMachineChartController::class,],
                                ['type' => 'chart','class' =>'Column','wrapper' => ['class' => 'col-6', 'style' => 'border-radius: 10px'],['header' => 'Machine Stock Out'],'content' => [
                                'header' => 'Other Product Stock Out '] ,'height' => 800,'controller' => \App\Http\Controllers\Admin\Charts\OtherStockOutForeveryNotMachineChartController::class,],
                               // ['type' => 'chart','class' =>'Column', 'wrapper' => ['class'=> 'col-md-4'] ,'controller' => \App\Http\Controllers\Admin\Charts\ProductComplaintChartController::class,],
                               // ['type' => 'chart','class' =>'Column', 'wrapper' => ['class'=> 'col-md-4'] ,'controller' => \App\Http\Controllers\Admin\Charts\ServiceComplaintChartController::class,],
                            ]
                           ]);



                   $machine_value_left_length=count($machine_value_left);
                    for($y=0;$y<$machine_value_left_length;$y++){
                           Widget::add([
                            'type' => 'div',
                            'class' =>'row',
                            'content' => [
                                [ 'type' => 'card','class'=>'card bg-success text-white','content'  => ['header' => $machine_label_left[$y].' Stock_Out','body' => $machine_value_left[$y]] ],

                            ]
                           ]);
                       }


                    $other_left_length=count($other_value_left);
                    for($y=0;$y<$other_left_length;$y++){
                        Widget::add([
                            'type' => 'div',
                            'class' =>'row',
                            'content' => [
                                [ 'type' => 'card','class'=>'card bg-success text-white','content'  => ['header' => $other_label_left[$y].' Stock_Out','body' => $other_value_left[$y]] ],

                            ]
                           ]);
                        }

                        $evalution_left_length=count($evaluation_value_left);
                        for($y=0;$y<$evalution_left_length;$y++){
                            Widget::add([
                                'type' => 'div',
                                'class' =>'column',
                                'content' => [
                                    [ 'type' => 'card','class'=>'card bg-success text-white','wrapper' => ['class'=> 'col-md-3' ],'content'  => ['header' => $evaluation_label_left[$y].' Evaluation','body' => $evaluation_value_left[$y]] ],
                                ]
                               ]);
                            }
                        });

        }

        /**
         * Define what happens when the List operation is loaded.
         *
         * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
         * @return void
         */
        protected function setupListOperation()
        {
            // $this->crud->addButtonFromView('top', 'all_com', 'all_com', 'begining');
            // $this->crud->addButtonFromView('top', 'complaint', 'complaint', 'begining');
            // $this->crud->addButtonFromView('top', 'evaluation', 'evaluation', 'begining');
            // $this->crud->addButtonFromView('top', 'price', 'price', 'begining');
            // $this->crud->addButtonFromView('top', 'outofstock', 'outofstock', 'begining');
            // $this->crud->addButtonFromView('top', 'outoflist', 'outoflist', 'begining');
            // $this->crud->addButtonFromView('top', 'sells', 'sells', 'begining');


        //     $this->crud->addColumn([
        //       'label' => 'Communication',
        //       'type' => 'select',
        //       'name' => 'communication_types_id',
        //       'type' => 'select_from_array',
        //       'options' => [
        //                     'Out Of Stock' => 'Out Of Stock',
        //                     'Out Of List' => 'Out Of List',
        //                     'Complaint' => 'Complaint',
        //                     'Price' => 'Price',
        //                     'Evaluation' => 'Evaluation',
        //                   ],

        //   ]);
                  //   $this->crud->addColumn([
            //     'label' => 'Case Number',
            //     'type' => 'text',
            //     'name' => 'id',
            // ]);

          $this->crud->addColumn([
            'label' => 'Lead Name',
            'type' => 'select',
            'name' => "person_id",
            'entity' => 'person',
            'model' => 'App\Models\person',
            'wrapper'   => [
                'class' => 'form-group col-md-12',
                'font-weight' => 'bold'
                ]
        ]);
                  $this->crud->addColumn([
                    'label' => 'Company',
                    'type' => 'select',
                    'name' => 'personcompany_id',
                    'attribute' =>'company_name',
                    'entity' => 'person',
                    'model' => 'App\Models\person',
            ]);


        //   $this->crud->addColumn([
        //       'type' => 'text',
        //       'label' => "Landline",
        //       'name' => 'personphone_id',
        //       'attribute' =>'Landline',
        //       'entity' => 'person',
        //       'model' => 'App\Models\person',
        //   ]);
          $this->crud->addColumn([
            'name' => 'personemail_id',
            'type' => 'select',
            'label' => "Mobile",
            'entity' => 'person',
            'attribute' =>'mobile_number',
            'model' => 'App\Models\person',
            'wrapper'   => [
                'class' => 'form-group col-md-12'
            ]
          ]);
          $this->crud->addColumn([
              'name' => 'personsource_id',
              'type' => 'select',
              'label' => "lead Source",
              'entity' => 'person',
              'attribute' =>'source',
              'model' => 'App\Models\person',
              'wrapper'   => [
                  'class' => 'form-group col-md-12'
              ]
              ]);
          $this->crud->addColumn([
              'label' => 'Lead Owner',
              'type' => 'select',
              'name' => 'user_id',
              'attribute' =>'name',
              'entity' => 'user',
              'model' => 'App\Models\user',
          ]);
          $this->crud->addColumn([
            'name' => 'person_id',
            'type' => 'select',
            'label' => "Email",
            'entity' => 'person',
            'attribute' =>'created_at',
            'model' => 'App\Models\person',
            'wrapper'   => [
                'class' => 'form-group col-md-12'
            ]
          ]);



            // $this->crud->addColumn([
            //     'label' => 'Communicated_By',
            //     'type' => 'select',
            //     'name' => 'user_id',
            //     'attribute' =>'name',
            //     'entity' => 'user',
            //     'model' => 'App\Models\user',

            // ]);
            //     $this->crud->addColumn([
            //         'label' => 'Company',
            //         'type' => 'select',
            //         'name' => 'person_id',
            //         'attribute' =>'company_name',
            //         'entity' => 'person',
            //         'model' => 'App\Models\person',

            // ]);
            // $this->crud->addColumn([
            //     'label' => 'Type',
            //     'type' => 'select',
            //     'name' => 'type',
            //     'attribute' =>'type',
            //     'entity' => 'person',
            //     'model' => 'App\Models\person',
            //  ]);
        //     $this->crud->addColumn([
        //         'label' => 'Communication',
        //         'type' => 'select_from_array',
        //         'name' => 'communication_ways_id',
        //         'allows_null' => true,
        //         'options' => [
        //             'Phone' => 'Phone',
        //             'Telegram' => 'Telegram',
        //             'Physical' => 'Physical',
        //             'E-Mail' => 'E-Mail',
        //             'Facebook' => 'Facebook',
        //           ],

        // ]);
        // $this->crud->addColumn([
        //     'label' => 'Product',
        //     'type' => 'text',
        //     'name' => 'product',

        // ]);
        //     $this->crud->addColumn([
        //         'label' => 'Quantity',
        //         'type' => 'number',
        //         'name' => 'quantity',

        // ]);
        // $this->crud->addColumn([
        //     'label' => 'Second',
        //     'type' => 'time',
        //     'name' => 'second',

        // ]);

        }

        /**
         * Define what happens when the Create operation is loaded.
         *
         * @see https://backpackforlaravel.com/docs/crud-operation-create
         * @return void
         */
        protected function setupCreateOperation()
        {
            CRUD::setValidation(CommunicationRequest::class);
            $this->crud->setCreateContentClass('col-md-12');
            // $this->crud->addField([
            //     'label' => 'Case Number',
            //     'type' => 'text',
            //     'name' => 'code',
            //     'wrapper'   => [
            //     'class' => 'form-group col-md-6'
            // ]
            // ]);
            $this->crud->addField([
                'label' => 'Owner',
                'type' => 'select',
                'name' => 'user_id',
                'attribute' =>'name',
                'entity' => 'user',
                'model' => 'App\Models\user',
              'wrapper'   => [
                'class' => 'form-group col-md-6'
             ]
            ]);
                $this->crud->addField([

                    'label' => 'Company',
                    'type' => 'hidden',
                    'name' => 'person_id',
                    'attribute' =>'company_name',
                    'attributes' => [
                        'readonly'    => 'readonly',
                      ],
                    'default' => request()->input('person_id', ''),

            ]);
            $this->crud->addField([
                'label' => 'Type',
                'type' => 'select',
                'name' => 'communication_types_id',
                'type' => 'select_from_array',
                'options' => [
                              'Out Of Stock' => 'Out Of Stock',
                              'Out Of List' => 'Out Of List',
                              'Complaint' => 'Complaint',
                              'Price' => 'Price',
                              'Evaluation' => 'Evaluation',
                            ],
                'allows_null' => true,
                'wrapper'   => [
                'class' => 'form-group col-md-6'
            ]
            ]);
            $this->crud->addField([
                'label' => 'Communication',
                'type' => 'select_from_array',
                'name' => 'communication_ways_id',
                'allows_null' => true,
                'options' => [
                    'Phone' => 'Phone',
                    'Telegram' => 'Telegram',
                    'Physical' => 'Physical',
                    'E-Mail' => 'E-Mail',
                    'Facebook' => 'Facebook',
                  ],
                'wrapper'   => [
                'class' => 'form-group col-md-6'
            ]
        ]);
        $this->crud->addField([
            'label' => 'All Day(If Complaint)',
            'type' => 'radio',
            'name' => 'comp_type',
            'options' => [
                0 => "product",
                1 => "Service",
            ],
            'wrapper'   => [
            'class' => 'form-group col-md-6'
        ]
        ]);
        $this->crud->addField([
            'label' => 'Product',
            'type' => 'text',
            'name' => 'product',
            'wrapper'   => [
            'class' => 'form-group col-md-6'
        ]
        ]);
            $this->crud->addField([
                'label' => 'Quantity',
                'type' => 'number',
                'name' => 'quantity',
                'wrapper'   => [
                    'class' => 'form-group col-md-6'
                ]
        ]);
        $this->crud->addField([
            'label' => 'Second',
            'type' => 'number',
            'name' => 'second',
            'wrapper'   => [
                'class' => 'form-group col-md-6'
            ]
        ]);
        $this->crud->addField([
            'label' => 'Remarks',
            'type' => 'textarea',
            'name' => 'remarks',
            'wrapper'   => [
                'class' => 'form-group col-md-12'
            ]
        ]);

        }

        /**
         * Define what happens when the Update operation is loaded.
         *
         * @see https://backpackforlaravel.com/docs/crud-operation-update
         * @return void
         */
        protected function setupUpdateOperation()
        {
            $this->crud->setUpdateContentClass('col-md-12');
            $this->setupCreateOperation();


        }

    protected function setupShowOperation()
    {
         $this->crud->setShowContentClass('col-md-12');
        //  $this->crud->addButtonFromView('top', 'see_detail', 'see_detail', 'beginning');
        $this->crud->set('show.setFromDb', false);
         $this->crud->addColumn([
             'label' => 'Owner',
             'type' => 'select',
             'name' => 'user_id',
             'attribute' =>'name',
             'entity' => 'user',
             'model' => 'App\Models\user',

         ]);
             $this->crud->addColumn([
                 'label' => 'Company',
                 'type' => 'select',
                 'name' => 'person_id',
                 'attribute' =>'company_name',
                 'entity' => 'person',
                 'model' => 'App\Models\person',

         ]);
         $this->crud->addColumn([
             'label' => 'Type',
             'type' => 'select',
             'name' => 'communication_types_id',
             'type' => 'select_from_array',
             'options' => [
                           'Out Of Stock' => 'Out Of Stock',
                           'Out Of List' => 'Out Of List',
                           'Complaint' => 'Complaint',
                           'Price' => 'Price',
                           'Evaluation' => 'Evaluation',
                         ],

         ]);
         $this->crud->addColumn([
             'label' => 'Communication',
             'type' => 'select_from_array',
             'name' => 'communication_ways_id',
             'allows_null' => true,
             'options' => [
                 'Phone' => 'Phone',
                 'Telegram' => 'Telegram',
                 'Physical' => 'Physical',
                 'E-Mail' => 'E-Mail',
                 'Facebook' => 'Facebook',
               ],

     ]);
     $this->crud->addColumn([
        'label' => 'Procut/Service',
        'type' => 'text',
        'name' => 'comp_type',

]);
     $this->crud->addColumn([
         'label' => 'Product',
         'type' => 'select',
         'name' => 'product_name',
         'attributes' => 'product_name',
         'entity' => 'product',
                 'model' => 'App\Models\product',

     ]);
         $this->crud->addColumn([
             'label' => 'Quantity',
             'type' => 'number',
             'name' => 'quantity',

     ]);
     $this->crud->addColumn([
         'label' => 'Second',
         'type' => 'time',
         'name' => 'second',

     ]);
     $this->crud->addColumn([
         'label' => 'Remarks',
         'type' => 'textarea',
         'name' => 'remarks',

     ]);

    }
}
