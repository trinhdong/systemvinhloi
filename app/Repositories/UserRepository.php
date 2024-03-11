<?php
namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\User;
use Illuminate\Http\Request;

class UserRepository extends BaseRepository{

    protected $user;
    /**
     * Create a new repository instance.
     * Created at: 27/06/2023
     * Created by: hien
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->setModel();
    }

    /**
     * Setting model want to interact
     * Created at: 27/06/2023
     * Created by: hien
     *
     * @access public
     * @return model
     */
    public function getModel()
    {
        return User::class;
    }
}
