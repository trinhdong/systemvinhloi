<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;

class UserService extends BaseService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->setRepository();
    }

    public function getRepository(){
        return UserRepository::class;
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

        if (!empty($request['role'])) {
            $filters['role'] = [
                'operator' => '=',
                'value' => intval($request['role'])
            ];
        }

        if (Auth::user()->role === ADMIN) {
            $filters['role'] = [
                'operator' => '>',
                'value' => ADMIN
            ];
        }


        return $this->paginate($filters, 'id');
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
            return $this->create($data);
        } else {
            return $this->update($id, $data);
        }
    }
}
