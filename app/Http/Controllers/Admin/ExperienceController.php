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

        // Normalisasi otomatis jika terdapat order bernilai 0 atau ada nilai duplikat
        $orders = $experiences->pluck('order')->toArray();
        if (in_array(0, $orders) || count($orders) !== count(array_unique($orders))) {
            foreach ($experiences as $i => $item) {
                $item->update(['order' => $i + 1]);
            }
            $experiences = Experience::orderBy('order')->get();
        }

        return view('admin.experiences.index', compact('experiences'));
    }

    public function create()
    {
        $nextOrder = (Experience::max('order') ?? 0) + 1;
        return view('admin.experiences.create', compact('nextOrder'));
    }

    public function moveUp(Experience $experience)
    {
        $previous = Experience::where('order', '<', $experience->order)
            ->orderBy('order', 'desc')
            ->first();

        if ($previous) {
            $currentOrder = $experience->order;
            $experience->update(['order' => $previous->order]);
            $previous->update(['order' => $currentOrder]);
            return back()->with('success', 'Urutan berhasil dinaikkan! 🔼');
        }

        return back()->with('info', 'Pengalaman ini sudah berada di posisi paling atas.');
    }

    public function moveDown(Experience $experience)
    {
        $next = Experience::where('order', '>', $experience->order)
            ->orderBy('order', 'asc')
            ->first();

        if ($next) {
            $currentOrder = $experience->order;
            $experience->update(['order' => $next->order]);
            $next->update(['order' => $currentOrder]);
            return back()->with('success', 'Urutan berhasil diturunkan! 🔽');
        }

        return back()->with('info', 'Pengalaman ini sudah berada di posisi paling bawah.');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'company' => 'nullable|string|max:255',
            'category' => 'required|string|in:work,education,organization',
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
            'category' => 'required|string|in:work,education,organization',
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
