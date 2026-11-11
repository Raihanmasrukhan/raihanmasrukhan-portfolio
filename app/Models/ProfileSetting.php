<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileSetting extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'hero_specialties' => 'array',
        'is_available' => 'boolean',
    ];

    /**
     * Get or create the singleton profile setting record.
     */
    public static function current(): self
    {
        return static::firstOrCreate([], [
            'full_name' => 'Raihan Adib Masrukhan',
            'hero_title_line1' => 'RAIHAN',
            'hero_title_prefix' => 'MAS',
            'hero_title_suffix' => 'RUKHAN',
            'headline' => 'Software Engineer & Full-Stack Web Developer',
            'sub_headline' => 'Software Engineer & Full-Stack Web Developer. Transforming complex business logic into high-performance web applications, scalable SaaS systems, and intuitive digital experiences.',
            'location' => 'Based in Depok & Bogor, ID',
            'availability_status' => 'Available for Projects',
            'is_available' => true,
            'avatar' => 'images/hero.jpg',
            'hero_specialties' => [
                'Full-Stack Web Dev',
                'SaaS Architecture',
                'Laravel & React Ecosystem',
                'Geofencing & PWA Systems',
                'Creative UI/UX Engineering',
            ],
            'about_statement' => 'I build <span class="text-bold">production-grade web platforms</span> and <span class="text-highlight">robust SaaS systems</span> that empower businesses and communities. Every solution begins with a <span class="text-bold">clean architectural foundation</span>, <span class="text-highlight">intuitive UI/UX</span>, and <span class="text-bold">rock-solid reliability</span> throughout.',
            'phone' => '+62 858-6445-9552',
            'whatsapp_number' => '6285864459552',
            'email' => 'Raihanmasrukhan56@gmail.com',
            'github_url' => 'https://github.com/Raihanmasrukhan',
            'linkedin_url' => 'https://www.linkedin.com/in/raihan-masrukhan-22626b316/',
        ]);
    }
}
