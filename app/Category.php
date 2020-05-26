<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {

    protected $table = 'categories';
    protected $guarded = [];

    public function users() {
        return $this->belongsToMany('App\User');
    }

    public function polls() {
        return $this->hasMany('App\Poll', 'category_id', 'id');
    }
}
