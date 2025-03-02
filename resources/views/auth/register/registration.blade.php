<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký tài khoản</title>
    <link rel="stylesheet" href="{{ asset('public/backend/css/bootstrap.min.css') }}">
    <link href="{{ asset('public/backend/css/style.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('public/backend/css/style-responsive.css') }}" rel="stylesheet">
    <script src="{{ asset('public/backend/js/jquery2.0.3.min.js') }}"></script>
</head>
<body>
<div class="log-w3">
    <div class="w3layouts-main">
        <h2>Đăng ký tài khoản</h2>
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
        <form action="{{ route('register.account') }}" method="post">
            @csrf
            <input type="text" class="ggg" name="name" placeholder="Nhập tên của bạn" required>
            <input type="email" class="ggg" name="email" placeholder="Nhập email của bạn" required>
            <h6><a href="{{URL::to('/login')}}">Quay lại đăng nhập</a></h6>
            <div class="clearfix"></div>
            <input type="submit" value="Đăng ký">
        </form>
        
    </div>
</div>

<script src="{{ asset('public/backend/js/bootstrap.js') }}"></script>
</body>
</html>
