<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\dashboard\Task;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
class ReportController extends Controller
{
    public function index()
    {
        // الحصول على الإحصائيات الشهرية لآخر 6 أشهر
        $monthlyStats = $this->getMonthlyStats();

        // الحصول على توزيع الحالات
        $statusDistribution = $this->getStatusDistribution();

        // الحصول على تقرير الأداء الشهري
        $performanceReport = $this->getPerformanceReport();

        return view('dashboard.reports.index', compact(
            'monthlyStats',
            'statusDistribution',
            'performanceReport'
        ));
    }

    private function getMonthlyStats()
    {
        $stats = Task::select(
            DB::raw('YEAR(start_date) as year'),
            DB::raw('MONTH(start_date) as month'),
            DB::raw('COUNT(*) as total_tasks')
        )
            ->where('start_date', '>=', Carbon::now()->subMonths(6))
            ->groupBy('year', 'month')
            ->orderBy('year', 'DESC')
            ->orderBy('month', 'DESC')
            ->limit(6)
            ->get();

        $labels = [];
        $data = [];

        foreach ($stats as $stat) {
            $labels[] = Carbon::create($stat->year, $stat->month)->translatedFormat('F Y');
            $data[] = $stat->total_tasks;
        }

        return [
            'labels' => array_reverse($labels),
            'data' => array_reverse($data)
        ];
    }

    private function getStatusDistribution()
    {
        // تعريف الحالات وترجمتها
        $statusLabels = [
            'مكتمل' => 'مكتملة',
            'قيد التنفيذ' => 'قيد التنفيذ',
            'قيد المراجعة' => 'قيد المراجعة',
            'ملغي' => 'ملغية'
        ];

        $distribution = Task::select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get()
            ->mapWithKeys(function ($item) use ($statusLabels) {
                return [$statusLabels[$item->status] ?? $item->status => $item->count];
            })->toArray();

        // ضمان وجود جميع الحالات حتى لو كانت القيمة 0
        foreach ($statusLabels as $label) {
            if (!array_key_exists($label, $distribution)) {
                $distribution[$label] = 0;
            }
        }

        return $distribution;
    }

    private function getPerformanceReport()
    {
        $reports = [];
        for ($i = 0; $i < 6; $i++) {
            $date = Carbon::now()->subMonths($i);
            $monthStart = $date->copy()->startOfMonth();
            $monthEnd = $date->copy()->endOfMonth();

            $monthlyData = Task::whereBetween('start_date', [$monthStart, $monthEnd])
                ->get();

            $completed = $monthlyData->where('status', 'مكتمل')->count();
            $cancelled = $monthlyData->where('status', 'ملغي')->count();
            // $avgTime = $monthlyData->where('status', 'مكتمل')
            // ->avg(DB::raw('DATEDIFF(updated_at, created_at)')) ?? 0;

            // حساب الإيرادات والأرباح
            $totalRevenue = $monthlyData->sum('price') ?? 0;
           // $netProfit = $totalRevenue * 0.7; // افتراض 30% مصاريف
            $netProfit = $totalRevenue; // افتراض 30% مصاريف

            $reports[] = [
                'month' => $date->translatedFormat('F Y'),
                'total_tasks' => $monthlyData->count(),
                'completed_tasks' => $completed,
                'cancelled_tasks' => $cancelled,
               // 'avg_completion_time' => round($avgTime, 1),
                'total_revenue' => $totalRevenue,
                'net_profit' => $netProfit
            ];
        }

        return array_reverse($reports); // عكس الترتيب لعرض الأحدث أولاً
    }
}
