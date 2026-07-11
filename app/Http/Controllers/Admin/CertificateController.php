<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CertificateController extends Controller
{
    public function index()
    {
        $certificates = Certificate::orderBy('order')->get();
        return view('admin.certificates.index', compact('certificates'));
    }

    public function create()
    {
        return view('admin.certificates.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'issuer' => 'nullable|string|max:255',
            'date' => 'nullable|date',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:5120',
            'credential_url' => 'nullable|url|max:500',
            'status' => 'required|in:draft,published',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('certificates', 'public');
        }

        Certificate::create($validated);

        return redirect()->route('admin.certificates.index')->with('success', 'Sertifikat berhasil ditambahkan! 🎉');
    }

    public function edit(Certificate $certificate)
    {
        return view('admin.certificates.edit', compact('certificate'));
    }

    public function update(Request $request, Certificate $certificate)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'issuer' => 'nullable|string|max:255',
            'date' => 'nullable|date',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:5120',
            'credential_url' => 'nullable|url|max:500',
            'status' => 'required|in:draft,published',
        ]);

        if ($request->hasFile('image')) {
            if ($certificate->image) {
                Storage::disk('public')->delete($certificate->image);
            }
            $validated['image'] = $request->file('image')->store('certificates', 'public');
        }

        $certificate->update($validated);

        return redirect()->route('admin.certificates.index')->with('success', 'Sertifikat berhasil diperbarui! ✅');
    }

    public function destroy(Certificate $certificate)
    {
        if ($certificate->image) {
            Storage::disk('public')->delete($certificate->image);
        }
        $certificate->delete();

        return redirect()->route('admin.certificates.index')->with('success', 'Sertifikat berhasil dihapus!');
    }

    public function toggleStatus(Certificate $certificate)
    {
        $certificate->update([
            'status' => $certificate->status === 'published' ? 'draft' : 'published'
        ]);

        return redirect()->back()->with('success', 'Status sertifikat berhasil diubah!');
    }
}
