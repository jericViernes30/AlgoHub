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
  <title>Class Details | AlgoHub</title>
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
<body class="bg-[#ececec] text-sm">
    <div id="body" class="w-full h-screen flex flex-col z-0">
        <div class="w-full bg-[#632c7d] flex justify-end items-center py-2">
            <a href="{{route('admin.logout')}}" class="text-white px-10">Logout</a>
        </div>
        <div class="w-full flex h-screen bg-[#F2EBFB]">

            @include('partials.header')
            
            <div class="w-full p-4">
                <div class="w-full mx-auto bg-[#f9f9f9] rounded-md p-4 text-sm">
                    <p class="text-lg font-semibold text-center mb-4">Course Details</p>
                        <div id="schedule_card" class="w-full border border-[#a9a9a9] rounded-lg p-4 mb-5">
                            <div class="flex w-full items-center gap-2 mb-5">
                                <div class="w-[10%]">
                                    <p class="font-semibold mb-2">Course Name</p>
                                    <p class="font-semibold mb-2">Teacher:</p>
                                    <p class="font-semibold mb-2">Scheduled Day:</p>
                                    <p class="font-semibold mb-2">Time Slot:</p>
                                    <p class="font-semibold">Start Date:</p>
                                </div>
                                <div>
                                    <p class="mb-2">: {{ $courses->course_name }}</p>
                                    <p class="mb-2">: {{ $courses->teacher }}</p>
                                    <p class="mb-2">: {{ $courses->day }}</p>
                                    <p id="time" class="mb-2"></p>
                                    <script>
                                        var time = ''
                                        console.log('{{$courses->time_slot}}');
                                        switch('{{$courses->time_slot}}'){
                                            case 'first':
                                                time = ": 11:00 AM to 1:00 PM"
                                                break
                                            case 'second':
                                                time = ": 1:00 PM to 3:00 PM"
                                                break
                                            case 'third':
                                                time = ": 3:00 PM to 5:00 PM"
                                                break
                                            case 'fourth':
                                                time = ": 5:00 PM to 7:00 PM"
                                                break
                                            default:
                                                time = 'Unknown Day';
                                                break;
                                        }

                                        var timeElement = document.getElementById('time');
                                        if (timeElement) {
                                            timeElement.innerHTML = time;
                                        }
                                    </script>
                                    <div class="flex items-center gap-2">
                                        @if ($courses->start_date == null)
                                            <span>No Start Date</span>
                                    
                                            <!-- Form to edit start date -->
                                            <form action="{{ route('admin.edit_start_date', $courses->course_ID) }}" method="POST">
                                                @csrf
                                                <input 
                                                    type="date" 
                                                    name="start_date" 
                                                    id="start_date" 
                                                    min="{{ date('Y-m-d') }}" 
                                                    required
                                                >
                                                <button type="submit">Update</button>
                                            </form>
                                        @else
                                            <span>: {{ \Carbon\Carbon::parse($courses->start_date)->format('F d, Y') }}</span>
                                        @endif
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="w-full">
                                <p class="text-lg font-semibold text-center mb-4">Enrolled Students</p>
                                <table class="w-full border-collapse">
                                    <tr class="bg-[#F2EBFB]  text-left">
                                        <th class="w-[20%] p-2">Parents Name</th>
                                        <th class="w-[20%] py-2">Childs Name</th>
                                        <th class="w-[20%] py-2">Age</th>
                                        <th class="w-[20%] py-2">Contact Number</th>
                                        <th class="w-[20%] py-2">Email Address</th>
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
                                                        statusDiv.classList.add("bg-green-300");
                                                        break;
                                                    default:
                                                        break;
                                                }
                                            });
                                        });
                                    </script>
                                    @foreach ($students as $student)
                                        <tr class="border-b border-[#F2EBFB]">
                                            <td class="w-1/5 p-2">{{$student->parent_name}}</td>
                                            <td class="w-1/5 py-2">{{$student->student_name}}</td>
                                            <td class="w-1/12 py-2">{{$student->age}}</td>
                                            <td class="w-1/6 py-2">{{$student->contact_number}}</td>
                                            <td class="w-1/5 py-2">{{$student->email_address}}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>