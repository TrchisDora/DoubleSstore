@extends('layout')
@section('content')

<section id="cart_items">
    <div class="">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="{{URL::to('/')}}">Trang chủ</a></li>
                <li class="active">Giỏ hàng của bạn</li>
            </ol>
        </div>
        <div class="table-responsive cart_info">
            <?php
            $content = Cart::content();
            ?>
            <table class="table table-condensed">
                <thead>
                    <tr class="cart_menu">
                        <td class="image">Sản phẩm</td>
                        <td class="description">Mô tả</td>
                        <td class="price">Giá</td>
                        <td class="quantity">Số lượng</td>
                        <td class="total">Tổng tiền</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($content as $v_content)
                    <tr>
                        <td class="cart_product">
                            <a href=""><img src="{{URL::to('public/fontend/images/product/'.$v_content->options->image)}}" height="50px" alt=""></a>
                        </td>
                        <td class="cart_description">
                            <h4><a href="">{{$v_content->name}}</a></h4>
                            <p>web id: 2100328</p>
                        </td>
                        <td class="cart_price">
                            <p>{{number_format($v_content->price)}}</p>
                        </td>
                        <td class="cart_quantity">
                            <div class="cart_quantity_button">
                                <form action="{{URL::to('/update-cart-quantity')}}" method="POST">
                                    {{csrf_field()}}
                                <input class="cart_quantity_input" type="text" name="cart_quantity" value="{{$v_content->qty}}" >
                                <input type="hidden" name="rowId_cart" value="{{$v_content->rowId}}" class="form-control">
                                <input type="submit" name="update_qty" value="Cập nhật" class="btn btn-default btn-sm">
                                </form>
                            </div>
                        </td>
                        <td class="cart_total">
                            <p class="cart_total_price">
                                <?php
                                $subtotal = $v_content->price * $v_content->qty;
                                echo number_format($subtotal).' '.'vnđ';
                                ?>
                            </p>
                        </td>
                        <td class="cart_delete">
                            <a class="cart_quantity_delete" href="{{URL::to('/delete-to-cart/'.$v_content->rowId)}}"><i class="fa fa-times"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
<section id="do_action">
    <div class="container">
        
        <div class="row">
            
            </div>
            <div class="col-sm-6">
                <div class="total_area">
                    <ul>
                        <li>Tổng <span>{{ Cart::priceTotal(0) }} vnđ</span></li>
                        <li>Thuế <span>{{ Cart::tax(0) }} vnđ</span></li>
                        <li>Phí vận chuyển <span>Free</span></li>
                        <li>Thành tiền <span>{{Cart::total(0).'vnđ'}}</span></li>
                    </ul>
                    <?php
						$customer_id = Session::get('customer_id');
						if($customer_id!=NULL){

						?>
							
                            <a class="btn btn-default check_out" href="{{URL::to('/checkout')}}">Thanh toán</a>
						<?php
						}else{
						?>
							<a class="btn btn-default check_out" href="{{URL::to('/login-checkout')}}">Thanh toán</a>
						<?php
						}
						?>
                    
                </div>
            </div>
        </div>
    </div>
</section>

@endsection