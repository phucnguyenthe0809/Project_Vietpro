<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\carbon;
use App\models\order;
class indexController extends Controller
{
    function getIndex() {  
        $month_now=carbon::now()->format('m');
        $year_now=carbon::now()->format('Y');
        for ($i=1; $i <= $month_now; $i++) { 
         $dl['Tháng '.$i]=order::where('state',1)->whereMonth('updated_at',$i)->whereYear('updated_at',$year_now)->sum('total');
        }
        $data['dl']=$dl;
        $data['so_dh']=order::where('state',2)->count();
        return view("backend.index",$data);
     }
}
