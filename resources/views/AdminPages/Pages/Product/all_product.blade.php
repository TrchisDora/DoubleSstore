@extends('AdminPages.admin')

@section('admin_content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Liệt kê sản phẩm
            </div>
            @if (session('message'))
                <script>
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: '{{ session('message') }}',
                        showConfirmButton: false,
                        timer: 2500
                    }).then(() => {
                        @php
                            Session::forget('message');
                        @endphp
                    });
                </script>
                @elseif (session('error'))
                <script>
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: '{{ session('error') }}',
                        showConfirmButton: false,
                        timer: 2500
                    });
                </script>
            @endif
                <div class="row w3-res-tb">
                    <div class="col-sm-6 m-b-xs" style="">
                                <form method="GET" action="{{ route('admin.products.index') }}">
                                        <select class="input-sm form-control w-sm inline v-middle" name="category_id" onchange="this.form.submit()">
                                                <option value="0">Tất cả danh mục</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->category_id }}" {{ request('category_id') == $category->category_id ? 'selected' : '' }}>
                                                        {{ $category->category_name }}
                                                </option>
                                                @endforeach
                                        </select>
                                        <select class="input-sm form-control w-sm inline v-middle" name="brand_id" onchange="this.form.submit()">
                                                <option value="0">Tất cả thương hiệu</option>
                                                @foreach($brands as $brand)
                                                    <option value="{{ $brand->brand_id }}" {{ request('brand_id') == $brand->brand_id ? 'selected' : '' }}>
                                                        {{ $brand->brand_name }}
                                                </option>
                                                @endforeach
                                        </select>
                                        <select class="input-sm form-control w-sm inline v-middle" name="product_status" onchange="this.form.submit()">
                                                <option value="">Tất cả sản phẩm</option>
                                                <option value="0" {{ request('product_status') == '0' ? 'selected' : '' }}>Sản phẩm đang ẩn</option>
                                                <option value="1" {{ request('product_status') == '1' ? 'selected' : '' }}>Sản phẩm đang hiển thị</option>
                                        </select>
                                        <select class="input-sm form-control w-sm inline v-middle" name="product_prominent" onchange="this.form.submit()">
                                                <option value="">Tất cả sản phẩm</option>
                                                <option value="1" {{ request('product_prominent') == '1' ? 'selected' : '' }}>Sản phẩm nổi bật</option>
                                                <option value="0" {{ request('product_prominent') == '0' ? 'selected' : '' }}>Sản phẩm không nổi bật</option>
                                                
                                    </select>
                            </form>
                        </div>
                    <div class="col-sm-3"></div>
                    <div class="col-sm-3">
                        <form method="GET" action="{{ route('admin.products.index') }}" style="display: inline; flex-grow: 1;">
                            <div class="input-group">
                                <input type="text" name="search" class="input-sm form-control" placeholder="Search" value="{{ request('search') }}">
                                <span class="input-group-btn">
                                    <button class="btn btn-sm btn-default" type="submit">Go!</button>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="table-responsive">
<<<<<<< HEAD
                <form action="{{ route('admin.products.bulk_action') }}" method="POST">
                 @csrf
                 <table class="table table-striped b-t b-light">
                    <thead>
                        <tr>
                            <th style="width:20px;">
                                <label class="i-checks m-b-none">
                                    <input type="checkbox" id="select-all"><i></i>
                                </label>
                            </th>
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
                        <form action="{{ route('admin.products.bulk_action') }}" method="POST">
                            @csrf
                            @foreach($all_product as $key => $pro)
                            <tr>
                                <td>
                                    <input type="checkbox" name="product_ids[]" value="{{ $pro->product_id }}">
                                </td>
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
                            <div class="col-sm-3 m-b-xs">
                                <select name="bulk_action" class="input-sm form-control w-sm inline v-middle">
                                    <option value="0">Chọn hành động</option>
                                    <option value="1">Xóa các mục</option>
                                    <option value="2">Hiện/Ẩn các mục</option>
                                    <option value="3">Un/Nổi Bật các mục</option>
                                    <option value="4">Xuất dữ liệu các mục</option>
                                </select>
                                <button type="submit" id="applyFilter" class="btn btn-sm btn-default">Apply</button>
                            </div>    
                        </form>
                    </tbody>
                </table>

                </form> 
            </div>           
=======
                    <form action="{{ route('admin.products.bulk_action') }}" method="POST" id="bulkActionForm">
                        @csrf
                        <table class="table table-striped b-t b-light">
                            <thead>
                                <tr>
                                    <th style="width:20px;">
                                        <label class="i-checks m-b-none">
                                            <input type="checkbox" id="select-all"><i></i>
                                        </label>
                                    </th>
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
                                @foreach($all_product as $key => $pro)
                                <tr>
                                    <td>
                                        <input type="checkbox" name="product_ids[]" value="{{ $pro->product_id }}">
                                    </td>
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
                                <div class="col-sm-3 m-b-xs">
                                    <select name="bulk_action" id="bulkActionSelect" class="input-sm form-control w-sm inline v-middle">
                                        <option value="0">Chọn hành động</option>
                                        <option value="1">Xóa các mục</option>
                                        <option value="2">Hiện/Ẩn các mục</option>
                                        <option value="3">Un/Nổi Bật các mục</option>
                                        <option value="4">Xuất dữ liệu các mục</option>
                                    </select>
                                    <button type="button" id="applyFilter" class="btn btn-sm btn-default" onclick="confirmBulkAction()">Apply</button>
                                </div>
                            </tbody>
                        </table>
                    </form>
                </div>           
>>>>>>> d97843cdb195b8e1c481d724187343e9507331a5
            <footer class="panel-footer">
                <div class="row">
                    <div class="col-sm-5 text-center">
                        <small class="text-muted inline m-t-sm m-b-sm">showing {{ $all_product->firstItem() }} - {{ $all_product->lastItem() }} of {{ $all_product->total() }} items</small>
                    </div>
                    <div class="col-sm-7 text-right text-center-xs">                
                    <ul class="pagination pagination-sm m-t-none m-b-none">
                        @if ($all_product->onFirstPage())
                            <li class="page-item disabled"><span class="page-link">Quay lại</span></li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $all_product->previousPageUrl() }}">Quay lại</a>
                            </li>
                        @endif
                        @foreach ($all_product->getUrlRange(1, $all_product->lastPage()) as $page => $url)
                            <li class="page-item {{ $page == $all_product->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endforeach
                        @if ($all_product->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $all_product->nextPageUrl() }}">Trang kế</a>
                            </li>
                        @else
                            <li class="page-item disabled"><span class="page-link">Trang kế</span></li>
                        @endif
                    </ul>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script>
<<<<<<< HEAD
    document.getElementById('select-all').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('input[name="product_ids[]"]');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });
    </script>
    @yield('product_list')
=======
    function confirmBulkAction() {
        const bulkAction = document.getElementById('bulkActionSelect').value;

        if (bulkAction === "1") { // Check if "Delete Selected" is chosen
            Swal.fire({
                title: 'Xác nhận',
                text: 'Bạn có chắc chắn muốn xóa các mục đã chọn không?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Có',
                cancelButtonText: 'Không'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('bulkActionForm').submit(); // Submit form if confirmed
                }
            });
        } else {
            document.getElementById('bulkActionForm').submit(); // Directly submit for other actions
        }
    }

    // Select/Deselect All functionality
    document.getElementById('select-all').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('input[name="product_ids[]"]');
        checkboxes.forEach((checkbox) => {
            checkbox.checked = this.checked;
        });
    });
</script>
>>>>>>> d97843cdb195b8e1c481d724187343e9507331a5
@endsection
