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
                        {!! $all_brand_product->links() !!}
                    </ul>
                </div>
            </div>
        </footer>
    </div>
</div>
@endsection
