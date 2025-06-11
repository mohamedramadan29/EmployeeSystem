// تسجيل الدخول وتوجيه المستخدم
document.getElementById('login-btn').addEventListener('click', function() {
    const email = document.getElementById('login-email').value;
    const password = document.getElementById('login-password').value;
    const role = document.getElementById('login-role').value;
    
    if (!email || !password) {
        alert('يرجى ملء جميع الحقول');
        return;
    }
    
    // تخزين بيانات تسجيل الدخول في localStorage
    localStorage.setItem('userEmail', email);
    localStorage.setItem('userRole', role);
    
    if (role === 'admin') {
        window.location.href = 'admin.html';
    } else {
        window.location.href = 'employee.html';
    }
});

// وظيفة مساعدة لتنسيق الأرقام
function formatNumber(num) {
    return new Intl.NumberFormat('ar-SA').format(num);
}

// وظيفة مساعدة لحساب الفرق بين التواريخ
function daysBetweenDates(date1, date2) {
    const oneDay = 24 * 60 * 60 * 1000; // milliseconds in one day
    const diffDays = Math.round(Math.abs((new Date(date1) - new Date(date2)) / oneDay));
    return diffDays;
}