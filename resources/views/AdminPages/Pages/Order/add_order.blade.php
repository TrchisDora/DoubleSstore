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
                        <div class="table-responsive">
                            <div class="card">
                                <div class="card-body">
                                    <form method="GET" action="{{ route('admin.order.add_order') }}"
                                        style="display: inline; flex-grow: 1;">
                                        <div class="input-group">
                                            <input type="text" name="search" class="input-sm form-control"
                                                placeholder="Search" value="{{ request('search') }}">
                                            <span class="input-group-btn">
                                                <button class="btn btn-sm btn-default" type="submit">Go!</button>
                                            </span>
                                        </div>
                                    </form>
                                    <h5 class="card-title">Danh sách sản phẩm trong giỏ hàng</h5>
                                    <div class="table-container">
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
                        </div>
                        <div class="panel-heading">
                            Liệt kê sản phẩm
                        </div>
                        <div class="row" style="margin: 15px 0px;">
                            <div class="col-sm-12">
                                <form method="GET" action="{{ route('admin.order.add_order') }}">
                                    <select class="input-sm form-control w-sm inline v-middle" name="category_id"
                                        onchange="this.form.submit()">
                                        <option value="0">Tất cả danh mục</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->category_id }}" {{ request('category_id') == $category->category_id ? 'selected' : '' }}>
                                                {{ $category->category_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <select class="input-sm form-control w-sm inline v-middle" name="brand_id"
                                        onchange="this.form.submit()">
                                        <option value="0">Tất cả thương hiệu</option>
                                        @foreach($brands as $brand)
                                            <option value="{{ $brand->brand_id }}" {{ request('brand_id') == $brand->brand_id ? 'selected' : '' }}>
                                                {{ $brand->brand_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <select class="input-sm form-control w-sm inline v-middle" name="product_status"
                                        onchange="this.form.submit()">
                                        <option value="">Tất cả sản phẩm</option>
                                        <option value="0" {{ request('product_status') == '0' ? 'selected' : '' }}>Sản
                                            phẩm đang ẩn</option>
                                        <option value="1" {{ request('product_status') == '1' ? 'selected' : '' }}>Sản
                                            phẩm đang hiển thị</option>
                                    </select>
                                    <select class="input-sm form-control w-sm inline v-middle" name="product_prominent"
                                        onchange="this.form.submit()">
                                        <option value="">Tất cả sản phẩm</option>
                                        <option value="1" {{ request('product_prominent') == '1' ? 'selected' : '' }}>
                                            Sản phẩm nổi bật</option>
                                        <option value="0" {{ request('product_prominent') == '0' ? 'selected' : '' }}>
                                            Sản phẩm không nổi bật</option>
                                    </select>
                                </form>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <div class="panel panel-default">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Tên sản phẩm</th>
                                            <th>Số lượng</th>
                                            <th>Giá</th>
                                            <th>Hình sản phẩm</th>
                                            <th>Danh mục</th>
                                            <th>Thương hiệu</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($all_product as $product)
                                            <tr>
                                                <td>
                                                    <button class="btn btn-primary btn-sm add-to-cart w-100"
                                                        data-id="{{ $product->product_id }}"
                                                        data-name="{{ $product->product_name }}"
                                                        data-price="{{ $product->product_price }}"
                                                        data-image="{{ asset('public/fontend/images/product/' . $product->product_image) }}"
                                                        {{ $product->product_quantity == 0 ? 'disabled' : '' }}>
                                                        <i class="fas fa-cart-plus"></i> Thêm vào giỏ
                                                    </button>
                                                </td>
                                                <td>{{ $product->product_name }}</td>
                                                <td>{{ $product->product_quantity }}</td>
                                                <td>{{ number_format($product->product_price, 0, ',', '.') }}đ</td>
                                                <td><img src="{{ asset('public/fontend/images/product/' . $product->product_image) }}"
                                                        height="85" width="100"></td>
                                                <td>{{ $product->categoryProduct ? $product->categoryProduct->category_name : 'Không có danh mục' }}
                                                </td>
                                                <td>{{ $product->brandProduct ? $product->brandProduct->brand_name : 'Không có thương hiệu' }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <footer class="panel-footer">
                            <div class="row">
                                <div class="col-sm-5 text-center">
                                    <small class="text-muted inline m-t-sm m-b-sm">showing
                                        {{ $all_product->firstItem() }} - {{ $all_product->lastItem() }} of
                                        {{ $all_product->total() }} items</small>
                                </div>
                                <div class="col-sm-7 text-right text-center-xs">
                                    <ul class="pagination pagination-sm m-t-none m-b-none">
                                        @if ($all_product->onFirstPage())
                                            <li class="page-item disabled"><span class="page-link">Quay lại</span></li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $all_product->previousPageUrl() }}">Quay
                                                    lại</a>
                                            </li>
                                        @endif
                                        @foreach ($all_product->getUrlRange(1, $all_product->lastPage()) as $page => $url)
                                            <li class="page-item {{ $page == $all_product->currentPage() ? 'active' : '' }}">
                                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                            </li>
                                        @endforeach
                                        @if ($all_product->hasMorePages())
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $all_product->nextPageUrl() }}">Trang
                                                    kế</a>
                                            </li>
                                        @else
                                            <li class="page-item disabled"><span class="page-link">Trang kế</span></li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </footer>
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
                                            <label>Thu ngân:</label>
                                            <img alt="" src="{{ asset('public/backend/images/icons/avt-admin.png') }}"
                                                height="40" width="40">
                                            <span class="username">
                                                <?php
    $name = Session::get('admin_name');
    if ($name) {
        echo $name;
    }
                                                ?>
                                            </span>
                                        </div>

                                        <div class="form-group">
                                            <label>Tên Khách hàng:</label>
                                            <span id="customerName" style="cursor: pointer;"
                                                onclick="toggleAddMemberForm()">Không tìm thấy</span>
                                        </div>
                                        <div class="form-group">
                                            <label for="customerPhone" class="mr-2">Tìm khách hàng:</label>
                                            <div class="input-group">
                                                <input type="text" id="customerPhone" class="form-control"
                                                    placeholder="Nhập số điện thoại" style="height: 40px;">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-primary" id="searchCustomerBtn" type="button"
                                                        style="height: 40px;">Tìm kiếm</button>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Tổng tiền hàng:</label>
                                            <span id="totalAmount">0</span> đ
                                        </div>
                                        <div class="form-group">
                                            <label for="discount">Mã giảm giá:</label>
                                            <select class="form-control" id="discount" style="height: 40px;">
                                                <option value="0">Không giảm</option>
                                                <option value="50000">Giảm 50,000đ</option>
                                                <option value="100000">Giảm 100,000đ</option>
                                                <option value="150000">Giảm 150,000đ</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="tax">Thuế suất:</label>
                                            <select class="form-control" id="tax" style="height: 40px;">
                                                <option value="10">10%</option>
                                                <option value="15">15%</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="totalPayable">Khách cần trả:</label>
                                            <span id="totalPayable">0</span> đ
                                        </div>

                                        <div class="form-group">
                                            <label for="customerPaid">Khách thanh toán:</label>
                                            <input type="text" class="form-control" id="customerPaid" value="0"
                                                style="height: 40px;">
                                        </div>

                                        <div class="form-group">
                                            <label for="changeAmount">Tiền thừa trả khách:</label>
                                            <span id="changeAmount">0</span>
                                        </div>

                                        <button class="btn btn-success w-100 mt-3" id="checkoutBtn"
                                            style="height: 50px;">Thanh toán</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Cột thêm thành viên -->
                        <div class="panel panel-default">
                            <div class="table-agile-info">
                            <div class="panel-heading" onclick="toggleAddMemberForm()" >Thêm thành viên</div>
                                <div id="add-member-form-container" style="display:none;">

                                    <form action="{{ route('register') }}" method="POST" id="edit-form">
                                        @csrf
                                        <div class="form-group">
                                            <label for="customer_name">Tên khách hàng:</label>
                                            <input type="text" class="form-control" id="customer_name" name="name" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="customer_email">Email:</label>
                                            <input type="email" class="form-control" id="customer_email" name="email"
                                                required>
                                        </div>
                                        <div class="form-group">
                                            <label for="customer_phone">Số điện thoại:</label>
                                            <input type="text" class="form-control" id="customer_phone" name="phone"
                                                required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Đăng ký</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                function toggleAddMemberForm() {
                    const formContainer = document.getElementById('add-member-form-container');
                    if (formContainer.style.display === 'none' || formContainer.style.display === '') {
                        formContainer.style.display = 'block';
                    } else {
                        formContainer.style.display = 'none';
                    }
                }
                let cart = JSON.parse(localStorage.getItem('cart')) || {}; // Lấy giỏ hàng từ localStorage

                // Lắng nghe sự kiện click vào các nút "Thêm vào giỏ"
                document.querySelectorAll('.add-to-cart').forEach(button => {
                    button.addEventListener('click', function () {
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
                    <td><img src="${product.image}" alt="${product.name}" style="width: 50px; height: 50px;"></td>
                    <td><input type="number" class="form-control" value="${product.quantity}" onchange="updateQuantity('${productId}', this.value)"></td>
                    <td>${formatCurrency(product.price)} đ</td>
                    <td>${formatCurrency(totalPrice)} đ</td>
                    <td><button class="btn btn-danger" onclick="removeItem('${productId}')">Xóa</button></td>
                </tr>
            `;
                    }

                    // Cập nhật hiển thị giỏ hàng và tổng tiền
                    document.getElementById('orderItems').innerHTML = orderItemsHTML;
                    document.getElementById('totalAmount').innerText = formatCurrency(totalAmount);

                    updateFinalAmounts(totalAmount);
                }

                // Hàm định dạng tiền
                function formatCurrency(amount) {
                    return amount.toLocaleString('vi-VN'); // Định dạng tiền theo kiểu Việt Nam
                }
                // Hàm để định dạng số tiền và chỉ cho phép nhập số
                function formatCurrencyInput(input) {
                    // Lọc tất cả ký tự không phải số và chỉ giữ lại các số
                    let value = input.value.replace(/\D/g, ''); // \D là regex để loại bỏ tất cả ký tự không phải là số

                    // Chuyển giá trị sang số
                    let number = parseInt(value, 10);

                    if (isNaN(number)) {
                        return; // Nếu không phải là số, không làm gì
                    }

                    // Định dạng số và thêm dấu chấm phân cách hàng nghìn
                    input.value = number.toLocaleString('vi-VN');
                }

                // Lắng nghe sự kiện 'input' trên ô input
                document.getElementById('customerPaid').addEventListener('input', function () {
                    formatCurrencyInput(this);
                });


                // Cập nhật số lượng sản phẩm trong giỏ
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

                // Cập nhật số tiền thanh toán sau khi giảm giá và thuế
                function updateFinalAmounts(totalAmount) {
                    const discount = parseInt(document.getElementById('discount').value, 10) || 0;  // Lấy giá trị giảm giá từ dropdown
                    const taxRate = parseInt(document.getElementById('tax').value, 10) || 0;        // Lấy giá trị thuế từ dropdown

                    // Tính toán tổng tiền sau giảm giá
                    let totalAfterDiscount = totalAmount - discount;

                    // Tính thuế
                    let totalAfterTax = totalAfterDiscount + totalAfterDiscount * (taxRate / 100);

                    // Cập nhật tổng tiền phải thanh toán
                    document.getElementById('totalPayable').textContent = formatCurrency(totalAfterTax);

                    // Lấy giá trị thanh toán của khách hàng từ input
                    const customerPayment = parseInt(document.getElementById('customerPaid').value.replace(/\./g, ''), 10) || 0;

                    // Tính tiền thừa trả khách
                    const changeAmount = customerPayment - totalAfterTax;

                    // Hiển thị tiền thừa trả khách
                    if (changeAmount >= 0) {
                        document.getElementById('changeAmount').textContent = formatCurrency(changeAmount) + ' đ';
                    } else {
                        document.getElementById('changeAmount').textContent = 'Chưa đủ tiền';
                    }
                }

                // Hàm tạo mã hóa đơn ngẫu nhiên
                function generateOrderCode() {
                    const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
                    let code = '';
                    for (let i = 0; i < 7; i++) {  // Tạo chuỗi 7 ký tự
                        const randomIndex = Math.floor(Math.random() * characters.length);
                        code += characters[randomIndex];
                    }
                    return code;
                }

                // Hiển thị mã hóa đơn ngẫu nhiên
                document.getElementById('orderCode').innerText = generateOrderCode();

                // Lắng nghe sự kiện thay đổi giá trị ở các trường giảm giá và thuế
                document.getElementById('discount').addEventListener('change', function () {
                    renderCart(); // Cập nhật giỏ hàng khi thay đổi giảm giá
                });
                document.getElementById('tax').addEventListener('change', function () {
                    renderCart(); // Cập nhật giỏ hàng khi thay đổi thuế
                });

                // Lắng nghe sự kiện input thanh toán của khách hàng
                document.getElementById('customerPaid').addEventListener('input', function () {
                    renderCart(); // Cập nhật lại giỏ hàng và tổng tiền khi nhập số tiền thanh toán
                });

                // Khi người dùng phân trang, giỏ hàng vẫn được lưu trữ trong localStorage và không bị mất
                window.addEventListener('load', function () {
                    renderCart(); // Hiển thị lại giỏ hàng khi trang được tải lại
                });
                $(document).ready(function () {
                    $('#addOrderBtn').click(function () {
                        // Xóa giỏ hàng khỏi localStorage
                        localStorage.removeItem('cart');

                        // Mở trang mới trong tab hoặc cửa sổ mới
                        window.open("{{ url('/add-order') }}", "_blank");
                    });
                });

                $(document).ready(function () {
                    $('#searchCustomerBtn').click(function () {
                        let phone = $('#customerPhone').val().trim();

                        if (phone === '') {
                            alert('Vui lòng nhập số điện thoại');
                            return;
                        }

                        $.ajax({
                            url: '{{ route('order.customer.search') }}',
                            method: 'GET',
                            data: { phone: phone },
                            success: function (response) {
                                if (response.status === 'success') {
                                    // Hiển thị thông tin khách hàng nếu tìm thấy
                                    $('#customerInfo').show();
                                    $('#customerName').text(response.customer.customer_name);
                                    $('#customerEmail').text(response.customer.customer_email);
                                    $('#customerPhoneDisplay').text(response.customer.customer_phone);
                                } else {
                                    $('#customerInfo').hide();
                                    alert(response.message);
                                }
                            },
                            error: function () {
                                alert('Đã có lỗi xảy ra. Vui lòng thử lại.');
                            }
                        });
                    });
                });
            </script>
@endsection