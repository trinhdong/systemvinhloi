<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUpdateCustomerRequest;
use App\Services\CustomerService;
use App\Services\AreaService;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    protected $customerService;
//    protected $areaService;

    public function __construct (CustomerService $customerService) {
        $this->customerService = $customerService;
//        $this->areaService = $areaService;
    }

    public function index(Request $request)
    {
        $areas = [];
        $query = $request->input('query');
        $customers = $this->customerService->searchQuery($query, $request->input());
        return view('customer.index', compact('customers', 'areas'));
    }

    public function detail($id)
    {
        $customer = $this->customerService->getCustomerById($id);
        return view('customer.detail', compact('customer'));
    }

    public function add(CreateUpdateCustomerRequest  $request)
    {
        if (!$request->isMethod('post') && !$request->isMethod('put')) {
            $areas = [];
            return view('customer.add', compact('areas'));
        }

        $data = $request->only(['name', 'email', 'phone', 'address', 'area_id']);
        $customer = $this->customerService->createCustomer($data);
        if ($customer) {
            return redirect()->route('customer.index')->with('success', 'Thêm người dùng thành công');
        }

        return redirect()->route('customer.index')->with('error', 'Lỗi không thể thêm người dùng');
    }

    public function edit(CreateUpdateCustomerRequest $request, $id)
    {
        $customer = $this->customerService->getCustomerById($id);
        if (!$customer) {
            return redirect()->route('customer.index')->with('error', 'Khách hàng không tồn tại');
        }

        if (!$request->isMethod('post') && !$request->isMethod('put')) {
            $areas = [];
            return view('customer.edit', compact('customer'), compact('areas'));
        }

        $data = $request->only(['name', 'email', 'phone', 'address', 'area_id']);
        $updated = $this->customerService->updateCustomer($customer->id, $data);
        if ($updated) {
            return redirect()->route('customer.index')->with('success', 'Cập nhật khách hàng thành công');
        }

        return redirect()->route('customer.index')->with('error', 'Lỗi không thể cập nhật khách hàng');
    }

    public function delete($id)
    {
        $customer = $this->customerService->deleteCustomer($id);
        if ($customer) {
            return redirect()->route('customer.index')->with('success', 'Xóa thành công');
        }
        return redirect()->route('customer.index')->with('error', 'Lỗi không thể xóa khách hàng');
    }
}
