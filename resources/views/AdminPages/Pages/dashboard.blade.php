@extends('AdminPages.admin')
@section('admin_content')
<!-- //market-->
<div class="market-updates">
	<div class="col-md-3 market-update-gd">
		<div class="market-update-block clr-block-1">
			<div class="col-md-4 market-update-right">
				<img alt="" src="{{ asset('public/backend/images/icons/Product.png') }}" height="90" width="90">
			</div>
			<div class="col-md-8 market-update-left">
				<h4>Số lượng sản phẩm</h4>
				<h3>{{ $totalQuantity }}</h3> <!-- Hiển thị tổng -->
				<p>Số lượng tất cả sản phẩm trong kho. Bao gồm tất cả các loại</p>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
	<div class="col-md-3 market-update-gd">
		<div class="market-update-block clr-block-2">
			<div class="col-md-4 market-update-right">
				<img alt="" src="{{ asset('public/backend/images/icons/account.png') }}" height="90" width="90">
			</div>
			<div class="col-md-8 market-update-left">
				<h4>Số lượng thành viên</h4>
				<h3>{{ $totalCustomer}}</h3>
				<p>Thông tin các thành đã tham gia vào GreenStore.</p>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>

	<div class="col-md-3 market-update-gd">
		<div class="market-update-block clr-block-3">
			<div class="col-md-4 market-update-right">
				<img alt="" src="{{ asset('public/backend/images/icons/Coin.png') }}" height="90" width="90">
			</div>
			<div class="col-md-8 market-update-left">
				<h4>Tổng doanh thu</h4>
				<h3>{{ number_format($totalSales, 0, '.', ',') }}</h3> <!-- Tổng doanh thu -->
				<p>Doanh thu thu được từ các đơn hàng đã bán.</p>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
	<div class="col-md-3 market-update-gd">
		<div class="market-update-block clr-block-4">
			<div class="col-md-4 market-update-right">
				<img alt="" src="{{ asset('public/backend/images/icons/DH.png') }}" height="90" width="90">
			</div>
			<div class="col-md-8 market-update-left">
				<h4>Số lượng đơn hàng</h4>
				<h3>{{ $totalOrders }}</h3> <!-- Tổng số đơn hàng -->
				<p>Thông tin chi tiết về các đơn hàng đã được đặt.</p>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>

	<div class="clearfix"> </div>
</div>
<!-- //market-->
<div class="row">
	<div class="panel-body">
		<div class="col-md-12 w3ls-graph">
			<!--agileinfo-grap-->
			<div class="agileinfo-grap">
				<div class="agileits-box">
					<header class="agileits-box-header clearfix">
						<h3>Bảng danh thu</h3>
						<label for="filter">Lọc dữ liệu theo:</label>
						<select id="filter" onchange="filterData()">
							<option value="all">Tất cả</option>
							<option value="day">Ngày</option>
							<option value="month">Tháng</option>
							<option value="year">Năm</option>
						</select>

				</div>

				<div class="toolbar">


				</div>
				</header>
				<canvas id="salesChart" width="350" height="100"></canvas>
			</div>
		</div>
		<!--//agileinfo-grap-->

	</div>
</div>
<div class="agil-info-calendar">
	<!-- calendar container -->
	<div class="col-md-6 agile-calendar">
		<div class="calendar-widget">
			<div class="panel-heading ui-sortable-handle">
				<span class="panel-icon">
					<i class="fa fa-calendar-o"></i>
				</span>
				<span class="panel-title"> Calendar Widget</span>
			</div>
			<div class="agile-calendar-grid">
				<div class="page">
					<div class="w3l-calendar-left">
						<div class="calendar-heading">
						</div>
						<div class="monthly" id="mycalendar">

						</div>
					</div>
					<div class="clearfix"> </div>
				</div>
			</div>
		</div>
	</div>
	<!-- //calendar -->
	<div class="col-md-6 w3agile-notifications">
		<div class="col-md-12 w3ls-graph">
			<!--agileinfo-grap-->
			<div class="agileinfo-grap">
				<div class="agileits-box">
					<header class="agileits-box-header clearfix">
						<h3>Bảng Đơn hàng</h3>
						<label for="filter">Lọc dữ liệu theo:</label>
						<select id="filter" onchange="filterData()">
							<option value="all">Tất cả</option>
							<option value="day">Ngày</option>
							<option value="month">Tháng</option>
							<option value="year">Năm</option>
						</select>

				</div>

				<div class="toolbar">


				</div>
				</header>


				<!-- Biểu đồ Trạng thái Đơn hàng -->
				<div id="orderStatusChartWrapper" style="display:none;">
					<canvas id="orderStatusChart" height="240"></canvas>
				</div>
			</div>
		</div>
	</div>
	<div class="clearfix"> </div>

</div>
<div class="row">
    <div class="panel-body">
        <div class="col-md-12 w3ls-graph">
            <!--agileinfo-grap-->
            <div class="agileinfo-grap">
                <div class="agileits-box">
                    <header class="agileits-box-header clearfix">
                        <h3>Sản phẩm gần hết hàng</h3>
                    </header>
                    <div class="toolbar"></div>
                    <div class="panel-body">
                        <div class="row text-center">
                            @foreach($lowStockProducts as $index => $product)
                                <div class="col-md-2 mb-4">
                                    <!-- Canvas biểu đồ tròn -->
                                    <canvas id="productChart{{ $index }}"></canvas>
                                    <script>
                                        var ctx = document.getElementById('productChart{{ $index }}').getContext('2d');
                                        var productChart{{ $index }} = new Chart(ctx, {
                                            type: 'doughnut',
                                            data: {
                                                labels: ['Sản phẩm gần hết hàng'],
                                                datasets: [{
                                                    label: '{{ $product->product_name }}',
                                                    data: [{{ $lowStockPercentages[$index] }}, 100 - {{ $lowStockPercentages[$index] }}],
                                                    backgroundColor: ['#4CAF50', '#FF9800'],  // Màu xanh lá và cam
                                                    borderWidth: 1
                                                }]
                                            },
                                            options: {
                                                responsive: true,
                                                cutoutPercentage: 70, // Tạo vòng tròn bên trong
                                                plugins: {
                                                    legend: {
                                                        display: false
                                                    },
                                                    tooltip: {
                                                        callbacks: {
                                                            label: function(tooltipItem) {
                                                                return tooltipItem.raw.toFixed(2) + '%';
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        });
                                    </script>
                                    <!-- Hiển thị tên sản phẩm và tỷ lệ -->
                                    <div class="product-name mt-2">
                                        <p><strong>{{ $product->product_name }}</strong></p>
										<p>{{ $product->product_quantity }}/10</p> <!-- Hiển thị số lượng hiện tại -->
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <!--//agileinfo-grap-->
        </div>
    </div>
</div>

<style>
    .row.text-center {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-wrap: wrap;
    }
    .product-name {
        text-align: center;
        font-size: 14px;
        color: #333;
    }
</style>

	<div class="panel-body">
		<div class="table-agile-info">
			<div class="panel panel-default">
				<div class="panel-heading bg-primary text-white">
					<h5 class="mb-0">KHÁCH HÀNG GẦN ĐÂY</h5>
				</div>
				<div class="table-responsive">
					<table class="table table-striped b-t b-light">
						<thead class="thead-dark">
							<tr>
								<th>Tên khách hàng</th>
								<th>Email</th>
								<th>Số điện thoại</th>
								<th>Ngày tạo</th>
							</tr>
						</thead>
						<tbody>
							@foreach($recentCustomers as $customer)
								<tr>
									<td>{{ $customer->customer_name }}</td>
									<td>{{ $customer->customer_email }}</td>
									<td>{{ $customer->customer_phone }}</td>
									<td>{{ $customer->created_at->format('d/m/Y') }}</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>

			<!-- Bảng Đơn hàng gần nhất -->
			<div class="panel panel-default">
				<div class="panel-heading bg-info text-white">
					<h5 class="mb-0">ĐƠN HÀNG GẦN NHẤT</h5>
				</div>
				<div class="table-responsive">
					<table class="table table-striped b-t b-light">
						<thead class="thead-dark">
							<tr>
								<th>Mã đơn hàng</th>
								<th>Trạng thái</th>
								<th>Ngày tạo</th>
								<th>Tổng tiền</th>
							</tr>
						</thead>
						<tbody>
							@foreach($recentOrders as $order)
								<tr>
									<td>{{ $order->order_code }}</td>
									<td>{{ $order->order_status }}</td>
									<td>{{ $order->created_at->format('d/m/Y') }}</td>
									<td>{{ number_format($order->getTotalAmountAttribute()) }} VNĐ</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>

			<!-- Bảng Sản phẩm mới -->
			<div class="panel panel-default">
				<div class="panel-heading bg-success text-white">
					<h5 class="mb-0">SẢN PHẨM MỚI</h5>
				</div>
				<div class="table-responsive">
					<table class="table table-striped b-t b-light">
						<thead class="thead-dark">
							<tr>
								<th>Tên sản phẩm</th>
								<th>Giá</th>
								<th>Giới thiệu</th>
								<th>Số lượng</th>
							</tr>
						</thead>
						<tbody>
							@foreach($recentProducts as $product)
								<tr>
									<td>{{ $product->product_name }}</td>
									<td>{{ number_format($product->product_price) }} VNĐ</td>
									<td>{{ $product->product_prominent }}</td>
									<td>{{ $product->product_quantity }}</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

<script>
	// Dữ liệu Doanh thu
	const rawDates = @json($date);
	const rawSales = @json($sales);

	let filteredDates = rawDates;
	let filteredSales = rawSales;

	// Biểu đồ Doanh thu
	const ctx1 = document.getElementById('salesChart').getContext('2d');
	const chart1 = new Chart(ctx1, {
		type: 'bar',
		data: {
			labels: filteredDates,
			datasets: [{
				label: 'Doanh thu',
				data: filteredSales,
				backgroundColor: 'rgba(75, 192, 192, 0.7)',
				borderColor: 'rgba(75, 192, 192, 1)',
				borderWidth: 1
			}]
		},
		options: {
			plugins: {
				legend: {
					display: true,
					position: 'top',
					labels: { font: { size: 12 } }
				}
			},
			scales: {
				x: {
					title: { display: true, text: 'Ngày đặt hàng' }
				},
				y: {
					title: { display: true, text: 'Giá trị (VNĐ)' }
				}
			}
		}
	});

	// Hàm lọc dữ liệu
	function filterData() {
		const filter = document.getElementById('filter').value;

		if (filter === 'day') {
			filteredDates = rawDates;
			filteredSales = rawSales;
		} else if (filter === 'month') {
			const monthData = {};
			rawDates.forEach((date, index) => {
				const month = date.slice(0, 7);
				const salesValue = parseFloat(rawSales[index]) || 0;

				if (!monthData[month]) {
					monthData[month] = { sales: 0 };
				}
				monthData[month].sales += salesValue;
			});

			filteredDates = Object.keys(monthData);
			filteredSales = filteredDates.map(date => monthData[date].sales.toFixed(2));
		} else if (filter === 'year') {
			const yearData = {};
			rawDates.forEach((date, index) => {
				const year = date.slice(0, 4);
				const salesValue = parseFloat(rawSales[index]) || 0;

				if (!yearData[year]) {
					yearData[year] = { sales: 0 };
				}
				yearData[year].sales += salesValue;
			});

			filteredDates = Object.keys(yearData);
			filteredSales = filteredDates.map(date => yearData[date].sales.toFixed(2));
		} else {
			filteredDates = rawDates;
			filteredSales = rawSales;
		}

		// Cập nhật biểu đồ doanh thu
		chart1.data.labels = filteredDates;
		chart1.data.datasets[0].data = filteredSales;
		chart1.update();
	}
	// Biểu đồ Trạng thái Đơn hàng
	const dates = @json($dates);
	const statusCounts = @json($statusCounts);
	const statusNames = ['Giao hàng thành công', 'Giao hàng thất bại', 'Thanh toán tại của hàng']; // Tên các trạng thái

	// Kiểm tra xem có dữ liệu hay không
	if (dates.length > 0 && Object.keys(statusCounts).length > 0) {
		// Hiển thị phần wrapper cho biểu đồ
		const orderStatusChartWrapper = document.getElementById('orderStatusChartWrapper');
		if (orderStatusChartWrapper) {
			orderStatusChartWrapper.style.display = 'block';
		}

		// Tính giá trị max từ statusCounts để tự động điều chỉnh trục y
		let maxOrderCount = 0;
		Object.values(statusCounts).forEach(counts => {
			const maxInStatus = Math.max(...counts);
			maxOrderCount = Math.max(maxOrderCount, maxInStatus);
		});

		// Làm tròn giá trị max lên để tạo khoảng cách đẹp
		let maxY = Math.ceil(maxOrderCount / 3) * 3; // Giới hạn lên một bội số của 3

		const ctx2 = document.getElementById('orderStatusChart').getContext('2d');
		const chart2 = new Chart(ctx2, {
			type: 'line',
			data: {
				labels: dates,
				datasets: Object.keys(statusCounts).map((status, index) => ({
					label: statusNames[index], // Sử dụng tên trạng thái thay vì "Trạng thái"
					data: statusCounts[status].map(count => Math.round(count)), // Làm tròn số
					borderColor: `rgba(${Math.random() * 255}, ${Math.random() * 255}, ${Math.random() * 255}, 1)`,
					fill: false,
					tension: 0 // Loại bỏ độ căng để không làm tròn các điểm
				}))
			},
			options: {
				responsive: true,
				plugins: { legend: { position: 'bottom' } },
				scales: {
					x: {
						title: { display: true, text: 'Ngày' }
					},
					y: {
						title: { display: true, text: 'Số đơn hàng' },
						beginAtZero: true,
						min: 0, // Đảm bảo trục y bắt đầu từ 0
						max: maxY, // Sử dụng giá trị max tính toán
						ticks: {
							stepSize: 1 // Đảm bảo trục y chỉ có số nguyên
						}
					}
				}
			}
		});
	} else {
		// Nếu không có dữ liệu, ẩn phần wrapper
		const orderStatusChartWrapper = document.getElementById('orderStatusChartWrapper');
		if (orderStatusChartWrapper) {
			orderStatusChartWrapper.style.display = 'none';
		}
	}


</script>

@endsection