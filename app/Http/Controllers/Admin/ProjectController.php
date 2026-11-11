<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    /**
     * Display a listing of projects.
     */
    public function index()
    {
        $projects = Project::orderBy('sort_order')->latest('id')->paginate(15);

        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new project.
     */
    public function create()
    {
        return view('admin.projects.create');
    }

    /**
     * Store a newly created project in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'category' => 'required|string|max:50',
            'badge' => 'nullable|string|max:100',
            'client' => 'nullable|string|max:150',
            'role' => 'nullable|string|max:150',
            'timeline' => 'nullable|string|max:100',
            'overview' => 'required|string',
            'highlights_text' => 'nullable|string',
            'tech_stack_text' => 'nullable|string',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'live_url' => 'nullable|url|max:255',
            'github_url' => 'nullable|url|max:255',
            'sort_order' => 'nullable|integer',
            'is_featured' => 'nullable|boolean',
        ]);

        $slug = Str::slug($validated['title']);
        $originalSlug = $slug;
        $counter = 1;
        while (Project::where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-".$counter++;
        }

        // Process highlights
        $highlights = [];
        if (! empty($validated['highlights_text'])) {
            $highlights = array_values(array_filter(array_map('trim', explode("\n", $validated['highlights_text']))));
        }

        // Process tech stack tags
        $techStack = [];
        if (! empty($validated['tech_stack_text'])) {
            $tags = explode(',', str_replace(["\r", "\n"], ',', $validated['tech_stack_text']));
            $techStack = array_values(array_filter(array_map('trim', $tags)));
        }

        // Image upload
        $imagePath = 'images/project-saas.jpg';
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $fileName = 'project_'.time().'_'.Str::random(5).'.'.$file->getClientOriginalExtension();
            $file->storeAs('images', $fileName, 'public');
            $imagePath = 'storage/images/'.$fileName;
        }

        Project::create([
            'title' => $validated['title'],
            'slug' => $slug,
            'category' => $validated['category'],
            'badge' => $validated['badge'] ?? null,
            'client' => $validated['client'] ?? null,
            'role' => $validated['role'] ?? null,
            'timeline' => $validated['timeline'] ?? null,
            'overview' => $validated['overview'],
            'highlights' => $highlights,
            'tech_stack' => $techStack,
            'image' => $imagePath,
            'live_url' => $validated['live_url'] ?? null,
            'github_url' => $validated['github_url'] ?? null,
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_featured' => $request->has('is_featured'),
        ]);

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project portfolio berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified project.
     */
    public function edit(Project $project)
    {
        return view('admin.projects.edit', compact('project'));
    }

    /**
     * Update the specified project in storage.
     */
    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'category' => 'required|string|max:50',
            'badge' => 'nullable|string|max:100',
            'client' => 'nullable|string|max:150',
            'role' => 'nullable|string|max:150',
            'timeline' => 'nullable|string|max:100',
            'overview' => 'required|string',
            'highlights_text' => 'nullable|string',
            'tech_stack_text' => 'nullable|string',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'live_url' => 'nullable|url|max:255',
            'github_url' => 'nullable|url|max:255',
            'sort_order' => 'nullable|integer',
            'is_featured' => 'nullable|boolean',
        ]);

        // Process highlights
        if (isset($validated['highlights_text'])) {
            $project->highlights = array_values(array_filter(array_map('trim', explode("\n", $validated['highlights_text']))));
        }

        // Process tech stack tags
        if (isset($validated['tech_stack_text'])) {
            $tags = explode(',', str_replace(["\r", "\n"], ',', $validated['tech_stack_text']));
            $project->tech_stack = array_values(array_filter(array_map('trim', $tags)));
        }

        // Image upload
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $fileName = 'project_'.time().'_'.Str::random(5).'.'.$file->getClientOriginalExtension();
            $file->storeAs('images', $fileName, 'public');
            $project->image = 'storage/images/'.$fileName;
        }

        $project->title = $validated['title'];
        $project->category = $validated['category'];
        $project->badge = $validated['badge'] ?? null;
        $project->client = $validated['client'] ?? null;
        $project->role = $validated['role'] ?? null;
        $project->timeline = $validated['timeline'] ?? null;
        $project->overview = $validated['overview'];
        $project->live_url = $validated['live_url'] ?? null;
        $project->github_url = $validated['github_url'] ?? null;
        $project->sort_order = $validated['sort_order'] ?? 0;
        $project->is_featured = $request->has('is_featured');
        $project->save();

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project portfolio berhasil diperbarui!');
    }

    /**
     * Remove the specified project from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project portfolio berhasil dihapus!');
    }
}
