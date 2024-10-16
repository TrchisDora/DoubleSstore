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
                            <label for="category_name">Tên danh mục</label>
                            <input type="text" class="form-control" name="category_name" placeholder="danh mục">
                        </div>
                        
                        <div class="form-group">
                            <label for="category_desc">Mô tả danh mục</label>
                            <textarea style="resize: none" rows="8" class="form-control" name="category_desc" placeholder="Mô tả danh mục"></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="category_product_keywords">Từ khóa danh mục</label>
                            <textarea style="resize: none" rows="8" class="form-control" name="category_product_keywords" placeholder="Từ khóa danh mục"></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="category_product_status">Hiển thị</label>
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
@endsection
