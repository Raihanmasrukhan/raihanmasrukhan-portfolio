<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Milestone;
use App\Models\ProfileSetting;
use App\Models\Project;
use App\Models\Service;
use App\Models\Skill;
use App\Models\Testimonial;
use App\Models\VisitorStat;
use App\Models\WorkProcess;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    /**
     * Display the dynamic public portfolio page.
     */
    public function index()
    {
        $currentLocale = session('locale', 'id');
        app()->setLocale($currentLocale);

        $profile = ProfileSetting::current();
        $projects = Project::orderBy('sort_order')->get();
        $experiences = Experience::orderBy('sort_order')->get();
        $educations = Education::orderBy('sort_order')->get();
        $skillsByCategory = Skill::orderBy('sort_order')->get()->groupBy('category');
        $services = Service::orderBy('sort_order')->get();
        $processes = WorkProcess::orderBy('sort_order')->get();
        $milestones = Milestone::orderBy('sort_order')->get();
        $testimonials = Testimonial::where('is_approved', true)
            ->orderByDesc('is_pinned')
            ->latest()
            ->take(12)
            ->get();

        // Record visitor analytics
        try {
            VisitorStat::create([
                'ip_address' => request()->ip(),
                'page' => '/',
                'user_agent' => substr(request()->userAgent() ?? '', 0, 250),
            ]);
        } catch (\Throwable $e) {
            // silent fail for stats
        }

        return view('portfolio', compact(
            'profile',
            'projects',
            'experiences',
            'educations',
            'skillsByCategory',
            'services',
            'processes',
            'milestones',
            'testimonials',
            'currentLocale',
        ));
    }

    /**
     * Handle contact form inquiry submission.
     */
    public function submitContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email_or_phone' => 'required|string|max:150',
            'project_type' => 'nullable|string|max:150',
            'message' => 'required|string|min:5|max:2000',
        ]);

        ContactMessage::create($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Pesan Anda berhasil terkirim! Terima kasih telah menghubungi saya.',
            ]);
        }

        return redirect()->to(url()->previous().'#contact')
            ->with('success', 'Pesan Anda telah berhasil dikirim! Saya akan segera merespons.');
    }
}
