<?php

namespace App\Http\Controllers\Admin\Api;
use App\Http\Controllers\Admin\AdminController;

use App\Models\Category;
use App\Requests\SaveCategoryRequest;
use App\Services\ServiceCategory;
use Illuminate\Http\Request;
use DB;

class CategoryController extends AdminController
{

    private $serviceCategory;
    public function __construct(ServiceCategory $serviceCategory)
    {
        $this->serviceCategory = $serviceCategory;
    }

    public function list(Request $request)
    {
        $search = trim(mb_strtolower($request->input('search')));

        $list =  Category::with(['parent' => function($query){
                    $query->select(['id', 'name']);
                 }])
                ->where(function ($query) use ($search){

                    //Поиск по ФИО, телефону или email
                    if(!empty($search))
                    {
                        $query->Where(   DB::raw('LOWER(name)'), 'like', "%"  . $search . "%");
                        $query->OrWhere( DB::raw('LOWER(slug)'), 'like', "%"  . $search . "%");
                    }

                })
                ->OrderBy('id', 'DESC')
                ->paginate($request->input('per_page') ?? 5);

        return  $this->sendResponse($list);
    }
    public function create(SaveCategoryRequest $request)
    {
        $category = Category::create($request->input('category'));
        return $this->sendResponse($category ? $category->id : false);
    }
    public function view($id)
    {
        return  $this->sendResponse(
            Category::findOrFail($id)
        );
    }

    public function update(SaveCategoryRequest $request, $id)
    {
        return  $this->sendResponse(
            Category::where('id', $id)->update($request->input('category')) ? true : false
        );
    }

    public function delete($id)
    {
        return  $this->sendResponse(Category::destroy($id) ? true : false);
    }

    public function reorder()
    {
        $list = Category::select(['id', 'name', 'parent_id'])->get();
        $tree = $this->serviceCategory->createTree($list);

        return  $this->sendResponse($tree);
    }

    public function reorder_save(Request $request)
    {
        $data = $request->input('reorder_send');

        foreach ($data as $item)
        {
            $id = $item['id'];
            unset($item['id']);
            Category::where('id', $id)->update($item);
        }

        return  $this->sendResponse(true);
    }






}
