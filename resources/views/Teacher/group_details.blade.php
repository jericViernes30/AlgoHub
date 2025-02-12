<!doctype html>
<html>
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@200..800&family=Noto+Sans:ital,wght@0,100..900;1,100..900&family=Oswald:wght@200..700&display=swap" rel="stylesheet">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
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
                <input type="search" name="search" placeholder="Search" class="px-2 py-1 rounded-md w-1/3">
                <div class="flex items-center justify-center">
                    <button class="rounded-md px-2 py-1 bg-[#F2EBFB] flex gap-1 items-center justify-center">
                        <p>Hi, Teacher!</p>
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
                    <a href="" class="text-[#48494b] px-5 hover:bg-[#F2EBFB] rounded-sm w-full py-2">Dashboard</a>
                </div>
                <div>
                    <div onclick="courseDropdown()">
                        <div class="w-full flex items-center justify-around px-5 bg-[#F2EBFB] border-l-4 border-[#833ae0] relative hover:cursor-pointer">
                            <p href="" class=" w-full py-2">My Classes</p>
                            {{-- <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="12" height="12"><path d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z"/></svg> --}}
                        </div>
                        <div id="courses" class="hidden">
                            <div class="w-full flex items-center px-10 relative hover:bg-[#F2EBFB] hover:cursor-pointer">
                                <a href="{{route('teacher.dashboard')}}" class="py-2">Overview</a>
                            </div>
                        </div>
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
                            <p class="py-1 mb-1 text-lg">{{$class->course_name}}</p>
                            <p class="py-1 text-xs text-gray-600">{{$class->course_name}} Group <span class="uppercase">{{$class->day}}</span> {{$class->slot}}</p>
                        </div>
                    </div>
                    <div class="w-full flex gap-24 text-xs text-gray-500">
                        <div>
                            <div class="flex gap-5 mb-2">
                                <p id="" class="text-right w-[80px]">Group Start</p>
                                <p class="text-gray-900 font-medium">{{ \Carbon\Carbon::parse($class->start_date)->format('d.m.Y') }} <span id="timeLesson"></span></p>
                                
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
                    <p class="w-fit p-2 bg-white rounded-tr-md rounded-tl-md text-sm text-gray-700">Students</p>
                    <p class="w-fit p-2 text-sm">Lesson and Schedule</p>
                </div>
                <div class="w-full bg-white rounded-bl-lg rounded-br-lg rounded-tr-lg p-4">
                    <div class="flex items-center font-medium text-blue-950 text-sm mb-4 pt-5">
                        <p class="w-[35%]">Student Name</p>
                        <p class="w-[20%]">Enrollment Date</p>
                    </div>
                    <hr>
                    @foreach ($students as $student)
                        <div class="flex items-center my-4">
                            <p class="w-[35%] text-blue-800">{{$student->student_name}}</p>
                            <p class="w-[20%]">{{$student->created_at->format('F d, Y h:i a')}}</p>
                        </div>
                        <hr>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</body>
</html>