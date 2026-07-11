<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    public function index()
    {
        $skills = Skill::orderBy('category')->orderBy('order')->get()->groupBy('category');
        return view('admin.skills.index', compact('skills'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'proficiency' => 'required|integer|min:1|max:100',
            'icon' => 'nullable|string|max:100',
        ]);

        Skill::create($validated);

        return back()->with('success', 'Skill berhasil ditambahkan! ✅');
    }

    public function update(Request $request, Skill $skill)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'proficiency' => 'required|integer|min:1|max:100',
            'icon' => 'nullable|string|max:100',
        ]);

        $skill->update($validated);

        return back()->with('success', 'Skill berhasil diperbarui! ✅');
    }

    public function destroy(Skill $skill)
    {
        $skill->delete();
        return back()->with('success', 'Skill berhasil dihapus!');
    }
}
