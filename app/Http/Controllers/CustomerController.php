<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    // Hiển thị danh sách khách hàng
    public function all()
    {
        $all_customer = Customer::paginate(10); // Lấy danh sách khách hàng với phân trang
        return view('AdminPages.Pages.Users.all_customer', compact('all_customer'));
    }

    

    // Cập nhật thông tin khách hàng
    public function update(Request $request, $id)
    {
        // Tìm khách hàng theo ID
        $customer = Customer::findOrFail($id);

        // Xác thực dữ liệu từ form
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:15',
        ]);

        // Cập nhật dữ liệu khách hàng
        $customer->customer_name = $request->input('customer_name');
        $customer->customer_email = $request->input('customer_email');
        $customer->customer_phone = $request->input('customer_phone');
        $customer->save();

        // Chuyển hướng về trang danh sách khách hàng với thông báo thành công
        return redirect()->route('all.customer')->with('success', 'Cập nhật khách hàng thành công!');
    }
}
