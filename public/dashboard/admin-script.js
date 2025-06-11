// // بيانات أولية للموظفين
// let employees = [
//     {
//         id: 1,
//         name: "سالم أحمد",
//         email: "saleh@example.com",
//         position: "مصمم جرافيك",
//         salary: 4000,
//         hireDate: "2022-01-15",
//         status: "active",
//         avatar: "س"
//     },
//     {
//         id: 2,
//         name: "فاطمة خالد",
//         email: "fatima@example.com",
//         position: "مطورة ويب",
//         salary: 4500,
//         hireDate: "2021-11-20",
//         status: "active",
//         avatar: "ف"
//     },
//     {
//         id: 3,
//         name: "علي حسن",
//         email: "ali@example.com",
//         position: "مدير مشاريع",
//         salary: 6000,
//         hireDate: "2020-05-10",
//         status: "active",
//         avatar: "ع"
//     }
// ];

// // بيانات أولية للطلبات
// let orders = [
//     {
//         id: 1,
//         orderNumber: "#1254",
//         clientName: "عبدالله محمد",
//         clientPhone: "0551234567",
//         employeeId: 1,
//         service: "تصميم شعار",
//         price: 800,
//         status: "completed",
//         startDate: "2023-06-10",
//         dueDate: "2023-06-15",
//         date: "2023-06-15",
//         notes: []
//     },
//     {
//         id: 2,
//         orderNumber: "#1253",
//         clientName: "نورة سعيد",
//         clientPhone: "0557654321",
//         employeeId: 2,
//         service: "تطبيق جوال",
//         price: 5200,
//         status: "in-progress",
//         startDate: "2023-06-15",
//         dueDate: "2023-06-25",
//         date: "2023-06-16",
//         notes: []
//     },
//     {
//         id: 3,
//         orderNumber: "#1252",
//         clientName: "شركة التقنية",
//         clientPhone: "0112345678",
//         employeeId: 3,
//         service: "موقع إلكتروني",
//         price: 12000,
//         status: "pending",
//         startDate: "2023-06-17",
//         dueDate: "2023-07-01",
//         date: "2023-06-17",
//         notes: []
//     },
//     {
//         id: 4,
//         orderNumber: "#1251",
//         clientName: "أحمد يوسف",
//         clientPhone: "0501122334",
//         employeeId: 1,
//         service: "تصميم بوستر",
//         price: 400,
//         status: "completed",
//         startDate: "2023-06-15",
//         dueDate: "2023-06-18",
//         date: "2023-06-18",
//         notes: []
//     },
//     {
//         id: 5,
//         orderNumber: "#1250",
//         clientName: "وليد عبدالعزيز",
//         clientPhone: "0555566778",
//         employeeId: 2,
//         service: "تسويق إلكتروني",
//         price: 3500,
//         status: "cancelled",
//         startDate: "2023-06-18",
//         dueDate: "2023-06-25",
//         date: "2023-06-19",
//         notes: []
//     }
// ];

// // تهيئة لوحة التحكم عند التحميل
// document.addEventListener('DOMContentLoaded', function() {
//     // التحقق من تسجيل الدخول
//     const userRole = localStorage.getItem('userRole');
//     if (userRole !== 'admin') {
//         window.location.href = 'index.html';
//         return;
//     }

//     // تحديث الإحصائيات
//     updateDashboardStats();

//     // تحميل الطلبات الحديثة
//     loadRecentOrders();

//     // تحميل أفضل الموظفين
//     loadTopEmployees();

//     // تهيئة الرسوم البيانية
//     initCharts();

//     // تهيئة التنقل بين الأقسام
//     initNavigation();

//     // تهيئة حاسبة الأرباح
//     initProfitCalculator();

//     // تحميل قائمة الموظفين
//     loadEmployeesTable();

//     // تحميل جميع الطلبات
//     loadAllOrders();

//     // تهيئة أحداث إضافة الموظف
//     initEmployeeForm();

//     // تهيئة أحداث إضافة الطلب
//     initOrderForm();

//     // تهيئة البحث عن الموظفين
//     initEmployeeSearch();

//     // تهيئة فلاتر الطلبات
//     initOrderFilters();
// });

// // تحديث إحصائيات لوحة التحكم
// function updateDashboardStats() {
//     document.getElementById('total-employees').textContent = employees.length;
//     document.getElementById('total-orders').textContent = orders.length;

//     const completedOrders = orders.filter(order => order.status === 'completed').length;
//     document.getElementById('completed-orders').textContent = completedOrders;

//     const totalEarnings = orders.filter(order => order.status === 'completed').reduce((sum, order) => sum + order.price, 0);
//     document.getElementById('total-earnings').textContent = formatNumber(totalEarnings);
// }

// // تحميل الطلبات الحديثة
// function loadRecentOrders() {
//     const tbody = document.querySelector('#orders-table tbody');
//     tbody.innerHTML = '';

//     // عرض 5 طلبات فقط
//     const recentOrders = orders.slice(0, 5);

//     recentOrders.forEach(order => {
//         const employee = employees.find(emp => emp.id === order.employeeId);

//         let statusClass, statusText;
//         switch(order.status) {
//             case 'completed':
//                 statusClass = 'status-completed';
//                 statusText = 'مكتمل';
//                 break;
//             case 'in-progress':
//                 statusClass = 'status-in-progress';
//                 statusText = 'قيد التنفيذ';
//                 break;
//             case 'pending':
//                 statusClass = 'status-pending';
//                 statusText = 'قيد المراجعة';
//                 break;
//             case 'cancelled':
//                 statusClass = 'status-cancelled';
//                 statusText = 'ملغي';
//                 break;
//         }

//         const tr = document.createElement('tr');
//         tr.innerHTML = `
//             <td>${order.orderNumber}</td>
//             <td>${order.clientName}</td>
//             <td>${employee ? employee.name : 'غير معين'}</td>
//             <td>${order.service}</td>
//             <td>${formatNumber(order.price)} ريال</td>
//             <td><span class="task-status ${statusClass}">${statusText}</span></td>
//             <td>
//                 <button class="btn btn-sm btn-outline-primary view-order" data-id="${order.id}">
//                     <i class="bi bi-eye"></i>
//                 </button>
//                 <button class="btn btn-sm btn-outline-success edit-order" data-id="${order.id}">
//                     <i class="bi bi-pencil"></i>
//                 </button>
//             </td>
//         `;

//         tbody.appendChild(tr);
//     });

//     // إضافة معالجات الأحداث للطلبات
//     document.querySelectorAll('.view-order').forEach(btn => {
//         btn.addEventListener('click', function() {
//             const orderId = this.getAttribute('data-id');
//             showOrderDetails(orderId);
//         });
//     });
// }

// // تحميل أفضل الموظفين
// function loadTopEmployees() {
//     const container = document.getElementById('top-employees');
//     container.innerHTML = '';

//     // حساب إيرادات كل موظف
//     const employeesWithEarnings = employees.map(employee => {
//         const employeeOrders = orders.filter(order =>
//             order.employeeId === employee.id && order.status === 'completed');

//         const earnings = employeeOrders.reduce((sum, order) => sum + order.price, 0);

//         return {
//             ...employee,
//             earnings
//         };
//     });

//     // ترتيب الموظفين حسب الإيرادات
//     const topEmployees = employeesWithEarnings
//         .sort((a, b) => b.earnings - a.earnings)
//         .slice(0, 3);

//     topEmployees.forEach(employee => {
//         const card = document.createElement('div');
//         card.className = 'employee-card d-flex align-items-center mb-3';
//         card.innerHTML = `
//             <div class="avatar bg-primary text-white me-3">${employee.avatar}</div>
//             <div>
//                 <div class="fw-bold">${employee.name}</div>
//                 <div class="small text-muted">${employee.position}</div>
//                 <div class="small text-success">${formatNumber(employee.earnings)} ريال إيرادات</div>
//             </div>
//         `;

//         container.appendChild(card);
//     });
// }

// // تهيئة الرسوم البيانية
// function initCharts() {
//     // مخطط توزيع المهام
//     const tasksCtx = document.getElementById('tasks-chart').getContext('2d');
//     new Chart(tasksCtx, {
//         type: 'doughnut',
//         data: {
//             labels: ['مكتملة', 'قيد التنفيذ', 'قيد المراجعة', 'ملغية'],
//             datasets: [{
//                 data: [45, 25, 20, 10],
//                 backgroundColor: [
//                     '#4caf50',
//                     '#2196f3',
//                     '#ffc107',
//                     '#f44336'
//                 ]
//             }]
//         },
//         options: {
//             responsive: true,
//             maintainAspectRatio: false,
//             plugins: {
//                 legend: {
//                     position: 'bottom'
//                 }
//             }
//         }
//     });

//     // مخطط إحصائيات الطلبات
//     const ordersCtx = document.getElementById('orders-chart').getContext('2d');
//     new Chart(ordersCtx, {
//         type: 'line',
//         data: {
//             labels: ['يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو'],
//             datasets: [{
//                 label: 'عدد الطلبات',
//                 data: [45, 60, 75, 80, 95, 110],
//                 borderColor: '#4361ee',
//                 backgroundColor: 'rgba(67, 97, 238, 0.1)',
//                 tension: 0.3,
//                 fill: true
//             }]
//         },
//         options: {
//             responsive: true,
//             maintainAspectRatio: false,
//             plugins: {
//                 legend: {
//                     display: false
//                 }
//             }
//         }
//     });

//     // مخطط توزيع الحالات
//     const statusCtx = document.getElementById('status-chart').getContext('2d');
//     new Chart(statusCtx, {
//         type: 'bar',
//         data: {
//             labels: ['مكتملة', 'قيد التنفيذ', 'قيد المراجعة', 'ملغية'],
//             datasets: [{
//                 label: 'عدد الطلبات',
//                 data: [45, 25, 20, 10],
//                 backgroundColor: [
//                     '#4caf50',
//                     '#2196f3',
//                     '#ffc107',
//                     '#f44336'
//                 ]
//             }]
//         },
//         options: {
//             responsive: true,
//             maintainAspectRatio: false,
//             plugins: {
//                 legend: {
//                     display: false
//                 }
//             }
//         }
//     });
// }

// // تهيئة التنقل بين الأقسام
// function initNavigation() {
//     const navLinks = document.querySelectorAll('.sidebar .nav-link');

//     navLinks.forEach(link => {
//         link.addEventListener('click', function(e) {
//             e.preventDefault();

//             // إزالة النشط من جميع الروابط
//             navLinks.forEach(l => l.classList.remove('active'));

//             // إضافة النشط للرابط الحالي
//             this.classList.add('active');

//             // إخفاء جميع الأقسام
//             const sections = document.querySelectorAll('.section-content');
//             sections.forEach(section => section.style.display = 'none');

//             // إظهار القسم المحدد
//             const targetSection = this.getAttribute('data-section');
//             document.getElementById(targetSection).style.display = 'block';
//         });
//     });

//     // تسجيل الخروج
//     document.getElementById('logout-btn').addEventListener('click', function() {
//         localStorage.removeItem('userEmail');
//         localStorage.removeItem('userRole');
//         window.location.href = 'index.html';
//     });

//     // عرض جميع الطلبات
//     document.getElementById('view-all-orders').addEventListener('click', function() {
//         // إزالة النشط من جميع الروابط
//         navLinks.forEach(l => l.classList.remove('active'));

//         // إضافة النشط لقسم الطلبات
//         document.querySelector('[data-section="orders"]').classList.add('active');

//         // إخفاء جميع الأقسام
//         const sections = document.querySelectorAll('.section-content');
//         sections.forEach(section => section.style.display = 'none');

//         // إظهار قسم الطلبات
//         document.getElementById('orders').style.display = 'block';
//     });
// }

// // تهيئة حاسبة الأرباح
// function initProfitCalculator() {
//     const totalIncomeInput = document.getElementById('total-income');
//     const totalSalariesInput = document.getElementById('total-salaries');
//     const otherExpensesInput = document.getElementById('other-expenses');
//     const netProfitElement = document.getElementById('net-profit');
//     const calculateBtn = document.getElementById('calculate-profit');

//     // حساب إجمالي رواتب الموظفين
//     const totalSalaries = employees.reduce((sum, employee) => sum + employee.salary, 0);
//     totalSalariesInput.value = totalSalaries;

//     // تحديث صافي الربح عند تغيير القيم
//     function updateNetProfit() {
//         const income = parseFloat(totalIncomeInput.value) || 0;
//         const salaries = parseFloat(totalSalariesInput.value) || 0;
//         const expenses = parseFloat(otherExpensesInput.value) || 0;

//         const profit = income - salaries - expenses;
//         netProfitElement.textContent = formatNumber(profit) + ' ريال';
//     }

//     totalIncomeInput.addEventListener('input', updateNetProfit);
//     otherExpensesInput.addEventListener('input', updateNetProfit);
//     calculateBtn.addEventListener('click', updateNetProfit);

//     // تحديث جدول مستحقات الموظفين
//     const salariesTable = document.querySelector('#salaries-table tbody');
//     salariesTable.innerHTML = '';

//     employees.forEach(employee => {
//         const tr = document.createElement('tr');
//         tr.innerHTML = `
//             <td>${employee.name}</td>
//             <td>${employee.position}</td>
//             <td>${formatNumber(employee.salary)} ريال</td>
//             <td>0 ريال</td>
//             <td>${formatNumber(employee.salary)} ريال</td>
//         `;

//         salariesTable.appendChild(tr);
//     });

//     // حساب الربح الأولي
//     updateNetProfit();
// }

// // تحميل جدول الموظفين
// function loadEmployeesTable() {
//     const tbody = document.querySelector('#employees-table tbody');
//     tbody.innerHTML = '';

//     employees.forEach(employee => {
//         const tr = document.createElement('tr');
//         tr.innerHTML = `
//             <td>${employee.name}</td>
//             <td>${employee.email}</td>
//             <td>${employee.position}</td>
//             <td>${formatNumber(employee.salary)} ريال</td>
//             <td>${employee.hireDate}</td>
//             <td><span class="badge bg-success">نشط</span></td>
//             <td>
//                 <button class="btn btn-sm btn-outline-primary edit-employee" data-id="${employee.id}">
//                     <i class="bi bi-pencil"></i>
//                 </button>
//                 <button class="btn btn-sm btn-outline-danger delete-employee" data-id="${employee.id}">
//                     <i class="bi bi-trash"></i>
//                 </button>
//             </td>
//         `;

//         tbody.appendChild(tr);
//     });

//     // إضافة معالجات الأحداث للموظفين
//     document.querySelectorAll('.delete-employee').forEach(btn => {
//         btn.addEventListener('click', function() {
//             const id = this.getAttribute('data-id');
//             if (confirm('هل أنت متأكد من حذف هذا الموظف؟')) {
//                 employees = employees.filter(emp => emp.id != id);
//                 loadEmployeesTable();
//                 initProfitCalculator();
//             }
//         });
//     });

//     // إضافة معالجات الأحداث للتعديل على الموظفين
//     document.querySelectorAll('.edit-employee').forEach(btn => {
//         btn.addEventListener('click', function() {
//             const id = this.getAttribute('data-id');
//             const employee = employees.find(emp => emp.id == id);
//             if (employee) {
//                 openEditEmployeeModal(employee);
//             }
//         });
//     });
// }

// // فتح نموذج تعديل الموظف
// function openEditEmployeeModal(employee) {
//     // ملء البيانات في النموذج
//     document.getElementById('employee-name').value = employee.name;
//     document.getElementById('employee-email').value = employee.email;
//     document.getElementById('employee-position').value = employee.position;
//     document.getElementById('employee-salary').value = employee.salary;
//     document.getElementById('employee-hire-date').value = employee.hireDate;

//     // تغيير نص الزر إلى "تحديث"
//     const submitBtn = document.querySelector('#add-employee-form button[type="submit"]');
//     submitBtn.textContent = 'تحديث الموظف';

//     // إضافة معرف الموظف إلى الزر
//     submitBtn.dataset.id = employee.id;

//     // إظهار قسم إضافة موظف
//     document.querySelector('[data-section="add-employee"]').click();

//     // إزالة الحدث القديم وإضافة حدث جديد للتحديث
//     const form = document.getElementById('add-employee-form');
//     const newForm = form.cloneNode(true);
//     form.parentNode.replaceChild(newForm, form);

//     document.getElementById('add-employee-form').addEventListener('submit', function(e) {
//         e.preventDefault();

//         const id = parseInt(submitBtn.dataset.id);
//         const employeeIndex = employees.findIndex(emp => emp.id === id);

//         if (employeeIndex !== -1) {
//             employees[employeeIndex] = {
//                 ...employees[employeeIndex],
//                 name: document.getElementById('employee-name').value,
//                 email: document.getElementById('employee-email').value,
//                 position: document.getElementById('employee-position').value,
//                 salary: parseInt(document.getElementById('employee-salary').value),
//                 hireDate: document.getElementById('employee-hire-date').value
//             };

//             alert('تم تحديث بيانات الموظف بنجاح!');
//             loadEmployeesTable();
//             initProfitCalculator();
//             this.reset();

//             // إعادة تعيين الزر إلى حالته الأصلية
//             submitBtn.textContent = 'إضافة موظف';
//             delete submitBtn.dataset.id;
//         }
//     });
// }

// // تحميل جميع الطلبات
// function loadAllOrders() {
//     const tbody = document.querySelector('#all-orders-table tbody');
//     tbody.innerHTML = '';

//     // تطبيق الفلاتر
//     const statusFilter = document.getElementById('filter-status').value;
//     const employeeFilter = document.getElementById('filter-employee').value;
//     const monthFilter = document.getElementById('filter-month').value;

//     let filteredOrders = orders;

//     if (statusFilter !== 'all') {
//         filteredOrders = filteredOrders.filter(order => order.status === statusFilter);
//     }

//     if (employeeFilter !== 'all') {
//         filteredOrders = filteredOrders.filter(order => order.employeeId == employeeFilter);
//     }

//     if (monthFilter !== 'all') {
//         filteredOrders = filteredOrders.filter(order => {
//             const orderDate = new Date(order.date);
//             return orderDate.getMonth() + 1 == monthFilter; // +1 لأن الأشهر تبدأ من 0
//         });
//     }

//     filteredOrders.forEach(order => {
//         const employee = employees.find(emp => emp.id === order.employeeId);

//         let statusClass, statusText;
//         switch(order.status) {
//             case 'completed':
//                 statusClass = 'status-completed';
//                 statusText = 'مكتمل';
//                 break;
//             case 'in-progress':
//                 statusClass = 'status-in-progress';
//                 statusText = 'قيد التنفيذ';
//                 break;
//             case 'pending':
//                 statusClass = 'status-pending';
//                 statusText = 'قيد المراجعة';
//                 break;
//             case 'cancelled':
//                 statusClass = 'status-cancelled';
//                 statusText = 'ملغي';
//                 break;
//         }

//         const today = new Date();
//         const dueDate = new Date(order.dueDate);
//         const daysLeft = Math.ceil((dueDate - today) / (1000 * 60 * 60 * 24));

//         let timerClass = 'timer-success';
//         if (daysLeft < 3) timerClass = 'timer-danger';
//         else if (daysLeft < 7) timerClass = 'timer-warning';

//         const tr = document.createElement('tr');
//         tr.innerHTML = `
//             <td>${order.orderNumber}</td>
//             <td>${order.clientName}</td>
//             <td>${order.clientPhone}</td>
//             <td>${order.service}</td>
//             <td>${formatNumber(order.price)} ريال</td>
//             <td>${employee ? employee.name : 'غير معين'}</td>
//             <td>${order.startDate}</td>
//             <td>${order.dueDate}</td>
//             <td><span class="task-status ${statusClass}">${statusText}</span></td>
//             <td>
//                 <div class="dropdown">
//                     <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
//                         <i class="bi bi-gear"></i>
//                     </button>
//                     <ul class="dropdown-menu">
//                         <li><a class="dropdown-item view-order" href="#" data-id="${order.id}">عرض التفاصيل</a></li>
//                         <li><a class="dropdown-item" href="#" data-action="assign" data-id="${order.id}">تعيين موظف</a></li>
//                         <li><a class="dropdown-item" href="#" data-action="status" data-id="${order.id}">تغيير الحالة</a></li>
//                         <li><a class="dropdown-item" href="#" data-action="edit" data-id="${order.id}">تعديل</a></li>
//                         <li><a class="dropdown-item text-danger" href="#" data-action="delete" data-id="${order.id}">حذف</a></li>
//                     </ul>
//                 </div>
//             </td>
//         `;

//         tbody.appendChild(tr);
//     });

//     // إضافة معالجات الأحداث للطلبات
//     document.querySelectorAll('.view-order').forEach(btn => {
//         btn.addEventListener('click', function() {
//             const orderId = this.getAttribute('data-id');
//             showOrderDetails(orderId);
//         });
//     });

//     // إضافة معالجات الأحداث لأزرار الإجراءات
//     document.querySelectorAll('.dropdown-item').forEach(item => {
//         item.addEventListener('click', function(e) {
//             e.preventDefault();
//             const action = this.getAttribute('data-action');
//             const orderId = this.getAttribute('data-id');
//             const order = orders.find(o => o.id == orderId);

//             if (action === 'assign') {
//                 assignEmployeeToOrder(order);
//             } else if (action === 'status') {
//                 changeOrderStatus(order);
//             } else if (action === 'edit') {
//                 editOrder(order);
//             } else if (action === 'delete') {
//                 deleteOrder(order);
//             }
//         });
//     });
// }

// // تعيين موظف للطلب
// function assignEmployeeToOrder(order) {
//     const modal = new bootstrap.Modal(document.getElementById('assignEmployeeModal'));
//     const select = document.getElementById('employee-assign-select');
//     select.innerHTML = '';

//     employees.forEach(employee => {
//         const option = document.createElement('option');
//         option.value = employee.id;
//         option.textContent = employee.name;
//         if (employee.id === order.employeeId) {
//             option.selected = true;
//         }
//         select.appendChild(option);
//     });

//     document.getElementById('assign-btn').onclick = function() {
//         const employeeId = parseInt(select.value);
//         order.employeeId = employeeId;
//         loadAllOrders();
//         modal.hide();
//         alert('تم تعيين الموظف للطلب بنجاح!');
//     };

//     modal.show();
// }

// // تغيير حالة الطلب
// function changeOrderStatus(order) {
//     const modal = new bootstrap.Modal(document.getElementById('changeStatusModal'));
//     const select = document.getElementById('status-select');
//     select.value = order.status;

//     document.getElementById('change-status-btn').onclick = function() {
//         const status = select.value;
//         order.status = status;
//         loadAllOrders();
//         modal.hide();
//         alert('تم تغيير حالة الطلب بنجاح!');
//     };

//     modal.show();
// }

// // تعديل الطلب
// function editOrder(order) {
//     const modal = new bootstrap.Modal(document.getElementById('editOrderModal'));

//     // تعبئة البيانات في النموذج
//     document.getElementById('edit-client-name').value = order.clientName;
//     document.getElementById('edit-client-phone').value = order.clientPhone;
//     document.getElementById('edit-order-number').value = order.orderNumber.replace('#', '');
//     document.getElementById('edit-service-price').value = order.price;
//     document.getElementById('edit-service-description').value = order.service;
//     document.getElementById('edit-start-date').value = order.startDate;
//     document.getElementById('edit-due-date').value = order.dueDate;

//     const employeeSelect = document.getElementById('edit-employee-assign');
//     employeeSelect.innerHTML = '';

//     employees.forEach(employee => {
//         const option = document.createElement('option');
//         option.value = employee.id;
//         option.textContent = employee.name;
//         if (employee.id === order.employeeId) {
//             option.selected = true;
//         }
//         employeeSelect.appendChild(option);
//     });

//     document.getElementById('edit-order-btn').onclick = function() {
//         order.clientName = document.getElementById('edit-client-name').value;
//         order.clientPhone = document.getElementById('edit-client-phone').value;
//         order.orderNumber = `#${document.getElementById('edit-order-number').value}`;
//         order.price = parseInt(document.getElementById('edit-service-price').value);
//         order.service = document.getElementById('edit-service-description').value;
//         order.startDate = document.getElementById('edit-start-date').value;
//         order.dueDate = document.getElementById('edit-due-date').value;
//         order.employeeId = parseInt(employeeSelect.value);

//         loadAllOrders();
//         modal.hide();
//         alert('تم تحديث بيانات الطلب بنجاح!');
//     };

//     modal.show();
// }

// // حذف الطلب
// function deleteOrder(order) {
//     if (confirm('هل أنت متأكد من حذف هذا الطلب؟')) {
//         orders = orders.filter(o => o.id !== order.id);
//         loadAllOrders();
//         alert('تم حذف الطلب بنجاح!');
//     }
// }

// // تهيئة نموذج إضافة الموظف
// function initEmployeeForm() {
//     document.getElementById('add-employee-form').addEventListener('submit', function(e) {
//         e.preventDefault();

//         const name = document.getElementById('employee-name').value;
//         const email = document.getElementById('employee-email').value;
//         const password = document.getElementById('employee-password').value;
//         const position = document.getElementById('employee-position').value;
//         const salary = document.getElementById('employee-salary').value;
//         const hireDate = document.getElementById('employee-hire-date').value;

//         if (!name || !email || !password || !position || !salary || !hireDate) {
//             alert('يرجى ملء جميع الحقول');
//             return;
//         }

//         const newEmployee = {
//             id: employees.length + 1,
//             name,
//             email,
//             position,
//             salary: parseInt(salary),
//             hireDate,
//             status: "active",
//             avatar: name.charAt(0)
//         };

//         employees.push(newEmployee);
//         alert('تم إضافة الموظف بنجاح!');
//         this.reset();
//         loadEmployeesTable();
//         initProfitCalculator();
//     });
// }

// // تهيئة نموذج إضافة الطلب
// function initOrderForm() {
//     // فتح نافذة إضافة طلب
//     document.getElementById('add-order-btn').addEventListener('click', function() {
//         const employeeSelect = document.getElementById('employee-assign');
//         employeeSelect.innerHTML = '';

//         employees.forEach(employee => {
//             const option = document.createElement('option');
//             option.value = employee.id;
//             option.textContent = employee.name;
//             employeeSelect.appendChild(option);
//         });

//         const modal = new bootstrap.Modal(document.getElementById('addOrderModal'));
//         modal.show();
//     });

//     // إرسال نموذج إضافة الطلب
//     document.getElementById('add-order-form').addEventListener('submit', function(e) {
//         e.preventDefault();

//         const clientName = document.getElementById('client-name').value;
//         const clientPhone = document.getElementById('client-phone').value;
//         const orderNumber = document.getElementById('order-number').value;
//         const servicePrice = document.getElementById('service-price').value;
//         const serviceDescription = document.getElementById('service-description').value;
//         const startDate = document.getElementById('start-date').value;
//         const dueDate = document.getElementById('due-date').value;
//         const employeeId = document.getElementById('employee-assign').value;

//         if (!clientName || !clientPhone || !orderNumber || !servicePrice || !serviceDescription || !startDate || !dueDate || !employeeId) {
//             alert('يرجى ملء جميع الحقول');
//             return;
//         }

//         const newOrder = {
//             id: orders.length + 1,
//             orderNumber: `#${orderNumber}`,
//             clientName,
//             clientPhone,
//             employeeId: parseInt(employeeId),
//             service: serviceDescription,
//             price: parseInt(servicePrice),
//             status: "pending",
//             startDate,
//             dueDate,
//             date: new Date().toISOString().split('T')[0],
//             notes: []
//         };

//         orders.push(newOrder);
//         alert('تم إضافة الطلب بنجاح!');
//         this.reset();

//         const modal = bootstrap.Modal.getInstance(document.getElementById('addOrderModal'));
//         modal.hide();

//         loadRecentOrders();
//         loadAllOrders();
//         updateDashboardStats();
//     });
// }

// // تهيئة البحث عن الموظفين
// function initEmployeeSearch() {
//     document.getElementById('search-employee-btn').addEventListener('click', function() {
//         const searchTerm = document.getElementById('employee-search').value.toLowerCase();
//         const tbody = document.querySelector('#employees-table tbody');
//         tbody.innerHTML = '';

//         const filteredEmployees = employees.filter(employee =>
//             employee.name.toLowerCase().includes(searchTerm) ||
//             employee.email.toLowerCase().includes(searchTerm) ||
//             employee.position.toLowerCase().includes(searchTerm)
//         );

//         if (filteredEmployees.length === 0) {
//             tbody.innerHTML = '<tr><td colspan="7" class="text-center">لم يتم العثور على موظفين</td></tr>';
//             return;
//         }

//         filteredEmployees.forEach(employee => {
//             const tr = document.createElement('tr');
//             tr.innerHTML = `
//                 <td>${employee.name}</td>
//                 <td>${employee.email}</td>
//                 <td>${employee.position}</td>
//                 <td>${formatNumber(employee.salary)} ريال</td>
//                 <td>${employee.hireDate}</td>
//                 <td><span class="badge bg-success">نشط</span></td>
//                 <td>
//                     <button class="btn btn-sm btn-outline-primary edit-employee" data-id="${employee.id}">
//                         <i class="bi bi-pencil"></i>
//                     </button>
//                     <button class="btn btn-sm btn-outline-danger delete-employee" data-id="${employee.id}">
//                         <i class="bi bi-trash"></i>
//                     </button>
//                 </td>
//             `;
//             tbody.appendChild(tr);
//         });

//         // إعادة إضافة معالجات الأحداث
//         document.querySelectorAll('.delete-employee').forEach(btn => {
//             btn.addEventListener('click', function() {
//                 const id = this.getAttribute('data-id');
//                 if (confirm('هل أنت متأكد من حذف هذا الموظف؟')) {
//                     employees = employees.filter(emp => emp.id != id);
//                     loadEmployeesTable();
//                     initProfitCalculator();
//                 }
//             });
//         });

//         document.querySelectorAll('.edit-employee').forEach(btn => {
//             btn.addEventListener('click', function() {
//                 const id = this.getAttribute('data-id');
//                 const employee = employees.find(emp => emp.id == id);
//                 if (employee) {
//                     openEditEmployeeModal(employee);
//                 }
//             });
//         });
//     });
// }

// // تهيئة فلاتر الطلبات
// function initOrderFilters() {
//     // تعبئة فلتر الموظفين
//     const employeeSelect = document.getElementById('filter-employee');
//     employeeSelect.innerHTML = '<option value="all">جميع الموظفين</option>';

//     employees.forEach(employee => {
//         const option = document.createElement('option');
//         option.value = employee.id;
//         option.textContent = employee.name;
//         employeeSelect.appendChild(option);
//     });

//     // فلتر الحالات
//     document.getElementById('filter-status').addEventListener('change', function() {
//         loadAllOrders();
//     });

//     // فلتر الموظفين
//     document.getElementById('filter-employee').addEventListener('change', function() {
//         loadAllOrders();
//     });

//     // فلتر الشهر
//     document.getElementById('filter-month').addEventListener('change', function() {
//         loadAllOrders();
//     });
// }

// // عرض تفاصيل الطلب
// function showOrderDetails(orderId) {
//     const order = orders.find(o => o.id == orderId);
//     if (!order) return;

//     const employee = employees.find(e => e.id == order.employeeId);

//     // حساب المدة المتبقية
//     const today = new Date();
//     const startDate = new Date(order.startDate);
//     const dueDate = new Date(order.dueDate);
//     const totalDays = Math.ceil((dueDate - startDate) / (1000 * 60 * 60 * 24));
//     const daysPassed = Math.ceil((today - startDate) / (1000 * 60 * 60 * 24));
//     const daysLeft = Math.ceil((dueDate - today) / (1000 * 60 * 60 * 24));

//     const progressPercent = Math.min(100, Math.max(0, Math.round((daysPassed / totalDays) * 100)));

//     // تعبئة البيانات
//     document.getElementById('detail-order-number').textContent = order.orderNumber;
//     document.getElementById('detail-client-name').textContent = order.clientName;
//     document.getElementById('detail-client-phone').textContent = order.clientPhone;
//     document.getElementById('detail-service').textContent = order.service;
//     document.getElementById('detail-price').textContent = formatNumber(order.price) + ' ريال';
//     document.getElementById('detail-employee').textContent = employee ? employee.name : 'غير معين';
//     document.getElementById('detail-start-date').textContent = order.startDate;
//     document.getElementById('detail-due-date').textContent = order.dueDate;
//     document.getElementById('detail-days-left').textContent = daysLeft > 0 ? daysLeft : 0;
//     document.getElementById('order-status').value = order.status;
//     document.getElementById('detail-progress-bar').style.width = `${progressPercent}%`;

//     // تعبئة الملاحظات
//     const notesContainer = document.getElementById('order-notes');
//     notesContainer.innerHTML = '';

//     if (order.notes && order.notes.length > 0) {
//         order.notes.forEach(note => {
//             const noteElement = document.createElement('div');
//             noteElement.className = 'note-bubble mb-2';
//             noteElement.innerHTML = `
//                 <div class="d-flex justify-content-between">
//                     <strong>${note.employee}</strong>
//                     <small>${note.date}</small>
//                 </div>
//                 <p class="mb-0">${note.text}</p>
//             `;
//             notesContainer.appendChild(noteElement);
//         });
//     } else {
//         notesContainer.innerHTML = '<p class="text-center text-muted">لا توجد ملاحظات</p>';
//     }

//     // إضافة معالج الحفظ
//     document.getElementById('save-order-status').addEventListener('click', function() {
//         const newStatus = document.getElementById('order-status').value;
//         order.status = newStatus;

//         // تحديث الجداول
//         loadRecentOrders();
//         loadAllOrders();
//         updateDashboardStats();

//         const modal = bootstrap.Modal.getInstance(document.getElementById('orderDetailsModal'));
//         modal.hide();

//         alert('تم تحديث حالة الطلب بنجاح!');
//     });

//     const modal = new bootstrap.Modal(document.getElementById('orderDetailsModal'));
//     modal.show();
// }

// // وظيفة مساعدة لتنسيق الأرقام
// function formatNumber(num) {
//     return new Intl.NumberFormat('ar-SA').format(num);
// }

// Sidebar Toggle Functionality
document.addEventListener('DOMContentLoaded', function() {
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.querySelector('.sidebar');

    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function(e) {
            e.preventDefault();
            sidebar.classList.toggle('active');
            // Change toggle icon
            const icon = this.querySelector('i');
            if (sidebar.classList.contains('active')) {
                icon.classList.remove('bi-list');
                icon.classList.add('bi-x');
            } else {
                icon.classList.remove('bi-x');
                icon.classList.add('bi-list');
            }
        });

        // Close sidebar when clicking outside
        document.addEventListener('click', function(e) {
            if (!sidebar.contains(e.target) &&
                !sidebarToggle.contains(e.target) &&
                sidebar.classList.contains('active')) {
                sidebar.classList.remove('active');
                const icon = sidebarToggle.querySelector('i');
                icon.classList.remove('bi-x');
                icon.classList.add('bi-list');
            }
        });
    }
});
