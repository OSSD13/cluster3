{{--
* draft_details.blade.php
* Layout for employee dashboard
*
* @input : -
* @output : Details_of_draft_work_request
* @author : Salsabeela Sa-e 66160349
* @Create Date : 2025-03-20
--}}

@extends('layouts.employee_layouts')
@section('content')

    <form action="{{ route('draft.update', $draft->draft_id) }}" method="POST" id="draft-form" novalidate>
        @method('PUT')
        <input type="hidden" name="submit_type" id="submit_type" value="create">
        @csrf
        <div class="container-fluid">
            <div style="color: #4B49AC">
                <h3>แก้ไขแบบร่าง</h3>
            </div>

            <div class="card shadow-sm p-4">
                {{-- ชื่อใบสั่งงาน --}}
                <div class="mb-3">
                    <label class="form-label">ชื่อใบสั่งงาน <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="task_name"
    value="{{ $draft->req_name }}" required>

                </div>

                {{-- สถานะผู้สร้างใบสั่งงาน --}}
<div class="mb-3">
    <label class="form-label">สถานะผู้สร้างใบสั่งงาน <span class="text-danger">*</span></label>
    <div class="d-inline-flex">
        <div class="form-check me-3">
            <input class="form-check-input" type="radio" name="creator_status" id="individual"
                value="ind" required
                {{ $draft->req_create_type == 'ind' ? 'checked' : '' }}>
            <label class="form-check-label" for="individual">นามบุคคล</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="creator_status" id="department"
                value="dept" required
                {{ $draft->req_create_type == 'dept' ? 'checked' : '' }}>
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
        document.addEventListener('DOMContentLoaded', function() {
            document.body.addEventListener('change', function(e) {
                if (e.target && e.target.name === 'dept[]') {
                    const deptSelect = e.target;
                    const deptId = deptSelect.value;

                    // หา select ของ emp ที่อยู่ใน task เดียวกัน
                    const empSelect = deptSelect.closest('.accordion-body').querySelector(
                        'select[name="emp[]"]');
                    empSelect.innerHTML = '<option disabled selected value="">-- เลือกพนักงาน --</option>';

                    fetch(`/form/employee/${deptId}`)
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
                <h2 class="accordion-header">
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
                                <input type="date" class="form-control" name="end_date[]" required>
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
                confirmButtonText: 'ลบเลย',
                cancelButtonText: 'ยกเลิก',
                reverseButtons: true
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
    </script>
@endsection
