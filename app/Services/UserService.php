<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function searchQuery($query, $request = [])
    {
        $filters = [
            'name' => [
                'operator' => 'LIKE',
                'value' => '%' . $query . '%'
            ],
            'email' => [
                'operator' => 'LIKE',
                'value' => '%' . $query . '%'
            ],
        ];

        if (Auth::user()->role === ADMIN) {
            $filters['role'] = [
                'column' => 'name',
                'operator' => 'NOT IN',
                'value' => [SUPER_ADMIN, ADMIN]
            ];
        }

        if (isset($request['role'])) {
            $filters['role'] = [
                'operator' => '=',
                'value' => intval($request['role'])
            ];
        }

        return $this->userRepository->paginate($filters, 'id');
    }

    public function getUserById($id)
    {
        return $this->userRepository->getUserById($id);
    }

    public function createUser(array $data)
    {
        return $this->processUser($data);
    }

    public function updateUser($id, array $data)
    {
        return $this->processUser($data, $id);
    }

    private function processUser(array $data, $id = null)
    {
        if (isset($data['role']) && intval($data['role']) === ADMIN) {
            $data['is_admin'] = true;
            $data['role'] = intval($data['role']);
        }
        if (!empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        if ($id === null) {
            return $this->userRepository->createUser($data);
        } else {
            return $this->userRepository->updateUser($id, $data);
        }
    }

    public function deleteUser($id)
    {
        return $this->userRepository->deleteUser($id);
    }
}
