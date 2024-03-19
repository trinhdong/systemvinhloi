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
                'logical_operator' => 'OR',
                'operator' => 'LIKE',
                'value' => '%' . $query . '%'
            ],
            'email' => [
                'logical_operator' => 'OR',
                'operator' => 'LIKE',
                'value' => '%' . $query . '%'
            ],
        ];

        if (Auth::user()->role === ADMIN) {
            $filters['role'] = [
                'logical_operator' => 'AND',
                'operator' => '>',
                'value' => ADMIN
            ];
        }

        if (!empty($request['role']) && $request['role'] > ADMIN) {
            $filters['role'] = intval($request['role']);
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
