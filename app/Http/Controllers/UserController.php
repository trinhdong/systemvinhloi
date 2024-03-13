<?php
namespace App\Http\Controllers;

use App\Http\Requests\CreateUpdateUserRequest;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
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
        $user = $this->userService->getUserById($id);
        return view('user.detail', compact('user'));
    }

    public function add(CreateUpdateUserRequest  $request)
    {
        if (!$request->isMethod('post') && !$request->isMethod('put')) {
            return view('user.add');
        }

        $data = $request->only(['name', 'email', 'password', 'role']);
        $user = $this->userService->createUser($data);
        if ($user) {
            return redirect()->route('user.index')->with('success', 'Thêm người dùng thành công');
        }

        return redirect()->route('user.index')->with('error', 'Lỗi không thể thêm người dùng');
    }

    public function edit(CreateUpdateUserRequest $request, $id)
    {
        $user = $this->userService->getUserById($id);
        if (!$user) {
            return redirect()->route('user.index')->with('error', 'Người dùng không tồn tại');
        }

        if (!$request->isMethod('post') && !$request->isMethod('put')) {
            return view('user.edit', compact('user'));
        }

        $data = $request->only(['name', 'email', 'password', 'role']);
        $updated = $this->userService->updateUser($user->id, $data);
        if ($updated) {
            return redirect()->route('user.index')->with('success', 'Cập nhật người dùng thành công');
        }

        return redirect()->route('user.index')->with('error', 'Lỗi không thể cập nhật người dùng');
    }

    public function delete($id)
    {
        $user = $this->userService->deleteUser($id);
        if ($user) {
            return redirect()->route('user.index')->with('success', 'Xóa thành công');
        }
        return redirect()->route('user.index')->with('error', 'Lỗi không thể xóa nhân viên');
    }
}
