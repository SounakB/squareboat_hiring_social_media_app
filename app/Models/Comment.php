<?php


namespace App;


class Comment extends \Illuminate\Database\Eloquent\Model
{
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function post()
    {
        return $this->belongsTo('App\Post');
    }
}