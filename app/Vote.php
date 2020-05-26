<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model {
    protected $table = 'votes';
    protected $guarded = [];

    public function getCreatedAtAttribute($value) {
        return \Carbon\Carbon::parse($value)->format('d-m-Y H:i');
    }

    public function category() {
        return $this->belongsTo('App\Category');
    }

    public function poll() {
        return $this->belongsTo('App\Poll', 'poll_id', 'id');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }
}
