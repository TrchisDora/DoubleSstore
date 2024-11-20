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
    // Validate dữ liệu
    $data = $request->validate([
        'coupon_name' => 'required|max:255',
        'coupon_code' => 'required|unique:tbl_coupon',
        'coupon_condition' => 'required|integer', // 0: % giảm, 1: giá trị giảm
        'coupon_number' => 'required|numeric',
        'coupon_time' => 'required|integer', // Số ngày coupon có hiệu lực
        'coupon_start_date' => 'required|date', // Ngày bắt đầu
        'coupon_end_date' => 'required|date', // Ngày kết thúc
    ]);

    // Tạo mới coupon
    $coupon = new Coupon();
    $coupon->coupon_name = $data['coupon_name'];
    $coupon->coupon_code = $data['coupon_code'];
    $coupon->coupon_condition = $data['coupon_condition'];
    $coupon->coupon_number = $data['coupon_number'];
    $coupon->coupon_time = $data['coupon_time'];
    $coupon->coupon_start_date = $data['coupon_start_date'];
    $coupon->coupon_end_date = $data['coupon_end_date'];

    // Lưu vào cơ sở dữ liệu
    $coupon->save();

    // Thông báo và chuyển hướng
    Session::put('message', 'Thêm coupon thành công');
    return redirect()->route('all_coupon');
}

    // Hiển thị form chỉnh sửa mã giảm giá
    public function edit_coupon($coupon_id)
    {
        // Lấy thông tin coupon từ cơ sở dữ liệu
        $coupon = Coupon::findOrFail($coupon_id); // Nếu không tìm thấy sẽ trả về lỗi 404
        return view('AdminPages.Pages.Coupon.edit_coupon', compact('coupon'));
    }
    



public function update_coupon(Request $request, $coupon_id)
{
    // Lấy thông tin coupon từ cơ sở dữ liệu
    $coupon = Coupon::findOrFail($coupon_id); // Nếu không tìm thấy sẽ trả về lỗi 404

    // Validate dữ liệu
    $data = $request->validate([
        'coupon_name' => 'required|max:255',
        'coupon_code' => 'required|unique:tbl_coupon,coupon_code,' . $coupon_id . ',coupon_id',
        'coupon_condition' => 'required|integer',
        'coupon_number' => 'required|numeric',
        'coupon_time' => 'required|integer',
        'coupon_start_date' => 'required|date',
        'coupon_end_date' => 'required|date',
    ]);

    // Cập nhật các trường dữ liệu
    $coupon->update($data);

    // Thông báo cập nhật thành công và redirect về trang danh sách
    Session::put('message', 'Cập nhật mã giảm giá thành công!');
    return redirect()->route('admin.coupons.index');
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
