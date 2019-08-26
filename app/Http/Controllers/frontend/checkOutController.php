<?php 
namespace App\Http\Controllers\frontend;
use App\Http\Requests\CheckOutRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\{order,product_order};
use Cart;
class checkOutController extends Controller {
    function getCheckOut() {
        $data['cart']=Cart::content();
        $data['total']=Cart::total(0,"",".");
         return view('frontend.checkout.checkout',$data);

    }

    function postCheckOut(CheckOutRequest $r) {
        $order=new order;
        $order->full=$r->full;
        $order->address=$r->address;
        $order->email=$r->email;
        $order->phone=$r->phone;
        $order->total=Cart::total(0,"","");
        $order->state=2;
        $order->save();
        
        foreach(Cart::content() as $row)
        {
           $prd=new product_order;
           $prd->code=$row->id;
           $prd->name=$row->name;
           $prd->price=round($row->price,0);
           $prd->quantity=$row->qty;
           $prd->img=$row->options->img;
           $prd->order_id=$order->id;
           $prd->save();
   
        }
        //Xoá Toàn Bộ Giỏ Hàng
        Cart::destroy();
        return redirect('checkout/complete/'.$order->id);
    }

    function getComplete($order_id) {
        $data['order']=order::find($order_id);
        return view('frontend.checkout.complete',$data);
    }
}
