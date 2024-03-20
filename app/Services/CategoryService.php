<?php

namespace App\Services;

use App\Repositories\AreaRepository;
use App\Repositories\CategoryRepository;
use Hash;
use Log;

class CategoryService extends BaseService
{

    protected $categoryRepository;

    /**
     * Method: __construct
     * Created at: 17/03/2024
     * Created by: Hieu
     *
     * @param App\Repositories\AreaRepository $areaRepository
     * @access public
     * @return void
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->setRepository();
    }

    /**
     * Setting repository want to interact
     * Created at: 17/03/2024
     * Created by: Hieu
     *
     * @access public
     * @return Repository
     */
    public function getRepository(){
        return CategoryRepository::class;
    }
}
