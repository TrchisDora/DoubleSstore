<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Session;

class AdminController extends Controller
{
    public function login()
    {
        return view('AdminPages.login');  
    }

    public function admin(Request $request)
    {
        $admin_email = $request->input('admin_email');
        $admin_password = $request->input('admin_password');

        $admin = Admin::where('admin_email', $admin_email)->first();

        if ($admin) {
            if ($admin->admin_password === md5($admin_password)) {
                $request->session()->put('admin_id', $admin->admin_id);
                $request->session()->put('admin_name', $admin->admin_name);
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('admin.login')->with('error', 'Mật khẩu không chính xác.');
            }
        } else {
            return redirect()->route('admin.login')->with('error', 'Email không tồn tại.');
        }
    }

    public function dashboard()
    {
        return view('AdminPages.Pages.dashboard');
    }

    public function logout(Request $request)
    {
        $request->session()->forget(['admin_id', 'admin_name']);
        return redirect()->route('admin.login');
    }
}
