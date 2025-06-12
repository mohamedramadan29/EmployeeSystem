<div class="card-body">
    <!-- فلترة الطلبات -->
    @if (Auth::guard('admin')->user()->account_type == 'admin')
        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label">حالة الطلب</label>
                <select class="form-select" id="filter-status" wire:model.live='status'>
                    <option value="all">جميع الحالات</option>
                    <option value="قيد المراجعة">قيد المراجعة</option>
                    <option value="قيد التنفيذ">قيد التنفيذ</option>
                    <option value="مكتمل">مكتمل</option>
                    <option value="ملغي">ملغي</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">الموظف المسؤول</label>
                <select class="form-select" id="filter-employee" wire:model.live='employee_id'>
                    <option value="all">جميع الموظفين</option>
                    @foreach ($employees as $employee)
                        <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">الشهر</label>
                <select class="form-select" id="filter-month" wire:model.live='month'>
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
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-gear"></i>
                                </button>
                                <ul class="dropdown-menu" style="">
                                    @if (Auth::guard('admin')->user()->account_type == 'admin')
                                        <li><a class="dropdown-item" href="{{ route('task.update', $task->id) }}"
                                                data-action="edit" data-id="1">تعديل</a></li>
                                    @endif
                                    <li><a class="dropdown-item" href="{{ route('task.show', $task->id) }}"
                                            data-action="assign" data-id="1"> عرض
                                            التفاصيل </a></li>
                                    @if (Auth::guard('admin')->user()->account_type == 'admin')
                                        <li><a class="dropdown-item text-danger"
                                                onclick="return confirm('هل انت متاكد من حذف هذا الموظف؟')"
                                                href="{{ route('task.delete', $task->id) }}" data-action="delete"
                                                data-id="1">حذف</a></li>
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
