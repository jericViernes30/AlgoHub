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
                <p class="text-2xl font-medium">Course Details - The Coding Knight</p>
                <div class="w-full h-[550px] overflow-auto mt-5">
                    {{-- module 1 --}}
                    <p class="w-full px-6 text-sm py-4 bg-[#e7e7e7] text-[#888] uppercase rounded-tl-md rounded-tr-md">Module 1: Linear Algorithms</p>
                    <p class="w-full px-6 text-sm py-4 bg-white border-b-2 border-[#e7e7e7]">Lesson 1. Executor and Algorithms ENG</p>
                    <p class="w-full px-6 text-sm py-4 bg-white border-b-2 border-[#e7e7e7]">Lesson 2. Programs and memory blocks ENG</p>
                    <p class="w-full px-6 text-sm py-4 bg-white border-b-2 border-[#e7e7e7]">Lesson 3. Learning to read and execute programs ENG</p>
                    <p class="w-full px-6 text-sm py-4 bg-white border-b-2 border-[#e7e7e7]">Lesson 4. Composing linear algorithms ENG</p>
                    <p class="w-full px-6 text-sm py-4 bg-white border-b-2 border-[#e7e7e7]">Lesson 5. Composing linear algorithms ENG</p>
                    {{-- module 2 --}}
                    <p class="w-full px-6 text-sm py-4 bg-[#e7e7e7] text-[#888] uppercase">MODULE 2. Loops</p>
                    <p class="w-full px-6 text-sm py-4 bg-white border-b-2 border-[#e7e7e7]">Lesson 6. Getting acquainted with loops ENG</p>
                    <p class="w-full px-6 text-sm py-4 bg-white border-b-2 border-[#e7e7e7]">Lesson 7. Composing looped algorithms ENG</p>
                    <p class="w-full px-6 text-sm py-4 bg-white border-b-2 border-[#e7e7e7]">Lesson 8. Composing looped algorithms ENG</p>
                    {{-- module 3 --}}
                    <p class="w-full px-6 text-sm py-4 bg-[#e7e7e7] text-[#888] uppercase">MODULE 3. Getting aquaired with scratch jr</p>
                    <p class="w-full px-6 text-sm py-4 bg-white border-b-2 border-[#e7e7e7]">Lesson 9. Introduction to the Scratch Jr environment ENG</p>
                    <p class="w-full px-6 text-sm py-4 bg-white border-b-2 border-[#e7e7e7]">Lesson 10. Scratch Jr. Events ("When the sprite is pressed down") and commands in the "Movement" section ENG</p>
                    <p class="w-full px-6 text-sm py-4 bg-white border-b-2 border-[#e7e7e7]">Lesson 11. Commands of the "Appearance" section ENG</p>
                    <p class="w-full px-6 text-sm py-4 bg-white border-b-2 border-[#e7e7e7]">Lesson 12. Loops. Review. Interactive project ENG</p>
                    {{-- module 4 --}}
                    <p class="w-full px-6 text-sm py-4 bg-[#e7e7e7] text-[#888] uppercase">MODULE 4. Events. Animation</p>
                    <p class="w-full px-6 text-sm py-4 bg-white border-b-2 border-[#e7e7e7]">Lesson 13. Events. Programming of parallel (simultaneous) actions when running a project. ENG</p>
                    <p class="w-full px-6 text-sm py-4 bg-white border-b-2 border-[#e7e7e7]">Lesson 14. Programming automatic changes in scenes when running a project. ENG</p>
                    <p class="w-full px-6 text-sm py-4 bg-white border-b-2 border-[#e7e7e7]">Lesson 15. Creating animation (beginning). The appearance of characters at the start. Recording and using sounds in Scratch. ENG</p>
                    <p class="w-full px-6 text-sm py-4 bg-white border-b-2 border-[#e7e7e7]">Lesson 16. Creating animation (finalizing), demonstration of projects, reviewing the module topics. ENG</p>
                    {{-- module 5 --}}
                    <p class="w-full px-6 text-sm py-4 bg-[#e7e7e7] text-[#888] uppercase">MODULE 5. Messages</p>
                    <p class="w-full px-6 text-sm py-4 bg-white border-b-2 border-[#e7e7e7]">Lesson 17. Messages. ENG</p>
                    <p class="w-full px-6 text-sm py-4 bg-white border-b-2 border-[#e7e7e7]">Lesson 18. Using messages in a game. ENG</p>
                    <p class="w-full px-6 text-sm py-4 bg-white border-b-2 border-[#e7e7e7]">Lesson 19. Programming buttons using messages. ENG</p>
                    <p class="w-full px-6 text-sm py-4 bg-white border-b-2 border-[#e7e7e7]">Lesson 20. Programming buttons to control the character. ENG</p>

                    {{-- module 6 --}}
                    <p class="w-full px-6 text-sm py-4 bg-[#e7e7e7] text-[#888] uppercase">MODULE 6. Condition (Touch) as an Event</p>
                    <p class="w-full px-6 text-sm py-4 bg-white border-b-2 border-[#e7e7e7]">Lesson 21. Touching conditions. ENG</p>
                    <p class="w-full px-6 text-sm py-4 bg-white border-b-2 border-[#e7e7e7]">Lesson 22. Sending a message when touching ENG</p>
                    <p class="w-full px-6 text-sm py-4 bg-white border-b-2 border-[#e7e7e7]">Lesson 23. Creating a game with animation. Start ENG</p>
                    <p class="w-full px-6 text-sm py-4 bg-white border-b-2 border-[#e7e7e7]">Lesson 24. Creating a game with animation. Finalizing ENG</p>

                    {{-- module 7 --}}
                    <p class="w-full px-6 text-sm py-4 bg-[#e7e7e7] text-[#888] uppercase">MODULE 7. Implementation of Game Mechanics in a Group Choice Project</p>
                    <p class="w-full px-6 text-sm py-4 bg-white border-b-2 border-[#e7e7e7]">Lesson 25. Selection and start of implementing a large group project. ENG</p>
                    <p class="w-full px-6 text-sm py-4 bg-white border-b-2 border-[#e7e7e7]">Lesson 26. Continuing the implementation of the group's large project. ENG</p>
                    <p class="w-full px-6 text-sm py-4 bg-white border-b-2 border-[#e7e7e7]">Lesson 27. Continuing the implementation of the group's project ENG</p>
                    <p class="w-full px-6 text-sm py-4 bg-white border-b-2 border-[#e7e7e7]">Lesson 28. Projects presentation ENG</p>

                    {{-- module 8 --}}
                    <p class="w-full px-6 text-sm py-4 bg-[#e7e7e7] text-[#888] uppercase">Module 8. Selection and Implementation of the Final Project</p>
                    <p class="w-full px-6 text-sm py-4 bg-white border-b-2 border-[#e7e7e7]">Lesson 29. Selection and start of work on the final individual project of the course. ENG</p>
                    <p class="w-full px-6 text-sm py-4 bg-white border-b-2 border-[#e7e7e7]">Lesson 30. Creating the students' individual projects according to their choice ENG</p>
                    <p class="w-full px-6 text-sm py-4 bg-white border-b-2 border-[#e7e7e7]">Lesson 31. Creating the students' individual projects according to their choice ENG</p>
                    <p class="w-full px-6 text-sm py-4 bg-white border-b-2 border-[#e7e7e7]">Lesson 32. Presentation of final projects. Awarding ENG</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>