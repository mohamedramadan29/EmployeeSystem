@extends('dashboard.layouts.master')
@section('tasks-active', 'active')
@section('title', 'إدارة الطلبات')

@section('content')
    <div class="main-content">
        <div id="orders" class="section-content" style="display: block;">
            <div class="card mt-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>إدارة الطلبات</span>
                    @if (Auth::guard('admin')->user()->account_type == 'admin')
                    <a href="{{ route('task.store') }}" class="btn btn-sm btn-primary" id="add-order-btn">إضافة طلب جديد</a>
                    @endif
                </div>
                <div class="card-body">
                    <!-- فلترة الطلبات -->
                    @if (Auth::guard('admin')->user()->account_type == 'admin')
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">حالة الطلب</label>
                            <select class="form-select" id="filter-status">
                                <option value="all">جميع الحالات</option>
                                <option value="pending">قيد المراجعة</option>
                                <option value="in-progress">قيد التنفيذ</option>
                                <option value="completed">مكتمل</option>
                                <option value="cancelled">ملغي</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">الموظف المسؤول</label>
                            <select class="form-select" id="filter-employee">
                                <option value="all">جميع الموظفين</option>
                                <option value="1">سالم أحمد</option>
                                <option value="2">فاطمة خالد</option>
                                <option value="3">علي حسن</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">الشهر</label>
                            <select class="form-select" id="filter-month">
                                <option value="all">جميع الأشهر</option>
                                <option value="1">يناير</option>
                                <option value="2">فبراير</option>
                                <option value="3">مارس</option>
                                <option value="4">أبريل</option>
                                <option value="5">مايو</option>
                                <option value="6">يونيو</option>
                                <option value="7">يوليو</option>
                                <option value="8">أغسطس</option>
                                <option value="9">سبتمبر</option>
                                <option value="10">أكتوبر</option>
                                <option value="11">نوفمبر</option>
                                <option value="12">ديسمبر</option>
                            </select>
                        </div>
                    </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover" id="all-orders-table">
                            <thead>
                                <tr>
                                    <th>رقم الطلب</th>
                                    <th>العميل</th>
                                    <th>رقم العميل</th>
                                    <th>الخدمة</th>
                                    <th>القيمة</th>
                                    <th>الموظف المسؤول</th>
                                    <th>تاريخ البدء</th>
                                    <th>تاريخ الانتهاء</th>
                                    <th>الحالة</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tasks as $task)
                                    <tr>
                                        <td>{{ $task->request_number }}</td>
                                        <td>{{ $task->client_name }}</td>
                                        <td>{{ $task->client_phone }}</td>
                                        <td>{{ $task->description }}</td>
                                        <td>{{ $task->price }}</td>
                                        <td>{{ $task->employee->name }}</td>
                                        <td>{{ $task->start_date }}</td>
                                        <td>{{ $task->end_date }}</td>

                                        <td>
                                            @if ($task->status == 'قيد المراجعة')
                                                <span class="task-status status-pending">قيد المراجعة</span>
                                            @elseif ($task->status == 'قيد التنفيذ')
                                                <span class="task-status status-in-progress">قيد التنفيذ</span>
                                            @elseif ($task->status == 'مكتمل')
                                                <span class="task-status status-completed">مكتمل</span>
                                            @elseif ($task->status == 'ملغي')
                                                <span class="task-status status-cancelled">ملغي</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle"
                                                    type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="bi bi-gear"></i>
                                                </button>
                                                <ul class="dropdown-menu" style="">
                                                    @if (Auth::guard('admin')->user()->account_type == 'admin')
                                                    <li><a class="dropdown-item"
                                                            href="{{ route('task.update', $task->id) }}" data-action="edit"
                                                            data-id="1">تعديل</a></li>
                                                    @endif
                                                    <li><a class="dropdown-item" href="{{ route('task.show', $task->id) }}"
                                                            data-action="assign" data-id="1"> عرض
                                                            التفاصيل </a></li>
                                                    @if (Auth::guard('admin')->user()->account_type == 'admin')
                                                    <li><a class="dropdown-item text-danger"  onclick="return confirm('هل انت متاكد من حذف هذا الموظف؟')"  href="{{ route('task.delete', $task->id) }}"
                                                            data-action="delete" data-id="1">حذف</a></li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Modal for adding new order -->
            <div class="modal fade" id="addOrderModal" tabindex="-1" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">إضافة طلب جديد</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="add-order-form">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">اسم العميل</label>
                                        <input type="text" class="form-control" id="client-name" required="">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">رقم العميل</label>
                                        <input type="text" class="form-control" id="client-phone" required="">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">رقم الطلب</label>
                                        <input type="text" class="form-control" id="order-number" required="">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">سعر الخدمة (ريال)</label>
                                        <input type="number" class="form-control" id="service-price" required="">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">تاريخ البدء</label>
                                        <input type="date" class="form-control" id="start-date" required="">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">تاريخ الانتهاء</label>
                                        <input type="date" class="form-control" id="due-date" required="">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">الموظف المسؤول</label>
                                        <select class="form-select" id="employee-assign" required="">
                                            <option value="1">سالم أحمد</option>
                                            <option value="2">فاطمة خالد</option>
                                            <option value="3">علي حسن</option>
                                        </select>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">الخدمة المطلوبة</label>
                                        <textarea class="form-control" id="service-description" rows="3" required=""></textarea>
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

            <!-- Modal for order details -->
            <div class="modal fade" id="orderDetailsModal" tabindex="-1" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">تفاصيل الطلب</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <p><strong>رقم الطلب:</strong> <span id="detail-order-number">#1254</span></p>
                                    <p><strong>العميل:</strong> <span id="detail-client-name">عبدالله محمد</span></p>
                                    <p><strong>رقم العميل:</strong> <span id="detail-client-phone">0551234567</span></p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>الخدمة:</strong> <span id="detail-service">تصميم شعار</span></p>
                                    <p><strong>القيمة:</strong> <span id="detail-price">٨٠٠ ريال</span></p>
                                    <p><strong>الموظف المسؤول:</strong> <span id="detail-employee">سالم أحمد</span></p>
                                </div>
                            </div>

                            <div class="mb-4">
                                <h6>تواريخ الطلب</h6>
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <strong>تاريخ البدء:</strong> <span id="detail-start-date">2023-06-10</span>
                                    </div>
                                    <div>
                                        <strong>تاريخ الانتهاء:</strong> <span id="detail-due-date">2023-06-15</span>
                                    </div>
                                    <div>
                                        <strong>المتبقي:</strong> <span id="detail-days-left">0</span> يوم
                                    </div>
                                </div>
                                <div class="progress-container mt-2">
                                    <div class="progress">
                                        <div class="progress-bar" id="detail-progress-bar" role="progressbar"
                                            style="width: 100%;"></div>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <h6>حالة الطلب</h6>
                                <select class="form-select mb-3" id="order-status">
                                    <option value="pending">قيد المراجعة</option>
                                    <option value="in-progress">قيد التنفيذ</option>
                                    <option value="completed">مكتمل</option>
                                    <option value="cancelled">ملغي</option>
                                </select>
                            </div>

                            <div class="mt-4">
                                <h6>ملاحظات الموظف</h6>
                                <div id="order-notes">
                                    <p class="text-center text-muted">لا توجد ملاحظات</p>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                            <button type="button" class="btn btn-primary" id="save-order-status">حفظ التغييرات</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal for assigning employee -->
            <div class="modal fade" id="assignEmployeeModal" tabindex="-1" aria-hidden="true" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">تعيين موظف للطلب</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">اختر الموظف</label>
                                <select class="form-select" id="employee-assign-select">
                                    <option value="1">سالم أحمد</option>
                                    <option value="2">فاطمة خالد</option>
                                    <option value="3">علي حسن</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                            <button type="button" class="btn btn-primary" id="assign-btn">تعيين</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal for changing status -->
            <div class="modal fade" id="changeStatusModal" tabindex="-1" aria-hidden="true" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">تغيير حالة الطلب</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">اختر الحالة الجديدة</label>
                                <select class="form-select" id="status-select">
                                    <option value="pending">قيد المراجعة</option>
                                    <option value="in-progress">قيد التنفيذ</option>
                                    <option value="completed">مكتمل</option>
                                    <option value="cancelled">ملغي</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                            <button type="button" class="btn btn-primary" id="change-status-btn">تغيير</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal for editing order -->
            <div class="modal fade" id="editOrderModal" tabindex="-1" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">تعديل الطلب</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">اسم العميل</label>
                                        <input type="text" class="form-control" id="edit-client-name" required="">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">رقم العميل</label>
                                        <input type="text" class="form-control" id="edit-client-phone"
                                            required="">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">رقم الطلب</label>
                                        <input type="text" class="form-control" id="edit-order-number"
                                            required="">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">سعر الخدمة (ريال)</label>
                                        <input type="number" class="form-control" id="edit-service-price"
                                            required="">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">تاريخ البدء</label>
                                        <input type="date" class="form-control" id="edit-start-date" required="">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">تاريخ الانتهاء</label>
                                        <input type="date" class="form-control" id="edit-due-date" required="">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">الموظف المسؤول</label>
                                        <select class="form-select" id="edit-employee-assign" required="">
                                            <option value="1">سالم أحمد</option>
                                            <option value="2">فاطمة خالد</option>
                                            <option value="3">علي حسن</option>
                                        </select>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">الخدمة المطلوبة</label>
                                        <textarea class="form-control" id="edit-service-description" rows="3" required=""></textarea>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                            <button type="button" class="btn btn-primary" id="edit-order-btn">تحديث</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
