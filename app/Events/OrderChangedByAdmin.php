<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;

class OrderChangedByAdmin
{
    use SerializesModels;

    public $orderId;
    public $orderCode;
    public $orderStatus;
    public $adminName;
    public $customerName;
    public $action;

    public function __construct($orderId, $orderCode, $orderStatus, $adminName, $customerName, $action)
    {
        $this->orderId = $orderId;
        $this->orderCode = $orderCode;
        $this->orderStatus = $orderStatus;
        $this->adminName = $adminName;
        $this->customerName = $customerName;
        $this->action = $action;
    }
}
