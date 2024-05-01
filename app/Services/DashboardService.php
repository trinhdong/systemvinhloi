<?php

namespace App\Services;

use App\Repositories\OrderRepository;

class DashboardService
{
    protected $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function addFieldQuantityInProcessing($products, $formatDate, $year, $month, $day)
    {
        foreach ($products as $product) {
            $product->quantity_in_processing = 0;
            foreach ($product->orderDetail as $orderDetail) {
                if (!empty($year) && $orderDetail->order->inProcessing !== null
                    && date($formatDate, strtotime($orderDetail->order->inProcessing->created_at))
                    !== date($formatDate, strtotime($year . $month . $day))
                ) {
                    continue;
                }
                if ($orderDetail->order->status === IN_PROCESSING) {
                    $product->quantity_in_processing += $orderDetail->quantity;
                }
            }
        }
        return $products;
    }

    public function addFieldQuantityDelivered($products, $formatDate, $year, $month, $day)
    {
        foreach ($products as $product) {
            $product->quantity_delivered = 0;
            foreach ($product->orderDetail as $orderDetail) {
                if (!empty($year) && $orderDetail->order->delivered !== null
                    && date($formatDate, strtotime($orderDetail->order->delivered->created_at))
                    !== date($formatDate, strtotime($year . $month . $day))
                ) {
                    continue;
                }
                if ($orderDetail->order->status === DELIVERED || $orderDetail->order->status === COMPLETE) {
                    $product->quantity_delivered += $orderDetail->quantity;
                }
            }
        }
        return $products;
    }

    public function getFormatDate($input = [])
    {
        $formatDate = 'Y';
        if (!empty($input['day']) && !empty($input['month'])) {
            $formatDate = 'Y-m-d';
        }
        if (empty($input['day']) && !empty($input['month'])) {
            $formatDate = 'Y-m';
        }
        return $formatDate;
    }

    public function getPaymentData($customerId, $yearPayment)
    {
        $payment = [];
        for ($monthPayment = 1; $monthPayment <= 12; $monthPayment++) {
            $revenueOfMonth = $this->orderRepository
                ->whereYear('updated_at', $yearPayment)
                ->whereMonth('updated_at', $monthPayment)
                ->where('status', COMPLETE);
            if (!empty($customerId)) {
                $revenueOfMonth->where('customer_id', intval($customerId));
            }
            $revenueOfMonth = $revenueOfMonth->get()->sum('paid');
            $payment[$monthPayment] = intval($revenueOfMonth ?? 0);
        }
        return $payment;
    }
}
