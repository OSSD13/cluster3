{{--
* sent.blade.php
* แสดงรายการใบงานที่ส่งแล้ว พร้อมสถานะ ความสำคัญ กำหนดส่ง และการอนุมัติ
*
* @input : $sentRequests (Collection ของ WorkRequest พร้อม tasks)
* @output : ตารางใบงานที่ส่งแล้ว พร้อมปุ่มยืนยัน และระบบค้นหา
* @author : Sarocha Dokyeesun 66160097
* @Create Date : 2025-04-09
--}}
@extends('layouts.employee_layouts')

@section('content')
    <div class="container-fluid">
        <div class="row ">
            <div class="col">
                <h2 class="mb-3" style="color: #4B49AC;"><b>รายการใบงานที่ส่งแล้ว</b></h2>
            </div>
            <div class="col">
                <div class="d-flex justify-content-end mb-3 mt-2">
                    <div class="position-relative" style="width: 300px;">
                        <i class="fas fa-search position-absolute top-50 start-0 translate-middle-y ms-3"></i>
                        <input type="text" id="searchInput" class="form-control ps-5 rounded-4 shadow-sm"
                            placeholder="Search">
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="custom-box py-0">
                <table class="table mt-3 table table-hover" style="border-collapse: separate; border-spacing: 0;"
                    id="dataTable">
                    <thead class="table-secondary">
                        <tr>
                            <th class="col-4">ชื่อใบงาน</th>
                            <th class="col-2">สถานะ</th>
                            <th class="text-center col-2">ความสำคัญ</th>
                            <th class="text-center col-3">กำหนดส่ง</th>
                            <th class="text-center">ยอมรับ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $sortedRequests = $sentRequests->sortBy([
                                fn($a, $b) => $b->tasks->pluck('tsk_status')->contains('Approved') <=>
                                    $a->tasks->pluck('tsk_status')->contains('Approved'),
                                fn($a, $b) => ($b->tasks->pluck('tsk_status')->contains('Rejected') ||
                                    $b->tasks->pluck('tsk_status')->every(fn($s) => $s === 'Completed')) <=>
                                    ($a->tasks->pluck('tsk_status')->contains('Rejected') ||
                                        $a->tasks->pluck('tsk_status')->every(fn($s) => $s === 'Completed')),
                                fn($a, $b) => \Carbon\Carbon::parse($a->tasks->max('tsk_due_date'))->timestamp <=>
                                    \Carbon\Carbon::parse($b->tasks->max('tsk_due_date'))->timestamp,
                            ]);
                        @endphp
                        @forelse ($sortedRequests as $req)
                            @php
                                $statuses = $req->tasks->pluck('tsk_status')->toArray();
                                $allCompleted =
                                    count($statuses) > 0 && collect($statuses)->every(fn($s) => $s === 'Completed');

                                $canApprove = $req->req_status === 'Completed'; // ใช้ req_status ที่อัปเดตมาจาก Controller แล้ว

                                $statusText = 'รอดำเนินการ';
                                $statusClass = 'status-dot-1';
                                $rowClass = '';
                                $latestDueDate = $req->tasks->max('tsk_due_date');

                                $thaiMonths = [
                                    1 => 'ม.ค.',
                                    2 => 'ก.พ.',
                                    3 => 'มี.ค.',
                                    4 => 'เม.ย.',
                                    5 => 'พ.ค.',
                                    6 => 'มิ.ย.',
                                    7 => 'ก.ค.',
                                    8 => 'ส.ค.',
                                    9 => 'ก.ย.',
                                    10 => 'ต.ค.',
                                    11 => 'พ.ย.',
                                    12 => 'ธ.ค.',
                                ];

                                if ($req->req_status == 'Rejected') {
                                    $statusText = 'ปฏิเสธ';
                                    $statusClass = 'status-dot-4';
                                    $rowClass = 'table-danger';
                                } elseif ($req->req_status == 'Completed') {
                                    $statusText = 'เสร็จสิ้น';
                                    $statusClass = 'status-dot-3';
                                } elseif ($req->req_status == 'In Progress') {
                                    $statusText = 'กำลังดำเนินการ';
                                    $statusClass = 'status-dot-2';
                                }

                                $latestDueDate = $req->tasks->max('tsk_due_date');

                                if ($req->req_status == 'Rejected') {
                                    $statusText = 'ปฏิเสธ';
                                    $statusClass = 'status-dot-4';
                                    $rowClass = 'table-danger';
                                } elseif ($req->req_status == 'Completed') {
                                    $statusText = 'เสร็จสิ้น';
                                    $statusClass = 'status-dot-3';
                                } elseif ($req->req_status == 'In Progress') {
                                    $statusText = 'กำลังดำเนินการ';
                                    $statusClass = 'status-dot-2';
                                }

                            @endphp
                            <tr id="row-{{ $req->req_id }}"
                                onclick="window.location='{{ route('sent_detail', ['id' => $req->req_id]) }}'"
                                style="cursor: pointer;">
                                <td>{{ $req->req_name }}</td>
                                <td>
                                    <span class="{{ $statusClass }}"></span> {{ $statusText }}
                                </td>
                                <td class="text-center">
                                    @php
                                        $priority = $req->tasks->first()?->tsk_priority ?? '-';
                                    @endphp

                                    @if ($priority === 'H')
                                        <span class="badge rounded-pill text-white" style="background-color: #E70000">
                                            สูง
                                        </span>
                                    @elseif ($priority === 'M')
                                        <span class="badge rounded-pill text-white " style="background-color: #F28D28;">
                                            กลาง
                                        </span>
                                    @elseif ($priority === 'L')
                                        <span class="badge rounded-pill text-white " style="background-color: #26BC00;">
                                            ต่ำ
                                        </span>
                                    @else
                                        <span style="color: #AFB2BA;">ไม่ระบุ</span>
                                    @endif

                                </td>
                                <td class="text-center">
                                    @if ($latestDueDate)
                                        @php
                                            $date = \Carbon\Carbon::parse($latestDueDate);
                                            $day = $date->format('d');
                                            $month = $thaiMonths[$date->month];
                                            $year = $date->year + 543;
                                            $time = $date->format('H:i');
                                        @endphp
                                        <div>{{ "$day $month $year" }}</div>
                                        <div>{{ $time }} น.</div>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($canApprove)
                                        <button class="btn btn-outline-success btn-sm"
                                            onclick="event.stopPropagation(); confirmApprove({{ $req->req_id }})">
                                            <i class="fa-solid fa-check xl"></i>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">ไม่พบข้อมูล</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <style>
        .status-dot-1,
        .status-dot-2,
        .status-dot-3,
        .status-dot-4 {
            display: inline-block;
            width: 13px;
            height: 13px;
            border-radius: 50%;
            margin-right: 5px;
        }

        .status-dot-1 {
            background-color: grey;
        }

        /* รอดำเนินการ */
        .status-dot-2 {
            background-color: #facc15;
        }

        /* กำลังดำเนินการ */
        .status-dot-3 {
            background-color: #a3e635;
        }

        /* เสร็จสิ้น */
        .status-dot-4 {
            background-color: #dc3545;
        }

        /* ปฏิเสธ */

        tr:hover {
            background-color: #f2f2f2;
            transition: 0.3s;
        }

        .table-danger {
            background-color: #f8d7da !important;
        }
    </style>

    <script>
        /*
         * confirmApprove()
         * ฟังก์ชันยืนยันการเปลี่ยนสถานะใบงานเป็น 'A' ด้วย SweetAlert
         *
         * @input : reqId (รหัสของ WorkRequest ที่ต้องการอนุมัติ)
         * @output : หากสำเร็จจะลบแถวนั้นออกจากหน้าจอ และแสดง SweetAlert
         * @author : Sarocha Dokyeesun 66160097
         * @Create Date : 2025-04-09
         */

        function confirmApprove(reqId) {
            Swal.fire({
                title: 'คุณแน่ใจหรือไม่?',
                text: 'เมื่อกดยืนยัน ใบงานจะถูกจัดเก็บ',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'ใช่, ยืนยัน!',
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
                    fetch(`/approve-request/${reqId}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                req_id: reqId
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                document.getElementById(`row-${reqId}`).remove();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'สำเร็จ',
                                    text: 'สถานะถูกอัปเดตแล้ว',
                                    confirmButtonText: 'ตกลง',
                                    buttonsStyling: false,
                                    customClass: {
                                        confirmButton: 'swal2-confirm'
                                    },
                                    didOpen: () => {
                                        Object.assign(Swal.getConfirmButton().style, {
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
                            }
                        });
                }
            });
        }
        /*
         * Search filter
         * ฟังก์ชันกรองข้อมูลในตารางตามคำที่พิมพ์ใน input
         * @author : Sarocha Dokyeesun 66160097
         * @input : คำที่ผู้ใช้พิมพ์ใน #searchInput
         * @output : แสดงเฉพาะแถวที่มีข้อความตรงกับคำค้น
         */
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const rows = document.querySelectorAll('#dataTable tbody tr');

            searchInput.addEventListener('keyup', function() {
                const keyword = this.value.toLowerCase();

                rows.forEach(row => {
                    const text = row.innerText.toLowerCase();
                    row.style.display = text.includes(keyword) ? '' : 'none';
                });
            });
        });
    </script>
@endsection