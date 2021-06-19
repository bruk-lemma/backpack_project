<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Myitem;
class EchartController extends Controller
{
    public function echart(Request $request)
    {
    	$fruit = Myitem::where('product_type','fruit')->get();
    	$veg = Myitem::where('product_type','vegitable')->get();
    	$grains = Myitem::where('product_type','grains')->get();
    	$fruit_count = count($fruit);
    	$veg_count = count($veg);
    	$grains_count = count($grains);
    	return view('echart',compact('fruit_count','veg_count','grains_count'));
    }
}
