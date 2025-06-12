@extends('dashboard.layouts.master')
@section('title', 'تعديل موظف')
@section('employees-active','active')
@section('content')
<div class="main-content">
<div id="add-employee" class="section-content" style="display: block;">
    <div class="card mt-4">
        <div class="card-header">
            تعديل موظف
        </div>
        <div class="card-body">
            <form id="add-employee-form" action="{{ route('employee.update', $employee->id) }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">الاسم الكامل</label>
                        <input type="text" name="name" class="form-control" id="employee-name" required="" value="{{ $employee->name }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">البريد الإلكتروني</label>
                        <input type="email" name="email" class="form-control" id="employee-email" required="" value="{{ $employee->email }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label"> تعديل كلمة المرور  </label>
                        <input type="password" name="password" class="form-control" id="employee-password">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label"> تأكيد كلمة المرور </label>
                        <input type="password" name="password_confirmation" class="form-control" id="employee-password">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">الوظيفة</label>
                        <input type="text" name="job_type" class="form-control" id="employee-position" required="" value="{{ $employee->job_type }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">تاريخ التوظيف</label>
                        <input type="date" name="start_job_date" class="form-control" id="employee-hire-date" required="" value="{{ $employee->start_job_date }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label"> نوع الحساب  </label>
                        <select name="account_type" class="form-select" id="employee-account-type" required="">
                            <option value="employee" {{ $employee->account_type == 'employee' ? 'selected' : '' }}>موظف</option>
                            <option value="admin" {{ $employee->account_type == 'admin' ? 'selected' : '' }}>مدير</option>
                        </select>
                    </div>
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">تعديل موظف</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
@endsection
