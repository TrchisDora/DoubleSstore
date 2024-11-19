@extends('AdminPages.admin')

@section('admin_content')
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            Thống kê đơn hàng
        </div>
<<<<<<< HEAD
=======
        
>>>>>>> d97843cdb195b8e1c481d724187343e9507331a5
        @if (session('message'))
            <script>
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: '{{ session('message') }}',
                    showConfirmButton: false,
                    timer: 2500
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
<<<<<<< HEAD
        @endif
        <div class="table-responsive">
            <table class="table table-striped b-t b-light">
                <thead>
                    <tr>
                        <th></th>
                        <th>Trạng thái</th>
                        <th>Số lượng</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orderStatuses as $key => $status)
                        <tr>
                            <td><img src="{{ asset('public/backend/images/icons/'.$statusIcons[$key]) }}" alt="Status Icon" width="40"></td>
                            <td>{{ $status }}</td>
                            <td>{{ $orderCounts[$key] ?? 0 }}</td>
                            <td>
                                <button class="btn btn-info" >Xem chi tiết</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
=======
         @elseif (session('accept'))
            <script>
            Swal.fire({
                title: 'Xác nhận',
                text: '{{ session('accept') }}',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Có',
                cancelButtonText: 'Không'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('bulkActionForm').submit();
                } else {
                  
                }
            });
        </script>
        @endif
        @php
            $status = request()->query('order_status'); 
        @endphp
        
        @if ($status && array_key_exists($status, $orderStatuses))  
            <div class="table-agile-info">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        BẢNG THÔNG TIN - {{ strtoupper($orderStatuses[$status]) }}
                        <span style="padding-right: 20px;"></span>
                        <img src="{{ asset('public/backend/images/icons/'.$statusIcons[$status]) }}" alt="Status Icon" width="40">
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped b-t b-light">
                            <thead>
                                <tr>
                                @if ($status == 2 || $status == 3 || $status == 5)
                                    <th><input type="checkbox" id="select_all"></th>
                                @endif
                                    <th>Mã đơn hàng</th>
                                    <th>Tổng số lượng</th>
                                    <th>User</th>
                                    <th>Tình trạng đơn hàng</th>
                                    <th>Ngày tạo</th>
                                    <th>Tổng hóa đơn</th>
                                    @if ($status == 1)
                                    <th>Hành động</th>
                                    @endif
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        @if ($status == 2 || $status == 3 || $status == 5)
                                        <td>
                                            <input type="checkbox" name="order_codes[]" value="{{ $order->order_code }}" class="order-checkbox" onchange="toggleBulkActionButton()">
                                        </td>
                                        @endif
                                        <td>{{ $order->order_code }}</td>
                                        <td>{{ $order->total_quantity }}</td>
                                        <td></td>
                                        <td>{{ $orderStatuses[$order->order_status] }}</td>
                                        <td>{{ $order->created_at }}</td>
                                        <td>
                                            {{ number_format($order->orderDetails->sum(function($detail) {
                                                return $detail->product_price * $detail->product_sales_quantity + $detail->product_feeship;
                                            }), 0, ',', '.') }}đ
                                        </td>
                                        @if ($status == 1)
                                        <td>
                                            <button class="btn btn-success" id="click" onclick="updateURLProcess('{{ $order->order_code }}')">Xử lý đơn hàng</button>
                                        </td>
                                        @endif
                                        <td>
                                            <a href="{{ route('order.detail', $order->order_code) }}" class="btn btn-info">Xem chi tiết</a>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-striped b-t b-light">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Trạng thái</th>
                            <th>Số lượng</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orderStatuses as $key => $status)
                            <tr>
                                <td><img src="{{ asset('public/backend/images/icons/'.$statusIcons[$key]) }}" alt="Status Icon" width="40"></td>
                                <td>{{ $status }}</td>
                                <td>{{ $orderCounts[$key] ?? 0 }}</td>
                                <td>
                                    <button class="btn btn-info" onclick="updateURLOrder({{ $key }})">Xem chi tiết</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
        @if (isset($orderDetails) && $orderDetails->order_status == 1)
            <div class="table-agile-info">
                <div style="margin: 10px 0; font-style: italic; color: #333;">
                    <em>Lưu ý: Admin xem kỹ nội dung, trước khi XÁC NHẬN đơn hàng </em>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        BẢNG XỬ LÝ ĐƠN HÀNG - {{ $orderDetails->order_code }}
                    </div>
                    <table class="table table-striped b-t b-light">
                        <thead>
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Giá</th>
                                <th>Số lượng</th>
                                <th>Tổng</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orderDetails->orderDetails as $product) 
                                <tr class="@if ($product->product->product_quantity == 0)@endif">
                                    <td>{{ $product->product_name }}</td>
                                    <td>{{ number_format($product->product_price, 0, ',', '.') }}đ</td>
                                    <td>
                                        @if ($product->product->product_quantity > 0)
                                            {{ $product->product->product_quantity }}
                                        @else
                                            <span class="text-danger">(Hết hàng)</span>
                                        @endif
                                    </td>
                                    <td>{{ number_format($product->product_price * $product->product_sales_quantity, 0, ',', '.') }}đ</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <form method="post" action="{{ route('updateOrderStatus') }}" class="d-flex align-items-center">
                        @csrf
                        <div class="panel panel-default"> 
                            <div class="panel-heading">
                                Cập nhật trạng thái đơn hàng (Orders update)
                            </div>
                            <div class="container mt-3" style="margin-top: 15px;">
                                <div class="col-sm-2 m-b-xs">
                                    <div class="selected-orders mt-3">
                                        <label for="new_status" class="mr-2">Chọn tình trạng:</label>
                                    </div>
                                </div>
                                <div class="col-sm-7">
                                    <input type="hidden" name="order_code" value="{{ $orderDetails->order_code }}">
                                    <div class="form-group mr-6">
                                        <select class="form-control d-inline" name="new_status" id="new_status" style="width: 380px;">
                                            <option value="2">Đã xử lý đơn hàng</option>
                                            <option value="8">Đã hết hàng</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary mr-2">Cập nhật trạng thái</button>
                                        <a href="{{ route('admin.orders.index',['order_status' => 1]) }}" class="btn btn-secondary">Quay lại</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                @else
                    @php
                        $status = request()->query('order_status'); 
                    @endphp
                    @if ($status == 2)
                    <form method="post" action="{{ route('bulk_action') }}" id="bulkActionForm">
                        @csrf
                        <div class="panel panel-default"> 
                            <div class="panel-heading">
                                Chọn đơn hàng giao đơn vị vận chuyển (Shipping)
                            </div>
                            <div class="container mt-3" style="margin-top: 15px;">
                            <div class="col-sm-6 m-b-xs">
                                <div class="selected-orders mt-3">
                                    <strong>Bạn đang chọn đơn hàng:</strong> <span id="selectedOrderCodes">Không có đơn hàng nào được chọn</span>
                                </div>
                            </div>
                            <div class="col-sm-3"></div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <input type="hidden" name="selectedOrderCodes" id="selectedOrderCodesInput" value="">
                                    <button type="submit" class="btn btn-success" id="btn-deliver" name="new_status" value="3" style="width: 180px;">Giao hàng</button>
                                </div>
                            </div>
                        </div>

                        </div>
                    </form>
                    @elseif ($status == 3)
                    <form method="post" action="{{ route('bulk_action') }}" id="bulkActionForm">
                        @csrf
                        <div class="panel panel-default"> 
                            <div class="panel-heading">
                                Xác nhận nhận hàng bởi đơn vị vận chuyển (Confirm order)
                            </div>
                            <div class="container mt-3" style="margin-top: 15px;">
                            <div class="col-sm-6 m-b-xs">
                                <div class="selected-orders mt-3">
                                    <strong>Bạn đang chọn đơn hàng:</strong> <span id="selectedOrderCodes">Không có đơn hàng nào được chọn</span>
                                </div>
                            </div>
                            <div class="col-sm-3"></div>
                            <div class="col-sm-3">
                            <input type="hidden" name="selectedOrderCodes" id="selectedOrderCodesInput" value="">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success" id="btn-deliver" name="new_status" value="4" style="width: 180px;">Giao hàng thành công</button>
                                </div><div class="form-group">
                                    <button type="submit" class="btn btn-danger" id="btn-deliver" name="new_status" value="7" style="width: 180px;">Giao hàng thất bại</button>
                                </div>
                            </div>
                        </div>

                        </div>
                    </form>
                    @elseif ($status == 5)
                    <form method="post" action="{{ route('bulk_action') }}" id="bulkActionForm">
                        @csrf
                        <input type="hidden" name="new_status" value="">
                        <input type="hidden" name="selectedOrderCodes" id="selectedOrderCodesInput" value="">

                        <div class="panel panel-default"> 
                            <div class="panel-heading">
                                Xử lý YÊU CẦU HỦY ĐƠN (Orders Cancel)
                            </div>
                            <div class="container mt-3" style="margin-top: 15px;">
                                <div class="col-sm-6 m-b-xs">
                                    <div class="selected-orders mt-3">
                                        <strong>Bạn đang chọn đơn hàng muốn hủy:</strong> <span id="selectedOrderCodes">Không có đơn hàng nào được chọn</span>
                                    </div>
                                </div>
                                <div class="col-sm-3"></div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <button type="button" class="btn btn-danger" style="width: 180px;" onclick="confirmAction();">Xác nhận</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
<script>
    function confirmAction() {
        Swal.fire({
            title: 'Xác nhận',
            text: 'Bạn có chắc chắn muốn gửi yêu cầu hủy đơn hàng không?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Có',
            cancelButtonText: 'Không'
        }).then((result) => {
            if (result.isConfirmed) {
            document.querySelector('input[name="new_status"]').value = 6;
            document.getElementById('bulkActionForm').submit(); 
            }
        });
    }
    let selectedOrders = [];
    function updateSelectedOrders() {
        const checkboxes = document.querySelectorAll('input[name="order_codes[]"]:checked');
        selectedOrders = Array.from(checkboxes).map(checkbox => checkbox.value);
        document.getElementById('selectedOrderCodes').textContent = selectedOrders.length ? selectedOrders.join(', ') : 'Không có đơn hàng nào được chọn';
        document.getElementById('selectedOrderCodesInput').value = selectedOrders.join(',');
    }
    function toggleBulkActionButton() {
        const checkboxes = document.querySelectorAll('.order-checkbox');
        const hasChecked = Array.from(checkboxes).some(checkbox => checkbox.checked); 
        updateSelectedOrders(); 
    }
    document.getElementById('select_all').onclick = function() {
        const checkboxes = document.querySelectorAll('input[name="order_codes[]"]');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        toggleBulkActionButton();
    };
</script>
>>>>>>> d97843cdb195b8e1c481d724187343e9507331a5
@endsection
