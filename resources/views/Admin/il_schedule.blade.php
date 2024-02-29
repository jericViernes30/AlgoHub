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
<body class="bg-[#ececec]">
    <div class="w-full h-screen flex flex-col">
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
                <div class="w-full mx-auto bg-[#f9f9f9] rounded-3xl p-4 text-sm">
                    <p class="text-lg font-semibold text-center mb-4">Introductory lesson schedules</p>
                    <form action="admin.show_il_schedule" method="POST" class="w-full border-b py-2 flex gap-2 items-center mb-4">
                        @csrf
                        <div class="flex gap-2 items-center">
                            <p class="font-semibold">Select course:</p>
                            <select name="course_select" id="">
                                <option value="1">Coding Knight</option>
                                <option value="2">Digital Literacy</option>
                                <option value="3">Visual Programming</option>
                                <option value="4">Game Design</option>
                                <option value="5">Video Blogging</option>
                                <option value="6">Graphic Design</option>
                                <option value="7">Unity Game Development</option>
                                <option value="8">Website Creation</option>
                                <option value="9">Front-end Development</option>
                                <option value="10">Pyhton Start</option>
                                <option value="11">Python Pro</option>
                            </select>  
                        </div>
                        <button type="submit" class="px-4 bg-[#833ae0] rounded-sm py-1 text-white flex items-center justify-center gap-2">
                            Submit
                        </button>
                    </form>
                    <div class="w-full">
                        <div class="w-full flex items-center gap-2 mb-4">
                            <div class="w-1/3">
                                <div class="w-full flex items-center gap-2 mb-3">
                                    <p class="font-semibold text-md">Course:</p>
                                    <p class="text-md">Coding Knight</p>
                                </div>
                                <div class="w-full flex items-center gap-2">
                                    <p class="font-semibold text-md">Teacher:</p>
                                    <p class="text-md">Roy G. Broniola</p>
                                </div>
                            </div>
                            <div class="w-1/3 flex font-semibold gap-2 items-center justify-center">
                                <p class="text-md">February</p>
                                <p class="text-md">28</p>
                                <p>-</p>
                                <p class="text-md">Wednesday</p>
                            </div>
                            <div class="w-1/3">
                                <div class="w-full flex flex-col items-end justify-center gap-2">
                                    <p class="font-semibold text-md">Time:</p>
                                    <p class="text-md">12:30 - 1:00</p>
                                </div>
                            </div>
                        </div>
                        <div class="w-full">
                            <table class="w-full border-collapse">
                                <tr class="bg-[#F2EBFB] border-b-2 border-[#833ae0] text-left">
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
                                <tr class="border-b border-[#d8d8d8]">
                                    <td class="w-1/5 p-2">Roy G. Broniola</td>
                                    <td class="w-1/5 py-2">Nissan Dagpin</td>
                                    <td class="w-1/12 py-2">26</td>
                                    <td class="w-1/6 py-2">09976589181</td>
                                    <td class="w-1/5 py-2">jericviernes06@gmail.com</td>
                                    <td class="w-1/6 py-2">
                                        <div class="status w-1/2 flex mx-auto items-center justify-center rounded-full text-xs py-1">
                                            <p id="status">Pending</p>
                                        </div>
                                    </td>
                                    <td class="w-1/5 p-2">
                                        <button class="px-2 py-1 bg-[#833ae0] text-white rounded-sm text-xs">Proceed</button>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>