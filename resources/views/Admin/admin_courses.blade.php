<!doctype html>
<html>
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@200..800&family=Noto+Sans:ital,wght@0,100..900;1,100..900&family=Oswald:wght@200..700&display=swap" rel="stylesheet">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                <input type="search" name="search" placeholder="Search" class="px-2 py-1 rounded-xl w-1/3">
                <div class="flex items-center justify-center">
                    <button class="rounded-xl px-2 py-1 bg-[#F2EBFB] flex gap-1 items-center justify-center">
                        <p>Hi, Jeric James!</p>
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
                    <a href="" class="text-[#48494b] px-5 bg-[#F2EBFB] border-l-4 rounded-sm border-[#833ae0] w-full py-2">Dashboard</a>
                </div>
                <div>
                    <div onclick="courseDropdown()">
                        <div class="w-full flex items-center justify-around px-5 relative hover:bg-[#F2EBFB] hover:cursor-pointer">
                            <p href="" class=" w-full py-2">Courses</p>
                        </div>
                    </div>

                    <div onclick="studentsDropdown()">
                        <div class="w-full flex items-center justify-around px-5 relative hover:bg-[#F2EBFB] hover:cursor-pointer">
                            <p href="" class=" w-full py-2">Students</p>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="12" height="12"><path d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z"/></svg>
                        </div>
                        <div id="students" class="hidden">
                            <div class="w-full flex items-center px-10 relative hover:bg-[#F2EBFB] hover:cursor-pointer">
                                <a href="" class="py-2">Enrolled</a>
                            </div>
                        </div>
                    </div>

                    <div onclick="scheduleDropdown()">
                        <div class="w-full flex items-center justify-around px-5 relative hover:bg-[#F2EBFB] hover:cursor-pointer">
                            <p href="" class=" w-full py-2">Schedule</p>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="12" height="12"><path d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z"/></svg>
                        </div>
                        <div id="schedules" class="hidden mb-5">
                            <div class="w-full flex items-center px-10 relative hover:bg-[#F2EBFB] hover:cursor-pointer">
                                <a href="{{route('admin.schedule')}}" class="py-2">Classes</a>
                            </div>
                            <div class="w-full flex items-center px-10 relative hover:bg-[#F2EBFB] hover:cursor-pointer">
                                <a href="{{route('admin.schedule')}}" class="py-2">Intro Lessons</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-full p-7">
                <p class="text-2xl font-medium">Courses</p>
                <div class="w-full flex gap-5 mt-5">
                    <div class="w-1/2 flex flex-col gap-5">
                        <div class="w-full">
                            <div onclick="window.location.href='course/The-Coding-Knight'" class="w-full rounded-md shadow-lg bg-white py-10">
                                <p class="text-center font-semibold">The Coding Knight</p>
                            </div>
                        </div>
                        <div class="w-full">
                            <div onclick="alert('Clicked!')" class="w-full rounded-md shadow-lg bg-white py-10">
                                <p class="text-center font-semibold">Digital Literacy</p>
                            </div>
                        </div>
                        <div class="w-full">
                            <div onclick="alert('Clicked!')" class="w-full rounded-md shadow-lg bg-white py-10">
                                <p class="text-center font-semibold">Visual Programming</p>
                            </div>
                        </div>
                        <div class="w-full">
                            <div onclick="alert('Clicked!')" class="w-full rounded-md shadow-lg bg-white py-10">
                                <p class="text-center font-semibold">Game Design</p>
                            </div>
                        </div>
                    </div>
                    <div class="w-1/2 flex flex-col gap-5">
                        <div class="w-full">
                            <div onclick="alert('Clicked!')" class="w-full rounded-md shadow-lg bg-white py-10">
                                <p class="text-center font-semibold">Building Websites</p>
                            </div>
                        </div>
                        <div class="w-full">
                            <div onclick="alert('Clicked!')" class="w-full rounded-md shadow-lg bg-white py-10">
                                <p class="text-center font-semibold">Python Start (Year 1)</p>
                            </div>
                        </div>
                        <div class="w-full">
                            <div onclick="alert('Clicked!')" class="w-full rounded-md shadow-lg bg-white py-10">
                                <p class="text-center font-semibold">Python Start (Year 2)</p>
                            </div>
                        </div>
                        <div class="w-full">
                            <div onclick="alert('Clicked!')" class="w-full rounded-md shadow-lg bg-white py-10">
                                <p class="text-center font-semibold">Python Pro (Year 1)</p>
                            </div>
                        </div>
                        <div class="w-full">
                            <div onclick="alert('Clicked!')" class="w-full rounded-md shadow-lg bg-white py-10">
                                <p class="text-center font-semibold">Python Pro (Year 1)</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>