<?php namespace App\Http\Controllers\backend;
use App\Http\Requests\{addProductRequest,EditProductRequest};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\{product,category};
class productController extends Controller {

    function getListProduct() {
        $data['products']=product::paginate(4);
        return view('backend.product.listproduct',$data);
    }

    function getAddProduct() {
      $data['categories']=category::all()->toarray();
        return view('backend.product.addproduct',$data);
    }

    function postAddProduct(addProductRequest $r) {
        $prd=new product;
        $prd->code=$r->code;
        $prd->name=$r->name;
        $prd->slug=str_slug($r->name);
        $prd->price=$r->price;
        $prd->featured=$r->featured;
        $prd->state=$r->state;
        $prd->info=$r->info;
        $prd->describe=$r->describe;
        if($r->hasFile('img'))
        {
         
            $file=$r->img;
            $file_name=str_slug($r->name).'.'.$file->getClientOriginalExtension();
            $file->move('backend/img',$file_name);
            $prd->img=$file_name;
        }
        else
        {
            $prd->img='no-img.jpg';
        }

        $prd->category_id=$r->category;
        $prd->save();
        return redirect('admin/product')->with('thongbao','Đã Thêm Sản phẩm thành Cồng');
    }

    function getEditProduct($idPrd) {
        $data['product']=product::find($idPrd);
        $data['categories']=category::all()->toarray();
        return view("backend.product.editproduct",$data);
    }

    function postEditProduct(EditProductRequest $r,$idPrd) {
        $prd=product::find($idPrd);
        $prd->code=$r->code;
        $prd->name=$r->name;
        $prd->slug=str_slug($r->name);
        $prd->price=$r->price;
        $prd->featured=$r->featured;
        $prd->state=$r->state;
        $prd->info=$r->info;
        $prd->describe=$r->describe;
        if($r->hasFile('img'))
        {
            if($prd->img!='no-img.jpg')
            {
                unlink('backend/img/'.$prd->img);
            }
           
            $file=$r->img;
            $file_name=str_slug($r->name).'.'.$file->getClientOriginalExtension();
            $file->move('backend/img',$file_name);
            $prd->img=$file_name;
        }

        $prd->category_id=$r->category;
        $prd->save();
      return redirect()->back()->with('thongbao','Đã sửa Thành Công!');
    }
    function delProduct($idPrd)
    {
      product::destroy($idPrd);
      return redirect('admin/product')->with('thongbao',"Đã xoá thành công");
    } 
}
