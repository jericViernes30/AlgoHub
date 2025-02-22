<!doctype html>
<html>
<head>
    <!-- Add jQuery CDN before your script -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://kit.fontawesome.com/5bf9be4e76.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        <div class="w-full bg-[#833ae0] flex justify-end items-center py-2">
            <a href="{{route('admin.logout')}}" class="text-white px-10">Logout</a>
        </div>
        <div class="w-full flex h-screen bg-[#F2EBFB]">
            <div class="w-1/6 h-full bg-[#f9f9f9] text-sm">
                <div class="w-full mx-auto flex gap-5 items-center mt-28">
                    <a href="{{route('admin.dashboard')}}" class="text-[#48494b] px-5 py-2 w-full">Dashboard</a>
                </div>
                {{-- navigations --}}
                <div>
                    <div onclick="courseDropdown()">
                        <a href="{{route('admin.courses')}}" class="w-full flex items-center justify-around px-5 relative hover:bg-[#F2EBFB] ">
                            <p id="course_dd" href="" class="w-full py-2 text-[#48494b] hover:cursor-pointer">Courses</p>
                        </a>
                    </div>

                    <div onclick="studentsDropdown()">
                        <a href="{{route('admin.students')}}" class="w-full flex items-center justify-around px-5 relative hover:bg-[#F2EBFB] hover:cursor-pointer">
                            <p id="students_dd" class=" w-full py-2 text-[#48494b]">Students</p>
                        </a>
                    </div>

                    <div onclick="">
                        <a href="" class="w-full flex items-center justify-around px-5 relative bg-[#F2EBFB] border-l-4 rounded-sm border-[#833ae0] hover:cursor-pointer">
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
            <div class="w-full p-10">
                <div class="w-full">
                    <div class="w-full mx-auto bg-[#f9f9f9] rounded-xl p-4 text-sm">
                        <p class="text-lg font-medium mb-4">Teachers List</p>
                        <div class="w-full flex justify-end mb-3">
                            {{-- <button onclick="showAddClient()" class="px-4 bg-[#833ae0] rounded-sm py-1 text-white flex items-center justify-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="14" height="14" fill="white"><path d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z"/></svg>
                                <p>Add new</p>
                            </button> --}}
                        </div>
    
                        <table class="w-full border-collapse mt-10">
                            <tr class="bg-[#F2EBFB] text-left">
                                <th class="w-1/12 p-2">Image</th>
                                <th class="w-[12%] py-2">First name</th>
                                <th class="w-[12%] py-2">Last name</th>
                                <th class="w-[13%] py-2">Contact Number</th>
                                <th class="w-[18%] py-2">Email Address</th>
                                <th class="w-[26.67] py-2">Certified Courses</th>
                                <th class="w-[10%] p-2 text-center">Actions</th>
                            </tr>
                            @foreach ($teachers as $teacher)
                                <tr class="border-b border-[#d8d8d8]">
                                    <td class="w-1/12 py-2 px-2">
                                        <img src="{{asset('images/account_test.png')}}" alt="" class="w-[45px] h-auto rounded-full bg-contain border-2 border-gray-700">
                                    </td>
                                    <td class="w-[12%] py-2">{{$teacher->first_name}}</td>
                                    <td class="w-[12%] py-2">{{$teacher->last_name}}</td>
                                    <td class="w-[13%] py-2">
                                        @php
                                            $contact = $teacher->contact_number;
                                            $contact = substr($contact, 1);
                                            $contact = '+63 ' . substr($contact, 0, 3) . ' ' . substr($contact, 3, 3) . ' ' . substr($contact, 6, 4);
                                        @endphp
                                        {{$contact}}
                                    </td>
                                    <td class="w-[18%] py-2">jericviernes06@gmail.com</td>
                                    <td class="w-[26.67] py-2 text-center">
                                        @php
                                            $courses = explode(',', $teacher->certified_courses);
                                        @endphp

                                        <div class="w-full flex gap-2 items-center flex-wrap">
                                            @foreach($courses as $course)
                                                @php
                                                    $course = trim($course);
                                                    switch ($course) {
                                                        case 'Python Start': $bgColor = 'bg-red-500'; break;
                                                        case 'Python Pro': $bgColor = 'bg-[#800000] text-white'; break;
                                                        case 'Visual Programming': $bgColor = 'bg-yellow-500'; break;
                                                        case 'Coding Knight': $bgColor = 'bg-green-500'; break;
                                                        case 'Digital Literacy': $bgColor = 'bg-sky-500'; break;
                                                        case 'Game Design': $bgColor = 'bg-orange-500'; break;
                                                        case 'Website Creation': $bgColor = 'bg-purple-500'; break;
                                                        case 'Frontend Development': $bgColor = 'bg-blue-800 text-white'; break;
                                                        default: $bgColor = 'bg-gray-500';
                                                    }
                                                @endphp
                                                <div class="py-1 px-4 text-xs {{ $bgColor }} rounded-full">
                                                    {{ $course }}
                                                </div>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="w-[10%] p-2 text-center">
                                        <div class="flex items-center justify-center gap-3">
                                            <button onclick="" class="
                                                {{-- @php
                                                    if($student->status == 'Scheduled' || $student->status == 'Enrolled'){
                                                        echo 'cursor-not-allowed';
                                                    }
                                                @endphp"
                                                @php
                                                    if($student->status == 'Scheduled' || $student->status == 'Enrolled'){
                                                        echo 'disabled';
                                                    }
                                                @endphp --}}
                                                ">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="13" height="13"><path d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"/></svg>
                                            </button>
                                            <a href="#">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="13" height="13"><path d="M441 58.9L453.1 71c9.4 9.4 9.4 24.6 0 33.9L424 134.1 377.9 88 407 58.9c9.4-9.4 24.6-9.4 33.9 0zM209.8 256.2L344 121.9 390.1 168 255.8 302.2c-2.9 2.9-6.5 5-10.4 6.1l-58.5 16.7 16.7-58.5c1.1-3.9 3.2-7.5 6.1-10.4zM373.1 25L175.8 222.2c-8.7 8.7-15 19.4-18.3 31.1l-28.6 100c-2.4 8.4-.1 17.4 6.1 23.6s15.2 8.5 23.6 6.1l100-28.6c11.8-3.4 22.5-9.7 31.1-18.3L487 138.9c28.1-28.1 28.1-73.7 0-101.8L474.9 25C446.8-3.1 401.2-3.1 373.1 25zM88 64C39.4 64 0 103.4 0 152V424c0 48.6 39.4 88 88 88H360c48.6 0 88-39.4 88-88V312c0-13.3-10.7-24-24-24s-24 10.7-24 24V424c0 22.1-17.9 40-40 40H88c-22.1 0-40-17.9-40-40V152c0-22.1 17.9-40 40-40H200c13.3 0 24-10.7 24-24s-10.7-24-24-24H88z"/></svg>
                                            </a>
                                            <a href="">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="13" height="13"><path d="M170.5 51.6L151.5 80h145l-19-28.4c-1.5-2.2-4-3.6-6.7-3.6H177.1c-2.7 0-5.2 1.3-6.7 3.6zm147-26.6L354.2 80H368h48 8c13.3 0 24 10.7 24 24s-10.7 24-24 24h-8V432c0 44.2-35.8 80-80 80H112c-44.2 0-80-35.8-80-80V128H24c-13.3 0-24-10.7-24-24S10.7 80 24 80h8H80 93.8l36.7-55.1C140.9 9.4 158.4 0 177.1 0h93.7c18.7 0 36.2 9.4 46.6 24.9zM80 128V432c0 17.7 14.3 32 32 32H336c17.7 0 32-14.3 32-32V128H80zm80 64V400c0 8.8-7.2 16-16 16s-16-7.2-16-16V192c0-8.8 7.2-16 16-16s16 7.2 16 16zm80 0V400c0 8.8-7.2 16-16 16s-16-7.2-16-16V192c0-8.8 7.2-16 16-16s16 7.2 16 16zm80 0V400c0 8.8-7.2 16-16 16s-16-7.2-16-16V192c0-8.8 7.2-16 16-16s16 7.2 16 16z"/></svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                                
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>