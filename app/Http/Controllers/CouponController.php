<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class CouponController extends Controller
{
    // Hiển thị danh sách mã giảm giá
    public function all_coupon()
    {
        $all_coupons = Coupon::paginate(3); // Sử dụng model
        return view('AdminPages.Pages.Coupon.all_coupon', compact('all_coupons'));
    
    }

    // Hiển thị form thêm mã giảm giá
    public function add_coupon()
    {
        return view('AdminPages.Pages.Coupon.add_coupon');
    }

    // Xử lý lưu mã giảm giá vào cơ sở dữ liệu
    public function save_coupon(Request $request)
    {
        // Kiểm tra và validate dữ liệu
        $request->validate([
            'coupon_name' => 'required|string|max:255',
            'coupon_code' => 'required|string|max:50|unique:tbl_coupon,coupon_code',
            'coupon_condition' => 'required|in:0,1', 
            'coupon_number' => 'required|numeric',
            'coupon_time' => 'required|numeric',
            'coupon_start_date' => 'nullable|date',
            'coupon_end_date' => 'nullable|date',
        ]);

        // Tạo và lưu mã giảm giá
        $coupon = new Coupon();
        $coupon->coupon_name = $request->coupon_name;
        $coupon->coupon_code = $request->coupon_code;
        $coupon->coupon_condition = $request->coupon_condition;
        $coupon->coupon_number = $request->coupon_number;
        $coupon->coupon_time = $request->coupon_time;
        $coupon->coupon_start_date = $request->coupon_start_date;
        $coupon->coupon_end_date = $request->coupon_end_date;
        $coupon->save();

        // Quay lại trang tạo mã giảm giá với thông báo thành công
        return redirect()->route('all.coupon')->with('message', 'Mã giảm giá đã được thêm thành công!');
    }

     // Hàm để hiển thị form cập nhật mã giảm giá
     public function edit_coupon($coupon_id)
     {
         $coupon = Coupon::find($coupon_id);
 
         // Nếu ngày bắt đầu hoặc kết thúc là NULL, mặc định sẽ hiển thị rỗng
         if ($coupon->coupon_start_date) {
             $coupon->coupon_start_date = date('Y-m-d', strtotime($coupon->coupon_start_date));
         } else {
             $coupon->coupon_start_date = null;
         }
 
         if ($coupon->coupon_end_date) {
             $coupon->coupon_end_date = date('Y-m-d', strtotime($coupon->coupon_end_date));
         } else {
             $coupon->coupon_end_date = null;
         }
 
         return view('AdminPages.Pages.Coupon.edit_coupon', compact('coupon'));
     }
 
     // Hàm để cập nhật mã giảm giá
     public function update_coupon(Request $request, $id)
    {
        // Validate dữ liệu đầu vào
        $request->validate([
            'coupon_name' => 'required|string|max:255',
            'coupon_code' => 'required|string|max:255',
            'coupon_condition' => 'required|integer|in:0,1',
            'coupon_number' => 'required|numeric',
            'coupon_time' => 'required|numeric',
            'coupon_start_date' => 'required|date',
            'coupon_end_date' => 'required|date|after_or_equal:coupon_start_date',
        ]);

        // Lấy coupon từ cơ sở dữ liệu
        $coupon = Coupon::find($id);
        
        if (!$coupon) {
            return redirect()->route('coupon.index')->with('error', 'Mã giảm giá không tồn tại!');
        }

        // Cập nhật thông tin coupon
        $coupon->coupon_name = $request->input('coupon_name');
        $coupon->coupon_code = $request->input('coupon_code');
        $coupon->coupon_condition = $request->input('coupon_condition'); 
        $coupon->coupon_number = $request->input('coupon_number'); 
        $coupon->coupon_time = $request->input('coupon_time');
        $coupon->coupon_start_date = $request->input('coupon_start_date');
        $coupon->coupon_end_date = $request->input('coupon_end_date');

        // Lưu thay đổi vào cơ sở dữ liệu
        $coupon->save();

        // Trả về trang với thông báo thành công
        return redirect()->route('all.coupon')->with('message', 'Cập nhật mã giảm giá thành công!');
    }
     

    // Xóa mã giảm giá
    public function delete_coupon($coupon_id)
    {
        // Lấy thông tin coupon từ cơ sở dữ liệu
        $coupon = Coupon::findOrFail($coupon_id); // Nếu không tìm thấy sẽ trả về lỗi 404
        
        // Xóa coupon
        $coupon->delete();

        // Thông báo xóa thành công và quay lại danh sách
        Session::put('message', 'Xóa mã giảm giá thành công!');
        return redirect()->route('admin.coupons.index');
    }
}
