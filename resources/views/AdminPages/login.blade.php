<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="{{ asset('public/backend/css/bootstrap.min.css') }}">
    <link href="{{ asset('public/backend/css/style.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('public/backend/css/style-responsive.css') }}" rel="stylesheet">
    <script src="{{ asset('public/backend/js/jquery2.0.3.min.js') }}"></script>
</head>
<body>
<div class="log-w3">
    <div class="w3layouts-main">
        <h2>ĐĂNG NHẬP NGAY!</h2>
        
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
    

        <form action="{{ route('admin.login') }}" method="post">
            @csrf  <!-- Tạo mã CSRF bảo vệ -->
            <input type="text" class="ggg" name="admin_email" placeholder="Điền email" required="">
            <input type="password" class="ggg" name="admin_password" placeholder="Điền mật khẩu" required="">
            <span><input type="checkbox" /> Lưu lại tài khoản</span>
            <h6><a href="#">Quên mật khẩu?</a></h6>
            <div class="clearfix"></div>
            <input type="submit" value="Đăng nhập" name="login">
        </form>
        <p>Bạn chưa có tài khoản? <a href="registration.html">Tạo tài khoản</a></p>
    </div>
</div>

<script src="{{ asset('public/backend/js/bootstrap.js') }}"></script>
</body>
</html>