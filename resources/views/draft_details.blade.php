{{--
* draft_details.blade.php
* Display form for editing draft work request
* @input : task_name, creator_status, task_description, subtask_name, dept[], emp[], priority[], end_date[],
description[]
* @output : ข้อมูลที่แสดงจากการดึงข้อมูลในฐานข้อมูลหรือส่งออกมาจาก View นี้ เช่น ฟอร์มสำหรับการแก้ไขใบสั่งงานแบบร่าง
พร้อมงานย่อยที่เกี่ยวข้อง
* @author : Salsabeela Sa-e 66160349
* @Create Date : 2025-03-23
--}}

@extends('layouts.employee_layouts')
@section('content')
    <!-- ต้องมี script sweetalert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <form action="{{ route('draft.update', $draft->req_id) }}" method="POST" id="draft-form" novalidate>
        @method('PUT')
        @csrf
        <input type="hidden" name="submit_type" id="submit_type" value="create">
        <input type="hidden" id="deleted-tasks" name="deleted_tasks" value="">

        <div class="container-fluid">
            <div style="color: #4B49AC">
                <h3>แก้ไขแบบร่าง</h3>
            </div>

            <div class="card shadow-sm p-4">
                {{-- ชื่อใบสั่งงาน --}}
                <div class="mb-3">
                    <label class="form-label">ชื่อใบสั่งงาน <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="task_name" value="{{ $draft->req_name }}" required>

                </div>

                {{-- สถานะผู้สร้างใบสั่งงาน --}}
                <div class="mb-3">
                    <label class="form-label">สถานะผู้สร้างใบสั่งงาน <span class="text-danger">*</span></label>
                    <div class="d-inline-flex">
                        <div class="form-check me-3">
                            <input class="form-check-input" type="radio" name="creator_status" id="individual" value="ind"
                                required {{ $draft->req_create_type == 'ind' ? 'checked' : '' }}>
                            <label class="form-check-label" for="individual">นามบุคคล</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="creator_status" id="department" value="dept"
                                required {{ $draft->req_create_type == 'dept' ? 'checked' : '' }}>
                            <label class="form-check-label" for="department">นามแผนก</label>
                        </div>
                    </div>
                </div>


                {{-- คำอธิบายงาน --}}
                <div class="mb-3">
                    <label class="form-label">คำอธิบายงาน <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="task_description" name="task_description" rows="3"
                        required>{{ $draft->req_description }}</textarea>
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

        /*
        * document.addEventListener('DOMContentLoaded', ...)
        * โหลด event listener เพื่อให้ JS เริ่มทำงานเมื่อ DOM โหลดเสร็จ
        * @input : -
        * @output : set event change ให้กับ select[name="dept[]"] เพื่อโหลด employee ตามแผนก
        * @author : Sarocha Dokyeesun 66160097
        * @Create Date : 2025-04-04
        */
        document.addEventListener('DOMContentLoaded', function () {
            // เพิ่ม Event Listener สำหรับการเปลี่ยนแปลงค่าใน select[name="dept[]"]
            document.body.addEventListener('change', function (e) {
                if (e.target && e.target.name === 'dept[]') {
                    const deptSelect = e.target;
                    const deptId = deptSelect.value;

                    // หา select ของ emp ที่อยู่ใน task เดียวกัน
                    const empSelect = deptSelect.closest('.accordion-body').querySelector('select[name="emp[]"]');
                    empSelect.innerHTML = '<option disabled selected value="">-- เลือกพนักงาน --</option>';
                    const baseUrl = "{{ config('app.url') }}";
                    const url = `${baseUrl}/form/employee/${deptId}`;
                    fetch(url)
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

            // เพิ่ม Event Listener สำหรับการคลิก dropdown ของ select[name="emp[]"]
            document.body.addEventListener('focus', function (e) {
                if (e.target && e.target.name === 'emp[]') {
                    const empSelect = e.target;
                    const deptSelect = empSelect.closest('.accordion-body').querySelector('select[name="dept[]"]');
                    const deptId = deptSelect.value;

                    if (!deptId) {
                        Swal.fire({
                            title: 'กรุณาเลือกแผนกก่อน',
                            text: 'คุณต้องเลือกแผนกก่อนที่จะเลือกผู้รับมอบหมาย',
                            icon: 'warning',
                            confirmButtonText: 'ตกลง'
                        });
                        return;
                    }

                    // ดึงข้อมูลพนักงานจาก API
                    empSelect.innerHTML = '<option disabled selected value="">-- กำลังโหลดพนักงาน --</option>';
                    fetch(`/form/employee/${deptId}`)
                        .then(response => response.json())
                        .then(data => {
                            empSelect.innerHTML = '<option disabled selected value="">-- เลือกพนักงาน --</option>';
                            data.forEach(emp => {
                                const option = document.createElement('option');
                                option.value = emp.emp_id;
                                option.text = emp.emp_name;
                                empSelect.appendChild(option);
                            });
                        })
                        .catch(error => {
                            console.error('เกิดข้อผิดพลาดในการโหลดพนักงาน:', error);
                            Swal.fire({
                                title: 'เกิดข้อผิดพลาด',
                                text: 'ไม่สามารถโหลดข้อมูลพนักงานได้ กรุณาลองใหม่อีกครั้ง',
                                icon: 'error',
                                confirmButtonText: 'ตกลง'
                            });
                        });
                }
            }, true);

            // โหลดข้อมูลงานย่อยจาก PHP
            const subtasks = @json($draft->tasks); // ดึงข้อมูลงานย่อยจาก PHP
            const taskList = document.getElementById("taskList"); // อ้างอิง taskList

            // วนลูปข้อมูลงานย่อยและเพิ่มลงใน DOM
            subtasks.forEach((subtask, index) => {
                const taskId = `task${index + 1}`;
                const newTask = document.createElement("div");
                newTask.classList.add("accordion-item");
                newTask.id = `task-item-${index + 1}`;
                newTask.setAttribute('data-task-id', subtask.tsk_id); // เพิ่ม data-task-id
                newTask.innerHTML = `
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#${taskId}">
                            งานย่อย ${index + 1}
                        </button>
                    </h2>
                    <div id="${taskId}" class="accordion-collapse collapse">
                        <div class="accordion-body">
                            <div class="mb-3">
                                <label class="form-label">ชื่อใบงานย่อย <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="subtask_name[]" value="${subtask.tsk_name}" required>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <label class="form-label">แผนกรับมอบหมาย <span class="text-danger">*</span></label>
                                    <select class="form-select" name="dept[]" required>
                                        <option selected disabled value="">กรุณาเลือก</option>
                                        ${@json($dept).map(d => `
                                            <option value="${d.dept_id}" ${d.dept_id == subtask.tsk_dept_id ? 'selected' : ''}>
                                                ${d.dept_name}
                                            </option>
                                        `).join('')}
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label class="form-label">ผู้รับมอบหมาย</label>
                                    <select class="form-select" name="emp[]">
                                        <option selected disabled value="">-- เลือกพนักงาน --</option>
                                        ${subtask.employee ? `<option value="${subtask.employee.emp_id}" selected>${subtask.employee.emp_name}</option>` : ''}
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-3">
                                        <div class="col-6">
                                            <label class="form-label">ความสำคัญ <span class="text-danger">*</span></label>
                                            <select class="form-select" name="priority[]" required>
                                                <option selected disabled value="">กรุณาเลือก</option>
                                                <option value="L" ${subtask.tsk_priority == 'L' ? 'selected' : ''}>ต่ำ</option>
                                                <option value="M" ${subtask.tsk_priority == 'M' ? 'selected' : ''}>ปานกลาง</option>
                                                <option value="H" ${subtask.tsk_priority == 'H' ? 'selected' : ''}>สูง</option>
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label">วันสิ้นสุด <span class="text-danger">*</span></label>
                                            <input type="datetime-local" class="form-control" name="end_date[]" value="${subtask.tsk_due_date}" required>
                                        </div>
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label class="form-label">คำอธิบาย <span class="text-danger">*</span></label>
                                        <textarea class="form-control" name="description[]" required>${subtask.tsk_description}</textarea>
                                    </div>
                                    <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-danger" onclick="removeTask(${index + 1})">ลบ</button>
                        </div>
                    </div>
                `;
                taskList.appendChild(newTask);
            });

            // อัปเดตตัวนับ task
            taskCount = subtasks.length + 1;
        });

        /*
        * addTask()
        * เพิ่ม task ย่อยใหม่ลงใน accordion
        * @input : -
        * @output : แสดง task ย่อยใหม่ใน DOM
        */
        function addTask() {
            const departments = @json($dept); // ดึงข้อมูลแผนกจาก PHP
            const taskList = document.getElementById("taskList"); // อ้างอิง taskList
            const taskId = `task${taskCount}`; // สร้าง ID สำหรับ task ใหม่
            const deptOptions = departments.map(d =>
                `<option value="${d.dept_id}">${d.dept_name}</option>`).join(''); // สร้างตัวเลือกแผนก

            // สร้างโครงสร้าง HTML สำหรับ task ใหม่
            const newTask = document.createElement("div");
            newTask.classList.add("accordion-item");
            newTask.id = `task-item-${taskCount}`;
            newTask.innerHTML = `
                        <h2 class="accordion-header" >
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#${taskId}">
                                งานย่อย ${taskCount}
                            </button>
                        </h2>
                        <div id="${taskId}" class="accordion-collapse collapse">
                            <div class="accordion-body">
                                <div class="mb-3">
                                    <label class="form-label">ชื่อใบงานย่อย <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="subtask_name[]" required>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <label class="form-label">แผนกรับมอบหมาย <span class="text-danger">*</span></label>
                                        <select class="form-select" name="dept[]" required>
                                            <option selected disabled value="">กรุณาเลือก</option>
                                            ${deptOptions}
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">ผู้รับมอบหมาย</label>
                                        <select class="form-select" name="emp[]">
                                            <option selected disabled value="">กรุณาเลือก</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-6">
                                        <label class="form-label">ความสำคัญ <span class="text-danger">*</span></label>
                                        <select class="form-select" name="priority[]" required>
                                            <option selected disabled value="">กรุณาเลือก</option>
                                            <option value="L">ต่ำ</option>
                                            <option value="M">ปานกลาง</option>
                                            <option value="H">สูง</option>
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">วันสิ้นสุด <span class="text-danger">*</span></label>
                                        <input type="datetime-local" class="form-control" name="end_date[]" required>
                                    </div>
                                </div>
                                <div class="mb-3 mt-3">
                                    <label class="form-label">คำอธิบาย <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="description[]" placeholder="กรุณากรอกคำอธิบาย" required></textarea>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-danger" onclick="removeTask(${taskCount})">ลบ</button>
                                </div>
                            </div>
                        </div>
                    `;

            taskList.appendChild(newTask); // เพิ่ม task ใหม่ลงใน taskList
            taskCount++; // เพิ่มตัวนับ task
        }

        /*
        * removeTask(id)
        * ลบ task ย่อยออกจากหน้า และอัปเดตหมายเลข
        * @input : id ของ task ย่อย
        * @output : ลบ DOM element ของ task ย่อยออกไป พร้อมอัปเดตหมายเลข task ใหม่ทั้งหมดในหน้าเพจ
        */
        function removeTask(id) {
            Swal.fire({
                title: 'ยืนยันการลบ?',
                text: 'คุณต้องการลบงานย่อยนี้ใช่หรือไม่?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'ยืนยัน',
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

        /*
         * updateTaskNumbers()
         * อัปเดตหมายเลขงานย่อยเมื่อมีการลบ
         * @input : -
         * @output : ปรับหมายเลข, ID, target ของ task ใหม่ทั้งหมดให้เรียงลำดับถูกต้องใน DOM
         * @author : Sarocha Dokyeesun 66160097
         * @Create Date : 2025-03-18
         */
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

        /*
         * validateFormFields(form)
         * ตรวจสอบความถูกต้องของฟอร์ม ก่อนส่ง submit
         * @input : form DOM object
         * @output : boolean ผลการตรวจสอบ (true = valid, false = invalid) และแสดงข้อความ error หากไม่ผ่าน
         * @author : Sarocha Dokyeesun 66160097
         * @Create Date : 2025-03-05
         */
        function validateFormFields(form) {
            const inputs = form.querySelectorAll("input[required], select[required], textarea[required]");
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
                const parent = input.closest('.form-group, .mb-3, .col, .col-6') || input.parentElement;
                const fieldName = input.name;

                // ลบข้อความ error เก่าก่อน
                const oldError = parent.querySelector('.invalid-feedback');
                if (oldError) oldError.remove();

                if (!input.value || input.value === "0") {
                    input.classList.add("is-invalid");

                    const error = document.createElement("div");
                    error.className = "invalid-feedback";

                    // ตั้งข้อความ error เฉพาะเจาะจงตาม name
                    let message = "กรุณากรอกข้อมูลให้ครบถ้วน";
                    if (fieldName === "task_name") message = "กรุณากรอกชื่อใบสั่งงาน";
                    if (fieldName === "creator_status") message = "กรุณาเลือกสถานะผู้สร้าง";
                    if (fieldName === "task_description") message = "กรุณากรอกคำอธิบายงาน";

                    if (fieldName === "subtask_name[]") message = "กรุณากรอกชื่อใบงานย่อย";
                    if (fieldName === "dept[]") message = "กรุณาเลือกแผนกรับมอบหมาย";
                    if (fieldName === "priority[]") message = "กรุณาเลือกความสำคัญ";
                    if (fieldName === "end_date[]") message = "กรุณาระบุวันสิ้นสุด";
                    if (fieldName === "description[]") message = "กรุณากรอกคำอธิบาย";

                    error.textContent = message;
                    parent.appendChild(error);
                    isValid = false;
                } else {
                    input.classList.remove("is-invalid");
                }
            });

            return isValid;
        }

        document.getElementById("create-task-btn").addEventListener("click", function (e) {
            e.preventDefault();
            const form = document.getElementById('draft-form');

            if (!validateFormFields(form)) return;

            Swal.fire({
                title: 'ยืนยันการสร้างใบสั่งงาน?',
                text: 'โปรดยืนยันว่าคุณต้องการสร้างใบสั่งงานนี้',
                icon: 'success',
                showCancelButton: true,
                confirmButtonText: 'ยืนยัน',
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
                    document.getElementById('submit_type').value = 'create'; // set ค่านี้ก่อน submit
                    form.submit();
                }
            });
        });

        document.getElementById("save-draft-btn").addEventListener("click", function (e) {
            e.preventDefault();
            const form = document.getElementById('draft-form');

            if (!validateFormFields(form)) return;

            Swal.fire({
                title: 'บันทึกแบบร่าง?',
                text: 'คุณต้องการบันทึกงานนี้เป็นแบบร่างใช่ไหม?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'บันทึก',
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
                    document.getElementById('submit_type').value = 'draft'; // set เป็น draft
                    form.submit();
                    // Redirect to draft_list after submission
                    form.addEventListener('submit', function () {
                        window.location.href = "{{ route('draft_list') }}";
                    });
                }
            });
        });
    </script>
@endsection
