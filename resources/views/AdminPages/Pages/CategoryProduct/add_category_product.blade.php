@extends('AdminPages.admin')

@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Thêm danh mục sản phẩm
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
                    }).then(() => {
                        @php Session::forget('error'); @endphp
                    });
                </script>
            @endif

            <div class="panel-body">
                <div class="position-center">
                    <form role="form" action="{{ URL::to('/save-category-product') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="category_name">Tên danh mục</label>
                            <input type="text" class="form-control" name="category_name" placeholder="Nhập tên danh mục" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="category_desc">Mô tả danh mục</label>
                            <textarea class="form-control" name="category_desc" rows="8" placeholder="Mô tả danh mục" required></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="meta_keywords">Từ khóa danh mục</label>
                            <textarea class="form-control" name="meta_keywords" rows="8" placeholder="Từ khóa danh mục" required></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="category_icon_admin">Hình ảnh loại Admin</label>
                            <input type="file" name="category_icon_admin" class="form-control" id="category_icon_admin" required>
                        </div>

                        <div class="form-group">
                            <label for="category_icon_user">Hình ảnh loại User</label>
                            <input type="file" name="category_icon_user" class="form-control" id="category_icon_user" required>
                        </div>     
                        <div class="form-group">
                            <label for="category_status">Trạng thái</label>
                            <select name="category_status" class="form-control" required>
                                <option value="0">Hiển thị</option>
                                <option value="1">Ẩn</option>
                            </select>
                        </div>    
                        <button type="submit" name="add_category_product" class="btn btn-info">Thêm danh mục</button>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
