@extends('AdminPages.admin')

@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Thêm mã giảm giá
            </header>

            @if (session('message'))
                <script>
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: '{{ session('message') }}',
                        showConfirmButton: false,
                        timer: 2500
                    }).then(() => {
                        window.location.href = "{{ route('all.coupons') }}";
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
                    }).then(() => {
                        @php Session::forget('error'); @endphp
                    });
                </script>
            @endif

            <div class="panel-body">
                <div class="position-center">
                    <form role="form" action="{{ URL::to('/save-coupon') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="coupon_name">Tên mã giảm giá</label>
                            <input type="text" class="form-control" name="coupon_name" placeholder="Nhập tên mã giảm giá" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="coupon_code">Mã giảm giá</label>
                            <input type="text" class="form-control" name="coupon_code" placeholder="Nhập mã giảm giá" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="coupon_time">Số lượng mã</label>
                            <input type="number" class="form-control" name="coupon_time" placeholder="Số lượng mã giảm giá" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="coupon_condition">Loại giảm giá</label>
                            <select name="coupon_condition" class="form-control" required>
                                <option value="0">Giảm theo %</option>
                                <option value="1">Giảm theo số tiền</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="coupon_number">Số tiền hoặc % giảm giá</label>
                            <input type="number" step="0.01" class="form-control" name="coupon_number" placeholder="Nhập giá trị giảm" required>
                        </div> 

                        <div class="form-group">
                            <label for="coupon_start_date">Ngày bắt đầu</label>
                            <input type="date" class="form-control" id="coupon_start_date" name="coupon_start_date" required>
                        </div>

                        <div class="form-group">
                            <label for="coupon_end_date">Ngày kết thúc</label>
                            <input type="date" class="form-control" id="coupon_end_date" name="coupon_end_date" required>
                        </div>
                        <button type="submit" name="add_coupon" class="btn btn-info">Thêm mã giảm giá</button>
                    </form>
                </div>
            </div>

        </section>
    </div>
</div>
@endsection
