@extends('dashboard.layouts.master')
@section('title', 'حساب الأرباح')
@section('calc-active', 'active')
@section('content')
    <div class="main-content">
        <div id="profit-calculator" class="section-content" style="display: block;">
            <div class="card mt-4">
                <div class="card-header">
                    حاسبة الأرباح
                </div>
                @livewire('dashboard.calc.calc-data')
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    تفاصيل مستحقات الموظفين
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="salaries-table">
                            <thead>
                                <tr>
                                    <th>اسم الموظف</th>
                                    <th>الوظيفة</th>
                                    <th>عمولات إضافية</th>
                                    <th>إجمالي المستحقات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employess as $employe)
                                    <tr>
                                        <td>{{ $employe->name }}</td>
                                        <td>{{ $employe->job_type }}</td>
                                        <td>0 ريال</td>
                                        <td>{{ number_format($employe->sallary, 2) }} ريال</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
