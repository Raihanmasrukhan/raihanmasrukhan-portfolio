<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::orderBy('sort_order')->get();

        return view('admin.services.index', compact('services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'number_label' => 'required|string|max:50',
            'title' => 'required|string|max:150',
            'description' => 'required|string|max:1000',
            'tags_text' => 'nullable|string',
            'sort_order' => 'nullable|integer',
        ]);

        $tags = [];
        if (! empty($validated['tags_text'])) {
            $tags = array_values(array_filter(array_map('trim', explode(',', $validated['tags_text']))));
        }

        Service::create([
            'number_label' => $validated['number_label'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'tags' => $tags,
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        return redirect()->route('admin.services.index')->with('success', 'Layanan berhasil ditambahkan!');
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'number_label' => 'required|string|max:50',
            'title' => 'required|string|max:150',
            'description' => 'required|string|max:1000',
            'tags_text' => 'nullable|string',
            'sort_order' => 'nullable|integer',
        ]);

        if (isset($validated['tags_text'])) {
            $service->tags = array_values(array_filter(array_map('trim', explode(',', $validated['tags_text']))));
        }

        $service->number_label = $validated['number_label'];
        $service->title = $validated['title'];
        $service->description = $validated['description'];
        $service->sort_order = $validated['sort_order'] ?? 0;
        $service->save();

        return redirect()->route('admin.services.index')->with('success', 'Layanan berhasil diperbarui!');
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->route('admin.services.index')->with('success', 'Layanan berhasil dihapus!');
    }
}
