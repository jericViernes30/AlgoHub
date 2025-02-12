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
                            <p class=" w-full py-2">My Classes</p>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="12" height="12"><path d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z"/></svg>
                        </div>
                        <div id="courses" class="hidden">
                            <div class="w-full flex items-center px-10 relative hover:bg-[#F2EBFB] hover:cursor-pointer">
                                <a href="{{route('teacher.dashboard')}}" class="py-2">Regular Class</a>
                            </div>
                            <div class="w-full flex items-center px-10 relative hover:bg-[#F2EBFB] hover:cursor-pointer">
                                <a href="{{route('teacher.il_schedule')}}" class="py-2">Introductory Lesson</a>
                            </div>
                        </div>
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
                    <p class="w-fit p-2 bg-white rounded-tr-md rounded-tl-md text-sm text-gray-700">Students</p>
                </div>
                <div class="w-full bg-white rounded-bl-lg rounded-br-lg rounded-tr-lg p-4">
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
                            <select name="actions" 
                                    class="action-select outline-none border-2 rounded-md py-1 px-2 border-gray-400 focus:border-[#833ae0]
                                    @if ($student->status != 'Pending') cursor-not-allowed bg-gray-400 border-none @endif"
                                    @if ($student->status != 'Pending') disabled @endif
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