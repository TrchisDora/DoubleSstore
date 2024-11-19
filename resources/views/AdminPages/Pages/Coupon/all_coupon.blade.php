@extends('AdminPages.admin')

@section('admin_content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Liệt kê Mã Giảm Giá
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
                <div class="col-sm-3"></div>
                <div class="col-sm-3"></div>
                <div class="col-sm-6 m-b-xs">
                    <form method="GET" action="{{ route('admin.coupons.index') }}" style="display: inline; flex-grow: 1;">
                        <div class="input-group">
                            <input type="text" name="search" class="input-sm form-control" placeholder="Tìm kiếm mã giảm giá" value="{{ request('search') }}">
                            <span class="input-group-btn">
                                <button class="btn btn-sm btn-default" type="submit">Tìm kiếm</button>
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
                            <th>Mã giảm giá</th>
                            <th>Tên MGG</th>
                            <th>Loại giảm giá</th>
                            <th></th>
                            <th>Giá trị giảm</th>
                            <th>Ngày bắt đầu</th>
                            <th>Ngày kết thúc</th>
                            <th style="width:30px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @csrf
                        @foreach($all_coupons as $coupon)
                        <tr>
                            <td>
                                <input type="checkbox" name="coupon_ids[]" value="{{ $coupon->id }}">
                            </td>
                            <td>{{ $coupon->coupon_code }}</td>
                            <td>{{ $coupon->coupon_name }}</td>
                            <td>
                                {{ $coupon->coupon_condition == 1 ? 'Giảm theo số tiền' : 'Giảm theo phần trăm' }}
                            </td>
                            <td>
                                @if ($coupon->coupon_condition == 1)
                                <img src="{{ asset('public/backend/images/icons/coupon_money.png') }}" alt="Coupon" style="width: 50px; height: auto;">
                                @else
                                <img src="{{ asset('public/backend/images/icons/coupon_percent.png') }}" alt="Coupon" style="width: 50px; height: auto;">
                                @endif
                            </td>
                            <td>
                                {{ number_format($coupon->coupon_number) }} 
                                {{ $coupon->coupon_condition == 1 ? 'VND' : '%' }}
                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($coupon->coupon_start_date)->format('d-m-Y') }}
                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($coupon->coupon_end_date)->format('d-m-Y') }}
                            </td>
                            <td>
                                <a href="{{ URL::to('/edit-coupon/' . $coupon->coupon_id) }}" class="active styling-edit">
                                    <i class="fa fa-pencil-square-o text-success text-active"></i>
                                </a>
                                <a onclick="return confirm('Bạn có chắc chắn muốn xóa mã giảm giá này không?')" 
                                href="{{ URL::to('/delete-coupon/' . $coupon->coupon_id) }}" class="active styling-edit">
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
                        <small class="text-muted inline m-t-sm m-b-sm">Đang hiển thị {{ $all_coupons->firstItem() }}-{{ $all_coupons->lastItem() }} của tổng số {{ $all_coupons->total() }} mã giảm giá</small>
                    </div>
                    <div class="col-sm-7 text-right text-center-xs">
                        <ul class="pagination pagination-sm m-t-none m-b-none">
                            @if ($all_coupons->onFirstPage())
                                <li class="page-item disabled"><span class="page-link">Quay lại</span></li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $all_coupons->previousPageUrl() }}">Quay lại</a>
                                </li>
                            @endif
                            @foreach ($all_coupons->getUrlRange(1, $all_coupons->lastPage()) as $page => $url)
                                <li class="page-item {{ $page == $all_coupons->currentPage() ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endforeach
                            @if ($all_coupons->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $all_coupons->nextPageUrl() }}">Trang kế</a>
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
        const checkboxes = document.querySelectorAll('input[name="coupon_ids[]"]');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });
    </script>

@endsection
