<!doctype html>
<html>
<head>
    <!-- Add jQuery CDN before your script -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://kit.fontawesome.com/5bf9be4e76.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="{{ asset('js/scripts.js') }}"></script>
  <title>Teacher | AlgoHub</title>
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
    <div id="overlay" class="hidden absolute top-0 w-full h-screen z-10 bg-black opacity-70"></div>
    <div id="viewCertificates" class="hidden w-1/2 h-[550px] absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-sm z-20">
        <div class="w-full flex flex-col bg-[#f9f7fc] rounded-xl">
            <div class="w-full flex justify-between bg-[#632c7d] p-4 rounded-tl-xl rounded-tr-xl">
                <p class="text-white">Certificate</p>
                <button id="closeCertificate" class="text-white flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="14" height="14" fill="#f9f9f9"><path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/></svg>
                </button>
                <script>
                    $(document).ready(function(){
                        $('#closeCertificate').on('click', function(){
                            $('#viewCertificates').addClass('hidden');
                            $('#overlay').addClass('hidden');
                        });
                    })
                </script>
            </div>
        </div>
        <div class="bg-white w-full h-4/5 overflow-y-scroll" id="certificates_container">
        </div>
    </div>
    <div id="edit_teacher" class="hidden w-2/6 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-sm z-20">
        <div class="w-full flex flex-col bg-[#f9f7fc] rounded-xl">
            <div class="w-full flex justify-between bg-[#632c7d] p-4 rounded-tl-xl rounded-tr-xl">
                <p class="text-white">Edit teacher</p>
                <button id="close_form_edit" class="text-white flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="14" height="14" fill="#f9f9f9"><path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/></svg>
                </button>
            </div>
            <div class="w-full px-16 py-4">
                <form action="{{route('teacher.edit')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="w-full flex gap-4">
                        <div class="w-1/2 flex flex-col">
                            <label for="" class="mb-1">First name</label>
                            <input type="text" name="edit_first_name" class="w-full rounded-md px-2 py-1 mb-3 border border-[#a9a9a9] focus:border-[#632c7d] outline-none">
                        </div>
                        <div class="w-1/2 flex flex-col">
                            <label for="" class="mb-1">Last name</label>
                            <input type="text" name="edit_last_name" class="w-full rounded-md px-2 py-1 mb-3 border border-[#a9a9a9] focus:border-[#632c7d] outline-none">
                        </div>
                    </div>
                    <div class="w-full flex flex-col mb-1">
                        <label for="" class="mb-1">Contact Number</label>
                        <input type="text" name="edit_contact_number" class="text-center w-full rounded-md px-2 py-1 mb-3 border border-[#a9a9a9] focus:border-[#632c7d] outline-none">
                    </div>
                    <div class="w-full flex flex-col mb-1">
                        <label for="" class="mb-1">Email Address</label>
                        <input type="email" name="edit_email_address" class="text-center w-full rounded-md px-2 py-1 mb-3 border border-[#a9a9a9] focus:border-[#632c7d] outline-none">
                    </div>
                    <p class="mb-2">Certified Courses: <span class="text-gray-500 text-sm">(Check all applies)</span></p>
                    <div class="w-full h-fit flex flex-wrap gap-2 mb-4">
                        <div class="w-fit flex gap-1 items-center">
                            <input type="checkbox" name="edit_certified_courses[]" id="course1" value="Coding Knight">
                            <label for="" class="">Coding Knight</label>
                        </div>
                        <div class="w-fit flex gap-1 items-center">
                            <input type="checkbox" name="edit_certified_courses[]" id="course2" value="Digital Literacy">
                            <label for="" class="">Digital Literacy</label>
                        </div>
                        <div class="w-fit flex gap-1 items-center">
                            <input type="checkbox" name="edit_certified_courses[]" id="course3" value="Visual Programming">
                            <label for="" class="">Visual Programming</label>
                        </div>
                        <div class="w-fit flex gap-1 items-center">
                            <input type="checkbox" name="edit_certified_courses[]" id="course4" value="Game Design">
                            <label for="" class="">Game Design</label>
                        </div>
                        <div class="w-fit flex gap-1 items-center">
                            <input type="checkbox" name="edit_certified_courses[]" id="course5" value="Graphic Design">
                            <label for="" class="">Graphic Design</label>
                        </div>
                        <div class="w-fit flex gap-1 items-center">
                            <input type="checkbox" name="edit_certified_courses[]" id="course6" value="Creating Websites">
                            <label for="" class="">Creating Websites</label>
                        </div>
                        <div class="w-fit flex gap-1 items-center">
                            <input type="checkbox" name="edit_certified_courses[]" id="course7" value="Unity Game Development">
                            <label for="" class="">Unity Game Development</label>
                        </div>
                        <div class="w-fit flex gap-1 items-center">
                            <input type="checkbox" name="edit_certified_courses[]" id="course9" value="Python Start">
                            <label for="" class="">Python Start</label>
                        </div>
                        <div class="w-fit flex gap-1 items-center">
                            <input type="checkbox" name="edit_certified_courses[]" id="course10" value="Python Pro">
                            <label for="" class="">Python Pro</label>
                        </div>
                    </div>
                    <input type="hidden" name="id" value="">
                    <div class="w-full flex justify-end">
                        <button type="submit" class="w-1/4 py-2 bg-[#632c7d] text-white rounded-md">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="add_teacher" class="hidden w-2/6 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-sm z-20">
        <div class="w-full flex flex-col bg-[#f9f7fc] rounded-xl">
            <div class="w-full flex justify-between bg-[#632c7d] p-4 rounded-tl-xl rounded-tr-xl">
                <p class="text-white">Add new Teacher</p>
                <button id="close_form_add" class="text-white flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="14" height="14" fill="#f9f9f9"><path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/></svg>
                </button>
            </div>
            <div class="w-full px-16 py-4">
                <form action="{{route('teacher.create')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="w-full flex gap-4">
                        <div class="w-1/2 flex flex-col">
                            <label for="" class="mb-1">First name <span class="text-red-500 text-sm">*</span></label>
                            <input type="text" name="first_name" class="w-full rounded-md px-2 py-1 mb-3 border border-[#a9a9a9] focus:border-[#632c7d] outline-none" required>
                        </div>
                        <div class="w-1/2 flex flex-col">
                            <label for="" class="mb-1">Last name <span class="text-red-500 text-sm">*</span></label>
                            <input type="text" name="last_name" class="w-full rounded-md px-2 py-1 mb-3 border border-[#a9a9a9] focus:border-[#632c7d] outline-none" required>
                        </div>
                    </div>
                    <div class="w-full flex flex-col mb-1">
                        <label for="" class="mb-1">Contact Number <span class="text-red-500 text-sm">*</span></label>
                        <input type="text" name="contact_number" class="text-center w-full rounded-md px-2 py-1 mb-3 border border-[#a9a9a9] focus:border-[#632c7d] outline-none" required>
                    </div>
                    <div class="w-full flex flex-col mb-1">
                        <label for="" class="mb-1">Email Address <span class="text-red-500 text-sm">*</span></label>
                        <input type="email" name="email_address" class="text-center w-full rounded-md px-2 py-1 mb-3 border border-[#a9a9a9] focus:border-[#632c7d] outline-none" required>
                    </div>
                    <div class="w-full flex items-center gap-2">
                        <div class="w-full flex flex-col">
                            <label for="" class="mb-1">Username <span class="text-red-500 text-sm">*</span></label>
                            <input type="text" name="username" class="w-full rounded-md px-2 py-1 mb-3 border border-[#a9a9a9] focus:border-[#632c7d] outline-none" required>
                        </div>
                    </div>
                    <p class="mb-2">Certified Courses: <span class="text-gray-500 text-sm">(Check all applies)</span></p>
                    <div class="w-full h-fit flex flex-wrap gap-2 mb-4">
                        <div class="w-fit flex gap-1 items-center">
                            <input type="checkbox" name="certified_courses[]" id="course1" value="Coding Knight">
                            <label for="" class="">Coding Knight</label>
                        </div>
                        <div class="w-fit flex gap-1 items-center">
                            <input type="checkbox" name="certified_courses[]" id="course2" value="Digital Literacy">
                            <label for="" class="">Digital Literacy</label>
                        </div>
                        <div class="w-fit flex gap-1 items-center">
                            <input type="checkbox" name="certified_courses[]" id="course3" value="Visual Programming">
                            <label for="" class="">Visual Programming</label>
                        </div>
                        <div class="w-fit flex gap-1 items-center">
                            <input type="checkbox" name="certified_courses[]" id="course4" value="Game Design">
                            <label for="" class="">Game Design</label>
                        </div>
                        <div class="w-fit flex gap-1 items-center">
                            <input type="checkbox" name="certified_courses[]" id="course5" value="Graphic Design">
                            <label for="" class="">Graphic Design</label>
                        </div>
                        <div class="w-fit flex gap-1 items-center">
                            <input type="checkbox" name="certified_courses[]" id="course6" value="Creating Websites">
                            <label for="" class="">Creating Websites</label>
                        </div>
                        <div class="w-fit flex gap-1 items-center">
                            <input type="checkbox" name="certified_courses[]" id="course7" value="Unity Game Development">
                            <label for="" class="">Unity Game Development</label>
                        </div>
                        <div class="w-fit flex gap-1 items-center">
                            <input type="checkbox" name="certified_courses[]" id="course9" value="Python Start">
                            <label for="" class="">Python Start</label>
                        </div>
                        <div class="w-fit flex gap-1 items-center">
                            <input type="checkbox" name="certified_courses[]" id="course10" value="Python Pro">
                            <label for="" class="">Python Pro</label>
                        </div>
                    </div>
                    <div class="mt-2">
                        <p class="mb-1">Upload certificate:</p>
                        <input type="file" name="certificates[]" id="" multiple>
                    </div>
                    <div class="w-full flex justify-end">
                        <button id="submit" type="submit" class="w-1/4 py-2 bg-[#632c7d] text-white rounded-md">Add</button>
                    </div>
                </form>
                {{-- <script>
                    $('#submit').on('click', function(){
                        $('#submit').text('Please wait...')
                        $('#submit').prop('disabled', true)
                        $('#submit').removeClass('bg-[#632c7d]').addClass('bg-[#70398a]')
                    })
                </script> --}}
            </div>
        </div>
    </div>
    <div class="w-full h-screen flex flex-col">
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
                        <a href="{{route('admin.teachers_list')}}" class="w-full flex items-center justify-around px-5 relative bg-[#F2EBFB] border-l-4 rounded-sm border-[#632c7d]">
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
            <div class="w-full p-10">
                <div class="w-full">
                    <div class="w-full mx-auto bg-[#f9f9f9] rounded-xl p-4 text-sm">
                        <p class="text-lg font-medium mb-2">Teachers List</p>
                        <div class="w-full flex justify-end">
                            <button id="add_teacher_btn" class="px-4 bg-[#632c7d] rounded-sm py-1 text-white flex items-center justify-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="14" height="14" fill="white"><path d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z"/></svg>
                                <p>Add new</p>
                            </button>
                        </div>
    
                        <table class="w-full border-collapse mt-5">
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
                                        <img src="{{ asset('images/' . $teacher->profile) }}" alt="" class="w-[45px] h-auto rounded-full bg-contain border-2 border-gray-700">

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
                                    <td class="w-[18%] py-2">{{$teacher->email_address}}</td>
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
                                                        case 'Graphic Design': $bgColor = 'bg-teal-500'; break;
                                                        case 'Coding Knight': $bgColor = 'bg-green-500'; break;
                                                        case 'Digital Literacy': $bgColor = 'bg-sky-500'; break;
                                                        case 'Game Design': $bgColor = 'bg-orange-500'; break;
                                                        case 'Unity Game Development': $bgColor = 'bg-purple-700 text-white'; break;
                                                        case 'Creating Websites': $bgColor = 'bg-purple-500'; break;
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
                                            <button class="certificates" data-certificates={{$teacher->certificates}}>
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" width="13" height="13"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M288 80c-65.2 0-118.8 29.6-159.9 67.7C89.6 183.5 63 226 49.4 256c13.6 30 40.2 72.5 78.6 108.3C169.2 402.4 222.8 432 288 432s118.8-29.6 159.9-67.7C486.4 328.5 513 286 526.6 256c-13.6-30-40.2-72.5-78.6-108.3C406.8 109.6 353.2 80 288 80zM95.4 112.6C142.5 68.8 207.2 32 288 32s145.5 36.8 192.6 80.6c46.8 43.5 78.1 95.4 93 131.1c3.3 7.9 3.3 16.7 0 24.6c-14.9 35.7-46.2 87.7-93 131.1C433.5 443.2 368.8 480 288 480s-145.5-36.8-192.6-80.6C48.6 356 17.3 304 2.5 268.3c-3.3-7.9-3.3-16.7 0-24.6C17.3 208 48.6 156 95.4 112.6zM288 336c44.2 0 80-35.8 80-80s-35.8-80-80-80c-.7 0-1.3 0-2 0c1.3 5.1 2 10.5 2 16c0 35.3-28.7 64-64 64c-5.5 0-10.9-.7-16-2c0 .7 0 1.3 0 2c0 44.2 35.8 80 80 80zm0-208a128 128 0 1 1 0 256 128 128 0 1 1 0-256z"/></svg>
                                            </button>
                                            <script>
                                                $(document).on('click', '.certificates', function () {
                                                    let certificates = $(this).data('certificates').split(',');
                                                    let container = $('#certificates_container');
                                                    $('#viewCertificates').removeClass('hidden');
                                                    $('#overlay').removeClass('hidden');

                                                    // Clear previous images
                                                    container.empty();

                                                    // Laravel base path to public/images
                                                    let basePath = "{{ asset('images') }}";

                                                    // Loop and display each certificate
                                                    certificates.forEach(function(cert) {
                                                        let trimmed = cert.trim();
                                                        if (trimmed) {
                                                            container.append(
                                                                `<img src="${basePath}/${trimmed}" alt="${trimmed}" class="w-full h-auto object-contain mb-2">`
                                                            );
                                                        }
                                                    });
                                                });
                                            </script>

                                            <a href="#" 
                                                id="edit" 
                                                class="edit-teacher"
                                                data-id="{{ $teacher->id }}"
                                                data-firstname="{{ $teacher->first_name }}"
                                                data-lastname="{{ $teacher->last_name }}"
                                                data-contact="{{ $teacher->contact_number }}"
                                                data-email="{{ $teacher->email_address }}"
                                                data-username="{{ $teacher->username }}"
                                                data-courses="{{ $teacher->certified_courses }}"
                                                data-profile="{{ asset('images/' . $teacher->profile) }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="13" height="13"><path d="M441 58.9L453.1 71c9.4 9.4 9.4 24.6 0 33.9L424 134.1 377.9 88 407 58.9c9.4-9.4 24.6-9.4 33.9 0zM209.8 256.2L344 121.9 390.1 168 255.8 302.2c-2.9 2.9-6.5 5-10.4 6.1l-58.5 16.7 16.7-58.5c1.1-3.9 3.2-7.5 6.1-10.4zM373.1 25L175.8 222.2c-8.7 8.7-15 19.4-18.3 31.1l-28.6 100c-2.4 8.4-.1 17.4 6.1 23.6s15.2 8.5 23.6 6.1l100-28.6c11.8-3.4 22.5-9.7 31.1-18.3L487 138.9c28.1-28.1 28.1-73.7 0-101.8L474.9 25C446.8-3.1 401.2-3.1 373.1 25zM88 64C39.4 64 0 103.4 0 152V424c0 48.6 39.4 88 88 88H360c48.6 0 88-39.4 88-88V312c0-13.3-10.7-24-24-24s-24 10.7-24 24V424c0 22.1-17.9 40-40 40H88c-22.1 0-40-17.9-40-40V152c0-22.1 17.9-40 40-40H200c13.3 0 24-10.7 24-24s-10.7-24-24-24H88z"/></svg>
                                             </a>
                                             <a href="javascript:void(0);" onclick="confirmDelete({{ $teacher->id }})" class="text-red-500 hover:text-red-700">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="13" height="13">
                                                    <path d="M170.5 51.6L151.5 80h145l-19-28.4c-1.5-2.2-4-3.6-6.7-3.6H177.1c-2.7 0-5.2 1.3-6.7 3.6zm147-26.6L354.2 80H368h48 8c13.3 0 24 10.7 24 24s-10.7 24-24 24h-8V432c0 44.2-35.8 80-80 80H112c-44.2 0-80-35.8-80-80V128H24c-13.3 0-24-10.7-24-24S10.7 80 24 80h8H80 93.8l36.7-55.1C140.9 9.4 158.4 0 177.1 0h93.7c18.7 0 36.2 9.4 46.6 24.9zM80 128V432c0 17.7 14.3 32 32 32H336c17.7 0 32-14.3 32-32V128H80zm80 64V400c0 8.8-7.2 16-16 16s-16-7.2-16-16V192c0-8.8 7.2-16 16-16s16 7.2 16 16zm80 0V400c0 8.8-7.2 16-16 16s-16-7.2-16-16V192c0-8.8 7.2-16 16-16s16 7.2 16 16zm80 0V400c0 8.8-7.2 16-16 16s-16-7.2-16-16V192c0-8.8 7.2-16 16-16s16 7.2 16 16z"/>
                                                </svg>
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
        function confirmDelete(id) {
            Swal.fire({
    title: "Are you sure?",
    text: "This action cannot be undone!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#d33",
    cancelButtonColor: "#3085d6",
    confirmButtonText: "Yes, delete it!"
}).then((result) => {
    if (result.isConfirmed) {
        $.ajax({
            url: "/admin/delete-teacher/" + id,
            type: "POST", // Keep it as POST
            data: {
                _token: "{{ csrf_token() }}",
                _method: "DELETE" // Laravel method spoofing
            },
            success: function(response) {
                Swal.fire({
                    title: "Deleted!",
                    text: "The teacher has been deleted.",
                    icon: "success",
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    location.reload();
                });
            },
            error: function(response) {
                console.log(response);
                Swal.fire({
                    title: "Error!",
                    text: "Something went wrong.",
                    icon: "error"
                });
            }
        });
    }
});

}

        $(document).ready(function(){
    $('#add_teacher_btn').on('click', function(){
        $('#add_teacher').removeClass('hidden');
        $('#overlay').removeClass('hidden');
    });

    $('#close_form_add').on('click', function(){
        $('#add_teacher').addClass('hidden');
        $('#overlay').addClass('hidden');
    });
    $('#close_form_edit').on('click', function(){
        $('#edit_teacher').addClass('hidden');
        $('#overlay').addClass('hidden');
    });

    // Use event delegation for dynamically added elements
    $(document).on("click", ".edit-teacher", function() {
        $('#edit_teacher').removeClass('hidden')
        $('#overlay').removeClass('hidden')
        let teacherId = $(this).data("id");
        let firstName = $(this).data("firstname");
        let lastName = $(this).data("lastname");
        let contact = $(this).data("contact");
        let email = $(this).data("email");
        let username = $(this).data("username");
        let courses = $(this).data("courses").toString().split(",");
        let profile = $(this).data("profile");

        // Populate form fields
        $("input[name='edit_first_name']").val(firstName);
        $("input[name='id']").val(teacherId);
        $("input[name='edit_last_name']").val(lastName);
        $("input[name='edit_contact_number']").val(contact);
        $("input[name='edit_email_address']").val(email);

        // Uncheck all checkboxes first
        $("input[name='edit_certified_courses[]']").prop("checked", false);

        // Check the relevant courses
        courses.forEach(course => {
            $(`input[name='edit_certified_courses[]'][value='${course.trim()}']`).prop("checked", true);
        });

        // Show profile image if available
        if (profile) {
            $("#profilePreview").attr("src", profile).show();
        } else {
            $("#profilePreview").hide(); // Hide if no image
        }
    });
});

    </script>
</body>
</html>