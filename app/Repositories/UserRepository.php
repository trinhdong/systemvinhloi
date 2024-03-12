<?php
namespace App\Repositories;

use App\Models\User;

class UserRepository extends BaseRepository
{
    protected $user;
    /**
     * Create a new repository instance.
     * Created at: 12/03/2024
     * Created by: Hieu
     *
     * @param  \App\Models\User  $accept
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->setModel();
    }

    /**
     * Setting model want to interact
     * Created at: 12/03/2023
     * Created by: Hieu
     *
     * @access public
     * @return string
     */
    public function getModel()
    {
        return User::class;
    }
}
