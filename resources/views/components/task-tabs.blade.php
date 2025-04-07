{{-- 
* components/task-tabs.blade.php
* Task tabs (my / department)
--}}

@php
    use Illuminate\Support\Str;
@endphp

<ul class="nav nav-tabs" id="taskTabs">
    <li class="nav-item">
        <a class="nav-link {{ Str::startsWith(Route::currentRouteName(), 'task.my') ? 'active' : '' }}" 
           href="{{ route('task.my') }}">
            ใบงานของฉัน
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ Str::startsWith(Route::currentRouteName(), 'task.dept') ? 'active' : '' }}" 
           href="{{ route('task.dept') }}">
            ใบงานของแผนก
        </a>
    </li>
</ul>
