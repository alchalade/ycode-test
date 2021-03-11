<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function scopeWaiting()
    {
        return $this->oldest()->take(10)->get();
    }
}
