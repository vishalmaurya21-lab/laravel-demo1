<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AllUsers extends Model
{
    protected $table = 'all_users';
    protected $fillable = ['name', 'email', 'password']; // ✅ Fixed typo: 'passeord' → 'password'

    public function posts()
    {
        return $this->hasMany(Posts::class, 'user_id');
    }
}