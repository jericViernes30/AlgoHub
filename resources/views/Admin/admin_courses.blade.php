<!doctype html>
<html>
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="{{ asset('js/scripts.js') }}"></script>
  <title>Courses | AlgoHub</title>
    <link rel="shortcut icon" href="{{asset('images/algo-logo.png')}}" type="image/x-icon">
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
                    <a href="{{route('admin.dashboard')}}" class="text-[#48494b] px-5 hover:bg-[#F2EBFB] w-full py-2">Dashboard</a>
                </div>
                <div>
                    <div onclick="courseDropdown()">
                        <a href="{{route('admin.courses')}}" class="w-full flex items-center justify-around px-5 relative bg-[#F2EBFB] border-l-4 rounded-sm border-[#632c7d]">
                            <p id="course_dd" href="" class="w-full py-2 text-[#48494b] hover:cursor-pointer">Courses</p>
                        </a>
                    </div>

                    <div onclick="studentsDropdown()">
                        <a href="{{route('admin.students')}}" class="w-full flex items-center justify-around px-5 relative hover:bg-[#F2EBFB] hover:cursor-pointer">
                            <p id="students_dd" class=" w-full py-2 text-[#48494b]">Students</p>
                        </a>
                    </div>

                    <div onclick="">
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
                                <a href="{{ route('admin.schedule') }}" class="py-2 text-[#48494b] hover:cursor-pointer">Classes</a>
                            </div>
                            <div class="w-full flex items-center px-10 relative hover:bg-[#F2EBFB] hover:cursor-pointer">
                                <a href="{{route('admin.il_schedule')}}" class="py-2 text-[#48494b] hover:cursor-pointer">Intro Lessons</a>
                            </div>
                            <div class="w-full flex items-center px-10 relative mb-4 hover:bg-[#F2EBFB] hover:cursor-pointer">
                                <a href="{{route('admin.schedule.for_scheduling')}}" class="py-2 text-[#48494b] hover:cursor-pointer">For Scheduling</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-full p-7">
                <p class="text-2xl font-medium">Courses</p>
                <div class="w-full flex gap-5 mt-5">
                    <div class="w-1/2 flex flex-col gap-5">
                        <div class="w-full">
                            <div onclick="window.location.href='course/The-Coding-Knight'" class="w-full rounded-md shadow-lg bg-white py-10">
                                <p class="text-center font-semibold">The Coding Knight</p>
                            </div>
                        </div>
                        <div class="w-full">
                            <div onclick="window.location.href='course/Digital-Literacy'" class="w-full rounded-md shadow-lg bg-white py-10">
                                <p class="text-center font-semibold">Digital Literacy</p>
                            </div>
                        </div>
                        <div class="w-full">
                            <div onclick="window.location.href='course/Visual-Programming'" class="w-full rounded-md shadow-lg bg-white py-10">
                                <p class="text-center font-semibold">Visual Programming</p>
                            </div>
                        </div>
                        <div class="w-full">
                            <div onclick="window.location.href='course/Game-Design'" class="w-full rounded-md shadow-lg bg-white py-10">
                                <p class="text-center font-semibold">Game Design</p>
                            </div>
                        </div>
                    </div>
                    <div class="w-1/2 flex flex-col gap-5">
                        <div class="w-full">
                            <div onclick="window.location.href='course/Building-Websites'" class="w-full rounded-md shadow-lg bg-white py-10">
                                <p class="text-center font-semibold">Building Websites</p>
                            </div>
                        </div>
                        <div class="w-full">
                            <div onclick="window.location.href='course/Python-Start-1'" class="w-full rounded-md shadow-lg bg-white py-10">
                                <p class="text-center font-semibold">Python Start (Year 1)</p>
                            </div>
                        </div>
                        <div class="w-full">
                            <div onclick="window.location.href='course/Python-Start-2'" class="w-full rounded-md shadow-lg bg-white py-10">
                                <p class="text-center font-semibold">Python Start (Year 2)</p>
                            </div>
                        </div>
                        <div class="w-full">
                            <div onclick="window.location.href='course/Python-Pro-1'" class="w-full rounded-md shadow-lg bg-white py-10">
                                <p class="text-center font-semibold">Python Pro (Year 1)</p>
                            </div>
                        </div>
                        <div class="w-full">
                            <div onclick="window.location.href='course/Python-Pro-2'" class="w-full rounded-md shadow-lg bg-white py-10">
                                <p class="text-center font-semibold">Python Pro (Year 2)</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>