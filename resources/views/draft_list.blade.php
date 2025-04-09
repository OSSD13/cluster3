{{--
* draft_list.blade.php
* Layout for employee dashboard
*
* @input : -
* @output : Summary_draft
* @author : Salsabeela Sa-e 66160349
* @Create Date : 2025-04-05
--}}

@extends('layouts.employee_layouts')
@section('content')
    <div class="container-fluid">
        <div style="color: #4B49AC">
        <h3>แบบร่างใบสั่งงาน</h3>
        <div class="card shadow-sm p-2">
            <table class="table table-borderless">
                <thead>
                    <tr>
                        <th style="width: 60%;">ชื่อใบสั่งงาน</th>
                        <th style="width: 20%;">จำนวนงานย่อย</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($draftRequests as $request)
                        <tr>
                            <td>
                                <div class="p-2 rounded shadow-sm bg-white border" style="margin-right: 15px;">
                                    {{ $request->req_name }}
                                </div>
                            </td>
                            <td>
                                <div class="p-2 rounded shadow-sm bg-white border text-center" style="margin-left: 10px;">
                                    {{ $request->tasks_count }}
                                </div>
                            </td>
                            {{-- แก้ไข draft --}}
                            <td style="text-align: center;">
                                <a href="{{ route('draft.edit', $request->req_id) }}" style="text-decoration: none;">
                                    <i class="fas fa-edit" style="font-size: 24px; color: #4B49AC;"></i>
                                </a>
                                {{-- ฟอร์มลบใบสั่งงาน --}}
                                <form id="delete-form-{{ $request->req_id }}"
                                    action="{{ route('drafts.destroy', $request->req_id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="confirmDelete({{ $request->req_id }})"
                                        style="background: transparent; border: none; margin-left: 30px;">
                                        <i class="fas fa-trash-alt" style="font-size: 24px; color: #ff4d4d;"></i>
                                    </button>
                                </form>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'ยืนยันการลบ?',
            text: 'คุณต้องการลบใบสั่งงานนี้ใช่หรือไม่?',
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

                // ปรับปุ่ม "ลบเลย" (แดง)
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

                // ปรับปุ่ม "ยกเลิก" (ม่วง)
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
                document.getElementById(`delete-form-${id}`).submit();
            }
        });
    }
</script>

