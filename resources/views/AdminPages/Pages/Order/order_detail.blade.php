@extends('AdminPages.admin')

@section('admin_content')
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="container mt-5">
            <div class="order-header text-center mb-4"style="margin-top: 50px;">
                <img alt="" src="{{ asset('public/backend/images/logos/logo_icon.png') }}" height="150" width="150" >
                <h2 class="display-4 font-weight-bold">GREEN STORE</h1>
                <h4 class="h3 text-muted">CHI TIẾT ĐƠN HÀNG</h2>
            </div>
            <div class="customer-info mb-4 border p-4 rounded shadow-sm bg-light">
                @if($order->customer)
                    <div><strong>Họ và tên:</strong> <span style="text-transform: capitalize;">{{ $order->customer->customer_name }}</span></div>
                    <div><strong>Email:</strong> <span style="text-transform: lowercase;">{{ $order->customer->customer_email }}</span></div>
                    <div><strong>Số điện thoại:</strong> <span>{{ $order->customer->customer_phone }}</span></div>
                    <div><strong>Địa chỉ:</strong> <span style="text-transform: capitalize;">{{ $order->customer->customer_address ?? 'Chưa có thông tin' }}</span></div>
                @else
                    <p>Không có thông tin khách hàng.</p>
                @endif
            </div>

            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Mã sản phẩm</th>
                        <th>Sản phẩm</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Hình ảnh</th>
                        <th>Tổng</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->orderDetails as $product)
                        <tr>
                            <td>{{ $product->product_id }}</td>
                            <td>{{ $product->product_name }}</td>
                            <td>{{ number_format($product->product_price, 0, ',', '.') }}đ</td>
                            <td>{{ $product->product_sales_quantity }}</td>
                            <td>
                                @if ($product->product)
                                    <img src="{{ asset('public/fontend/images/product/' . $product->product->product_image) }}" height="50" width="50" alt="{{ $product->product_name }}">
                                @else
                                    <img src="{{ asset('public/fontend/images/product/default.png') }}" height="50" width="50" alt="Hình ảnh không có">
                                @endif
                            </td>
                            <td>{{ number_format($product->product_price * $product->product_sales_quantity, 0, ',', '.')}}đ</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="payment-method" style="text-align: right;">
                <h4 class="font-weight-bold">Phương thức thanh toán: Thanh toán khi nhận hàng</h4>
            </div>
            <div class="total-price d-flex justify-content-between align-items-center mt-3">
            <div>
                <h4 class="font-weight-bold">Tổng hóa đơn: {{ number_format($order->total_amount, 0, ',', '.') }}₫</h4>
                <div style="margin: 10px 0; font-style: italic; color: #333;">
                    <em>(Tổng hóa đơn không bao gồm phí vận chuyển)</em>
                </div>
            </div>
            
            <div class="order-footer mt-5 pt-4 text-center bg-light border-top">
                <div class="panel panel-default">
                    <div class="footer-content mb-3">
                        <h4>Green Store cam kết chịu trách nhiệm từ việc lập đơn, đóng gói đến vận chuyển hàng hóa.</h5>
                        <p class="text-muted">
                            Liên hệ qua số điện thoại: <strong>0788781116</strong> hoặc địa chỉ: 
                            <strong>12 Lương Định Của, TP. Cần Thơ.</strong>
                        </p>
                    </div>
                    <div>
                        <small class="text-muted">&copy; {{ date('Y') }} Green Store. All Rights Reserved.</small>
                    </div>
                </div>
            </div>
        </div>
       
</div>
@endsection
