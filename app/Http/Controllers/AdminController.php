<?php

namespace App\Http\Controllers;

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
    $email = $request->input('email');
    $password = $request->input('password');

    // Kiểm tra thông tin đăng nhập
    $result = DB::table('tbl_admin')
                ->where('email', $email)
                ->first();

    if ($result) {555
        // Kiểm tra mật khẩu (nếu không mã hóa mật khẩu)
        if ($result->password === md5($password)) {
            // Đăng nhập thành công, lưu thông tin vào session
            $request->session()->put('admin_id', $result->id);
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
    }
}
