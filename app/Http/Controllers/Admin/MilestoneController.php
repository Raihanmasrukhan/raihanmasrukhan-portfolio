<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Milestone;
use Illuminate\Http\Request;

class MilestoneController extends Controller
{
    public function index()
    {
        $milestones = Milestone::orderBy('sort_order')->get();

        return view('admin.milestones.index', compact('milestones'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'organization' => 'required|string|max:150',
            'project_name' => 'required|string|max:200',
            'tech_stack' => 'required|string|max:150',
            'period' => 'required|string|max:100',
            'sort_order' => 'nullable|integer',
        ]);

        Milestone::create($validated);

        return redirect()->route('admin.milestones.index')->with('success', 'Milestone track record berhasil ditambahkan!');
    }

    public function update(Request $request, Milestone $milestone)
    {
        $validated = $request->validate([
            'organization' => 'required|string|max:150',
            'project_name' => 'required|string|max:200',
            'tech_stack' => 'required|string|max:150',
            'period' => 'required|string|max:100',
            'sort_order' => 'nullable|integer',
        ]);

        $milestone->update($validated);

        return redirect()->route('admin.milestones.index')->with('success', 'Milestone track record berhasil diperbarui!');
    }

    public function destroy(Milestone $milestone)
    {
        $milestone->delete();

        return redirect()->route('admin.milestones.index')->with('success', 'Milestone track record berhasil dihapus!');
    }
}
