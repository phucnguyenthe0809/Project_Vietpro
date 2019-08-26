<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\{product,category};
class indexController extends Controller
{
   
    function getIndex() {  
        $data['prd_new']=product::orderBy('id','desc')->take(8)->get();
    $data['prd_nb']=product::where('featured',1)->take(4)->get();
     return view('frontend.index',$data);
     }

    function getContact() {  
        return view('frontend.contact');
      }

    function getAbout() { 
        return view('frontend.about');  
    }

    function GetPrdCate($slug_cate)
    {
       $data['products']=category::where('slug',$slug_cate)->first()->product()->paginate(6);
       $data['categorys']=category::all();
       return view('frontend.product.shop',$data);
    
    }
    
    function GetFilter(request $r)
    {
        $data['products']=product::whereBetween('price', [$r->start, $r->end])->paginate(6);
        $data['categorys']=category::all();
        return view('frontend.product.shop',$data);
    }
}
