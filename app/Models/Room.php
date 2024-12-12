<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    use HasFactory;

    protected $fillable = ['room_code', 'active', 'admin_id'];

    public function users()
    {
        return $this->hasMany(User::class, 'room_id', 'id');
    }
}
