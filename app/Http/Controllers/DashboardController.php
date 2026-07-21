<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Dashboard shell. All numbers are loaded client-side by dashboard.js
     * calling data()/chart() below, so the date filter and the chart's
     * daily/weekly/monthly/yearly toggle can refresh in place without a
     * full page reload.
     */
    public function index()
    {
        return view('dashboard');
    }

    /**
     * Stat cards + the two "recent orders" panels + the vehicle-model
     * distribution chart, all scoped to ?range=today|week|month|year|custom
     * (custom takes &from=YYYY-MM-DD&to=YYYY-MM-DD).
     *
     * NOTE: date scoping runs off `created_at`, not `entry_date`. Entry
     * date is a free-typed field on the job-order form and can be any
     * date the person typed in; created_at reliably reflects when the
     * order actually entered the system, which is what a sales/revenue
     * report needs.
     */
    public function data(Request $request)
    {
        [$from, $to, $prevFrom, $prevTo] = $this->resolveRange($request);

        $base = fn () => DB::table('vehicle_entries')
            ->whereNull('deleted_at')
            ->whereBetween('created_at', [$from, $to]);

        $prevBase = fn () => DB::table('vehicle_entries')
            ->whereNull('deleted_at')
            ->whereBetween('created_at', [$prevFrom, $prevTo]);

        $revenue = (clone $base())->where('status', 'submitted')->sum('total_amount');
        $prevRevenue = (clone $prevBase())->where('status', 'submitted')->sum('total_amount');

        $orderCount = (clone $base())->count();
        $prevOrderCount = (clone $prevBase())->count();

        $uniqueVehicles = (clone $base())->whereNotNull('plate_number')->distinct()->count('plate_number');
        $prevUniqueVehicles = (clone $prevBase())->whereNotNull('plate_number')->distinct()->count('plate_number');

        $vehicleModels = (clone $base())->whereNotNull('car_model')->where('car_model', '!=', '')->distinct()->count('car_model');

        $servicesRendered = DB::table('vehicle_entry_services')
            ->join('vehicle_entries', 'vehicle_entries.id', '=', 'vehicle_entry_services.vehicle_entry_id')
            ->whereNull('vehicle_entries.deleted_at')
            ->whereBetween('vehicle_entries.created_at', [$from, $to])
            ->count();
        $prevServicesRendered = DB::table('vehicle_entry_services')
            ->join('vehicle_entries', 'vehicle_entries.id', '=', 'vehicle_entry_services.vehicle_entry_id')
            ->whereNull('vehicle_entries.deleted_at')
            ->whereBetween('vehicle_entries.created_at', [$prevFrom, $prevTo])
            ->count();

        $submittedCount = (clone $base())->where('status', 'submitted')->count();
        $draftCount = (clone $base())->where('status', 'draft')->count();

        $customersServed = (clone $base())->distinct()->count('customer_id');
        $prevCustomersServed = (clone $prevBase())->distinct()->count('customer_id');

        $stats = [
            'revenue'         => $this->statBlock($revenue, $prevRevenue, true),
            'orders'          => $this->statBlock($orderCount, $prevOrderCount),
            'unique_vehicles' => $this->statBlock($uniqueVehicles, $prevUniqueVehicles),
            'vehicle_models'  => ['value' => (int) $vehicleModels],
            'services'        => $this->statBlock($servicesRendered, $prevServicesRendered),
            'submitted'       => ['value' => (int) $submittedCount],
            'draft'           => ['value' => (int) $draftCount],
            'customers'       => $this->statBlock($customersServed, $prevCustomersServed),
        ];

        $modelRows = DB::table('vehicle_entries')
            ->select('car_model', DB::raw('COUNT(*) as total'))
            ->whereNull('deleted_at')
            ->whereNotNull('car_model')
            ->where('car_model', '!=', '')
            ->whereBetween('created_at', [$from, $to])
            ->groupBy('car_model')
            ->orderByDesc('total')
            ->get();

        $topModels = $modelRows->take(5);
        $otherTotal = $modelRows->skip(5)->sum('total');
        $distLabels = $topModels->pluck('car_model')->values()->all();
        $distValues = $topModels->pluck('total')->values()->all();
        if ($otherTotal > 0) {
            $distLabels[] = 'Other';
            $distValues[] = $otherTotal;
        }

        $recentOrders = DB::table('vehicle_entries')
            ->join('customers', 'customers.id', '=', 'vehicle_entries.customer_id')
            ->whereNull('vehicle_entries.deleted_at')
            ->orderByDesc('vehicle_entries.created_at')
            ->limit(6)
            ->get([
                'vehicle_entries.job_order_no',
                'vehicle_entries.car_model',
                'vehicle_entries.total_amount',
                'vehicle_entries.status',
                'vehicle_entries.created_at',
                'customers.name as customer_name',
            ])
            ->map(fn ($row) => [
                'job_order' => $row->job_order_no,
                'title'     => $row->car_model ?: 'Vehicle',
                'sub'       => $row->customer_name.' • '.number_format($row->total_amount, 2),
                'status'    => $row->status,
                'time'      => Carbon::parse($row->created_at)->diffForHumans(),
            ]);

        $draftOrders = DB::table('vehicle_entries')
            ->join('customers', 'customers.id', '=', 'vehicle_entries.customer_id')
            ->whereNull('vehicle_entries.deleted_at')
            ->where('vehicle_entries.status', 'draft')
            ->orderByDesc('vehicle_entries.created_at')
            ->limit(6)
            ->get([
                'vehicle_entries.job_order_no',
                'vehicle_entries.car_model',
                'vehicle_entries.total_amount',
                'vehicle_entries.created_at',
                'customers.name as customer_name',
            ])
            ->map(fn ($row) => [
                'job_order' => $row->job_order_no,
                'title'     => $row->car_model ?: 'Vehicle',
                'sub'       => $row->customer_name.' • '.number_format($row->total_amount, 2),
                'time'      => Carbon::parse($row->created_at)->diffForHumans(),
            ]);

        return response()->json([
            'range'                => ['from' => $from->toDateString(), 'to' => $to->toDateString()],
            'stats'                => $stats,
            'vehicle_distribution' => ['labels' => $distLabels, 'values' => $distValues],
            'recent_orders'        => $recentOrders,
            'draft_orders'         => $draftOrders,
        ]);
    }

    /**
     * Revenue trend chart, independent of the stat-card date filter.
     * ?period=daily|weekly|monthly|yearly
     */
    public function chart(Request $request)
    {
        $period = $request->get('period', 'daily');

        [$labels, $values] = match ($period) {
            'weekly'  => $this->revenueByWeek(),
            'monthly' => $this->revenueByMonth(),
            'yearly'  => $this->revenueByYear(),
            default   => $this->revenueByDay(),
        };

        return response()->json(['labels' => $labels, 'values' => $values]);
    }

    private function revenueByDay(): array
    {
        $start = Carbon::today()->subDays(6);
        $rows = DB::table('vehicle_entries')
            ->selectRaw('DATE(created_at) as d, SUM(total_amount) as total')
            ->whereNull('deleted_at')
            ->where('status', 'submitted')
            ->where('created_at', '>=', $start->copy()->startOfDay())
            ->groupBy('d')
            ->pluck('total', 'd');

        $labels = [];
        $values = [];
        foreach (CarbonPeriod::create($start, Carbon::today()) as $day) {
            $labels[] = $day->format('D');
            $values[] = (float) ($rows[$day->toDateString()] ?? 0);
        }

        return [$labels, $values];
    }

    private function revenueByWeek(): array
    {
        $start = Carbon::now()->startOfWeek()->subWeeks(7);
        $rows = DB::table('vehicle_entries')
            ->selectRaw('YEARWEEK(created_at, 3) as yw, SUM(total_amount) as total')
            ->whereNull('deleted_at')
            ->where('status', 'submitted')
            ->where('created_at', '>=', $start->copy()->startOfDay())
            ->groupBy('yw')
            ->pluck('total', 'yw');

        $labels = [];
        $values = [];
        $cursor = $start->copy();
        for ($i = 0; $i < 8; $i++) {
            $yw = (int) $cursor->isoFormat('GGGGWW');
            $labels[] = 'Wk '.$cursor->isoWeek();
            $values[] = (float) ($rows[$yw] ?? 0);
            $cursor->addWeek();
        }

        return [$labels, $values];
    }

    private function revenueByMonth(): array
    {
        $start = Carbon::now()->startOfMonth()->subMonths(11);
        $rows = DB::table('vehicle_entries')
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as ym, SUM(total_amount) as total")
            ->whereNull('deleted_at')
            ->where('status', 'submitted')
            ->where('created_at', '>=', $start->copy()->startOfDay())
            ->groupBy('ym')
            ->pluck('total', 'ym');

        $labels = [];
        $values = [];
        $cursor = $start->copy();
        for ($i = 0; $i < 12; $i++) {
            $labels[] = $cursor->format('M');
            $values[] = (float) ($rows[$cursor->format('Y-m')] ?? 0);
            $cursor->addMonth();
        }

        return [$labels, $values];
    }

    private function revenueByYear(): array
    {
        $start = Carbon::now()->startOfYear()->subYears(4);
        $rows = DB::table('vehicle_entries')
            ->selectRaw('YEAR(created_at) as yr, SUM(total_amount) as total')
            ->whereNull('deleted_at')
            ->where('status', 'submitted')
            ->where('created_at', '>=', $start->copy()->startOfDay())
            ->groupBy('yr')
            ->pluck('total', 'yr');

        $labels = [];
        $values = [];
        for ($year = $start->year; $year <= Carbon::now()->year; $year++) {
            $labels[] = (string) $year;
            $values[] = (float) ($rows[$year] ?? 0);
        }

        return [$labels, $values];
    }

    /**
     * ?range=today|week|month|year|custom(&from&to) -> current window +
     * an equal-length previous window (used for the stat cards' up/down
     * trend percentage).
     */
    private function resolveRange(Request $request): array
    {
        $range = $request->get('range', 'month');

        if ($range === 'custom' && $request->filled('from') && $request->filled('to')) {
            $from = Carbon::parse($request->get('from'))->startOfDay();
            $to = Carbon::parse($request->get('to'))->endOfDay();
            $days = $from->diffInDays($to) + 1;
            $prevTo = $from->copy()->subSecond();
            $prevFrom = $prevTo->copy()->subDays($days - 1)->startOfDay();

            return [$from, $to, $prevFrom, $prevTo];
        }

        return match ($range) {
            'today' => [
                Carbon::today(), Carbon::today()->endOfDay(),
                Carbon::yesterday(), Carbon::yesterday()->endOfDay(),
            ],
            'week' => [
                Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek(),
                Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek(),
            ],
            'year' => [
                Carbon::now()->startOfYear(), Carbon::now()->endOfYear(),
                Carbon::now()->subYear()->startOfYear(), Carbon::now()->subYear()->endOfYear(),
            ],
            default => [
                Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth(),
                Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->subMonth()->endOfMonth(),
            ],
        };
    }

    private function statBlock($current, $previous, bool $isMoney = false): array
    {
        $current = (float) $current;
        $previous = (float) $previous;

        $change = $previous == 0.0
            ? ($current > 0 ? 100.0 : 0.0)
            : (($current - $previous) / $previous) * 100;

        return [
            'value'     => $isMoney ? round($current, 2) : (int) $current,
            'change'    => round(abs($change), 1),
            'direction' => $change >= 0 ? 'up' : 'down',
        ];
    }
}
