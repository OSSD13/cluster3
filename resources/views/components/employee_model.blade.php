{{--
* employee_modal.blade.php
* component modal for manage employee
* @input : emp_id, emp_name, dept_id
* @output : form show table manage employee
* @author : Naphat Maneechansuk 66160099
* @Create Date : 2025-04-05
--}}

@foreach ($employees as $employee)
    <div class="modal fade" id="editEmployeeModal{{ $employee->emp_id }}" tabindex="-1"
        aria-labelledby="editEmployeeModalLabel{{ $employee->emp_id }}" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content p-4 rounded-4 shadow-lg">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold text-primary" id="editEmployeeModalLabel{{ $employee->emp_id }}">แผนก
                    </h5>
                </div>
                <div class="modal-body">
                    <form id="employeeFormEdit{{ $employee->emp_id }}"
                        action="{{ route('manage_employee_edit', ['id' => $employee->emp_id]) }}" method="POST">
                        @csrf
                        @method('put')
                        <!-- ฟิลด์เลือกแผนก -->
                        <div class="mb-4 d-flex align-items-center">
                            <label for="employeeNameEdit{{ $employee->emp_id }}"
                                class="fw-semibold text-primary me-2 mb-0" style="min-width: 60px;">แผนก :</label>
                            <select class="form-select flex-grow-1 ps-4 pe-5 rounded-3 shadow-sm" name="emp_dept_id"
                                id="employeeNameEdit{{ $employee->emp_id }}" required style="max-width: 300px;">
                                <option value="" disabled selected>เลือกแผนก...</option>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->dept_id }}"
                                        {{ $employee->department->dept_id == $department->dept_id ? 'selected' : '' }}>
                                        {{ $department->dept_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>



                        <!-- คำยืนยัน -->
                        <div class="text-center mb-4">
                            <h5 class="fw-bold text-dark">คุณต้องการบันทึกข้อมูลพนักงานใช่หรือไม่?</h5>
                        </div>

                        <!-- ปุ่ม -->
                        <div class="modal-footer border-0 justify-content-center">
                            <button type="button" class="btn btn-danger px-4 py-2 rounded-3"
                                data-bs-dismiss="modal">ยกเลิก</button>
                            <button type="submit" class="btn btn-primary px-4 py-2 rounded-3"
                                id="saveEmployeeEdit{{ $employee->emp_id }}">ยืนยัน</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach



<!-- Delete Department Modal -->
