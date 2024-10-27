@extends('AdminPages.admin')

@section('admin_content')
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            Liệt kê thương hiệu sản phẩm
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
                        // Xóa session để tránh lặp lại thông báo
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
            <div class="col-sm-5 m-b-xs">
                <select class="input-sm form-control w-sm inline v-middle">
                    <option value="0">Bulk action</option>
                    <option value="1">Delete selected</option>
                    <option value="2">Bulk edit</option>
                    <option value="3">Export</option>
                </select>
                <button class="btn btn-sm btn-default">Apply</button>                
            </div>
            <div class="col-sm-4"></div>
            <div class="col-sm-3">
                <div class="input-group">
                    <input type="text" class="input-sm form-control" placeholder="Search">
                    <span class="input-group-btn">
                        <button class="btn btn-sm btn-default" type="button">Go!</button>
                    </span>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped b-t b-light">
                <thead>
                    <tr>
                        <th style="width:20px;">
                            <label class="i-checks m-b-none">
                                <input type="checkbox"><i></i>
                            </label>
                        </th>
                        <th>Tên thương hiệu</th>
                        <th>Brand Slug</th>
                        <th>Hiển thị</th>
                        <th style="width:30px;"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($all_brand_product as $key => $brand_pro)
                    <tr>
                        <td>
                            <label class="i-checks m-b-none">
                                <input type="checkbox" name="post[]"><i></i>
                            </label>
                        </td>
                        <td>{{ $brand_pro->brand_name }}</td>
                        <td>{{ $brand_pro->brand_slug }}</td>
                        <td>
                            <span class="text-ellipsis">
                                @if($brand_pro->brand_status==0)
                                    <a href="{{URL::to('/unactive-brand-product/'.$brand_pro->brand_id)}}">
                                        <span class="fa-thumb-styling fa fa-thumbs-up"></span>
                                    </a>
                                @else
                                    <a href="{{URL::to('/active-brand-product/'.$brand_pro->brand_id)}}">
                                        <span class="fa-thumb-styling fa fa-thumbs-down"></span>
                                    </a>
                                @endif
                            </span>
                        </td>
                        <td>
                            <a href="{{URL::to('/edit-brand-product/'.$brand_pro->brand_id)}}" class="active styling-edit" ui-toggle-class="">
                                <i class="fa fa-pencil-square-o text-success text-active"></i>
                            </a>
                            <a onclick="return confirm('Bạn có chắc là muốn xóa thương hiệu này không?')" href="{{URL::to('/delete-brand-product/'.$brand_pro->brand_id)}}" class="active styling-edit" ui-toggle-class="">
                                <i class="fa fa-times text-danger text"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <footer class="panel-footer">
            <div class="row">
                <div class="col-sm-5 text-center">
                    <small class="text-muted inline m-t-sm m-b-sm">Showing {{ $all_brand_product->firstItem() }} - {{ $all_brand_product->lastItem() }} of {{ $all_brand_product->total() }} items</small>
                </div>
                <div class="col-sm-7 text-right text-center-xs">                
                <ul class="pagination pagination-sm m-t-none m-b-none">
                    {{-- Nút Quay lại --}}
                    @if ($all_brand_product->onFirstPage())
                        <li class="page-item disabled"><span class="page-link">Quay lại</span></li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $all_brand_product->previousPageUrl() }}">Quay lại</a>
                        </li>
                    @endif

                    {{-- Hiển thị các số trang --}}
                    @foreach ($all_brand_product->getUrlRange(1, $all_brand_product->lastPage()) as $page => $url)
                        <li class="page-item {{ $page == $all_brand_product->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endforeach

                    {{-- Nút Trang kế --}}
                    @if ($all_brand_product->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $all_brand_product->nextPageUrl() }}">Trang kế</a>
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
