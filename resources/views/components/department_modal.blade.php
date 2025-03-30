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

    <!-- Edit Department Modal -->
    <div class="modal fade" id="editDepartmentModal" tabindex="-1" aria-labelledby="editDepartmentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editDepartmentModalLabel">แก้ไขข้อมูล</h5>
                </div>
                <div class="modal-body">
                    <form id="departmentFormEdit">
                        <div class="mb-3">
                            <label for="departmentNameEdit" class="form-label">ชื่อแผนก</label>
                            <input type="text" class="form-control" id="departmentNameEdit"
                                placeholder="กรอกชื่อแผนก..." required>
                            <div class="invalid-feedback">***กรุณากรอกข้อมูลให้ครบถ้วน</div>
                        </div>
                        <div class="confirmation-text">
                            <h5>ต้องการบันทึกข้อมูลแผนกหรือไม่?</h5>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="button" class="btn btn-save" id="saveDepartmentEdit">บันทึก</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Delete Department Modal -->
    <div class="modal fade" id="deleteDepartmentModal" tabindex="-1" aria-labelledby="deleteDepartmentModalLabel"
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
                    <button type="button" class="btn btn-save" id="saveDepartmentDelete">ลบ</button>
                </div>
            </div>
        </div>
    </div>

