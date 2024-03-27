<!doctype html>
<html>
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
<body class="bg-[#ececec] relative">
    {{-- PROCEED --}}
    <div id="proceed" class="hidden w-2/6 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-sm z-10">
        <div class="w-full flex flex-col bg-[#f9f7fc] rounded-xl">
            <div class="w-full flex justify-between bg-[#833ae0] p-4 rounded-tl-xl rounded-tr-xl">
                <p class="text-white">Select schedule for Enrollment</p>
                <button onclick="closeProceedForm()" class="text-white flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="14" height="14" fill="#f9f9f9"><path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/></svg>
                </button>
            </div>
            <div class="w-full px-16 py-4">
                
                <form action="{{ route('admin.add_to_sched') }}" method="GET">
                    <script>
                        $(document).ready(function(){
                            var course = "{{$il_schedule->course}}"
                            $.ajax({
                                url: '{{ route("admin.get_course_sched", ":course") }}'.replace(':course', course),
                                type:"GET",
                                dataType: 'json',
                                success: function(data){
                                    var selectSchedule = $('select[name="day"]')
                                    selectSchedule.empty()
                                    if($.isEmptyObject(data)){
                                        selectSchedule.append('<option disabled selected>No schedule yet</option>')
                                    } else {
                                        $.each(data, function(time_slot, day) {
                                            var time = ''
                                            switch(time_slot){
                                                case 'first':
                                                    time = "11:00 AM to 1:00 PM"
                                                    break
                                                case 'second':
                                                    time = "1:00 PM to 3:00 PM"
                                                    break
                                                case 'third':
                                                    time = "3:00 PM to 5:00 PM"
                                                    break
                                                case 'fourth':
                                                    time = "5:00 PM to 7:00 PM"
                                                    break
                                                default:
                                                    time = 'Unknown Day';
                                                    break;
                                            }
                                            selectSchedule.append('<option value="' + day  + '">' + day + ' - ' + time  + '</option>');
                                        });
                                    }
                                }
                            })
                        })
                    </script>
                    @csrf
                    <div class="w-full flex flex-col gap-1 mb-4">
                        <label for="">Select schedule</label>
                        <select name="day" id="" class="w-full px-2 py-1 rounded-md border border-[#a9a9a9] focus:border-[#833ae0] outline-none text-center">
                            <option disabled selected>-- Select schedule --</option>
                        </select>
                    </div>
                    <input type="hidden" name="course_name" value="{{$il_schedule->course}}">
                    <input type="hidden" name="student_name">
                    <button class="float-right w-1/4 py-2 bg-[#833ae0] text-white rounded-md">
                        Proceed
                    </button>
                </form>
                {{-- <form action="" method="GET">
                    <script>
                        $(document).ready(function(){
                            var course = "{{$il_schedule->course}}";
                            $.ajax({
                                url: '{{ route("admin.get_course_sched", ":course") }}'.replace(':course', course),
                                type: "GET",
                                dataType: 'json',
                                success: function(data){
                                    var selectSchedule = $('select[name="sched"]');
                                    selectSchedule.empty();
                                    if($.isEmptyObject(data)){
                                        selectSchedule.append('<option disabled selected>No schedule yet</option>');
                                    } else {
                                        $.each(data, function(day, time) {
                                            selectSchedule.append('<option value="' + time + '">' + day + ' - ' + time + '</option>');
                                        });
                                    }
                                }
                            });
                        });
                    </script>
                    @csrf
                    <div class="w-full flex flex-col gap-1 mb-4">
                        <label for="">Select schedule</label>
                        <select name="sched" id="" class="w-full px-2 py-1 rounded-md border border-[#a9a9a9] focus:border-[#833ae0] outline-none text-center">
                            <option disabled selected>-- Select schedule --</option>
                        </select>
                    </div>
                    <button type="submit">
                        PROCEED
                    </button>
                </form> --}}
                
            </div>
        </div>
    </div>
    <div id="body" class="w-full h-screen flex flex-col">
        <div class="w-full bg-[#833ae0] flex py-2">
            <div class="w-4/5 mx-auto flex justify-between">
                <input type="search" name="search" placeholder="Search" class="px-2 py-1 rounded-xl w-1/3">
                <div class="flex items-center justify-center">
                    <button class="rounded-xl px-2 py-1 bg-[#F2EBFB] flex gap-1 items-center justify-center">
                        <p>Hi, Jeric James!</p>
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="12" height="12"><path d="M201.4 342.6c12.5 12.5 32.8 12.5 45.3 0l160-160c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L224 274.7 86.6 137.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l160 160z"/></svg>
                        </span>
                    </button>
                </div>
            </div>
        </div>
        <div class="w-full flex h-screen bg-[#F2EBFB]">
            <div class="w-1/6 h-full bg-[#f9f9f9] text-sm">
                <div class="w-full mx-auto flex gap-5 items-center mt-28">
                    <a href="{{route('admin.dashboard')}}" class="text-[#48494b] px-5 w-full py-2">Dashboard</a>
                </div>
                <div>
                    <div onclick="courseDropdown()">
                        <div class="w-full flex items-center justify-around px-5 relative hover:bg-[#F2EBFB] ">
                            <p id="course_dd" href="" class="w-full py-2 text-[#48494b] hover:cursor-pointer">Courses</p>
                            <svg id="arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="12" height="12"><path d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z"/></svg>
                        </div>
                        <div id="courses" class="hidden">
                            <div class="w-full flex items-center px-10 relative hover:bg-[#F2EBFB] hover:cursor-pointer">
                                <a href="" class="py-2 text-[#48494b]">Overview</a>
                            </div>
                        </div>
                    </div>

                    <div onclick="studentsDropdown()">
                        <div class="w-full flex items-center justify-around px-5 relative hover:bg-[#F2EBFB] hover:cursor-pointer">
                            <p id="students_dd" class=" w-full py-2 text-[#48494b]">Students</p>
                            <svg id="arrow1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="12" height="12"><path d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z"/></svg>
                        </div>
                        <div id="students" class="hidden">
                            <div class="w-full flex items-center px-10 relative hover:bg-[#F2EBFB] hover:cursor-pointer">
                                <a href="" class="py-2 text-[#48494b]">Enrolled</a>
                            </div>
                        </div>
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
                    <p class="text-lg font-semibold text-center mb-4">IL Details</p>

                        <div id="schedule_card" class="w-full border border-[#a9a9a9] rounded-lg p-4 mb-5">
                            <div class="w-full flex items-center gap-2 mb-4">
                                <div class="w-1/3">
                                    <div class="w-full flex items-center gap-2 mb-3">
                                        <p class="font-semibold text-md">Course:</p>
                                        <p class="text-md">{{$il_schedule->course}}</p>
                                    </div>
                                    <div class="w-full flex items-center gap-2">
                                        <p class="font-semibold text-md">Teacher:</p>
                                        <p class="text-md">{{$il_schedule->teacher}}</p>
                                    </div>
                                </div>
                                <div class="w-1/3 flex font-semibold gap-2 items-center justify-center">
                                    <p class="text-md">{{$il_schedule->mm}}</p>
                                    <p class="text-md">{{$il_schedule->dd}}</p>
                                    <p>-</p>
                                    <p class="text-md">{{$il_schedule->day}}</p>
                                </div>
                                <div class="w-1/3">
                                    <div class="w-full flex justify-end gap-2 mb-3">
                                        <p class="font-semibold text-md">Code:</p>
                                        <p class="text-md">{{$il_schedule->code}}</p>
                                    </div>
                                    <div class="w-full flex justify-end gap-2">
                                        <p class="font-semibold text-md">Time:</p>
                                        <p class="text-md">{{$il_schedule->from}} to {{$il_schedule->to}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="w-full">
                                <table class="w-full border-collapse">
                                    <tr class="bg-[#F2EBFB]  text-left">
                                        <th class="w-1/5 p-2">Parents Name</th>
                                        <th class="w-1/5 py-2">Childs Name</th>
                                        <th class="w-1/12 py-2">Age</th>
                                        <th class="w-1/6 py-2">Contact Number</th>
                                        <th class="w-1/5 py-2">Email Address</th>
                                        <th class="w-1/5 py-2 text-center">Status/Remarks</th>
                                        <th class="w-1/5 p-2 text-center">Actions</th>
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
                                                        // Do nothing or add default behavior
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
                                            <td class="w-1/6 py-2">
                                                <div class="status w-1/2 flex mx-auto items-center justify-center rounded-full text-xs py-1">
                                                    <p id="status">{{$student->status}}</p>
                                                </div>
                                            </td>
                                            <td class="w-1/5 p-2">
                                                <button onclick="proceedToEnrollment('{{ json_encode($student) }}')" class="px-2 py-1 bg-[#833ae0] text-white rounded-sm text-xs">Proceed</button>
                                            </td>
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