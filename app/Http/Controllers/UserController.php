<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUpdateUserRequest;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct (UserService $userService) {
        $this->userService = $userService;
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
            return view('user.add');
        }

        $data = $request->only(['name', 'email', 'password', 'role', 'day_of_work', 'phone']);
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
            return view('user.edit', compact('user'));
        }

        $data = $request->only(['name', 'email', 'password', 'role', 'day_of_work', 'phone']);
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
                return redirect()->route('user.index')->with(['flash_level' => 'success', 'flash_message' => 'Xóa thành công']);
            }
        }
        return redirect()->route('user.index')->with(['flash_level' => 'error', 'flash_message' => 'Lỗi không thể xóa nhân viên']);
    }
}
