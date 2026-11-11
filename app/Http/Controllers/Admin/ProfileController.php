<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProfileSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Show profile & general site settings form.
     */
    public function index()
    {
        $profile = ProfileSetting::current();
        $user = Auth::user();

        return view('admin.profile.index', compact('profile', 'user'));
    }

    /**
     * Update profile and site settings.
     */
    public function update(Request $request)
    {
        $profile = ProfileSetting::current();

        $validated = $request->validate([
            'full_name' => 'required|string|max:150',
            'hero_title_line1' => 'required|string|max:100',
            'hero_title_prefix' => 'required|string|max:50',
            'hero_title_suffix' => 'required|string|max:50',
            'headline' => 'required|string|max:200',
            'sub_headline' => 'nullable|string|max:1000',
            'location' => 'required|string|max:150',
            'availability_status' => 'required|string|max:100',
            'is_available' => 'nullable|boolean',
            'about_statement' => 'required|string|max:2000',
            'hero_specialties_text' => 'nullable|string',
            'phone' => 'required|string|max:50',
            'whatsapp_number' => 'required|string|max:50',
            'email' => 'required|email|max:100',
            'github_url' => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255',
            'cv_url' => 'nullable|string|max:255',
            'avatar_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        // Process Specialties pills list
        if (! empty($validated['hero_specialties_text'])) {
            $specialties = array_filter(array_map('trim', explode("\n", $validated['hero_specialties_text'])));
            $profile->hero_specialties = array_values($specialties);
        }

        // Process personal photo upload
        if ($request->hasFile('avatar_file')) {
            $file = $request->file('avatar_file');
            $fileName = 'hero_'.time().'.'.$file->getClientOriginalExtension();
            $file->storeAs('images', $fileName, 'public');
            $profile->avatar = 'storage/images/'.$fileName;
        }

        $profile->full_name = $validated['full_name'];
        $profile->hero_title_line1 = $validated['hero_title_line1'];
        $profile->hero_title_prefix = $validated['hero_title_prefix'];
        $profile->hero_title_suffix = $validated['hero_title_suffix'];
        $profile->headline = $validated['headline'];
        $profile->sub_headline = $validated['sub_headline'];
        $profile->location = $validated['location'];
        $profile->availability_status = $validated['availability_status'];
        $profile->is_available = $request->has('is_available');
        $profile->about_statement = $validated['about_statement'];
        $profile->phone = $validated['phone'];
        $profile->whatsapp_number = $validated['whatsapp_number'];
        $profile->email = $validated['email'];
        $profile->github_url = $validated['github_url'] ?? null;
        $profile->linkedin_url = $validated['linkedin_url'] ?? null;
        $profile->instagram_url = $validated['instagram_url'] ?? null;
        $profile->cv_url = $validated['cv_url'] ?? null;
        $profile->save();

        // Optional password update for logged in user
        if ($request->filled('new_password')) {
            $request->validate([
                'new_password' => 'min:6|confirmed',
            ]);
            $user = Auth::user();
            $user->password = Hash::make($request->new_password);
            $user->save();
        }

        return redirect()->route('admin.profile.index')
            ->with('success', 'Profil dan pengaturan portfolio berhasil diperbarui!');
    }
}
