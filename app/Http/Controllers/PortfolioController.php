<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\ContactMessage;
use App\Models\Donation;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Skill;
use App\Models\Visitor;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PortfolioController extends Controller
{
    /**
     * Landing page - Public portfolio
     */
    public function index()
    {
        $profile = Profile::with('socialLinks')->first();
        $skills = Skill::orderBy('order')->get();
        
        $featuredProjects = Project::published()->where('is_featured', true)->orderBy('order')->take(6)->get();
        // Fallback jika tidak ada featured project
        if ($featuredProjects->isEmpty()) {
            $featuredProjects = Project::published()->orderBy('order')->take(6)->get();
        }
        
        $certificates = Certificate::published()->orderBy('order')->take(3)->get();
        $totalCertificates = Certificate::published()->count();

        $stats = [
            'projects' => Project::published()->count(),
            'downloads' => Project::sum('download_count'),
            'visitors' => Visitor::distinct('ip_address')->count(),
        ];

        $notes = Note::latest()->get();
        
        $experiences = \App\Models\Experience::published()->orderBy('order')->orderBy('created_at', 'desc')->get();

        return view('portfolio.home', compact('profile', 'skills', 'featuredProjects', 'certificates', 'totalCertificates', 'stats', 'notes', 'experiences'));
    }

    /**
     * Dedicated Project Estimator Page
     */
    public function estimator()
    {
        $profile = Profile::with('socialLinks')->first();
        if (!($profile->enable_estimator ?? true)) {
            return redirect()->route('home')->with('info', 'Layanan Kalkulator Estimasi sedang dinonaktifkan.');
        }
        return view('portfolio.estimator', compact('profile'));
    }

    /**
     * Dedicated Frequently Asked Questions (FAQ) Page
     */
    public function faq()
    {
        $profile = Profile::with('socialLinks')->first();
        return view('portfolio.faq', compact('profile'));
    }

    /**
     * Dedicated All Certificates Gallery Page
     */
    public function certificates()
    {
        $profile = Profile::with('socialLinks')->first();
        $certificates = Certificate::published()->orderBy('order')->get();
        return view('portfolio.certificates', compact('profile', 'certificates'));
    }

    /**
     * Dedicated All Projects Catalog Page
     */
    public function projects()
    {
        $profile = Profile::with('socialLinks')->first();
        $projects = Project::published()->orderBy('order')->get();
        return view('portfolio.projects', compact('profile', 'projects'));
    }

    /**
     * Project detail page - Public
     */
    public function project(string $slug)
    {
        $project = Project::published()->where('slug', $slug)->firstOrFail();
        $profile = Profile::with('socialLinks')->first();
        $relatedProjects = Project::published()
            ->where('id', '!=', $project->id)
            ->take(3)
            ->get();

        return view('portfolio.project-detail', compact('project', 'profile', 'relatedProjects'));
    }

    public function downloadProject(Project $project)
    {
        if (!$project->zip_path || !Storage::disk('public')->exists($project->zip_path)) {
            return back()->with('error', 'File ZIP tidak tersedia.');
        }

        $project->increment('download_count');

        return Storage::disk('public')->download(
            $project->zip_path,
            $project->slug . '.zip'
        );
    }

    /**
     * Download project APK
     */
    public function downloadApk(Project $project)
    {
        if (!$project->apk_path || !Storage::disk('public')->exists($project->apk_path)) {
            return back()->with('error', 'File APK tidak tersedia.');
        }

        $project->increment('download_count');

        return Storage::disk('public')->download(
            $project->apk_path,
            $project->slug . '.apk'
        );
    }

    /**
     * Download profile CV / Resume
     */
    public function downloadCv(Request $request)
    {
        if ($request->boolean('preview') || $request->query('view') === 'inline') {
            return $this->streamCv();
        }

        $profile = Profile::first();

        if (!$profile || !$profile->resume_path || !Storage::disk('public')->exists($profile->resume_path)) {
            return back()->with('error', 'File CV / Resume belum diunggah atau tidak ditemukan.');
        }

        $extension = pathinfo($profile->resume_path, PATHINFO_EXTENSION) ?: 'pdf';
        $safeName = Str::slug($profile->name ?? 'Portofolio');
        $filename = 'CV_' . $safeName . '.' . $extension;

        return Storage::disk('public')->download(
            $profile->resume_path,
            $filename
        );
    }

    /**
     * Stream profile CV / Resume inline for browser preview
     */
    public function streamCv()
    {
        $profile = Profile::first();

        if (!$profile || !$profile->resume_path || !Storage::disk('public')->exists($profile->resume_path)) {
            return response(
                '<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dokumen CV Belum Tersedia</title>
    <style>
        body {
            margin: 0;
            padding: 24px;
            background-color: #0c0c14;
            color: #cbd5e1;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            min-height: 100vh;
            box-sizing: border-box;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card {
            max-width: 440px;
            text-align: center;
            padding: 40px 24px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 24px;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5);
        }
        .icon-box {
            width: 64px;
            height: 64px;
            margin: 0 auto 18px;
            background: rgba(244, 63, 94, 0.12);
            border: 1px solid rgba(244, 63, 94, 0.25);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
        }
        h2 {
            margin: 0 0 10px;
            color: #ffffff;
            font-size: 18px;
            font-weight: 700;
        }
        p {
            margin: 0 0 24px;
            color: #94a3b8;
            font-size: 13px;
            line-height: 1.6;
        }
        .btn {
            display: inline-block;
            padding: 10px 24px;
            background: linear-gradient(135deg, #6366f1, #a855f7);
            color: #ffffff;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="icon-box">📄</div>
        <h2>Dokumen CV Belum Tersedia</h2>
        <p>File CV / Resume belum diunggah atau sedang dalam pembaruan oleh pemilik portofolio. Silakan unggah dokumen di Dashboard Admin > Edit Profil.</p>
        <a href="/" target="_top" class="btn">Kembali ke Beranda</a>
    </div>
</body>
</html>',
                200,
                ['Content-Type' => 'text/html; charset=UTF-8']
            );
        }

        $extension = pathinfo($profile->resume_path, PATHINFO_EXTENSION) ?: 'pdf';
        $safeName = Str::slug($profile->name ?? 'Portofolio');
        $filename = 'CV_' . $safeName . '.' . $extension;

        return Storage::disk('public')->response(
            $profile->resume_path,
            $filename,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $filename . '"',
                'Cache-Control' => 'public, max-age=3600',
            ]
        );
    }

    /**
     * Store donation
     */
    public function donate(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'nullable|exists:projects,id',
            'donor_name' => 'required|string|max:255',
            'donor_email' => 'nullable|email|max:255',
            'amount' => 'required|numeric|min:1000',
            'message' => 'nullable|string|max:1000',
            'payment_method' => 'required|string|in:transfer,dana,gopay,ovo',
        ]);

        $validated['status'] = 'pending';

        Donation::create($validated);

        if ($request->project_id) {
            $project = Project::find($request->project_id);
            if ($project) {
                $project->increment('download_count');
            }
        }

        return back()->with('success', 'Terima kasih atas donasinya! 🎉');
    }

    /**
     * Store contact message
     */
    public function contact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        ContactMessage::create($validated);

        return back()->with('success', 'Pesan berhasil dikirim! Terima kasih. 📬');
    }

    /**
     * Store visitor note (Workspace)
     */
    public function storeNote(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'required|string|max:1000',
        ]);

        Note::create($validated);

        return back()->with('success_note', 'Catatan Anda berhasil dipublikasikan! 🎉');
    }
}
