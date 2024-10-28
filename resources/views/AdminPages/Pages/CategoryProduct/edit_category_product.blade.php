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
                @if($edit_category_product)
                    <div class="position-center">
                        <form role="form" action="{{ route('update.category.product', $edit_category_product->category_id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="category_name">Tên danh mục</label>
                                <input type="text" value="{{ $edit_category_product->category_name }}" onkeyup="ChangeToSlug();" name="category_name" class="form-control" id="slug" required>
                            </div>
                            <div class="form-group">
                                <label for="category_desc">Mô tả danh mục</label>
                                <textarea style="resize: none" rows="8" class="form-control" name="category_desc" id="category_desc" required>{{ $edit_category_product->category_desc }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="meta_keywords">Từ khóa danh mục</label>
                                <textarea style="resize: none" rows="8" class="form-control" name="meta_keywords" id="meta_keywords" required>{{ $edit_category_product->meta_keywords }}</textarea>
                            </div>
                            <div class="form-group row">
                                <label for="category_icon_admin" class="col-md-2 col-form-label">Hình ảnh loại Admin</label>
                                <div class="col-md-10 d-flex align-items-center">
                                    <input type="file" name="category_icon_admin" class="form-control-file" id="category_icon_admin">
                                    <div class="ml-3">
                                        @if(isset($edit_category_product->category_icon_admin) && $edit_category_product->category_icon_admin)
                                            <img src="{{ asset('public/backend/images/icons/' . $edit_category_product->category_icon_admin) }}" alt="Admin Icon" class="img-thumbnail" style="width: 100px; height: auto;">
                                        @else
                                            <p class="text-muted">Chưa có hình ảnh.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="category_icon_user" class="col-md-2 col-form-label">Hình ảnh loại User</label>
                                <div class="col-md-10 d-flex align-items-center">
                                    <input type="file" name="category_icon_user" class="form-control-file" id="category_icon_user">
                                    <div class="ml-3">
                                        @if(isset($edit_category_product->category_icon_user) && $edit_category_product->category_icon_user)
                                            <img src="{{ asset('public/fontend/images/icons/' . $edit_category_product->category_icon_user) }}" alt="User Icon" class="img-thumbnail" style="width: 100px; height: auto;">
                                        @else
                                            <p class="text-muted">Chưa có hình ảnh.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="category_status">Trạng thái danh mục</label>
                                <select name="category_status" class="form-control input-sm m-bot15" required>
                                    <option value="0" {{ $edit_category_product->category_status == 0 ? 'selected' : '' }}>Ẩn</option>
                                    <option value="1" {{ $edit_category_product->category_status == 1 ? 'selected' : '' }}>Hiển thị</option>
                                </select>
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
