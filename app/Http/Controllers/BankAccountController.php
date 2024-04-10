<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUpdateBankAccountRequest;
use App\Services\BankAccountService;
use Illuminate\Http\Request;

class BankAccountController extends Controller
{
    protected $bankAccountService;

    public function __construct (BankAccountService $bankAccountService) {
        $this->bankAccountService = $bankAccountService;
    }

    public function index(Request $request)
    {
        $query = $request->input('query');
        $bankAccounts = $this->bankAccountService->searchQuery($query, $request->input());
        return view('bank_account.index', compact('bankAccounts'));
    }

    public function detail($id)
    {
        $bankAccount = $this->bankAccountService->find($id);
        return view('bank_account.detail', compact('bankAccount'));
    }

    public function add(CreateUpdateBankAccountRequest  $request)
    {
        if (!$request->isMethod('post') && !$request->isMethod('put')) {
            return view('bank_account.add');
        }

        $data = $request->only(['bank_code', 'bank_name', 'bank_account_name', 'bank_branch']);
        $bankAccount = $this->bankAccountService->createBankAccount($data);
        if ($bankAccount) {
            return redirect()->route('bank_account.index')->with(['flash_level' => 'success', 'flash_message' => 'Thêm tài khoản ngân hàng thành công']);
        }

        return redirect()->route('bank_account.add')->with(['flash_level' => 'error', 'flash_message' => 'Lỗi không thể thêm tài khoản ngân hàng']);
    }

    public function edit(CreateUpdateBankAccountRequest $request, $id)
    {
        $bankAccount = $this->bankAccountService->find($id);
        if (!$bankAccount) {
            return redirect()->route('bank_account.index')->with(['flash_level' => 'error', 'flash_message' => 'Tài khoản ngân hàng không tồn tại']);
        }

        if (!$request->isMethod('post') && !$request->isMethod('put')) {
            return view('bank_account.edit', compact('bankAccount'));
        }

        $data = $request->only(['bank_code', 'bank_name', 'bank_account_name', 'bank_branch']);
        $updated = $this->bankAccountService->updateBankAccount($bankAccount->id, $data);
        if ($updated) {
            return redirect()->route('bank_account.index')->with(['flash_level' => 'success', 'flash_message' => 'Cập nhật tài khoản ngân hàng thành công']);
        }

        return redirect()->route('bank_account.edit', $id)->with(['flash_level' => 'error', 'flash_message' => 'Lỗi không thể cập nhật tài khoản ngân hàng']);
    }

    public function delete($id)
    {
        $bankAccount = $this->bankAccountService->delete($id);
        if ($bankAccount) {
            return redirect()->route('bank_account.index')->with(['flash_level' => 'success', 'flash_message' => 'Xóa thành công']);
        }
        return redirect()->route('bank_account.index')->with(['flash_level' => 'error', 'flash_message' => 'Lỗi không thể xóa tài khoản ngân hàng']);
    }
}
