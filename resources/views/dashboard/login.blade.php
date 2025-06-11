<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نظام إدارة الموظفين والمرتبات</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('dashboard/style.css') }}">
</head>

<body>
    <div class="login-container">
        <div class="login-logo">
            <i class="bi bi-people-fill"></i>
            <h2 class="mt-3">نظام إدارة الموظفين</h2>
        </div>
        <form action="{{ route('admin_login') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="login-email" class="form-label">البريد الإلكتروني</label>
                <input type="email" class="form-control" name="email" id="login-email" placeholder="ادخل بريدك الإلكتروني">
            </div>

            <div class="mb-3">
                <label for="login-password" class="form-label">كلمة المرور</label>
                <input type="password" class="form-control" name="password" id="login-password" placeholder="ادخل كلمة المرور">
            </div>
 
            <button id="login-btn" class="btn btn-primary w-100">تسجيل الدخول</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('dashboard/script.js') }}"></script>
</body>

</html>
