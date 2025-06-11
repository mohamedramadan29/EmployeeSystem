@extends('dashboard.layouts.master')
@section('title', 'إدارة الموظفين')
@section('employees-active', 'active')
@section('content')
    <div class="main-content">
        <div id="manage-employees" class="section-content" style="display: block;">
            <div class="card mt-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>قائمة الموظفين</span>
                    <div class="d-flex">
                        <input type="text" class="form-control me-2" id="employee-search" placeholder="بحث عن موظف...">
                        <button class="btn btn-sm btn-outline-primary" id="search-employee-btn">بحث</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="employees-table">
                            <thead>
                                <tr>
                                    <th>الاسم</th>
                                    <th>البريد الإلكتروني</th>
                                    <th>الوظيفة</th>
                                    <th>الراتب</th>
                                    <th>تاريخ التوظيف</th>
                                    <th>الحالة</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employees as $employee)
                                    <tr>
                                        <td>{{ $employee->name }}</td>
                                        <td>{{ $employee->email }}</td>
                                        <td>{{ $employee->job_type }}</td>
                                        <td> {{ number_format($employee->sallary, 2) }} ريال</td>
                                        <td>{{ $employee->created_at->format('Y-m-d') }}</td>
                                        <td><span class="badge bg-success">نشط</span></td>
                                        <td>
                                            <a href="{{ route('employee.update', $employee->id) }}" class="btn btn-sm btn-outline-primary edit-employee" data-id="{{ $employee->id }}">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="{{ route('employee.delete', $employee->id) }}" onclick="return confirm('هل انت متاكد من حذف هذا الموظف؟')" class="btn btn-sm btn-outline-danger delete-employee" data-id="{{ $employee->id }}">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </td>
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
