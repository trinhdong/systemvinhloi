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
    public function create(Request $request){
        try {
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
                    'message' => 'Thêm khu vực thất bại',
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Lỗi khi thêm khu vực: ' . $e->getMessage(), [
                'stack' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);
            return response()->json([
                'success' => false,
                'message' => __("construction_project.message.Cannot_update_please_check_the_error_log_file"),
            ]);
        }
    }
}
