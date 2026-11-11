<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'badges' => 'array',
        'is_current' => 'boolean',
    ];
}
