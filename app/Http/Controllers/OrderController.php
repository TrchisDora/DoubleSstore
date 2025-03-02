<?php

namespace App\Http\Controllers;

use App\Models\Order;  
use App\Models\Product;          
use App\Models\CategoryProduct;  
use App\Models\BrandProduct;  
use App\Models\Customer; 
use Illuminate\Http\Request;
use App\Events\OrderChangedByAdmin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    // Hiển thị danh sách đơn hàng
    public function order_index(Request $request)
    {
        // Định nghĩa trạng thái đơn hàng
        $orderStatuses = [
            1 => 'Đang xử lý đơn hàng',
            2 => 'Đã xử lý đơn hàng',
            3 => 'Đang giao hàng',
            4 => 'Giao hàng thành công',
            5 => 'Yêu cầu hủy đơn hàng',
            6 => 'Đã hủy đơn hàng',
            7 => 'Giao hàng thất bại',
            8 => 'Hết hàng'
        ];

        // Định nghĩa biểu tượng trạng thái đơn hàng
        $statusIcons = [
            1 => 'Order_Proccessing.png',
            2 => 'Order_Proccessed.png',
            3 => 'Shipping.png',
            4 => 'Ship_Done_2.png',
            5 => 'Cancel_wait.png',
            6 => 'Order_Cancel.png',
            7 => 'Ship_Error.png',
            8 => 'Not_Have_Order.png'
        ];

        // Đếm số lượng đơn hàng theo trạng thái
        $orderCounts = Order::select('order_status', DB::raw('count(*) as count'))
                            ->groupBy('order_status')
                            ->pluck('count', 'order_status')
                            ->all();

        // Tạo truy vấn để lấy danh sách đơn hàng
        $query = Order::with('orderDetails');

        // Kiểm tra xem có tham số order_status trong yêu cầu không
        if ($request->has('order_status') && $request->order_status != '') {
            $query->where('order_status', $request->order_status);
        }
        if ($request->has('order_status') && $request->order_status == '') {
            return redirect()->route('some.other.route')->with('error', 'Trạng thái đơn hàng không hợp lệ.');
        }

        // Lấy danh sách đơn hàng và tính tổng số lượng sản phẩm cho từng đơn hàng
        $orders = $query->get()->map(function ($order) {
            $order->total_quantity = $order->orderDetails->sum('product_sales_quantity');
            return $order;
        });

        if ($orders->isEmpty()) {
            return redirect()->route('admin.orders.index')->with('error', 'Không có đơn hàng nào!');
        }

        $orderCode = $request->query('order_code');
        $orderDetails = null;

        if ($orderCode) {
            $orderDetails = $this->getOrderDetailsByCode($orderCode);
        }

        return view('AdminPages.Pages.Order.order', compact('orderStatuses', 'statusIcons', 'orderCounts', 'orders', 'orderDetails'));
    }

    // Lấy chi tiết đơn hàng theo mã đơn hàng
    private function getOrderDetailsByCode($orderCode) {
        return Order::with('orderDetails') 
            ->where('order_code', $orderCode)
            ->first();
    }

    // Thực hiện hành động hàng loạt trên các đơn hàng
    public function bulkAction(Request $request)
    {
        $orderCodes = $request->input('selectedOrderCodes'); 
        $newStatus = $request->input('new_status');

        $orderCodesArray = explode(',', $orderCodes);

        if (empty($orderCodes) || count($orderCodesArray) === 0) {
            return redirect()->back()->with('error', 'Vui lòng chọn ít nhất một đơn hàng!');
        }

        if ($newStatus) {
            DB::table('tbl_order')
                ->whereIn('order_code', $orderCodesArray)
                ->update(['order_status' => $newStatus, 'updated_at' => now()]);

            return redirect()->route('admin.orders.index', ['order_status' => $newStatus])->with('message', 'Cập nhật trạng thái thành công.');
        }

        Log::error('Không có đơn hàng nào được chọn hoặc trạng thái không hợp lệ', [
            'orderCodes' => $orderCodes,
            'newStatus' => $newStatus,
        ]);

        return redirect()->back()->with('error', 'Không có đơn hàng nào được chọn hoặc trạng thái không hợp lệ.');
    }

    // Cập nhật trạng thái đơn hàng
    public function updateOrderStatus(Request $request)
{
    // Lấy order_code và trạng thái mới từ request
    $orderCode = $request->input('order_code');
    $status = $request->input('new_status');

    // Cập nhật trạng thái đơn hàng
    $order = Order::where('order_code', $orderCode)->first();

    // Kiểm tra xem đơn hàng có tồn tại không
    if (!$order) {
        return redirect()->route('admin.orders.index')->with('error', 'Đơn hàng không tồn tại!');
    }

    // Cập nhật trạng thái đơn hàng
    $order->order_status = $status;
    $order->save();

    // Lấy thông tin khách hàng liên quan
    $customer = Customer::find($order->customer_id);

    

    // Trả về thông báo thành công
    return redirect()->route('admin.orders.index')->with('message', 'Cập nhật trạng thái đơn hàng thành công!');
}


    // Hiển thị chi tiết đơn hàng
    public function showOrderDetail($order_code)
    {
        $order = Order::with('orderDetails.product')->where('order_code', $order_code)->firstOrFail();
        return view('AdminPages.Pages.Order.order_detail', compact('order'));
    }

    // In đơn hàng
    public function printOrder($id)
    {
        $order = Order::with(['customer', 'shipping', 'orderDetails.product'])->find($id);
        return view('admin.order_print', compact('order'));
    }

    // Thêm đơn hàng mới
    public function add_order(Request $request)
    {
        $currentPage = $request->input('page', 1);
        session(['current_page' => $currentPage]);
    
        $query = Product::query()->with('categoryProduct');
        
        // Áp dụng các điều kiện lọc nếu có
        if ($request->has('category_id') && $request->category_id != 0) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->has('brand_id') && $request->brand_id != 0) {
            $query->where('brand_id', $request->brand_id);
        }
        if ($request->has('product_status') && $request->product_status != '') {
            $query->where('product_status', $request->product_status);
        }
        if ($request->has('product_prominent') && $request->product_prominent != '') {
            $query->where('product_prominent', $request->product_prominent);
        }
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('product_name', 'like', '%' . $searchTerm . '%')
                  ->orWhereHas('categoryProduct', function ($query) use ($searchTerm) {
                      $query->where('meta_keywords', 'like', '%' . $searchTerm . '%');
                  });
            });
        }
    
        // Áp dụng phân trang với các tham số lọc
        $all_product = $query->paginate(5)->appends(request()->query());
    
        // Lấy danh sách danh mục và thương hiệu để hiển thị trong filter
        $categories = CategoryProduct::all();
        $brands = BrandProduct::all();
    
        // Trả về view với dữ liệu sản phẩm, danh mục và thương hiệu
        return view('AdminPages.Pages.Order.add_order', compact('all_product', 'categories', 'brands'));
    }
    

    // Tìm kiếm khách hàng theo số điện thoại
    public function searchCustomerByPhone(Request $request)
    {
        $phone = $request->input('phone');
        $customer = Customer::where('customer_phone', $phone)->first();

        if ($customer) {
            return response()->json([
                'status' => 'success',
                'customer' => $customer
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Khách hàng không tìm thấy.'
            ]);
        }
    }
}
