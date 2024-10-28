@extends('AdminPages.admin')
@section('admin_content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Liệt kê danh mục sản phẩm
            </div>

            <div class="table-responsive">
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

                <table class="table table-striped b-t b-light">
                    <thead>
                        <tr>
                            <th style="width:20px;">
                                <label class="i-checks m-b-none">
                                    <input type="checkbox"><i></i>
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
                        @foreach($all_category_product as $key => $cate_pro)
                            <tr>
                                <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
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
@endsection
