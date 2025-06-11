@extends('dashboard.layouts.master')
@section('title', 'تعديل طلب')
@section('tasks-active', 'active')
@section('content')
    <div class="main-content">
        <div id="add-employee" class="section-content" style="display: block;">
            <div class="card mt-4">
                <div class="card-header">
                    تعديل طلب
                </div>
                <div class="card-body">
                    <form id="add-order-form" action="{{ route('task.update', $task->id) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">اسم العميل</label>
                                <input type="text" class="form-control" id="client-name" required=""
                                    name="client_name" value="{{ $task->client_name }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">رقم العميل</label>
                                <input type="text" class="form-control" id="client-phone" required=""
                                    name="client_phone" value="{{ $task->client_phone }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">رقم الطلب</label>
                                <input type="text" class="form-control" id="order-number" required=""
                                    name="request_number" value="{{ $task->request_number }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">سعر الخدمة (ريال)</label>
                                <input type="number" class="form-control" id="service-price" required="" name="price"
                                    value="{{ $task->price }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">تاريخ البدء</label>
                                <input type="date" class="form-control" id="start-date" required="" name="start_date"
                                    value="{{ $task->start_date }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">تاريخ الانتهاء</label>
                                <input type="date" class="form-control" id="due-date" required="" name="end_date"
                                    value="{{ $task->end_date }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">الموظف المسؤول</label>
                                <select class="form-select" id="employee-assign" required="" name="employe_id">
                                    @foreach ($employees as $employee)
                                        <option {{ $task->employee_id == $employee->id ? 'selected' : '' }}
                                            value="{{ $employee->id }}">{{ $employee->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">الخدمة المطلوبة</label>
                                <textarea class="form-control" id="service-description" rows="3" required="" name="description">{{ $task->description }}</textarea>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">حالة الطلب</label>
                                <select class="form-select" id="order-status" required="" name="status">
                                    <option {{ $task->status == 'قيد المراجعة' ? 'selected' : '' }} value="قيد المراجعة">قيد المراجعة
                                    </option>
                                    <option {{ $task->status == 'قيد التنفيذ' ? 'selected' : '' }} value="قيد التنفيذ">قيد
                                        التنفيذ</option>
                                    <option {{ $task->status == 'مكتمل' ? 'selected' : '' }} value="مكتمل">مكتمل
                                    </option>
                                    <option {{ $task->status == 'ملغي' ? 'selected' : '' }} value="ملغي">ملغي
                                    </option>
                                </select>
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
