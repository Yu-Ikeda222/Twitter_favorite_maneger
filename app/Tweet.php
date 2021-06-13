<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    public function user() {
        return $this->belongsTo('App\User');
    }

    public function categories() {
        return $this->belongsToMany('App\Category');
    }

    protected $fillable = [
        'user_id', 'user_screen_name', 'tweet_id', 'oembed_url',
    ];
}
