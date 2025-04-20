<div class="w-1/6 h-full bg-[#f9f9f9] text-sm">
    <div class="w-full mb-8 mt-10">
        <img src="https://lms.alg.academy/auth/v3/img/logo.d1092e37.svg" alt="Lesson Logo" class="w-3/4 block mx-auto">
    </div>

    <div class="w-full mx-auto flex gap-5 items-center">
        <a href="{{ route('staff.dashboard') }}"
           class="text-[#48494b] px-5 w-full py-2 
                  {{ request()->routeIs('staff.dashboard') ? 'bg-[#F2EBFB] border-l-4 border-[#632c7d] rounded-sm' : 'hover:bg-[#F2EBFB]' }}">
            Dashboard
        </a>
    </div>

    <div>
        <div onclick="courseDropdown()">
            <a href="{{ route('staff.courses') }}"
               class="w-full flex items-center justify-around px-5 relative 
                      {{ request()->routeIs('staff.courses') ? 'bg-[#F2EBFB] border-l-4 border-[#632c7d] rounded-sm' : 'hover:bg-[#F2EBFB]' }}">
                <p id="course_dd" class="w-full py-2 text-[#48494b] hover:cursor-pointer">Courses</p>
            </a>
        </div>

        <div onclick="studentsDropdown()">
            <div class="w-full flex items-center justify-around px-5 relative py-2 hover:cursor-pointer">
                <p id="students_dd" class="w-full text-[#48494b]">Students</p>
                <svg id="arrow2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="12" height="12">
                    <path d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z"/>
                </svg>
            </div>
            <div id="students" class="{{ request()->routeIs('staff.students') ? '' : 'hidden' }}">
                <div class="w-full flex items-center px-10 relative 
                            {{ request()->routeIs('staff.students') ? 'bg-[#F2EBFB] border-l-4 border-[#632c7d] rounded-sm' : 'hover:bg-[#F2EBFB]' }}">
                    <a href="{{ route('staff.students') }}" class="py-2 text-[#48494b] hover:cursor-pointer">Enrolled Students</a>
                </div>
            </div>
        </div>

        <div onclick="scheduleDropdown()">
            <div class="w-full flex items-center justify-around px-5 relative py-2 hover:cursor-pointer 
                        {{ request()->routeIs('staff.schedule', 'staff.il_schedule', 'staff.walk_in') ? 'bg-[#F2EBFB] border-l-4 border-[#632c7d] rounded-sm' : '' }}">
                <p id="sched_dd" class="w-full text-[#48494b]">Schedule</p>
                <svg id="arrow2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="12" height="12">
                    <path d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z"/>
                </svg>
            </div>
            <div id="schedules" class="{{ request()->routeIs('staff.schedule', 'staff.il_schedule', 'staff.walk_in') ? '' : 'hidden' }} mb-5">
                <div class="w-full flex items-center px-10 relative 
                            {{ request()->routeIs('staff.schedule') ? 'bg-[#F2EBFB] border-l-4 border-[#632c7d] rounded-sm' : 'hover:bg-[#F2EBFB]' }}">
                    <a href="{{ route('staff.schedule') }}" class="py-2 text-[#48494b] hover:cursor-pointer">Classes</a>
                </div>
                <div class="w-full flex items-center px-10 relative 
                            {{ request()->routeIs('staff.il_schedule') ? 'bg-[#F2EBFB] border-l-4 border-[#632c7d] rounded-sm' : 'hover:bg-[#F2EBFB]' }}">
                    <a href="{{ route('staff.il_schedule') }}" class="py-2 text-[#48494b] hover:cursor-pointer">Introductory Lessons</a>
                </div>
            </div>
        </div>
    </div>
</div>
