<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUpdateCategoryRequest;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index(Request $request)
    {
        $searchTerm = $request->query('search-category', '');
        $filters = [];
        if (!empty($searchTerm)) {
            $filters['whereRaw'] = "category_name LIKE '%" . $searchTerm . "%'";
        }
        $categoryList = $this->categoryService->paginate($filters, '', 'ASC', 20, false);
        return view('category.index', compact('categoryList'));
    }

    public function show(){
        return view('category.add');
    }

    public function create(CreateUpdateCategoryRequest $request)
    {
        $data = $request->all();
        $user = Auth::user();
        $data['created_by'] = $user['id'];
        $insertCategory = $this->categoryService->create($data);
        if($insertCategory) {
            return redirect()->route('category.list')->with(['flash_level' => 'success', 'flash_message' => 'Thêm danh mục sản phẩm thành công']);
        } else {
            return redirect()->route('category.create.show')->with(['flash_level' => 'error', 'flash_message' => 'Thêm danh mục sản phẩm không thành công']);
        }
    }

    public function detail($id){
        $category = $this->categoryService->find($id);
        return view('category.detail', compact('category'));
    }

    public function edit($id){
        $category = $this->categoryService->find($id);
        if (!$category){
            return redirect()->route('area.list')->with(['flash_level' => 'error', 'flash_message' => 'Danh mục sản phẩm không tồn tại']);
        }
        return view('category.edit', compact('category'));
    }

    public function update(CreateUpdateCategoryRequest $request){
        $data = $request->all();
        $user = Auth::user();
        $data['updated_by'] = $user['id'];
        $updateCategory = $this->categoryService->update($data['id'], $data);
        if ($updateCategory){
            return redirect()->route('category.list')->with(['flash_level' => 'success', 'flash_message' => 'Chỉnh sửa danh mục sản phẩm thành công']);
        } else {
            return redirect()->route('category.edit', ['id' => $data['id']])->with(['flash_level' => 'error', 'flash_message' => 'Chỉnh sửa danh mục sản phẩm không thành công']);
        }
    }

    public function delete($id)
    {
        try {
            $category = $this->categoryService->find($id);
            if (!$category) {
                return redirect()->route('category.list')->with([
                    'flash_level' => 'error',
                    'flash_message' => 'Danh mục sản phẩm không tồn tại.'
                ]);
            }
            $category->deleted_by = auth()->user()->id;
            $category->delete();

            return redirect()->route('category.list')->with([
                'flash_level' => 'success',
                'flash_message' => 'Xóa danh mục sản phẩm thành công.'
            ]);
        } catch (\Exception $e) {
            return redirect()->route('category.list')->with([
                'flash_level' => 'error',
                'flash_message' => 'Đã có lỗi xảy ra khi xóa danh mục sản phẩm.'
            ]);
        }
    }
}
