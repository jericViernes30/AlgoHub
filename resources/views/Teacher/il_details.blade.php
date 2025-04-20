<!doctype html>
<html>
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <title>Introductory Class Details | AlgoHub</title>
  <link rel="shortcut icon" href="{{asset('images/algo-logo.png')}}" type="image/x-icon">
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
        <div class="w-full bg-[#632c7d] flex py-2">
            <div class="w-11/12 mx-auto flex gap-5 justify-end">
                @include('partials.notifs')
                <script>
                    $(document).ready(function () {
                        function fetchNotifications() {
                            $.ajax({
                                url: "{{ route('teacher.notifications') }}", // Replace with your actual route
                                method: "GET",
                                dataType: "json",
                                success: function (data) {
                                    console.log(data);
                
                if (data.message == 'true') {
                    $("#notifBadge").removeClass('hidden'); // Show badge with count
                } else {
                    $("#notifBadge").addClass('hidden'); // Hide badge if no notifications
                }
                                },
                                error: function () {
                                    console.error("Failed to fetch notifications.");
                                }
                            });
                        }
                
                        // Fetch notifications every 1 second
                        setInterval(fetchNotifications, 1000);
                    });
                </script>
                <script>
                    $(document).ready(function () {
                        $('#notifButton').on('click', function () {
                            $('#notifs').toggleClass('hidden');
                
                            // Mark notifications as seen when the panel opens
                            if (!$('#notifs').hasClass('hidden')) {
                                var teacherID = $('#notifButton').data('teacherid'); // Get teacher ID dynamically
                                
                                $.ajax({
                                    url: "{{ route('teacher.seenNotif', ':teacher') }}".replace(':teacher', teacherID),
                                    type: "GET",
                                    success: function(response) {
                                        console.log(response.message);
                                        $('#notifBadge').addClass('hidden'); // Hide the red dot when seen
                                    },
                                    error: function(xhr) {
                                        console.log('Error:', xhr.responseText);
                                    }
                                });
                            }
                        });
                    });
                </script>
                 
                
                <div class="relative w-fit flex gap-4 items-center justify-center">
                    <p class="text-sm font-medium text-white uppercase">{{$teacher->last_name}} {{$teacher->first_name}}</p>
                </div>
            </div>
        </div>
        <div class="w-full flex h-screen bg-[#F2EBFB]">
            <div class="w-1/6 h-full bg-[#f9f9f9] text-sm">
                <div class="w-full mb-8 mt-10">
                    <img src="https://lms.alg.academy/auth/v3/img/logo.d1092e37.svg" alt="Lesson Logo" class="w-3/4 block mx-auto">
                </div>
                <div class="">
                    <div class="w-full flex items-center px-5 relative hover:bg-[#F2EBFB] hover:cursor-pointer">
                        <a href="{{route('teacher.dashboard')}}" class="py-2">Regular Class</a>
                    </div>
                    <div class="w-full flex items-center px-5 relative bg-[#F2EBFB] border-l-4 border-[#632c7d] hover:cursor-pointer">
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
                    
                    <div class="flex gap-10 items-center mb-10">
                        <div>
                            <p class="w-fit py-1 px-6 text-sm bg-gray-500 rounded-md text-white font-light mb-2">IL Group</p>
                            <p class="w-fit py-1 px-5 text-sm bg-gray-500 rounded-md text-white font-light">Face-to-face</p>
                        </div>
                        <div>
                            <p class="py-1 mb-1 text-lg">{{$il->course}}</p>
                            <p class="py-1 text-xs text-gray-600">{{$il->course}} Introductory Lesson <span class="uppercase">{{$il->day}}</span> {{$il->from}}</p>
                        </div>
                    </div>
                    <div class="w-full flex gap-24 text-xs text-gray-500">
                        <div>
                            <div class="flex gap-5 mb-2">
                                <p class="text-right w-[80px]">Students</p>
                                <p class="text-gray-900 font-medium">{{$students->count()}}</p>
                            </div>
                            <div class="flex gap-5 mb-2">
                                <p class="text-right w-[80px]">Course</p>
                                <p class="text-gray-900 font-medium">{{$il->course}} ENG</p>
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
                    <p class="w-fit py-2 px-5 bg-white rounded-tr-md rounded-tl-md text-sm text-gray-700">Students</p>
                </div>
                <div class="w-full bg-white h-[350px] overflow-auto rounded-bl-lg rounded-br-lg rounded-tr-lg p-4">
                    <div class="flex items-center font-medium text-blue-950 text-sm mb-4 pt-5">
                        <p class="w-[30%]">Student Name</p>
                        <p class="w-[25%]">Scheduled Date</p>
                        <p class="w-[20%]">Status</p>
                        <p class="w-[10%]">Actions</p>
                    </div>
                    <hr>
                    @foreach ($students as $student)
                        <div class="flex items-center my-3">
                            <p class="w-[30%] text-blue-800 student-name">{{$student->student_name}}</p>
                            <p class="w-[25%]">{{$student->created_at->format('F d, Y h:i a')}}</p>
                            <div class="w-[20%]">
                                @php
                                    $statusClass = '';
                                    switch ($student->status) {
                                        case 'Pending':
                                            $statusClass = 'bg-yellow-300';
                                            break;
                                        case 'Completed':
                                            $statusClass = 'bg-blue-300 text-white';
                                            break;
                                        case 'Enrolled':
                                            $statusClass = 'bg-green-300 text-black';
                                            break;
                                        case 'Did not attend':
                                            $statusClass = 'bg-red-500 text-white text-xs';
                                            break;
                                    }
                                @endphp
                                <p class="status w-1/2 px-5 py-1 text-center rounded-full text-sm {{ $statusClass }}">
                                    {{$student->status}}
                                </p>
                            </div>
                            @php
    $isToday = \Carbon\Carbon::parse($il->day)->isToday();
@endphp

<select name="actions"
    class="action-select outline-none border-2 rounded-md py-1 px-2 border-gray-400 focus:border-[#632c7d]
    @if ($student->status != 'Pending' || !$isToday) cursor-not-allowed bg-gray-400 border-none @endif"
    @if ($student->status != 'Pending' || !$isToday) disabled @endif
>
    <option selected disabled>Select</option>
    <option value="completed">Completed</option>
    <option value="dna">Did not attend</option>
</select>
                        </div>
                        <hr>
                    @endforeach

                    <script>
                        // Use event delegation to handle multiple selects dynamically
                        $(document).on('change', '.action-select', function() {
                            var action = $(this).val();
                            var row = $(this).closest('.flex'); // Target the specific row
                            var studentName = row.find('.student-name').text();
                            var statusElement = row.find('.status');
                            var il = '{{$il->code}}';
                            var teacher = '{{$teacher->id}}';
                            var token = '{{csrf_token()}}';

                            $.ajax({
                                url: '/teacher/il_details/update/',
                                type: 'GET',
                                data: {
                                    action: action,
                                    student: studentName,
                                    il: il,
                                    teacher: teacher,
                                    _token: token
                                },
                                success: function(data) {
                                    if (action === 'completed') {
                                        alert('Status changed to: Completed');
                                        statusElement.text('Completed').removeClass().addClass('status w-1/2 px-5 py-1 text-center rounded-full text-sm bg-blue-300 text-white');
                                    } else if (action === 'dna') {
                                        alert('Status changed to: Did not attend');
                                        statusElement.text('Did not attend').removeClass().addClass('status w-1/2 px-5 py-1 text-center rounded-full text-sm bg-red-300 text-white');
                                    }
                                    location.reload()
                                },
                                error: function(error) {
                                    alert('Error! Status not changed');
                                }
                            });
                        });
                    </script>

                </div>
            </div>
        </div>
    </div>
</body>
</html>