<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Donation;
use App\Models\Project;
use App\Models\Visitor;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_projects' => Project::count(),
            'published_projects' => Project::published()->count(),
            'total_downloads' => Project::sum('download_count'),
            'total_visitors' => Visitor::distinct('ip_address')->count(),
            'unread_messages' => ContactMessage::where('is_read', false)->count(),
            'total_messages' => ContactMessage::count(),
        ];

        $recentMessages = ContactMessage::latest()
            ->take(5)
            ->get();

        $recentVisitors = Visitor::latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentMessages', 'recentVisitors'));
    }
}
