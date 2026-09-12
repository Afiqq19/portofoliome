<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class SitemapController extends Controller
{
    public function index(Request $request)
    {
        $projects = Project::published()->get();
        
        return response()->view('sitemap', [
            'projects' => $projects
        ])->header('Content-Type', 'text/xml');
    }
}
