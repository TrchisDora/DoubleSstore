<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Admin;
use App\Models\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register.registration');
    }

    public function register(Request $request)
{
    // Validate dữ liệu đầu vào
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => [
            'required',
            'email',
            function ($attribute, $value, $fail) {
                $customerExists = Customer::where('customer_email', $value)->exists();
                $adminExists = Admin::where('admin_email', $value)->exists();
                if ($customerExists || $adminExists) {
                    $fail('Email này đã tồn tại trong hệ thống.');
                }
            },
        ],
        'phone' => 'nullable|digits_between:10,15', // Số điện thoại không bắt buộc
    ], [
        'name.required' => 'Tên là bắt buộc.',
        'email.required' => 'Email là bắt buộc.',
        'email.email' => 'Email phải hợp lệ.',
        'phone.digits_between' => 'Số điện thoại phải từ 10 đến 15 ký tự.',
    ]);

    // Tạo mật khẩu ngẫu nhiên và mã hóa
    $randomPassword = Str::random(8);
    $hashedPassword = Hash::make($randomPassword);

    // Tạo tài khoản mới
    $customerData = [
        'customer_name' => $request->name,
        'customer_email' => $request->email,
        'customer_password' => $hashedPassword,
        'email_verified_at' => null,
        'created_at' => now(),
        'updated_at' => now(),
    ];

    // Thêm số điện thoại nếu có
    if ($request->filled('phone')) {
        $customerData['customer_phone'] = $request->phone;
    }

    // Lưu vào cơ sở dữ liệu
    $customer = Customer::create($customerData);

    // Gửi email xác nhận
    $token = Str::random(60);
    PasswordReset::create([
        'email' => $request->email,
        'token' => $token,
        'created_at' => Carbon::now(),
    ]);
    Mail::send('auth.emails.verify_email', ['token' => $token, 'password' => $randomPassword, 'email' => $request->email], function ($message) use ($customer) {
        $message->to($customer->customer_email);
        $message->subject('Xác nhận đăng ký');
    });

    return back()->with('success', 'Đăng ký thành công. Vui lòng kiểm tra email để xác nhận.');
}


    // Xác nhận email
    public function verifyEmail($token)
    {
        // Tìm khách hàng có token xác nhận tương ứng
        $customer = Customer::where('remember_token', $token)->first();

        if ($customer) {
            // Cập nhật thời gian xác nhận email
            $customer->email_verified_at = now(); // Cập nhật thời gian xác nhận
            $customer->remember_token = null; // Xóa token sau khi xác nhận
            $customer->save();

            // Chuyển hướng người dùng đến trang đăng nhập với thông báo thành công
            return redirect()->route('login')->with('success', 'Xác nhận email thành công.');
        }

        // Trường hợp token không hợp lệ hoặc hết hạn
        return back()->with('error', 'Token không hợp lệ hoặc đã hết hạn.');
    }
}
