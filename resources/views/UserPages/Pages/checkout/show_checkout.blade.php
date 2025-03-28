@extends('layout')
@section('content')

<section id="cart_items">
		<div class="">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="{{URL::to('/')}}">Trang chủ</a></li>
                    <li class="active">Thanh toán giỏ hàng</li>
                </ol>
            </div>

			<div class="register-req">
				<p>Vui lòng đăng ký hoặc đăng nhập tài khoản để thanh toán</p>
			</div><!--/register-req-->

			<div class="shopper-informations">
				<div class="row">
					<div class="col-sm-10 clearfix">
						<div class="bill-to">
							<p>Điền thông tin gửi hàng</p>
							<div class="form-one">
								<form action="{{URL::to('/save-checkout-customer')}}" method="POST">
                                    {{ csrf_field() }}
									<input type="text" name="shipping_email" placeholder="Email">
									<input type="text" name="shipping_name" placeholder="Họ và Tên">
									<input type="text" name="shipping_address" placeholder="Địa chỉ">
									<input type="text" name="shipping_phone" placeholder="SĐT">
									<input type="text" name="shipping_method" placeholder="1">
									<textarea name="shipping_notes"  placeholder="thêm ghi chú của bạn về đơn hàng" rows="16"></textarea>
									<input type="submit" name="send_order" value="Gửi" class="btn btn-primary btn-sm">
								</form>
							</div>
						</div>
					</div>
								
				</div>
			</div>
			<div class="review-payment">
				<h2>Xem lại giỏ hàng</h2>
			</div>

			<!-- <div class="payment-options">
					<span>
						<label><input type="checkbox"> Direct Bank Transfer</label>
					</span>
					<span>
						<label><input type="checkbox"> Check Payment</label>
					</span>
					<span>
						<label><input type="checkbox"> Paypal</label>
					</span>
				</div>
			</div> -->
	</section> <!--/#cart_items-->

@endsection