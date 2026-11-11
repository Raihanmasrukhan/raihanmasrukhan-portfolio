<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'is_approved' => 'boolean',
        'is_pinned' => 'boolean',
        'rating' => 'integer',
    ];
}
