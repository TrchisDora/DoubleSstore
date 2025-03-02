<?php

namespace App\Listeners;

use App\Events\OrderChangedByAdmin;
use Illuminate\Support\Facades\Log;

class SendAdminOrderChangeNotification
{
    public function handle(OrderChangedByAdmin $event)
    {
        // Log thông báo thay đổi đơn hàng
        Log::info("Thông báo: " . $event->adminName . " đã thay đổi trạng thái đơn hàng " . $event->orderCode . " (ID: " . $event->orderId . ") của khách hàng " . $event->customerName . " với trạng thái " . $event->orderStatus . " và hành động: " . $event->action);

        // Bạn có thể gửi thông báo tới người dùng hoặc admin qua email, notification...
    }
}
