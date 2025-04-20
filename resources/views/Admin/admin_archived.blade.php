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
                    <p class="text-lg font-medium mb-4">Archived Students</p>
                    <div class="w-full flex justify-between mb-3">
                        <div>

                        </div>
                    </div>
                    <div class="w-full h-[480px] overflow-auto">
                        <table id="table" class="w-full border-collapse mt-5">
                            <tr class="bg-[#F2EBFB] text-left">
                                <th class="w-1/5 p-2">Childs Name</th>
                                <th class="w-[15%] py-2">Course</th>
                                <th class="w-[15%] py-2">Contact Number</th>
                                <th class="w-1/5 py-2">Email Address</th>
                                <th class="w-[25%] p-2 text-center">Last update</th>
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
                                    <td class="w-[15%] py-2">{{$student->contact_number}}</td>
                                    <td class="w-1/5 py-2">{{$student->email_address}}</td>
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