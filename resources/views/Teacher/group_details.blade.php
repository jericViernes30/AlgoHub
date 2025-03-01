<!doctype html>
<html>
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="{{ asset('js/scripts.js') }}"></script>
  <title>Group Details | AlgoHub</title>
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
<body class="bg-[#ececec] h-fit">
    <div class="w-full h-screen flex flex-col">
        <div class="w-full bg-[#632c7d] flex py-2">
            <div class="w-11/12 mx-auto flex justify-end">
                <div class="relative w-fit flex gap-4 items-center justify-center">
                    <p class="text-sm font-medium text-white uppercase">{{$teacher->last_name}} {{$teacher->first_name}}</p>
                </div>
            </div>
        </div>
        <div class="w-full flex h-full bg-[#F2EBFB]">
            <div class="w-1/6 h-full bg-[#f9f9f9] text-sm">
                <div class="w-full mb-8 mt-10">
                    <img src="https://lms.alg.academy/auth/v3/img/logo.d1092e37.svg" alt="Lesson Logo" class="w-3/4 block mx-auto">
                </div>
                <div class="">
                    <div class="w-full flex items-center px-5 relative bg-[#F2EBFB] border-l-4 border-[#632c7d] hover:cursor-pointer">
                        <a href="{{route('teacher.dashboard')}}" class="py-2">Regular Class</a>
                    </div>
                    <div class="w-full flex items-center px-5 relative hover:bg-[#F2EBFB] hover:cursor-pointer">
                        <a href="{{route('teacher.il_schedule')}}" class="py-2">Introductory Lesson</a>
                    </div>
                    <div class="w-full flex items-center px-5 relative hover:bg-[#F2EBFB] hover:cursor-pointer">
                        <a href="{{route('teacher.profile')}}" class="py-2">Profile</a>
                    </div>
                    <div class="w-full flex items-center px-5 relative hover:bg-[#F2EBFB] hover:cursor-pointer">
                        <a href="{{route('teacher.logout')}}" class="py-2">Logout</a>
                    </div>
                    
                </div>
            </div>
            <div class="w-full p-4">
                <div class="w-full bg-white rounded-lg p-4 mb-8">
                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            // Safely pass the PHP variable to JavaScript
                            var timeSlot = {!! json_encode($class->time_slot) !!};
                            var time = '';
                    
                            switch (timeSlot) {
                                case 'first':
                                    time = "11:00";
                                    break;
                                case 'second':
                                    time = "13:00";
                                    break;
                                case 'third':
                                    time = "15:00";
                                    break;
                                case 'fourth':
                                    time = "17:00";
                                    break;
                                default:
                                    time = "Unknown Time";
                                    break;
                            }
                            console.log("Time Slot:", timeSlot);
                            console.log("Time:", time);
                            document.getElementById('timeLesson').textContent = time;
                        });
                    </script>
                    
                    <div class="flex gap-10 items-center mb-10">
                        <div>
                            <p class="w-fit py-1 px-6 text-sm bg-gray-500 rounded-md text-white font-light mb-2">Group</p>
                            <p class="w-fit py-1 px-5 text-sm bg-gray-500 rounded-md text-white font-light">Face-to-face</p>
                        </div>
                        <div>
                            <p id="course" class="py-1 mb-1 text-lg">{{$class->course_name}}</p>
                            <p class="py-1 text-xs text-gray-600">{{$class->course_name}} Group <span id="day" class="uppercase">{{$class->day}}</span> {{$class->slot}}</p>
                        </div>
                    </div>
                    <div class="w-full flex gap-24 text-xs text-gray-500">
                        <div>
                            <div class="flex gap-5 mb-2">
                                <p id="" class="text-right w-[80px]">Group Start</p>
                                <p id="start" class="text-gray-900 font-medium">{{ \Carbon\Carbon::parse($class->start_date)->format('d.m.Y') }} <span id="timeLesson"></span></p>
                                
                            </div>
                            <div class="flex gap-5 mb-2">
                                <p class="text-right w-[80px]">Next Lesson</p>
                                <p class="text-gray-900 font-medium" id="nextLesson"></p>
                            </div>
                            
                            <script>
                                document.addEventListener('DOMContentLoaded', function () {
                                    // Pass PHP variables to JavaScript
                                    const startDate = {!! json_encode($class->start_date) !!};
                                    const timeSlot = {!! json_encode($class->time_slot) !!};
                            
                                    // Map the time slot to corresponding times
                                    let time = '';
                                    switch (timeSlot) {
                                        case 'first': time = "11:00"; break;
                                        case 'second': time = "13:00"; break;
                                        case 'third': time = "15:00"; break;
                                        case 'fourth': time = "17:00"; break;
                                        default: time = "Unknown Time"; break;
                                    }
                            
                                    // Parse start date and today's date
                                    let currentDate = new Date();
                                    let lessonDate = new Date(startDate);
                            
                                    // If today's date is >= lesson date, increment by 7 days until it's in the future
                                    while (currentDate >= lessonDate) {
                                        lessonDate.setDate(lessonDate.getDate() + 7);
                                    }
                                    const formattedDate = lessonDate.toLocaleDateString('en-GB', {
                                        day: '2-digit',
                                        month: '2-digit',
                                        year: 'numeric',
                                    }).replace(/\//g, '.'); // Replace slashes with dots
                                    const nextLesson = `${formattedDate} ${time}`;

                            
                                    // Update the #nextLesson element with the calculated date
                                    document.getElementById('nextLesson').textContent = nextLesson;
                            
                                    // Debugging
                                    console.log("Start Date:", startDate);
                                    console.log("Current Date:", currentDate);
                                    console.log("Next Lesson Date:", lessonDate);
                                });
                            </script>
                            
                            <div class="flex gap-5 mb-2">
                                <p class="text-right w-[80px]">Lessons Had</p>
                                <p class="text-gray-900 font-medium">1 of 36</p>
                            </div>
                            <div class="flex gap-5 mb-2">
                                <p class="text-right w-[80px]">Students</p>
                                <p class="text-gray-900 font-medium">{{$students->count()}}</p>
                            </div>
                            <div class="flex gap-5 mb-2">
                                <p class="text-right w-[80px]">Course</p>
                                <p class="text-gray-900 font-medium">{{$class->course_name}} ENG</p>
                            </div>
                        </div>
                        <div>
                            <p class="text-blue-950 text-base uppercase">{{$teacher->last_name}} {{$teacher->first_name}}</p>
                            <p class="text-xs text-blue-700 mb-3">Teacher</p>
                            <p class="mb-1">{{$teacher->contact_number}}</p>
                            <p>{{$teacher->email_address}}</p>
                        </div>
                    </div>
                </div>

                <div class="w-full flex items-center">
                    <p id="stdBtn" class="w-fit py-2 px-5 bg-white rounded-tr-md rounded-tl-md text-sm text-gray-700 hover:cursor-pointer">Students</p>
                    <p id="lsnBtn" class="w-fit py-2  px-5 text-sm rounded-tr-md rounded-tl-md hover:cursor-pointer">Lesson and Schedule</p>
                </div>
                <div id="students" class="w-full bg-white rounded-bl-lg rounded-br-lg rounded-tr-lg p-4">
                    <div class="flex items-center font-medium text-blue-950 text-sm mb-4 pt-2 pb-2 border-b-2 border-[#632c7d]">
                        <p class="w-[35%] text-[#632c7d] font-medium">Student Name</p>
                        <p class="w-[20%] text-[#632c7d] font-medium">Enrollment Date</p>
                    </div>
                    @foreach ($students as $student)
                        <div class="flex items-center my-4">
                            <p class="w-[35%] text-blue-800">{{$student->student_name}}</p>
                            <p class="w-[20%]">{{$student->created_at->format('F d, Y h:i a')}}</p>
                        </div>
                        <hr>
                    @endforeach
                </div>
                <div id="lesson_and_schedules" class="hidden w-full bg-white rounded-bl-lg rounded-br-lg rounded-tr-lg p-4 text-sm mb-4">
                    <div class="w-full flex items-center py-2 border-b-2 border-[#632c7d]">
                        <p class="w-[10%] text-[#632c7d] font-medium">#</p>
                        <p class="w-[20%] text-[#632c7d] font-medium">Time</p>
                        <p class="w-[10%] text-[#632c7d] font-medium">Code</p>
                        <p class="w-[60%] text-[#632c7d] font-medium">Lesson</p>
                    </div>
                    <div id="lessonContainer" class="w-full h-[250px] overflow-auto">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function(){
            $('#lsnBtn').on('click', function(){
    $('#lesson_and_schedules').removeClass('hidden');
    $('#lsnBtn').addClass('bg-white');
    $('#students').addClass('hidden');
    $('#stdBtn').removeClass('bg-white');

    let startText = $('#start').text().trim(); // "18.02.2025 17:00"
    let course = $('#course').text().trim();

    // Extract only the date part
    let datePart = startText.split(' ')[0]; // Get "18.02.2025"

    // Convert startDate (dd.mm.yyyy) to a JavaScript Date object
    let dateParts = datePart.split('.'); // ["18", "02", "2025"]
    let currentDate = new Date(`${dateParts[2]}-${dateParts[1]}-${dateParts[0]}T17:00:00`); // yyyy-mm-ddT17:00:00

    if (isNaN(currentDate.getTime())) {
        console.error('Invalid date format:', startText);
        return;
    }

    $.ajax({
        url: '/teacher/course/' + course,
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            let lessonContainer = $('#lessonContainer');
            lessonContainer.html('');

            response.forEach((lesson, index) => {
                let lessonDate = new Date(currentDate);
                lessonDate.setDate(currentDate.getDate() + (index * 7)); // Add 7 days per lesson

                let day = lessonDate.toLocaleDateString('en-GB', { weekday: 'short' }); // "Tue"
                let dayNum = lessonDate.getDate().toString().padStart(2, '0'); // "18"
                let month = (lessonDate.getMonth() + 1).toString().padStart(2, '0'); // "02"
                let year = lessonDate.getFullYear(); // "2025"
                let hours = lessonDate.getHours().toString().padStart(2, '0'); // "17"
                let minutes = lessonDate.getMinutes().toString().padStart(2, '0'); // "00"

                let formattedDate = `${day} ${dayNum}.${month}.${year} ${hours}:${minutes}`; // "Tue 18.02.2025 17:00"

                let lessonHtml = `
                    <div class="w-full flex py-2 border-b border-[#b69fd4] text-gray-700">
                        <p class="w-[10%] font-medium text-xs text-gray-500">${index + 1}</p>
                        <p class="w-[20%] font-medium">${formattedDate}</p>
                        <p class="w-[10%] font-medium">${lesson.code}</p>
                        <div class="w-[60%] flex items-start justify-center gap-1 flex-col">
                            <p class="font-medium">${lesson.lesson}</p>
                            <p class="font-medium text-xs italic text-gray-500">${lesson.description}</p>
                        </div>
                    </div>`;
                lessonContainer.append(lessonHtml);
            });
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
});




            $('#stdBtn').on('click', function(){
                $('#lesson_and_schedules').addClass('hidden')
                $('#students').removeClass('hidden')
                $('#lsnBtn').removeClass('bg-white')
                $('#stdBtn').addClass('bg-white')
            })
        })
    </script>
</body>
</html>