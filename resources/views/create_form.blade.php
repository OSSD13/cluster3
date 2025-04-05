{{-- 
* employee_layouts.blade.php
* Layout for employee dashboard
*
* @input : -
* @output : Employee_layout_with_header_and_sidebar
* @author : Sarocha Dokyeesun 66160097
* @Create Date : 2025-03-18
--}}
@extends('layouts.employee_layouts')
@section('content')
    <form form action="{{ route('form.create') }}" method="POST" id="work-form" novalidate>
        @csrf

        <div class="container-fluid">
            <div style="color: #4B49AC">
                <h3>สร้างใบสั่งงาน</h3>
            </div>

            <div class="card shadow-sm p-4">
                {{-- ชื่อใบสั่งงาน --}}
                <div class="mb-3">
                    <label class="form-label">ชื่อใบสั่งงาน <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="task_name" required>
                </div>

                {{-- สถานะผู้สร้างใบสั่งงาน --}}
                <div class="mb-3">
                    <label class="form-label">สถานะผู้สร้างใบสั่งงาน <span class="text-danger">*</span></label>
                    <div class="d-inline-flex">
                        <div class="form-check me-3">
                            <input class="form-check-input" type="radio" name="creator_status" id="individual"
                                value="ind" required>
                            <label class="form-check-label" for="individual">นามบุคคล</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="creator_status" id="department"
                                value="dept" required>
                            <label class="form-check-label" for="department">นามแผนก</label>
                        </div>
                    </div>
                </div>

                {{-- คำอธิบายงาน --}}
                <div class="mb-3">
                    <label class="form-label">คำอธิบายงาน</label>
                    <textarea class="form-control" rows="3" name="task_description" placeholder="รายละเอียดเพิ่มเติม"
                        style="vertical-align: top;"></textarea>
                </div>
            </div>

            {{-- Accordion สำหรับงานย่อย --}}
            <div class="shadow-sm accordion mt-4" id="taskAccordion">
                <div class="accordion" id="taskAccordion">
                    <div id="taskList"></div>
                </div>
            </div>

            {{-- ปุ่มเพิ่มงานย่อย --}}
            <button type="button" onclick="addTask()" id="add-task-btn" class="btn btn-outline-light mt-3"
                style="border: 1px solid #4B49AC; color: #4B49AC; background-color: #ffffff;">
                + เพิ่มงานย่อย
            </button>

            {{-- ปุ่มบันทึกและสร้าง --}}
            <div class="d-flex justify-content-end my-4">
                <button type="submit" class="btn btn-secondary" name="submit_type" value="draft"
                    id="save-draft-btn">แบบร่าง</button>
                &nbsp;&nbsp;
                <button type="submit" class="btn btn-outline-light" name="submit_type" value="create" id="create-task-btn"
                    style="border: 1px solid #2B467E; color: #ffffff; background-color: #4B49AC">
                    สร้างใบสั่งงาน
                </button>
            </div>
        </div>
    </form>

    <script>
        let taskCount = 1;

        function addTask() {
            const departments = @json($dept);
            const taskList = document.getElementById("taskList");
            const taskId = `task${taskCount}`;

            const deptOptions = departments.map(d =>
                `<option value="${d.dept_id}">${d.dept_name}</option>`).join('');

            const newTask = document.createElement("div");
            newTask.classList.add("accordion-item");
            newTask.id = `task-item-${taskCount}`;
            newTask.innerHTML = `
    <h2 class="accordion-header">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#${taskId}">
            งานย่อย ${taskCount}
        </button>
    </h2>
    <div id="${taskId}" class="accordion-collapse collapse">
        <div class="accordion-body">
            <div class="mb-3 col">
                <label class="form-label">ชื่อใบงานย่อย <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="subtask_name[]" required>
            </div>
            <div class="row">
                <div class="col">
                    <label class="form-label">แผนกรับมอบหมาย <span class="text-danger">*</span></label>
                    <select class="form-select" name="dept[]" required>
                        <option selected value="0">กรุณาเลือก</option>
                        ${deptOptions}
                    </select>
                </div>
                <div class="col">
                    <label class="form-label">ผู้รับมอบหมาย</label>
                    <select class="form-select" name="emp[]">
                        <option selected value="0">กรุณาเลือก</option>
                    </select>
                </div>
                <div class="mb">
                    <small class="form-text text-danger">
                        * หากไม่เลือกผู้รับมอบหมาย จะถือว่าส่งให้แผนกโดยรวม
                    </small>
                </div>
            </div>
            <div class="row">
                <div class="col mb-3 mt-2">
                    <label class="form-label">ความสำคัญ <span class="text-danger">*</span></label>
                    <select class="form-select" name="priority[]" required>
                        <option selected disabled value="">กรุณาเลือก</option>
                        <option value="L">ต่ำ</option>
                        <option value="M">ปานกลาง</option>
                        <option value="H">สูง</option>
                    </select>
                </div>
                <div class="col mb-3 mt-2">
                    <label class="form-label">วันสิ้นสุด <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" name="end_date[]" required>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">คำอธิบาย</label>
                <textarea class="form-control" rows="3" name="description[]"></textarea>
            </div>
            <div class="d-flex justify-content-end">
                <button type="button"  class="btn btn-danger" onclick="removeTask(${taskCount})">ลบ</button>
            </div>
        </div>
    </div>`;
            taskList.appendChild(newTask);
            taskCount++;
        }

        function removeTask(id) {
            Swal.fire({
                title: 'ยืนยันการลบ?',
                text: 'คุณต้องการลบงานย่อยนี้ใช่หรือไม่?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'ลบเลย',
                cancelButtonText: 'ยกเลิก',
                reverseButtons: true,
                customClass: {
                    confirmButton: 'swal2-confirm',
                    cancelButton: 'swal2-cancel'
                },
                buttonsStyling: false,
                didOpen: () => {
                    const confirmBtn = Swal.getConfirmButton();
                    const cancelBtn = Swal.getCancelButton();

                    // ปุ่มแดง: "ลบเลย"
                    Object.assign(confirmBtn.style, {
                        backgroundColor: '#DC3545',
                        color: '#fff',
                        border: 'none',
                        borderRadius: '12px',
                        padding: '8px 24px',
                        fontSize: '1.1rem',
                        fontWeight: '400',
                        marginLeft: '10px',
                        boxShadow: '0 2px 6px rgba(0,0,0,0.1)'
                    });

                    // ปุ่มม่วง: "ยกเลิก"
                    Object.assign(cancelBtn.style, {
                        backgroundColor: '#4D47C3',
                        color: '#fff',
                        border: 'none',
                        borderRadius: '12px',
                        padding: '8px 24px',
                        fontSize: '1.1rem',
                        fontWeight: '400',
                        marginRight: '10px',
                        boxShadow: '0 2px 6px rgba(0,0,0,0.1)'
                    });
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const taskToRemove = document.getElementById(`task-item-${id}`);
                    if (taskToRemove) {
                        taskToRemove.remove();
                        updateTaskNumbers();
                    }
                }
            });
        }

        function updateTaskNumbers() {
            const taskItems = document.querySelectorAll("#taskList .accordion-item");
            taskCount = 1;
            taskItems.forEach((taskItem) => {
                taskItem.id = `task-item-${taskCount}`;
                const button = taskItem.querySelector(".accordion-button");
                const newTaskId = `task${taskCount}`;
                button.innerText = `งานย่อย ${taskCount}`;
                button.setAttribute("data-bs-target", `#${newTaskId}`);
                const collapseDiv = taskItem.querySelector(".accordion-collapse");
                collapseDiv.id = newTaskId;
                const deleteButton = taskItem.querySelector(".btn-danger");
                deleteButton.setAttribute("onclick", `removeTask(${taskCount})`);
                taskCount++;
            });
        }

        function validateFormFields(form) {
            const inputs = form.querySelectorAll("input[required], select[required]");
            let isValid = true;

            const taskList = document.querySelectorAll("#taskList .accordion-item");
            if (taskList.length === 0) {
                Swal.fire({
                    title: 'ไม่สามารถส่งฟอร์มได้',
                    text: 'กรุณาเพิ่มอย่างน้อย 1 งานย่อยก่อนส่งใบสั่งงาน',
                    icon: 'error',
                    confirmButtonText: 'ตกลง',
                    buttonsStyling: false,
                    customClass: {
                        confirmButton: 'swal2-confirm'
                    },
                    didOpen: () => {
                        const confirmBtn = Swal.getConfirmButton();
                        Object.assign(confirmBtn.style, {
                            backgroundColor: '#4B49AC',
                            color: '#fff',
                            borderRadius: '12px',
                            fontWeight: '400',
                            fontSize: '1rem',
                            padding: '8px 24px',
                            border: 'none'
                        });
                    }
                });
                return false;
            }

            inputs.forEach(input => {
                if (!input.value || input.value === "0") {
                    input.classList.add("is-invalid");
                    isValid = false;
                } else {
                    input.classList.remove("is-invalid");
                }
            });

            return isValid;
        }

        document.getElementById("create-task-btn").addEventListener("click", function(e) {
            e.preventDefault();
            const form = document.getElementById('work-form');

            if (!validateFormFields(form)) return;

            Swal.fire({
                title: 'ยืนยันการสร้างใบสั่งงาน?',
                text: 'โปรดยืนยันว่าคุณต้องการสร้างใบสั่งงานนี้',
                icon: 'success',
                showCancelButton: true,
                confirmButtonText: 'สร้างเลย',
                cancelButtonText: 'ยกเลิก',
                reverseButtons: true,
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'swal2-confirm',
                    cancelButton: 'swal2-cancel'
                },
                didOpen: () => {
                    const confirmBtn = Swal.getConfirmButton();
                    const cancelBtn = Swal.getCancelButton();

                    Object.assign(confirmBtn.style, {
                        backgroundColor: '#4B49AC', 
                        color: '#fff',
                        borderRadius: '12px',
                        fontWeight: '400',
                        fontSize: '1rem',
                        padding: '8px 24px',
                        marginLeft: '10px',
                        border: 'none'
                    });

                    Object.assign(cancelBtn.style, {
                        backgroundColor: '#DC3545', 
                        color: '#fff',
                        borderRadius: '12px',
                        fontWeight: '400',
                        fontSize: '1rem',
                        padding: '8px 24px',
                        marginRight: '10px',
                        border: 'none'
                    });
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });

        document.getElementById("save-draft-btn").addEventListener("click", function(e) {
            e.preventDefault();
            const form = document.getElementById('work-form');

            if (!validateFormFields(form)) return;

            Swal.fire({
                title: 'บันทึกแบบร่าง?',
                text: 'คุณต้องการบันทึกงานนี้เป็นแบบร่างใช่ไหม?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'ใช่, บันทึก',
                cancelButtonText: 'ยกเลิก',
                reverseButtons: true,
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'swal2-confirm',
                    cancelButton: 'swal2-cancel'
                },
                didOpen: () => {
                    const confirmBtn = Swal.getConfirmButton();
                    const cancelBtn = Swal.getCancelButton();

                    Object.assign(confirmBtn.style, {
                        backgroundColor: '#4B49AC',
                        color: '#fff',
                        borderRadius: '12px',
                        fontWeight: '400',
                        fontSize: '1rem',
                        padding: '8px 24px',
                        marginLeft: '10px',
                        border: 'none'
                    });

                    Object.assign(cancelBtn.style, {
                        backgroundColor: '#DC3545', 
                        color: '#fff',
                        borderRadius: '12px',
                        fontWeight: '400',
                        fontSize: '1rem',
                        padding: '8px 24px',
                        marginRight: '10px',
                        border: 'none'
                    });
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    </script>
@endsection
