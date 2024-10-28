@extends('AdminPages.admin')

@section('admin_content')
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            Thống kê đơn hàng
        </div>
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
@endsection
