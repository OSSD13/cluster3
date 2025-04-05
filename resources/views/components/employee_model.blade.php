{{--
* employee_modal.blade.php
* component modal for manage employee
* @input : emp_id, emp_name, dept_id
* @output : form show table manage employee
* @author : Naphat Maneechansuk 66160099
* @Create Date : 2025-04-05
--}}

@foreach ($employees as $employee)
    <div class="modal fade" id="editEmployeeModal{{ $employee->emp_id }}" tabindex="-1" aria-labelledby="editEmployeeModalLabel{{ $employee->emp_id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editEmployeeModalLabel{{ $employee->emp_id }}">แก้ไขข้อมูล</h5>
                </div>
                <div class="modal-body">
                    <form id="employeeFormEdit{{ $employee->emp_id }}" action="{{ route('manage_employee_edit', ['id' => $employee->emp_id]) }}" method="POST">
                        @csrf
                        @method('put')
                        <div class="mb-3">
                            <label for="employeeNameEdit{{ $employee->emp_id }}" class="form-label">ชื่อแผนก</label>
                            <select class="form-select" name="emp_dept_id" id="employeeNameEdit{{ $employee->emp_id }}" required>
                                <option value="" disabled>เลือกแผนก...</option>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->dept_id }}" {{ $employee->department->dept_id == $department->dept_id ? 'selected' : '' }}>
                                        {{ $department->dept_name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">***กรุณากรอกข้อมูลให้ครบถ้วน</div>
                        </div>
                        <div class="confirmation-text">
                            <h5>ต้องการบันทึกข้อมูลแผนกหรือไม่?</h5>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">ยกเลิก</button>
                            <button type="submit" class="btn btn-save" id="saveEmployeeEdit{{ $employee->emp_id }}">บันทึก</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach

<!-- Delete Department Modal -->

