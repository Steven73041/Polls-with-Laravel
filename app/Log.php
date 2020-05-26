<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model {
    protected $table = 'logs';
    protected $guarded = [];

    public function getCreatedAtAttribute($value) {
        return \Carbon\Carbon::parse($value)->format('d-m-Y H:i');
    }

    public function user(){
        return $this->hasOne('App\User','id', 'user_id');
    }

}
