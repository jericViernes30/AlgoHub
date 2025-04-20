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
  <title>Teachers | AlgoHub</title>
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
                <p class="text-lg font-light mb-2">Regular Class Schedule</p>
                <div class="w-full bg-white rounded-lg p-4">
                    <div class="mb-4">
                        <p class="text-xs">Showing items <span class="text-blue-900 font-bold">1 - 3 </span> of <span class="text-blue-900 font-bold">3</span></p>
                    </div>
                    <div class="w-full flex items-center text-sm mb-2 py-2 font-semibold text-blue-950">
                        <p class="w-[27%]">Schedule</p>
                        <p class="w-[33%]">Course</p>
                        <p class="w-[20%]">Lesson Teacher</p>
                        <p class="w-[10%]">Students</p>
                        <p class="w-[10%]">Type</p>
                    </div>
                    <hr>
                    @foreach ($subjects as $subject)
                        <button onclick="window.location.href='class/{{$subject->course_ID}}'" class="w-full flex items-center text-sm mt-4 mb-2 py-2 text-left">
                            <p class="w-[27%]">{{$subject->day}} - {{$subject->formatted_time}}</p>
                            <div class="w-[33%]">
                                <p id="">{{$subject->course_name}}</p>
                                <p class="text-xs font-medium text-blue-500">CID:{{$subject->course_ID}}</p>
                            </div>
                            <p class="w-[20%] text-left">{{$subject->teacher}}</p>
                            <p class="w-[10%] uppercase">{{ $students[$subject->course_ID] ?? 0 }}</p>
                            <p class="w-fit bg-blue-400 px-2 py-1 rounded-md text-xs font-semibold">Face-to-face</p>
                        </button>
                        <hr>
                    @endforeach
                </div>
                
            </div>
        </div>
    </div>
</body>
</html>