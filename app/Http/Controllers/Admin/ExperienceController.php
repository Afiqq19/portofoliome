<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Experience;
use Illuminate\Http\Request;

class ExperienceController extends Controller
{
    public function index()
    {
        $experiences = Experience::orderBy('order')->orderBy('created_at', 'desc')->get();
        return view('admin.experiences.index', compact('experiences'));
    }

    public function create()
    {
        return view('admin.experiences.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'company' => 'nullable|string|max:255',
            'period' => 'required|string|max:100',
            'description' => 'required|string',
            'tags' => 'nullable|string',
            'color' => 'required|string|in:indigo,cyan,purple,emerald,rose,amber',
            'order' => 'required|integer',
            'is_published' => 'boolean',
        ]);

        $validated['is_published'] = $request->has('is_published');
        $validated['profile_id'] = \App\Models\Profile::first()->id ?? null;

        Experience::create($validated);

        return redirect()->route('admin.experiences.index')->with('success', 'Pengalaman berhasil ditambahkan! ✅');
    }

    public function edit(Experience $experience)
    {
        return view('admin.experiences.edit', compact('experience'));
    }

    public function update(Request $request, Experience $experience)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'company' => 'nullable|string|max:255',
            'period' => 'required|string|max:100',
            'description' => 'required|string',
            'tags' => 'nullable|string',
            'color' => 'required|string|in:indigo,cyan,purple,emerald,rose,amber',
            'order' => 'required|integer',
            'is_published' => 'boolean',
        ]);

        $validated['is_published'] = $request->has('is_published');

        $experience->update($validated);

        return redirect()->route('admin.experiences.index')->with('success', 'Pengalaman berhasil diperbarui! ✅');
    }

    public function destroy(Experience $experience)
    {
        $experience->delete();
        return redirect()->route('admin.experiences.index')->with('success', 'Pengalaman berhasil dihapus! ✅');
    }

    public function toggleStatus(Experience $experience)
    {
        $experience->update(['is_published' => !$experience->is_published]);
        $status = $experience->is_published ? 'dipublikasikan' : 'disembunyikan';
        return redirect()->route('admin.experiences.index')->with('success', "Pengalaman berhasil $status! ✅");
    }
}
