<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Admin;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\TblStatistical;
use Illuminate\Support\Facades\DB;
use Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;

class AdminController extends Controller
{
    public function AuthLogin()
    {
        $admin_id = Session::get('admin_id');
        if ($admin_id) {
            return Redirect::to('dashboard');
        } else {
            return Redirect::to('login')->send();
        }
    }
    // Hiển thị trang đăng nhập
    public function login()
    {
        return view('AdminPages.login');
    }

    // Xử lý đăng nhập
    public function admin(Request $request)
    {
        $admin_email = $request->input('admin_email');
        $admin_password = $request->input('admin_password');
        $admin = Admin::where('admin_email', $admin_email)->first();

        if ($admin) {

            if ($admin->admin_password === md5($admin_password)) {

                $request->session()->put('admin_id', $admin->admin_id);
                $request->session()->put('admin_name', $admin->admin_name);
                // Quay về trang dashboard của admin
                return redirect()->route('admin.dashboard');
            } else {

                return redirect()->route('login')->with('error', 'Mật khẩu không chính xác.');
            }
        } else {

            $user = Customer::where('customer_email', $admin_email)->first();

            if ($user) {
                return redirect('/');
            } else {

                return redirect()->route('login')->with('error', 'Email không tồn tại.');
            }
        }
    }


    public function dashboard()
    {
        $this->AuthLogin();
         // Lấy các đơn hàng gần đây
         $recentOrders = Order::latest()->take(5)->get();

         // Lấy các tài khoản gần đây
         $recentCustomers = Customer::latest()->take(5)->get();
 
         // Lấy các sản phẩm mới nhất
         $recentProducts = Product::latest()->take(5)->get();

        // Lấy dữ liệu từ bảng tbl_order và tbl_order_details, nhóm theo ngày trong tháng hiện tại
        $orders = DB::table('tbl_order')
            ->join('tbl_order_details', 'tbl_order.order_code', '=', 'tbl_order_details.order_code')
            ->select(
                DB::raw('DATE(tbl_order.created_at) as order_date'),
                DB::raw('SUM(tbl_order_details.product_price * tbl_order_details.product_sales_quantity) as total_sales'),
                DB::raw('SUM(tbl_order_details.product_sales_quantity) as total_quantity_sold'),
                DB::raw('COUNT(tbl_order_details.order_code) as total_orders')
            )
            ->groupBy(DB::raw('DATE(tbl_order.created_at)'))  // Nhóm theo ngày
            ->orderBy(DB::raw('DATE(tbl_order.created_at)'))  // Sắp xếp theo ngày
            ->get();  // Lấy kết quả

        // Chuyển đổi dữ liệu thành mảng để truyền vào View
        $date = $orders->pluck('order_date');  // Lấy mảng các ngày
        $sales = $orders->pluck('total_sales');  // Lấy mảng doanh thu
        $quantities = $orders->pluck('total_quantity_sold');  // Lấy mảng số lượng bán
        $totalOrdersFromStats = $orders->pluck('total_orders');  // Lấy mảng tổng số đơn hàng
        // Tính toán bổ sung
        $totalOrders = Order::whereMonth('created_at', Carbon::now()->month)  // Lọc theo tháng hiện tạ
            ->count();  // Tổng số đơn hàng trong tháng hiện tại

        $totalCustomer = Customer::count(); // Tổng số khách hàng

        $totalSales = OrderDetail::whereHas('order', function ($query) {
            $query->whereIn('order_status', [4, 9])
                ->whereMonth('created_at', Carbon::now()->month);
        })->sum(DB::raw('product_price * product_sales_quantity')); // Tổng doanh thu
        $totalQuantity = Product::sum('product_quantity'); // Tổng số lượng sản phẩm
        $orders2 = DB::table('tbl_order')
            ->select(
                DB::raw('DATE(tbl_order.created_at) as order_date'),
                DB::raw('MONTH(tbl_order.created_at) as order_month'),
                DB::raw('YEAR(tbl_order.created_at) as order_year'),
                DB::raw('COUNT(*) as total_orders'),
                DB::raw("CASE 
                        WHEN order_status = 4 THEN 'Giao hàng thành công'
                        WHEN order_status = 7 THEN 'Giao hàng thất bại'
                        WHEN order_status = 9 THEN 'Thanh toán tại cửa hàng'
                        ELSE 'Khác' 
                    END AS order_status_name")
            )
            ->whereIn('order_status', [4, 7, 9]) // Lọc theo trạng thái
            ->groupBy(
                DB::raw('DATE(tbl_order.created_at)'),
                DB::raw('MONTH(tbl_order.created_at)'),
                DB::raw('YEAR(tbl_order.created_at)'),
                'order_status' // Nhóm theo ngày và trạng thái đơn hàng
            )
            ->orderBy('order_date', 'ASC') // Sắp xếp theo ngày
            ->get();

        // Tạo mảng dữ liệu cho các trạng thái 4, 7, 9
        $statusData = [
            'Giao hàng thành công' => [],
            'Giao hàng thất bại' => [],
            'Thanh toán tại cửa hàng' => []
        ];

        // Phân loại và lưu dữ liệu vào mảng
        foreach ($orders2 as $order2) {
            $statusData[$order2->order_status_name][$order2->order_date] = $order2->total_orders;
        }

        // Lấy danh sách ngày từ các trạng thái 4, 7, và 9
        $dates = array_keys($statusData['Giao hàng thành công'] + $statusData['Giao hàng thất bại'] + $statusData['Thanh toán tại cửa hàng']);

        // Chuẩn bị mảng số lượng đơn hàng theo trạng thái
        $statusCounts = [];
        foreach ($statusData as $status => $data) {
            $statusCounts[$status] = array_values($data);
        }
// Lấy các sản phẩm gần hết hàng
$lowStockProducts = Product::where('product_quantity', '<=', 10)->orderBy('product_quantity')->take(5)->get();

// Tính tỷ lệ của mỗi sản phẩm so với 10
$lowStockPercentages = $lowStockProducts->map(function ($product) {
    return ($product->product_quantity / 10) * 100; // Chia cho 10 để lấy phần trăm
});

// Truyền dữ liệu vào view
return view('AdminPages.Pages.dashboard', compact(
    'dates',
    'statusCounts',
    'date',
    'sales',
    'quantities',
    'totalOrdersFromStats',
    'totalOrders',
    'totalCustomer',
    'totalSales',
    'totalQuantity',
    'recentOrders',
    'recentCustomers',
    'recentProducts',
    'lowStockProducts',
    'lowStockPercentages'  // Truyền dữ liệu tỷ lệ vào view
));


    }




    // Đăng xuất
    public function logout(Request $request)
    {
        $request->session()->forget(['admin_id', 'admin_name']);
        return redirect()->route('login');
    }

    public function showChartData()
    {
        $data = TblStatistical::select('order_date', 'sales', 'profit', 'quantity', 'total_order')->get();

        // Chuyển đổi dữ liệu thành dạng mảng để truyền vào View
        $dates = $data->pluck('order_date');
        $sales = $data->pluck('sales');
        $profits = $data->pluck('profit');
        $quantities = $data->pluck('quantity');
        $totalOrders = $data->pluck('total_order');

        return view('AdminPages.Pages.dashboard', compact('dates', 'sales', 'profits', 'quantities', 'totalOrders'));
    }

}
