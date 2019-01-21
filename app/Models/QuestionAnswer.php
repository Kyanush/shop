<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Mail;

class QuestionAnswer extends Model
{

    protected $table = 'questions_answers';
    protected $fillable = [
        'name',
        'email',
        'question',
        'answer',
        'product_id',
        'created_at',
        'active'
    ];


    public function scopeIsActive($query){
        return $query->where('active', 1);
    }

    public function scopeNoActive($query){
        return $query->where('active', 0);
    }

    public function product()
    {
        return $this->hasOne('App\Models\Product', 'id', 'product_id');
    }

    protected static function boot()
    {
        parent::boot();

        //Событие после
        static::Created(function ($modal) {

            if(env('APP_TEST') == 0)
            {
                //вопрос
                $subject = env('APP_NAME') . ' - ' . 'Вопрос-ответ';
                Mail::send('mails.write_question', ['data' => $modal, 'subject' => $subject], function($m) use($subject)
                {
                    $m->to(env('MAIL_ADMIN'))->subject($subject);
                });
            }

        });

        //Событие после
        static::saved(function($modal) {
            if(env('APP_TEST') == 0)
            {
                //ответ к вопросу
                if ($modal->answer and $modal->email) {
                    $subject = env('APP_NAME') . ' - ' . 'Ответы на ваши вопросы';
                    Mail::send('mails.answer_question', ['data' => $modal, 'subject' => $subject], function ($m) use ($subject, $modal) {
                        $m->to($modal->email)->subject($subject);
                    });
                }
            }

        });
    }

    public function scopeSearch($query, $search){
        $search = trim(mb_strtolower($search));
        if($search)
        {
            $query->Where(   DB::raw('LOWER(name)'),     'like', "%"  . $search . "%");
            $query->OrWhere( DB::raw('LOWER(email)'),    'like', "%"  . $search . "%");
            $query->OrWhere( DB::raw('LOWER(question)'), 'like', "%"  . $search . "%");
            $query->OrWhere( DB::raw('LOWER(answer)'),   'like', "%"  . $search . "%");
        }
        return $query;
    }

}