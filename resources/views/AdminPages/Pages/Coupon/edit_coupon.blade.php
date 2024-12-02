@extends('AdminPages.admin')

@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Cập nhật mã giảm giá
            </header>

            @if (session('message'))
                <script>
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: '{{ session('message') }}',
                        showConfirmButton: false,
                        timer: 2500
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

            <div class="panel-body">
                <div class="position-center">
                <form action="{{ route('update.coupon', ['id' => $coupon->coupon_id]) }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="coupon_name">Tên mã giảm giá</label>
                            <input type="text" name="coupon_name" class="form-control" id="coupon_name" 
                                value="{{ old('coupon_name', $coupon->coupon_name) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="coupon_code">Mã giảm giá</label>
                            <input type="text" name="coupon_code" class="form-control" id="coupon_code" 
                                value="{{ old('coupon_code', $coupon->coupon_code) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="coupon_condition">Loại mã giảm giá</label>
                            <select name="coupon_condition" id="coupon_condition" class="form-control" required>
                                <option value="0" {{ $coupon->coupon_condition == 0 ? 'selected' : '' }}>Phần trăm</option>
                                <option value="1" {{ $coupon->coupon_condition == 1 ? 'selected' : '' }}>Số tiền cố định</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="coupon_number">Giá trị mã giảm giá</label>
                            <input type="number" name="coupon_number" class="form-control" id="coupon_number" 
                                value="{{ old('coupon_number', $coupon->coupon_number) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="coupon_time">Số lần sử dụng</label>
                            <input type="number" name="coupon_time" class="form-control" id="coupon_time" 
                                value="{{ old('coupon_time', $coupon->coupon_time) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="coupon_start_date">Ngày bắt đầu</label>
                            <input type="date" name="coupon_start_date" class="form-control" id="coupon_start_date" 
                                value="{{ old('coupon_start_date', $coupon->coupon_start_date ? $coupon->coupon_start_date : '') }}">
                        </div>

                        <div class="form-group">
                            <label for="coupon_end_date">Ngày kết thúc</label>
                            <input type="date" name="coupon_end_date" class="form-control" id="coupon_end_date" 
                                value="{{ old('coupon_end_date', $coupon->coupon_end_date ? $coupon->coupon_end_date : '') }}">
                        </div>

                        <button type="submit" class="btn btn-info">Cập nhật mã giảm giá</button>
                    </form>

                </div>
            </div>
        </section>
    </div>
</div>
@endsection
