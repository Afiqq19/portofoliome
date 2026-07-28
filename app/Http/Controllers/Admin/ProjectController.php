<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::orderBy('order')->get();
        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        return view('admin.projects.create');
    }

    public function store(Request $request)
    {
        $messages = [
            'thumbnail.max' => 'Ukuran gambar thumbnail terlalu besar! Maksimal 20 MB.',
            'thumbnail.image' => 'File thumbnail harus berupa gambar.',
            'title.required' => 'Judul projek wajib diisi.',
            'status.required' => 'Status publikasi wajib dipilih.',
        ];

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'long_description' => 'nullable|string',
            'tech_stack' => 'nullable|string',
            'demo_url' => 'nullable|url|max:500',
            'github_url' => 'nullable|url|max:500',
            'thumbnail' => 'nullable|image|max:20480',
            'zip_file' => 'nullable|file',
            'apk_file' => 'nullable|file',
            'is_featured' => 'nullable|boolean',
            'status' => 'required|in:draft,published',
            'credentials_username' => 'nullable|array',
            'credentials_password' => 'nullable|array',
            'credentials_role' => 'nullable|array',
            'credentials_note' => 'nullable|array',
        ], $messages);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['tech_stack'] = array_filter(array_map('trim', explode(',', $validated['tech_stack'] ?? '')));
        $validated['is_featured'] = $request->boolean('is_featured');

        // Build credentials array
        $credentials = [];
        if ($request->credentials_username) {
            foreach ($request->credentials_username as $i => $username) {
                if ($username) {
                    $credentials[] = [
                        'username' => $username,
                        'password' => $request->credentials_password[$i] ?? '',
                        'role' => $request->credentials_role[$i] ?? '',
                        'note' => $request->credentials_note[$i] ?? '',
                    ];
                }
            }
        }
        $validated['credentials'] = $credentials;

        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();
            $path = 'projects/thumbnails/' . $filename;
            
            // Auto compress
            Storage::disk('public')->makeDirectory('projects/thumbnails');
            $manager = new ImageManager(new Driver());
            $image = $manager->decode($file->getPathname());
            $image->scaleDown(width: 1920, height: 1080);
            $image->save(storage_path('app/public/' . $path));
            
            $validated['thumbnail'] = $path;
        }

        if ($request->hasFile('zip_file')) {
            $validated['zip_path'] = $request->file('zip_file')->store('projects/zips', 'public');
        }

        if ($request->hasFile('apk_file')) {
            $validated['apk_path'] = $request->file('apk_file')->store('projects/apks', 'public');
        }

        unset($validated['zip_file'], $validated['apk_file'], $validated['credentials_username'], $validated['credentials_password'], $validated['credentials_role'], $validated['credentials_note']);

        Project::create($validated);

        return redirect()->route('admin.projects.index')->with('success', 'Projek berhasil ditambahkan! 🎉');
    }

    public function edit(Project $project)
    {
        return view('admin.projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $messages = [
            'thumbnail.max' => 'Ukuran gambar thumbnail terlalu besar! Maksimal 20 MB.',
            'thumbnail.image' => 'File thumbnail harus berupa gambar.',
            'title.required' => 'Judul projek wajib diisi.',
            'status.required' => 'Status publikasi wajib dipilih.',
        ];

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'long_description' => 'nullable|string',
            'tech_stack' => 'nullable|string',
            'demo_url' => 'nullable|url|max:500',
            'github_url' => 'nullable|url|max:500',
            'thumbnail' => 'nullable|image|max:20480',
            'zip_file' => 'nullable|file',
            'apk_file' => 'nullable|file',
            'is_featured' => 'nullable|boolean',
            'status' => 'required|in:draft,published',
            'credentials_username' => 'nullable|array',
            'credentials_password' => 'nullable|array',
            'credentials_role' => 'nullable|array',
            'credentials_note' => 'nullable|array',
        ], $messages);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['tech_stack'] = array_filter(array_map('trim', explode(',', $validated['tech_stack'] ?? '')));
        $validated['is_featured'] = $request->boolean('is_featured');

        // Build credentials
        $credentials = [];
        if ($request->credentials_username) {
            foreach ($request->credentials_username as $i => $username) {
                if ($username) {
                    $credentials[] = [
                        'username' => $username,
                        'password' => $request->credentials_password[$i] ?? '',
                        'role' => $request->credentials_role[$i] ?? '',
                        'note' => $request->credentials_note[$i] ?? '',
                    ];
                }
            }
        }
        $validated['credentials'] = $credentials;

        if ($request->hasFile('thumbnail')) {
            if ($project->thumbnail) {
                Storage::disk('public')->delete($project->thumbnail);
            }
            
            $file = $request->file('thumbnail');
            $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();
            $path = 'projects/thumbnails/' . $filename;
            
            // Auto compress
            Storage::disk('public')->makeDirectory('projects/thumbnails');
            $manager = new ImageManager(new Driver());
            $image = $manager->decode($file->getPathname());
            $image->scaleDown(width: 1920, height: 1080);
            $image->save(storage_path('app/public/' . $path));
            
            $validated['thumbnail'] = $path;
        }

        if ($request->hasFile('zip_file')) {
            if ($project->zip_path) {
                Storage::disk('public')->delete($project->zip_path);
            }
            $validated['zip_path'] = $request->file('zip_file')->store('projects/zips', 'public');
        }

        if ($request->hasFile('apk_file')) {
            if ($project->apk_path) {
                Storage::disk('public')->delete($project->apk_path);
            }
            $validated['apk_path'] = $request->file('apk_file')->store('projects/apks', 'public');
        }

        unset($validated['zip_file'], $validated['apk_file'], $validated['credentials_username'], $validated['credentials_password'], $validated['credentials_role'], $validated['credentials_note']);

        $project->update($validated);

        return redirect()->route('admin.projects.index')->with('success', 'Projek berhasil diperbarui! ✅');
    }

    public function destroy(Project $project)
    {
        if ($project->thumbnail) {
            Storage::disk('public')->delete($project->thumbnail);
        }
        if ($project->zip_path) {
            Storage::disk('public')->delete($project->zip_path);
        }
        if ($project->apk_path) {
            Storage::disk('public')->delete($project->apk_path);
        }

        $project->delete();

        return redirect()->route('admin.projects.index')->with('success', 'Projek berhasil dihapus!');
    }

    public function toggleStatus(Project $project)
    {
        $project->update([
            'status' => $project->status === 'published' ? 'draft' : 'published'
        ]);

        return redirect()->back()->with('success', 'Status projek berhasil diubah!');
    }
}
