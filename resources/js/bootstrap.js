import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

document.addEventListener('DOMContentLoaded', function() {
    document.body.addEventListener('change', function(e) {
        if (e.target && e.target.matches('select[name="dept"]')) {
            const deptSelect = e.target;
            const deptId = deptSelect.value;

            // หา select ของ emp ที่อยู่ใน task เดียวกัน
            const empSelect = deptSelect.closest('.accordion-body').querySelector(
                'select[name="emp"]');
            empSelect.innerHTML = '<option value="">-- เลือกพนักงาน --</option>';

            fetch(`/form/${deptId}`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(emp => {
                        const option = document.createElement('option');
                        option.value = emp.emp_id;
                        option.text = emp.emp_name;
                        empSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('เกิดข้อผิดพลาดในการโหลดพนักงาน:', error));
        }
    });
});
