<!doctype html>
<html>
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="{{ asset('js/scripts.js') }}"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <title>Introductory Lesson Schedules | AlgoHub</title>
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
<body class="bg-[#ececec] overflow-hidden">
    <div id="il_sched" class="hidden w-1/4 bg-[#632c7d] rounded-lg absolute transform top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-sm z-10">
        <div class="w-full flex flex-col bg-[#f9f7fc]">
            <div class="w-full flex justify-between bg-[#632c7d] p-4 rounded-tl-xl rounded-tr-xl">
                <p class="text-white">Add new IL Schedule</p>
                <button id="closeForm" class="text-white flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="14" height="14" fill="#f9f9f9"><path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/></svg>
                </button>
                <script>
                    $(document).ready(function(){
                        $('#closeForm').on('click', function(){
                            $('#il_sched').addClass('hidden')
                            body.style.filter = 'blur(0px)'
                        })
                    })
                </script>
            </div>
            <div class="w-full p-4">
                <form action="{{route('admin.add_il_schedule')}}" method="POST" class="w-full">
                    @csrf
                        <select name="course" class="mb-4 w-full text-center px-1 py-1 rounded-md border border-[#a9a9a9] focus:border-[#632c7d] outline-none">
                            <option selected disabled>-- Please select a course --</option>
                            @foreach ($courses as $course)
                                <option value="{{$course->course_name}}">{{$course->course_name}}</option>
                            @endforeach
                        </select>
                        <label for="" class="font-medium">Teacher</label>
                        <select name="teacher" class="mt-1 mb-4 w-full text-center px-1 py-1 rounded-md border border-[#a9a9a9] focus:border-[#632c7d] outline-none">
                            <option selected disabled>-- Select a teacher --</option>
                            @foreach ($teachers as $teacher)
                                <option value="{{$teacher->id}}">{{$teacher->first_name}}</option>
                            @endforeach
                        </select>
                        <div class="w-full flex justify-evenly gap-1 mb-4">
                            <div class="flex flex-col w-full">
                                <label for="" class="mb-1">Day</label>
                                <select name="day" id="" class="w-full text-center px-1 py-1 rounded-md border border-[#a9a9a9] focus:border-[#632c7d] outline-none">
                                    <option value="Monday">Monday</option>
                                    <option value="Tuesday">Tuesday</option>
                                    <option value="Wednesday">Wednesday</option>
                                    <option value="Thursday">Thursday</option>
                                    <option value="Friday">Friday</option>
                                    <option value="Saturday">Saturday</option>
                                    <option value="Sunday">Sunday</option>
                                </select>
                            </div>
                        </div>
                        <div class="w-full flex gap-4 items-center justify-center mb-4">
                            <div class="w-1/2">
                                <label for="" class="">From</label>
                                <div class="w-full flex gap-2 items-center mt-1">
                                    <select name="from_a" id="" class="w-full text-center px-1 py-1 rounded-md border border-[#a9a9a9] focus:border-[#632c7d] outline-none">
                                        @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                    </select>
                                    <p class="font-bold">:</p>
                                    <select name="from_b" id="" class="w-full text-center px-1 py-1 rounded-md border border-[#a9a9a9] focus:border-[#632c7d] outline-none">
                                        <option value="00">00</option>
                                        <option value="01">01</option>
                                        <option value="02">02</option>
                                        <option value="03">03</option>
                                        <option value="04">04</option>
                                        <option value="05">05</option>
                                        <option value="06">06</option>
                                        <option value="07">07</option>
                                        <option value="08">08</option>
                                        <option value="09">09</option>
                                        @for ($i = 10; $i <= 60; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                    <select name="from_tm" id="">
                                        <option value="AM">AM</option>
                                        <option value="PM">PM</option>
                                    </select>
                                </div>
                            </div>
                            <div class="w-1/2">
                                <label for="" class="">To</label>
                                <div class="w-full flex gap-2 items-center mt-1">
                                    <select name="to_a" id="" class="w-full text-center px-1 py-1 rounded-md border border-[#a9a9a9] focus:border-[#632c7d] outline-none">
                                        @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                    </select>
                                    <p class="font-bold">:</p>
                                    <select name="to_b" id="" class="w-full text-center px-1 py-1 rounded-md border border-[#a9a9a9] focus:border-[#632c7d] outline-none">
                                        <option value="00">00</option>
                                        <option value="01">01</option>
                                        <option value="02">02</option>
                                        <option value="03">03</option>
                                        <option value="04">04</option>
                                        <option value="05">05</option>
                                        <option value="06">06</option>
                                        <option value="07">07</option>
                                        <option value="08">08</option>
                                        <option value="09">09</option>
                                        @for ($i = 10; $i <= 60; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                    <select name="to_tm" id="">
                                        <option value="AM">AM</option>
                                        <option value="PM">PM</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="w-full py-2 bg-[#632c7d] text-white rounded-md">Add</button>
                </form>
            </div>
        </div>
    </div>
    <div id="body" class="w-full h-screen flex flex-col z-0">
        <div class="w-full bg-[#632c7d] flex items-center justify-end py-2 px-10 gap-5">
            <p class="text-sm text-white">Hi, admin!</p>
            <button onclick="window.location.href='{{route('admin.logout')}}'" class="w-fit">
                <img src="{{asset('images/logout.png')}}" alt="PUTANGINANG IMAGE" class="w-2/3">
            </button>
        </div>
        <div class="w-full flex h-screen bg-[#F2EBFB]">
            <div class="w-1/6 h-full bg-[#f9f9f9] text-sm">
                <div class="w-full mb-8 mt-10">
                    <img src="https://lms.alg.academy/auth/v3/img/logo.d1092e37.svg" alt="Lesson Logo" class="w-3/4 block mx-auto">
                </div>
                <div class="w-full mx-auto flex gap-5 items-center hover:bg-[#F2EBFB]">
                    <a href="{{route('admin.dashboard')}}" class="text-[#48494b] px-5 py-2 w-full">Dashboard</a>
                </div>
                {{-- navigations --}}
                <div>
                    <div onclick="courseDropdown()">
                        <a href="{{route('admin.courses')}}" class="w-full flex items-center justify-around px-5 relative hover:bg-[#F2EBFB]">
                            <p id="course_dd" href="" class="w-full py-2 text-[#48494b] hover:cursor-pointer">Courses</p>
                        </a>
                    </div>

                    <div onclick="studentsDropdown()">
                        <div class="w-full flex items-center justify-around px-5 relative py-2 hover:cursor-pointer hover:bg-[#F2EBFB]">
                            <p id="sched_dd" class=" w-full text-[#48494b]">Students</p>
                            <svg id="arrow2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="12" height="12"><path d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z"/></svg>
                        </div>
                        <div id="students" class="hidden">
                            <div class="w-full flex items-center px-10 relative hover:bg-[#F2EBFB] hover:cursor-pointer">
                                <a href="{{ route('admin.students') }}" class="py-2 text-[#48494b] hover:cursor-pointer">Enrolled Students</a>
                            </div>
                            <div class="w-full flex items-center px-10 relative hover:bg-[#F2EBFB] hover:cursor-pointer">
                                <a href="{{route('admin.expelled')}}" class="py-2 text-[#48494b] hover:cursor-pointer">Expelled Students</a>
                            </div>
                            <div class="w-full flex items-center px-10 relative hover:bg-[#F2EBFB] hover:cursor-pointer">
                                <a href="{{route('admin.archived')}}" class="py-2 text-[#48494b] hover:cursor-pointer">Archived Students</a>
                            </div>
                        </div>
                    </div>

                    <div onclick="">
                        <a href="{{route('admin.teachers_list')}}" class="w-full flex items-center justify-around px-5 relative hover:bg-[#F2EBFB]">
                            <p id="students_dd" class=" w-full py-2 text-[#48494b]">Teachers</p>
                        </a>
                    </div>

                    <div onclick="scheduleDropdown()">
                        <div class="w-full flex items-center justify-around px-5 relative py-2 bg-[#F2EBFB] border-l-4 rounded-sm border-[#632c7d] hover:cursor-pointer">
                            <p id="sched_dd" class=" w-full text-[#48494b]">Schedule</p>
                            <svg id="arrow2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="12" height="12"><path d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z"/></svg>
                        </div>
                        <div id="schedules" class="hidden mb-5">
                            <div class="w-full flex items-center px-10 relative hover:bg-[#F2EBFB] hover:cursor-pointer">
                                <a href="{{route('admin.schedule.for_scheduling')}}" class="py-2 text-[#48494b] hover:cursor-pointer">Walk In Clients</a>
                            </div>
                            <div class="w-full flex items-center px-10 relative hover:bg-[#F2EBFB] hover:cursor-pointer">
                                <a href="{{route('admin.il_schedule')}}" class="py-2 text-[#48494b] hover:cursor-pointer">Intro Lessons</a>
                            </div>
                            <div class="w-full flex items-center px-10 relative hover:bg-[#F2EBFB] hover:cursor-pointer">
                                <a href="{{ route('admin.schedule') }}" class="py-2 text-[#48494b] hover:cursor-pointer">Classes</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-full p-4">
                <div class="w-full mx-auto bg-[#f9f9f9] rounded-md p-4 text-sm">
                    <p class="text-lg font-semibold text-center mb-4">Introductory lesson schedules</p>
                    <div class="mb-5 w-full flex justify-between">
                        <button onclick="showAddIlSched()" class="flex items-center gap-2 bg-[#632c7d] rounded-sm px-4 py-1">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="14" height="14" fill="white"><path d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z"/></svg>
                            <p class="text-white">Add IL Schedule</p>
                        </button>
                    </div>
                    <div class="w-full flex justify-between mb-4">
                        <div class="w-[9.09%]"></div>
                        <div class="w-[9.09%]">10:00 AM</div>
                        <div class="w-[9.09%]">11:00 AM</div>
                        <div class="w-[9.09%]">12:00 PM</div>
                        <div class="w-[9.09%]">1:00 PM</div>
                        <div class="w-[9.09%]">2:00 PM</div>
                        <div class="w-[9.09%]">3:00 PM</div>
                        <div class="w-[9.09%]">4:00 PM</div>
                        <div class="w-[9.09%]">5:00 PM</div>
                        <div class="w-[9.09%]">6:00 PM</div>
                        <div class="w-[9.09%]">7:00 PM</div>
                    </div>
                    <script>
                        $(document).ready(function() {
                            // Iterate over each course container in the course-div
                            $('.course-div').each(function() {
                                $(this).find('.course-container').each(function() {
                                    var courseName = $(this).find('.course').text().trim(); // Get course name from each container
                    
                                    // Apply background color based on the course name
                                    switch (courseName) {
                                        case "Graphic Design":
                                            $(this).addClass("bg-teal-300");
                                            break;
                                        case "Visual Programming":
                                            $(this).addClass("bg-yellow-300");
                                            break;
                                        case "Game Design":
                                            $(this).addClass("bg-orange-300");
                                            break;
                                        case "Python Start":
                                            $(this).addClass("bg-red-300");
                                            break;
                                        case "Python Pro":
                                            $(this).addClass("bg-red-500 text-white");
                                            break;
                                        case "Coding Knight":
                                            $(this).addClass("bg-green-300");
                                            break;
                                        case "Digital Literacy":
                                            $(this).addClass("bg-sky-300");
                                            break;
                                        case "Building Website":
                                            $(this).addClass("bg-purple-300");
                                            break;
                                        case "Unity Game Development":
                                            $(this).addClass("bg-purple-500 text-white");
                                            break;
                                        case "Frontend Development":
                                            $(this).addClass("bg-blue-300");
                                            break;
                                        default:
                                            // Optional: Add a default class if needed
                                            break;
                                    }
                                });
                            });
                        });
                    </script>
                    
                    <div class="w-full flex flex-col gap-10 pb-4 font-medium course-div">
                        <div class="w-full flex items-center">
                            <p class="w-[9.09%]">Mon</p>
                            @php
                                $timeslots = [
                                    '10:00 AM', '11:00 AM', '12:00 PM', '1:00 PM', '2:00 PM',
                                    '3:00 PM', '4:00 PM', '5:00 PM', '6:00 PM', '7:00 PM'
                                ];
                            @endphp

                            @foreach ($timeslots as $timeslot)
                                @php
                                    $scheduleForTime = $schedule->where('day', 'Monday')->where('from', $timeslot)->first();
                                @endphp

                                <div onclick="window.location.href='/admin/open_il/{{ $scheduleForTime->code ?? '' }}'" class="course-container cursor-pointer w-[9.09%] py-2 rounded-md overflow-hidden text-nowrap">
                                    @if ($scheduleForTime)
                                        <p class="course text-xs px-2">
                                            {{ $scheduleForTime->course }}
                                        </p>
                                    @else
                                        <p class="course text-xs px-2">
                                        </p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        <div class="w-full flex items-center">
                            <p class="w-[9.09%]">Tue</p>
                            @php
                                $timeslots = [
                                    '10:00 AM', '11:00 AM', '12:00 PM', '1:00 PM', '2:00 PM',
                                    '3:00 PM', '4:00 PM', '5:00 PM', '6:00 PM', '7:00 PM'
                                ];
                            @endphp

                            @foreach ($timeslots as $timeslot)
                                @php
                                    $scheduleForTime = $schedule->where('day', 'Tuesday')->where('from', $timeslot)->first();
                                @endphp

                                <div onclick="window.location.href='/admin/open_il/{{ $scheduleForTime->code ?? '' }}'" class="course-container cursor-pointer w-[9.09%] py-2 rounded-md overflow-hidden text-nowrap">
                                    @if ($scheduleForTime)
                                        <p class="course text-xs px-2">
                                            {{ $scheduleForTime->course }}
                                        </p>
                                    @else
                                        <p class="course text-xs px-2">
                                        </p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        <div class="w-full flex items-center">
                            <p class="w-[9.09%]">Wed</p>
                            @php
                                $timeslots = [
                                    '10:00 AM', '11:00 AM', '12:00 PM', '1:00 PM', '2:00 PM',
                                    '3:00 PM', '4:00 PM', '5:00 PM', '6:00 PM', '7:00 PM'
                                ];
                            @endphp

                            @foreach ($timeslots as $timeslot)
                                @php
                                    $scheduleForTime = $schedule->where('day', 'Wednesday')->where('from', $timeslot)->first();
                                @endphp

                                <div onclick="window.location.href='/admin/open_il/{{ $scheduleForTime->code ?? '' }}'" class="course-container cursor-pointer w-[9.09%] py-2 rounded-md overflow-hidden text-nowrap">
                                    @if ($scheduleForTime)
                                        <p class="course text-xs px-2">
                                            {{ $scheduleForTime->course }}
                                        </p>
                                    @else
                                        <p class="course text-xs px-2">
                                        </p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        <div class="w-full flex items-center">
                            <p class="w-[9.09%]">Thu</p>
                            @php
                                $timeslots = [
                                    '10:00 AM', '11:00 AM', '12:00 PM', '1:00 PM', '2:00 PM',
                                    '3:00 PM', '4:00 PM', '5:00 PM', '6:00 PM', '7:00 PM'
                                ];
                            @endphp

                            @foreach ($timeslots as $timeslot)
                                @php
                                    $scheduleForTime = $schedule->where('day', 'Thursday')->where('from', $timeslot)->first();
                                @endphp

                                <div onclick="window.location.href='/admin/open_il/{{ $scheduleForTime->code ?? '' }}'" class="course-container cursor-pointer w-[9.09%] py-2 rounded-md overflow-hidden text-nowrap">
                                    @if ($scheduleForTime)
                                        <p class="course text-xs px-2">
                                            {{ $scheduleForTime->course }}
                                        </p>
                                    @else
                                        <p class="course text-xs px-2">
                                        </p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        <div class="w-full flex items-center">
                            <p class="w-[9.09%]">Fri</p>
                            @php
                                $timeslots = [
                                    '10:00 AM', '11:00 AM', '12:00 PM', '1:00 PM', '2:00 PM',
                                    '3:00 PM', '4:00 PM', '5:00 PM', '6:00 PM', '7:00 PM'
                                ];
                            @endphp

                            @foreach ($timeslots as $timeslot)
                                @php
                                    $scheduleForTime = $schedule->where('day', 'Friday')->where('from', $timeslot)->first();
                                @endphp

                                <div onclick="window.location.href='/admin/open_il/{{ $scheduleForTime->code ?? '' }}'" class="course-container cursor-pointer w-[9.09%] py-2 rounded-md overflow-hidden text-nowrap">
                                    @if ($scheduleForTime)
                                        <p class="course text-xs px-2">
                                            {{ $scheduleForTime->course }}
                                        </p>
                                    @else
                                        <p class="course text-xs px-2">
                                        </p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        <div class="w-full flex items-center">
                            <p class="w-[9.09%]">Sat</p>
                            @php
                                $timeslots = [
                                    '10:00 AM', '11:00 AM', '12:00 PM', '1:00 PM', '2:00 PM',
                                    '3:00 PM', '4:00 PM', '5:00 PM', '6:00 PM', '7:00 PM'
                                ];
                            @endphp

                            @foreach ($timeslots as $timeslot)
                                @php
                                    $scheduleForTime = $schedule->where('day', 'Saturday')->where('from', $timeslot)->first();
                                @endphp

                                <div onclick="window.location.href='/admin/open_il/{{ $scheduleForTime->code ?? '' }}'" class="course-container cursor-pointer w-[9.09%] py-2 rounded-md overflow-hidden text-nowrap">
                                    @if ($scheduleForTime)
                                        <p class="course text-xs px-2">
                                            {{ $scheduleForTime->course }}
                                        </p>
                                    @else
                                        <p class="course text-xs px-2">
                                        </p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        <div class="w-full flex items-center">
                            <p class="w-[9.09%]">Sun</p>
                            @php
                                $timeslots = [
                                    '10:00 AM', '11:00 AM', '12:00 PM', '1:00 PM', '2:00 PM',
                                    '3:00 PM', '4:00 PM', '5:00 PM', '6:00 PM', '7:00 PM'
                                ];
                            @endphp

                            @foreach ($timeslots as $timeslot)
                                @php
                                    $scheduleForTime = $schedule->where('day', 'Sunday')->where('from', $timeslot)->first();
                                @endphp

                                <div onclick="window.location.href='/admin/open_il/{{ $scheduleForTime->code ?? '' }}'" class="course-container cursor-pointer w-[9.09%] py-2 rounded-md overflow-hidden text-nowrap">
                                    @if ($scheduleForTime)
                                        <p class="course text-xs px-2">
                                            {{ $scheduleForTime->course }}
                                        </p>
                                    @else
                                        <p class="course text-xs px-2">
                                        </p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>