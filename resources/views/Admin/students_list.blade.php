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
    <div id="body" class="w-full h-screen flex flex-col">
        <div class="w-full bg-[#632c7d] flex py-5">
        </div>
        <div class="w-full flex h-auto bg-[#F2EBFB]">
            <div class="w-1/6 h-full bg-[#f9f9f9] text-sm">
                <div class="w-full mb-8 mt-10">
                    <img src="https://lms.alg.academy/auth/v3/img/logo.d1092e37.svg" alt="Lesson Logo" class="w-3/4 block mx-auto">
                </div>
                <div class="w-full mx-auto flex gap-5 items-center">
                    <a href="{{route('admin.dashboard')}}" class="text-[#48494b] px-5 py-2 w-full">Dashboard</a>
                </div>
                {{-- navigations --}}
                <div>
                    <div onclick="courseDropdown()">
                        <a href="{{route('admin.courses')}}" class="w-full flex items-center justify-around px-5 relative hover:bg-[#F2EBFB] ">
                            <p id="course_dd" href="" class="w-full py-2 text-[#48494b] hover:cursor-pointer">Courses</p>
                        </a>
                    </div>

                    <div onclick="studentsDropdown()">
                        <div class="w-full flex items-center justify-around px-5 relative py-2 bg-[#F2EBFB] border-l-4 rounded-sm border-[#632c7d] hover:cursor-pointer">
                            <p id="sched_dd" class=" w-full text-[#48494b]">Students</p>
                            <svg id="arrow2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="12" height="12"><path d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z"/></svg>
                        </div>
                        <div id="students" class="hidden">
                            <div class="w-full flex items-center px-10 relative hover:bg-[#F2EBFB] hover:cursor-pointer">
                                <a href="{{ route('admin.students') }}" class="py-2 text-[#48494b] hover:cursor-pointer">Enrolled Students</a>
                            </div>
                            <div class="w-full flex items-center px-10 relative hover:bg-[#F2EBFB] hover:cursor-pointer">
                                <a href="{{route('admin.il_schedule')}}" class="py-2 text-[#48494b] hover:cursor-pointer">Expelled Students</a>
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
                                <a href="{{ route('admin.schedule') }}" class="py-2 text-[#48494b] hover:cursor-pointer">Classes</a>
                            </div>
                            <div class="w-full flex items-center px-10 relative hover:bg-[#F2EBFB] hover:cursor-pointer">
                                <a href="{{route('admin.il_schedule')}}" class="py-2 text-[#48494b] hover:cursor-pointer">Intro Lessons</a>
                            </div>
                            <div class="w-full flex items-center px-10 relative mb-4 hover:bg-[#F2EBFB] hover:cursor-pointer">
                                <a href="{{route('admin.schedule.for_scheduling')}}" class="py-2 text-[#48494b] hover:cursor-pointer">For Scheduling</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-full p-10">
                <div class="w-full mx-auto h-fit bg-[#f9f9f9] rounded-xl p-4 text-sm">
                    <p class="text-lg font-medium mb-4">Enrolled Students</p>
                    <div class="w-full flex justify-between mb-3">
                        <div>

                        </div>
                        <div class="w-fit flex flex-col items-end">
                            <p id="showing" class="text-xs font-medium text-[#632c7d] mb-2">Results: <span id="displayed">1 - 8 </span> of <span id="total">  {{$enrolledCount}}</span></p>
                            <div class="w-fit flex gap-2">
                                <div class="w-full flex gap-1">
                                    <button class="w-[30px] h-[30px] rounded-md bg-gray-300"><i class="fa-solid fa-angle-left fa-sm"></i></button>
                                    <button id="first" class="w-[30px] h-[30px] rounded-md text-xs text-white bg-[#632c7d]">1</button>
                                    <button id="second" class="w-[30px] h-[30px] rounded-md bg-gray-300 text-xs text-gray-600">2</button>
                                    <button id="third" class="paginate-btn w-[30px] h-[30px] rounded-md bg-gray-300 text-xs text-gray-600">3</button>
                                    <p id="cat" class="text-2xl text-gray-500">...</p>
                                    <button id="last" class="w-[30px] h-[30px] rounded-md bg-gray-300 text-xs text-gray-600">7</button>
                                    <button class="w-[30px] h-[30px] rounded-md bg-gray-300"><i class="fa-solid fa-angle-right fa-sm"></i></button>
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
                                <th class="w-[5%] py-2">Age</th>
                                <th class="w-1/5 py-2">Course</th>
                                <th class="w-[14%] py-2">Contact Number</th>
                                <th class="w-1/5 py-2">Email Address</th>
                                <th class="w-1/5 p-2 text-center">Actions</th>
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
                                    <td class="w-[5%] py-2">{{$student->age}}</td>
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
                                    <td class="w-1/5 py-2">
                                        <p class="px-4 text-xs w-fit py-1 rounded-full {{$bgColor}}">{{$student->course}}</p>
                                    </td>
                                    <td class="w-[14%] py-2">{{$student->contact_number}}</td>
                                    <td class="w-1/5 py-2">{{$student->email_address}}</td>
                                    <td class="w-1/5 p-2 text-center">
                                        <div class="flex items-center justify-center gap-3">
                                            {{-- <button onclick="proceed('{{ json_encode($students) }}')" class="
                                                @php
                                                    if($student->status == 'Scheduled' || $student->status == 'Enrolled'){
                                                        echo 'cursor-not-allowed';
                                                    }
                                                @endphp"
                                                @php
                                                    if($student->status == 'Scheduled' || $student->status == 'Enrolled'){
                                                        echo 'disabled';
                                                    }
                                                @endphp
                                                >
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="13" height="13"><path d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"/></svg>
                                            </button>
                                            <a href="#" onclick="editSchedule('{{ json_encode($student) }}')">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="13" height="13"><path d="M441 58.9L453.1 71c9.4 9.4 9.4 24.6 0 33.9L424 134.1 377.9 88 407 58.9c9.4-9.4 24.6-9.4 33.9 0zM209.8 256.2L344 121.9 390.1 168 255.8 302.2c-2.9 2.9-6.5 5-10.4 6.1l-58.5 16.7 16.7-58.5c1.1-3.9 3.2-7.5 6.1-10.4zM373.1 25L175.8 222.2c-8.7 8.7-15 19.4-18.3 31.1l-28.6 100c-2.4 8.4-.1 17.4 6.1 23.6s15.2 8.5 23.6 6.1l100-28.6c11.8-3.4 22.5-9.7 31.1-18.3L487 138.9c28.1-28.1 28.1-73.7 0-101.8L474.9 25C446.8-3.1 401.2-3.1 373.1 25zM88 64C39.4 64 0 103.4 0 152V424c0 48.6 39.4 88 88 88H360c48.6 0 88-39.4 88-88V312c0-13.3-10.7-24-24-24s-24 10.7-24 24V424c0 22.1-17.9 40-40 40H88c-22.1 0-40-17.9-40-40V152c0-22.1 17.9-40 40-40H200c13.3 0 24-10.7 24-24s-10.7-24-24-24H88z"/></svg>
                                            </a>
                                            <a href="{{route('admin.delete_client', ['parent_name' => $student->id])}}">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="13" height="13"><path d="M170.5 51.6L151.5 80h145l-19-28.4c-1.5-2.2-4-3.6-6.7-3.6H177.1c-2.7 0-5.2 1.3-6.7 3.6zm147-26.6L354.2 80H368h48 8c13.3 0 24 10.7 24 24s-10.7 24-24 24h-8V432c0 44.2-35.8 80-80 80H112c-44.2 0-80-35.8-80-80V128H24c-13.3 0-24-10.7-24-24S10.7 80 24 80h8H80 93.8l36.7-55.1C140.9 9.4 158.4 0 177.1 0h93.7c18.7 0 36.2 9.4 46.6 24.9zM80 128V432c0 17.7 14.3 32 32 32H336c17.7 0 32-14.3 32-32V128H80zm80 64V400c0 8.8-7.2 16-16 16s-16-7.2-16-16V192c0-8.8 7.2-16 16-16s16 7.2 16 16zm80 0V400c0 8.8-7.2 16-16 16s-16-7.2-16-16V192c0-8.8 7.2-16 16-16s16 7.2 16 16zm80 0V400c0 8.8-7.2 16-16 16s-16-7.2-16-16V192c0-8.8 7.2-16 16-16s16 7.2 16 16z"/></svg>
                                            </a> --}}
                                            <button onclick="window.location.href='{{ route('admin.expel_student', ['student' => $student->student_name, 'course' => $student->course]) }}'" 
                                                class="text-sm px-5 py-1 text-red-500">
                                                Expel
                                            </button>
                                            
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
            
            proceedDiv.querySelector('input[name="student_name"]').value = rowData.childs_name;
            proceedDiv.querySelector('input[name="parent_name"]').value = rowData.parents_name;
            proceedDiv.querySelector('input[name="age"]').value = rowData.age;
            proceedDiv.querySelector('input[name="contact_number"]').value = rowData.contact_number;
            proceedDiv.querySelector('input[name="email_address"]').value = rowData.email_address;
        }

        $(document).ready(function () {
            let lastPage = parseInt($('#last').text()); // Get the last page number dynamically
            let currentPage = parseInt($('#second').text()); // Set initial page (middle button)

            function fetchStudents(page) {
                $.ajax({
                    url: `/admin/students/paginate/${page}`,
                    type: 'GET',
                    dataType: 'json',
                    success: function (response) {
                        console.log(response)
                        $('#total').text(response.total)
                        if(response.total < response.fetch){
                            $('#displayed').text((response.offset + 1) + ' - ' + response.total);
                        } else {
                            $('#displayed').text((response.offset + 1) + ' - ' + response.fetch);
                        }
                        let tableBody = $("#table"); // Replace with the actual table body ID
                        tableBody.find("tr:not(:first-child)").remove(); // Remove only the rows, keeping the header intact

                        response.students.forEach(student => {
                            let bgColor = getBgColor(student.course); // Function to get background color

                            let row = `
                                <tr class="border-b border-[#d8d8d8]">
                                    <td class="w-1/5 py-4 px-2">${student.student_name}</td>
                                    <td class="w-[5%] py-2">${student.age}</td>
                                    <td class="w-1/5 py-2">
                                        <p class="px-4 text-xs w-fit py-1 rounded-full ${bgColor}">${student.course}</p>
                                    </td>
                                    <td class="w-[14%] py-2">${student.contact_number}</td>
                                    <td class="w-1/5 py-2">${student.email_address}</td>
                                    <td class="w-1/5 p-2 text-center">
                                        <div class="flex items-center justify-center gap-3">
                                            <button class="text-sm px-5 py-1 text-red-500">Expel</button>
                                        </div>
                                    </td>
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