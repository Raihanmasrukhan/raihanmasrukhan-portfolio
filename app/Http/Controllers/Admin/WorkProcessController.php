<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WorkProcess;
use Illuminate\Http\Request;

class WorkProcessController extends Controller
{
    public function index()
    {
        $processes = WorkProcess::orderBy('sort_order')->get();

        return view('admin.processes.index', compact('processes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'step_number' => 'required|string|max:20',
            'title' => 'required|string|max:100',
            'description' => 'required|string|max:1000',
            'is_featured' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
        ]);

        WorkProcess::create([
            'step_number' => $validated['step_number'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'is_featured' => $request->has('is_featured'),
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        return redirect()->route('admin.processes.index')->with('success', 'Work process step berhasil ditambahkan!');
    }

    public function update(Request $request, WorkProcess $workProcess)
    {
        $validated = $request->validate([
            'step_number' => 'required|string|max:20',
            'title' => 'required|string|max:100',
            'description' => 'required|string|max:1000',
            'is_featured' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
        ]);

        $workProcess->update([
            'step_number' => $validated['step_number'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'is_featured' => $request->has('is_featured'),
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        return redirect()->route('admin.processes.index')->with('success', 'Work process step berhasil diperbarui!');
    }

    public function destroy(WorkProcess $workProcess)
    {
        $workProcess->delete();

        return redirect()->route('admin.processes.index')->with('success', 'Work process step berhasil dihapus!');
    }
}
