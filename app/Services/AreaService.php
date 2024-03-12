<?php

namespace App\Services;

use App\Repositories\AreaRepository;
use Hash;
use Log;

class AreaService extends BaseService
{

    protected $areaRepository;

    /**
     * Method: __construct
     * Created at: 12/03/2024
     * Created by: Hieu
     *
     * @param App\Repositories\AreaRepository $areaRepository
     * @access public
     * @return void
     */
    public function __construct(AreaRepository $areaRepository)
    {
        $this->areaRepository = $areaRepository;
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
        return AreaRepository::class;
    }
}
