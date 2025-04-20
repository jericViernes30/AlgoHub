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
  <title>Introductory Lesson Schedules | AlgoHub</title>
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
<body class="bg-[#ececec] overflow-hidden">
    
    <div id="body" class="w-full h-screen flex flex-col z-0">
        <div class="w-full bg-[#632c7d] flex justify-end items-center py-2">
            <a href="{{route('admin.logout')}}" class="text-white px-10">Logout</a>
        </div>
        <div class="w-full flex h-screen bg-[#F2EBFB]">
            
            @include('partials.header')
            
            <div class="w-full p-4">
                <div class="w-full mx-auto bg-[#f9f9f9] rounded-md p-4 text-sm">
                    <p class="text-lg font-semibold text-center mb-4">Introductory lesson schedules</p>
                    <div class="mb-5 w-full flex justify-between">
                        <button onclick="showAddIlSched()" class="flex items-center gap-2 bg-[#632c7d] rounded-sm px-4 py-1">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="14" height="14" fill="white"><path d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z"/></svg>
                            <p class="text-white">Add IL Schedule</p>
                        </button>
                    </div>
                    <div class="w-full flex justify-between mb-4">
                        <div class="w-[9.09%]"></div>
                        <div class="w-[9.09%]">10:00 AM</div>
                        <div class="w-[9.09%]">11:00 AM</div>
                        <div class="w-[9.09%]">12:00 PM</div>
                        <div class="w-[9.09%]">1:00 PM</div>
                        <div class="w-[9.09%]">2:00 PM</div>
                        <div class="w-[9.09%]">3:00 PM</div>
                        <div class="w-[9.09%]">4:00 PM</div>
                        <div class="w-[9.09%]">5:00 PM</div>
                        <div class="w-[9.09%]">6:00 PM</div>
                        <div class="w-[9.09%]">7:00 PM</div>
                    </div>
                    <script>
                        $(document).ready(function() {
                            // Iterate over each course container in the course-div
                            $('.course-div').each(function() {
                                $(this).find('.course-container').each(function() {
                                    var courseName = $(this).find('.course').text().trim(); // Get course name from each container
                    
                                    // Apply background color based on the course name
                                    switch (courseName) {
                                        case "Graphic Design":
                                            $(this).addClass("bg-teal-300");
                                            break;
                                        case "Visual Programming":
                                            $(this).addClass("bg-yellow-300");
                                            break;
                                        case "Game Design":
                                            $(this).addClass("bg-orange-300");
                                            break;
                                        case "Python Start":
                                            $(this).addClass("bg-red-300");
                                            break;
                                        case "Python Pro":
                                            $(this).addClass("bg-red-500 text-white");
                                            break;
                                        case "Coding Knight":
                                            $(this).addClass("bg-green-300");
                                            break;
                                        case "Digital Literacy":
                                            $(this).addClass("bg-sky-300");
                                            break;
                                        case "Building Website":
                                            $(this).addClass("bg-purple-300");
                                            break;
                                        case "Unity Game Development":
                                            $(this).addClass("bg-purple-500 text-white");
                                            break;
                                        case "Frontend Development":
                                            $(this).addClass("bg-blue-300");
                                            break;
                                        default:
                                            // Optional: Add a default class if needed
                                            break;
                                    }
                                });
                            });
                        });
                    </script>
                    
                    <div class="w-full flex flex-col gap-10 pb-4 font-medium course-div">
                        <div class="w-full flex items-center">
                            <p class="w-[9.09%]">Mon</p>
                            @php
                                $timeslots = [
                                    '10:00 AM', '11:00 AM', '12:00 PM', '1:00 PM', '2:00 PM',
                                    '3:00 PM', '4:00 PM', '5:00 PM', '6:00 PM', '7:00 PM'
                                ];
                            @endphp

                            @foreach ($timeslots as $timeslot)
                                @php
                                    $scheduleForTime = $schedule->where('day', 'Monday')->where('from', $timeslot)->first();
                                @endphp

                                <div onclick="window.location.href='/staff/il-details/{{ $scheduleForTime->code ?? '' }}'" class="course-container cursor-pointer w-[9.09%] py-2 rounded-md overflow-hidden text-nowrap">
                                    @if ($scheduleForTime)
                                        <p class="course text-xs px-2">
                                            {{ $scheduleForTime->course }}
                                        </p>
                                    @else
                                        <p class="course text-xs px-2">
                                        </p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        <div class="w-full flex items-center">
                            <p class="w-[9.09%]">Tue</p>
                            @php
                                $timeslots = [
                                    '10:00 AM', '11:00 AM', '12:00 PM', '1:00 PM', '2:00 PM',
                                    '3:00 PM', '4:00 PM', '5:00 PM', '6:00 PM', '7:00 PM'
                                ];
                            @endphp

                            @foreach ($timeslots as $timeslot)
                                @php
                                    $scheduleForTime = $schedule->where('day', 'Tuesday')->where('from', $timeslot)->first();
                                @endphp

                                <div onclick="window.location.href='/staff/il-details/{{ $scheduleForTime->code ?? '' }}'" class="course-container cursor-pointer w-[9.09%] py-2 rounded-md overflow-hidden text-nowrap">
                                    @if ($scheduleForTime)
                                        <p class="course text-xs px-2">
                                            {{ $scheduleForTime->course }}
                                        </p>
                                    @else
                                        <p class="course text-xs px-2">
                                        </p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        <div class="w-full flex items-center">
                            <p class="w-[9.09%]">Wed</p>
                            @php
                                $timeslots = [
                                    '10:00 AM', '11:00 AM', '12:00 PM', '1:00 PM', '2:00 PM',
                                    '3:00 PM', '4:00 PM', '5:00 PM', '6:00 PM', '7:00 PM'
                                ];
                            @endphp

                            @foreach ($timeslots as $timeslot)
                                @php
                                    $scheduleForTime = $schedule->where('day', 'Wednesday')->where('from', $timeslot)->first();
                                @endphp

                                <div onclick="window.location.href='/staff/il-details/{{ $scheduleForTime->code ?? '' }}'" class="course-container cursor-pointer w-[9.09%] py-2 rounded-md overflow-hidden text-nowrap">
                                    @if ($scheduleForTime)
                                        <p class="course text-xs px-2">
                                            {{ $scheduleForTime->course }}
                                        </p>
                                    @else
                                        <p class="course text-xs px-2">
                                        </p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        <div class="w-full flex items-center">
                            <p class="w-[9.09%]">Thu</p>
                            @php
                                $timeslots = [
                                    '10:00 AM', '11:00 AM', '12:00 PM', '1:00 PM', '2:00 PM',
                                    '3:00 PM', '4:00 PM', '5:00 PM', '6:00 PM', '7:00 PM'
                                ];
                            @endphp

                            @foreach ($timeslots as $timeslot)
                                @php
                                    $scheduleForTime = $schedule->where('day', 'Thursday')->where('from', $timeslot)->first();
                                @endphp

                                <div onclick="window.location.href='/staff/il-details/{{ $scheduleForTime->code ?? '' }}'" class="course-container cursor-pointer w-[9.09%] py-2 rounded-md overflow-hidden text-nowrap">
                                    @if ($scheduleForTime)
                                        <p class="course text-xs px-2">
                                            {{ $scheduleForTime->course }}
                                        </p>
                                    @else
                                        <p class="course text-xs px-2">
                                        </p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        <div class="w-full flex items-center">
                            <p class="w-[9.09%]">Fri</p>
                            @php
                                $timeslots = [
                                    '10:00 AM', '11:00 AM', '12:00 PM', '1:00 PM', '2:00 PM',
                                    '3:00 PM', '4:00 PM', '5:00 PM', '6:00 PM', '7:00 PM'
                                ];
                            @endphp

                            @foreach ($timeslots as $timeslot)
                                @php
                                    $scheduleForTime = $schedule->where('day', 'Friday')->where('from', $timeslot)->first();
                                @endphp

                                <div onclick="window.location.href='/staff/il-details/{{ $scheduleForTime->code ?? '' }}'" class="course-container cursor-pointer w-[9.09%] py-2 rounded-md overflow-hidden text-nowrap">
                                    @if ($scheduleForTime)
                                        <p class="course text-xs px-2">
                                            {{ $scheduleForTime->course }}
                                        </p>
                                    @else
                                        <p class="course text-xs px-2">
                                        </p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        <div class="w-full flex items-center">
                            <p class="w-[9.09%]">Sat</p>
                            @php
                                $timeslots = [
                                    '10:00 AM', '11:00 AM', '12:00 PM', '1:00 PM', '2:00 PM',
                                    '3:00 PM', '4:00 PM', '5:00 PM', '6:00 PM', '7:00 PM'
                                ];
                            @endphp

                            @foreach ($timeslots as $timeslot)
                                @php
                                    $scheduleForTime = $schedule->where('day', 'Saturday')->where('from', $timeslot)->first();
                                @endphp

                                <div onclick="window.location.href='/staff/il-details/{{ $scheduleForTime->code ?? '' }}'" class="course-container cursor-pointer w-[9.09%] py-2 rounded-md overflow-hidden text-nowrap">
                                    @if ($scheduleForTime)
                                        <p class="course text-xs px-2">
                                            {{ $scheduleForTime->course }}
                                        </p>
                                    @else
                                        <p class="course text-xs px-2">
                                        </p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        <div class="w-full flex items-center">
                            <p class="w-[9.09%]">Sun</p>
                            @php
                                $timeslots = [
                                    '10:00 AM', '11:00 AM', '12:00 PM', '1:00 PM', '2:00 PM',
                                    '3:00 PM', '4:00 PM', '5:00 PM', '6:00 PM', '7:00 PM'
                                ];
                            @endphp

                            @foreach ($timeslots as $timeslot)
                                @php
                                    $scheduleForTime = $schedule->where('day', 'Sunday')->where('from', $timeslot)->first();
                                @endphp

                                <div onclick="window.location.href='/staff/il-details/{{ $scheduleForTime->code ?? '' }}'" class="course-container cursor-pointer w-[9.09%] py-2 rounded-md overflow-hidden text-nowrap">
                                    @if ($scheduleForTime)
                                        <p class="course text-xs px-2">
                                            {{ $scheduleForTime->course }}
                                        </p>
                                    @else
                                        <p class="course text-xs px-2">
                                        </p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>