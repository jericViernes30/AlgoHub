<!doctype html>
<html>
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@200..800&family=Noto+Sans:ital,wght@0,100..900;1,100..900&family=Oswald:wght@200..700&display=swap" rel="stylesheet">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://kit.fontawesome.com/5bf9be4e76.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        <div class="w-full bg-[#833ae0] flex justify-end items-center py-2">
            <a href="{{route('admin.logout')}}" class="text-white px-10">Logout</a>
        </div>
        <div class="w-full flex h-screen bg-[#F2EBFB]">
            <div class="w-1/6 h-full bg-[#f9f9f9] text-sm">
                <div class="w-full mx-auto flex gap-5 items-center mt-28 bg-[#F2EBFB] border-l-4 rounded-sm border-[#833ae0]">
                    <a href="{{route('admin.dashboard')}}" class="text-[#48494b] px-5 py-2 w-full">Dashboard</a>
                </div>
                <div>
                    <div onclick="courseDropdown()">
                        <a href="{{route('admin.courses')}}" class="w-full flex items-center justify-around px-5 relative hover:bg-[#F2EBFB] ">
                            <p id="course_dd" href="" class="w-full py-2 text-[#48494b] hover:cursor-pointer">Courses</p>
                        </a>
                    </div>

                    <div onclick="studentsDropdown()">
                        <a href="{{route('admin.students')}}" class="w-full flex items-center justify-around px-5 relative hover:bg-[#F2EBFB] hover:cursor-pointer">
                            <p id="students_dd" class=" w-full py-2 text-[#48494b]">Students</p>
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
                <p class="mb-10">Dashboard</p>
                
                <div class="w-full flex items-center justify-between gap-5">
                    <div class="w-1/4 bg-white p-5 rounded-lg shadow-lg">
                        <p class="text-sm font-semibold">Walk-in clients</p>
                        <p class="text-4xl pt-5 text-center font-medium text-[#833ae0]">63</p>
                    </div>
                    <div class="w-1/4 bg-white p-5 rounded-lg shadow-lg">
                        <p class="text-sm font-semibold">IL'ed students</p>
                        <p class="text-4xl pt-5 text-center font-medium text-[#833ae0]">31</p>
                    </div>
                    <div class="w-1/4 bg-white p-5 rounded-lg shadow-lg">
                        <p class="text-sm font-semibold">Currently enrolled students</p>
                        <p class="text-4xl pt-5 text-center font-medium text-[#833ae0]">29</p>
                    </div>
                    <div class="w-1/4 bg-white p-5 rounded-lg shadow-lg">
                        <p class="text-sm font-semibold">Total enrolled students</p>
                        <p class="text-4xl pt-5 text-center font-medium text-[#833ae0]">95</p>
                    </div>
                </div>

                <div class="w-full flex gap-5">
                    <div class="w-2/3 bg-white p-5 rounded-lg shadow-lg mt-5">
                        <p class="text-center mb-2">Course enrollees graph</p>
                        <canvas id="courseEnrollees" class="w-full"></canvas>
                        <script>
                            var ctx = document.getElementById('courseEnrollees').getContext('2d');
                            var myChart = new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: ['The Coding Knight', 'Digital Literacy', 'Visual Programming', 'Game Design', 'Building Websites', 'Python Start', 'Python Pro', 'Unity Game Development', 'Front-end Development'],
                                    datasets: [{
                                        label: 'Course enrollees',
                                        data: [12, 2, 35, 15, 1, 21, 5, 2, 1],
                                        backgroundColor: [
                                            'rgba(255, 99, 132, 0.6)', // The Coding Knight
                                            'rgba(54, 162, 235, 0.6)', // Digital Literacy
                                            'rgba(255, 206, 86, 0.6)', // Visual Programming
                                            'rgba(75, 192, 192, 0.6)', // Game Design
                                            'rgba(153, 102, 255, 0.6)', // Building Websites
                                            'rgba(255, 159, 64, 0.6)', // Python Start
                                            'rgba(201, 203, 207, 0.6)', // Python Pro
                                            'rgba(99, 132, 255, 0.6)', // Unity Game Development
                                            'rgba(255, 99, 64, 0.6)' // Front-end Development
                                        ],
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    scales: {
                                        y: {
                                            beginAtZero: true
                                        }
                                    }
                                }
                            });
                        </script>
                        
                    </div>
                    
                    <div class="w-1/3 bg-white p-5 rounded-lg shadow-lg mt-5">
                        <p class="text-center mb-2">Course inquiry rate</p>
                        <canvas id="courseInquiry" class="w-full"></canvas>
                        <script>
                            var ctx1 = document.getElementById('courseInquiry').getContext('2d');
                            var myChart1 = new Chart(ctx1, {
                                type: 'doughnut',
                                data: {
                                    labels: ['The Coding Knight', 'Digital Literacy', 'Visual Programming', 'Game Design', 'Building Websites', 'Python Start', 'Python Pro', 'Unity Game Development', 'Front-end Development'],
                                    datasets: [{
                                        label: 'Enrollees',
                                        data: [10, 4, 28, 16, 3, 27, 8, 5, 4],
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    scales: {
                                        y: {
                                            beginAtZero: true
                                        }
                                    }
                                }
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>