<!doctype html>
<html>
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@200..800&family=Noto+Sans:ital,wght@0,100..900;1,100..900&family=Oswald:wght@200..700&display=swap" rel="stylesheet">
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
<body class="bg-[#ececec] relative text-sm">
    <div id="add_form" class="hidden w-2/6 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-sm z-10">
        <div class="w-full flex flex-col bg-[#F2EBFB] rounded-xl">
            <div class="w-full flex justify-between bg-[#833ae0] p-4 rounded-tl-xl rounded-tr-xl">
                <p class="text-white">Add new class Schedule</p>
                <button class="text-white flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="14" height="14" fill="#f9f9f9"><path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/></svg>
                </button>
            </div>
            <div class="w-full px-16 py-4">
                <form action="{{route('admin.add_class_post')}}" method="POST">
                    @csrf
                    <div class="flex flex-col w-full mb-5">
                        <label for="" class="mb-1">Select Course</label>
                        <select name="course_name" class="py-2 outline-none text-center rounded-lg border border-[#a9a9a9] focus:border-[#833ae0]">
                            <option value="" class="text-center" selected disabled>-- Please select a course --</option>
                            @foreach ($courses as $course)
                                <option value="{{$course->course_name}}">{{$course->course_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex flex-col w-full mb-5">
                        <label for="" class="mb-1">Teacher</label>
                        <select name="teacher" id="" class="py-2 outline-none text-center rounded-lg border border-[#a9a9a9] focus:border-[#833ae0]">
                                <option value="" disabled selected>Select Teacher</option>
                                @foreach ($teachers as $teacher)
                                    <option value="{{$teacher->id}}|{{$teacher->first_name}}" class="text-center">
                                        {{$teacher->first_name}}
                                    </option>
                                @endforeach
                        </select>
                    </div>
                    <div class="flex gap-2 w-full mb-5">
                        <div class="w-1/2 flex flex-col">
                            <label for="" class="mb-1">Day</label>
                            <select name="day" id="" class="py-2 outline-none text-center rounded-lg border border-[#a9a9a9] focus:border-[#833ae0]">
                                <option value="Monday" class="text-center">Monday</option>
                                <option value="Tuesday">Tuesday</option>
                                <option value="Wednesday">Wednesday</option>
                                <option value="Thursday">Thursday</option>
                                <option value="Friday">Friday</option>
                                <option value="Saturday">Saturday</option>
                                <option value="Sunday">Sunday</option>
                            </select>
                        </div>
                        <div class="w-1/2 flex flex-col">
                            <label for="" class="mb-1">Time Slot</label>
                            <select name="time_slot" id="" class="py-2 outline-none text-center rounded-lg border border-[#a9a9a9] focus:border-[#833ae0]">
                                <option value="first">11:00 AM</option>
                                <option value="second">1:00 PM</option>
                                <option value="third">3:00 PM</option>
                                <option value="fourth">5:00 PM</option>
                                <option value="fifth">7:00 PM</option>
                            </select>
                        </div>
                    </div>
                    <div class="w-full flex justify-end">
                        <button type="submit" class="w-1/4 py-2 bg-[#833ae0] text-white rounded-md">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="body" class="w-full h-screen flex flex-col">
        <div class="w-full bg-[#833ae0] flex py-5">
            {{-- <div class="w-4/5 mx-auto flex justify-between">
                <input type="search" name="search" placeholder="Search" class="px-2 py-1 rounded-xl w-1/3">
                <div class="flex items-center justify-center">
                </div>
            </div> --}}
        </div>
        <div class="w-full flex h-screen bg-[#F2EBFB]">
            <div class="w-1/6 h-full bg-[#f9f9f9] text-sm">
                <div class="w-full mx-auto flex gap-5 items-center mt-28">
                    <a href="{{route('admin.dashboard')}}" class="text-[#48494b] px-5 py-2 w-full">Dashboard</a>
                </div>
                <div>
                    <div onclick="courseDropdown()">
                        <div class="w-full flex items-center justify-around px-5 relative hover:bg-[#F2EBFB] ">
                            <p id="course_dd" href="" class="w-full py-2 text-[#48494b] hover:cursor-pointer">Courses</p>
                        </div>
                    </div>

                    <div onclick="studentsDropdown()">
                        <div class="w-full flex items-center justify-around px-5 relative hover:bg-[#F2EBFB] hover:cursor-pointer">
                            <p id="students_dd" class=" w-full py-2 text-[#48494b]">Students</p>
                        </div>
                    </div>

                    <div onclick="scheduleDropdown()">
                        <div class="w-full flex items-center justify-around px-5 relative py-2 bg-[#F2EBFB] border-l-4 rounded-sm border-[#833ae0] hover:cursor-pointer">
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
            <div class="w-full p-4 z-0">
                {{-- Dashboard Schedule --}}
                <div class="w-full mx-auto bg-[#f9f9f9] rounded-3xl border border-[#833ae0]"> 
                    @php
                        function displayMonth() {
                            return date('F');
                        }
                    @endphp
                    <p class="text-xl font-semibold py-2 text-center mb-5">Class schedules for the month of {{ displayMonth() }}</p>
                    <div class="p-8">
                        <div class="w-full flex justify-end mb-5">
                            <button onclick="showAddForm()" class="py-1 px-4 text-sm bg-[#833ae0] rounded-sm text-white">Add new schedule</button>
                        </div>
                        <div class="w-full flex justify-between mb-4">
                            <div class=""></div>
                            <div>11:00 AM</div>
                            <div>1:00 AM</div>
                            <div>3:00 PM</div>
                            <div>5:00 PM</div>
                            <div>7:00 PM</div>
                            <div>9:00 PM</div>
                        </div>
                        <div class="w-full flex flex-col gap-10 pb-4">
                            <div class="w-full relative">
                                <script>
                                    document.addEventListener("DOMContentLoaded", function() {
                                        var courseElements = document.querySelectorAll(".div_course #course");
                                        
                                        courseElements.forEach(function(courseElement) {
                                            var courseName = courseElement.textContent.trim();
                                            var parentDiv = courseElement.closest(".div_course");
                                            
                                            switch (courseName) {
                                                case "Graphic Design":
                                                    parentDiv.classList.add("bg-blue-300");
                                                    break;
                                                case "Visual Programming":
                                                    parentDiv.classList.add("bg-orange-300");
                                                    break;
                                                case "Game Creation":
                                                    parentDiv.classList.add("bg-red-300");
                                                    break;
                                                case "Python Start":
                                                    parentDiv.classList.add("bg-green-300");
                                                    break;
                                                case "Python Pro":
                                                    parentDiv.classList.add("bg-purple-300");
                                                    break;
                                                case "Coding Knight":
                                                    parentDiv.classList.add("bg-yellow-300");
                                                    break;
                                                case "Front-end Development":
                                                    parentDiv.classList.add("bg-pink-300");
                                                    break;
                                                default:
                                                    // Do nothing or add default behavior
                                                    break;
                                            }
                                        });
                                    });
                                </script>
                                <p>Monday</p>
                                @foreach ($schedule as $sched)
                                    @if ($sched->day === "Monday" && $sched->time_slot === "first")
                                        <a href="#" id="" class="div_course flex w-[205px] items-center absolute top-0 left-[150px] rounded-2xl px-1 py-1 text-sm">
                                            <div class="w-full">
                                                <p class="text-center" id="course">{{ $sched->course_name }}</p>
                                                <p class="text-xs font-semibold text-center">{{ $sched->teacher }}</p>
                                            </div>
                                        </a>
                                    @endif
                                    
                                    @if ($sched->day === "Monday" && $sched->time_slot === "second")
                                        <div id="" class="div_course flex w-[205px] items-center absolute top-0 left-[355px] rounded-2xl px-1 py-1 text-sm">
                                            <div class="w-full">
                                                <p class="text-center" id="course">{{ $sched->course_name }}</p>
                                                <p class="text-xs font-semibold text-center">{{ $sched->teacher }}</p>
                                            </div>
                                        </div>
                                    @endif

                                    @if ($sched->day === "Monday" && $sched->time_slot === "third")
                                        <div id="" class="div_course flex w-[200px] items-center absolute top-0 left-[560px] rounded-2xl px-1 py-1 text-sm">
                                            <div class="w-full">
                                                <p class="text-center" id="course">{{ $sched->course_name }}</p>
                                                <p class="text-xs font-semibold text-center">{{ $sched->teacher }}</p>
                                            </div>
                                        </div>
                                    @endif

                                    @if ($sched->day === "Monday" && $sched->time_slot === "fourth")
                                        <a href="admin/schedules/class_enrollees/{{ $sched->course_name }}" id="" class="div_course flex w-[200px] items-center absolute top-0 left-[760px] rounded-2xl px-1 py-1 text-sm">
                                            <div class="w-full">
                                                <p class="text-center" id="course">{{ $sched->course_name }}</p>
                                                <p class="text-xs font-semibold text-center">{{ $sched->teacher }}</p>
                                            </div>
                                        </a>
                                    @endif

                                    @if ($sched->day === "Monday" && $sched->time_slot === "fifth")
                                        <div id="" class="div_course flex w-[200px] items-center absolute top-0 left-[960px] rounded-2xl px-1 py-1 text-sm">
                                            <div class="w-full">
                                                <p class="text-center">{{ $sched->course_name }}</p>
                                                <p class="text-xs font-semibold text-center">{{ $sched->teacher }}</p>
                                            </div>
                                        </div>
                                    @endif
                                    
                                @endforeach
                                
                            </div>
                            <div class="w-full relative">
                                <p>Tuesday</p>
                                @foreach ($schedule as $sched)
                                    @if ($sched->day === "Tuesday" && $sched->time_slot === "first")
                                        <a href="admin/schedules/class_enrollees/{{ $sched->day }}/{{ $sched->time_slot }}/{{ $sched->course_name }}" id="" class="div_course flex w-[205px] items-center absolute top-0 left-[150px] rounded-2xl px-1 py-1 text-sm">
                                            <div class="w-full">
                                                <p class="text-center" id="course">{{ $sched->course_name }}</p>
                                                <p class="text-xs font-semibold text-center">{{ $sched->teacher }}</p>
                                            </div>
                                        </a>
                                    @endif
                                    
                                    @if ($sched->day === "Tuesday" && $sched->time_slot === "second")
                                        <a href="admin/schedules/class_enrollees/{{ $sched->day }}/{{ $sched->time_slot }}/{{ $sched->course_name }}" id="" class="div_course flex w-[205px] items-center absolute top-0 left-[355px] rounded-2xl px-1 py-1 text-sm">
                                            <div class="w-full">
                                                <p class="text-center" id="course">{{ $sched->course_name }}</p>
                                                <p class="text-xs font-semibold text-center">{{ $sched->teacher }}</p>
                                            </div>
                                        </a>
                                    @endif

                                    @if ($sched->day === "Tuesday" && $sched->time_slot === "third")
                                        <a href="admin/schedules/class_enrollees/{{ $sched->day }}/{{ $sched->time_slot }}/{{ $sched->course_name }}" id="" class="div_course flex w-[200px] items-center absolute top-0 left-[560px] rounded-2xl px-1 py-1 text-sm">
                                            <div class="w-full">
                                                <p class="text-center">{{ $sched->course_name }}</p>
                                                <p class="text-xs font-semibold text-center">{{ $sched->teacher }}</p>
                                            </div>
                                        </a>
                                    @endif

                                    @if ($sched->day === "Tuesday" && $sched->time_slot === "fourth")
                                        <a href="admin/schedules/class_enrollees/{{ $sched->course_ID }}" id="" class="div_course flex w-[200px] items-center absolute top-0 left-[760px] rounded-2xl px-1 py-1 text-sm">
                                            <div class="w-full">
                                                <p class="text-center" id="course">{{ $sched->course_name }}</p>
                                                <p class="text-xs font-semibold text-center">{{ $sched->teacher }}</p>
                                            </div>
                                        </a>
                                    @endif

                                    @if ($sched->day === "Tuesday" && $sched->time_slot === "fifth")
                                        <a href="admin/schedules/class_enrollees/{{ $sched->day }}/{{ $sched->time_slot }}/{{ $sched->course_name }}" class="div_course flex w-[200px] items-center absolute top-0 left-[960px] rounded-2xl px-1 py-1 text-sm">
                                            <div class="w-full">
                                                <p class="text-center">{{ $sched->course_name }}</p>
                                                <p class="text-xs font-semibold text-center">{{ $sched->teacher }}</p>
                                            </div>
                                        </a>
                                    @endif
                                    
                                @endforeach
                            </div>

                            <div class="w-full relative">
                                <p>Wednesday</p>
                                @foreach ($schedule as $sched)
                                    @if ($sched->day === "Wednesday" && $sched->time_slot === "first")
                                        <a href="admin/schedules/class_enrollees/{{ $sched->day }}/{{ $sched->time_slot }}/{{ $sched->course_name }}" id="" class="div_course flex w-[205px] items-center absolute top-0 left-[150px] rounded-2xl px-1 py-1 text-sm">
                                            <div class="w-full">
                                                <p class="text-center" id="course">{{ $sched->course_name }}</p>
                                                <p class="text-xs font-semibold text-center">{{ $sched->teacher }}</p>
                                            </div>
                                        </a>
                                    @endif
                                    
                                    @if ($sched->day === "Wednesday" && $sched->time_slot === "second")
                                        <a href="admin/schedules/class_enrollees/{{ $sched->day }}/{{ $sched->time_slot }}/{{ $sched->course_name }}" id="" class="div_course flex w-[205px] items-center absolute top-0 left-[355px] rounded-2xl px-1 py-1 text-sm">
                                            <div class="w-full">
                                                <p class="text-center" id="course">{{ $sched->course_name }}</p>
                                                <p class="text-xs font-semibold text-center">{{ $sched->teacher }}</p>
                                            </div>
                                        </a>
                                    @endif

                                    @if ($sched->day === "Wednesday" && $sched->time_slot === "third")
                                        <a href="admin/schedules/class_enrollees/{{ $sched->day }}/{{ $sched->time_slot }}/{{ $sched->course_name }}" id="" class="div_course flex w-[200px] items-center absolute top-0 left-[560px] rounded-2xl px-1 py-1 text-sm">
                                            <div class="w-full">
                                                <p class="text-center" id="course">{{ $sched->course_name }}</p>
                                                <p class="text-xs font-semibold text-center">{{ $sched->teacher }}</p>
                                            </div>
                                        </a>
                                    @endif

                                    @if ($sched->day === "Wednesday" && $sched->time_slot === "fourth")
                                        <a href="admin/schedules/class_enrollees/{{ $sched->day }}/{{ $sched->time_slot }}/{{ $sched->course_name }}" class="div_course flex w-[200px] items-center absolute top-0 left-[760px] rounded-2xl px-1 py-1 text-sm">
                                            <div class="w-full">
                                                <p class="text-center" id="course">{{ $sched->course_name }}</p>
                                                <p class="text-xs font-semibold text-center">{{ $sched->teacher }}</p>
                                            </div>
                                        </a>
                                    @endif

                                    @if ($sched->day === "Wednesday" && $sched->time_slot === "fifth")
                                        <a href="admin/schedules/class_enrollees/{{ $sched->day }}/{{ $sched->time_slot }}/{{ $sched->course_name }}" class="div_course flex w-[200px] items-center absolute top-0 left-[960px] rounded-2xl px-1 py-1 text-sm">
                                            <div class="w-full">
                                                <p class="text-center">{{ $sched->course_name }}</p>
                                                <p class="text-xs font-semibold text-center">{{ $sched->teacher }}</p>
                                            </div>
                                        </a>
                                    @endif
                                    
                                @endforeach
                            </div>
                            <div class="w-full relative">
                                <p>Thursday</p>
                                @foreach ($schedule as $sched)
                                    @if ($sched->day === "Thursday" && $sched->time_slot === "first")
                                        <a href="admin/schedules/class_enrollees/{{ $sched->day }}/{{ $sched->time_slot }}/{{ $sched->course_name }}" id="" class="div_course flex w-[205px] items-center absolute top-0 left-[150px] rounded-2xl px-1 py-1 text-sm">
                                            <div class="w-full">
                                                <p class="text-center" id="course">{{ $sched->course_name }}</p>
                                                <p class="text-xs font-semibold text-center">{{ $sched->teacher }}</p>
                                            </div>
                                        </a>
                                    @endif
                                    
                                    @if ($sched->day === "Thursday" && $sched->time_slot === "second")
                                        <a href="admin/schedules/class_enrollees/{{ $sched->day }}/{{ $sched->time_slot }}/{{ $sched->course_name }}" id="" class="div_course flex w-[205px] items-center absolute top-0 left-[355px] rounded-2xl px-1 py-1 text-sm">
                                            <div class="w-full">
                                                <p class="text-center" id="course">{{ $sched->course_name }}</p>
                                                <p class="text-xs font-semibold text-center">{{ $sched->teacher }}</p>
                                            </div>
                                        </a>
                                    @endif

                                    @if ($sched->day === "Thursday" && $sched->time_slot === "third")
                                        <a href="admin/schedules/class_enrollees/{{ $sched->day }}/{{ $sched->time_slot }}/{{ $sched->course_name }}" id="" class="div_course flex w-[200px] items-center absolute top-0 left-[560px] rounded-2xl px-1 py-1 text-sm">
                                            <div class="w-full">
                                                <p class="text-center" id="course">{{ $sched->course_name }}</p>
                                                <p class="text-xs font-semibold text-center">{{ $sched->teacher }}</p>
                                            </div>
                                        </a>
                                    @endif

                                    @if ($sched->day === "Thursday" && $sched->time_slot === "fourth")
                                        <a href="admin/schedules/class_enrollees/{{ $sched->day }}/{{ $sched->time_slot }}/{{ $sched->course_name }}" class="div_course flex w-[200px] items-center absolute top-0 left-[760px] rounded-2xl px-1 py-1 text-sm">
                                            <div class="w-full">
                                                <p class="text-center" id="course">{{ $sched->course_name }}</p>
                                                <p class="text-xs font-semibold text-center">{{ $sched->teacher }}</p>
                                            </div>
                                        </a>
                                    @endif

                                    @if ($sched->day === "Thursday" && $sched->time_slot === "fifth")
                                        <a href="admin/schedules/class_enrollees/{{ $sched->day }}/{{ $sched->time_slot }}/{{ $sched->course_name }}" class="div_course flex w-[200px] items-center absolute top-0 left-[960px] rounded-2xl px-1 py-1 text-sm">
                                            <div class="w-full">
                                                <p class="text-center">{{ $sched->course_name }}</p>
                                                <p class="text-xs font-semibold text-center">{{ $sched->teacher }}</p>
                                            </div>
                                        </a>
                                    @endif
                                    
                                @endforeach
                            </div>
                            <div class="w-full relative">
                                <p>Friday</p>
                                @foreach ($schedule as $sched)
                                    @if ($sched->day === "Friday" && $sched->time_slot === "first")
                                        <a href="admin/schedules/class_enrollees/{{ $sched->day }}/{{ $sched->time_slot }}/{{ $sched->course_name }}" id="" class="div_course flex w-[205px] items-center absolute top-0 left-[150px] rounded-2xl px-1 py-1 text-sm">
                                            <div class="w-full">
                                                <p class="text-center" id="course">{{ $sched->course_name }}</p>
                                                <p class="text-xs font-semibold text-center">{{ $sched->teacher }}</p>
                                            </div>
                                        </a>
                                    @endif
                                    
                                    @if ($sched->day === "Friday" && $sched->time_slot === "second")
                                        <a href="admin/schedules/class_enrollees/{{ $sched->day }}/{{ $sched->time_slot }}/{{ $sched->course_name }}" id="" class="div_course flex w-[205px] items-center absolute top-0 left-[355px] rounded-2xl px-1 py-1 text-sm">
                                            <div class="w-full">
                                                <p class="text-center" id="course">{{ $sched->course_name }}</p>
                                                <p class="text-xs font-semibold text-center">{{ $sched->teacher }}</p>
                                            </div>
                                        </a>
                                    @endif

                                    @if ($sched->day === "Friday" && $sched->time_slot === "third")
                                        <a href="admin/schedules/class_enrollees/{{ $sched->day }}/{{ $sched->time_slot }}/{{ $sched->course_name }}" id="" class="div_course flex w-[200px] items-center absolute top-0 left-[560px] rounded-2xl px-1 py-1 text-sm">
                                            <div class="w-full">
                                                <p class="text-center" id="course">{{ $sched->course_name }}</p>
                                                <p class="text-xs font-semibold text-center">{{ $sched->teacher }}</p>
                                            </div>
                                        </a>
                                    @endif

                                    @if ($sched->day === "Friday" && $sched->time_slot === "fourth")
                                        <a href="admin/schedules/class_enrollees/{{ $sched->day }}/{{ $sched->time_slot }}/{{ $sched->course_name }}" class="div_course flex w-[200px] items-center absolute top-0 left-[760px] rounded-2xl px-1 py-1 text-sm">
                                            <div class="w-full">
                                                <p class="text-center" id="course">{{ $sched->course_name }}</p>
                                                <p class="text-xs font-semibold text-center">{{ $sched->teacher }}</p>
                                            </div>
                                        </a>
                                    @endif

                                    @if ($sched->day === "Friday" && $sched->time_slot === "fifth")
                                        <a href="admin/schedules/class_enrollees/{{ $sched->day }}/{{ $sched->time_slot }}/{{ $sched->course_name }}" class="div_course flex w-[200px] items-center absolute top-0 left-[960px] rounded-2xl px-1 py-1 text-sm">
                                            <div class="w-full">
                                                <p class="text-center">{{ $sched->course_name }}</p>
                                                <p class="text-xs font-semibold text-center">{{ $sched->teacher }}</p>
                                            </div>
                                        </a>
                                    @endif
                                    
                                @endforeach
                            </div>
                            <div class="w-full relative">
                                <p>Saturday</p>
                                @foreach ($schedule as $sched)
                                    @if ($sched->day === "Saturday" && $sched->time_slot === "first")
                                        <a href="admin/schedules/class_enrollees/{{ $sched->day }}/{{ $sched->time_slot }}/{{ $sched->course_name }}" id="" class="div_course flex w-[205px] items-center absolute top-0 left-[150px] rounded-2xl px-1 py-1 text-sm">
                                            <div class="w-full">
                                                <p class="text-center" id="course">{{ $sched->course_name }}</p>
                                                <p class="text-xs font-semibold text-center">{{ $sched->teacher }}</p>
                                            </div>
                                        </a>
                                    @endif
                                    
                                    @if ($sched->day === "Saturday" && $sched->time_slot === "second")
                                        <a href="admin/schedules/class_enrollees/{{ $sched->day }}/{{ $sched->time_slot }}/{{ $sched->course_name }}" id="" class="div_course flex w-[205px] items-center absolute top-0 left-[355px] rounded-2xl px-1 py-1 text-sm">
                                            <div class="w-full">
                                                <p class="text-center" id="course">{{ $sched->course_name }}</p>
                                                <p class="text-xs font-semibold text-center">{{ $sched->teacher }}</p>
                                            </div>
                                        </a>
                                    @endif

                                    @if ($sched->day === "Saturday" && $sched->time_slot === "third")
                                        <a href="admin/schedules/class_enrollees/{{ $sched->day }}/{{ $sched->time_slot }}/{{ $sched->course_name }}" id="" class="div_course flex w-[200px] items-center absolute top-0 left-[560px] rounded-2xl px-1 py-1 text-sm">
                                            <div class="w-full">
                                                <p class="text-center" id="course">{{ $sched->course_name }}</p>
                                                <p class="text-xs font-semibold text-center">{{ $sched->teacher }}</p>
                                            </div>
                                        </a>
                                    @endif

                                    @if ($sched->day === "Saturday" && $sched->time_slot === "fourth")
                                        <a href="admin/schedules/class_enrollees/{{ $sched->day }}/{{ $sched->time_slot }}/{{ $sched->course_name }}" class="div_course flex w-[200px] items-center absolute top-0 left-[760px] rounded-2xl px-1 py-1 text-sm">
                                            <div class="w-full">
                                                <p class="text-center" id="course">{{ $sched->course_name }}</p>
                                                <p class="text-xs font-semibold text-center">{{ $sched->teacher }}</p>
                                            </div>
                                        </a>
                                    @endif

                                    @if ($sched->day === "Saturday" && $sched->time_slot === "fifth")
                                        <a href="admin/schedules/class_enrollees/{{ $sched->day }}/{{ $sched->time_slot }}/{{ $sched->course_name }}" class="div_course flex w-[200px] items-center absolute top-0 left-[960px] rounded-2xl px-1 py-1 text-sm">
                                            <div class="w-full">
                                                <p class="text-center">{{ $sched->course_name }}</p>
                                                <p class="text-xs font-semibold text-center">{{ $sched->teacher }}</p>
                                            </div>
                                        </a>
                                    @endif
                                    
                                @endforeach
                            </div>
                            <div class="w-full relative">
                                <p>Sunday</p>
                                @foreach ($schedule as $sched)
                                    @if ($sched->day === "Sunday" && $sched->time_slot === "first")
                                        <div id="" class="div_course flex w-[205px] items-center absolute top-0 left-[150px] rounded-2xl px-1 py-1 text-sm">
                                            <div class="w-full">
                                                <p class="text-center" id="course">{{ $sched->course_name }}</p>
                                                <p class="text-xs font-semibold text-center">{{ $sched->teacher }}</p>
                                            </div>
                                        </div>
                                    @endif
                                    
                                    @if ($sched->day === "Sunday" && $sched->time_slot === "second")
                                        <div id="" class="div_course flex w-[205px] items-center absolute top-0 left-[355px] rounded-2xl px-1 py-1 text-sm">
                                            <div class="w-full">
                                                <p class="text-center" id="course">{{ $sched->course_name }}</p>
                                                <p class="text-xs font-semibold text-center">{{ $sched->teacher }}</p>
                                            </div>
                                        </div>
                                    @endif

                                    @if ($sched->day === "Sunday" && $sched->time_slot === "third")
                                        <div id="" class="div_course flex w-[200px] items-center absolute top-0 left-[560px] rounded-2xl px-1 py-1 text-sm">
                                            <div class="w-full">
                                                <p class="text-center" id="course">{{ $sched->course_name }}</p>
                                                <p class="text-xs font-semibold text-center">{{ $sched->teacher }}</p>
                                            </div>
                                        </div>
                                    @endif

                                    @if ($sched->day === "Sunday" && $sched->time_slot === "fourth")
                                        <div id="" class="div_course flex w-[200px] items-center absolute top-0 left-[760px] rounded-2xl px-1 py-1 text-sm">
                                            <div class="w-full">
                                                <p class="text-center" id="course">{{ $sched->course_name }}</p>
                                                <p class="text-xs font-semibold text-center">{{ $sched->teacher }}</p>
                                            </div>
                                        </div>
                                    @endif

                                    @if ($sched->day === "Sunday" && $sched->time_slot === "fifth")
                                        <div id="" class="div_course flex w-[200px] items-center absolute top-0 left-[960px] rounded-2xl px-1 py-1 text-sm">
                                            <div class="w-full">
                                                <p class="text-center" id="course">{{ $sched->course_name }}</p>
                                                <p class="text-xs font-semibold text-center">{{ $sched->teacher }}</p>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>