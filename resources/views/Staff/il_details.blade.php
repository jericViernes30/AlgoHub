<!doctype html>
<html>
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="{{ asset('js/scripts.js') }}"></script>
  <title>Introductory Class Details | AlgoHub</title>
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
<body class="bg-[#ececec] relative overflow-hidden">
    {{-- PROCEED --}}
    <div id="proceed" class="hidden w-2/6 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-sm z-10">
        <div class="w-full flex flex-col bg-[#f9f7fc] rounded-xl">
            <div class="w-full flex justify-between bg-[#632c7d] p-4 rounded-tl-xl rounded-tr-xl">
                <p class="text-white">Select schedule for Enrollment</p>
                <button onclick="closeProceedForm()" class="text-white flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="14" height="14" fill="#f9f9f9"><path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/></svg>
                </button>
            </div>
            <div class="w-full px-16 py-4">
                
                <form action="{{ route('admin.add_to_sched') }}" method="GET">
                    <script>
                        $(document).ready(function () {
                            var course = "{{$il_schedule->course}}";
                            $.ajax({
                                url: '{{ route("admin.get_course_sched", ":course") }}'.replace(':course', course),
                                type: "GET",
                                dataType: 'json',
                                success: function (data) {
                                    console.log("Data:", data);
                                    var selectSchedule = $('select[name="course_ID"]');
                                    selectSchedule.empty();

                                    if ($.isEmptyObject(data)) {
                                        selectSchedule.append('<option disabled selected>No schedule yet</option>');
                                    } else {
                                        $.each(data, function (index, schedule) {
                                            console.log("Schedule:", schedule);

                                            var timeSlot = schedule.time_slot;
                                            var day = schedule.day;
                                            var courseID = schedule.course_ID;

                                            // Map the time_slot to human-readable times
                                            var time = '';
                                            switch (timeSlot) {
                                                case 'first':
                                                    time = "11:00 AM to 1:00 PM";
                                                    break;
                                                case 'second':
                                                    time = "1:00 PM to 3:00 PM";
                                                    break;
                                                case 'third':
                                                    time = "3:00 PM to 5:00 PM";
                                                    break;
                                                case 'fourth':
                                                    time = "5:00 PM to 7:00 PM";
                                                    break;
                                                case 'fifth':
                                                    time = "7:00 PM to 9:00 PM";
                                                    break;
                                                default:
                                                    time = "Unknown Time";
                                                    break;
                                            }

                                            // Append the option to the select element
                                            selectSchedule.append(
                                                '<option value="' + courseID + '">' + courseID + ' - ' + day + ' (' + time + ')</option>'
                                            );
                                        });
                                    }
                                },
                                error: function (xhr, status, error) {
                                    console.error("Error fetching schedule:", error);
                                }
                            });
                        });

                    </script>
                    @csrf
                    <div class="w-full flex flex-col gap-1 mb-4">
                        <label for="">Select schedule</label>
                        <select name="course_ID" id="" class="w-full px-2 py-1 rounded-md border border-[#a9a9a9] focus:border-[#632c7d] outline-none text-center">
                            <option disabled selected>-- Select schedule --</option>
                        </select>
                    </div>
                    <input type="hidden" name="student_ID">
                    <input type="hidden" name="student_name">
                    <button class="float-right w-1/4 py-2 bg-[#632c7d] text-white rounded-md">
                        Proceed
                    </button>
                </form>
                
            </div>
        </div>
    </div>
    <div id="body" class="w-full h-screen flex flex-col">
        <div class="w-full bg-[#632c7d] flex py-5">
        </div>
        <div class="w-full flex h-screen bg-[#F2EBFB]">

            @include('partials.header')
            
            <div class="w-full p-4">
                <div class="w-full mx-auto bg-[#f9f9f9] rounded-md p-4 text-sm">
                    <p class="text-lg font-semibold text-center mb-4">IL Details</p>

                        <div id="schedule_card" class="w-full border border-[#a9a9a9] rounded-lg p-4 mb-5">
                            <div class="w-full flex items-center gap-2 mb-10">
                                <div class="w-1/3">
                                    <div class="w-full flex items-center gap-2 mb-3">
                                        <p class="font-semibold text-md">Course:</p>
                                        <p class="text-md">{{$il_schedule->course}}</p>
                                    </div>
                                    <div class="w-full flex items-center gap-2">
                                        <p class="font-semibold text-md">Teacher:</p>
                                        <p class="text-md">{{ optional(App\Models\Teacher::find($il_schedule->teacher))->first_name }}</p>
                                    </div>
                                </div>
                                <div class="w-1/3 flex font-semibold gap-2 items-center justify-center">
                                    <p class="text-md">{{$il_schedule->day}}</p>
                                </div>
                                <div class="w-1/3">
                                    <div class="w-full flex justify-end gap-2 mb-3">
                                        <p class="font-semibold text-md">Code:</p>
                                        <p class="text-md">{{$il_schedule->code}}</p>
                                    </div>
                                    <div class="w-full flex justify-end gap-2">
                                        <p class="font-semibold text-md">Time:</p>
                                        <p class="text-md">{{$il_schedule->from}} to {{$il_schedule->to}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="w-full h-[450px] overflow-auto">
                                <table class="w-full border-collapse">
                                    <tr class="bg-[#F2EBFB]  text-left">
                                        <th class="w-1/5 p-2">Parents Name</th>
                                        <th class="w-1/5 py-2">Childs Name</th>
                                        <th class="w-1/12 py-2">Age</th>
                                        <th class="w-1/6 py-2">Contact Number</th>
                                        <th class="w-1/5 py-2">Email Address</th>
                                        <th class="w-1/5 py-2 text-center">Status/Remarks</th>
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
                                                    case "Completed":
                                                        statusDiv.classList.add("bg-blue-300");
                                                        break;
                                                    case "Enrolled":
                                                        statusDiv.classList.add("bg-green-300");
                                                        break;
                                                    case "DNA":
                                                        statusDiv.classList.add('bg-red-500', 'text-white', 'text-xs', 'text-center');
                                                        break;
                                                    
                                                    statusDiv.classList.add("bg-green-300");
                                                    break;
                                                    default:
                                                        // Do nothing or add default behavior
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
                                            <td class="w-1/6 py-2">
                                                <div class="status w-1/2 flex mx-auto items-center justify-center rounded-full text-xs py-1">
                                                    <p id="status">
                                                        @php
                                                            if($student->status == 'Did not attend'){
                                                                echo 'DNA';
                                                            } else {
                                                                echo $student->status;
                                                            }
                                                        @endphp
                                                    </p>
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
    </div>
    <script>
        $(document).ready(function() {
            $('table tr').each(function() {
                var status = $(this).find('#status').text().trim();
                // alert(status)
                if (status == 'Enrolled' || status == 'DNA') {
                    $(this).find('button').prop('disabled', true).addClass('bg-gray-400 cursor-not-allowed');
                }

            });
        });

        
        function proceedToEnrollment(data){
            var proceed = document.getElementById('proceed');
            var body = document.getElementById('body');
            proceed.classList.toggle('hidden')

            if(!proceed.classList.contains('hidden')){
                body.style.filter = 'blur(2px)'
            } else {
                body.style.filter = 'blur(0px)' 
            }

            const rowData = JSON.parse(data);
            const proceedDiv = document.getElementById('proceed');
            
            proceedDiv.querySelector('input[name="student_name"]').value = rowData.student_name;
            proceedDiv.querySelector('input[name="student_ID"]').value = rowData.id;
        }
    </script>
</body>
</html>