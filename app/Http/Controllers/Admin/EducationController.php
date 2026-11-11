<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Education;
use Illuminate\Http\Request;

class EducationController extends Controller
{
    /**
     * Display a listing of education history.
     */
    public function index()
    {
        $educations = Education::orderBy('sort_order')->get();

        return view('admin.educations.index', compact('educations'));
    }

    /**
     * Show form for creating new education.
     */
    public function create()
    {
        return view('admin.educations.create');
    }

    /**
     * Store newly created education.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'school' => 'required|string|max:150',
            'degree' => 'required|string|max:150',
            'period' => 'required|string|max:100',
            'notes' => 'nullable|string|max:1000',
            'sort_order' => 'nullable|integer',
        ]);

        Education::create($validated);

        return redirect()->route('admin.educations.index')
            ->with('success', 'Riwayat pendidikan berhasil ditambahkan!');
    }

    /**
     * Show form for editing education.
     */
    public function edit(Education $education)
    {
        return view('admin.educations.edit', compact('education'));
    }

    /**
     * Update education.
     */
    public function update(Request $request, Education $education)
    {
        $validated = $request->validate([
            'school' => 'required|string|max:150',
            'degree' => 'required|string|max:150',
            'period' => 'required|string|max:100',
            'notes' => 'nullable|string|max:1000',
            'sort_order' => 'nullable|integer',
        ]);

        $education->update($validated);

        return redirect()->route('admin.educations.index')
            ->with('success', 'Riwayat pendidikan berhasil diperbarui!');
    }

    /**
     * Delete education.
     */
    public function destroy(Education $education)
    {
        $education->delete();

        return redirect()->route('admin.educations.index')
            ->with('success', 'Riwayat pendidikan berhasil dihapus!');
    }
}
