<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Admin;
use App\Models\Customer; 
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{
    public function showForgotPasswordForm()
    {
        return view('auth.passwords.forgot_password');
    }

    public function sendResetLink(Request $request)
    {
        // Xác thực email
        $request->validate([
            'email' => 'required|email',
        ], [
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không hợp lệ.',
        ]);

        // Xóa token cũ nếu có
        PasswordReset::where('email', $request->email)->delete();

        // Tạo token mới
        $token = Str::random(60);

        // Lưu token vào bảng password_resets
        PasswordReset::create([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now(),
        ]);

        // Gửi email reset mật khẩu
        Mail::send('auth.emails.reset_password', ['token' => $token, 'email' => $request->email], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Yêu cầu đặt lại mật khẩu');
        });

        return redirect()->back()->with('success', 'Link đặt lại mật khẩu đã được gửi đến email của bạn.');
    }

    public function showResetForm(Request $request, $token)
    {
        // Lấy email từ request
        $email = $request->input('email'); 

        // Kiểm tra xem email có tồn tại trong bảng password_resets không
        $resetRecordExists = PasswordReset::where('email', $email)->exists();

        if ($resetRecordExists) {
            // Nếu email tồn tại trong bảng password_resets, hiển thị form reset mật khẩu
            return view('auth.passwords.reset_password', ['token' => $token]);
        } else {
            return redirect()->route('login')->with('error', 'Mật khẩu đã thay đổi!');
        }
    }

    public function resetPassword(Request $request)
    {
        // Xác nhận dữ liệu đầu vào
        $request->validate([
            'email' => 'required|email|exists:password_resets,email',
            'password' => 'required|min:6|confirmed', 
            'token' => 'required',
        ], [
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không hợp lệ.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp.',
        ]);

        // Kiểm tra token có hợp lệ và chưa hết hạn
        $passwordReset = PasswordReset::where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$passwordReset || Carbon::now()->diffInMinutes($passwordReset->created_at) > 60) {
            return redirect()->back()->with('error', 'Link đặt lại mật khẩu đã hết hạn.');
        }

        // Kiểm tra xem email là của customer hay admin
        $admin = Admin::where('admin_email', $request->email)->first();
        $customer = Customer::where('customer_email', $request->email)->first(); // Thay admin_email thành customer_email

        if ($admin) {
            // Nếu là admin, cập nhật mật khẩu admin
            $admin->admin_password = md5($request->password); // Mã hóa mật khẩu mới sử dụng md5
            $admin->save();
        } elseif ($customer) { // Nếu là khách hàng
            if (is_null($customer->email_verified_at)) { 
                $customer->email_verified_at = Carbon::now();  // Cập nhật thời gian email đã xác minh
            }
            $customer->customer_password = md5($request->password); // Mã hóa mật khẩu mới
            $customer->save();
        } else {
            return redirect()->back()->with('error', 'Email không tồn tại.');
        }

        // Xóa token sau khi đã reset mật khẩu thành công
        PasswordReset::where('email', $request->email)->delete();

        return redirect()->route('login')->with('success', 'Mật khẩu đã được đặt lại thành công.');
    }
}
