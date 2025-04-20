<!doctype html>
<html>
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/5bf9be4e76.js" crossorigin="anonymous"></script>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="{{ asset('js/scripts.js') }}"></script>
  @vite('resources/css/app.css')
  <style>
    .slidedown {
        animation-duration: 0.5s;
        animation-name: slide-in;
      }
      @keyframes slide-in {
        from {
        opacity: 0;
        transform: translateY(-100%);
    }
        to {
        opacity: 1;
        transform: translateY(0);
    }
      }

      .slideup {
        animation-duration: 0.6s;
        animation-name: slide-out;
      }
      @keyframes slide-out {
        from {
        opacity: 1;
        transform: translateY(0);
    }
        to {
        opacity: 0;
        transform: translateY(-100%);
    }
      }
  </style>
</head>
<body class="bg-[#ececec]">
    <div class="w-full h-screen flex flex-col">
        <div class="w-full bg-[#632c7d] flex justify-end items-center py-2">
            <a href="{{route('admin.logout')}}" class="text-white px-10">Logout</a>
        </div>
        <div class="w-full flex h-screen bg-[#F2EBFB]">
            <div class="w-1/6 h-full bg-[#f9f9f9] text-sm">
                <div class="w-full mb-8 mt-10">
                    <img src="https://lms.alg.academy/auth/v3/img/logo.d1092e37.svg" alt="Lesson Logo" class="w-3/4 block mx-auto">
                </div>
                <div class="w-full mx-auto flex gap-5 items-center">
                    <a href="{{session('role') === 'admin' ? route('admin.dashboard') : route('staff.dashboard')}}" class="text-[#48494b] px-5 hover:bg-[#F2EBFB] w-full py-2">Dashboard</a>
                </div>
                <div>
                    <div onclick="courseDropdown()">
                        <a href="{{session('role') === 'admin' ? route('admin.courses') : route('staff.courses')}}"  class="w-full flex items-center justify-around px-5 relative bg-[#F2EBFB] border-l-4 rounded-sm border-[#632c7d]">
                            <p id="course_dd" href="" class="w-full py-2 text-[#48494b] hover:cursor-pointer">Courses</p>
                        </a>
                    </div>

                    <div onclick="studentsDropdown()">
                        <a href="{{session('role') === 'admin' ? route('admin.students') : route('staff.students')}}" class="w-full flex items-center justify-around px-5 relative hover:bg-[#F2EBFB] hover:cursor-pointer">
                            <p id="students_dd" class=" w-full py-2 text-[#48494b]">Students</p>
                        </a>
                    </div>

                    <div onclick="" class="{{session('role') !== 'admin' ? 'hidden' : ''}}">
                        <a href="{{route('admin.teachers_list')}}" class="w-full flex items-center justify-around px-5 relative hover:bg-[#F2EBFB] hover:cursor-pointer">
                            <p id="students_dd" class=" w-full py-2 text-[#48494b]">Teachers</p>
                        </a>
                    </div>

                    <div onclick="scheduleDropdown()">
                        <div class="w-full flex items-center justify-around px-5 relative py-2 hover:bg-[#F2EBFB] hover:cursor-pointer">
                            <p id="sched_dd" class=" w-full text-[#48494b]">Schedule</p>
                            <svg id="arrow2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="12" height="12"><path d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z"/></svg>
                        </div>
                        <div id="schedules" class="hidden mb-5">
                            <div class="w-full flex items-center px-10 relative hover:bg-[#F2EBFB] hover:cursor-pointer">
                                <a href="{{session('role') === 'admin' ? route('admin.schedule.for_scheduling') : route('staff.walk_in')}}" class="py-2 text-[#48494b] hover:cursor-pointer">Walk In Clients</a>
                            </div>
                            <div class="w-full flex items-center px-10 relative hover:bg-[#F2EBFB] hover:cursor-pointer">
                                <a href="{{session('role') === 'admin' ? route('admin.il_schedule') : route('staff.il_schedule')}}" class="py-2 text-[#48494b] hover:cursor-pointer">Intro Lessons</a>
                            </div>
                            <div class="w-full flex items-center px-10 relative hover:bg-[#F2EBFB] hover:cursor-pointer">
                                <a href="{{session('role') === 'admin' ? route('admin.schedule') : route('staff.schedule')}}" class="py-2 text-[#48494b] hover:cursor-pointer">Classes</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-full p-7">
                <div class="w-fit flex gap-2 items-center justify-center mb-5 text-sm">
                    <a class="text-[#632c7d]" href="{{route('admin.courses')}}">Courses</a>
                    <i class="fa-solid fa-angle-right pt-[2px]"></i>
                    <p class="pt-[1px]">Python Start Year 2</p>
                </div>
                <p class="text-2xl font-medium">Course Details - Python Start Year 2</p>
                <p class="text-sm italic">32 lessons</p>
                <div class="w-full h-[550px] overflow-auto mt-5">
                    @if($lessons->isNotEmpty())
                        @php
                            $modules = $lessons->groupBy('topic');
                        @endphp

                        @foreach($modules as $moduleName => $moduleLessons)
                            <p class="w-full px-6 text-sm py-4 bg-[#e7e7e7] text-[#888] uppercase rounded-tl-md rounded-tr-md">
                                {{ $moduleName }}
                            </p>
                            @foreach($moduleLessons as $lesson)
                                <p class="w-full px-6 text-sm py-4 bg-white border-b-2 border-[#e7e7e7]">
                                    {{$lesson->code}} {{ $lesson->lesson }}
                                </p>
                            @endforeach
                        @endforeach
                    @else
                        <p class="text-center text-gray-500">No lessons available for this course.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</body>
</html>