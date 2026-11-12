<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'highlights' => 'array',
        'tech_stack' => 'array',
        'is_featured' => 'boolean',
    ];

    /**
     * Supported project showcase categories across Admin and public portfolio.
     *
     * @return array<string, string>
     */
    public static function categoryOptions(): array
    {
        return [
            'saas' => 'SaaS Platforms',
            'enterprise' => 'Management Systems',
            'landing' => 'Landing & CMS',
            'design' => 'Desain & UI/UX',
            'video-editing' => 'Video Editing',
            'other' => 'Other Applications',
        ];
    }
}
