@extends('dashboard.layouts.master')
@section('title', 'تعديل طلب')
@section('tasks-active', 'active')
@section('content')
    <div class="main-content">
        <div id="add-employee" class="section-content" style="display: block;">
            <div class="card mt-4">
                <div class="card-header">
                    تفاصيل الطلب
                </div>
                <div class="card-body">

                    <form class="" method="POST" action="{{ route('task.show', $task['id']) }}">
                        @csrf


                        <div class="row mb-4">
                            <div class="col-md-6">
                                <p><strong>رقم الطلب:</strong> <span
                                        id="detail-order-number">#{{ $task['request_number'] }}</span></p>
                                <p><strong>العميل:</strong> <span id="detail-client-name">{{ $task['client_name'] }}</span>
                                </p>
                                <p><strong>رقم العميل:</strong> <span
                                        id="detail-client-phone">{{ $task['client_phone'] }}</span></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>الخدمة:</strong> <span id="detail-service">{{ $task['description'] }}</span></p>
                                <p><strong>القيمة:</strong> <span id="detail-price">{{ number_format($task['price'], 2) }}
                                        ريال</span></p>
                                <p><strong>الموظف المسؤول:</strong> <span
                                        id="detail-employee">{{ $task['employee']['name'] }}</span></p>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h6>تواريخ الطلب</h6>
                            <div class="d-flex justify-content-between">
                                <div>
                                    <strong>تاريخ البدء:</strong> <span
                                        id="detail-start-date">{{ $task['start_date'] }}</span>
                                </div>
                                <div>
                                    <strong>تاريخ الانتهاء:</strong> <span
                                        id="detail-due-date">{{ $task['end_date'] }}</span>
                                </div>
                                <div>
                                    <strong>المتبقي:</strong> <span id="detail-days-left">
                                        @php
                                            $startDate = new DateTime($task['start_date']);
                                            $endDate = new DateTime($task['end_date']);
                                            $interval = $startDate->diff($endDate);
                                            $daysLeft = $interval->days;
                                        @endphp
                                        {{ $daysLeft }} يوم
                                    </span>
                                </div>
                            </div>
                            @php
                                // calculate progress
                                $progress = ($daysLeft / $task['price']) * 100;
                            @endphp
                            <div class="progress-container mt-2">
                                <div class="progress">
                                    <div class="progress-bar" id="detail-progress-bar" role="progressbar"
                                        style="width: {{ $progress }}%;">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <h6>حالة الطلب</h6>
                            <select class="form-select mb-3" id="order-status" name="status">
                                <option value="قيد المراجعة" {{ $task['status'] == 'قيد المراجعة' ? 'selected' : '' }}>قيد
                                    المراجعة</option>
                                <option value="قيد التنفيذ" {{ $task['status'] == 'قيد التنفيذ' ? 'selected' : '' }}>قيد
                                    التنفيذ</option>
                                <option value="مكتمل" {{ $task['status'] == 'مكتمل' ? 'selected' : '' }}>مكتمل</option>
                                <option value="ملغي" {{ $task['status'] == 'ملغي' ? 'selected' : '' }}>ملغي</option>
                            </select>
                        </div>
                        @if (Auth::guard('admin')->user()->account_type == 'employee')
                            <div>
                                <h6>ملاحظات الموظف</h6>
                                <textarea class="form-control" name="employee_note" id="employee-note" rows="3">{{ $task['employee_note'] }}</textarea>
                            </div>
                        @endif
                        @if (Auth::guard('admin')->user()->account_type == 'admin')
                            <div class="mt-4">
                                <h6>ملاحظات الموظف</h6>
                                <div id="order-notes">
                                    <p class="text-center text-muted"> {{ $task['employee_note'] }}  </p>
                                </div>
                            </div>
                        @endif
                        <br>
                        @if (Auth::guard('admin')->user()->account_type == 'employee')
                        <button type="submit" class="btn btn-primary">تحديث</button>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>


    </div>
@endsection
