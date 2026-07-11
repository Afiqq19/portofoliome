<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    public function index()
    {
        $profile = Profile::first();
        if (!$profile) {
            $profile = Profile::create(['name' => 'Your Name']);
        }
        
        return view('admin.donations.index', compact('profile'));
    }

    public function updateTrakteer(Request $request)
    {
        $validated = $request->validate([
            'trakteer_url' => 'nullable|url',
        ]);

        $profile = Profile::first();
        if ($profile) {
            $profile->update($validated);
        }

        return back()->with('success', 'Link Trakteer berhasil diperbarui! ☕');
    }
}
