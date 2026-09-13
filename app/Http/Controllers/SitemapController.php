<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SitemapController extends Controller
{
    public function index(Request $request)
    {
        try {
            $projects = Project::published()->get();
            $certificates = Certificate::published()->get();
            
            return response()->view('sitemap', [
                'projects' => $projects,
                'certificates' => $certificates
            ])->header('Content-Type', 'text/xml; charset=utf-8');
        } catch (\Throwable $e) {
            Log::error('Sitemap error: ' . $e->getMessage());
            
            $xml = '<?xml version="1.0" encoding="UTF-8"?>';
            $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
            $xml .= '<url><loc>' . url('/') . '</loc><priority>1.0</priority></url>';
            $xml .= '<url><loc>' . url('/projects') . '</loc><priority>0.8</priority></url>';
            $xml .= '<url><loc>' . url('/certificates') . '</loc><priority>0.8</priority></url>';
            $xml .= '</urlset>';
            
            return response($xml, 200)->header('Content-Type', 'text/xml; charset=utf-8');
        }
    }
}
