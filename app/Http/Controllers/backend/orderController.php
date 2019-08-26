<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\order;
class orderController extends Controller
{
    function getOrder() { 
      $data['orders']=order::where('state',2)->orderby('id','desc')->paginate(3);
      return view("backend.order.order",$data);
      }
    function getdetail($order_id) {  
      $data['order']=order::find($order_id);
      return view("backend.order.detailorder",$data);
      }
    function getProcessed() {  
      $data['orders']=order::where('state',1)->orderby('updated_at','desc')->paginate(3);
      return view("backend.order.processed",$data);
      }


  
      function paid($order_id)
      {
          $order=order::find($order_id);
          $order->state=1;
          $order->save();
          return redirect('admin/order/processed');
      }
}
