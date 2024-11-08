@extends('AdminPages.admin')

@section('admin_content')
<div class="table-agile-info">
    <div class="panel panel-default">
    <div class="container-fluid">

    <div class="row mb-4" style="margin: 15px 0px;">
        <div class="col-md-11">
            <label for="orderCode">Mã hóa đơn:</label>
            <span id="orderCode"></span>
        </div>
        <div class="col-md-1">
            <button class="btn btn-primary w-100" id="addOrderBtn">Hóa đơn mới</button>
        </div>
    </div>


    {{-- Danh sách sản phẩm trong giỏ hàng --}}
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Danh sách sản phẩm trong giỏ hàng</h5>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Mã hàng</th>
                                <th>Tên sản phẩm</th>
                                <th>Hình ảnh</th>
                                <th>Số lượng</th>
                                <th>Đơn giá</th>
                                <th>Thành tiền</th>
                                <th>Xóa</th>
                            </tr>
                        </thead>
                        <tbody id="orderItems">
                            <!-- Các dòng sản phẩm sẽ được thêm vào đây -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        {{-- Thông tin thanh toán --}}
        <div class="col-md-4">
        <div class="panel panel-default">
            <div class="table-agile-info">
            <div class="card">
                <div class="card-body">
                <div class="panel-heading">
                       Hóa đơn thanh toán
                    </div>
                    <div class="form-group">
                        <label>Tổng tiền hàng:</label>
                        <span id="totalAmount">0</span> đ
                    </div>
                    <div class="form-group">
                        <label>Giảm giá:</label>
                        <input type="number" class="form-control" id="discount" value="0">
                    </div>
                    <div class="form-group">
                        <label>Thuế suất:</label>
                        <input type="number" class="form-control" id="tax" value="0">
                    </div>
                    <div class="form-group">
                        <label>Khách cần trả:</label>
                        <span id="totalPayable">0</span> đ
                    </div>
                    <div class="form-group">
                        <label>Khách thanh toán:</label>
                        <input type="number" class="form-control" id="customerPaid" value="0">
                    </div>
                    <div class="form-group">
                        <label>Tiền thừa trả khách:</label>
                        <span id="changeAmount">0</span> đ
                    </div>
                    <button class="btn btn-success w-100 mt-3" id="checkoutBtn">Thanh toán</button>
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>
</div>

            <div class="table-agile-info">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Liệt kê sản phẩm
                    </div>
                    <div class="row w3-res-tb">
                        <div class="col-sm-6 m-b-xs" style="">
                            <form method="GET" action="{{ route('admin.order.add_order') }}">
                                <select class="input-sm form-control w-sm inline v-middle" name="category_id" onchange="this.form.submit()">
                                    <option value="0">Tất cả danh mục</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->category_id }}" {{ request('category_id') == $category->category_id ? 'selected' : '' }}>
                                            {{ $category->category_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <select class="input-sm form-control w-sm inline v-middle" name="brand_id" onchange="this.form.submit()">
                                    <option value="0">Tất cả thương hiệu</option>
                                    @foreach($brands as $brand)
                                        <option value="{{ $brand->brand_id }}" {{ request('brand_id') == $brand->brand_id ? 'selected' : '' }}>
                                            {{ $brand->brand_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <select class="input-sm form-control w-sm inline v-middle" name="product_status" onchange="this.form.submit()">
                                    <option value="">Tất cả sản phẩm</option>
                                    <option value="0" {{ request('product_status') == '0' ? 'selected' : '' }}>Sản phẩm đang ẩn</option>
                                    <option value="1" {{ request('product_status') == '1' ? 'selected' : '' }}>Sản phẩm đang hiển thị</option>
                                </select>
                                <select class="input-sm form-control w-sm inline v-middle" name="product_prominent" onchange="this.form.submit()">
                                    <option value="">Tất cả sản phẩm</option>
                                    <option value="1" {{ request('product_prominent') == '1' ? 'selected' : '' }}>Sản phẩm nổi bật</option>
                                    <option value="0" {{ request('product_prominent') == '0' ? 'selected' : '' }}>Sản phẩm không nổi bật</option>
                                </select>
                            </form>
                        </div>
                        
                        <div class="col-sm-3"></div>
                        
                        <div class="col-sm-3">
                            <form method="GET" action="{{ route('admin.order.add_order') }}" style="display: inline; flex-grow: 1;">
                                <div class="input-group">
                                    <input type="text" name="search" class="input-sm form-control" placeholder="Search" value="{{ request('search') }}">
                                    <span class="input-group-btn">
                                        <button class="btn btn-sm btn-default" type="submit">Go!</button>
                                    </span>
                                </div>
                            </form>
                        </div>
                    </div>

                        <div class="table-responsive">
                            <table class="table table-striped b-t b-light">
                                <thead>
                                    <tr>
                                        <th>Tên sản phẩm</th>
                                        <th>Số lượng</th>
                                        <th>Giá</th>
                                        <th>Hình sản phẩm</th>
                                        <th>Danh mục</th>
                                        <th>Thương hiệu</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($all_product as $product)
                                    <tr>
                                        <td>{{ $product->product_name }}</td>
                                        <td>{{ $product->product_quantity }}</td>
                                        <td>{{ number_format($product->product_price, 0, ',', '.') }}đ</td>
                                        <td><img src="{{ asset('public/fontend/images/product/'.$product->product_image) }}" height="115" width="125"></td>
                                        <td>{{ $product->categoryProduct ? $product->categoryProduct->category_name : 'Không có danh mục' }}</td>
                                        <td>{{ $product->brandProduct ? $product->brandProduct->brand_name : 'Không có thương hiệu' }}</td>
                                        <td>
                                            <button class="btn btn-primary btn-sm add-to-cart w-100" data-id="{{ $product->product_id }}" data-name="{{ $product->product_name }}" data-price="{{ $product->product_price }}" data-image="{{ asset('public/fontend/images/product/'.$product->product_image) }}">
                                                <i class="fas fa-cart-plus"></i> Thêm vào giỏ
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>           
                    <footer class="panel-footer">
                        <div class="row">
                            <div class="col-sm-5 text-center">
                                <small class="text-muted inline m-t-sm m-b-sm">showing {{ $all_product->firstItem() }} - {{ $all_product->lastItem() }} of {{ $all_product->total() }} items</small>
                            </div>
                            <div class="col-sm-7 text-right text-center-xs">                
                            <ul class="pagination pagination-sm m-t-none m-b-none">
                                @if ($all_product->onFirstPage())
                                    <li class="page-item disabled"><span class="page-link">Quay lại</span></li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $all_product->previousPageUrl() }}">Quay lại</a>
                                    </li>
                                @endif
                                @foreach ($all_product->getUrlRange(1, $all_product->lastPage()) as $page => $url)
                                    <li class="page-item {{ $page == $all_product->currentPage() ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach
                                @if ($all_product->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $all_product->nextPageUrl() }}">Trang kế</a>
                                    </li>
                                @else
                                    <li class="page-item disabled"><span class="page-link">Trang kế</span></li>
                                @endif
                            </ul>
                            </div>
                        </div>
                    </footer>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
let cart = JSON.parse(localStorage.getItem('cart')) || {};
// Lắng nghe sự kiện click vào các nút "Thêm vào giỏ"
document.querySelectorAll('.add-to-cart').forEach(button => {
    button.addEventListener('click', function() {
        const productId = this.getAttribute('data-id');
        const productName = this.getAttribute('data-name');
        const productPrice = parseFloat(this.getAttribute('data-price'));
        const productImage = this.getAttribute('data-image');
        
        // Nếu sản phẩm chưa có trong giỏ thì thêm mới
        if (!cart[productId]) {
            cart[productId] = {
                name: productName,
                price: productPrice,
                quantity: 0,
                image: productImage
            };
        }

        // Tăng số lượng sản phẩm
        cart[productId].quantity++;

        // Lưu giỏ hàng vào localStorage
        localStorage.setItem('cart', JSON.stringify(cart));

        renderCart();
    });
});
// Hiển thị giỏ hàng
function renderCart() {
    let orderItemsHTML = '';
    let totalAmount = 0;

    for (const productId in cart) {
        const product = cart[productId];
        const totalPrice = product.price * product.quantity;
        totalAmount += totalPrice;

        orderItemsHTML += `
            <tr>
                <td>${productId}</td>
                <td>${product.name}</td>
                <td>
                    <img src="${product.image}" alt="${product.name}" style="width: 50px; height: 50px;">
                </td>
                <td>
                    <input type="number" class="form-control" value="${product.quantity}" onchange="updateQuantity('${productId}', this.value)">
                </td>
                <td>${formatCurrency(product.price)} đ</td>
                <td>${formatCurrency(totalPrice)} đ</td>
                <td><button class="btn btn-danger" onclick="removeItem('${productId}')">Xóa</button></td>
            </tr>
        `;
    }

    // Cập nhật hiển thị tổng tiền
    document.getElementById('orderItems').innerHTML = orderItemsHTML;
    document.getElementById('totalAmount').innerText = formatCurrency(totalAmount);

    updateFinalAmounts(totalAmount);
}

// Hàm định dạng tiền
function formatCurrency(amount) {
    return amount.toLocaleString('vi-VN'); // Định dạng tiền theo kiểu Việt Nam
}
// Cập nhật số lượng sản phẩm
function updateQuantity(productId, quantity) {
    if (quantity <= 0) {
        quantity = 1;
    }
    cart[productId].quantity = quantity;
    
    // Lưu giỏ hàng vào localStorage
    localStorage.setItem('cart', JSON.stringify(cart));

    renderCart();
}

// Xóa sản phẩm khỏi giỏ hàng
function removeItem(productId) {
    delete cart[productId];
    
    // Lưu giỏ hàng vào localStorage
    localStorage.setItem('cart', JSON.stringify(cart));

    renderCart();
}

// Cập nhật các giá trị cuối cùng
function updateFinalAmounts(totalAmount) {
    const discount = parseFloat(document.getElementById('discount').value) || 0;
    const tax = parseFloat(document.getElementById('tax').value) || 0;

    let totalPayable = totalAmount - discount + tax;
    document.getElementById('totalPayable').innerText = totalPayable;

    const customerPaid = parseFloat(document.getElementById('customerPaid').value) || 0;
    const changeAmount = customerPaid - totalPayable;
    document.getElementById('changeAmount').innerText = changeAmount >= 0 ? changeAmount : 0;
}

// Lắng nghe sự kiện thay đổi giá trị giảm giá và thuế
document.getElementById('discount').addEventListener('input', function() {
    const totalAmount = parseFloat(document.getElementById('totalAmount').innerText) || 0;
    updateFinalAmounts(totalAmount);
});

document.getElementById('tax').addEventListener('input', function() {
    const totalAmount = parseFloat(document.getElementById('totalAmount').innerText) || 0;
    updateFinalAmounts(totalAmount);
});

document.getElementById('customerPaid').addEventListener('input', function() {
    const totalAmount = parseFloat(document.getElementById('totalAmount').innerText) || 0;
    updateFinalAmounts(totalAmount);
});

// Khi người dùng phân trang, giỏ hàng vẫn được lưu trữ trong localStorage và không bị mất
window.addEventListener('load', function() {
    renderCart();  // Hiển thị lại giỏ hàng khi trang được tải lại
});
// Hàm để tạo mã hóa đơn ngẫu nhiên
function generateOrderCode() {
    const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    let code = '';
    for (let i = 0; i < 7; i++) {  // Tạo chuỗi 5 ký tự
        const randomIndex = Math.floor(Math.random() * characters.length);
        code += characters[randomIndex];
    }
    return code;
}

// Hiển thị mã hóa đơn ngẫu nhiên
document.getElementById('orderCode').innerText = generateOrderCode();

// Nếu muốn mỗi lần nhấn vào "Hóa đơn mới" thì tạo mã hóa đơn mới
document.getElementById('addOrderBtn').addEventListener('click', function() {
    const newOrderCode = generateOrderCode();
    document.getElementById('orderCode').innerText = newOrderCode;
});
$(document).ready(function() {
    $('#addOrderBtn').click(function() {
        // Xóa giỏ hàng khỏi localStorage
        localStorage.removeItem('cart');
        
        // Mở trang mới trong tab hoặc cửa sổ mới
        window.open("{{ url('/add-order') }}", "_blank");
    });
}); 
</script>
@endsection
