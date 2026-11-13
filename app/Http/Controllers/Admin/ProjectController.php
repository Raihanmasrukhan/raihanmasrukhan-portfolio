<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{
    /**
     * Display a listing of projects.
     */
    public function index(Request $request)
    {
        $categoryOptions = Project::categoryOptions();
        $activeCategory = $request->query('category', 'all');

        $query = Project::orderBy('sort_order')->latest('id');
        if ($activeCategory !== 'all' && array_key_exists($activeCategory, $categoryOptions)) {
            $query->where('category', $activeCategory);
        } else {
            $activeCategory = 'all';
        }

        $projects = $query->paginate(15)->withQueryString();

        return view('admin.projects.index', compact('projects', 'activeCategory', 'categoryOptions'));
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
    public function store(Request $request, ImageUploadService $imageUploadService)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'category' => ['required', 'string', 'max:50', Rule::in(array_keys(Project::categoryOptions()))],
            'badge' => 'nullable|string|max:100',
            'client' => 'nullable|string|max:150',
            'role' => 'nullable|string|max:150',
            'timeline' => 'nullable|string|max:100',
            'overview' => 'required|string',
            'highlights_text' => 'nullable|string',
            'tech_stack_text' => 'nullable|string',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:25600',
            'live_url' => 'nullable|url|max:255',
            'github_url' => 'nullable|url|max:255',
            'video_url' => 'nullable|url|max:255',
            'video_duration' => 'nullable|string|max:50',
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

        // Image upload (auto-compressed to max 5MB if oversized)
        $imagePath = 'images/project-saas.jpg';
        if ($request->hasFile('image_file')) {
            $imagePath = $imageUploadService->storeCompressedImage(
                $request->file('image_file'),
                'project',
                ImageUploadService::MAX_SIZE_BYTES,
                'image_file'
            );
        }

        $payload = [
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
            'video_url' => $validated['video_url'] ?? null,
            'video_duration' => $validated['video_duration'] ?? null,
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_featured' => $request->has('is_featured'),
        ];

        Project::create($payload);

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
    public function update(Request $request, Project $project, ImageUploadService $imageUploadService)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'category' => ['required', 'string', 'max:50', Rule::in(array_keys(Project::categoryOptions()))],
            'badge' => 'nullable|string|max:100',
            'client' => 'nullable|string|max:150',
            'role' => 'nullable|string|max:150',
            'timeline' => 'nullable|string|max:100',
            'overview' => 'required|string',
            'highlights_text' => 'nullable|string',
            'tech_stack_text' => 'nullable|string',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:25600',
            'live_url' => 'nullable|url|max:255',
            'github_url' => 'nullable|url|max:255',
            'video_url' => 'nullable|url|max:255',
            'video_duration' => 'nullable|string|max:50',
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

        // Image upload (auto-compressed to max 5MB if oversized)
        if ($request->hasFile('image_file')) {
            $project->image = $imageUploadService->storeCompressedImage(
                $request->file('image_file'),
                'project',
                ImageUploadService::MAX_SIZE_BYTES,
                'image_file'
            );
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
        $project->video_url = $validated['video_url'] ?? null;
        $project->video_duration = $validated['video_duration'] ?? null;
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
