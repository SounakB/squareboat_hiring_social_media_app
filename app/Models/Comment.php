<?php


namespace App\Models;


class Comment extends \Illuminate\Database\Eloquent\Model
{
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function post()
    {
        return $this->belongsTo('App\Models\Post');
    }
}
