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
                    <form role="form" action="{{ route('update.product', $edit_product->product_id) }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên sản phẩm</label>
                            <input type="text" name="product_name" class="form-control" onkeyup="ChangeToSlug();" id="slug" value="{{ $edit_product->product_name }}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">SL sản phẩm</label>
                            <input type="text" data-validation="number" data-validation-error-msg="Làm ơn điền số lượng" name="product_quantity" class="form-control" id="convert_slug" value="{{ $edit_product->product_quantity }}">
                        </div>
                        <div class="form-group">
                            <label for="category_desc">Mô tả sản phẩm</label>
                            <textarea style="resize: none" rows="8" class="form-control" name="category_desc" placeholder="Mô tả danh mục" required>{{ $edit_product->category_desc }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Giá sản phẩm</label>
                            <input type="text" value="{{ $edit_product->product_price }}" name="product_price" class="form-control" id="exampleInputEmail1">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Hình ảnh sản phẩm</label>
                            <input type="file" name="product_image" class="form-control" id="exampleInputEmail1">
                            <img src="{{ URL::to('public/uploads/product/'.$edit_product->product_image) }}" height="100" width="100">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Mô tả sản phẩm</label>
                            <textarea style="resize: none" rows="8" class="form-control" name="product_desc" id="ckeditor2">{{ $edit_product->product_desc }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Nội dung sản phẩm</label>
                            <textarea style="resize: none" rows="8" class="form-control" name="product_content" id="ckeditor3">{{ $edit_product->product_content }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Danh mục sản phẩm</label>
                            <select name="product_cate" class="form-control input-sm m-bot15">
                                @foreach($cate_product as $key => $cate)
                                    <option value="{{ $cate->category_id }}" {{ $cate->category_id == $edit_product->category_id ? 'selected' : '' }}>{{ $cate->category_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Thương hiệu</label>
                            <select name="product_brand" class="form-control input-sm m-bot15">
                                @foreach($brand_product as $key => $brand)
                                    <option value="{{ $brand->brand_id }}" {{ $brand->brand_id == $edit_product->brand_id ? 'selected' : '' }}>{{ $brand->brand_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Hiển thị</label>
                            <select name="product_status" class="form-control input-sm m-bot15">
                                <option value="0" {{ $edit_product->product_status == 0 ? 'selected' : '' }}>Ẩn</option>
                                <option value="1" {{ $edit_product->product_status == 1 ? 'selected' : '' }}>Hiển thị</option>
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
