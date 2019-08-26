<?php namespace App\Http\Controllers\backend;
use App\Http\Requests\{AddCategoryRequest,EditCategoryRequest};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\category;
class categoryController extends Controller {
    function getCategory() {
        $data['categories']=category::all()->toArray();
        return view('backend.category.category',$data);
    }

    function postCategory(AddCategoryRequest $r) {
        $categories=category::all()->toArray();
        
        if(getLevel($categories,$r->idParent,1)>2)
        {
            return redirect('admin/category')
            ->withErrors(['name'=>'Xin lỗi web không hỗ trợ danh mục lớn hơn 2 cấp!']);
        }

        $cate=new category;
        $cate->name=$r->name;
        $cate->slug=str_slug($r->name);
        $cate->parent=$r->idParent;
        $cate->save();
        return redirect()->back()->with('thongbao','Đã thêm thành công');
    }


    function getEditCategory($idCate) {
        $data['categories']=category::all()->toArray();
        $data['category']=category::find($idCate);
        return view('backend.category.editcategory',$data);
    }

    function postEditCategory(EditCategoryRequest $r,$idCate) {
        $cate=category::find($idCate);
        $cate->name=$r->name;
        $cate->slug=str_slug($r->name);
        $cate->parent=$r->idParent;
        $cate->save();
        return redirect()->back()->with('thongbao','Đã Sửa thành công');
        
    }

    function delCate($idCate)
    {
        category::destroy($idCate);
        return redirect()->back()->with('thongbao','Đã xoá thành công');
    }
}
