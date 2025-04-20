<!doctype html>
<html>
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  <meta charset="utf-8">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
        <div class="w-full bg-[#632c7d] flex items-center justify-end py-2 px-10 gap-5">
            <p class="text-sm text-white">Hi, admin!</p>
            <button class="w-fit">
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
                        <a href="{{route('admin.courses')}}" class="w-full flex items-center justify-around px-5 relative bg-[#F2EBFB] border-l-4 rounded-sm border-[#632c7d]">
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
            <div class="w-full p-7">
                <p class="text-2xl font-medium">Courses</p>
                <form action="" class="w-full flex justify-end">
                    <input type="file" id="fileInput" class="hidden">
                    <button type="button" id="uploadBtn" class="w-fit text-xs py-2 px-4 bg-green-300">Upload new course</button>
                </form>
                <script>
                    $(document).ready(function() {
                        $('#uploadBtn').click(function() {
                            $('#fileInput').click();
                        });

                        $('#fileInput').change(function(event) {
                            let file = event.target.files[0];
                            if (!file) return;

                            let formData = new FormData();
                            formData.append('file', file);
                            formData.append('_token', '{{ csrf_token() }}');

                            $.ajax({
                                url: '{{ route("upload.course") }}',
                                type: 'POST',
                                data: formData,
                                processData: false,
                                contentType: false,
                                success: function(response) {
                                    alert(response.message);
                                    location.reload();
                                },
                                error: function(xhr) {
                                    console.error('Upload failed:', xhr.responseText);
                                }
                            });
                        });
                    });
                    </script>
                </script>
                <div class="w-full flex flex-wrap gap-5 mt-5">
@foreach($courses as $course)
                    <div 
                    onclick="window.location.href='{{ isset($course) ? route('admin.course_details', ['course' => $course->course]) : '#' }}'" 
                    class="w-[49%] rounded-md shadow-lg bg-white py-10">
                
                    <p class="text-center font-semibold">{{ $course->course ?? 'Unknown Course' }}</p>
                
                </div>
                    @endforeach
                    {{-- <div class="w-1/2 flex flex-col gap-5">
                        <div class="w-full">
                            <div onclick="window.location.href='{{route('admin.coding_knight')}}'" class="w-full rounded-md shadow-lg bg-white py-10">
                                <p class="text-center font-semibold">The Coding Knight</p>
                            </div>
                        </div>
                        <div class="w-full">
                            <div onclick="window.location.href='{{route('admin.visual_programming')}}'" class="w-full rounded-md shadow-lg bg-white py-10">
                                <p class="text-center font-semibold">Digital Literacy</p>
                            </div>
                        </div>
                        <div class="w-full">
                            <div onclick="window.location.href='{{route('admin.visual_programming')}}'" class="w-full rounded-md shadow-lg bg-white py-10">
                                <p class="text-center font-semibold">Visual Programming</p>
                            </div>
                        </div>
                        <div class="w-full">
                            <div onclick="window.location.href='{{route('admin.game_design')}}'" class="w-full rounded-md shadow-lg bg-white py-10">
                                <p class="text-center font-semibold">Game Design</p>
                            </div>
                        </div>
                        <div class="w-full">
                            <div onclick="window.location.href='{{route('admin.game_design')}}'" class="w-full rounded-md shadow-lg bg-white py-10">
                                <p class="text-center font-semibold">Graphic Design</p>
                            </div>
                        </div>
                        <div class="w-full">
                            <div onclick="window.location.href='{{route('admin.game_design')}}'" class="w-full rounded-md shadow-lg bg-white py-10">
                                <p class="text-center font-semibold">Unity Game Development</p>
                            </div>
                        </div>
                    </div>
                    <div class="w-1/2 flex flex-col gap-5">
                        <div class="w-full">
                            <div onclick="window.location.href='{{route('admin.building_websites')}}'" class="w-full rounded-md shadow-lg bg-white py-10">
                                <p class="text-center font-semibold">Building Websites</p>
                            </div>
                        </div>
                        <div class="w-full">
                            <div onclick="window.location.href='{{route('admin.python_start1')}}'" class="w-full rounded-md shadow-lg bg-white py-10">
                                <p class="text-center font-semibold">Python Start (Year 1)</p>
                            </div>
                        </div>
                        <div class="w-full">
                            <div onclick="window.location.href='{{route('admin.python_start2')}}'" class="w-full rounded-md shadow-lg bg-white py-10">
                                <p class="text-center font-semibold">Python Start (Year 2)</p>
                            </div>
                        </div>
                        <div class="w-full">
                            <div onclick="window.location.href='{{route('admin.python_pro1')}}'" class="w-full rounded-md shadow-lg bg-white py-10">
                                <p class="text-center font-semibold">Python Pro (Year 1)</p>
                            </div>
                        </div>
                        <div class="w-full">
                            <div onclick="window.location.href='{{route('admin.python_pro2')}}'" class="w-full rounded-md shadow-lg bg-white py-10">
                                <p class="text-center font-semibold">Python Pro (Year 2)</p>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</body>
</html>