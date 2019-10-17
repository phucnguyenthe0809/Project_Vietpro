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
    function callAPI($method, $url, $data){
        $curl = curl_init();
     
        switch ($method){
           case "POST":
              curl_setopt($curl, CURLOPT_POST, 1);
              if ($data)
                 curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
              break;
           case "PUT":
              curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
              if ($data)
                 curl_setopt($curl, CURLOPT_POSTFIELDS, $data);			 					
              break;
           default:
              if ($data)
                 $url = sprintf("%s?%s", $url, http_build_query($data));
        }
     
        // OPTIONS:
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
           'Token: 69ce06E2Ae039e3EaFda0c4E5c97ed77114291ad',
           'Content-Type: application/json',
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
     
        // EXECUTE:
        $result = curl_exec($curl);
        if(!$result){die("Connection Failure");}
        curl_close($curl);
        return $result;
     }

    function postCheckOut(CheckOutRequest $r) {
        // $order=new order;
        // $order->full=$r->full;
        // $order->address=$r->address;
        // $order->email=$r->email;
        // $order->phone=$r->phone;
        // $order->total=Cart::total(0,"","");
        // $order->state=2;
        // $order->save();
        
        // foreach(Cart::content() as $row)
        // {
        //    $prd=new product_order;
        //    $prd->code=$row->id;
        //    $prd->name=$row->name;
        //    $prd->price=round($row->price,0);
        //    $prd->quantity=$row->qty;
        //    $prd->img=$row->options->img;
        //    $prd->order_id=$order->id;
        //    $prd->save();
   
        // }
        // //Xoá Toàn Bộ Giỏ Hàng
        // Cart::destroy();
        // return redirect('checkout/complete/'.$order->id);
        //Giao hàng tiết kiệm
            $products=[];
        foreach(Cart::content() as $row)
        {
           $products[]=[
               'name'=>$row->name.'-'.$row->id,
               'weight'=>0.1,
               'quantity'=>(int)$row->qty
           ];
       
        }
       $order=[
            "id"=> "A36",
            "pick_name"=> "NGUYỄN THẾ PHÚC",
            "pick_address"=> "Số 5 Ngõ 113  TEST DEV",
            "pick_province"=> "TP. HÀ NỘI",
            "pick_district"=> "Hoàng Cầu",
            "pick_tel"=> "0356642214",
            "tel"=> "0911222333",
            "name"=> "GHTK - HCM - Noi Thanh",
            "address"=> "123 nguyễn chí thanh",
            "province"=> "TP. Hồ Chí Minh",
            "district"=> "Quận 1",
            "is_freeship"=> "1",
            "pick_date"=> "2019-09-30",
            "pick_money"=> 10000,
            "note"=> "Khối lượng tính cước tối đa: 1.00 kg",
            "value"=> 10000,
            "transport"=> "road"
       ];
        
        $data=[
            "products"=>$products,
            "order"=> $order
            ];
   
            $make_call = $this->callAPI('POST', 'https://services.giaohangtietkiem.vn/services/shipment/order/?ver=1.5', json_encode($data));
            $response = json_decode($make_call, true);
            dd($response);
    }

    function getComplete($order_id) {
        $data['order']=order::find($order_id);
        return view('frontend.checkout.complete',$data);
    }
}
