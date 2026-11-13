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

    public function isDesign(): bool
    {
        return $this->category === 'design';
    }

    public function isVideo(): bool
    {
        return $this->category === 'video-editing';
    }

    /**
     * Extract responsive iframe embed URL for YouTube or Vimeo.
     */
    public function youtubeEmbedUrl(): ?string
    {
        $url = $this->video_url ?? ($this->isVideo() ? $this->live_url : null);
        if (empty($url)) {
            return null;
        }

        // Match YouTube URL formats
        if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?|shorts)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/i', $url, $matches)) {
            return 'https://www.youtube-nocookie.com/embed/'.$matches[1];
        }

        // Match Vimeo URL formats
        if (preg_match('/vimeo\.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|)(\d+)(?:|\/\?)/i', $url, $matches)) {
            return 'https://player.vimeo.com/video/'.$matches[2];
        }

        return null;
    }
}
