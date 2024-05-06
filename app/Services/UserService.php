<?php

namespace App\Services;

use App\Repositories\EmployeeCustomerRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserService extends BaseService
{
    protected $userRepository;
    protected $employeeCustomerRepository;

    public function __construct(UserRepository $userRepository, EmployeeCustomerRepository $employeeCustomerRepository)
    {
        $this->userRepository = $userRepository;
        $this->employeeCustomerRepository = $employeeCustomerRepository;
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

        if (!empty($request['role']) && $request['role'] > ADMIN
            || Auth::user()->role === SUPER_ADMIN && !empty($request['role'])
        ) {
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
        DB::beginTransaction();
        if (isset($data['day_of_work'])) {
            $dayOfWork = \DateTime::createFromFormat(FORMAT_DATE_VN, $data['day_of_work']);
            if ($dayOfWork) {
                $data['day_of_work'] = $dayOfWork->format(FORMAT_DATE);
            }
        }
        if (isset($data['role']) && intval($data['role']) === ADMIN) {
            $data['is_admin'] = true;
        }
        $data['role'] = intval($data['role']);
        if (!empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        if ($id === null) {
            $user = $this->userRepository->create($data, true);
        } else {
            $user = $this->userRepository->update($id, $data, true);
        }
        if ($user && $this->processEmployeeCustomer($data, $user->id)) {
            DB::commit();
            return $user;
        }
        DB::rollBack();
        return false;
    }

    private function processEmployeeCustomer(array $data, $id) {
        $employeeCustomerDb = $this->employeeCustomerRepository
            ->getWhere(['user_id' => $id])
            ->pluck('id', 'customer_id')
            ->toArray();
        $dataDelete = $employeeCustomerDb;
        if ($data['role'] === SALE) {
            foreach ($data['customer_ids'] ?? [] as $customerId) {
                unset($dataDelete[$customerId]);
                if (array_key_exists($customerId, $employeeCustomerDb)) {
                    continue;
                }
                $employeeCustomer = $this->employeeCustomerRepository->create([
                    'customer_id' => $customerId,
                    'user_id' => $id
                ], true);
                if (!$employeeCustomer) {
                    return false;
                }
            }
        }
        if (!empty($dataDelete)) {
            foreach ($dataDelete as $id) {
                if (!$this->employeeCustomerRepository->delete($id, true)) {
                    return false;
                }
            }
        }
        return true;
    }
}
