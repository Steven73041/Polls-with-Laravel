<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Poll extends Model {
    protected $guarded = [];
    protected $table = 'polls';

    public function votes() {
        return $this->hasMany('App\Vote', 'poll_id', 'id');
    }

    public function getCreatedAtAttribute($value) {
        return \Carbon\Carbon::parse($value)->format('d-m-Y H:i');
    }

    public function category() {
        return $this->belongsTo('App\Category', 'category_id', 'id');
    }
}
