<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = ['user_id', 'title', 'content', 'note_color', 'is_pinned', 'pinned_at', 'is_locked', 'note_password'];

    protected $casts = [
        'is_pinned' => 'boolean',
        'is_locked' => 'boolean',
    ];

    public function labels()
    {
        return $this->belongsToMany(Label::class, 'note_label');
    }
}