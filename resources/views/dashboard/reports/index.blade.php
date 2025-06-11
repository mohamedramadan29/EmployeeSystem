@extends('dashboard.layouts.master')
@section('title', 'التقارير والإحصائيات')
@section('reports-active', 'active')
@section('content')
    <div class="main-content">
        <div id="profit-calculator" class="section-content" style="display: block;">
            <div id="reports" class="section-content" style="display: block;">
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                إحصائيات الطلبات
                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                    <canvas id="orders-chart" height="250"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                توزيع المهام حسب الحالة
                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                    <canvas id="status-chart" height="250"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                تقرير الأداء الشهري
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>الشهر</th>
                                                <th>عدد الطلبات</th>
                                                <th>طلبات مكتملة</th>
                                                <th>طلبات ملغية</th>
                                                {{-- <th>متوسط وقت الإكمال (أيام)</th> --}}
                                                <th>إجمالي الإيرادات (ريال)</th>
                                                <th>صافي الأرباح (ريال)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($performanceReport as $report)
                                                <tr>
                                                    <td>{{ $report['month'] }}</td>
                                                    <td>{{ $report['total_tasks'] }}</td>
                                                    <td>{{ $report['completed_tasks'] }}</td>
                                                    <td>{{ $report['cancelled_tasks'] }}</td>
                                                    {{-- <td>{{ number_format($report['avg_completion_time'], 1, '.', '') }}</td> --}}
                                                    <td>{{ number_format($report['total_revenue'], 0, '.', ',') }}</td>
                                                    <td>{{ number_format($report['net_profit'], 0, '.', ',') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@section('js')
<script>
    // مخطط إحصائيات الطلبات
    const ordersCtx = document.getElementById('orders-chart').getContext('2d');
    new Chart(ordersCtx, {
        type: 'line',
        data: {
            labels: @json($monthlyStats['labels']),
            datasets: [{
                label: 'عدد الطلبات',
                data: @json($monthlyStats['data']),
                borderColor: '#4361ee',
                backgroundColor: 'rgba(67, 97, 238, 0.1)',
                tension: 0.3,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'عدد الطلبات: ' + context.parsed.y;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'عدد الطلبات'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'الشهر'
                    }
                }
            }
        }
    });

    // مخطط توزيع الحالات
    const statusCtx = document.getElementById('status-chart').getContext('2d');
    new Chart(statusCtx, {
        type: 'bar',
        data: {
            labels: @json(array_keys($statusDistribution)),
            datasets: [{
                label: 'عدد الطلبات',
                data: @json(array_values($statusDistribution)),
                backgroundColor: [
                    '#4caf50', // مكتملة
                    '#2196f3', // قيد التنفيذ
                    '#ffc107', // قيد المراجعة
                    '#f44336'  // ملغية
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.label + ': ' + context.parsed.y;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'عدد الطلبات'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'حالة المهمة'
                    }
                }
            }
        }
    });
</script>
@endsection
