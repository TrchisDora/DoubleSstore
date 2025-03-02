<!DOCTYPE html>
<html>
<head>
    <title>Xác nhận đăng ký</title>
</head>
<body>
    <h2>Chào bạn,</h2>
    <p>Chúng tôi đã nhận được yêu cầu đăng ký tài khoản. Dưới đây là thông tin tài khoản của bạn:</p>
    <p><strong>Email:</strong> {{ $email }}</p>
    <p><strong>Mật khẩu:</strong> {{ $password }}</p>
    <p>Vui lòng nhấn vào liên kết dưới đây để xác nhận đăng ký tài khoản của bạn:</p>
    <a href="{{ url('reset-password/'.$token.'?email='.$email) }}">Xác nhận đăng ký</a>
    <p>Nếu bạn không yêu cầu đăng ký, vui lòng bỏ qua email này. Lưu ý: Hệ thống sẽ xóa tài khoản không xác nhận trong 3 ngày! </p>
</body>
</html>
