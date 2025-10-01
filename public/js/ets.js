


// function renderCourses() {
//     const container = document.getElementById('coursesContainer');
//     if (!container) return;

//     container.innerHTML = '';

//     courses.forEach(course => {
//         const div = document.createElement('div');
//         div.className = 'form-check mb-2';
//         div.innerHTML = `
//             <input class="form-check-input" type="checkbox" id="course-${course.id}" data-id="${course.id}" data-credits="${course.credits}">
//             <label class="form-check-label" for="course-${course.id}">
//                 ${course.name} (${course.credits} SKS)
//             </label>
//         `;
//         container.appendChild(div);
//     });
// }

// /**
//  * Update total SKS berdasarkan checkbox yang dipilih
//  */
// function updateTotalCredits() {
//     let total = 0;
//     document.querySelectorAll('.course-checkbox:checked').forEach(checkbox => {
//         const credits = checkbox.dataset.credits;
//         if (credits) {
//             total += parseInt(credits, 10);
//         }
//     });
//     const creditsElement = document.getElementById('creditsCount');
//     if (creditsElement) {
//         creditsElement.textContent = total;
//     }
// }

// /**
//  * Validasi form enroll: minimal 1 checkbox dipilih
//  * @returns {boolean}
//  */
// function validateForm() {
//     const checked = document.querySelectorAll('.course-checkbox:checked');
//     const errorMessage = document.getElementById('errorMessage');

//     if (checked.length === 0) {
//         if (errorMessage) {
//             errorMessage.style.display = 'block';
//         }
//         return false;
//     }

//     if (errorMessage) {
//         errorMessage.style.display = 'none';
//     }
//     return true;
// }

// // ================================
// // EVENT HANDLING
// // ================================

// /**
//  * Setup validasi real-time untuk form course (create/edit)
//  */
// function setupCourseValidation() {
//     const fields = ['course_name', 'credits', 'semester', 'description'];
//     fields.forEach(field => {
//         const input = document.getElementById(field);
//         if (!input) return;

//         input.addEventListener('input', function () {
//             if (this.value.trim() === '') {
//                 this.classList.add('is-invalid');
//             } else {
//                 this.classList.remove('is-invalid');
//             }
//         });
//     });
// }

// /**
//  * Setup validasi real-time untuk form student
//  */
// function setupValidation() {
//     const fields = ['full_name', 'username', 'email','password', 'entry_year'];
//     fields.forEach(field => {
//         const input = document.getElementById(field);
//         if (!input) return;

//         input.addEventListener('input', function ()  {
//             const errorElement = document.getElementById(`error_${field}`);
//             if (this.value.trim() === '') {
//                 this.classList.add('is-invalid');
//                 if (errorElement) {
//                     errorElement.textContent = `${this.previousElementSibling.textContent} wajib diisi.`;
//                 }
//             } else {
//                 this.classList.remove('is-invalid');
//                 if (errorElement) {
//                     errorElement.textContent = '';
//                 }
//             }
//         });
//     });
// }

// /**
//  * Setup validasi untuk form select (admin)
//  */
// function setupAdminValidation() {
//     const selects = ['student_id', 'course_id'];
//     selects.forEach(field => {
//         const select = document.getElementById(field);
//         if (!select) return;

//         select.addEventListener('change', function () {
//             const errorElement = document.getElementById(`error_${field}`);
//             if (this.value === '') {
//                 this.classList.add('is-invalid');
//                 if (errorElement) {
//                     errorElement.textContent = `${this.previousElementSibling.textContent} wajib dipilih.`;
//                 }
//             } else {
//                 this.classList.remove('is-invalid');
//                 if (errorElement) {
//                     errorElement.textContent = '';
//                 }
//             }
//         });
//     });
// }

// /**
//  * Setup konfirmasi hapus (mahasiswa & enroll)
//  */
// function setupDeleteConfirmation() {
//     document.addEventListener('click', function (e) {
//         // Hapus mahasiswa
//         if (e.target.classList.contains('delete-btn')) {
//             const name = e.target.dataset.name;
//             const username = e.target.dataset.username || 'N/A';
//             const email = e.target.dataset.email || 'N/A';

//             const message = `Hapus mahasiswa berikut?\n\nNama: ${name}\nUsername: ${username}\nEmail: ${email}\n\nTindakan ini tidak bisa dibatalkan.`;

//             if (confirm(message)) {
//                 const form = e.target.closest('form');
//                 if (form) form.submit();
//             }
//         }

//         // Hapus enroll
//         if (e.target.classList.contains('delete-take-btn')) {
//             const student = e.target.dataset.student;
//             const course = e.target.dataset.course;
//             const credits = e.target.dataset.credits;

//             const message = `Hapus enroll berikut?\n\nMahasiswa: ${student}\nMata Kuliah: ${course} (${credits} SKS)\n\nTindakan ini tidak bisa dibatalkan.`;

//             if (confirm(message)) {
//                 const form = e.target.closest('form');
//                 if (form) form.submit();
//             }
//         }

//         // Hapus mata kuliah
//         if (e.target.classList.contains('delete-course-btn')) {
//             const name = e.target.dataset.name;
//             const credits = e.target.dataset.credits;

//             const message = `Hapus mata kuliah berikut?\n\nNama: ${name}\nSKS: ${credits}\n\nTindakan ini tidak bisa dibatalkan.`;

//             if (confirm(message)) {
//                 const form = e.target.closest('form');
//                 if (form) form.submit();
//             }
//         }
//     });
// }

// // ================================
// // UI ENHANCEMENT
// // ================================

// /**
//  * Highlight menu aktif berdasarkan URL
//  */
// function setActiveMenu() {
//     const currentPath = window.location.pathname;

//     document.querySelectorAll('[data-nav]').forEach(link => {
//         const target = link.dataset.nav;
//         let isActive = false;

//         // Mahasiswa
//         if (target === 'enroll' && currentPath.includes('/mahasiswa/enroll')) {
//             isActive = true;
//         } else if (target === 'view' && currentPath.includes('/mahasiswa/view-courses')) {
//             isActive = true;
//         }

//         // Admin
//         if (target === 'courses' && currentPath.includes('/admin/courses')) {
//             isActive = true;
//         } else if (target === 'students' && currentPath.includes('/admin/students')) {
//             isActive = true;
//         }

//         if (isActive) {
//             link.classList.add('active');
//             link.style.fontWeight = 'bold';
//             link.style.color = '#fff';
//             link.style.borderBottom = '2px solid #fff';
//         } else {
//             link.classList.remove('active');
//             link.style.fontWeight = '';
//             link.style.color = '';
//             link.style.borderBottom = '';
//         }
//     });
// }

// // ================================
// // INITIALIZATION
// // ================================

// /**
//  * Inisialisasi semua fitur saat DOM siap
//  */
// document.addEventListener('DOMContentLoaded', function () {
//     // Pasang event listener untuk checkbox course
//     document.querySelectorAll('.course-checkbox').forEach(checkbox => {
//         checkbox.addEventListener('change', updateTotalCredits);
//     });

//     // Validasi saat submit form enroll
//     const enrollForm = document.getElementById('enrollForm');
//     if (enrollForm) {
//         enrollForm.addEventListener('submit', function (e) {
//             if (!validateForm()) {
//                 e.preventDefault();
//             }
//         });
//     }

//     // Jalankan fitur lainnya
    
//     setupValidation();
//     setupAdminValidation();
//     setupDeleteConfirmation();

//     setTimeout(() => {
//         renderCourses();
//     }, 2000);
    
//     setActiveMenu();
//     setupCourseValidation();

// });