<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Services\AreaService;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    protected $areaService;
    protected $userService;

    public function __construct(UserService $userService, Area $areaService)
    {
        $this->userService = $userService;
        $this->areaService = $areaService;
    }
}
