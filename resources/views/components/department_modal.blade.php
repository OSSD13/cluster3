{{--
* department_modal.blade.php
* component modal for manage department
* @input : dept_name
* @output : new department
* @author : Natthanan Sirisurayut 66160352
* @Create Date : 2025-03-19
--}}
<!-- Add Department Modal -->
<div class="modal fade" id="addDepartmentModal" tabindex="-1" aria-labelledby="addDepartmentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDepartmentModalLabel">เพิ่มแผนก</h5>
            </div>
            <div class="modal-body">
                <form id="departmentFormAdd" action="{{ route('department.createDepartment') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="departmentNameAdd" class="form-label">ชื่อแผนก</label>
                            <input type="text" class="form-control" name="dept_name" id="departmentNameAdd"
                                placeholder="กรอกชื่อแผนก..." required>
                            <div class="invalid-feedback">***กรุณากรอกข้อมูลให้ครบถ้วน</div>
                        </div>
                        <div class="confirmation-text">
                            <h5>คุณต้องการบันทึกข้อมูลการสร้างแผนกใหม่หรือไม่?</h5>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">ยกเลิก</button>
                        <button type="submit" class="btn btn-save" id="saveDepartmentAdd">บันทึก</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Loop สำหรับแสดง Modal แก้ไขแผนก -->
@foreach ($departments as $department)
    <div class="modal fade" id="editDepartmentModal{{ $department->dept_id }}" tabindex="-1" aria-labelledby="editDepartmentModalLabel{{ $department->dept_id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editDepartmentModalLabel{{ $department->dept_id }}">แก้ไขข้อมูล</h5>
                </div>
                <div class="modal-body">
                    <form id="departmentFormEdit{{ $department->dept_id }}" action="{{ route('department.updateDepartment', ['id' => $department->dept_id]) }}" method="POST">
                        @csrf
                        @method('put')
                        <div class="mb-3">
                            <label for="departmentNameEdit{{ $department->dept_id }}" class="form-label">ชื่อแผนก</label>
                            <input type="text" class="form-control" name="dept_name" value="{{ $department->dept_name }}" id="departmentNameEdit{{ $department->dept_id }}" placeholder="กรอกชื่อแผนก..." required>
                            <div class="invalid-feedback">***กรุณากรอกข้อมูลให้ครบถ้วน</div>
                        </div>
                        <div class="confirmation-text">
                            <h5>ต้องการบันทึกข้อมูลแผนกหรือไม่?</h5>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">ยกเลิก</button>
                            <button type="submit" class="btn btn-save" id="saveDepartmentEdit{{ $department->dept_id }}">บันทึก</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach

<!-- Delete Department Modal -->
@foreach ($departments as $department)
<div class="modal fade" id="deleteDepartmentModal{{ $department->dept_id }}" tabindex="-1" aria-labelledby="deleteDepartmentModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteDepartmentModalLabel">ลบข้อมูล</h5>
            </div>
            <div class="modal-body text-center">
                <i class="bi bi-trash-fill" style="color: #DC3545;font-size: 4rem;"></i>
                <div class="confirmation-text">
                    <h5>ยืนยันการลบข้อมูลหรือไม่</h5>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">ยกเลิก</button>
                <form id="departmentFormDelete{{ $department->dept_id }}" action="{{ route('department.deleteDepartment', ['id' => $department->dept_id]) }}" method="POST">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-save" id="saveDepartmentDelete">ลบ</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
