<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\Donation;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Skill;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PortfolioController extends Controller
{
    /**
     * Landing page - Public portfolio
     */
    public function index()
    {
        $profile = Profile::with('socialLinks')->first();
        $skills = Skill::orderBy('order')->get()->groupBy('category');
        $projects = Project::published()->orderBy('order')->get();
        $featuredProjects = Project::published()->featured()->orderBy('order')->take(6)->get();
        $certificates = \App\Models\Certificate::published()->orderBy('order')->get();

        $stats = [
            'projects' => Project::published()->count(),
            'downloads' => Project::sum('download_count'),
            'visitors' => Visitor::distinct('ip_address')->count(),
        ];

        return view('portfolio.home', compact('profile', 'skills', 'projects', 'featuredProjects', 'certificates', 'stats'));
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

        // If project_id exists, also trigger download
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
}
