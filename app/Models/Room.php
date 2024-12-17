<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    use HasFactory;

    protected $fillable = ['room_code', 'active', 'admin_id', 'game_end_at'];

    public function users()
    {
        return $this->hasMany(User::class, 'room_id', 'id');
    }

    public function animals()
    {
        return $this->belongsToMany(Animal::class, 'room_animal');
    }

    public function assignRandomAnimals($count)
    {
        $randomAnimals = Animal::inRandomOrder()->take($count)->pluck('id');
        $this->animals()->sync($randomAnimals);
    }
}
