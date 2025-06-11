// // بيانات الموظف
// const employee = {
//     id: 1,
//     name: "سالم أحمد",
//     email: "saleh@example.com",
//     position: "مصمم جرافيك",
//     salary: 4000,
//     hireDate: "2022-01-15",
//     status: "active",
//     avatar: "س"
// };

// // بيانات المهام
// let tasks = [];

// // تهيئة لوحة التحكم عند التحميل
// document.addEventListener('DOMContentLoaded', function() {
//     // التحقق من تسجيل الدخول
//     const userRole = localStorage.getItem('userRole');
//     if (userRole !== 'employee') {
//         window.location.href = 'index.html';
//         return;
//     }

//     // تحديث بيانات الموظف
//     document.querySelector('.user-name').textContent = employee.name;
//     document.querySelector('.user-position').textContent = employee.position;
//     document.getElementById('employee-avatar').textContent = employee.avatar;
//     document.getElementById('profile-avatar').textContent = employee.avatar;

//     // تحميل مهام الموظف
//     loadEmployeeTasks();

//     // تحديث الإحصائيات
//     updateDashboardStats();

//     // تحميل قائمة المهام
//     loadTasksList();

//     // تهيئة الرسوم البيانية
//     initCharts();

//     // تهيئة التنقل بين الأقسام
//     initNavigation();

//     // تهيئة نموذج الملف الشخصي
//     initProfileForm();

//     // تهيئة أحداث المهام
//     initTaskActions();

//     // تهيئة فلاتر المهام
//     initTaskFilters();
// });

// // تحميل مهام الموظف
// function loadEmployeeTasks() {
//     // في الواقع، سيتم جلب المهام من الخادم بناءً على هوية الموظف
//     // هنا سنستخدم بيانات أولية للمثال
//     tasks = [
//         {
//             id: 1,
//             orderNumber: "#1254",
//             clientName: "عبدالله محمد",
//             clientPhone: "0551234567",
//             service: "تصميم شعار",
//             price: 800,
//             status: "completed",
//             startDate: "2023-06-10",
//             dueDate: "2023-06-15",
//             notes: []
//         },
//         {
//             id: 2,
//             orderNumber: "#1260",
//             clientName: "شركة الأفق",
//             clientPhone: "0112345678",
//             service: "تصميم كتيب",
//             price: 1200,
//             status: "in-progress",
//             startDate: "2023-06-15",
//             dueDate: "2023-06-20",
//             notes: []
//         },
//         {
//             id: 3,
//             orderNumber: "#1262",
//             clientName: "أحمد يوسف",
//             clientPhone: "0501122334",
//             service: "تصميم بوستر",
//             price: 400,
//             status: "in-progress",
//             startDate: "2023-06-15",
//             dueDate: "2023-06-18",
//             notes: []
//         },
//         {
//             id: 4,
//             orderNumber: "#1265",
//             clientName: "وليد عبدالعزيز",
//             clientPhone: "0555566778",
//             service: "هوية بصرية",
//             price: 2500,
//             status: "pending",
//             startDate: "2023-06-20",
//             dueDate: "2023-06-25",
//             notes: []
//         }
//     ];
// }

// // تحديث إحصائيات لوحة التحكم
// function updateDashboardStats() {
//     document.getElementById('total-tasks').textContent = tasks.length;

//     const completedTasks = tasks.filter(task => task.status === 'completed').length;
//     document.getElementById('completed-tasks').textContent = completedTasks;

//     const inProgressTasks = tasks.filter(task => task.status === 'in-progress').length;
//     document.getElementById('in-progress-tasks').textContent = inProgressTasks;

//     const totalEarnings = tasks.filter(task => task.status === 'completed').reduce((sum, task) => sum + task.price, 0);
//     document.getElementById('employee-earnings').textContent = formatNumber(totalEarnings);
// }

// // تحميل المهام
// function loadTasks() {
//     const tbody = document.querySelector('#tasks-table tbody');
//     tbody.innerHTML = '';

//     tasks.forEach(task => {
//         let statusClass, statusText;
//         switch(task.status) {
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

//         // حساب المدة المتبقية
//         const today = new Date();
//         const dueDate = new Date(task.dueDate);
//         const daysLeft = Math.ceil((dueDate - today) / (1000 * 60 * 60 * 24));

//         let timerClass = 'timer-success';
//         let timerText = `${daysLeft} يوم`;
//         if (daysLeft < 0) {
//             timerClass = 'timer-danger';
//             timerText = 'منتهي';
//         } else if (daysLeft < 3) {
//             timerClass = 'timer-danger';
//         } else if (daysLeft < 7) {
//             timerClass = 'timer-warning';
//         }

//         const tr = document.createElement('tr');
//         tr.innerHTML = `
//             <td>${task.orderNumber}</td>
//             <td>${task.clientName}</td>
//             <td>${task.service}</td>
//             <td>${formatNumber(task.price)} ريال</td>
//             <td>${task.dueDate}</td>
//             <td><span class="timer ${timerClass}">${timerText}</span></td>
//             <td><span class="task-status ${statusClass}">${statusText}</span></td>
//             <td>
//                 <button class="btn btn-sm btn-outline-primary view-task" data-id="${task.id}">
//                     <i class="bi bi-eye"></i>
//                 </button>
//                 <button class="btn btn-sm btn-outline-success complete-task" data-id="${task.id}">
//                     <i class="bi bi-check"></i>
//                 </button>
//                 <button class="btn btn-sm btn-outline-info add-note" data-id="${task.id}">
//                     <i class="bi bi-chat"></i>
//                 </button>
//             </td>
//         `;

//         tbody.appendChild(tr);
//     });

//     // إضافة معالجات الأحداث للمهام
//     document.querySelectorAll('.complete-task').forEach(btn => {
//         btn.addEventListener('click', function() {
//             const taskId = this.getAttribute('data-id');
//             const task = tasks.find(t => t.id == taskId);
//             if (task) {
//                 task.status = 'completed';
//                 loadTasks();
//                 loadTasksList();
//                 updateDashboardStats();
//                 alert('تم تحديث حالة المهمة إلى مكتملة!');
//             }
//         });
//     });

//     document.querySelectorAll('.add-note').forEach(btn => {
//         btn.addEventListener('click', function() {
//             const taskId = this.getAttribute('data-id');
//             document.getElementById('note-task-id').value = taskId;
//             const modal = new bootstrap.Modal(document.getElementById('addNoteModal'));
//             modal.show();
//         });
//     });
// }

// // تحميل قائمة المهام
// function loadTasksList() {
//     const container = document.getElementById('tasks-list');
//     container.innerHTML = '';

//     tasks.forEach(task => {
//         let statusClass, statusText;
//         switch(task.status) {
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

//         // حساب المدة المتبقية
//         const today = new Date();
//         const dueDate = new Date(task.dueDate);
//         const daysLeft = Math.ceil((dueDate - today) / (1000 * 60 * 60 * 24));

//         let timerClass = 'timer-success';
//         let timerText = `${daysLeft} يوم`;
//         if (daysLeft < 0) {
//             timerClass = 'timer-danger';
//             timerText = 'منتهي';
//         } else if (daysLeft < 3) {
//             timerClass = 'timer-danger';
//         } else if (daysLeft < 7) {
//             timerClass = 'timer-warning';
//         }

//         const taskDiv = document.createElement('div');
//         taskDiv.className = 'd-flex mb-3';
//         taskDiv.innerHTML = `
//             <div class="flex-shrink-0">
//                 <div class="task-status ${statusClass}">${task.id}</div>
//             </div>
//             <div class="flex-grow-1 ms-3">
//                 <div class="fw-bold">${task.service} - ${task.clientName}</div>
//                 <div class="small text-muted">تاريخ التسليم: ${task.dueDate}</div>
//                 <div class="d-flex justify-content-between">
//                     <div>الحالة: <span class="${statusClass}">${statusText}</span></div>
//                     <div>المتبقي: <span class="${timerClass}">${timerText}</span></div>
//                 </div>
//             </div>
//         `;

//         container.appendChild(taskDiv);
//     });
// }

// // تهيئة الرسوم البيانية
// function initCharts() {
//     // مخطط الأرباح الشهرية
//     const employeeCtx = document.getElementById('employee-chart').getContext('2d');
//     new Chart(employeeCtx, {
//         type: 'bar',
//         data: {
//             labels: ['يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو'],
//             datasets: [{
//                 label: 'الأرباح (ريال)',
//                 data: [3200, 4100, 3800, 4500, 5200, 4800],
//                 backgroundColor: '#4caf50'
//             }]
//         },
//         options: {
//             responsive: true,
//             maintainAspectRatio: false,
//             plugins: {
//                 legend: {
//                     display: false
//                 }
//             },
//             scales: {
//                 y: {
//                     beginAtZero: true
//                 }
//             }
//         }
//     });

//     // مخطط إجمالي الأرباح
//     const earningsCtx = document.getElementById('earnings-chart').getContext('2d');
//     new Chart(earningsCtx, {
//         type: 'line',
//         data: {
//             labels: ['يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو'],
//             datasets: [{
//                 label: 'الأرباح (ريال)',
//                 data: [3200, 4100, 3800, 4500, 5200, 4800],
//                 borderColor: '#4caf50',
//                 backgroundColor: 'rgba(76, 175, 80, 0.1)',
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
//     document.getElementById('employee-logout-btn').addEventListener('click', function() {
//         localStorage.removeItem('userEmail');
//         localStorage.removeItem('userRole');
//         window.location.href = 'index.html';
//     });

//     // عرض جميع المهام
//     document.getElementById('view-all-tasks').addEventListener('click', function() {
//         // إزالة النشط من جميع الروابط
//         navLinks.forEach(l => l.classList.remove('active'));

//         // إضافة النشط لقسم المهام
//         document.querySelector('[data-section="tasks"]').classList.add('active');

//         // إخفاء جميع الأقسام
//         const sections = document.querySelectorAll('.section-content');
//         sections.forEach(section => section.style.display = 'none');

//         // إظهار قسم المهام
//         document.getElementById('tasks').style.display = 'block';

//         // تحميل جدول جميع المهام
//         loadAllTasksTable();
//     });
// }

// // تحميل جدول جميع المهام
// function loadAllTasksTable() {
//     const tbody = document.querySelector('#all-tasks-table tbody');
//     tbody.innerHTML = '';

//     const filterValue = document.getElementById('task-filter').value;
//     let filteredTasks = tasks;

//     if (filterValue !== 'all') {
//         filteredTasks = tasks.filter(task => task.status === filterValue);
//     }

//     if (filteredTasks.length === 0) {
//         tbody.innerHTML = '<tr><td colspan="8" class="text-center">لا توجد مهام</td></tr>';
//         return;
//     }

//     filteredTasks.forEach(task => {
//         let statusClass, statusText;
//         switch(task.status) {
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

//         // حساب المدة المتبقية
//         const today = new Date();
//         const dueDate = new Date(task.dueDate);
//         const daysLeft = Math.ceil((dueDate - today) / (1000 * 60 * 60 * 24));

//         let timerClass = 'timer-success';
//         let timerText = `${daysLeft} يوم`;
//         if (daysLeft < 0) {
//             timerClass = 'timer-danger';
//             timerText = 'منتهي';
//         } else if (daysLeft < 3) {
//             timerClass = 'timer-danger';
//         } else if (daysLeft < 7) {
//             timerClass = 'timer-warning';
//         }

//         const tr = document.createElement('tr');
//         tr.innerHTML = `
//             <td>${task.orderNumber}</td>
//             <td>${task.clientName}</td>
//             <td>${task.service}</td>
//             <td>${formatNumber(task.price)} ريال</td>
//             <td>${task.dueDate}</td>
//             <td><span class="timer ${timerClass}">${timerText}</span></td>
//             <td><span class="task-status ${statusClass}">${statusText}</span></td>
//             <td>
//                 <button class="btn btn-sm btn-outline-primary view-task" data-id="${task.id}">
//                     <i class="bi bi-eye"></i>
//                 </button>
//                 <button class="btn btn-sm btn-outline-success complete-task" data-id="${task.id}">
//                     <i class="bi bi-check"></i>
//                 </button>
//                 <button class="btn btn-sm btn-outline-info add-note" data-id="${task.id}">
//                     <i class="bi bi-chat"></i>
//                 </button>
//             </td>
//         `;

//         tbody.appendChild(tr);
//     });

//     // إضافة معالجات الأحداث للمهام
//     initTaskActions();
// }

// // تهيئة أحداث المهام
// function initTaskActions() {
//     document.querySelectorAll('.complete-task').forEach(btn => {
//         btn.addEventListener('click', function() {
//             const taskId = this.getAttribute('data-id');
//             const task = tasks.find(t => t.id == taskId);
//             if (task) {
//                 task.status = 'completed';
//                 loadTasks();
//                 loadTasksList();
//                 loadAllTasksTable();
//                 updateDashboardStats();
//                 alert('تم تحديث حالة المهمة إلى مكتملة!');
//             }
//         });
//     });

//     document.querySelectorAll('.add-note').forEach(btn => {
//         btn.addEventListener('click', function() {
//             const taskId = this.getAttribute('data-id');
//             document.getElementById('note-task-id').value = taskId;
//             const modal = new bootstrap.Modal(document.getElementById('addNoteModal'));
//             modal.show();
//         });
//     });

//     document.querySelectorAll('.view-task').forEach(btn => {
//         btn.addEventListener('click', function() {
//             const taskId = this.getAttribute('data-id');
//             const task = tasks.find(t => t.id == taskId);
//             if (task) {
//                 showTaskDetails(task);
//             }
//         });
//     });
// }

// // عرض تفاصيل المهمة
// function showTaskDetails(task) {
//     const modal = new bootstrap.Modal(document.getElementById('taskDetailsModal'));

//     // تعبئة البيانات
//     document.getElementById('task-order-number').textContent = task.orderNumber;
//     document.getElementById('task-client-name').textContent = task.clientName;
//     document.getElementById('task-client-phone').textContent = task.clientPhone;
//     document.getElementById('task-service').textContent = task.service;
//     document.getElementById('task-price').textContent = formatNumber(task.price) + ' ريال';
//     document.getElementById('task-start-date').textContent = task.startDate;
//     document.getElementById('task-due-date').textContent = task.dueDate;

//     // حساب المدة المتبقية
//     const today = new Date();
//     const dueDate = new Date(task.dueDate);
//     const daysLeft = Math.ceil((dueDate - today) / (1000 * 60 * 60 * 24));
//     document.getElementById('task-days-left').textContent = daysLeft > 0 ? daysLeft : 0;

//     // حالة المهمة
//     let statusClass, statusText;
//     switch(task.status) {
//         case 'completed':
//             statusClass = 'status-completed';
//             statusText = 'مكتمل';
//             break;
//         case 'in-progress':
//             statusClass = 'status-in-progress';
//             statusText = 'قيد التنفيذ';
//             break;
//         case 'pending':
//             statusClass = 'status-pending';
//             statusText = 'قيد المراجعة';
//             break;
//         case 'cancelled':
//             statusClass = 'status-cancelled';
//             statusText = 'ملغي';
//             break;
//     }
//     document.getElementById('task-status').textContent = statusText;
//     document.getElementById('task-status').className = `task-status ${statusClass}`;

//     // ملاحظات المهمة
//     const notesContainer = document.getElementById('task-notes');
//     notesContainer.innerHTML = '';

//     if (task.notes && task.notes.length > 0) {
//         task.notes.forEach(note => {
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

//     modal.show();
// }

// // تهيئة نموذج الملف الشخصي
// function initProfileForm() {
//     // تعبئة بيانات الملف الشخصي
//     document.getElementById('profile-name').textContent = employee.name;
//     document.getElementById('profile-position').textContent = employee.position;
//     document.getElementById('profile-fullname').value = employee.name;
//     document.getElementById('profile-email').value = employee.email;
//     document.getElementById('profile-phone').value = "0551234567";
//     document.getElementById('profile-birthdate').value = "1990-05-15";

//     // تغيير الصورة
//     document.getElementById('change-avatar-btn').addEventListener('click', function() {
//         document.getElementById('avatar-upload').click();
//     });

//     document.getElementById('avatar-upload').addEventListener('change', function(e) {
//         if (e.target.files && e.target.files[0]) {
//             const reader = new FileReader();

//             reader.onload = function(event) {
//                 // تغيير الصورة في الواجهة
//                 document.getElementById('employee-avatar').textContent = '';
//                 document.getElementById('employee-avatar').style.backgroundImage = `url(${event.target.result})`;
//                 document.getElementById('profile-avatar').textContent = '';
//                 document.getElementById('profile-avatar').style.backgroundImage = `url(${event.target.result})`;

//                 // تخزين الصورة (في الواقع سيتم إرسالها للخادم)
//                 employee.avatar = event.target.result;
//                 alert('تم تغيير الصورة بنجاح!');
//             }

//             reader.readAsDataURL(e.target.files[0]);
//         }
//     });

//     // إرسال نموذج الملف الشخصي
//     document.getElementById('profile-form').addEventListener('submit', function(e) {
//         e.preventDefault();

//         const fullName = document.getElementById('profile-fullname').value;
//         const email = document.getElementById('profile-email').value;
//         const phone = document.getElementById('profile-phone').value;
//         const birthdate = document.getElementById('profile-birthdate').value;
//         const address = document.getElementById('profile-address').value;

//         // تحديث بيانات الموظف
//         employee.name = fullName;
//         employee.email = email;

//         // تحديث الواجهة
//         document.querySelector('.user-name').textContent = fullName;
//         document.getElementById('profile-name').textContent = fullName;

//         // إظهار رسالة نجاح
//         alert('تم تحديث الملف الشخصي بنجاح!');
//     });

//     // إرسال نموذج تغيير كلمة المرور
//     document.getElementById('password-form').addEventListener('submit', function(e) {
//         e.preventDefault();

//         const currentPassword = document.getElementById('current-password').value;
//         const newPassword = document.getElementById('new-password').value;
//         const confirmPassword = document.getElementById('confirm-password').value;

//         if (newPassword !== confirmPassword) {
//             alert('كلمة المرور الجديدة غير متطابقة');
//             return;
//         }

//         // هنا سيتم إرسال الطلب لتغيير كلمة المرور
//         alert('تم تغيير كلمة المرور بنجاح!');
//         this.reset();
//     });

//     // إرسال نموذج إضافة ملاحظة
//     document.getElementById('add-note-form').addEventListener('submit', function(e) {
//         e.preventDefault();

//         const taskId = document.getElementById('note-task-id').value;
//         const noteText = document.getElementById('note-text').value;
//         const task = tasks.find(t => t.id == taskId);

//         if (task) {
//             if (!task.notes) task.notes = [];
//             task.notes.push({
//                 id: task.notes.length + 1,
//                 text: noteText,
//                 date: new Date().toLocaleDateString('ar-SA'),
//                 employee: employee.name
//             });

//             alert('تم إضافة الملاحظة بنجاح!');
//             this.reset();

//             const modal = bootstrap.Modal.getInstance(document.getElementById('addNoteModal'));
//             modal.hide();
//         }
//     });
// }

// // تهيئة فلاتر المهام
// function initTaskFilters() {
//     document.getElementById('apply-filter').addEventListener('click', function() {
//         loadAllTasksTable();
//     });
// }

// // وظيفة مساعدة لتنسيق الأرقام
// function formatNumber(num) {
//     return new Intl.NumberFormat('ar-SA').format(num);
// }

// // عرض تفاصيل المرتب
// function showSalaryDetails(month) {
//     const modal = new bootstrap.Modal(document.getElementById('salaryDetailsModal'));

//     // تعبئة البيانات (في الواقع سيتم جلبها من الخادم)
//     document.getElementById('salary-month').textContent = month;
//     document.getElementById('salary-base').textContent = formatNumber(employee.salary) + ' ريال';
//     document.getElementById('salary-bonus').textContent = '500 ريال';
//     document.getElementById('salary-deduction').textContent = '200 ريال';
//     document.getElementById('salary-total').textContent = formatNumber(employee.salary + 500 - 200) + ' ريال';

//     // زر تأكيد الاستلام
//     document.getElementById('confirm-receipt').addEventListener('click', function() {
//         // في الواقع سيتم تحديث حالة المرتب في الخادم
//         alert('تم تأكيد استلام المرتب بنجاح!');
//         modal.hide();
//     });

//     modal.show();
// }
