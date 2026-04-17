<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerProfile extends Model
{
    protected $primaryKey = 'user_id';
    public $incrementing = false;

    protected $fillable = ['user_id', 'total_exp', 'level'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
