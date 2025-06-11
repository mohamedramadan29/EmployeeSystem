@extends('dashboard.layouts.master')
@section('title', 'لوحة تحكم المدير')
@section('welcome-active', 'active')
@section('content')
    <div class="main-content">
        <div class="header d-flex justify-content-between align-items-center flex-wrap">
            @if (Auth::guard('admin')->user()->account_type == 'employee')
                <h4 class="mb-2 mb-sm-0">لوحة تحكم الموظف</h4>
            @else
                <h4 class="mb-2 mb-sm-0">لوحة تحكم المدير</h4>
            @endif
            <div class="d-flex align-items-center mt-2 mt-sm-0">
                <div class="user-info d-flex align-items-center">
                    <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center">
                        م</div>
                    <div class="ms-2">
                        <div class="fw-bold"> {{ Auth::guard('admin')->user()->name }} </div>
                        <div class="text-muted small"> {{ Auth::guard('admin')->user()->job_type }} </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- لوحة القيادة -->
        <div id="dashboard" class="section-content">
            @if (Auth::guard('admin')->user()->account_type == 'employee')
                <div class="row mt-4 g-3">
                    <div class="col-md-3">
                        <div class="card stat-card bg-light">
                            <i class="bi bi-list-check dashboard-icon"></i>
                            <div class="number" id="total-tasks">{{ $totalOrders }}</div>
                            <div class="label">إجمالي مهامي</div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card stat-card bg-light">
                            <i class="bi bi-check-circle dashboard-icon"></i>
                            <div class="number" id="completed-tasks">{{ $completedOrders }}</div>
                            <div class="label">مهام مكتملة</div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card stat-card bg-light">
                            <i class="bi bi-clock dashboard-icon"></i>
                            <div class="number" id="in-progress-tasks">{{ $inProgressOrders }}</div>
                            <div class="label">مهام قيد التنفيذ</div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card stat-card bg-light">
                            <i class="bi bi-currency-exchange dashboard-icon"></i>
                            <div class="number" id="employee-earnings">{{ number_format($totalEarnings, 2) }} ريال</div>
                            <div class="label">إجمالي أرباحي (ريال)</div>
                        </div>
                    </div>
                </div>
            @else
                <div class="row mt-4 g-3">
                    <div class="col-md-3">
                        <div class="card stat-card bg-light">
                            <i class="bi bi-people dashboard-icon"></i>
                            <div class="number" id="total-employees"> {{ $totalEmployees }} </div>
                            <div class="label">إجمالي الموظفين</div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card stat-card bg-light">
                            <i class="bi bi-list-check dashboard-icon"></i>
                            <div class="number" id="total-orders"> {{ $totalOrders }} </div>
                            <div class="label">إجمالي الطلبات</div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card stat-card bg-light">
                            <i class="bi bi-check-circle dashboard-icon"></i>
                            <div class="number" id="completed-orders"> {{ $completedOrders }} </div>
                            <div class="label">طلبات مكتملة</div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card stat-card bg-light">
                            <i class="bi bi-currency-exchange dashboard-icon"></i>
                            <div class="number" id="total-earnings"> {{ $totalEarnings }} </div>
                            <div class="label">إجمالي الأرباح (ريال)</div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                            <span class="mb-2 mb-sm-0">الطلبات الحديثة</span>
                            <a href="{{ route('tasks') }}" class="btn btn-sm btn-primary" id="view-all-orders">عرض الكل</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover" id="orders-table">
                                    <thead>
                                        <tr>
                                            <th>رقم الطلب</th>
                                            <th>العميل</th>
                                            <th>الموظف المسؤول</th>
                                            <th>الخدمة</th>
                                            <th>القيمة</th>
                                            <th>الحالة</th>
                                            <th>الإجراءات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $order)
                                            <tr>
                                                <td>{{ $order->id }}</td>
                                                <td>{{ $order->client_name }}</td>
                                                <td>{{ $order->employee->name }}</td>
                                                <td>{{ $order->description }}</td>
                                                <td>{{ $order->price }}</td>
                                                <td>{{ $order->status }}</td>
                                                <td>
                                                    <a href="{{ route('task.show', $order->id) }}"
                                                        class="btn btn-sm btn-primary">عرض</a>
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
        </div>

        <!-- إضافة موظف -->
        <div id="add-employee" class="section-content" style="display:none;">
            <div class="card mt-4">
                <div class="card-header">
                    إضافة موظف جديد
                </div>
                <div class="card-body">
                    <form id="add-employee-form">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">الاسم الكامل</label>
                                <input type="text" class="form-control" id="employee-name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">البريد الإلكتروني</label>
                                <input type="email" class="form-control" id="employee-email" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">كلمة المرور</label>
                                <input type="password" class="form-control" id="employee-password" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">الوظيفة</label>
                                <input type="text" class="form-control" id="employee-position" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">الراتب الأساسي (ريال)</label>
                                <input type="number" class="form-control" id="employee-salary" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">تاريخ التوظيف</label>
                                <input type="date" class="form-control" id="employee-hire-date" required>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">إضافة موظف</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- إدارة الموظفين -->
        <div id="manage-employees" class="section-content" style="display:none;">
            <div class="card mt-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>قائمة الموظفين</span>
                    <div class="d-flex">
                        <input type="text" class="form-control me-2" id="employee-search"
                            placeholder="بحث عن موظف...">
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
                                <!-- سيتم ملؤها بالجافاسكربت -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- الطلبات والمهام -->
        <div id="orders" class="section-content" style="display:none;">
            <div class="card mt-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>إدارة الطلبات</span>
                    <button class="btn btn-sm btn-primary" id="add-order-btn">إضافة طلب جديد</button>
                </div>
                <div class="card-body">
                    <!-- فلترة الطلبات -->
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
                                <!-- سيتم ملؤها بالجافاسكربت -->
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
                                <!-- سيتم ملؤها بالجافاسكربت -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Modal for adding new order -->
            <div class="modal fade" id="addOrderModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">إضافة طلب جديد</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="add-order-form">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">اسم العميل</label>
                                        <input type="text" class="form-control" id="client-name" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">رقم العميل</label>
                                        <input type="text" class="form-control" id="client-phone" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">رقم الطلب</label>
                                        <input type="text" class="form-control" id="order-number" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">سعر الخدمة (ريال)</label>
                                        <input type="number" class="form-control" id="service-price" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">تاريخ البدء</label>
                                        <input type="date" class="form-control" id="start-date" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">تاريخ الانتهاء</label>
                                        <input type="date" class="form-control" id="due-date" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">الموظف المسؤول</label>
                                        <select class="form-select" id="employee-assign" required>
                                            <!-- سيتم ملؤها بالجافاسكربت -->
                                        </select>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">الخدمة المطلوبة</label>
                                        <textarea class="form-control" id="service-description" rows="3" required></textarea>
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
            <div class="modal fade" id="orderDetailsModal" tabindex="-1" aria-hidden="true">
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
                                    <p><strong>رقم الطلب:</strong> <span id="detail-order-number"></span></p>
                                    <p><strong>العميل:</strong> <span id="detail-client-name"></span></p>
                                    <p><strong>رقم العميل:</strong> <span id="detail-client-phone"></span></p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>الخدمة:</strong> <span id="detail-service"></span></p>
                                    <p><strong>القيمة:</strong> <span id="detail-price"></span></p>
                                    <p><strong>الموظف المسؤول:</strong> <span id="detail-employee"></span></p>
                                </div>
                            </div>

                            <div class="mb-4">
                                <h6>تواريخ الطلب</h6>
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <strong>تاريخ البدء:</strong> <span id="detail-start-date"></span>
                                    </div>
                                    <div>
                                        <strong>تاريخ الانتهاء:</strong> <span id="detail-due-date"></span>
                                    </div>
                                    <div>
                                        <strong>المتبقي:</strong> <span id="detail-days-left"></span> يوم
                                    </div>
                                </div>
                                <div class="progress-container mt-2">
                                    <div class="progress">
                                        <div class="progress-bar" id="detail-progress-bar" role="progressbar"
                                            style="width: 0%"></div>
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
                                    <!-- سيتم ملؤها بالجافاسكربت -->
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
            <div class="modal fade" id="assignEmployeeModal" tabindex="-1" aria-hidden="true">
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
                                    <!-- سيتم ملؤها بالجافاسكربت -->
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
            <div class="modal fade" id="changeStatusModal" tabindex="-1" aria-hidden="true">
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
            <div class="modal fade" id="editOrderModal" tabindex="-1" aria-hidden="true">
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
                                        <input type="text" class="form-control" id="edit-client-name" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">رقم العميل</label>
                                        <input type="text" class="form-control" id="edit-client-phone" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">رقم الطلب</label>
                                        <input type="text" class="form-control" id="edit-order-number" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">سعر الخدمة (ريال)</label>
                                        <input type="number" class="form-control" id="edit-service-price" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">تاريخ البدء</label>
                                        <input type="date" class="form-control" id="edit-start-date" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">تاريخ الانتهاء</label>
                                        <input type="date" class="form-control" id="edit-due-date" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">الموظف المسؤول</label>
                                        <select class="form-select" id="edit-employee-assign" required>
                                            <!-- سيتم ملؤها بالجافاسكربت -->
                                        </select>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">الخدمة المطلوبة</label>
                                        <textarea class="form-control" id="edit-service-description" rows="3" required></textarea>
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

        <!-- حاسبة الأرباح -->
        <div id="profit-calculator" class="section-content" style="display:none;">
            <div class="card mt-4">
                <div class="card-header">
                    حاسبة الأرباح
                </div>
                <div class="card-body profit-calculator">
                    <div class="mb-3">
                        <label class="form-label">إجمالي الدخل (ريال)</label>
                        <input type="number" class="form-control" id="total-income" value="0">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">إجمالي مستحقات الموظفين (ريال)</label>
                        <input type="number" class="form-control" id="total-salaries" value="0">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">المصاريف الأخرى (ريال)</label>
                        <input type="number" class="form-control" id="other-expenses" value="0">
                    </div>

                    <hr style="background-color: rgba(255,255,255,0.2)">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5>صافي الربح:</h5>
                        <h3 id="net-profit">0 ريال</h3>
                    </div>

                    <button class="btn btn-light w-100 mt-3" id="calculate-profit">
                        <i class="bi bi-calculator me-2"></i> احتساب الأرباح
                    </button>
                </div>
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
                                    <th>الراتب الأساسي</th>
                                    <th>عمولات إضافية</th>
                                    <th>إجمالي المستحقات</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- سيتم ملؤها بالجافاسكربت -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- التقارير والإحصائيات -->
        <div id="reports" class="section-content" style="display:none;">
            <div class="row mt-4 g-3">
                <div class="col-12 col-lg-6">
                    <div class="card h-100">
                        <div class="card-header">
                            إحصائيات الطلبات
                        </div>
                        <div class="card-body">
                            <div class="chart-container">
                                <canvas id="orders-chart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-6">
                    <div class="card h-100">
                        <div class="card-header">
                            توزيع المهام حسب الحالة
                        </div>
                        <div class="card-body">
                            <div class="chart-container">
                                <canvas id="status-chart"></canvas>
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
                                            <th>متوسط وقت التنفيذ</th>
                                            <th>إجمالي الإيرادات</th>
                                            <th>صافي الأرباح</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>يونيو 2023</td>
                                            <td>142</td>
                                            <td>86</td>
                                            <td>12</td>
                                            <td>3.2 أيام</td>
                                            <td>25,430 ريال</td>
                                            <td>18,760 ريال</td>
                                        </tr>
                                        <tr>
                                            <td>مايو 2023</td>
                                            <td>128</td>
                                            <td>78</td>
                                            <td>15</td>
                                            <td>3.5 أيام</td>
                                            <td>23,800 ريال</td>
                                            <td>17,200 ريال</td>
                                        </tr>
                                        <tr>
                                            <td>أبريل 2023</td>
                                            <td>115</td>
                                            <td>72</td>
                                            <td>10</td>
                                            <td>3.8 أيام</td>
                                            <td>21,500 ريال</td>
                                            <td>15,900 ريال</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
