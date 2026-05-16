<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = ['user_id', 'title', 'content', 'img',];

    protected $casts = [
        'is_pinned' => 'boolean',
    ];
}