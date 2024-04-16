<?php

namespace App\Http\Controllers;

use App\Repositories\CustomerRepository;
use App\Repositories\ProductRepository;
use App\Services\DashboardService;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct(
        OrderService          $orderService,
        CustomerRepository    $customerRepository,
        ProductRepository     $productRepository,
        DashboardService      $dashboardService
    )
    {
        $this->orderService = $orderService;
        $this->customerRepository = $customerRepository;
        $this->productRepository = $productRepository;
        $this->dashboardService = $dashboardService;
    }

    public function index(Request $request)
    {
        $isAdmin = Auth::user()->role == ADMIN || Auth::user()->role == SUPER_ADMIN;
        $isStocker = Auth::user()->role == STOCKER;
        $formatDate = $this->dashboardService->getFormatDate($request->input());
        $day = !empty($request->input('day')) ? '-' . $request->input('day') : '';
        $month = !empty($request->input('month')) ? '-' . $request->input('month') : '-1';
        $year = $request->input('year') ?? date('Y');
        $yearPayment = $request->input('year_payment') ?? date('Y');
        $customerId = $request->input('customer_id') ?? '';
        $payment = $this->dashboardService->getPaymentData($customerId, $yearPayment);
        $products = $this->productRepository->getAll();
        $products = $this->dashboardService->addFieldQuantityDelivered($products, $formatDate, $year, $month,  $day);
        $products = $this->dashboardService->addFieldQuantityInProcessing($products, $formatDate, $year, $month,  $day);
        $customers = $this->customerRepository->getList('customer_name');
        return view('dashboard', compact('products', 'isAdmin', 'isStocker', 'customers', 'payment'));
    }
}
