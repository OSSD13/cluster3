<div class="tab-pane fade mt-3" id="departmentTasks">
                <ul class="nav nav-tabs">
                    <!-- แท็บย่อยสำหรับใบงานของแผนก -->
                    <li class="nav-item">
                        <a class="custom-btn active" data-bs-toggle="tab" href="#deptReceived">งานที่ได้รับ</a>
                    </li>
                    <li class="nav-item">
                        <a class="custom-btn" data-bs-toggle="tab" href="#deptInprogress">กำลังดำเนินการ</a>
                    </li>
                    <li class="nav-item">
                        <a class="custom-btn" data-bs-toggle="tab" href="#deptCompleted">เสร็จสิ้น</a>
                    </li>
                </ul>
                <div class="tab-content mt-3" style="border:none;">
                    <div class="tab-pane fade show active" id="deptReceived">
                        <table class="table table-hover">
                            <thead>
                                <tr class="table-secondary">
                                    <th class="col-3" style="padding-left:32px;">ชื่อใบงาน</th>
                                    <th class="col-3">ชื่องาน</th>
                                    <th class="col-2">ผู้มอบหมาย</th>
                                    <th class="col-2">ความสำคัญ</th>
                                    <th class="col-2">กำหนดส่ง</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($tasks['received']['dept']) && count($tasks['received']['dept']) > 0)
                                @foreach ($tasks['received']['dept'] as $task)
                                <tr class="clickable-row" data-href="{{ route('show', ['id' => $task->tsk_id]) }}">
                                    <td class="col-3" style="padding-left:32px;">{{ $workRequests[$task->tsk_req_id]->req_name}}</td>
                                    <td class="col-3">{{ $task->tsk_name }}</td>
                                    <td class="col-2">
                                        @if ($task->workRequest->req_create_type == 'ind')
                                        {{ $task->workRequest->employee->emp_name }}
                                        @endif
                                        @if ($task->workRequest->req_create_type == 'dept')
                                        {{ $task->workRequest->department->dept_name }}
                                        @endif
                                    </td>
                                    <td>
                                        @if($task->tsk_priority == 'H' )
                                        <span class="badge rounded-pill text-white text-bg-danger">สูง</span>
                                        @endif
                                        @if($task->tsk_priority == 'M' )
                                        <span class="badge rounded-pill text-white text-bg-warning">กลาง</span>
                                        @endif
                                        @if($task->tsk_priority == 'L' )
                                        <span class="badge rounded-pill text-white text-bg-success">ต่ำ</span>
                                        @endif
                                    </td>
                                    <td class="text-danger">{{ \Carbon\Carbon::parse($task->tsk_due_date)->locale('th')->isoFormat('D MMMM YYYY HH:mm') }}</td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="6" class="text-center">ไม่มีงานที่ได้รับมอบหมาย</td> <!-- ปรับ colspan เป็น 6 -->
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="deptInprogress">
                        <table class="table">
                            <thead>
                                <tr class="table-secondary">
                                    <th class="col-3" style="padding-left:32px;">ชื่อใบงาน</th>
                                    <th class="col-3">ชื่องาน</th>
                                    <th class="col-2">ผู้มอบหมาย</th>
                                    <th class="col-2">ความสำคัญ</th>
                                    <th class="col-2">กำหนดส่ง</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($tasks['inprogress']['dept']) && count($tasks['inprogress']['dept']) > 0)
                                @foreach ($tasks['inprogress']['dept'] as $task)
                                <tr class="clickable-row" data-href="{{ route('show', ['id' => $task->tsk_id]) }}">
                                    <td class="col-3" style="padding-left:32px;">{{ $workRequests[$task->tsk_req_id]->req_name}}</td>
                                    <td class="col-3">{{ $task->tsk_name }}</td>
                                    <td class="col-2">
                                        @if ($task->workRequest->req_create_type == 'ind')
                                        {{ $task->workRequest->employee->emp_name }}
                                        @endif
                                        @if ($task->workRequest->req_create_type == 'dept')
                                        {{ $task->workRequest->department->dept_name }}
                                        @endif
                                    </td>
                                    <td>
                                        @if($task->tsk_priority == 'H' )
                                        <span class="badge rounded-pill text-white text-bg-danger">สูง</span>
                                        @endif
                                        @if($task->tsk_priority == 'M' )
                                        <span class="badge rounded-pill text-white text-bg-warning">กลาง</span>
                                        @endif
                                        @if($task->tsk_priority == 'L' )
                                        <span class="badge rounded-pill text-white text-bg-success">ต่ำ</span>
                                        @endif
                                    </td>
                                    <td class="text-danger">{{ \Carbon\Carbon::parse($task->tsk_due_date)->locale('th')->isoFormat('D MMMM YYYY HH:mm') }}</td>
                                    <!-- <td class="col-2">{{ $task->tsk_due_date }}</td> -->
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="6" class="text-center">ไม่มีงานที่ได้รับมอบหมาย</td> <!-- ปรับ colspan เป็น 6 -->
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="deptCompleted">
                        <table class="table table-hover">
                            <thead>
                                <tr class="table-secondary">
                                    <th class="col-3" style="padding-left:32px;">ชื่อใบงาน</th>
                                    <th class="col-3">ชื่องาน</th>
                                    <th class="col-2">ผู้มอบหมาย</th>
                                    <th class="col-2">ความสำคัญ</th>
                                    <th class="col-2">กำหนดส่ง</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($tasks['completed']['dept']) && count($tasks['completed']['dept']) > 0)
                                @foreach ($tasks['completed']['dept'] as $task)
                                @if ( $workRequests[$task->tsk_req_id]->req_status != 'Completed' )
                                <tr class="clickable-row" data-href="{{ route('show', ['id' => $task->tsk_id]) }}">
                                    <td class="col-3" style="padding-left:32px;">{{ $workRequests[$task->tsk_req_id]->req_name}}</td>
                                    <td class="col-3">{{ $task->tsk_name }}</td>
                                    <td class="col-2">
                                        @if ($task->workRequest->req_create_type == 'ind')
                                        {{ $task->workRequest->employee->emp_name }}
                                        @endif
                                        @if ($task->workRequest->req_create_type == 'dept')
                                        {{ $task->workRequest->department->dept_name }}
                                        @endif
                                    </td>
                                    <td>
                                        @if($task->tsk_priority == 'H' )
                                        <span class="badge rounded-pill text-white text-bg-danger">สูง</span>
                                        @endif
                                        @if($task->tsk_priority == 'M' )
                                        <span class="badge rounded-pill text-white text-bg-warning">กลาง</span>
                                        @endif
                                        @if($task->tsk_priority == 'L' )
                                        <span class="badge rounded-pill text-white text-bg-success">ต่ำ</span>
                                        @endif
                                    </td>
                                    <td class="text-danger">{{ \Carbon\Carbon::parse($task->tsk_due_date)->locale('th')->isoFormat('D MMMM YYYY HH:mm') }}</td>
                                </tr>
                                @endif
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="6" class="text-center">ไม่มีงานที่ได้รับมอบหมาย</td> <!-- ปรับ colspan เป็น 6 -->
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>