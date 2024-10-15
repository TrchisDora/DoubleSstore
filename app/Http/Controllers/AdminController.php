<?php

namespace App\Http\Controllers;
use Session;
use Illuminate\Http\Request;
use DB;

class AdminController extends Controller
{
    // Hiển thị trang đăng nhập
    public function login()
    {
        return view('AdminPages.login');  
    }
    // Xử lý đăng nhập
    public function admin(Request $request)
    {
        // Lấy email và password từ form đăng nhập
        $admin_email = $request->input('admin_email');
        $admin_password = $request->input('admin_password');

        // Kiểm tra thông tin đăng nhập
        $result = DB::table('tbl_admin')
                    ->where('admin_email', $admin_email)
                    ->first();

        if ($result) {
            // Kiểm tra mật khẩu (nếu không mã hóa mật khẩu)
            if ($result->admin_password === md5($admin_password)) {
                // Đăng nhập thành công, lưu thông tin vào session
                $request->session()->put('admin_id', $result->admin_id);
                $request->session()->put('admin_name', $result->admin_name);
                // Chuyển hướng đến trang dashboard
                return redirect()->route('admin.dashboard');
            } else {
                // Mật khẩu không đúng
                return redirect()->route('login')->with('error', 'Mật khẩu không chính xác.');
            }
        } else {
            // Không tìm thấy email
            return redirect()->route('login')->with('error', 'Email không tồn tại.');
        }
    }
    // Hiển thị trang dashboard sau khi đăng nhập thành công
    public function dashboard()
    {
        // Kiểm tra session hoặc middleware bảo mật nếu cần
        return view('AdminPages.Pages.dashboard');
        //abc
    }
    public function logout(){
        $request->session()->put('admin_id', null);
        $request->session()->put('admin_name', null);
        return redirect()->route('admin.login');
    }
}
