@extends('AdminPages.admin')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Cập nhật thương hiệu sản phẩm
            </header>

            {{-- Hiển thị thông báo thành công hoặc lỗi nếu có --}}
            @if (session('message'))
                <script>
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: '{{ session('message') }}',
                        showConfirmButton: false,
                        timer: 2500
                    }).then(() => {
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
                    });
                </script>
            @endif

            <div class="panel-body">
                <div class="position-center">
                    {{-- Form cập nhật thương hiệu --}}
                    <form role="form" action="{{ URL::to('/update-brand-product/' . $edit_brand_product->brand_id) }}" method="post">
                        {{ csrf_field() }}
                        
                        <div class="form-group">
                            <label for="brand_product_name">Tên thương hiệu</label>
                            <input type="text" 
                                   value="{{ $edit_brand_product->brand_name }}"  
                                   onkeyup="ChangeToSlug();" 
                                   name="brand_product_name" 
                                   class="form-control" 
                                   id="slug" 
                                   required>
                        </div>
                        <div class="form-group">
                            <label for="brand_product_desc">Mô tả thương hiệu</label>
                            <textarea style="resize: none" 
                                      rows="8" 
                                      class="form-control" 
                                      name="brand_product_desc" 
                                      id="brand_product_desc" 
                                      required>{{ $edit_brand_product->brand_desc }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="brand_product_status">Hiển thị</label>
                            <select name="brand_product_status" 
                                    class="form-control input-sm m-bot15" 
                                    id="brand_product_status">
                                <option value="0" {{ $edit_brand_product->brand_status == 0 ? 'selected' : '' }}>Ẩn</option>
                                <option value="1" {{ $edit_brand_product->brand_status == 1 ? 'selected' : '' }}>Hiển thị</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-info">Cập nhật thương hiệu</button>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection