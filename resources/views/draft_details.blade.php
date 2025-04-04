{{--
* employee_layouts.blade.php
* Layout for employee dashboard
*
* @input : -
* @output : Employee_layout_with_header_and_sidebar
* @author : Salsabeela Sa-e 66160349
* @Create Date : 2025-03-20
--}}

@extends('layouts.employee_layouts')
@section('content')
    <div class="container-fluid ">
        <div class="">
            <h3>แบบร่างใบสั่งงาน</h3>
        </div>
        <div class="card shadow-sm p-4 ">
            <div class="mb-3">
                <label class="form-label">ชื่อใบสั่งงาน</label>
                {{-- ดึง database มา --}}
                <input type="text" class="form-control">
            </div>
            <div class="mb-3 col">
    <label class="form-label">สถานะผู้สร้างใบสั่งงาน</label>
    <div class="d-flex">
        <div class="form-check me-3">
            <input class="form-check-input" type="radio" name="creatorStatus" id="individual" value="individual">
            <label class="form-check-label" for="individual">
                นามบุคคล
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="creatorStatus" id="department" value="department">
            <label class="form-check-label" for="department">
                นามแผนก
            </label>
        </div>
    </div>
</div>
            <div class="mb-3">
                <label class="form-label">คำอธิบายงาน</label>
                <input type="text" class="form-control" style="height: 100px">
            </div>
        </div>
        {{-- งานย่อย  --}}
        <div class="shadow-sm accordion mt-4" id="taskAccordion">
            {{-- ตรงนี้จะเพิ่มงานย่อยใหม่ --}}
            <div class="accordion" id="taskAccordion">
                <div id="taskList"></div>
            </div>
        </div>

        {{-- ปุ่มเพิ่มงานย่อย --}}
        <button class=" btn btn-outline-lightt mt-3" style="border: 1px solid #4B49AC;color:#4B49AC ;background-color:#ffffff" onclick="addTask()">+ เพิ่มงานย่อย</button>

        <div class="d-flex justify-content-end my-4">
            <button class="btn btn-secondary">แบบร่าง</button>
            &nbsp;&nbsp;
            <button class=" btn btn-outline-lightt"  style="border: 1px solid #2B467E;color:#ffffff ;background-color:#4B49AC">สร้างใบสั่งงาน</button>
        </div>
        <br>
    </div>
    </div>

    <script>
        // เริ่มจากงานย่อย 1
        let taskCount = 1;

        function addTask() {
            const taskList = document.getElementById("taskList");
            const taskId = `task${taskCount}`;
            const newTask = document.createElement("div");
            newTask.classList.add("accordion-item");
            newTask.id = `task-item-${taskCount}`;
            newTask.innerHTML = `
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#${taskId}">
                    งานย่อย ${taskCount}
                </button>
            </h2>
            <div id="${taskId}" class="accordion-collapse collapse ">
                <div class="accordion-body">
    <div class="mb-3 col">
        <label class="form-label">
            ชื่อใบงานย่อย
        </label>
        <input type="text" class="form-control">
    </div>
    <div class="row">
        <div class="col mb-3">
            <label class="form-label">แผนกรับมอบหมาย</label>
            <select class="form-select">
                <option selected>กรุณาเลือก</option>
                <option>บุคคล</option>
                <option>แผนก</option>
            </select>
        </div>

        <div class="col mb-3">
            <label class="form-label">ผู้รับมอบหมาย</label>
            <select class="form-select">
                <option selected>กรุณาเลือก</option>
                <option>บุคคล</option>
                <option>แผนก</option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col mb-3">
            <label class="form-label">ความสำคัญ</label>
            <select class="form-select">
                <option selected>กรุณาเลือก</option>
                <option>ต่ำ</option>
                <option>ปานกลาง</option>
                <option>สูง</option>
            </select>
        </div>

        <div class="col mb-3">
            <label class="form-label">วันสิ้นสุด</label>
            <input type="date" class="form-control">
        </div>
    </div>

    <div class="mb-3">
        <textarea class="form-control" rows="3" placeholder="รายละเอียดเพิ่มเติม"></textarea>
    </div>

    <!-- ปุ่มลบงานย่อย -->
    <div class="d-flex justify-content-end">
        <button class="btn btn-danger" onclick="removeTask(${taskCount})">ลบ</button>
    </div>
</div>

        `;
            taskList.appendChild(newTask);
            taskCount++;
        }

function removeTask(id) {
    const taskToRemove = document.getElementById(`task-item-${id}`);
    if (taskToRemove) {
        taskToRemove.remove();
        updateTaskNumbers(); // รีเซ็ตเลขงานย่อยใหม่หลังจากลบ
    }
}

function updateTaskNumbers() {
    const taskList = document.getElementById("taskList").children;
    taskCount = 1; // รีเซ็ตตัวนับ
    for (let i = 0; i < taskList.length; i++) {
        const taskItem = taskList[i];
        taskItem.id = `task-item-${taskCount}`;
        const button = taskItem.querySelector(".accordion-button");
        button.innerText = `งานย่อย ${taskCount}`;
        button.setAttribute("data-bs-target", `#task${taskCount}`);

        const collapseDiv = taskItem.querySelector(".accordion-collapse");
        collapseDiv.id = `task${taskCount}`;

        const deleteButton = taskItem.querySelector(".btn-danger");
        deleteButton.setAttribute("onclick", `removeTask(${taskCount})`);

        taskCount++;
    }
}
    </script>
@endsection
