<!doctype html>
<html>
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/5bf9be4e76.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                    <div class="w-full flex items-center px-5 relative hover:bg-[#F2EBFB] hover:cursor-pointer">
                        <a href="{{route('teacher.dashboard')}}" class="py-2">Regular Class</a>
                    </div>
                    <div class="w-full flex items-center px-5 relative hover:bg-[#F2EBFB] hover:cursor-pointer">
                        <a href="{{route('teacher.il_schedule')}}" class="py-2">Introductory Lesson</a>
                    </div>
                    <div class="w-full flex items-center px-5 relative bg-[#F2EBFB] border-l-4 border-[#632c7d] hover:cursor-pointer">
                        <a href="{{route('teacher.profile')}}" class="py-2">Profile</a>
                    </div>
                    <div class="w-full flex items-center px-5 relative hover:bg-[#F2EBFB] hover:cursor-pointer">
                        <a href="{{route('teacher.logout')}}" class="py-2">Logout</a>
                    </div>
                </div>
            </div>
            <div class="w-full p-10">
                <p class="text-lg font-medium mb-5 uppercase">{{$teacher->last_name}} {{$teacher->first_name}}</p>
                <div class="w-full flex items-center gap-5 mb-10">
                    <button id="genBtn" class="w-1/6 text-sm px-4 py-2 bg-[#632c7d] text-white rounded-md">
                        General Information
                    </button>
                    <button id="passBtn" class="w-1/6 text-sm px-4 py-2 rounded-md">
                        Change Password
                    </button>
                </div>

                @if(session('succees'))
                    <div class="w-full px-4 py-2 rounded-md bg-green-500 flex gap-2 items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="15" height="15" fill="#fff"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"/></svg>
                        <p class=" text-white">{{ session('succees') }}</p>
                    </div>
                @endif
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded-md mb-4">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div id="general_info" class="w-full flex gap-4 h-auto rounded-lg">
                    <div class="w-3/4 bg-white p-4 rounded-md">
                        <div class="mb-5">
                            <p class="text-sm text-[#632c7d] font-medium mb-1">Name</p>
                            <input type="text" class="w-full px-4 py-2 text-sm border border-[#632c7d] rounded-md uppercase" value="{{$teacher->first_name}}" readonly>
                        </div>
                        <div class="mb-5">
                            <p class="text-sm text-[#632c7d] font-medium mb-1">Last name</p>
                            <input type="text" class="w-full px-4 py-2 text-sm border border-[#632c7d] rounded-md uppercase" value="{{$teacher->last_name}}" readonly>
                        </div>
                        <div class="mb-5">
                            <p class="text-sm text-[#632c7d] font-medium mb-1">Login</p>
                            <input type="text" class="w-full px-4 py-2 text-sm border border-[#632c7d] rounded-md" value="{{$teacher->username}}" readonly>
                        </div>
                        <div class="mb-5">
                            <p class="text-sm text-[#632c7d] font-medium mb-1">Email address</p>
                            <input type="text" class="w-full px-4 py-2 text-sm border border-[#632c7d] rounded-md" value="{{$teacher->email_address}}" readonly>
                        </div><div class="">
                            <p class="text-sm text-[#632c7d] font-medium mb-1">Phone</p>
                            <input type="text" class="w-full px-4 py-2 text-sm border border-[#632c7d] rounded-md" value="{{ '+63 (' . substr($teacher->contact_number, 1, 3) . ') ' . substr($teacher->contact_number, 4, 3) . ' ' . substr($teacher->contact_number, 7) }}" readonly>
                        </div>
                    </div>
                    <div class="w-1/4 flex flex-col gap-4">
                        <div class="w-full h-3/4 bg-white p-4 rounded-md flex flex-col items-center justify-center">
                            <img src="{{ asset($teacher->profile ? 'images/' . $teacher->profile : 'images/default.png') }}" 
                                 alt="Teacher Profile" 
                                 class="max-h-full w-auto object-contain rounded-md">
                                 <button id="updateProfileBtn" class="text-xs py-1 px-4 underline">Update Picture</button>
                                 <input type="file" name="profile" id="profile" class="text-xs" hidden>
                                 <input type="hidden" id="teacherId" value="{{$teacher->id}}">
                            <input type="file" name="profile" id="profile" class="text-xs" hidden>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $('#updateProfileBtn').click(function () {
                                    $('#profile').click();
                                });
                        
                                $('#profile').change(function () {
                                    alert('Profile picture selected. Click "Update" to save changes.');
                                    let formData = new FormData();
                                    let file = $('#profile')[0].files[0];
                                    let teacherId = $('#teacherId').val();
                        
                                    if (file) {
                                        formData.append('profile', file);
                                        formData.append('id', teacherId);
                        
                                        $.ajax({
                                            url: "{{ route('teacher.updateProfile') }}",
                                            type: "POST",
                                            data: formData,
                                            contentType: false,
                                            processData: false,
                                            headers: {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                            },
                                            success: function (response) {
                                                Swal.fire({
                                                    title: "Success!",
                                                    text: response.message,
                                                    icon: "success",
                                                    confirmButtonText: "OK"
                                                }).then(() => {
                                                    location.reload(); // Reload the page after clicking "OK"
                                                });
                                            },
                                            error: function (xhr) {
                                                alert('Error updating profile');
                                            }
                                        });
                                    }
                                });
                            });
                        </script>
                        <div class="w-full flex flex-col justify-center h-1/4 bg-white p-4 rounded-md">
                            <p class="text-sm text-[#632c7d] font-medium mb-4">Created on: <span class="text-black font-normal">{{ $teacher->created_at->format('M d, Y h:i A') }}</span></p>
                            <p class="text-sm text-[#632c7d] font-medium">Updated on: <span class="text-black font-normal">{{ $teacher->updated_at->format('M d, Y h:i A') }}</span></p>
                        </div>                    
                    </div>
                </div>

                <div id="change_password" class="hidden w-full h-auto rounded-lg bg-white p-4">
                    <div class="w-3/4 rounded-md block mx-auto">
                        <form action="{{route('teacher.update_password')}}" method="POST">
                            @csrf
                            <div class="w-full flex items-center mb-4">
                                <p class="text-[#632c7d] text-sm font-medium pr-10 w-1/5">New password</p>
                                <div class="w-4/5 flex">
                                    <input type="password" name="new_password" id="new_password" class="w-[74%] px-4 py-2 rounded-tl-md rounded-bl-md text-sm border border-[#632c7d]">
                                    <button type="button" id="showPassword" class="border-t border-r border-b border-[#632c7d] py-2 px-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" width="15" height="15"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z"/></svg>
                                    </button>
                                    <button type="button" id="generatePassword" class="border-t border-r border-b text-xs border-[#632c7d] py-2 px-2 rounded-tr-md rounded-br-md">Generate a password</button>
                                </div>
                            </div>
                            <div class="w-full flex items-center mb-4">
                                <p class="text-[#632c7d] text-sm font-medium w-1/4">Confirm password</p>
                                <div class="w-full flex">
                                    <input type="password" name="confirm_new_password" id="confirm_new_password" class="w-full px-4 py-2 text-sm border border-[#632c7d] rounded-md">
                                </div>
                            </div>
                            <input type="hidden" name="id" value="{{$teacher->id}}">
                            <div class="w-[60%] block mx-auto">
                                <button type="submit" class="border-gray-500 border-2 text-gray-500 py-2 px-10 text-sm rounded-md hover:bg-[#632c7d] transition duration-100 hover:border-[#632c7d] hover:text-white">Change password</button>
                            </div>
                        </form>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function(){
            $('#passBtn').on('click', function(){
                $('#general_info').addClass('hidden');
                $('#genBtn').removeClass('bg-[#632c7d]');
                $('#genBtn').removeClass('text-white');
                $('#change_password').removeClass('hidden');
                $('#passBtn').addClass('bg-[#632c7d]');
                $('#passBtn').addClass('text-white');
            })

            $('#genBtn').on('click', function(){
                $('#change_password').addClass('hidden');
                $('#general_info').removeClass('hidden');
                $('#passBtn').removeClass('bg-[#632c7d]');
                $('#passBtn').removeClass('text-white');
                $('#genBtn').addClass('bg-[#632c7d]');
                $('#genBtn').addClass('text-white');
            })

            $('#generatePassword').on('click', function(){
                var password = Math.random().toString(36).slice(-8);
                $('#new_password').val(password);
                $('#confirm_new_password').val(password);
            })

            $('#showPassword').on('click', function(){
                var password = $('#new_password');
                if(password.attr('type') == 'password'){
                    password.attr('type', 'text');
                } else {
                    password.attr('type', 'password');
                }
            })
        })
    </script>
</body>
</html>