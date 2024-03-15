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
        return view('area.add');
    }
    public function create(Request $request)
    {
        $data = $request->all();
        $user = Auth::user();
        $data['created_by'] = $user['id'];
        $insertArea = $this->areaService->create($data);
        if($insertArea) {
            return redirect()->route('area.list')->with(['flash_level' => 'success', 'flash_message' => 'Thêm khu vực thành công']);
        } else {
            return redirect()->route('area.create.show')->with(['flash_level' => 'error', 'flash_message' => 'Thêm khu vực không thành công']);
        }
    }
    public function detail($id){
        $area = $this->areaService->find($id);
        return view('area.detail', compact('area'));
    }
    public function edit($id){
        $area = $this->areaService->find($id);
        if (!$area){
            return redirect()->route('area.list')->with(['flash_level' => 'error', 'flash_message' => 'Khu vực không tồn tại']);
        }
        return view('area.edit', compact('area'));
    }
    public function update(Request $request){
        $data = $request->all();
        $user = Auth::user();
        $data['updated_by'] = $user['id'];
        $updateArea = $this->areaService->update($data['id'], $data);
        if ($updateArea){
            return redirect()->route('area.list')->with(['flash_level' => 'success', 'flash_message' => 'Chỉnh sửa khu vực thành công']);
        } else {
            return redirect()->route('area.edit', ['id' => $data['id']])->with(['flash_level' => 'error', 'flash_message' => 'Chỉnh sửa khu vực không thành công']);
        }
    }
    public function delete($id)
    {
        $area = $this->areaService->delete($id);
        if ($area) {
            return redirect()->route('area.list')->with(['flash_level' => 'success', 'flash_message' => 'Xóa khu vực thành công']);
        }
        return redirect()->route('area.list')->with('error', 'Lỗi không thể xóa khu vực');
    }
}
