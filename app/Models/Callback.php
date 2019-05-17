<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Mail;
use DB;

class Callback extends Model
{

    protected $table = 'callbacks';
    protected $fillable = [
        'phone',
        'type',
        'message',
        'email',
        'status',
        'comment'
	];

    public function scopeSearch($query, $search){
        $search = trim(mb_strtolower($search));
        if($search)
        {
            $query->Where(   DB::raw('LOWER(phone)'), 'like', "%"  . $search . "%");
            $query->OrWhere( DB::raw('LOWER(type)'),  'like', "%"  . $search . "%");
            $query->OrWhere( DB::raw('LOWER(message)'),  'like', "%"  . $search . "%");
            $query->OrWhere( DB::raw('LOWER(email)'),  'like', "%"  . $search . "%");
        }
        return $query;
    }

    protected static function boot()
    {
        parent::boot();

        //Событие после
        static::Created(function ($modal) {

            if(env('APP_TEST') == 0)
            {
                $subject = env('APP_NAME') . ' - ' . $modal->type;
                Mail::send('mails.callback', ['data' => $modal, 'subject' => $subject], function ($m) use ($subject) {
                    $m->to(env('MAIL_ADMIN'))->subject($subject);
                });
            }
        });

    }


}
