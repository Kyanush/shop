<?php
namespace App\Services;

class ServiceCategory
{

    public function createTree(&$list, $parentId = null)
    {
        $tree = array();
        foreach ($list as $key => $eachNode) {
            if ($eachNode->parent_id == $parentId) {
                $eachNode->children = $this->createTree ($list, $eachNode->id);
                $tree[] = $eachNode;
                unset($list[$key]);
            }
        }
        return $tree;
    }

}