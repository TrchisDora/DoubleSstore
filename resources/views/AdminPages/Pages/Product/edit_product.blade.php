@extends('AdminPages.admin')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Cập nhật sản phẩm
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
                    });
                </script>
            @endif
            <div class="panel-body">
                <div class="position-center">
                    <form role="form" action="{{ route('update.product', $product->product_id) }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="product_name">Tên sản phẩm</label>
                            <input type="text" name="product_name" class="form-control" onkeyup="ChangeToSlug();" id="slug" value="{{ $product->product_name }}">
                        </div>

                        <div class="form-group">
                            <label for="product_quantity">SL sản phẩm</label>
                            <input type="text" data-validation="number" data-validation-error-msg="Làm ơn điền số lượng" name="product_quantity" class="form-control" id="convert_slug" value="{{ $product->product_quantity }}">
                        </div>

                        <div class="form-group">
                            <label for="product_desc">Mô tả sản phẩm</label>
                            <textarea style="resize: none" rows="8" class="form-control" name="product_desc" id="ckeditor2">{{ $product->product_desc }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="product_content">Nội dung sản phẩm</label>
                            <textarea style="resize: none" rows="8" class="form-control" name="product_content" id="ckeditor3">{{ $product->product_content }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="product_price">Giá sản phẩm</label>
                            <input type="text" value="{{ $product->product_price }}" name="product_price" class="form-control" id="product_price">
                        </div>

                        <div class="form-group row">
                            <label for="product_image" class="col-md-2 col-form-label">Hình ảnh sản phẩm</label>
                            <div class="col-md-10 d-flex align-items-center">
                                <input type="file" name="product_image" class="form-control-file" id="product_image">
                                <div class="ml-3">
                                    @if(isset($product->product_image) && $product->product_image)
                                        <img src="{{ URL::to('public/fontend/images/product/'.$product->product_image) }}" class="img-thumbnail" alt="Hình ảnh sản phẩm" height="200" width="200">
                                    @else
                                        <p class="text-muted">Chưa có hình ảnh sản phẩm.</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="category_id">Danh mục sản phẩm</label>
                            <select name="category_id" class="form-control input-sm m-bot15" required>
                                @foreach($categories as $key => $cate)
                                    <option value="{{ $cate->category_id }}" {{ $cate->category_id == $product->category_id ? 'selected' : '' }}>
                                        {{ $cate->category_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="brand_id">Thương hiệu sản phẩm</label>
                            <select name="brand_id" class="form-control input-sm m-bot15" required>
                                @foreach($brands as $key => $brand)
                                    <option value="{{ $brand->brand_id }}" {{ $brand->brand_id == $product->brand_id ? 'selected' : '' }}>
                                        {{ $brand->brand_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="product_status">Hiển thị</label>
                            <select name="product_status" class="form-control input-sm m-bot15">
                                <option value="0" {{ $product->product_status == 0 ? 'selected' : '' }}>Ẩn</option>
                                <option value="1" {{ $product->product_status == 1 ? 'selected' : '' }}>Hiển thị</option>
                            </select>
                        </div>

                        <button type="submit" name="add_product" class="btn btn-info">Cập nhật sản phẩm</button>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
