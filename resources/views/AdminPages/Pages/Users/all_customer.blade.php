@extends('AdminPages.admin')

@section('admin_content')
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="row">
            <!-- Phần 40% -->
            <div class="col-md-4">
                <div class="panel panel-primary">
                    <div class="panel-heading">Thông tin chỉnh sửa</div>
                    <div class="panel-body">
                        <!-- Form chỉnh sửa -->
                        <div id="edit-form-container" style="display:none;">
                            <form action="" method="POST" id="edit-form">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="customer_name">Tên khách hàng:</label>
                                    <input type="text" class="form-control" id="customer_name" name="customer_name"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="customer_email">Email:</label>
                                    <input type="email" class="form-control" id="customer_email" name="customer_email"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="customer_phone">Số điện thoại:</label>
                                    <input type="text" class="form-control" id="customer_phone" name="customer_phone"
                                        required>
                                </div>
                                <button type="submit" class="btn btn-primary">Cập nhật</button>
                            </form>
                        </div>
                    </div>
                </div>


                <!-- Cột thêm thành viên -->
                <div class="panel panel-default">
                    <div class="panel-heading" style="cursor: pointer;" onclick="toggleAddMemberForm()">Thêm
                        thành viên</div>
                    <div id="add-member-form-container" style="display:none;">
                        <form action="{{ route('register') }}" method="POST" id="edit-form">
                            @csrf
                            <div class="form-group">
                                <label for="customer_name">Tên khách hàng:</label>
                                <input type="text" class="form-control" id="customer_name" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="customer_email">Email:</label>
                                <input type="email" class="form-control" id="customer_email" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="customer_phone">Số điện thoại:</label>
                                <input type="text" class="form-control" id="customer_phone" name="phone" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Đăng ký</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Phần 60% -->
            <div class="col-md-8">
                <div class="table-responsive">
                    <table class="table table-striped b-t b-light">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên khách hàng</th>
                                <th>Email</th>
                                <th>Số điện thoại</th>
                                <th>Trạng thái email</th>
                                <th>Ngày đăng ký</th>
                                <th>Ngày cập nhật</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($all_customer as $customer)
                                <tr>
                                    <td>{{ $customer->customer_id }}</td>
                                    <td>{{ $customer->customer_name }}</td>
                                    <td>{{ $customer->customer_email }}</td>
                                    <td>{{ $customer->customer_phone }}</td>
                                    <td>
                                        <span class="text-ellipsis">
                                            @if($customer->email_verified_at)
                                                <span class="badge badge-success">Đã xác minh</span>
                                            @else
                                                <span class="badge badge-danger">Chưa xác minh</span>
                                            @endif
                                        </span>
                                    </td>
                                    <td>{{ $customer->created_at->format('d-m-Y') }}</td>
                                    <td>{{ $customer->updated_at->format('d-m-Y') }}</td>
                                    <td>
                                        <button class="btn btn-warning btn-edit" data-id="{{ $customer->customer_id }}">
                                            Chỉnh sửa
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Footer phần phân trang -->
                <footer class="panel-footer">
                    <div class="row">
                        <div class="col-sm-5 text-center">
                            <small class="text-muted inline m-t-sm m-b-sm">
                                Showing {{ $all_customer->firstItem() }} - {{ $all_customer->lastItem() }} of
                                {{ $all_customer->total() }} items
                            </small>
                        </div>
                        <div class="col-sm-7 text-right text-center-xs">
                            <ul class="pagination pagination-sm m-t-none m-b-none">
                                @if ($all_customer->onFirstPage())
                                    <li class="page-item disabled"><span class="page-link">Quay lại</span></li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $all_customer->previousPageUrl() }}">Quay lại</a>
                                    </li>
                                @endif
                                @foreach ($all_customer->getUrlRange(1, $all_customer->lastPage()) as $page => $url)
                                    <li class="page-item {{ $page == $all_customer->currentPage() ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach
                                @if ($all_customer->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $all_customer->nextPageUrl() }}">Trang kế</a>
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

<script>
    document.querySelectorAll('.btn-edit').forEach(button => {
        button.addEventListener('click', function () {
            var customerId = this.getAttribute('data-id');
            var formContainer = document.getElementById('edit-form-container');
            var form = document.getElementById('edit-form');

            const currentUrl = window.location.pathname;
            form.action = currentUrl + `/${customerId}`;

            // Điền dữ liệu vào form
            var customerName = this.closest('tr').querySelector('td:nth-child(2)').textContent.trim();
            var customerEmail = this.closest('tr').querySelector('td:nth-child(3)').textContent.trim();
            var customerPhone = this.closest('tr').querySelector('td:nth-child(4)').textContent.trim();

            document.getElementById('customer_name').value = customerName;
            document.getElementById('customer_email').value = customerEmail;
            document.getElementById('customer_phone').value = customerPhone;

            formContainer.style.display = 'block';
        });
    });

    function toggleAddMemberForm() {
        const formContainer = document.getElementById('add-member-form-container');
        if (formContainer.style.display === 'none' || formContainer.style.display === '') {
            formContainer.style.display = 'block';
        } else {
            formContainer.style.display = 'none';
        }
    }
</script>

@endsection