<?php

namespace App\Http\Controllers;

use App\Repositories\BankAccountRepository;
use App\Repositories\CommentRepository;
use App\Repositories\CustomerRepository;
use App\Repositories\InvoiceRepository;
use App\Repositories\OrderDetailRepository;
use App\Repositories\ProductRepository;
use App\Repositories\UserRepository;
use App\Services\OrderService;

class DashboardController extends Controller
{
    public function __construct(
        OrderService $orderService,
        CustomerRepository $customerRepository,
        ProductRepository $productRepository,
        OrderDetailRepository $orderDetailRepository,
        CommentRepository $commentRepository,
        UserRepository $userRepository,
        BankAccountRepository $bankAccountRepository,
        InvoiceRepository $invoiceRepository,
    )
    {
        $this->orderService = $orderService;
        $this->customerRepository = $customerRepository;
        $this->productRepository = $productRepository;
        $this->orderDetailRepository = $orderDetailRepository;
        $this->commentRepository = $commentRepository;
        $this->userRepository = $userRepository;
        $this->bankAccountRepository = $bankAccountRepository;
        $this->invoiceRepository = $invoiceRepository;
    }

    public function index()
    {
//        $orders = $this->orderService->getAll();
//        $products = $this->productRepository->getAll();
//        $comments = $this->commentRepository->getWhere(['type' => COMMENT_TYPE_ORDER, 'status' => DELIVERED])->pluck('created_at', 'order_id');
//        $orderDetails = $this->orderDetailRepository->pluck('order_id', 'product_id');
//        foreach ($products as $product) {
//            if ($comments[$product->order]) {
//
//            }
//        }
//        $customers = $this->customerRepository->getAll();
//        $totalOrder = count($orders);
//        $totalProduct = count($products);
//        $totalCustomer = count($customers);
//        $totalPayment = $orders->where('status', COMPLETE)->sum('paid');
        return view('dashboard');
    }
}
