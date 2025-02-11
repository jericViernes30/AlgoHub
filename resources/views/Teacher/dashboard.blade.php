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
                <input type="search" name="search" placeholder="Search" class="px-2 py-1 rounded-md w-1/3">
                <div class="flex gap-4 items-center justify-center">
                    <button class="rounded-md px-2 py-1 bg-[#F2EBFB] flex gap-1 items-center justify-center">
                        <p>Hi, {{$teacher->first_name}}!</p>
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="12" height="12"><path d="M201.4 342.6c12.5 12.5 32.8 12.5 45.3 0l160-160c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L224 274.7 86.6 137.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l160 160z"/></svg>
                        </span>
                    </button>
                    <svg onclick="window.location.href='/teacher/logout'" class="hover:cursor-pointer" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="25" height="25" fill="#fff"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M502.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-128-128c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L402.7 224 192 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l210.7 0-73.4 73.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l128-128zM160 96c17.7 0 32-14.3 32-32s-14.3-32-32-32L96 32C43 32 0 75 0 128L0 384c0 53 43 96 96 96l64 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-64 0c-17.7 0-32-14.3-32-32l0-256c0-17.7 14.3-32 32-32l64 0z"/></svg>
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
                            <p href="" class=" w-full py-2">My Classes</p>
                            {{-- <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="12" height="12"><path d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z"/></svg> --}}
                        </div>
                        <div id="courses" class="hidden">
                            <div class="w-full flex items-center px-10 relative hover:bg-[#F2EBFB] hover:cursor-pointer">
                                <a href="" class="py-2">Overview</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-full p-4">
                <p class="text-lg font-light mb-2">Schedule</p>
                <div class="w-full bg-white rounded-lg p-4">
                    <div class="mb-4">
                        <p class="text-xs">Showing items <span class="text-blue-900 font-bold">1 - 3 </span> of <span class="text-blue-900 font-bold">3</span></p>
                    </div>
                    <div class="w-full flex items-center text-sm mb-2 py-2 font-semibold text-blue-950">
                        <p class="w-[12%]">Schedule</p>
                        <p class="w-[8%]">Lesson #</p>
                        <p class="w-[33%]">Next Lesson</p>
                        <p class="w-[7%]">Day</p>
                        <p class="w-[20%]">Lesson Teacher</p>
                        <p class="w-[20%]">Type</p>
                    </div>
                    <hr>
                    <div class="w-full flex items-center text-sm mt-4 mb-2 py-2">
                        <p class="w-[12%]">25.11.2024 17:00</p>
                        <p class="w-[8%]">1</p>
                        <div class="w-[33%]">
                            <p>M1 L1 Roblox.com vs Roblox Studio</p>
                            <p class="text-xs">Game Design 2021/2022 M1 L1</p>
                        </div>
                        <p class="w-[7%]">Mon</p>
                        <p class="w-[20%]">TICAR MA ALMIRA</p>
                        <p class="w-fit bg-green-400 px-2 py-1 rounded-sm text-xs font-semibold">Regular</p>
                    </div>
                    <hr>
                    <div class="w-full flex items-center text-sm mt-4 mb-2 py-2">
                        <p class="w-[12%]">27.11.2024 14:00</p>
                        <p class="w-[8%]">1</p>
                        <div class="w-[33%]">
                            <p>Game Design IL</p>
                            <p class="text-xs">IL_Game Design_ENG</p>
                        </div>
                        <p class="w-[7%]">Wed</p>
                        <p class="w-[20%]">TICAR MA ALMIRA</p>
                        <p class="w-fit bg-blue-400 px-2 py-1 rounded-sm text-xs font-semibold">Introductory Lesson</p>
                    </div>
                    <hr>
                    <div class="w-full flex items-center text-sm mt-4 mb-2 py-2">
                        <p class="w-[12%]">29.11.2024 17:00</p>
                        <p class="w-[8%]">3</p>
                        <div class="w-[33%]">
                            <p>M1 L3 My first real 3D game ENG</p>
                            <p class="text-xs">Game Design 2021/2022 M1 L3</p>
                        </div>
                        <p class="w-[7%]">Fri</p>
                        <p class="w-[20%]">TICAR MA ALMIRA</p>
                        <p class="w-fit bg-green-400 px-2 py-1 rounded-sm text-xs font-semibold">Regular</p>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</body>
</html>