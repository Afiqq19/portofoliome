<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\SocialLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        $profile = Profile::with('socialLinks')->first();
        if (!$profile) {
            $profile = Profile::create(['name' => 'Your Name']);
        }

        return view('admin.profile.edit', compact('profile'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'location' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|max:10240',
            'resume' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        $profile = Profile::first();

        if ($request->hasFile('avatar')) {
            if ($profile->avatar) {
                Storage::disk('public')->delete($profile->avatar);
            }
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        if ($request->hasFile('resume')) {
            if ($profile->resume_path) {
                Storage::disk('public')->delete($profile->resume_path);
            }
            $validated['resume_path'] = $request->file('resume')->store('resumes', 'public');
        }

        $profile->update($validated);

        return back()->with('success', 'Profil berhasil diperbarui! ✅');
    }

    public function updateSocialLinks(Request $request)
    {
        $request->validate([
            'platforms' => 'array',
            'platforms.*' => 'required|string|max:50',
            'urls' => 'array',
            'urls.*' => 'nullable|url|max:500',
            'icons' => 'array',
            'icons.*' => 'nullable|string|max:100',
        ]);

        $profile = Profile::first();

        $platforms = $request->input('platforms', []);
        $urls = $request->input('urls', []);
        $icons = $request->input('icons', []);

        // Delete existing and recreate
        $profile->socialLinks()->delete();

        $order = 0;
        foreach ($platforms as $index => $platform) {
            $url = $urls[$index] ?? '';
            $icon = $icons[$index] ?? null;

            // Skip entries with empty URL
            if (empty(trim($url))) {
                continue;
            }

            $profile->socialLinks()->create([
                'platform' => $platform,
                'url' => $url,
                'icon' => $icon,
                'order' => $order++,
            ]);
        }

        return back()->with('success', 'Social links berhasil diperbarui! ✅');
    }

    public function editSettings()
    {
        $profile = Profile::first();
        if (!$profile) {
            $profile = Profile::create(['name' => 'Your Name']);
        }
        return view('admin.settings.index', compact('profile'));
    }

    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'trakteer_url' => 'nullable|url|max:255',
            'google_analytics_id' => 'nullable|string|max:50',
        ]);

        $profile = Profile::first();
        
        $profile->update([
            'enable_skills' => $request->has('enable_skills'),
            'enable_projects' => $request->has('enable_projects'),
            'enable_certificates' => $request->has('enable_certificates'),
            'trakteer_url' => $validated['trakteer_url'],
            'google_analytics_id' => $validated['google_analytics_id'],
        ]);

        return back()->with('success', 'Pengaturan tampilan berhasil diperbarui! 🎨');
    }

    public function deleteResume()
    {
        $profile = Profile::first();

        if ($profile && $profile->resume_path) {
            if (Storage::disk('public')->exists($profile->resume_path)) {
                Storage::disk('public')->delete($profile->resume_path);
            }
            $profile->update(['resume_path' => null]);
        }

        return back()->with('success', 'File CV berhasil dihapus! 🗑️');
    }
}
