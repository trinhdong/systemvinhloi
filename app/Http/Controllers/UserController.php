<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\UserService;
use App\Enums\EUserRole;

class UserController extends Controller
{
    protected $userService;
    protected $businessLocationService;

    public function __construct (UserService $userService) {
        $this->userService = $userService;
    }

    /**
     * Show page list user.
     * Create by: Hien
     * Update by: Hien
     * Update at: 12/12/2022
     */
    public function getListUser(Request $request)
    {
        $id_business = Auth::user()->business_location_id;
        if(Auth::user()->is_admin != 1) {
            $filters = [
            'name' => [
                'operator' => 'LIKE',
                'value' => '%'.$request->user_name.'%',
                ],
                'business_location_id' => $id_business
            ];
        } else {
            $filters = [
            'name' => [
                'operator' => 'LIKE',
                'value' => '%'.$request->user_name.'%',
                ]
            ];
        }
        $users = $this->userService->paginate($filters);
        foreach ($users as $key => $user) {
            switch ($user->role) {
            case EUserRole::SUPER_ADMIN:
                $user->rolename = EUserRole::changeValueToName(EUserRole::SUPER_ADMIN);
                break;
            case EUserRole::ADMIN:
                $user->rolename = EUserRole::changeValueToName(EUserRole::ADMIN);
                break;
            case EUserRole::PRODUCT_MANAGER:
                $user->rolename = EUserRole::changeValueToName(EUserRole::PRODUCT_MANAGER);
                break;
            case EUserRole::ACCOUNTANT:
                $user->rolename = EUserRole::changeValueToName(EUserRole::ACCOUNTANT);
                break;
            case EUserRole::SELLER:
                $user->rolename = EUserRole::changeValueToName(EUserRole::SELLER);
                break;
            case EUserRole::SELL_DEPARTMENT:
                $user->rolename = EUserRole::changeValueToName(EUserRole::SELL_DEPARTMENT);
                break;
            }
        }
        return view('user/list-user', compact('users'));
    }

    /**
     * Show page create user.
     * Create by: Hien
     * Update by: Hien
     * Update at: 12/12/2022
     */
    public function addUser(Request $request)
    {
        $status = $this->userService->getStatus();
        $getBusiness = $this->businessLocationService->getAll();
        if(Auth::user()->is_admin != 1) {
            unset($status['user'][1]);
        }
        return view('user/add-user', compact('status', 'getBusiness'));
    }

    /**
     * Store a newly created resource in storage.
     * Create by: Hien
     * Update by: Hien
     * Update at: 12/12/2022
     *
     * @param  \App\Http\Requests\Admin\UserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function createUser(UserCreateRequest $request)
    {
        $data = $request->all();
        if(Auth::user()->is_admin == 1) {
            $request->validate([
                'business_location_id' => 'required',
            ]);
        }
        if($data['role'] == 1 ) {
            $data['business_location_id'] = null;
        } else {
            if(Auth::user()->is_admin != 1) {
                $data['business_location_id'] = Auth::user()->business_location_id;
            }
        }
        $create_user = $this->userService->store($data);
        if ($create_user) {
            return redirect()->route('list-user')->with(['flash_level' => 'success', 'flash_message' => __('message.create_user_successful')]);
        } else {
            return redirect()->route('add-user')->with(['flash_level' => 'error', 'flash_message' => __('message.message_create_failed')]);
        }
    }

    /**
     * Show page view detail user.
     * Create by: Hien
     * Update by: Hien
     * Update at: 12/12/2022
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function viewUser($id)
    {
        $get_user = $this->userService->find($id);
        if($get_user) {
            if(Auth::user()->role == EUserRole::ADMIN && $get_user->business_location_id != Auth::user()->business_location_id) {
            return redirect()->route('list-user')->with(['flash_level' => 'error', 'flash_message' => __('このアイテムにアクセスする権限がありません。')]);
            }
            switch ($get_user->role) {
                case EUserRole::SUPER_ADMIN:
                    $get_user->rolename = EUserRole::changeValueToName(EUserRole::SUPER_ADMIN);
                    break;
                case EUserRole::ADMIN:
                    $get_user->rolename = EUserRole::changeValueToName(EUserRole::ADMIN);
                    break;
                case EUserRole::PRODUCT_MANAGER:
                    $get_user->rolename = EUserRole::changeValueToName(EUserRole::PRODUCT_MANAGER);
                    break;
                case EUserRole::ACCOUNTANT:
                    $get_user->rolename = EUserRole::changeValueToName(EUserRole::ACCOUNTANT);
                    break;
                case EUserRole::SELLER:
                    $get_user->rolename = EUserRole::changeValueToName(EUserRole::SELLER);
                    break;
                case EUserRole::SELL_DEPARTMENT:
                    $get_user->rolename = EUserRole::changeValueToName(EUserRole::SELL_DEPARTMENT);
                    break;
                }
                return view('user/detail-user', compact('get_user'));
        } else {
            return redirect()->route('list-user')->with(['flash_level' => 'error', 'flash_message' => __('message.404_not_found')]);
        }
    }

    /**
     * Show page view detail user.
     * Create by: Hien
     * Update by: Hien
     * Update at: 12/12/2022
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function viewUserEdit($id)
    {
        $get_user = $this->userService->find($id);
        if ($get_user) {
            if($get_user->is_admin == 1) {
                if(Auth::user()->is_admin != 1) {
                    return redirect()->route('list-user')->with(['flash_level' => 'error', 'flash_message' => __('このアイテムにアクセスする権限がありません。')]);
                }
            }
            if(Auth::user()->role == EUserRole::ADMIN && $get_user->business_location_id != Auth::user()->business_location_id) {
                return redirect()->route('list-user')->with(['flash_level' => 'error', 'flash_message' => __('このアイテムにアクセスする権限がありません。')]);
            }
            $status = $this->userService->getStatus();
            $getBusiness = $this->businessLocationService->getAll();
            if(Auth::user()->is_admin != 1) {
                unset($status['user'][1]);
            }
            switch ($get_user->role) {
                case EUserRole::SUPER_ADMIN:
                    $get_user->rolename = EUserRole::changeValueToName(EUserRole::SUPER_ADMIN);
                    break;
                case EUserRole::ADMIN:
                    $get_user->rolename = EUserRole::changeValueToName(EUserRole::ADMIN);
                    break;
                case EUserRole::PRODUCT_MANAGER:
                    $get_user->rolename = EUserRole::changeValueToName(EUserRole::PRODUCT_MANAGER);
                    break;
                case EUserRole::ACCOUNTANT:
                    $get_user->rolename = EUserRole::changeValueToName(EUserRole::ACCOUNTANT);
                    break;
                case EUserRole::SELLER:
                    $get_user->rolename = EUserRole::changeValueToName(EUserRole::SELLER);
                    break;
                case EUserRole::SELL_DEPARTMENT:
                    $get_user->rolename = EUserRole::changeValueToName(EUserRole::SELL_DEPARTMENT);
                    break;
                }
            return view('user/edit-user', compact('get_user', 'status','getBusiness'));
        } else {
            return back()->with(['flash_level' => 'error', 'flash_message' => __('message.404_not_found')]);
        }
    }

    /**
     * Edit User.
     * Create by: Hien
     * Update by: Hien
     * Update at: 12/12/2022
     *
     * @param  \App\Http\Requests\Admin\UserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function editUser(UserEditRequest $request, $id)
    {
        $data = $request->all();
        if(!empty($data['role'])) {
            if($data['role'] == 1) {
                $data['business_location_id'] = null;
            }
        }
        if(!empty($data['check_role'])) {
            $data['business_location_id'] = null;
            unset($data['check_role']);
        }
        $updateUser = $this->userService->update($id ,$data);
        if ($updateUser) {
            return redirect()->route('list-user',$id)->with(['flash_level' => 'success', 'flash_message' => __('message.update_user_successful')]);
        } else {
            return redirect()->route('edit-user')->with(['flash_level' => 'error', 'flash_message' => __('message.message_create_failed')]);
        }
    }

    /**
     * Delete User.
     * Create by: Hien
     * Update by: Hien
     * Update at: 12/12/2022
     *
     * @param  \App\Http\Requests\Admin\UserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function deleteUser(Request $request)
    {
        $deleteUser = $this->userService->delete($request->id);
        if ($deleteUser) {
            return [
                'status' => true,
                'message' => __('message.delete_user_successful')
            ];
        } else {
            return [
                'status' => false,
                'message' => __('message.message_create_failed')
            ];
        }
    }
}
