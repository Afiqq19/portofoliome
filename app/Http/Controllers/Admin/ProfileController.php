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
            'resume' => 'nullable|file|mimes:pdf|max:5120',
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
        $validated = $request->validate([
            'links' => 'array',
            'links.*.platform' => 'required|string|max:50',
            'links.*.url' => 'required|url|max:500',
            'links.*.icon' => 'nullable|string|max:100',
        ]);

        $profile = Profile::first();

        // Delete existing and recreate
        $profile->socialLinks()->delete();

        foreach ($validated['links'] ?? [] as $index => $link) {
            $profile->socialLinks()->create([
                'platform' => $link['platform'],
                'url' => $link['url'],
                'icon' => $link['icon'] ?? null,
                'order' => $index,
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
        $profile = Profile::first();
        
        $profile->update([
            'enable_skills' => $request->has('enable_skills'),
            'enable_projects' => $request->has('enable_projects'),
            'enable_certificates' => $request->has('enable_certificates'),
        ]);

        return back()->with('success', 'Pengaturan tampilan berhasil diperbarui! 🎨');
    }
}
