<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> @yield('title') </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@200;300;400;500;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('dashboard/style.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/admin-style.css') }}">
    @toastifyCss
</head>

<body>
    <div class="sidebar-container">
        <button id="sidebarToggle" class="sidebar-toggle">
            <i class="bi bi-list"></i>
        </button>
        <div class="sidebar">
            <div class="p-3">
                <h4 class="text-center mb-4"><i class="bi bi-people-fill"></i> إدارة الموظفين</h4>
            </div>

            <ul class="nav flex-column">

                <li class="nav-item">
                    <a class="nav-link @yield('welcome-active')" href="{{ route('welcome') }}" data-section="dashboard"><i
                            class="bi bi-speedometer2"></i> <span>الرئيسية</span></a>
                </li>
                @if (Auth::guard('admin')->user()->account_type == 'admin')
                    <li class="nav-item">
                        <a class="nav-link @yield('add-employee-active')" href="{{ route('employee.store') }}"
                            data-section="add-employee"><i class="bi bi-person-plus"></i> <span>إضافة موظف</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @yield('employees-active')" href="{{ route('employees') }}"
                            data-section="employees"><i class="bi bi-people"></i> <span>إدارة الموظفين</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @yield('tasks-active')" href="{{ route('tasks') }}" data-section="tasks"><i
                                class="bi bi-list-task"></i> <span>المهام</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @yield('calc-active')" href="{{ route('calc-profit') }}"
                            data-section="profit-calculator"><i class="bi bi-cash-coin"></i> <span>حاسبة
                                الأرباح</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @yield('reports-active')" href="{{ route('reports') }}" data-section="reports"><i
                                class="bi bi-bar-chart"></i> <span>التقارير والإحصائيات</span></a>
                    </li>
                @endif
                @if (Auth::guard('admin')->user()->account_type == 'employee')
                    <li class="nav-item">
                        <a class="nav-link @yield('tasks-active')" href="{{ route('tasks') }}" data-section="tasks"><i
                                class="bi bi-list-task"></i> <span>مهامي </span></a>
                    </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link @yield('profile-active')" href="{{ route('update_profile') }}" data-section="profile"><i
                            class="bi bi-list-task"></i> <span>الملف الشخصي </span></a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}" id="logout-btn"><i
                            class="bi bi-box-arrow-left"></i>
                        <span>تسجيل الخروج</span></a>
                </li>

            </ul>
        </div>
    </div>
