<?php

namespace App\Http\Controllers;

use App\Services\AreaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AreaController extends Controller
{
    protected $areaService;

    public function __construct(AreaService $areaService)
    {
        $this->areaService = $areaService;
    }

    public function index(){
        $areaList = $this->areaService->paginate('', '','ASC',2,false);
        return view('area.index', compact('areaList'));
    }
    public function show(){
        return view('area.create');
    }
    public function create(Request $request)
    {
        $data = $request->all();
        $user = Auth::user();
        $data['created_by'] = $user['id'];
        $insertArea = $this->areaService->create($data);

        if ($insertArea) {
            return response()->json([
                'success' => true,
                'message' => 'Thêm khu vực thành công',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Thêm khu vực thất bại hoặc đã xảy ra lỗi nào đó',
            ]);
        }
    }
}
