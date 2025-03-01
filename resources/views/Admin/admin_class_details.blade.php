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
  <title>Class Details | AlgoHub</title>
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
<body class="bg-[#ececec] text-sm">
    <div id="body" class="w-full h-screen flex flex-col z-0">
        <div class="w-full bg-[#632c7d] flex justify-end items-center py-2">
            <a href="{{route('admin.logout')}}" class="text-white px-10">Logout</a>
        </div>
        <div class="w-full flex h-screen bg-[#F2EBFB]">
            <div class="w-1/6 h-full bg-[#f9f9f9] text-sm">
                <div class="w-full mb-8 mt-10">
                    <img src="https://lms.alg.academy/auth/v3/img/logo.d1092e37.svg" alt="Lesson Logo" class="w-3/4 block mx-auto">
                </div>
                <div class="w-full mx-auto flex gap-5 items-center">
                    <a href="{{route('admin.dashboard')}}" class="text-[#48494b] px-5 w-full py-2">Dashboard</a>
                </div>
                <div>
                    <div onclick="courseDropdown()">
                        <a href="{{route('admin.courses')}}" class="w-full flex items-center justify-around px-5 relative hover:bg-[#F2EBFB] ">
                            <p id="course_dd" href="" class="w-full py-2 text-[#48494b] hover:cursor-pointer">Courses</p>
                        </a>
                    </div>

                    <div onclick="studentsDropdown()">
                        <a href="#" class="w-full flex items-center justify-around px-5 relative hover:bg-[#F2EBFB] hover:cursor-pointer">
                            <p id="students_dd" class=" w-full py-2 text-[#48494b]">Students</p>
                        </a>
                    </div>
                    <div onclick="">
                        <a href="{{route('admin.teachers_list')}}" class="w-full flex items-center justify-around px-5 relative hover:bg-[#F2EBFB] hover:cursor-pointer">
                            <p id="students_dd" class=" w-full py-2 text-[#48494b]">Teachers</p>
                        </a>
                    </div>
                    <div onclick="scheduleDropdown()">
                        <div class="w-full flex items-center justify-around px-5 relative py-2 bg-[#F2EBFB] border-l-4 rounded-sm border-[#833ae0] hover:cursor-pointer">
                            <p id="sched_dd" class=" w-full text-[#48494b]">Schedule</p>
                            <svg id="arrow2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="12" height="12"><path d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z"/></svg>
                        </div>
                        <div id="schedules" class="hidden mb-5">
                            <div class="w-full flex items-center px-10 relative hover:bg-[#F2EBFB] hover:cursor-pointer">
                                <a href="{{route('admin.schedule')}}" class="py-2 text-[#48494b] hover:cursor-pointer">Classes</a>
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
            <div class="w-full p-4">
                <div class="w-full mx-auto bg-[#f9f9f9] rounded-md p-4 text-sm">
                    <p class="text-lg font-semibold text-center mb-4">Course Details</p>
                        <div id="schedule_card" class="w-full border border-[#a9a9a9] rounded-lg p-4 mb-5">
                            <div class="flex w-full items-center gap-2 mb-5">
                                <div class="w-[10%]">
                                    <p class="font-semibold mb-2">Course Name</p>
                                    <p class="font-semibold mb-2">Teacher:</p>
                                    <p class="font-semibold mb-2">Scheduled Day:</p>
                                    <p class="font-semibold mb-2">Time Slot:</p>
                                    <p class="font-semibold">Start Date:</p>
                                </div>
                                <div>
                                    <p class="mb-2">: {{ $courses->course_name }}</p>
                                    <p class="mb-2">: {{ $courses->teacher }}</p>
                                    <p class="mb-2">: {{ $courses->day }}</p>
                                    <p id="time" class="mb-2"></p>
                                    <script>
                                        var time = ''
                                        console.log('{{$courses->time_slot}}');
                                        switch('{{$courses->time_slot}}'){
                                            case 'first':
                                                time = ": 11:00 AM to 1:00 PM"
                                                break
                                            case 'second':
                                                time = ": 1:00 PM to 3:00 PM"
                                                break
                                            case 'third':
                                                time = ": 3:00 PM to 5:00 PM"
                                                break
                                            case 'fourth':
                                                time = ": 5:00 PM to 7:00 PM"
                                                break
                                            default:
                                                time = 'Unknown Day';
                                                break;
                                        }

                                        var timeElement = document.getElementById('time');
                                        if (timeElement) {
                                            timeElement.innerHTML = time;
                                        }
                                    </script>
                                    <div class="flex items-center gap-2">
                                        @if ($courses->start_date == null)
                                            <span>No Start Date</span>
                                    
                                            <!-- Form to edit start date -->
                                            <form action="{{ route('admin.edit_start_date', $courses->course_ID) }}" method="POST">
                                                @csrf
                                                <input 
                                                    type="date" 
                                                    name="start_date" 
                                                    id="start_date" 
                                                    min="{{ date('Y-m-d') }}" 
                                                    required
                                                >
                                                <button type="submit">Update</button>
                                            </form>
                                        @else
                                            <span>: {{ \Carbon\Carbon::parse($courses->start_date)->format('F d, Y') }}</span>
                                        @endif
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="w-full">
                                <p class="text-lg font-semibold text-center mb-4">Enrolled Students</p>
                                <table class="w-full border-collapse">
                                    <tr class="bg-[#F2EBFB]  text-left">
                                        <th class="w-[20%] p-2">Parents Name</th>
                                        <th class="w-[20%] py-2">Childs Name</th>
                                        <th class="w-[20%] py-2">Age</th>
                                        <th class="w-[20%] py-2">Contact Number</th>
                                        <th class="w-[20%] py-2">Email Address</th>
                                    </tr>
                                    <script>
                                        document.addEventListener("DOMContentLoaded", function() {
                                            var statusDivs = document.querySelectorAll(".status");
                                    
                                            statusDivs.forEach(function(statusDiv) {
                                                var statusText = statusDiv.querySelector("#status").textContent.trim();
                                    
                                                switch (statusText) {
                                                    case "Pending":
                                                        statusDiv.classList.add("bg-yellow-300");
                                                        break;
                                                    case "Scheduled":
                                                        statusDiv.classList.add("bg-green-300");
                                                        break;
                                                    default:
                                                        break;
                                                }
                                            });
                                        });
                                    </script>
                                    @foreach ($students as $student)
                                        <tr class="border-b border-[#F2EBFB]">
                                            <td class="w-1/5 p-2">{{$student->parent_name}}</td>
                                            <td class="w-1/5 py-2">{{$student->student_name}}</td>
                                            <td class="w-1/12 py-2">{{$student->age}}</td>
                                            <td class="w-1/6 py-2">{{$student->contact_number}}</td>
                                            <td class="w-1/5 py-2">{{$student->email_address}}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>