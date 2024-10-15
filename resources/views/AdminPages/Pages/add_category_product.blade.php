@extends('AdminPages.admin')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Thêm danh mục sản phẩm
            </header>
            <?php
                $message = Session::get('message');
                if ($message) {
                    echo '<span class="text-alert">' . $message . '</span>';
                    Session::put('message', null);
                }
            ?>
            <div class="panel-body">
                <div class="position-center">
                    <form role="form" action="{{ URL::to('/save-category-product') }}" method="post">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên danh mục</label>
                            <input type="text" class="form-control" onkeyup="ChangeToSlug();" name="category_product_name" id="slug" placeholder="danh mục">
                        </div>
                        
                        <div class="form-group">
                            <label for="exampleInputPassword1">Mô tả danh mục</label>
                            <textarea style="resize: none" rows="8" class="form-control" name="category_product_desc" id="exampleInputPassword1" placeholder="Mô tả danh mục"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Từ khóa danh mục</label>
                            <textarea style="resize: none" rows="8" class="form-control" name="category_product_keywords" id="exampleInputPassword1" placeholder="Mô tả danh mục"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Hiển thị</label>
                            <select name="category_product_status" class="form-control input-sm m-bot15">
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

<script>
    function ChangeToSlug() {
        var name = document.getElementById("slug").value;
        var slug = name.toLowerCase().trim()
            .replace(/[^a-z0-9 -]/g, '') // Loại bỏ ký tự không hợp lệ
            .replace(/-+/g, '-') // Thay thế nhiều dấu gạch nối bằng một
            .replace(/ - /g, '-') // Thay thế khoảng trắng xung quanh
            .replace(/\s+/g, '-'); // Thay thế khoảng trắng bằng dấu gạch nối

        document.getElementById("convert_slug").value = slug; // Gán giá trị slug cho input slug
    }
</script>
@endsection
