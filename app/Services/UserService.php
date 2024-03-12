<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Hash;
use Log;

class UserService extends BaseService
{

    protected $userRepository;

    /**
     * Method: __construct
     * Created at: 12/03/2024
     * Created by: Hieu
     *
     * @param App\Repositories\UserRepository $userRepository
     * @access public
     * @return void
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->setRepository();
    }

    /**
     * Setting repository want to interact
     * Created at: 12/03/2024
     * Created by: Hieu
     *
     * @access public
     * @return Repository
     */
    public function getRepository(){
        return UserRepository::class;
    }
}
