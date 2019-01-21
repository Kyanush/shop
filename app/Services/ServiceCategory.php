<?php
namespace App\Services;

use App\Models\Category;
use App\Models\CategoryFilterLink;
use App\Tools\Helpers;

class ServiceCategory
{
    private $model;
    public function __construct()
    {
        $this->model = new Category();
    }

    public function catalogsTree($type = 1)
    {
        $list = $this->model::OrderBy('sort')->get();
        $data = $list->map(function ($item) use ($type) {

            if($type == 1)
            {
                return[
                    'id'        => $item->id,
                    'url'      => $item->url,
                    'text'      => $item->name,
                    'parent_id' => $item->parent_id,
                    'icon'      => 'fa fa-folder icon-state-default',
                    'opened'    => true
                ];
            }else if($type == 2){
                return [
                    'id'        => $item->id,
                    'name'      => $item->name,
                    'parent_id' => $item->parent_id,
                ];
            }
        });

        return Helpers::createTree($data);
    }

    public function categoryChildIds($parent_id, $self_id_add = true)
    {
        $categories_ids = [];

        if($self_id_add)
            $categories_ids[] = $parent_id;

        $category = $this->model::OrderBy('sort')->where('parent_id', $parent_id)->get();
        foreach ($category as $item)
        {
            $categories_ids[] = $item['id'];
            $childCategories = $this->categoryChildIds($item['id'], false);
            if(count($childCategories) > 0)
            {
                $categories_ids = array_merge($categories_ids, $childCategories);
            }
        }
        return $categories_ids;
    }

    public function listCategoryFilterLinks(int $category_id){
        return CategoryFilterLink::whereIn('category_id', $this->categoryChildIds($category_id))->OrderBy('sort', 'asc')->get();
    }

}