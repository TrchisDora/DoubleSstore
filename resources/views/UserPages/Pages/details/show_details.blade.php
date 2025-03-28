@extends('layout')
@section('content')
@foreach($details_product as $key => $value)

    <div class="product-details">
        <div class="col-sm-5">
            <div class="view-product">
                <img src="{{URL::to('/public/ReDoub/images/products/'.$value->product_image)}}" alt="" />
                <h3>ZOOM</h3>
            </div>
            <!-- <div id="similar-product" class="carousel slide" data-ride="carousel">
                
                <div class="carousel-inner">
                    <div class="item active">
                        <a href="#"><img src="{{ URL::to('/public/fontend/images/product/'.$value->product_image) }}" alt=""></a>
                        <a href="#"><img src="{{ URL::to('/public/fontend/images/product-details/similar2.jpg') }}" alt=""></a>
                        <a href="#"><img src="{{ URL::to('/public/fontend/images/product-details/similar3.jpg') }}" alt=""></a>
                    </div>
                    
                </div>
                
                <a class="left item-control" href="#similar-product" data-slide="prev">
                    <i class="fa fa-angle-left"></i>
                </a>
                <a class="right item-control" href="#similar-product" data-slide="next">
                    <i class="fa fa-angle-right"></i>
                </a>
            </div> -->
        </div>
        <div class="col-sm-7">
            <div class="product-information"><!--product_information-->
                <img src="images/product-details/new.jpg" class="newarrival" alt="" />
                <h2>{{$value->product_name}}</h2>
                <p>ID: {{$value->product_id}}</p>
                <img src="images/product-details/rating.png" alt="" />
                <form action="{{URL::to('/save-cart')}}" method="POST">
                    {{ csrf_field() }}
                <span>
                    <span>{{number_format($value->product_price).'VNĐ'}}</span>
                    <label>Số lượng:</label>
                    <input name="qty" type="number" min="1" value="1" />
                    <input name="productid_hidden" type="hidden" value="{{$value->product_id}}" />
                    <button type="submit" class="btn btn-default cart">
                        <i class="fa fa-shopping-cart"></i>
                        Thêm giỏ hàng
                    </button>
                </span>
                </form>
                <p><b>Tình trạng:</b> Còn hàng</p>
                <p><b>Điều kiện:</b> Mới 100%</p>
                <p><b>Thương hiệu:</b> {{ $value->brand->brand_name ?? 'Không xác định' }}</p>
                <p><b>Danh mục:</b> {{ $value->category->category_name }}</p>
                </p>
                <a href="#"><img src="images/product-details/share.png" class="share img-responsive" alt="" /></a>
            </div><!--/product-information-->
        </div>
    </div>

    <div class="category-tab shop-details-tab"><!--category-tab-->
        <div class="col-sm-12">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#details" data-toggle="tab">Mô tả</a></li>
                <li><a href="#companyprofile" data-toggle="tab">Chi tiết sản phẩm</a></li>               
                <li><a href="#reviews" data-toggle="tab">Đánh giá</a></li>
            </ul>
        </div>
    <div class="tab-content">
        <div class="tab-pane fade active in" id="details">
            <p>{!!$value->product_desc!!}</p>
        </div>

        <div class="tab-pane fade" id="companyprofile">
            <p>{!!$value->product_content!!}</p>

        </div>

        <div class="tab-pane fade" id="reviews">
            <div class="col-sm-12">
                <ul>
                    <li><a href=""><i class="fa fa-user">1</i></a></li>
                    <li><a href=""><i class="fa fa-clock-o">1</i></a></li>
                    <li><a href=""><i class="fa fa-calendar-o">1</i></a></li>
                </ul>
                <p>Nhân mời bạn cho reviews về sản phẩm của chúng tôi</p>
                <p><b>Write your reviews</b></p>
                <form action="#">
                    <span>
                        <input type="text" placeholder="Your name">
                        <input type="email" placeholder="Email Address">
                    </span>
                    <textarea name="" id=""></textarea>
                    <b>rating: </b> <img src="" alt="">
                    <button type="button" class="btn btn-default pull-right">
                        Submit
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
    <div class="recommended_items">
        <h2 class="title text-center">Sản phẩm liên quan</h2>
        <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="item active">
                @foreach($related_product->slice(0, 3) as $key => $lienquan)
                    <div class="col-sm-4">
                        <div class="product-image-wrapper">
                        <div class="single-products">
                            <div class="productinfo text-center">
                                <img src="{{URL::to('public/ReDoub/images/products/'.$lienquan->product_image)}}" alt="" />
                                <h2>{{number_format($lienquan->product_price).' '.'VND'}}</h2>
                                <p>{{$lienquan->product_name}}</p>
                                <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm giỏ hàng</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                <!-- <div>
                <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
                    <i class="fa fa-angle-left"></i>
                </a>
                <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
                    <i class="fa fa-angle-right"></i>
                </a>
                </div> -->
@endsection
