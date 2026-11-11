<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    /**
     * Display a listing of skills.
     */
    public function index()
    {
        $skills = Skill::orderBy('category')->orderBy('sort_order')->get();

        return view('admin.skills.index', compact('skills'));
    }

    /**
     * Store a newly created skill.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'category' => 'required|string|in:web_app,database_arch,tools_cloud',
            'level' => 'nullable|string|max:50',
            'sort_order' => 'nullable|integer',
        ]);

        Skill::create($validated);

        return redirect()->route('admin.skills.index')
            ->with('success', 'Skill '.$validated['name'].' berhasil ditambahkan!');
    }

    /**
     * Update skill.
     */
    public function update(Request $request, Skill $skill)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'category' => 'required|string|in:web_app,database_arch,tools_cloud',
            'level' => 'nullable|string|max:50',
            'sort_order' => 'nullable|integer',
        ]);

        $skill->update($validated);

        return redirect()->route('admin.skills.index')
            ->with('success', 'Skill '.$skill->name.' berhasil diperbarui!');
    }

    /**
     * Delete skill.
     */
    public function destroy(Skill $skill)
    {
        $name = $skill->name;
        $skill->delete();

        return redirect()->route('admin.skills.index')
            ->with('success', 'Skill '.$name.' berhasil dihapus!');
    }
}
