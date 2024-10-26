@extends('AdminPages.admin')

@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">Thêm sản phẩm</header>
            @if (session('message'))
            <script>
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: '{{ session('message') }}',
                    showConfirmButton: false,
                    timer: 2500
                }).then(() => {
                    // Chuyển hướng đến trang danh sách sản phẩm sau 2 giây
                    window.location.href = "{{ route('all.product') }}";
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
                    @php
                        Session::forget('error');
                    @endphp
                });
            </script>
            @endif
            <div class="panel-body">
                <div class="position-center">
                    <form role="form" action="{{ URL::to('/save-product') }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="product_name">Tên sản phẩm</label>
                            <input type="text" class="form-control" name="product_name" id="product_name" placeholder="Tên sản phẩm" required>
                        </div>

                        <div class="form-group">
                            <label for="product_quantity">Số lượng</label>
                            <input type="number" class="form-control" name="product_quantity" id="product_quantity" placeholder="Số lượng" required>
                        </div>

                        <div class="form-group">
                            <label for="product_content">Nội dung sản phẩm</label>
                            <textarea style="resize: none" rows="8" class="form-control" name="product_content" placeholder="Nội dung sản phẩm" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="product_desc">Mô tả sản phẩm</label>
                            <textarea style="resize: none" rows="8" class="form-control" name="product_desc" placeholder="Mô tả sản phẩm" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="product_price">Giá</label>
                            <input type="text" class="form-control" name="product_price" id="product_price" placeholder="Giá sản phẩm" required>
                        </div>

                        <div class="form-group">
                            <label for="product_image">Hình sản phẩm</label>
                            <input type="file" name="product_image" class="form-control" id="product_image" required>
                        </div>

                        <div class="form-group">
                            <label for="category_id">Danh mục</label>
                            <select name="category_id" class="form-control" required>
                                <option value="">Chọn danh mục</option>
                                @foreach($cate_product as $cate)
                                    <option value="{{ $cate->category_id }}">{{ $cate->category_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="brand_id">Thương hiệu</label>
                            <select name="brand_id" class="form-control" required>
                                <option value="">Chọn thương hiệu</option>
                                @foreach($brand_product as $brand)
                                    <option value="{{ $brand->brand_id }}">{{ $brand->brand_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="product_status">Trạng thái</label>
                            <select name="product_status" class="form-control" required>
                                <option value="0">Hiển thị</option>
                                <option value="1">Ẩn</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Nổi bật</label>
                            <select name="product_prominent" class="form-control input-sm m-bot15" required>
                                <option value="0">Không</option>
                                <option value="1">Có</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-info">Thêm sản phẩm</button>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
