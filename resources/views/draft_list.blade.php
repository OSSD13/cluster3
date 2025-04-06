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
                @foreach($draftRequests as $request)
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
                    {{--แก้ไข draft--}}
                    <td style="text-align: center;">
                        <a href="{{ url('/draft') }}" style="text-decoration: none;">
                            <i class="fas fa-edit" style="font-size: 24px; color: #4B49AC;"></i>
                        </a>
                        {{--ลบ draft ใบงานใหญ่--}}
                        <form action="{{ route('drafts.destroy', $request->req_id) }}"
                            
                            method="POST"
                            style="display:inline;"
                            onsubmit="return confirm('คุณต้องการลบใบสั่งงานนี้หรือไม่?');">
                          @csrf
                          @method('DELETE')
                          <button type="submit" style="background: transparent; border: none; margin-left: 30px;">
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
