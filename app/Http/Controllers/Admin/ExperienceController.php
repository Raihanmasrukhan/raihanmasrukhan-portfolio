<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Experience;
use Illuminate\Http\Request;

class ExperienceController extends Controller
{
    /**
     * Display a listing of experiences.
     */
    public function index()
    {
        $experiences = Experience::orderBy('sort_order')->get();

        return view('admin.experiences.index', compact('experiences'));
    }

    /**
     * Show form for creating a new experience.
     */
    public function create()
    {
        return view('admin.experiences.create');
    }

    /**
     * Store a newly created experience.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'role' => 'required|string|max:150',
            'company' => 'required|string|max:150',
            'date_span' => 'required|string|max:100',
            'description' => 'required|string|max:2000',
            'badges_text' => 'nullable|string',
            'sort_order' => 'nullable|integer',
            'is_current' => 'nullable|boolean',
        ]);

        $badges = [];
        if (! empty($validated['badges_text'])) {
            $tags = explode(',', str_replace(["\r", "\n"], ',', $validated['badges_text']));
            $badges = array_values(array_filter(array_map('trim', $tags)));
        }

        Experience::create([
            'role' => $validated['role'],
            'company' => $validated['company'],
            'date_span' => $validated['date_span'],
            'description' => $validated['description'],
            'badges' => $badges,
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_current' => $request->has('is_current'),
        ]);

        return redirect()->route('admin.experiences.index')
            ->with('success', 'Pengalaman kerja berhasil ditambahkan!');
    }

    /**
     * Show form for editing experience.
     */
    public function edit(Experience $experience)
    {
        return view('admin.experiences.edit', compact('experience'));
    }

    /**
     * Update experience.
     */
    public function update(Request $request, Experience $experience)
    {
        $validated = $request->validate([
            'role' => 'required|string|max:150',
            'company' => 'required|string|max:150',
            'date_span' => 'required|string|max:100',
            'description' => 'required|string|max:2000',
            'badges_text' => 'nullable|string',
            'sort_order' => 'nullable|integer',
            'is_current' => 'nullable|boolean',
        ]);

        if (isset($validated['badges_text'])) {
            $tags = explode(',', str_replace(["\r", "\n"], ',', $validated['badges_text']));
            $experience->badges = array_values(array_filter(array_map('trim', $tags)));
        }

        $experience->role = $validated['role'];
        $experience->company = $validated['company'];
        $experience->date_span = $validated['date_span'];
        $experience->description = $validated['description'];
        $experience->sort_order = $validated['sort_order'] ?? 0;
        $experience->is_current = $request->has('is_current');
        $experience->save();

        return redirect()->route('admin.experiences.index')
            ->with('success', 'Pengalaman kerja berhasil diperbarui!');
    }

    /**
     * Delete experience.
     */
    public function destroy(Experience $experience)
    {
        $experience->delete();

        return redirect()->route('admin.experiences.index')
            ->with('success', 'Pengalaman kerja berhasil dihapus!');
    }
}
