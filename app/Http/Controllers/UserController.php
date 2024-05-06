<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUpdateUserRequest;
use App\Repositories\CustomerRepository;
use App\Repositories\EmployeeCustomerRepository;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;
    protected $customerRepository;
    protected $employeeCustomerRepository;

    public function __construct (UserService $userService, CustomerRepository $customerRepository, EmployeeCustomerRepository $employeeCustomerRepository) {
        $this->userService = $userService;
        $this->customerRepository = $customerRepository;
        $this->employeeCustomerRepository = $employeeCustomerRepository;
    }

    public function index(Request $request)
    {
        $query = $request->input('query');
        $users = $this->userService->searchQuery($query, $request->input());
        return view('user.index', compact('users'));
    }

    public function detail($id)
    {
        $user = $this->userService->find($id);
        return view('user.detail', compact('user'));
    }

    public function add(CreateUpdateUserRequest  $request)
    {
        if (!$request->isMethod('post') && !$request->isMethod('put')) {
            $customers = $this->customerRepository->getAll();
            foreach ($customers as $k => $customer) {
                if (!empty($customer->employeeCustomer)) {
                    unset($customers[$k]);
                }
            }
            return view('user.add', compact('customers'));
        }

        $data = $request->only(['name', 'email', 'password', 'role', 'day_of_work', 'phone', 'customer_ids']);
        $user = $this->userService->createUser($data);
        if ($user) {
            return redirect()->route('user.index')->with(['flash_level' => 'success', 'flash_message' => 'Thêm nhân viên thành công']);
        }

        return redirect()->route('user.add')->with(['flash_level' => 'error', 'flash_message' => 'Lỗi không thể thêm nhân viên']);
    }

    public function edit(CreateUpdateUserRequest $request, $id)
    {
        $user = $this->userService->find($id);
        if (!$user) {
            return redirect()->route('user.index')->with(['flash_level' => 'error', 'flash_message' => 'Nhân viên không tồn tại']);
        }

        if (!$request->isMethod('post') && !$request->isMethod('put')) {
            $customerIds = $user->customer->pluck('id')->toArray();
            $customers = $this->customerRepository->getAll();
            foreach ($customers as $k => $customer) {
                if (!empty($customer->employeeCustomer) && !in_array($customer->id, $customerIds)) {
                    unset($customers[$k]);
                }
            }
            return view('user.edit', compact('user', 'customers', 'customerIds'));
        }

        $data = $request->only(['name', 'email', 'password', 'role', 'day_of_work', 'phone', 'customer_ids']);
        $updated = $this->userService->updateUser($user->id, $data);
        if ($updated) {
            return redirect()->route('user.index')->with(['flash_level' => 'success', 'flash_message' => 'Cập nhật nhân viên thành công']);
        }

        return redirect()->route('user.edit', $id)->with(['flash_level' => 'error', 'flash_message' => 'Lỗi không thể cập nhật nhân viên']);
    }

    public function delete($id)
    {
        if ($id > 1) {
            $user = $this->userService->delete($id);
            if ($user) {
                $hasEmployeeCustomer = $this->employeeCustomerRepository->getWhere(['user_id' => $id])->count() > 0;
                if($hasEmployeeCustomer) {
                    $this->employeeCustomerRepository->deleteAll('user_id', $id);
                }
                return redirect()->route('user.index')->with(['flash_level' => 'success', 'flash_message' => 'Xóa thành công']);
            }
        }
        return redirect()->route('user.index')->with(['flash_level' => 'error', 'flash_message' => 'Lỗi không thể xóa nhân viên']);
    }
}
