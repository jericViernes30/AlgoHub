<!doctype html>
<html>
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="{{ asset('js/scripts.js') }}"></script>
  <title>Classes | AlgoHub</title>
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
<body class="bg-[#ececec] relative text-sm">
    <div id="body" class="w-full h-screen flex flex-col">
        <div class="w-full bg-[#632c7d] flex justify-end items-center py-2">
            <a href="{{route('admin.logout')}}" class="text-white px-10">Logout</a>
        </div>
        <div class="w-full flex h-screen bg-[#F2EBFB]">
            
            @include('partials.header')
            
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
                        <div class="w-full flex justify-end mb-5 py-2">
                            
                        </div>
                        <div class="w-full flex justify-between mb-4">
                            <div class=""></div>
                            <div>11:00 AM</div>
                            <div>1:00 AM</div>
                            <div>3:00 PM</div>
                            <div>5:00 PM</div>
                            <div>7:00 PM</div>
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
                                                    parentDiv.classList.add("bg-teal-300");
                                                    break;
                                                case "Visual Programming":
                                                    parentDiv.classList.add("bg-yellow-300");
                                                    break;
                                                case "Game Design":
                                                    parentDiv.classList.add("bg-orange-300");
                                                    break;
                                                case "Python Start":
                                                    parentDiv.classList.add("bg-red-300");
                                                    break;
                                                case "Python Pro":
                                                    parentDiv.classList.add("bg-red-500");
                                                    parentDiv.classList.add("text-white");
                                                    break;
                                                case "Coding Knight":
                                                    parentDiv.classList.add("bg-green-300");
                                                    break;
                                                case "Digital Literacy":
                                                    parentDiv.classList.add("bg-sky-300");
                                                    break;
                                                    case "Website Creation":
                                                    parentDiv.classList.add("bg-purple-300");
                                                    break;
                                                case "Unity Game Development":
                                                    parentDiv.classList.add("bg-purple-500");
                                                    parentDiv.classList.add("text-white");
                                                    break;
                                                case "Frontend Development":
                                                    parentDiv.classList.add("bg-blue-300");
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
                                        <a href="schedules/class_enrollees/{{ $sched->course_ID }}" id="" class="div_course flex w-[205px] items-center absolute top-0 left-[150px] rounded-2xl px-1 py-1 text-sm">
                                            <div class="w-full">
                                                <p class="text-center" id="course">{{ $sched->course_name }}</p>
                                                <p class="text-xs font-semibold text-center">{{ $sched->teacher }}</p>
                                            </div>
                                        </a>
                                    @endif
                                    
                                    @if ($sched->day === "Tuesday" && $sched->time_slot === "second")
                                        <a href="schedules/class_enrollees/{{ $sched->course_ID }}" id="" class="div_course flex w-[205px] items-center absolute top-0 left-[355px] rounded-2xl px-1 py-1 text-sm">
                                            <div class="w-full">
                                                <p class="text-center" id="course">{{ $sched->course_name }}</p>
                                                <p class="text-xs font-semibold text-center">{{ $sched->teacher }}</p>
                                            </div>
                                        </a>
                                    @endif

                                    @if ($sched->day === "Tuesday" && $sched->time_slot === "third")
                                        <a href="schedules/class_enrollees/{{ $sched->course_ID }}" id="" class="div_course flex w-[200px] items-center absolute top-0 left-[560px] rounded-2xl px-1 py-1 text-sm">
                                            <div class="w-full">
                                                <p class="text-center">{{ $sched->course_name }}</p>
                                                <p class="text-xs font-semibold text-center">{{ $sched->teacher }}</p>
                                            </div>
                                        </a>
                                    @endif

                                    @if ($sched->day === "Tuesday" && $sched->time_slot === "fourth")
                                        <a href="schedules/class_enrollees/{{ $sched->course_ID }}" id="" class="div_course flex w-[200px] items-center absolute top-0 left-[760px] rounded-full px-1 py-1 text-sm">
                                            <div class="w-full">
                                                <p class="text-center" id="course">{{ $sched->course_name }}</p>
                                                <p class="text-xs font-semibold text-center">{{ $sched->teacher }}</p>
                                            </div>
                                        </a>
                                    @endif

                                    @if ($sched->day === "Tuesday" && $sched->time_slot === "fifth")
                                        <a href="schedules/class_enrollees/{{ $sched->course_ID }}" class="div_course flex w-[200px] items-center absolute top-0 left-[960px] rounded-2xl px-1 py-1 text-sm">
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
                                        <a href="schedules/class_enrollees/{{ $sched->course_ID }}" id="" class="div_course flex w-[205px] items-center absolute top-0 left-[150px] rounded-2xl px-1 py-1 text-sm">
                                            <div class="w-full">
                                                <p class="text-center" id="course">{{ $sched->course_name }}</p>
                                                <p class="text-xs font-semibold text-center">{{ $sched->teacher }}</p>
                                            </div>
                                        </a>
                                    @endif
                                    
                                    @if ($sched->day === "Wednesday" && $sched->time_slot === "second")
                                        <a href="schedules/class_enrollees/{{ $sched->course_ID }}" id="" class="div_course flex w-[205px] items-center absolute top-0 left-[355px] rounded-2xl px-1 py-1 text-sm">
                                            <div class="w-full">
                                                <p class="text-center" id="course">{{ $sched->course_name }}</p>
                                                <p class="text-xs font-semibold text-center">{{ $sched->teacher }}</p>
                                            </div>
                                        </a>
                                    @endif

                                    @if ($sched->day === "Wednesday" && $sched->time_slot === "third")
                                        <a href="schedules/class_enrollees/{{ $sched->course_ID }}" id="" class="div_course flex w-[200px] items-center absolute top-0 left-[560px] rounded-2xl px-1 py-1 text-sm">
                                            <div class="w-full">
                                                <p class="text-center" id="course">{{ $sched->course_name }}</p>
                                                <p class="text-xs font-semibold text-center">{{ $sched->teacher }}</p>
                                            </div>
                                        </a>
                                    @endif

                                    @if ($sched->day === "Wednesday" && $sched->time_slot === "fourth")
                                        <a href="schedules/class_enrollees/{{ $sched->course_ID }}" class="div_course flex w-[200px] items-center absolute top-0 left-[760px] rounded-2xl px-1 py-1 text-sm">
                                            <div class="w-full">
                                                <p class="text-center" id="course">{{ $sched->course_name }}</p>
                                                <p class="text-xs font-semibold text-center">{{ $sched->teacher }}</p>
                                            </div>
                                        </a>
                                    @endif

                                    @if ($sched->day === "Wednesday" && $sched->time_slot === "fifth")
                                        <a href="schedules/class_enrollees/{{ $sched->course_ID }}" class="div_course flex w-[200px] items-center absolute top-0 left-[960px] rounded-2xl px-1 py-1 text-sm">
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
                                        <a href="schedules/class_enrollees/{{ $sched->course_ID }}" id="" class="div_course flex w-[205px] items-center absolute top-0 left-[150px] rounded-2xl px-1 py-1 text-sm">
                                            <div class="w-full">
                                                <p class="text-center" id="course">{{ $sched->course_name }}</p>
                                                <p class="text-xs font-semibold text-center">{{ $sched->teacher }}</p>
                                            </div>
                                        </a>
                                    @endif
                                    
                                    @if ($sched->day === "Thursday" && $sched->time_slot === "second")
                                        <a href="schedules/class_enrollees/{{ $sched->course_ID }}" id="" class="div_course flex w-[205px] items-center absolute top-0 left-[355px] rounded-2xl px-1 py-1 text-sm">
                                            <div class="w-full">
                                                <p class="text-center" id="course">{{ $sched->course_name }}</p>
                                                <p class="text-xs font-semibold text-center">{{ $sched->teacher }}</p>
                                            </div>
                                        </a>
                                    @endif

                                    @if ($sched->day === "Thursday" && $sched->time_slot === "third")
                                        <a href="schedules/class_enrollees/{{ $sched->course_ID }}" id="" class="div_course flex w-[200px] items-center absolute top-0 left-[560px] rounded-2xl px-1 py-1 text-sm">
                                            <div class="w-full">
                                                <p class="text-center" id="course">{{ $sched->course_name }}</p>
                                                <p class="text-xs font-semibold text-center">{{ $sched->teacher }}</p>
                                            </div>
                                        </a>
                                    @endif

                                    @if ($sched->day === "Thursday" && $sched->time_slot === "fourth")
                                        <a href="schedules/class_enrollees/{{ $sched->course_ID }}" id="" class="div_course flex w-[200px] items-center absolute top-0 left-[760px] rounded-2xl px-1 py-1 text-sm">
                                            <div class="w-full">
                                                <p class="text-center" id="course">{{ $sched->course_name }}</p>
                                                <p class="text-xs font-semibold text-center">{{ $sched->teacher }}</p>
                                            </div>
                                        </a>
                                    @endif

                                    @if ($sched->day === "Thursday" && $sched->time_slot === "fifth")
                                        <a href="schedules/class_enrollees/{{ $sched->course_ID }}" class="div_course flex w-[200px] items-center absolute top-0 left-[960px] rounded-2xl px-1 py-1 text-sm">
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
                                        <a href="schedules/class_enrollees/{{ $sched->course_ID }}" id="" class="div_course flex w-[205px] items-center absolute top-0 left-[150px] rounded-2xl px-1 py-1 text-sm">
                                            <div class="w-full">
                                                <p class="text-center" id="course">{{ $sched->course_name }}</p>
                                                <p class="text-xs font-semibold text-center">{{ $sched->teacher }}</p>
                                            </div>
                                        </a>
                                    @endif
                                    
                                    @if ($sched->day === "Friday" && $sched->time_slot === "second")
                                        <a href="schedules/class_enrollees/{{ $sched->course_ID }}" id="" class="div_course flex w-[200px] items-center absolute top-0 left-[355px] rounded-2xl px-1 py-1 text-sm">
                                            <div class="w-full">
                                                <p class="text-center" id="course">{{ $sched->course_name }}</p>
                                                <p class="text-xs font-semibold text-center">{{ $sched->teacher }}</p>
                                            </div>
                                        </a>
                                    @endif

                                    @if ($sched->day === "Friday" && $sched->time_slot === "third")
                                        <a href="schedules/class_enrollees/{{ $sched->course_ID }}" id="" class="div_course flex w-[200px] items-center absolute top-0 left-[560px] rounded-2xl px-1 py-1 text-sm">
                                            <div class="w-full">
                                                <p class="text-center" id="course">{{ $sched->course_name }}</p>
                                                <p class="text-xs font-semibold text-center">{{ $sched->teacher }}</p>
                                            </div>
                                        </a>
                                    @endif

                                    @if ($sched->day === "Friday" && $sched->time_slot === "fourth")
                                        <a href="schedules/class_enrollees/{{ $sched->course_ID }}" class="div_course flex w-[200px] items-center absolute top-0 left-[760px] rounded-2xl px-1 py-1 text-sm">
                                            <div class="w-full">
                                                <p class="text-center" id="course">{{ $sched->course_name }}</p>
                                                <p class="text-xs font-semibold text-center">{{ $sched->teacher }}</p>
                                            </div>
                                        </a>
                                    @endif

                                    @if ($sched->day === "Friday" && $sched->time_slot === "fifth")
                                        <a href="schedules/class_enrollees/{{ $sched->course_ID }}" class="div_course flex w-[200px] items-center absolute top-0 left-[960px] rounded-2xl px-1 py-1 text-sm">
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
                                        <a href="schedules/class_enrollees/{{ $sched->course_ID }}" id="" class="div_course flex w-[205px] items-center absolute top-0 left-[150px] rounded-2xl px-1 py-1 text-sm">
                                            <div class="w-full">
                                                <p class="text-center" id="course">{{ $sched->course_name }}</p>
                                                <p class="text-xs font-semibold text-center">{{ $sched->teacher }}</p>
                                            </div>
                                        </a>
                                    @endif
                                    
                                    @if ($sched->day === "Saturday" && $sched->time_slot === "second")
                                        <a href="schedules/class_enrollees/{{ $sched->course_ID }}" id="" class="div_course flex w-[205px] items-center absolute top-0 left-[355px] rounded-2xl px-1 py-1 text-sm">
                                            <div class="w-full">
                                                <p class="text-center" id="course">{{ $sched->course_name }}</p>
                                                <p class="text-xs font-semibold text-center">{{ $sched->teacher }}</p>
                                            </div>
                                        </a>
                                    @endif

                                    @if ($sched->day === "Saturday" && $sched->time_slot === "third")
                                        <a href="schedules/class_enrollees/{{ $sched->course_ID }}" id="" class="div_course flex w-[200px] items-center absolute top-0 left-[560px] rounded-2xl px-1 py-1 text-sm">
                                            <div class="w-full">
                                                <p class="text-center" id="course">{{ $sched->course_name }}</p>
                                                <p class="text-xs font-semibold text-center">{{ $sched->teacher }}</p>
                                            </div>
                                        </a>
                                    @endif

                                    @if ($sched->day === "Saturday" && $sched->time_slot === "fourth")
                                        <a href="schedules/class_enrollees/{{ $sched->course_ID }}" id="" class="div_course flex w-[200px] items-center absolute top-0 left-[760px] rounded-2xl px-1 py-1 text-sm">
                                            <div class="w-full">
                                                <p class="text-center" id="course">{{ $sched->course_name }}</p>
                                                <p class="text-xs font-semibold text-center">{{ $sched->teacher }}</p>
                                            </div>
                                        </a>
                                    @endif

                                    @if ($sched->day === "Saturday" && $sched->time_slot === "fifth")
                                        <a href="schedules/class_enrollees/{{ $sched->course_ID }}" class="div_course flex w-[200px] items-center absolute top-0 left-[960px] rounded-2xl px-1 py-1 text-sm">
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