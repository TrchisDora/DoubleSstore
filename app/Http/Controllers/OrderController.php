<?php

namespace App\Http\Controllers;
<<<<<<< HEAD
use App\Models\Order;  
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function order_index()
    {
=======

use App\Models\Order;  
use App\Models\Product;          
use App\Models\CategoryProduct;  
use App\Models\BrandProduct;  
use App\Models\Customer; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    // Hiển thị danh sách đơn hàng
    public function order_index(Request $request)
    {
        // Định nghĩa trạng thái đơn hàng
>>>>>>> d97843cdb195b8e1c481d724187343e9507331a5
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
<<<<<<< HEAD
=======

        // Định nghĩa biểu tượng trạng thái đơn hàng
>>>>>>> d97843cdb195b8e1c481d724187343e9507331a5
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
<<<<<<< HEAD
=======

        // Đếm số lượng đơn hàng theo trạng thái
>>>>>>> d97843cdb195b8e1c481d724187343e9507331a5
        $orderCounts = Order::select('order_status', DB::raw('count(*) as count'))
                            ->groupBy('order_status')
                            ->pluck('count', 'order_status')
                            ->all();

<<<<<<< HEAD
        return view('AdminPages.Pages.Order.order', compact('orderStatuses', 'orderCounts', 'statusIcons'));
    }
    public function bulkAction(Request $request)
    {
        // Xử lý hành động bulk ở đây
        // Ví dụ: Xóa các đơn hàng được chọn
        if ($request->has('order_ids')) {
            // Giả sử bạn muốn xóa các đơn hàng được chọn
            Order::destroy($request->input('order_ids'));
            return redirect()->back()->with('message', 'Đã xóa các đơn hàng thành công!');
        }

        return redirect()->back()->with('error', 'Không có đơn hàng nào được chọn!');
=======
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
        $orderCode = $request->input('order_code');
        $status = $request->input('new_status');

        Order::where('order_code', $orderCode)->update(['order_status' => $status]);

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
>>>>>>> d97843cdb195b8e1c481d724187343e9507331a5
    }
}
