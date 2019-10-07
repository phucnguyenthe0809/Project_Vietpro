@extends('frontend.master.master')
@section('title','Thanh Toán')
@section('content')
<!-- main -->
<div class="colorlib-shop">
        <div class="container">
            <div class="row row-pb-md">
                <div class="col-md-10 col-md-offset-1">
                    <div class="process-wrap">
                        <div class="process text-center active">
                            <p><span>01</span></p>
                            <h3>Giỏ hàng</h3>
                        </div>
                        <div class="process text-center active">
                            <p><span>02</span></p>
                            <h3>Thanh toán</h3>
                        </div>
                        <div class="process text-center">
                            <p><span>03</span></p>
                            <h3>Hoàn tất thanh toán</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-7">
                        <form method="post" class="colorlib-form">
                            @csrf
                        <h2>Chi tiết thanh toán</h2>
                        <div class="row">
                                <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="fname">Họ & Tên</label>
                                            <input type="text" name="full" id="full" class="form-control" placeholder="Full Name">
                                            {!! showError($errors,"full") !!}
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="fname">Địa chỉ</label>
                                            <input type="text" name="address" id="address" class="form-control"
                                                placeholder="Nhập địa chỉ của bạn">
                                        </div>
                                    </div>
    
                                    <div class="form-group">
                                        <div class="col-md-6">
                                            <label for="email">Địa chỉ email</label>
                                            <input type="email" name="email" id="email" class="form-control"
                                                placeholder="Ex: youremail@domain.com">
                                                {!! showError($errors,"email") !!}
                                        </div>
                                        <div class="col-md-6">
                                            <label for="Phone">Số điện thoại</label>
                                            <input type="text" name="phone" id="phone" class="form-control"
                                                placeholder="Ex: 0123456789">
                                                {!! showError($errors,"phone") !!}
                                        </div>
                                    </div>
                            <div class="form-group">
                                <div class="col-md-12">

                                </div>
                            </div>
                        </div>
                
                </div>
                <div class="col-md-5">
                    <div class="cart-detail">
                        <h2>Tổng Giỏ hàng</h2>
                        <ul>
                            <li>

                                <ul>
                                    @foreach ($cart as $row)
                                    <li><span>{{ $row->qty }} x {{ $row->name }}</span> <span>{{ number_format($row->qty*$row->price,0,"",".") }} đ </span></li>
                                    @endforeach
                                    
                                
                                </ul>
                            </li>

                            <li><span>Tổng tiền đơn hàng</span> <span>{{ $total }}₫</span></li>
                        </ul>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                                <p><button type="submit" class="btn btn-primary">Thanh toán</button></p>
                                <p onclick="upGHTK()" style="width: 100%;border: none;height: 40px; background-color:green; color:white">GIAO HÀNG TIẾT KIỆM</p>
                        </div>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
    <!-- end main -->
@endsection
@section('script')
@parent
<script>
    
    function upGHTK() {
        //lấy thông tin
        let full=$('#full').val();
        let address=$('#address').val();
        let email=$('#email').val();
        let phone=$('#phone').val();
       
        $.get('/cart/all',function(data){
            let products=[];

            for (let key in data) {
               let item={
                    "name":data[key].name+'-'+data[key].id,
                    "weight":0.1,
                    "quantity":data[key].qty
                }
                products.push(item);
                
            }
        
            let dataSend={
                            "products": products,
                            "order": {
                                "id": "#1",
                                "pick_name": "NGUYỄN THẾ PHÚC",
                                "pick_address": "Số 5 Ngõ 113  TEST DEV",
                                "pick_province": "TP. HÀ NỘI",
                                "pick_district": "Hoàng Cầu",
                                "pick_tel": "0356642214",
                                "tel": phone,
                                "name": full,
                                "address": address,
                                "province": address,
                                "district": address,
                                "is_freeship": "1",
                                "pick_date": "2016-09-30",
                                "pick_money": 10000,
                                "note": "Khối lượng tính cước tối đa: 1.00 kg",
                                "value": 10000,
                                "transport": "road"
                            }
                        };
                        //Gửi đơn hàng qua API GIAO HÀNG TIET KIEM
            
                        $.ajax({
                            url: 'https://phucnguyenthe0809-eval-test.apigee.net/giao-hang-tiet-kiem',
                            headers: {
                                'Token': '69ce06E2Ae039e3EaFda0c4E5c97ed77114291ad',
                                'Content-Type':'application/json'
                            },
                            method: 'POST',
                            data: dataSend,
                            success: function(data){
                                console.log(data);
                                
                            }
                        });
            
        });
      
    }
   
</script>
@stop