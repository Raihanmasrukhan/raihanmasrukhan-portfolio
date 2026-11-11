<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Education;
use App\Models\Experience;
use App\Models\ProfileSetting;
use App\Models\Project;
use App\Models\Skill;
use App\Models\Testimonial;
use App\Models\VisitorStat;

class DashboardController extends Controller
{
    /**
     * Show admin dashboard overview.
     */
    public function index()
    {
        $profile = ProfileSetting::current();

        $stats = [
            'projects' => Project::count(),
            'experiences' => Experience::count(),
            'educations' => Education::count(),
            'skills' => Skill::count(),
            'total_testimonials' => Testimonial::count(),
            'draft_testimonials' => Testimonial::where('is_approved', false)->count(),
            'total_messages' => ContactMessage::count(),
            'unread_messages' => ContactMessage::where('is_read', false)->count(),
            'total_views' => VisitorStat::count(),
            'today_views' => VisitorStat::whereDate('created_at', today())->count(),
        ];

        $recentMessages = ContactMessage::latest()->take(5)->get();
        $recentTestimonials = Testimonial::orderByDesc('is_pinned')->latest()->take(5)->get();
        $recentProjects = Project::orderBy('sort_order')->take(4)->get();

        return view('admin.dashboard', compact('profile', 'stats', 'recentMessages', 'recentTestimonials', 'recentProjects'));
    }
}
