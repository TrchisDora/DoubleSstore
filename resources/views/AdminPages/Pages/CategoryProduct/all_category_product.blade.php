@extends('AdminPages.admin')
@section('admin_content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Liệt kê danh mục sản phẩm
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
                            @php Session::forget('message'); @endphp
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
                <table class="table table-striped b-t b-light">
                    <thead>
                        <tr>
                            <th style="width:20px;">
                                <label class="i-checks m-b-none">
                                    <input type="checkbox" id="select-all"><i></i>
                                </label>
                            </th>
                            <th>Tên danh mục</th>
                            <th>Slug</th>
                            <th>Hình ảnh loại User</th>
                            <th>Hình ảnh loại Admin</th>
                            <th>Hiển thị</th>
                            <th style="width:30px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <form action="{{ route('admin.category.bulk_action') }}" method="POST">
                        @csrf
                        @foreach($all_category_product as $key => $cate_pro)
                            <tr>
                                <td><input type="checkbox" name="category_ids[]" value="{{ $cate_pro->category_id}}"></td>
                                <td>{{ $cate_pro->category_name }}</td>
                                <td>{{ $cate_pro->slug_category_product }}</td>
                                <td><img src="{{ asset('public/fontend/images/icons/'.$cate_pro->category_icon_user) }}" alt="User Icon" style="width: 50px; height: auto;"></td>
                                <td><img src="{{ asset('public/backend/images/icons/'.$cate_pro->category_icon_admin) }}" alt="Admin Icon" style="width: 50px; height: auto;"></td>
                                <td>
                                    <span class="text-ellipsis">
                                        @if($cate_pro->category_status == 0)
                                            <a href="{{ URL::to('/active-category-product/'.$cate_pro->category_id) }}">
                                                <span class="fa-thumb-styling fa fa-thumbs-down"></span>
                                            </a>
                                        @else
                                            <a href="{{ URL::to('/unactive-category-product/' . $cate_pro->category_id) }}">
                                                <span class="fa-thumb-styling fa fa-thumbs-up"></span>
                                            </a>
                                        @endif
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ URL::to('/edit-category-product/' . $cate_pro->category_id) }}" class="active styling-edit">
                                        <i class="fa fa-pencil-square-o text-success text-active"></i>
                                    </a>
                                    <a onclick="return confirm('Bạn có chắc là muốn xóa danh mục này không?')" href="{{ URL::to('/delete-category-product/' . $cate_pro->category_id) }}" class="active styling-edit">
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
                                    <option value="3">Xuất dữ liệu các mục</option>
                                </select>
                                <button type="submit" id="applyFilter" class="btn btn-sm btn-default">Apply</button>
                            </div>    
                        </form>
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <footer class="panel-footer">
                <div class="row">
                    <div class="col-sm-5 text-center">
                        <small class="text-muted inline m-t-sm m-b-sm">showing {{ $all_category_product->firstItem() }}-{{ $all_category_product->lastItem() }} of {{ $all_category_product->total() }} items</small>
                    </div>
                    <div class="col-sm-7 text-right text-center-xs">
                        <ul class="pagination pagination-sm m-t-none m-b-none">
                            @if ($all_category_product->onFirstPage())
                                <li class="page-item disabled"><span class="page-link">Quay lại</span></li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $all_category_product->previousPageUrl() }}">Quay lại</a>
                                </li>
                            @endif
                            @foreach ($all_category_product->getUrlRange(1, $all_category_product->lastPage()) as $page => $url)
                                <li class="page-item {{ $page == $all_category_product->currentPage() ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endforeach
                            @if ($all_category_product->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $all_category_product->nextPageUrl() }}">Trang kế</a>
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
    document.getElementById('select-all').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('input[name="category_ids[]"]');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });
    </script>
@endsection
