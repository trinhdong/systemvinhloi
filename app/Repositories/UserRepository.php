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
}
