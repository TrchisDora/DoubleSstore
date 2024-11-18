@extends('AdminPages.Pages.Product.all_product')

@section('product_list')
    @csrf
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Liệt kê sản phẩm
            </div>
            <table class="table table-striped b-t b-light">
                <thead>
                    <tr>   
                        <th>Tên sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Slug</th>
                        <th>Giá</th>
                        <th>Hình sản phẩm</th>
                        <th>Danh mục</th>
                        <th>Thương hiệu</th>
                        <th>Hiển thị</th>
                        <th>Nổi bật</th>
                        <th style="width:30px;"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($filtered_products as $pro)
                    <tr>
                        <td>{{ $pro->product_name }}</td>
                        <td>{{ $pro->product_quantity }}</td>
                        <td>{{ $pro->product_slug }}</td>
                        <td>{{ number_format($pro->product_price, 0, ',', '.') }}đ</td>
                        <td><img src="{{ asset('public/fontend/images/product/'.$pro->product_image) }}" height="115" width="125"></td>
                        <td>{{ $pro->categoryProduct ? $pro->categoryProduct->category_name : 'Không có danh mục' }}</td>
                        <td>{{ $pro->brandProduct ? $pro->brandProduct->brand_name : 'Không có thương hiệu' }}</td>
                        <td>
                            <span class="text-ellipsis">
                                @if($pro->product_status == 0)
                                    <a href="{{ URL::to('/active-product/'.$pro->product_id) }}">
                                        <span class="fa-thumb-styling fa fa-thumbs-down"></span>
                                    </a>
                                @else
                                    <a href="{{ URL::to('/unactive-product/'.$pro->product_id) }}">
                                        <span class="fa-thumb-styling fa fa-thumbs-up"></span>
                                    </a>
                                @endif
                            </span>
                        </td>
                        <td>
                            <span class="text-ellipsis">
                                @if($pro->product_prominent == 0)
                                    <a href="{{ URL::to('/active-prominent-product/'.$pro->product_id) }}">
                                        <span class="fa fa-star-o"></span>
                                    </a>
                                @else
                                    <a href="{{ URL::to('/unactive-prominent-product/'.$pro->product_id) }}">
                                        <span class="fa fa-star"></span>
                                    </a>
                                @endif
                            </span>
                        </td>
                        <td>
                            <a href="{{ URL::to('/edit-product/'.$pro->product_id) }}" class="active styling-edit" ui-toggle-class="">
                                <i class="fa fa-pencil-square-o text-success text-active"></i>
                            </a>
                            <a onclick="return confirm('Bạn có chắc là muốn xóa sản phẩm này không?')" href="{{ URL::to('/delete-product/'.$pro->product_id) }}" class="active styling-edit" ui-toggle-class="">
                                <i class="fa fa-times text-danger text"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>      
@endsection
