@extends('dashboard.layouts.master')
@section('title', 'إضافة موظف جديد')
@section('add-employee-active','active')
@section('content')
<div class="main-content">
<div id="add-employee" class="section-content" style="display: block;">
    <div class="card mt-4">
        <div class="card-header">
            إضافة موظف جديد
        </div>
        <div class="card-body">
            <form id="add-employee-form" action="{{ route('employee.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">الاسم الكامل</label>
                        <input type="text" name="name" class="form-control" id="employee-name" required="">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">البريد الإلكتروني</label>
                        <input type="email" name="email" class="form-control" id="employee-email" required="">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">كلمة المرور</label>
                        <input type="password" name="password" class="form-control" id="employee-password" required="">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label"> تأكيد كلمة المرور </label>
                        <input type="password" name="password_confirmation" class="form-control" id="employee-password" required="">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">الوظيفة</label>
                        <input type="text" name="job_type" class="form-control" id="employee-position" required="">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">الراتب الأساسي (ريال)</label>
                        <input type="number" name="sallary" class="form-control" id="employee-salary" required="">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">تاريخ التوظيف</label>
                        <input type="date" name="start_job_date" class="form-control" id="employee-hire-date" required="">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label"> نوع الحساب  </label>
                        <select name="account_type" class="form-select" id="employee-account-type" required="">
                            <option value="employee">موظف</option>
                            <option value="admin">مدير</option>
                        </select>
                    </div>
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">إضافة موظف</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
@endsection
