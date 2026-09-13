<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Donation;
use App\Models\Project;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DashboardController extends Controller
{
    public function index()
    {
        $now = Carbon::now('Asia/Jakarta');
        $todayStart = $now->copy()->startOfDay();
        $weekStart = $now->copy()->startOfWeek();
        $monthStart = $now->copy()->startOfMonth();

        $stats = [
            'total_projects' => Project::count(),
            'published_projects' => Project::published()->count(),
            'total_downloads' => Project::sum('download_count'),
            'total_visitors' => Visitor::distinct('ip_address')->count(),
            'today_visitors' => Visitor::where('created_at', '>=', $todayStart)->distinct('ip_address')->count(),
            'week_visitors' => Visitor::where('created_at', '>=', $weekStart)->distinct('ip_address')->count(),
            'month_visitors' => Visitor::where('created_at', '>=', $monthStart)->distinct('ip_address')->count(),
            'unread_messages' => ContactMessage::where('is_read', false)->count(),
            'total_messages' => ContactMessage::count(),
        ];

        // 7 Days Visitor Trend
        $dates7 = [];
        $counts7 = [];
        for ($i = 6; $i >= 0; $i--) {
            $day = $now->copy()->subDays($i);
            $dates7[] = $day->isoFormat('D MMM');
            $counts7[] = Visitor::whereDate('created_at', $day->format('Y-m-d'))->distinct('ip_address')->count();
        }

        // 30 Days Visitor Trend
        $dates30 = [];
        $counts30 = [];
        for ($i = 29; $i >= 0; $i--) {
            $day = $now->copy()->subDays($i);
            $dates30[] = $day->format('d/m');
            $counts30[] = Visitor::whereDate('created_at', $day->format('Y-m-d'))->distinct('ip_address')->count();
        }

        // Top 5 Visited Pages
        $topPages = Visitor::select('page', DB::raw('count(*) as views_count'), DB::raw('count(distinct ip_address) as unique_visitors'))
            ->groupBy('page')
            ->orderByDesc('views_count')
            ->take(5)
            ->get()
            ->map(function ($item) {
                $rawPage = trim($item->page ?? '');
                if (empty($rawPage) || $rawPage === '/') {
                    $item->page_name = 'Beranda Utama (Home)';
                } else {
                    $item->page_name = '/' . ltrim($rawPage, '/');
                }
                return $item;
            });

        // Device Breakdown (Mobile vs Desktop)
        $totalTracked = Visitor::count();
        $mobileCount = 0;
        $desktopCount = 0;
        if ($totalTracked > 0) {
            $mobileCount = Visitor::where(function ($q) {
                $q->where('user_agent', 'like', '%Mobile%')
                  ->orWhere('user_agent', 'like', '%Android%')
                  ->orWhere('user_agent', 'like', '%iPhone%')
                  ->orWhere('user_agent', 'like', '%iPad%');
            })->count();
            $desktopCount = max(0, $totalTracked - $mobileCount);
        }

        $deviceStats = [
            'total' => $totalTracked,
            'mobile' => $mobileCount,
            'desktop' => $desktopCount,
            'mobile_percent' => $totalTracked > 0 ? round(($mobileCount / $totalTracked) * 100) : 0,
            'desktop_percent' => $totalTracked > 0 ? round(($desktopCount / $totalTracked) * 100) : 0,
        ];

        $recentMessages = ContactMessage::latest()->take(5)->get();
        $recent_messages = $recentMessages; // support both naming conventions
        $recentVisitors = Visitor::latest()->take(10)->get();

        return view('admin.dashboard', compact(
            'stats',
            'dates7',
            'counts7',
            'dates30',
            'counts30',
            'topPages',
            'deviceStats',
            'recentMessages',
            'recent_messages',
            'recentVisitors'
        ));
    }

    /**
     * Export visitor logs to CSV format.
     */
    public function exportVisitors()
    {
        $fileName = 'visitor-logs-' . date('Y-m-d-His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');
            // Write UTF-8 BOM for Excel compatibility
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($file, ['No', 'IP Address', 'Halaman Dikunjungi', 'Tipe Perangkat', 'Waktu Kunjungan (WIB)', 'User Agent Lengkap']);

            $no = 0;
            Visitor::latest()->chunk(250, function ($visitors) use ($file, &$no) {
                foreach ($visitors as $v) {
                    $no++;
                    $isMobile = preg_match('/Mobile|Android|iPhone|iPad/i', $v->user_agent ?? '');
                    $deviceType = $isMobile ? 'Mobile / Smartphone' : 'Desktop / PC';
                    $pageName = empty($v->page) || $v->page === '/' ? 'Beranda' : '/' . ltrim($v->page, '/');
                    $timeWib = $v->created_at ? $v->created_at->setTimezone('Asia/Jakarta')->format('Y-m-d H:i:s') : '-';

                    fputcsv($file, [
                        $no,
                        $v->ip_address ?? '-',
                        $pageName,
                        $deviceType,
                        $timeWib,
                        $v->user_agent ?? '-',
                    ]);
                }
            });

            fclose($file);
        };

        return new StreamedResponse($callback, 200, $headers);
    }
}
