<?php
namespace App\Repositories;

use App\Models\User;

class UserRepository extends BaseRepository
{
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->setModel();
    }

    public function getModel()
    {
        return User::class;
    }

    public function getUserById($id)
    {
        return $this->find($id);
    }

    public function createUser(array $data)
    {
        return $this->create($data);
    }

    public function updateUser($id, array $data)
    {
        return $this->update($id, $data);
    }

    public function deleteUser($id)
    {
        return $this->delete($id);
    }
}
