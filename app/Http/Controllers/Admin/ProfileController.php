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
            'urls.*' => 'nullable|string|max:500',
            'icons' => 'array',
            'icons.*' => 'nullable|string|max:100',
        ]);

        $profile = Profile::first();
        if (!$profile) {
            $profile = Profile::create(['name' => 'Admin']);
        }

        $platforms = $request->input('platforms', []);
        $urls = $request->input('urls', []);
        $icons = $request->input('icons', []);

        // Delete existing and recreate
        $profile->socialLinks()->delete();

        $order = 0;
        foreach ($platforms as $index => $platform) {
            $rawUrl = trim($urls[$index] ?? '');
            $icon = $icons[$index] ?? null;

            if (empty($rawUrl)) {
                continue;
            }

            // Smart URL Formatter
            $url = $rawUrl;
            $platformLower = strtolower($platform);

            if ($platformLower === 'whatsapp') {
                // Bersihkan karakter selain angka
                $cleanPhone = preg_replace('/[^0-9]/', '', $rawUrl);
                if (str_starts_with($cleanPhone, '0')) {
                    $cleanPhone = '62' . substr($cleanPhone, 1);
                } elseif (!str_starts_with($cleanPhone, '62') && strlen($cleanPhone) >= 9) {
                    $cleanPhone = '62' . $cleanPhone;
                }

                if (!str_contains($rawUrl, 'wa.me') && !str_contains($rawUrl, 'whatsapp.com')) {
                    $url = "https://wa.me/{$cleanPhone}";
                } elseif (!str_starts_with($rawUrl, 'http://') && !str_starts_with($rawUrl, 'https://')) {
                    $url = 'https://' . ltrim($rawUrl, '/');
                }
            } else {
                // Untuk Instagram, GitHub, LinkedIn, YouTube, dll.
                if (!str_starts_with($rawUrl, 'http://') && !str_starts_with($rawUrl, 'https://')) {
                    $cleanHandle = ltrim($rawUrl, '@');
                    if (!str_contains($cleanHandle, '.')) {
                        // Jika hanya menginput username (misal: "Afiqq19")
                        $url = match($platformLower) {
                            'github' => "https://github.com/{$cleanHandle}",
                            'instagram' => "https://instagram.com/{$cleanHandle}",
                            'linkedin' => "https://linkedin.com/in/{$cleanHandle}",
                            'youtube' => "https://youtube.com/@{$cleanHandle}",
                            default => "https://{$cleanHandle}",
                        };
                    } else {
                        // Jika menginput domain (misal: "instagram.com/afiqq")
                        $url = 'https://' . $cleanHandle;
                    }
                }
            }

            $profile->socialLinks()->create([
                'platform' => $platform,
                'url' => $url,
                'icon' => $icon,
                'order' => $order++,
            ]);
        }

        return back()->with('success', 'Tautan media sosial berhasil disimpan! ✅');
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
            'maintenance_status' => 'nullable|string|in:maintenance,coming_soon,custom',
            'maintenance_title' => 'nullable|string|max:255',
            'maintenance_message' => 'nullable|string|max:1000',
        ]);

        $profile = Profile::first();
        if (!$profile) {
            $profile = Profile::create(['name' => 'Your Name']);
        }
        
        $profile->update([
            'enable_landing_page' => $request->has('enable_landing_page'),
            'maintenance_status' => $validated['maintenance_status'] ?? 'maintenance',
            'maintenance_title' => $validated['maintenance_title'],
            'maintenance_message' => $validated['maintenance_message'],
            'enable_skills' => $request->has('enable_skills'),
            'enable_projects' => $request->has('enable_projects'),
            'enable_certificates' => $request->has('enable_certificates'),
            'enable_estimator' => $request->has('enable_estimator'),
            'enable_architecture' => $request->has('enable_architecture'),
            'enable_ai_assistant' => $request->has('enable_ai_assistant'),
            'trakteer_url' => $validated['trakteer_url'],
            'google_analytics_id' => $validated['google_analytics_id'],
        ]);

        $statusMsg = $request->has('enable_landing_page')
            ? 'Pengaturan tampilan berhasil diperbarui! (Landing Page Aktif) 🎨'
            : 'Pengaturan tampilan berhasil diperbarui! (Mode Pemeliharaan Aktif) ⚠️';

        return back()->with('success', $statusMsg);
    }

    public function previewMaintenance()
    {
        $profile = Profile::with('socialLinks')->first();
        return view('errors.maintenance', [
            'profile' => $profile,
            'title' => $profile->maintenance_title ?: 'Sistem Sedang Dalam Pemeliharaan & Pembaruan',
            'message' => $profile->maintenance_message ?: 'Website portofolio kami sedang dalam proses perbaruan karya dan peningkatan fitur terbaru untuk menghadirkan pengalaman terbaik. Kami akan segera kembali online!',
            'status' => $profile->maintenance_status ?: 'maintenance',
            'isPreview' => true,
        ]);
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
