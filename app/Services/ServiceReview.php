<?php
namespace App\Services;

use App\Models\Review;
use App\Tools\Helpers;

class ServiceReview
{

    private $model;
    public function __construct()
    {
        $this->model = new Review();
    }

    public function setLike(int $review_id, int $like)
    {
        $review = $this->model::find($review_id);
        if($review)
        {
            $reviewLike = $review->reviewLikes()->searchVisitNumber()->first();

            if(!$reviewLike)
                $review->reviewLikes()->create([
                    'like' =>  $like,
                    'visit_number' => Helpers::getVisitNumber()
                ]);
            else{
                if($reviewLike->like != $like)
                {
                    $reviewLike->like = $like;
                    $reviewLike->save();
                }
            }
            return true;
        }
        return false;
    }

}