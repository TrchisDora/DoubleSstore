<?php

namespace App\Http\Controllers;
use App\Models\Order;  
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function order_index()
    {
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
        $orderCounts = Order::select('order_status', DB::raw('count(*) as count'))
                            ->groupBy('order_status')
                            ->pluck('count', 'order_status')
                            ->all();

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
    }
}
