<?php

namespace App\Models;

use App\Models\AllUsers;
use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    // ✅ Added 'image' to fillable
    protected $fillable = ['user_id', 'title', 'content', 'image'];

    public function allUsers()
    {
        return $this->belongsTo(AllUsers::class, 'user_id');
    }
}
