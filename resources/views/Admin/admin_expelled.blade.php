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
  <title>Students | AlgoHub</title>
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
                    @csrf
                    <p>Select course</p>
                    <select name="course" id="course" class="w-full px-2 py-1 rounded-md border border-[#a9a9a9] focus:border-[#632c7d] outline-none text-center mb-2">
                        @foreach ($courses as $course)
                            <option value="{{$course->course_name}}">{{$course->course_name}}</option>
                        @endforeach
                    </select>
                    <script>
                        $(document).ready(function () {
                            $('#course').change(function() {
                                let course = $(this).val();
                                console.log(course); // Logs the selected course

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
                            
                        });

                    </script>
                    @csrf
                    <div class="w-full flex flex-col gap-1 mb-4">
                        <label for="">Select schedule</label>
                        <select name="course_ID" id="" class="w-full px-2 py-1 rounded-md border border-[#a9a9a9] focus:border-[#632c7d] outline-none text-center">
                            <option disabled selected>-- Select schedule --</option>
                        </select>
                    </div>
                    {{-- <input type="hidden" name="student_ID"> --}}
                    <input type="text" name="student_name">
                    <button class="float-right w-1/4 py-2 bg-[#632c7d] text-white rounded-md">
                        Proceed
                    </button>
                </form>
                
            </div>
        </div>
    </div>
    <div id="body" class="w-full h-screen flex flex-col">
        <div class="w-full bg-[#632c7d] flex items-center justify-end py-2 px-10 gap-5">
            <p class="text-sm text-white">Hi, admin!</p>
            <button onclick="window.location.href='{{route('admin.logout')}}'" class="w-fit">
                <img src="{{asset('images/logout.png')}}" alt="PUTANGINANG IMAGE" class="w-2/3">
            </button>
        </div>
        <div class="w-full flex h-auto bg-[#F2EBFB]">
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
                        <a href="{{route('admin.courses')}}" class="w-full flex items-center justify-around px-5 relative hover:bg-[#F2EBFB]">
                            <p id="course_dd" href="" class="w-full py-2 text-[#48494b] hover:cursor-pointer">Courses</p>
                        </a>
                    </div>

                    <div onclick="studentsDropdown()">
                        <div class="w-full flex items-center justify-around px-5 relative py-2 hover:cursor-pointer bg-[#F2EBFB] border-l-4 rounded-sm border-[#632c7d]">
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
            <div class="w-full p-10">
                <div class="w-full mx-auto h-fit bg-[#f9f9f9] rounded-xl p-4 text-sm">
                    <p class="text-lg font-medium mb-4">Expelled Students</p>
                    <div class="w-full flex justify-between mb-3">
                        <div>

                        </div>
                        <div class="w-fit flex flex-col items-end">
                            <p id="showing" class="text-xs font-medium text-[#632c7d] mb-2">Results: <span id="displayed">1 - {{$enrolledCount < 8 ? $enrolledCount : '8'}} </span> of <span id="total">  {{$enrolledCount}}</span></p>
                            <div class="w-fit flex gap-2">
                                <div class="w-full flex gap-1">
                                    <button id="first" class="w-[30px] h-[30px] rounded-md text-xs text-white bg-[#632c7d]">1</button>
                                    <button id="second" class="w-[30px] h-[30px] rounded-md bg-gray-300 text-xs text-gray-600">2</button>
                                    <button id="third" class="paginate-btn w-[30px] h-[30px] rounded-md bg-gray-300 text-xs text-gray-600">3</button>
                                    <p id="cat" class="text-2xl text-gray-500">...</p>
                                    <button id="last" class="w-[30px] h-[30px] rounded-md bg-gray-300 text-xs text-gray-600">7</button>
                                </div>
                            </div>
                            <script>
                                $(document).ready(function () {
                                    let totalPages = Math.ceil({{$enrolledCount}} / 8); // Get the total number of pages
                                    if (totalPages < 3) {
                                        // $("#third").prop("disabled", true).addClass("cursor-not-allowed opacity-50");
                                        // $("#cat").prop("disabled", true).addClass("cursor-not-allowed opacity-50");
                                        // $("#last").prop("disabled", true).addClass("cursor-not-allowed opacity-50");
                                        $("#third").addClass("hidden");
                                        $("#cat").addClass("hidden");
                                        $("#last").addClass("hidden");
                                    }
                                });
                            </script>
                        </div>

                    </div>
                    <div class="w-full h-[480px] overflow-auto">
                        <table id="table" class="w-full border-collapse mt-5">
                            <tr class="bg-[#F2EBFB] text-left">
                                <th class="w-1/5 p-2">Childs Name</th>
                                <th class="w-[15%] py-2">Course</th>
                                <th class="w-[15%] py-2">Contact Number</th>
                                <th class="w-1/5 py-2">Email Address</th>
                                <th class="w-[25%] p-2 text-center">Expelled Date</th>
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
                                                statusDiv.classList.add("bg-blue-300");
                                                break;
                                            case "Enrolled":
                                                statusDiv.classList.add("bg-green-300");
                                                break;
                                            case "DNA":
                                                statusDiv.classList.add('bg-red-500', 'text-white', 'text-xs', 'text-center');
                                                break;
                                            default:
                                                // Do nothing or add default behavior
                                                break;
                                        }
                                    });
                                });
                            </script>
                            @foreach ($students as $student)
                                <tr class="border-b border-[#d8d8d8]">
                                    <td class="w-1/5 py-4 px-2">{{$student->student_name}}</td>
                                    @php
                                        switch ($student->course) {
                                            case 'Python Start': $bgColor = 'bg-red-500 text-white'; break;
                                            case 'Python Pro': $bgColor = 'bg-[#800000] text-white'; break;
                                            case 'Visual Programming': $bgColor = 'bg-yellow-500'; break;
                                            case 'Graphic Design': $bgColor = 'bg-teal-500'; break;
                                            case 'Coding Knight': $bgColor = 'bg-green-500'; break;
                                            case 'Digital Literacy': $bgColor = 'bg-sky-500'; break;
                                            case 'Game Design': $bgColor = 'bg-orange-500'; break;
                                            case 'Unity Game Development': $bgColor = 'bg-purple-700 text-white'; break;
                                            case 'Creating Websites': $bgColor = 'bg-purple-500'; break;
                                            case 'Frontend Development': $bgColor = 'bg-blue-800 text-white'; break;
                                            default: $bgColor = 'bg-gray-500';
                                        }
                                    @endphp
                                    <td class="w-[15%] py-2">
                                        <p class="px-4 text-xs w-fit py-1 rounded-full {{$bgColor}}">{{$student->course}}</p>
                                    </td>
                                    <td class="w-[15%] py-2">{{$student->il_data->contact_number}}</td>
                                    <td class="w-1/5 py-2">{{$student->il_data->email_address}}</td>
                                    <td class="w-[25%] p-2 text-center">
                                        {{ $student->updated_at->format('F d, Y - h:i a') }}
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

        function proceed(data){
            var proceed = document.getElementById('proceed')
            var body = document.getElementById('body');
            proceed.classList.remove('hidden')

            if(!proceed.classList.contains('hidden')){
                body.style.filter = 'blur(2px)'
            } else {
                body.style.filter = 'blur(0px)'
            }

            const rowData = JSON.parse(data);
            const proceedDiv = document.getElementById('proceed');
            
            proceedDiv.querySelector('input[name="student_name"]').value = rowData.student_name;
        }


        $(document).ready(function () {
            let lastPage = parseInt($('#last').text()); // Get the last page number dynamically
            let currentPage = parseInt($('#second').text()); // Set initial page (middle button)



            function fetchStudents(page) {
                $.ajax({
                    url: `/admin/expelled/paginate/${page}`,
                    type: 'GET',
                    dataType: 'json',
                    success: function (response) {
                console.log(response);
                $('#total').text(response.total);

                if (response.total < response.fetch) {
                    $('#displayed').text((response.offset + 1) + ' - ' + response.total);
                } else {
                    $('#displayed').text((response.offset + 1) + ' - ' + response.fetch);
                }

                let tableBody = $("#table"); // Adjust the actual table body ID
                tableBody.find("tr:not(:first-child)").remove(); // Keep the header, remove rows

                response.students.forEach(student => {
                    let bgColor = getBgColor(student.course); // Function to get background color
 // Format created_at to "F d, Y - h:i A"
 let createdAt = new Date(student.created_at);
    let formattedDate = createdAt.toLocaleString('en-US', {
        month: 'long', 
        day: '2-digit', 
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
        hour12: true
    });
                    let row = `
                        <tr class="border-b border-[#d8d8d8]">
                            <td class="w-1/5 py-4 px-2">${student.student_name}</td>
                            <td class="w-[15%] py-2">
                                <p class="px-4 text-xs w-fit py-1 rounded-full ${bgColor}">${student.course}</p>
                            </td>
                            <td class="w-[15%] py-2">${student.il_data.contact_number}</td>
                            <td class="w-1/5 py-2">${student.il_data.email_address}</td>
                            <td class="w-[25%] p-2 text-center">${formattedDate}</td>
                        </tr>
                    `;

                    tableBody.append(row);
                });
            },
                    error: function (xhr, status, error) {
                        console.error("AJAX Error:", status, error);
                    }
                });
            }   

            // Helper function to get the background color
            function getBgColor(course) {
                switch (course) {
                    case 'Python Start': return 'bg-red-500 text-white';
                    case 'Python Pro': return 'bg-[#800000] text-white';
                    case 'Visual Programming': return 'bg-yellow-500';
                    case 'Graphic Design': return 'bg-teal-500';
                    case 'Coding Knight': return 'bg-green-500';
                    case 'Digital Literacy': return 'bg-sky-500';
                    case 'Game Design': return 'bg-orange-500';
                    case 'Unity Game Development': return 'bg-purple-700 text-white';
                    case 'Creating Websites': return 'bg-purple-500';
                    case 'Frontend Development': return 'bg-blue-800 text-white';
                    default: return 'bg-gray-500';
                }
            }



            $('#second').on('click', function(){
                let currentPage = parseInt($('#second').text())
                fetchStudents(currentPage)

                $("#first, #second, #third").removeClass("bg-[#632c7d] text-white").addClass("bg-gray-300 text-gray-600");

                // Highlight the new middle button
                $("#second").removeClass("bg-gray-300").addClass("bg-[#632c7d] text-white");

            })

            $('#first').on('click', function(){
                let currentPage = parseInt($('#first').text())
                fetchStudents(currentPage)

                $("#first, #second, #third").removeClass("bg-[#632c7d] text-white").addClass("bg-gray-300 text-gray-600");

                // Highlight the new middle button
                $("#first").removeClass("bg-gray-300").addClass("bg-[#632c7d] text-white");

            })

            $(".w-full button").click(function () {
                let clickedId = $(this).attr("id");

                if (clickedId === "third") {
                    let secondVal = parseInt($("#second").text()); // Get middle value
                    
                    if (secondVal + 1 < lastPage) { 
                        // Normal increment behavior
                        let newFirst = secondVal;
                        let newSecond = secondVal + 1;
                        let newThird = secondVal + 2;

                        // Update text values
                        $("#first").text(newFirst);
                        $("#second").text(newSecond);
                        $("#third").text(newThird);
                        currentPage = newSecond; // Update current page

                        // Reset classes for all buttons
                        $("#first, #second, #third").removeClass("bg-[#632c7d] text-white").addClass("bg-gray-300 text-gray-600");

                        // Highlight the new middle button
                        $("#second").removeClass("bg-gray-300").addClass("bg-[#632c7d] text-white");

                        // Fetch new data
                        fetchStudents(currentPage);
                    } else {
                        // If #third reaches the last page, make it active
                        $("#first, #second, #third").removeClass("bg-[#632c7d] text-white").addClass("bg-gray-300 text-gray-600");
                        $("#third").removeClass("bg-gray-300").addClass("bg-[#632c7d] text-white");
                    }
                }

                if (clickedId === "first") {
                    let firstVal = parseInt($("#first").text()); // Get the first value
                    
                    if (firstVal > 1) { 
                        // Normal decrement behavior
                        let newFirst = firstVal - 1;
                        let newSecond = firstVal;
                        let newThird = firstVal + 1;

                        // Update text values
                        $("#first").text(newFirst);
                        $("#second").text(newSecond);
                        $("#third").text(newThird);
                        currentPage = newSecond; // Update current page

                        // Reset classes for all buttons
                        $("#first, #second, #third").removeClass("bg-[#632c7d] text-white").addClass("bg-gray-300 text-gray-600");

                        // Highlight the new middle button
                        $("#second").removeClass("bg-gray-300").addClass("bg-[#632c7d] text-white");

                        // Fetch new data
                        fetchStudents(currentPage);
                    } else {
                        // If #first reaches 1, make it active
                        $("#first, #second, #third").removeClass("bg-[#632c7d] text-white").addClass("bg-gray-300 text-gray-600");
                        $("#first").removeClass("bg-gray-300").addClass("bg-[#632c7d] text-white");
                    }
                }
            });
        });





    </script>
</body>
</html>