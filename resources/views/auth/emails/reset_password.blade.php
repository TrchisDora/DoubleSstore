<!DOCTYPE html>
<html>
<head>
    <title>Đặt lại mật khẩu</title>
</head>
<body>
    <h2>Yêu cầu đặt lại mật khẩu</h2>
    <p>Nhấn vào link dưới đây để đặt lại mật khẩu của bạn:</p>
    <a href="{{ url('reset-password/'.$token.'?email='.$email) }}">Đặt lại mật khẩu</a>
    <p>Nếu bạn không yêu cầu đặt lại mật khẩu, vui lòng bỏ qua email này.</p>
</body>
</html>
