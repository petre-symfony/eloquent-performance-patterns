<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model {
    use HasFactory;

    public function feature(){
        return $this->belongsTo(Feature::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
