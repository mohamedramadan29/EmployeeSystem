@extends('dashboard.layouts.master')
@section('title', 'إضافة طلب جديد')
@section('tasks-active', 'active')
@section('content')
    <div class="main-content">
        <div id="add-employee" class="section-content" style="display: block;">
            <div class="card mt-4">
                <div class="card-header">
                    إضافة طلب جديد
                </div>
                <div class="card-body">
                    <form id="add-order-form" action="{{ route('task.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">اسم العميل</label>
                                <input type="text" class="form-control" id="client-name" required="" name="client_name">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">رقم العميل</label>
                                <input type="text" class="form-control" id="client-phone" required="" name="client_phone">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">رقم الطلب</label>
                                <input type="text" class="form-control" id="order-number" required="" name="request_number">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">سعر الخدمة (ريال)</label>
                                <input type="number" class="form-control" id="service-price" required="" name="price">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">تاريخ البدء</label>
                                <input type="date" class="form-control" id="start-date" required="" name="start_date">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">تاريخ الانتهاء</label>
                                <input type="date" class="form-control" id="due-date" required="" name="end_date">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">الموظف المسؤول</label>
                                <select class="form-select" id="employee-assign" required="" name="employe_id">
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">الخدمة المطلوبة</label>
                                <textarea class="form-control" id="service-description" rows="3" required="" name="description"></textarea>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">حفظ الطلب</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
