<!doctype html>
<html>
<head>
    <!-- Add jQuery CDN before your script -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://kit.fontawesome.com/5bf9be4e76.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="{{ asset('js/scripts.js') }}"></script>
    <title>Staff | AlgoHub</title>
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
<body class="bg-[#ececec] relative">
    <div id="overlay" class="hidden absolute top-0 w-full h-screen z-10 bg-black opacity-70"></div>
    <div id="print_div" class="hidden w-1/4 absolute top-1/2 left-1/2 bg-white transform -translate-x-1/2 -translate-y-1/2 text-sm z-20">
        <div class="w-full h-auto p-4">
            <label for="report_type" class="text-xl font-medium">Select Report:</label>
            <div class="w-full flex items-center gap-4 my-5">
                <div class="w-1/2 flex items-center gap-2">
                    <input type="radio" name="report_type" id="monthly" value="monthly">
                    <label for="monthly">Monthly Report</label>
                </div>
                <div class="w-1/2 flex items-center gap-2">
                    <input type="radio" name="report_type" id="daily" value="daily">
                    <label for="daily">Daily Report</label>
                </div>
            </div>
            <div id="monthsContainer" class="mb-5 hidden">
                <select name="month" id="months" class="w-full py-2 text-center rounded-lg outline-none border">
                    <option value="January">January</option>
                    <option value="February">February</option>
                    <option value="March">March</option>
                    <option value="April">April</option>
                    <option value="May">May</option>
                    <option value="June">June</option>
                    <option value="July">July</option>
                    <option value="August">August</option>
                    <option value="September">September</option>
                    <option value="October">October</option>
                    <option value="November">November</option>
                    <option value="December">December</option>
                </select>
            </div>
            <button id="generate-btn" class="w-full py-2 rounded-lg bg-[#632c7d] text-white hidden">Generate Report</button>
        </div>
        <script>
            $(document).ready(function () {
                $("#generate-btn").hide();
                $("#monthsContainer").hide();

                $("input[name='report_type']").on("change", function () {
                    let selectedReport = $(this).val();
                    
                    if (selectedReport === "daily") {
                        $("#generate-btn").show();
                        $("#monthsContainer").hide();
                    } else {
                        $("#monthsContainer").show();
                        $("#generate-btn").hide();
                    }
                });

                $("#months").on("change", function () {
                    if ($("input[name='report_type']:checked").val() === "monthly") {
                        $("#generate-btn").show();
                    }
                });

                $("#generate-btn").on("click", function () {
    let selectedReport = $("input[name='report_type']:checked").val();
    let selectedMonth = $("#months").val();

    if (selectedReport === "monthly") {
        window.location.href = `/reports/monthly/${selectedMonth}`;
    } else {
        window.location.href = `/reports/daily`;
    }
});

            });
        </script>
    </div>
    <div class="w-full h-screen flex flex-col">
        <div class="w-full bg-[#632c7d] flex justify-end items-center py-2">
            <a href="{{route('admin.logout')}}" class="text-white px-10">Logout</a>
        </div>
        <div class="w-full flex h-[1300px]  bg-[#F2EBFB]">

            @include('partials.header')
            
            <div class="w-full h-[1300px] overflow-auto p-10">
                <p class="mb-10">Dashboard</p>
                <div class="w-full flex items-center justify-end mb-5">
                    <button id="print" class="px-10 py-2 rounded-lg text-white bg-[#632c7d] text-xs font-medium">Print Report</button>
                </div>
                
                <script>
                    $(document).ready(function(){
                        $('#print').on('click', function(){
                            $('#overlay').show();
                            $('#print_div').show();
                        });
                    })
                </script>
                <div class="w-full flex items-center justify-between gap-5 mb-5">
                    <div onclick="window.location.href='{{route('admin.schedule.for_scheduling')}}'" class="w-1/4 bg-white p-5 rounded-lg shadow-lg hover:bg-[#d5c9e6] hover:cursor-pointer transition duration-200">
                        <p class="text-sm font-semibold">Walk-in clients</p>
                        <p class="text-4xl pt-5 text-center font-medium text-[#632c7d]">{{$walkin_count}}</p>
                    </div>
                    <div class="w-1/4 bg-white p-5 rounded-lg shadow-lg hover:bg-[#d5c9e6] hover:cursor-pointer transition duration-200">
                        <p class="text-sm font-semibold">IL'ed students</p>
                        <p class="text-4xl pt-5 text-center font-medium text-[rgb(99,44,125)]">{{$il_count}}</p>
                    </div>
                    <div onclick="window.location.href='{{route('admin.students')}}'" class="w-1/4 bg-white p-5 rounded-lg shadow-lg hover:bg-[#d5c9e6] hover:cursor-pointer transition duration-200">
                        <p class="text-sm font-semibold">Currently enrolled students</p>
                        <p class="text-4xl pt-5 text-center font-medium text-[#632c7d]">{{$enrolled_count}}</p>
                    </div>
                    <div class="w-1/4 bg-white p-5 rounded-lg shadow-lg hover:bg-[#d5c9e6] hover:cursor-pointer transition duration-200">
                        <p class="text-sm font-semibold">Total enrolled students</p>
                        <p class="text-4xl pt-5 text-center font-medium text-[#632c7d]">{{$enrolled_count}}</p>
                    </div>
                </div>

                <div class="w-full flex items-center justify-end">
                    <div class="w-full flex items-center justify-end gap-4">
                        <select name="year" id="yearSelect" class="px-10 py-2 rounded-lg border text-xs font-medium outline-none">
                            <option value="">Select Year</option>
                        </select>
                        <select name="month" id="monthSelect" class="px-10 py-2 rounded-lg border text-xs font-medium outline-none hidden">
                            <option value="">Select Month</option>
                        </select>
                    </div>
                    
                </div>

                <div class="w-full flex gap-5">
                    <div class="w-2/3 bg-white p-5 rounded-lg shadow-lg mt-5">
                        <p class="text-center mb-2">Course enrollees graph</p>
                        <canvas id="courseEnrollees" class="w-full h-1/2"></canvas>
                        <script>
                            $(document).ready(function () {
    let currentYear = new Date().getFullYear();
    let startYear = 2024;
    let months = [
        { value: 1, name: "January" }, { value: 2, name: "February" },
        { value: 3, name: "March" }, { value: 4, name: "April" },
        { value: 5, name: "May" }, { value: 6, name: "June" },
        { value: 7, name: "July" }, { value: 8, name: "August" },
        { value: 9, name: "September" }, { value: 10, name: "October" },
        { value: 11, name: "November" }, { value: 12, name: "December" }
    ];

    let yearSelect = $("#yearSelect");
    let monthSelect = $("#monthSelect").hide();
    let courseChart = null; // Store the chart instance

    // Populate the year dropdown
    for (let year = currentYear; year >= startYear; year--) {
        yearSelect.append(`<option value="${year}">${year}</option>`);
    }

    // Show month dropdown when a year is selected
    yearSelect.on("change", function () {
        let selectedYear = $(this).val();
        monthSelect.toggle(!!selectedYear).empty().append('<option value="">Select Month</option>');
        
        if (selectedYear) {
            months.forEach(month => {
                monthSelect.append(`<option value="${month.value}">${month.name}</option>`);
            });
        }
    });

    // Fetch course data when month is selected
    monthSelect.on("change", function () {
        let selectedYear = yearSelect.val();
        let selectedMonth = $(this).val();

        if (selectedYear && selectedMonth) {
            $.ajax({
                url: "/admin/students-per-course/fetch",
                type: "GET",
                data: { year: selectedYear, month: selectedMonth },
                success: function (data) {
                    console.log("Received Data Fetch:", data);

                    let labels = data.map(item => item.course);
                    let counts = data.map(item => item.count || 0);
                    let maxCount = Math.max(...counts) + 5;

                    // Define a color mapping for courses
                    let courseColors = {
                        "Graphic Design": "rgba(45, 212, 191, 0.6)",  // bg-teal-300
                        "Visual Programming": "rgba(253, 230, 138, 0.6)",  // bg-yellow-300
                        "Game Design": "rgba(251, 146, 60, 0.6)",  // bg-orange-300
                        "Python Start": "rgba(248, 113, 113, 0.6)",  // bg-red-300
                        "Python Pro": "rgba(239, 68, 68, 0.8)",  // bg-red-500
                        "Coding Knight": "rgba(134, 239, 172, 0.6)",  // bg-green-300
                        "Digital Literacy": "rgba(125, 211, 252, 0.6)",  // bg-sky-300
                        "Website Creation": "rgba(192, 132, 252, 0.6)",  // bg-purple-300
                        "Unity Game Development": "rgba(168, 85, 247, 0.8)",  // bg-purple-500
                        "Frontend Development": "rgba(96, 165, 250, 0.6)"  // bg-blue-300
                    };

                    // Assign colors based on course names or use a default color
                    let backgroundColors = labels.map(course => courseColors[course] || 'rgba(201, 203, 207, 0.6)'); // Default gray if not found

                    // Destroy previous chart instance if exists
                    if (courseChart !== null) {
                        courseChart.destroy();
                    }

                    let ctx = $("#courseEnrollees")[0].getContext("2d");
                    courseChart = new Chart(ctx, {
                        type: "bar",
                        data: {
                            labels: labels,
                            datasets: [{
                                label: "Course Enrollees",
                                data: counts,
                                backgroundColor: backgroundColors.slice(0, labels.length),
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    suggestedMax: maxCount,
                                    ticks: { stepSize: 1 }
                                }
                            }
                        }
                    });
                }
            });
        }
    });

    // Fetch initial data on page load
    $.ajax({
        url: "/admin/students-per-course",
        method: "GET",
        dataType: "json",
        success: function (data) {
            console.log("Received Data:", data);

            let labels = data.map(item => item.course);
            let counts = data.map(item => item.count || 0);
            let maxCount = Math.max(...counts) + 5;

            // Define a color mapping for courses
            let courseColors = {
                "Graphic Design": "rgba(45, 212, 191, 0.6)",  // bg-teal-300
                "Visual Programming": "rgba(253, 230, 138, 0.6)",  // bg-yellow-300
                "Game Design": "rgba(251, 146, 60, 0.6)",  // bg-orange-300
                "Python Start": "rgba(248, 113, 113, 0.6)",  // bg-red-300
                "Python Pro": "rgba(239, 68, 68, 0.8)",  // bg-red-500
                "Coding Knight": "rgba(134, 239, 172, 0.6)",  // bg-green-300
                "Digital Literacy": "rgba(125, 211, 252, 0.6)",  // bg-sky-300
                "Website Creation": "rgba(192, 132, 252, 0.6)",  // bg-purple-300
                "Unity Game Development": "rgba(168, 85, 247, 0.8)",  // bg-purple-500
                "Frontend Development": "rgba(96, 165, 250, 0.6)"  // bg-blue-300
            };

            // Assign colors based on course names or use a default color
            let backgroundColors = labels.map(course => courseColors[course] || 'rgba(201, 203, 207, 0.6)'); // Default gray if not found

            let ctx = $("#courseEnrollees")[0].getContext("2d");

            // Destroy existing chart before creating a new one
            if (courseChart !== null) {
                courseChart.destroy();
            }

            courseChart = new Chart(ctx, {
                type: "bar",
                data: {
                    labels: labels,
                    datasets: [{
                        label: "Course Enrollees",
                        data: counts,
                        backgroundColor: backgroundColors.slice(0, labels.length),
                        borderWidth: 1
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            display: false // This hides the legend
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            suggestedMax: maxCount,
                            ticks: { stepSize: 1 }
                        }
                    }
                }
            });
        },
        error: function (xhr, status, error) {
            console.error("Error fetching data:", error);
        }
    });
});

                        </script>
                    </div>
                    
                    <div class="w-1/3 bg-white p-5 rounded-lg shadow-lg mt-5">
                        <p class="text-center mb-2">Course inquiry rate</p>
                        <canvas id="courseInquiry" class="w-full"></canvas>
                        <script>
                            // Fetch course data from PHP
                            var courseCounts = <?php echo json_encode($courseCounts); ?>;
                        
                            // Extract labels (course names) and data (counts)
                            var labels = Object.keys(courseCounts);
                            var data = Object.values(courseCounts);

                            // Define a color mapping for courses
                            var courseColors = {
                                "Graphic Design": "rgba(45, 212, 191, 0.6)",  // bg-teal-300
                                "Visual Programming": "rgba(253, 230, 138, 0.6)",  // bg-yellow-300
                                "Game Design": "rgba(251, 146, 60, 0.6)",  // bg-orange-300
                                "Python Start": "rgba(248, 113, 113, 0.6)",  // bg-red-300
                                "Python Pro": "rgba(239, 68, 68, 0.8)",  // bg-red-500
                                "Coding Knight": "rgba(134, 239, 172, 0.6)",  // bg-green-300
                                "Digital Literacy": "rgba(125, 211, 252, 0.6)",  // bg-sky-300
                                "Website Creation": "rgba(192, 132, 252, 0.6)",  // bg-purple-300
                                "Unity Game Development": "rgba(168, 85, 247, 0.8)",  // bg-purple-500
                                "Frontend Development": "rgba(96, 165, 250, 0.6)"  // bg-blue-300
                            };
                        
                            // Assign colors based on course names or use a default color
                            var backgroundColors = labels.map(course => courseColors[course] || 'rgba(201, 203, 207, 0.6)'); // Default gray if not found
                        
                            var ctx1 = document.getElementById('courseInquiry').getContext('2d');
                            var myChart1 = new Chart(ctx1, {
                                type: 'doughnut',
                                data: {
                                    labels: labels, // Use dynamic course names
                                    datasets: [{
                                        label: 'Enrollees',
                                        data: data, // Use dynamic course counts
                                        backgroundColor: backgroundColors,
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    plugins: {
                                        legend: {
                                            position: 'bottom'
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
    <script>
</body>
</html>