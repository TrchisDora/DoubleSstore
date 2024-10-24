@extends('AdminPages.admin')

@section('admin_content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                           Thêm thương hiệu sản phẩm
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
                                // Chuyển hướng đến trang danh sách sản phẩm sau 2 giây
                                window.location.href = "{{ route('all.brand.product') }}";
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
                                <form role="form" action="{{URL::to('/save-brand-product')}}" method="post">
                                    {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên thương hiệu</label>
                                    <input type="text" name="brand_product_name" class="form-control" onkeyup="ChangeToSlug();" id="slug" placeholder="Tên danh mục">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Mô tả thương hiệu</label>
                                    <textarea style="resize: none" rows="8" class="form-control" name="brand_product_desc" id="exampleInputPassword1" placeholder="Mô tả danh mục"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Hiển thị</label>
                                      <select name="brand_product_status" class="form-control input-sm m-bot15">
                                            <option value="0">Hiển thị</option>
                                            <option value="1">Ẩn</option>
                                            
                                    </select>
                                </div>
                               
                                <button type="submit" name="add_category_product" class="btn btn-info">Thêm thương hiệu</button>
                                </form>
                            </div>

                        </div>
                    </section>

            </div>
@endsection