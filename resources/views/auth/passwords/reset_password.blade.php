<!DOCTYPE html>
<html>
<head>
    <title>Đặt lại mật khẩu</title>
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
        <h2>Đặt lại mật khẩu</h2>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
        <form action="{{ route('reset.password') }}" method="post">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">
    <!-- Add email as a hidden field -->
    <input type="hidden" name="email" value="{{ request()->email }}">

    <input type="password" class="ggg" name="password" placeholder="Nhập mật khẩu mới" required>
    <input type="password" class="ggg" name="password_confirmation" placeholder="Xác nhận mật khẩu mới" required>
    <div class="clearfix"></div>
    <input type="submit" value="Đặt lại mật khẩu">
</form>

        <p>Bạn đã nhớ mật khẩu? <a href="{{URL::to('/login')}}">Đăng nhập</a></p>
    </div>
</div>

<script src="{{ asset('public/backend/js/bootstrap.js') }}"></script>
</body>
</html>
