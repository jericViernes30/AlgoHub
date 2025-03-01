<!doctype html>
<html>
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/5bf9be4e76.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="{{ asset('js/scripts.js') }}"></script>
  <title>Walk In Clients | AlgoHub</title>
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
    <div id="proceed" class="hidden w-2/6 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-sm z-10">
        <div class="w-full flex flex-col bg-[#f9f7fc] rounded-xl">
            <div class="w-full flex justify-between bg-[#833ae0] p-4 rounded-tl-xl rounded-tr-xl">
                <p class="text-white">Select course and teacher for Introductory Lesson</p>
                <button onclick="closeProceedForm()" class="text-white flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="14" height="14" fill="#f9f9f9"><path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/></svg>
                </button>
            </div>
            <div class="w-full px-16 py-4">
                <form action="{{route('admin.proceed')}}" method="POST">
                    @csrf
                    <div class="w-full flex flex-col gap-1 mb-4">
                        <label for="" class="font-medium">Choose a Subject</label>
                        <select name="course" id="course_select" class="w-full px-2 py-1 rounded-md border border-[#a9a9a9] focus:border-[#833ae0] outline-none text-center">
                            <option disabled selected>-- Select a course --</option>
                            @foreach ($course as $c)
                                <option value="{{$c->course_name}}">{{$c->course_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <script>
                        $(document).ready(function() {
                            $('#course_select').on('change', function() {
                                var course = $(this).val();
                                if (course) {
                                    $.ajax({
                                        url: '{{ route("admin.get_schedules", ":course") }}'.replace(':course', course),
                                        type: "GET",
                                        dataType: "json",
                                        success: function(data) {
                                            var selectCode = $('select[name="code"]');
                                            selectCode.empty();
                                            if ($.isEmptyObject(data)) {
                                                selectCode.append('<option disabled selected>No schedule yet</option>');
                                            } else {
                                                $.each(data, function(time_slot, code) {
                                                    selectCode.append('<option value="' + code + '">' + time_slot + '</option>');
                                                });
                                            }
                                        }
                                    });
                                } else {
                                    $('select[name="code"]').empty().append('<option disabled selected>Select a Schedule</option>');
                                }
                            });
                        });
                    </script>                    
                    <div class="w-full flex flex-col gap-1 mb-4">
                        <label for="" class="font-medium">Select Schedule</label>
                        <select name="code" id="" class="w-full px-2 py-1 rounded-md border border-[#a9a9a9] focus:border-[#833ae0] outline-none text-center">
                            <option disabled selected>Select a Schedule</option>
                        </select>
                    </div>
                    <input type="hidden" name="student_name">
                    <input type="hidden" name="parent_name">
                    <input type="hidden" name="age">
                    <input type="hidden" name="contact_number">
                    <input type="hidden" name="email_address">
                    <div class="w-full flex items-center gap-3 justify-end">
                        <button type="submit" class="w-1/4 py-2 bg-[#833ae0] text-white rounded-md">Continue</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="edit_schedule" class="hidden w-2/6 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-sm z-10">
        <div class="w-full flex flex-col bg-[#f9f7fc] rounded-xl">
            <div class="w-full flex justify-between bg-[#632c7d] p-4 rounded-tl-xl rounded-tr-xl">
                <p class="text-white">Update client data</p>
                <button onclick="closeUpdateForm()" class="text-white flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="14" height="14" fill="#f9f9f9"><path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/></svg>
                </button>
            </div>
            <div class="w-full px-16 py-4">
                <form action="{{route('admin.update_client')}}" method="POST">
                    @csrf
                    <div class="w-full pb-4 border-b-2 border-[#632c7d]">
                        <div class="w-full flex items-center gap-4">
                            <div class="w-1/2 flex flex-col">
                                <label for="parent_first_name" class="mb-1">Parent's First Name</label>
                                <input type="text" name="parents_first_name" class="w-full rounded-md px-2 py-1 mb-3 border border-[#a9a9a9] focus:border-[#632c7d] outline-none">
                            </div>
                            <div class="w-1/2 flex flex-col">
                                <label for="parent_last_name" class="mb-1">Parent's Last Name</label>
                                <input type="text" name="parents_last_name" class="w-full rounded-md px-2 py-1 mb-3 border border-[#a9a9a9] focus:border-[#632c7d] outline-none">
                            </div>
                        </div>
                        <div class="w-full flex items-center gap-2">
                            <div class="w-1/2 flex flex-col mb-1">
                                <label for="contact_number" class="mb-1">Contact Number</label>
                                <input type="text" name="contact_number" class="w-full rounded-md px-2 py-1 mb-3 border border-[#a9a9a9] focus:border-[#632c7d] outline-none">
                            </div>
                            <div class="w-1/2 flex flex-col mb-1">
                                <label for="email_address" class="mb-1">Email Address</label>
                                <input type="email" name="email_address" class="w-full rounded-md px-2 py-1 mb-3 border border-[#a9a9a9] focus:border-[#632c7d] outline-none">
                            </div>
                        </div>
                    </div>
                    <div class="w-full flex items-center gap-2 mt-4">
                        <div class="w-4/5 flex flex-col">
                            <label for="childs_name" class="mb-1">Child's Name</label>
                            <input type="text" name="childs_name" class="w-full rounded-md px-2 py-1 mb-3 border border-[#a9a9a9] focus:border-[#632c7d] outline-none">
                        </div>
                        <div class="w-1/5 flex flex-col">
                            <label for="age" class="mb-1">Age</label>
                            <input type="text" name="age" class="w-full rounded-md px-2 py-1 mb-3 border border-[#a9a9a9] focus:border-[#632c7d] outline-none">
                        </div>
                    </div>
                    <input type="text" name="id">
                    <div class="w-full flex justify-end">
                        <button type="submit" class="w-1/4 py-2 bg-[#632c7d] text-white rounded-md">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="add_schedule" class="hidden w-2/6 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-sm z-10">
        <div class="w-full flex flex-col bg-[#f9f7fc] rounded-xl">
            <div class="w-full flex justify-between bg-[#632c7d] p-4 rounded-tl-xl rounded-tr-xl">
                <p class="text-white">Add new class Schedule</p>
                <button onclick="closeAddForm()" class="text-white flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="14" height="14" fill="#f9f9f9"><path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/></svg>
                </button>
            </div>
            <div class="w-full px-16 py-4">
                <form action="{{ route('admin.add_client') }}" method="POST">
                    @csrf
                    <div class="w-full pb-4 border-b-2 border-[#632c7d]">
                        <div class="w-full flex items-center gap-4">
                            <div class="w-1/2 flex flex-col">
                                <label for="parent_first_name" class="mb-1">Parent's First Name</label>
                                <input type="text" name="parents_first_name" class="w-full rounded-md px-2 py-1 mb-3 border border-[#a9a9a9] focus:border-[#632c7d] outline-none">
                            </div>
                            <div class="w-1/2 flex flex-col">
                                <label for="parent_last_name" class="mb-1">Parent's Last Name</label>
                                <input type="text" name="parents_last_name" class="w-full rounded-md px-2 py-1 mb-3 border border-[#a9a9a9] focus:border-[#632c7d] outline-none">
                            </div>
                        </div>
                        <div class="w-full flex items-center gap-2">
                            <div class="w-1/2 flex flex-col mb-1">
                                <label for="contact_number" class="mb-1">Contact Number</label>
                                <input type="text" name="contact_number" class="w-full rounded-md px-2 py-1 mb-3 border border-[#a9a9a9] focus:border-[#632c7d] outline-none">
                            </div>
                            <div class="w-1/2 flex flex-col mb-1">
                                <label for="email_address" class="mb-1">Email Address</label>
                                <input type="email" name="email_address" class="w-full rounded-md px-2 py-1 mb-3 border border-[#a9a9a9] focus:border-[#632c7d] outline-none">
                            </div>
                        </div>
                    </div>
                    <div class="w-full flex items-center gap-2 mt-4">
                        <div class="w-4/5 flex flex-col">
                            <label for="childs_name" class="mb-1">Child's Name</label>
                            <input type="text" name="childs_name" class="w-full rounded-md px-2 py-1 mb-3 border border-[#a9a9a9] focus:border-[#632c7d] outline-none">
                        </div>
                        <div class="w-1/5 flex flex-col">
                            <label for="age" class="mb-1">Age</label>
                            <input type="text" name="age" class="w-full rounded-md px-2 py-1 mb-3 border border-[#a9a9a9] focus:border-[#632c7d] outline-none">
                        </div>
                    </div>
                
                    <p class="mb-2">Inquired Courses: <span class="text-gray-500 text-sm">(Check all that apply)</span></p>
                    <div class="w-full h-fit flex flex-wrap gap-2 mb-4">
                        @php
                            $courses = ['Coding Knight', 'Digital Literacy', 'Visual Programming', 'Game Design', 'Graphic Design', 'Creating Websites', 'Unity Game Development', 'Frontend Development', 'Python Start', 'Python Pro'];
                        @endphp
                        @foreach($courses as $index => $course)
                            <div class="w-fit flex gap-1 items-center">
                                <input type="checkbox" name="inquired_courses[]" id="course{{ $index }}" value="{{ $course }}">
                                <label for="course{{ $index }}">{{ $course }}</label>
                            </div>
                        @endforeach
                    </div>
                
                    <div class="w-full flex justify-end">
                        <button type="submit" class="w-1/4 py-2 bg-[#632c7d] text-white rounded-md">Add</button>
                    </div>
                </form>
                
                
            </div>
        </div>
    </div>
    <div id="body" class="w-full h-screen flex flex-col">
        <div class="w-full bg-[#632c7d] flex py-5">
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
                        <div class="w-full flex items-center justify-around px-5 relative hover:bg-[#F2EBFB] hover:cursor-pointer">
                            <p id="students_dd" class=" w-full py-2 text-[#48494b]">Students</p>
                        </div>
                    </div>

                    <div onclick="">
                        <a href="{{route('admin.teachers_list')}}" class="w-full flex items-center justify-around px-5 relative hover:bg-[#F2EBFB] hover:cursor-pointer">
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
                <div class="w-full mx-auto bg-[#f9f9f9] rounded-xl p-4 text-sm">
                    <p class="text-lg font-medium mb-4">Walk-in clients</p>
                    <div class="w-full justify-end flex flex-col items-end mb-3">
                        <p id="showing" class="text-xs font-medium text-[#632c7d] mb-2">Results: <span id="displayed">1 - 8 </span> of <span id="total">  {{$scheduled}}</span></p>
                        <div class="w-fit flex gap-2">
                            <div class="w-full flex gap-1">
                                <button class="w-[30px] h-[30px] rounded-md bg-gray-300"><i class="fa-solid fa-angle-left fa-sm"></i></button>
                                <button id="first" class="w-[30px] h-[30px] rounded-md text-xs text-white bg-[#632c7d]">1</button>
                                <button id="second" class="w-[30px] h-[30px] rounded-md bg-gray-300 text-xs text-gray-600">2</button>
                                <button id="third" class="paginate-btn w-[30px] h-[30px] rounded-md bg-gray-300 text-xs text-gray-600">3</button>
                                <p id="cat" class="text-2xl text-gray-500">...</p>
                                <button id="last" class="w-[30px] h-[30px] rounded-md bg-gray-300 text-xs text-gray-600">7</button>
                                <button class="w-[30px] h-[30px] rounded-md bg-gray-300"><i class="fa-solid fa-angle-right fa-sm"></i></button>
                            </div>
                        </div>
                        <script>
                            $(document).ready(function () {
                                let totalPages = Math.ceil({{$scheduled}} / 8); // Get the total number of pages
                                if (totalPages < 3) {
                                    // $("#third").prop("disabled", true).addClass("cursor-not-allowed opacity-50");
                                    // $("#cat").prop("disabled", true).addClass("cursor-not-allowed opacity-50");
                                    // $("#last").prop("disabled", true).addClass("cursor-not-allowed opacity-50");
                                    $("#third").addClass("hidden");
                                    $("#cat").addClass("hidden");
                                    $("#last").addClass("hidden");
                                }
                            });
                        </script>
                    </div>
                    <div class="w-full flex justify-between mb-3">
                       <input type="search" name="search" placeholder="Search here" class="w-1/5 outline-none border border-[#632c7d] px-2 py-1 rounded-md">
                        <button onclick="showAddClient()" class="px-4 bg-[#632c7d] rounded-sm py-1 text-white flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="14" height="14" fill="white"><path d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z"/></svg>
                            <p>Add new</p>
                        </button>
                    </div>
                    <!-- Success/Error Message Handling -->
                    @if(session('succees'))
                        <div class="w-full px-4 py-2 rounded-md bg-green-500 flex gap-2 items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="15" height="15" fill="#fff"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"/></svg>
                            <p class=" text-white">{{ session('succees') }}</p>
                        </div>
                    @endif
                    @if(session('addClientError'))
                        <p class="px-4 py-2 rounded-md bg-red-500 text-white">{{ session('addClientError') }}</p>
                    @endif
                    @if(session('success'))
                        <div class="w-full px-4 py-2 rounded-md bg-green-500 flex gap-2 items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="15" height="15" fill="#fff"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"/></svg>
                            <p class=" text-white">{{ session('success') }}</p>
                        </div>
                    @endif
                    @if(session('error'))
                        <p class="px-4 py-2 rounded-md bg-red-500 text-white">{{ session('error') }}</p>
                    @endif
                    <div class="w-full relative">
                        <table id="table" class="w-full border-collapse mt-5">
                            <tr class="bg-[#F2EBFB] text-left">
                                <th class="w-1/5 p-2">Parents Name</th>
                                <th class="w-1/5 py-2">Childs Name</th>
                                <th class="w-[5%] py-2">Age</th>
                                <th class="w-[11%] py-2">Contact Number</th>
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
                                                statusDiv.classList.add("bg-blue-300");
                                                break;
                                            case "Enrolled":
                                                statusDiv.classList.add("bg-green-300");
                                                break;
                                            default:
                                                // Do nothing or add default behavior
                                                break;
                                        }
                                    });
                                });
                            </script>
                            @foreach ($scheduling as $for_scheduling)
                                <tr class="border-b border-[#d8d8d8]">
                                    <td class="w-1/5 py-4 px-2"> {{$for_scheduling->parents_first_name}} {{$for_scheduling->parents_last_name}} </td>
                                    <td class="w-1/5 py-2">{{$for_scheduling->childs_name}} {{$for_scheduling->parents_last_name}}</td>
                                    <td class="w-[5%] py-2">{{$for_scheduling->age}}</td>
                                    <td class="w-[11%] py-2">{{$for_scheduling->contact_number}}</td>
                                    <td class="w-1/5 py-2">{{$for_scheduling->email_address}}</td>
                                    <td class="w-1/5 py-2 text-center">
                                        <div class="status w-1/2 mx-auto flex items-center justify-center rounded-full text-xs py-1">
                                            <p id="status">{{$for_scheduling->status}}</p>
                                        </div>
                                    </td>
                                    <td class="w-1/5 p-2 text-center">
                                        <div class="flex items-center justify-center gap-3">
                                            <button onclick="proceed('{{ json_encode($for_scheduling) }}')" class="
                                                @php
                                                    if($for_scheduling->status == 'Scheduled'){
                                                        echo 'cursor-not-allowed';
                                                    }
                                                @endphp"
                                                @php
                                                    if($for_scheduling->status == 'Scheduled'){
                                                        echo 'disabled';
                                                    }
                                                @endphp
                                                >
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="13" height="13"><path d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"/></svg>
                                            </button>
                                            <a href="#" onclick="editSchedule('{{ json_encode($for_scheduling) }}')">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="13" height="13"><path d="M441 58.9L453.1 71c9.4 9.4 9.4 24.6 0 33.9L424 134.1 377.9 88 407 58.9c9.4-9.4 24.6-9.4 33.9 0zM209.8 256.2L344 121.9 390.1 168 255.8 302.2c-2.9 2.9-6.5 5-10.4 6.1l-58.5 16.7 16.7-58.5c1.1-3.9 3.2-7.5 6.1-10.4zM373.1 25L175.8 222.2c-8.7 8.7-15 19.4-18.3 31.1l-28.6 100c-2.4 8.4-.1 17.4 6.1 23.6s15.2 8.5 23.6 6.1l100-28.6c11.8-3.4 22.5-9.7 31.1-18.3L487 138.9c28.1-28.1 28.1-73.7 0-101.8L474.9 25C446.8-3.1 401.2-3.1 373.1 25zM88 64C39.4 64 0 103.4 0 152V424c0 48.6 39.4 88 88 88H360c48.6 0 88-39.4 88-88V312c0-13.3-10.7-24-24-24s-24 10.7-24 24V424c0 22.1-17.9 40-40 40H88c-22.1 0-40-17.9-40-40V152c0-22.1 17.9-40 40-40H200c13.3 0 24-10.7 24-24s-10.7-24-24-24H88z"/></svg>
                                            </a>
                                            <a href="{{route('admin.delete_client', ['parent_name' => $for_scheduling->id])}}">
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
    <script>
        function proceed(data) {
    alert('Clicked');
    console.log("Proceed Data:", data); // Ensure it's an object

    var proceed = document.getElementById('proceed');
    var body = document.getElementById('body');
    proceed.classList.remove('hidden');

    if (!proceed.classList.contains('hidden')) {
        body.style.filter = 'blur(2px)';
    } else {
        body.style.filter = 'blur(0px)';
    }

    // Directly use `data` instead of JSON.parse
    const proceedDiv = document.getElementById('proceed');

    proceedDiv.querySelector('input[name="student_name"]').value = data.childs_name;
    proceedDiv.querySelector('input[name="parent_name"]').value = data.parents_first_name + ' ' + data.parents_last_name;
    proceedDiv.querySelector('input[name="age"]').value = data.age;
    proceedDiv.querySelector('input[name="contact_number"]').value = data.contact_number;
    proceedDiv.querySelector('input[name="email_address"]').value = data.email_address;
}


        $(document).ready(function () {
            $(document).on("click", ".proceed-btn", function() {
            let studentData = $(this).data("student");
            console.log("Proceed Button Clicked: ", studentData);
            proceed(studentData);
        });

        $(document).on("click", ".edit-btn", function() {
            let studentData = $(this).data("student");
            console.log("Edit Button Clicked: ", studentData);
            editSchedule(studentData);
        });


            let lastPage = parseInt($('#last').text()); // Get the last page number dynamically
            let currentPage = parseInt($('#second').text()); // Set initial page (middle button)

            function fetchStudents(page) {
                $.ajax({
                    url: `/admin/students/paginate-walkin/${page}`,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        let tableBody = $("#table");
                        tableBody.empty(); // Clear table before adding new data
                        $('#total').text(response.total)
                        if(response.total < response.fetch){
                            $('#displayed').text((response.offset + 1) + ' - ' + response.total);
                        } else {
                            $('#displayed').text((response.offset + 1) + ' - ' + response.fetch);
                        }
                        response.students.forEach(student => {
                            let row = `
                                <tr class="border-b border-[#d8d8d8]">
                                    <td class="w-1/5 py-4 px-2">${student.parents_first_name} ${student.parents_last_name}</td>
                                    <td class="w-1/5 py-2">${student.childs_name} ${student.parents_last_name}</td>
                                    <td class="w-[5%] py-2">${student.age}</td>
                                    <td class="w-[11%] py-2">${student.contact_number}</td>
                                    <td class="w-1/5 py-2">${student.email_address}</td>
                                    <td class="w-1/5 py-2 text-center">
                                        <div class="status w-1/2 mx-auto flex items-center justify-center rounded-full text-xs py-1">
                                            <p id="status">${student.status}</p>
                                        </div>
                                    </td>
                                    <td class="w-1/5 p-2 text-center">
                                        <div class="flex items-center justify-center gap-3">
                                            <!-- Check Button -->
                                            <button class="proceed-btn" data-student='${JSON.stringify(student).replace(/"/g, '&quot;')}'
    ${student.status === 'Scheduled' ? 'disabled' : ''}>
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="13" height="13">
                                                    <path d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"/>
                                                </svg>
                                            </button>

                                            <a href="#" class="edit-btn" data-student='${JSON.stringify(student)}'>
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="13" height="13">
                                                    <path d="M441 58.9L453.1 71c9.4 9.4 9.4 24.6 0 33.9L424 134.1 377.9 88 407 58.9c9.4-9.4 24.6-9.4 33.9 0zM209.8 256.2L344 121.9 390.1 168 255.8 302.2c-2.9 2.9-6.5 5-10.4 6.1l-58.5 16.7 16.7-58.5c1.1-3.9 3.2-7.5 6.1-10.4zM373.1 25L175.8 222.2c-8.7 8.7-15 19.4-18.3 31.1l-28.6 100c-2.4 8.4-.1 17.4 6.1 23.6s15.2 8.5 23.6 6.1l100-28.6c11.8-3.4 22.5-9.7 31.1-18.3L487 138.9c28.1-28.1 28.1-73.7 0-101.8L474.9 25C446.8-3.1 401.2-3.1 373.1 25z"/>
                                                </svg>
                                            </a>

                                            <!-- Delete Button -->
                                            <a href="/admin/schedules/delete_client/${student.id}">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="13" height="13">
                                                    <path d="M170.5 51.6L151.5 80h145l-19-28.4c-1.5-2.2-4-3.6-6.7-3.6H177.1c-2.7 0-5.2 1.3-6.7 3.6zm147-26.6L354.2 80H368h48 8c13.3 0 24 10.7 24 24s-10.7 24-24 24h-8V432c0 44.2-35.8 80-80 80H112c-44.2 0-80-35.8-80-80V128H24c-13.3 0-24-10.7-24-24S10.7 80 24 80h8H80 93.8l36.7-55.1C140.9 9.4 158.4 0 177.1 0h93.7c18.7 0 36.2 9.4 46.6 24.9zM80 128V432c0 17.7 14.3 32 32 32H336c17.7 0 32-14.3 32-32V128H80zm80 64V400c0 8.8-7.2 16-16 16s-16-7.2-16-16V192c0-8.8 7.2-16 16-16s16 7.2 16 16zm80 0V400c0 8.8-7.2 16-16 16s-16-7.2-16-16V192c0-8.8 7.2-16 16-16s16 7.2 16 16zm80 0V400c0 8.8-7.2 16-16 16s-16-7.2-16-16V192c0-8.8 7.2-16 16-16s16 7.2 16 16z"/>
                                                </svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            `;
                            tableBody.append(row);
                        });

                        // Apply status color after updating the table
                        document.querySelectorAll(".status").forEach(statusDiv => {
                            let statusText = statusDiv.querySelector("#status").textContent.trim();

                            switch (statusText) {
                                case "Pending":
                                    statusDiv.classList.add("bg-yellow-300");
                                    break;
                                case "Scheduled":
                                    statusDiv.classList.add("bg-blue-300");
                                    break;
                                case "Enrolled":
                                    statusDiv.classList.add("bg-green-300");
                                    break;
                            }
                        });
                    },

                    error: function (xhr, status, error) {
                        console.error("AJAX Error:", status, error);
                    }
                });
            }   



            $('#second').on('click', function(){
                let currentPage = parseInt($('#second').text())
                fetchStudents(currentPage)

                $("#first, #second, #third").removeClass("bg-[#632c7d] text-white").addClass("bg-gray-300 text-gray-600");

                // Highlight the new middle button
                $("#second").removeClass("bg-gray-300").addClass("bg-[#632c7d] text-white");

            })

            $('#first').on('click', function(){
                let currentPage = parseInt($('#first').text())
                fetchStudents(currentPage)

                $("#first, #second, #third").removeClass("bg-[#632c7d] text-white").addClass("bg-gray-300 text-gray-600");

                // Highlight the new middle button
                $("#first").removeClass("bg-gray-300").addClass("bg-[#632c7d] text-white");

            })

            $(".w-full button").click(function () {
                let clickedId = $(this).attr("id");

                if (clickedId === "third") {
                    let secondVal = parseInt($("#second").text()); // Get middle value
                    
                    if (secondVal + 1 < lastPage) { 
                        // Normal increment behavior
                        let newFirst = secondVal;
                        let newSecond = secondVal + 1;
                        let newThird = secondVal + 2;

                        // Update text values
                        $("#first").text(newFirst);
                        $("#second").text(newSecond);
                        $("#third").text(newThird);
                        currentPage = newSecond; // Update current page

                        // Reset classes for all buttons
                        $("#first, #second, #third").removeClass("bg-[#632c7d] text-white").addClass("bg-gray-300 text-gray-600");

                        // Highlight the new middle button
                        $("#second").removeClass("bg-gray-300").addClass("bg-[#632c7d] text-white");

                        // Fetch new data
                        fetchStudents(currentPage);
                    } else {
                        // If #third reaches the last page, make it active
                        $("#first, #second, #third").removeClass("bg-[#632c7d] text-white").addClass("bg-gray-300 text-gray-600");
                        $("#third").removeClass("bg-gray-300").addClass("bg-[#632c7d] text-white");
                    }
                }

                if (clickedId === "first") {
                    let firstVal = parseInt($("#first").text()); // Get the first value
                    
                    if (firstVal > 1) { 
                        // Normal decrement behavior
                        let newFirst = firstVal - 1;
                        let newSecond = firstVal;
                        let newThird = firstVal + 1;

                        // Update text values
                        $("#first").text(newFirst);
                        $("#second").text(newSecond);
                        $("#third").text(newThird);
                        currentPage = newSecond; // Update current page

                        // Reset classes for all buttons
                        $("#first, #second, #third").removeClass("bg-[#632c7d] text-white").addClass("bg-gray-300 text-gray-600");

                        // Highlight the new middle button
                        $("#second").removeClass("bg-gray-300").addClass("bg-[#632c7d] text-white");

                        // Fetch new data
                        fetchStudents(currentPage);
                    } else {
                        // If #first reaches 1, make it active
                        $("#first, #second, #third").removeClass("bg-[#632c7d] text-white").addClass("bg-gray-300 text-gray-600");
                        $("#first").removeClass("bg-gray-300").addClass("bg-[#632c7d] text-white");
                    }
                }
            });
        });
    </script>
</body>
</html>