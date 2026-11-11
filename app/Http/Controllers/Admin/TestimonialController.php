<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    /**
     * Display a listing of client testimonials.
     */
    public function index(Request $request)
    {
        $query = Testimonial::orderByDesc('is_pinned')->latest();

        if ($request->has('filter')) {
            if ($request->filter === 'draft') {
                $query->where('is_approved', false);
            } elseif ($request->filter === 'published') {
                $query->where('is_approved', true);
            } elseif ($request->filter === 'featured') {
                $query->where('is_pinned', true);
            }
        }

        $testimonials = $query->paginate(20)->withQueryString();
        $draftCount = Testimonial::where('is_approved', false)->count();

        return view('admin.testimonials.index', compact('testimonials', 'draftCount'));
    }

    /**
     * Store a newly created client testimonial.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:120',
            'role_title' => 'nullable|string|max:120',
            'company' => 'nullable|string|max:150',
            'project_tag' => 'nullable|string|max:120',
            'message' => 'required|string|min:5|max:1500',
            'rating' => 'nullable|integer|between:1,5',
            'is_approved' => 'nullable|boolean',
            'is_pinned' => 'nullable|boolean',
        ]);

        $colors = ['#ff5500', '#ff8800', '#10b981', '#3b82f6', '#8b5cf6', '#f59e0b'];

        Testimonial::create([
            'name' => $validated['name'],
            'role_title' => $validated['role_title'] ?? null,
            'company' => $validated['company'] ?? null,
            'project_tag' => $validated['project_tag'] ?? null,
            'message' => $validated['message'],
            'rating' => $validated['rating'] ?? 5,
            'avatar_color' => $colors[array_rand($colors)],
            'is_approved' => $request->has('is_approved'),
            'is_pinned' => $request->has('is_pinned'),
        ]);

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimoni klien berhasil ditambahkan!');
    }

    /**
     * Update an existing client testimonial.
     */
    public function update(Request $request, Testimonial $testimonial)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:120',
            'role_title' => 'nullable|string|max:120',
            'company' => 'nullable|string|max:150',
            'project_tag' => 'nullable|string|max:120',
            'message' => 'required|string|min:5|max:1500',
            'rating' => 'nullable|integer|between:1,5',
        ]);

        $testimonial->update([
            'name' => $validated['name'],
            'role_title' => $validated['role_title'] ?? null,
            'company' => $validated['company'] ?? null,
            'project_tag' => $validated['project_tag'] ?? null,
            'message' => $validated['message'],
            'rating' => $validated['rating'] ?? $testimonial->rating,
        ]);

        return redirect()->route('admin.testimonials.index')
            ->with('success', "Testimoni dari {$testimonial->name} berhasil diperbarui!");
    }

    /**
     * Toggle published status of a testimonial.
     */
    public function toggleApproval(Testimonial $testimonial)
    {
        $testimonial->is_approved = ! $testimonial->is_approved;
        $testimonial->save();

        $status = $testimonial->is_approved ? 'dipublikasikan ke' : 'disembunyikan (draft) dari';

        return back()->with('success', "Testimoni dari {$testimonial->name} berhasil {$status} halaman utama.");
    }

    /**
     * Toggle featured/pinned status of a testimonial.
     */
    public function togglePin(Testimonial $testimonial)
    {
        $testimonial->is_pinned = ! $testimonial->is_pinned;
        $testimonial->save();

        $status = $testimonial->is_pinned ? 'ditandai sebagai Featured Endorsement' : 'dilepas dari Featured';

        return back()->with('success', "Testimoni dari {$testimonial->name} berhasil {$status}.");
    }

    /**
     * Delete a testimonial.
     */
    public function destroy(Testimonial $testimonial)
    {
        $name = $testimonial->name;
        $testimonial->delete();

        return back()->with('success', "Testimoni dari {$name} telah dihapus.");
    }
}

