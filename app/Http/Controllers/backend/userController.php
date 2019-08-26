<?php namespace App\Http\Controllers\backend;
use App\Http\Requests\{AddUserRequest,EditUserRequest};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class userController extends Controller {
    function getUser() {
        $data['users']=User::paginate(5) ;
        return view('backend.user.listuser',$data);
    }

    function getAddUser() {
        return view('backend.user.adduser');
    }

    function postAddUser(AddUserRequest $r) {
    
        $user=new User;
        $user->email=$r->email;
        $user->password=$r->password;
        $user->full=$r->full;
        $user->address=$r->address;
        $user->phone=$r->phone;
        $user->level=$r->level;
        $user->save();
        return redirect('admin/user')
        ->with('thongbao','Đã Thêm Thành Công!');

    }

    function geteditUser($idUser) {
        $data['user']=User::find($idUser);
        return view('backend.user.edituser',$data);

    }

    function postEditUser(EditUserRequest $r,$idUser) {
        $user=User::find($idUser);
        $user->email=$r->email;
        $user->full=$r->full;
        $user->address=$r->address;
        $user->phone=$r->phone;
        $user->level=$r->level;
        $user->save();
        return redirect()->back()->with('thongbao','Đã Sửa thành công!');
    }
    function delUser($idUser)
    {
        User::destroy($idUser);
        return redirect()->back()->with('thongbao','Đã xoá thành viên!');
    }
}
