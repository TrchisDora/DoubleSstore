@extends('AdminPages.admin')

@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Cập nhật danh mục sản phẩm
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
                        window.location.href = "{{ route('all.category.product') }}";
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
                @if($edit_category_product) <!-- Kiểm tra nếu đối tượng không rỗng -->
                    <div class="position-center">
                        <form role="form" action="{{ route('update.category.product', $edit_category_product->category_id) }}" method="post">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="category_name">Tên danh mục</label>
                                <input type="text" value="{{ $edit_category_product->category_name }}" onkeyup="ChangeToSlug();" name="category_name" class="form-control" id="slug" required>
                            </div>
                            <div class="form-group">
                                <label for="slug_category_product">Slug</label>
                                <input type="text" value="{{ $edit_category_product->slug_category_product }}" name="slug_category_product" class="form-control" id="convert_slug" required>
                            </div>
                            <div class="form-group">
                                <label for="category_desc">Mô tả danh mục</label>
                                <textarea style="resize: none" rows="8" class="form-control" name="category_desc" id="category_desc" required>{{ $edit_category_product->category_desc }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="meta_keywords">Từ khóa danh mục</label>
                                <textarea style="resize: none" rows="8" class="form-control" name="meta_keywords" id="meta_keywords" required>{{ $edit_category_product->meta_keywords }}</textarea>
                            </div>
                            <button type="submit" name="update_category_product" class="btn btn-info">Cập nhật danh mục</button>
                        </form>
                    </div>
                @else
                    <p>Không tìm thấy danh mục sản phẩm để cập nhật.</p>
                @endif
            </div>
        </section>
    </div>
</div>
@endsection
