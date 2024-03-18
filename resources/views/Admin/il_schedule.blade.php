<!doctype html>
<html>
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@200..800&family=Noto+Sans:ital,wght@0,100..900;1,100..900&family=Oswald:wght@200..700&display=swap" rel="stylesheet">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="{{ asset('js/scripts.js') }}"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
    <div id="il_sched" class="hidden w-1/4 bg-[#833ae0] rounded-lg absolute transform top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-sm z-10">
        <div class="w-full flex flex-col bg-[#f9f7fc]">
            <div class="w-full flex justify-between bg-[#833ae0] p-4 rounded-tl-xl rounded-tr-xl">
                <p class="text-white">Add new IL Schedule</p>
                <button onclick="closeProceedForm()" class="text-white flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="14" height="14" fill="#f9f9f9"><path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/></svg>
                </button>
            </div>
            <div class="w-full p-4">
                <form action="{{route('admin.add_il_schedule')}}" method="POST" class="w-full">
                    @csrf
                        <select name="course" class="mb-4 w-full text-center px-1 py-1 rounded-md border border-[#a9a9a9] focus:border-[#833ae0] outline-none">
                            <option selected disabled>-- Please select a course --</option>
                            @foreach ($courses as $course)
                                <option value="{{$course->course_name}}">{{$course->course_name}}</option>
                            @endforeach
                        </select>
                        <label for="" class="font-medium">Teacher</label>
                        <input type="text" name="teacher" class="mt-1 mb-4 w-full text-center px-1 py-1 rounded-md border border-[#a9a9a9] focus:border-[#833ae0] outline-none">
                        <div class="w-full flex justify-evenly gap-1 mb-4">
                            <div class="flex flex-col w-1/2">
                                <label for="" class="mb-1">Month</label>
                                <select name="mm" id="" class="w-full text-center px-1 py-1 rounded-md border border-[#a9a9a9] focus:border-[#833ae0] outline-none">
                                    <option value="January">January</option>
                                    <option value="February">February</option>
                                    <option value="March">March</option>
                                    <option value="April">April</option>
                                    <option value="May">May</option>
                                </select>
                            </div>
                            <div class="flex flex-col w-1/6">
                                <label for="" class="mb-1">Date</label>
                                <input type="number" name="dd" class="w-full text-center px-1 py-1 rounded-md border border-[#a9a9a9] focus:border-[#833ae0] outline-none">
                            </div>
                            <div class="flex flex-col w-1/3">
                                <label for="" class="mb-1">Day</label>
                                <select name="day" id="" class="w-full text-center px-1 py-1 rounded-md border border-[#a9a9a9] focus:border-[#833ae0] outline-none">
                                    <option value="Monday">Monday</option>
                                    <option value="Tuesday">Tuesday</option>
                                    <option value="Wednesday">Wednesday</option>
                                    <option value="Thursday">Thursday</option>
                                    <option value="Friday">Friday</option>
                                    <option value="Saturday">Saturday</option>
                                    <option value="Sunday">Sunday</option>
                                </select>
                            </div>
                        </div>
                        <div class="w-full flex gap-4 items-center justify-center mb-4">
                            <div class="w-1/2">
                                <label for="" class="">From</label>
                                <div class="w-full flex gap-2 items-center mt-1">
                                    <select name="from_a" id="" class="w-full text-center px-1 py-1 rounded-md border border-[#a9a9a9] focus:border-[#833ae0] outline-none">
                                        @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                    </select>
                                    <p class="font-bold">:</p>
                                    <select name="from_b" id="" class="w-full text-center px-1 py-1 rounded-md border border-[#a9a9a9] focus:border-[#833ae0] outline-none">
                                        <option value="00">00</option>
                                        <option value="01">01</option>
                                        <option value="02">02</option>
                                        <option value="03">03</option>
                                        <option value="04">04</option>
                                        <option value="05">05</option>
                                        <option value="06">06</option>
                                        <option value="07">07</option>
                                        <option value="08">08</option>
                                        <option value="09">09</option>
                                        @for ($i = 10; $i <= 60; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                    <select name="from_tm" id="">
                                        <option value="AM">AM</option>
                                        <option value="AM">PM</option>
                                    </select>
                                </div>
                            </div>
                            <div class="w-1/2">
                                <label for="" class="">To</label>
                                <div class="w-full flex gap-2 items-center mt-1">
                                    <select name="to_a" id="" class="w-full text-center px-1 py-1 rounded-md border border-[#a9a9a9] focus:border-[#833ae0] outline-none">
                                        @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                    </select>
                                    <p class="font-bold">:</p>
                                    <select name="to_b" id="" class="w-full text-center px-1 py-1 rounded-md border border-[#a9a9a9] focus:border-[#833ae0] outline-none">
                                        <option value="00">00</option>
                                        <option value="01">01</option>
                                        <option value="02">02</option>
                                        <option value="03">03</option>
                                        <option value="04">04</option>
                                        <option value="05">05</option>
                                        <option value="06">06</option>
                                        <option value="07">07</option>
                                        <option value="08">08</option>
                                        <option value="09">09</option>
                                        @for ($i = 10; $i <= 60; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                    <select name="to_tm" id="">
                                        <option value="AM">AM</option>
                                        <option value="AM">PM</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="w-full py-2 bg-[#833ae0] text-white rounded-md">Add</button>
                </form>
            </div>
        </div>
    </div>
    <div id="body" class="w-full h-screen flex flex-col z-0">
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
                    <a href="{{route('admin.dashboard')}}" class="text-[#48494b] px-5 w-full py-2">Dashboard</a>
                </div>
                <div>
                    <div onclick="courseDropdown()">
                        <div class="w-full flex items-center justify-around px-5 relative hover:bg-[#F2EBFB] ">
                            <p id="course_dd" href="" class="w-full py-2 text-[#48494b] hover:cursor-pointer">Courses</p>
                            <svg id="arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="12" height="12"><path d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z"/></svg>
                        </div>
                        <div id="courses" class="hidden">
                            <div class="w-full flex items-center px-10 relative hover:bg-[#F2EBFB] hover:cursor-pointer">
                                <a href="" class="py-2 text-[#48494b]">Overview</a>
                            </div>
                        </div>
                    </div>

                    <div onclick="studentsDropdown()">
                        <div class="w-full flex items-center justify-around px-5 relative hover:bg-[#F2EBFB] hover:cursor-pointer">
                            <p id="students_dd" class=" w-full py-2 text-[#48494b]">Students</p>
                            <svg id="arrow1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="12" height="12"><path d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z"/></svg>
                        </div>
                        <div id="students" class="hidden">
                            <div class="w-full flex items-center px-10 relative hover:bg-[#F2EBFB] hover:cursor-pointer">
                                <a href="" class="py-2 text-[#48494b]">Enrolled</a>
                            </div>
                        </div>
                    </div>

                    <div onclick="scheduleDropdown()">
                        <div class="w-full flex items-center justify-around px-5 relative py-2 bg-[#F2EBFB] border-l-4 rounded-sm border-[#833ae0] hover:cursor-pointer">
                            <p id="sched_dd" class=" w-full text-[#48494b]">Schedule</p>
                            <svg id="arrow2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="12" height="12"><path d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z"/></svg>
                        </div>
                        <div id="schedules" class="hidden mb-5">
                            <div class="w-full flex items-center px-10 relative hover:bg-[#F2EBFB] hover:cursor-pointer">
                                <a href="{{route('admin.schedule')}}" class="py-2 text-[#48494b] hover:cursor-pointer">Classes</a>
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
            <div class="w-full p-4">
                <div class="w-full mx-auto bg-[#f9f9f9] rounded-md p-4 text-sm">
                    <p class="text-lg font-semibold text-center mb-4">Introductory lesson schedules</p>
                    <div class="mb-5 w-full flex justify-between">
                        <form action="" method="GET">
                            @csrf
                            <select name="course" id="dropdown" class="px-1 py-1 rounded-md border border-[#a9a9a9] focus:border-[#833ae0] outline-none">
                                <option selected disabled>Please select a course</option>
                                @foreach ($courses as $course)
                                    <option value="{{$course->course_name}}">{{$course->course_name}}</option>
                                @endforeach
                            </select>
                        </form>
                        <button onclick="showAddIlSched()" class="flex items-center gap-2 bg-[#833ae0] rounded-sm px-4 py-1">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="14" height="14" fill="white"><path d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z"/></svg>
                            <p class="text-white">Add IL Schedule</p>
                        </button>
                    </div>
                    <div id="data-container">

                    </div>
                    <script>
                        $(document).ready(function(){
                            $('#dropdown').change(function(){
                                var selectedValue = $(this).val();
                    
                                $.ajax({
                                    url: "{{ route('admin.fetch_data') }}",
                                    type: "GET",
                                    data: {selectedValue: selectedValue},
                                    success: function(response){
                                        var dataContainer = $('#data-container');
                                        dataContainer.empty();
                                        $.each(response, function(index, item){
                                            var $scheduleCard = $('<a/>', {
                                            'id': 'schedule_card',
                                            'href': '/admin/open_il/' + item.code,
                                            }).append(
                                                $('<div/>', {
                                                    'class': 'w-full border border-[#a9a9a9] rounded-md p-4 mb-2',
                                                }).append(
                                                    $('<div/>', {
                                                        'class': 'w-full flex items-center gap-2 ',
                                                    }).append(
                                                        $('<div/>', {
                                                            'class': 'w-1/3',
                                                        }).append(
                                                            $('<div/>', {
                                                                'class': 'w-full flex items-center gap-2 mb-3',
                                                            }).append(
                                                                $('<p/>', {
                                                                    'class': 'font-semibold text-md',
                                                                    'text': 'Course:'
                                                                }),
                                                                $('<p/>', {
                                                                    'class': 'text-md',
                                                                    'text': item.course
                                                                })
                                                            ),
                                                            $('<div/>', {
                                                                'class': 'w-full flex items-center gap-2',
                                                            }).append(
                                                                $('<p/>', {
                                                                    'class': 'font-semibold text-md',
                                                                    'text': 'Teacher:'
                                                                }),
                                                                $('<p/>', {
                                                                    'class': 'text-md',
                                                                    'text': item.teacher
                                                                })
                                                            )
                                                        ),
                                                        $('<div/>', {
                                                            'class': 'w-1/3 flex font-semibold gap-2 items-center justify-center',
                                                        }).append(
                                                            $('<p/>', {
                                                                'class': 'text-md',
                                                                'text': item.mm
                                                            }),
                                                            $('<p/>', {
                                                                'class': 'text-md',
                                                                'text': item.dd
                                                            }),
                                                            $('<p/>', {
                                                                'text': '-'
                                                            }),
                                                            $('<p/>', {
                                                                'class': 'text-md',
                                                                'text': item.day
                                                            })
                                                        ),
                                                        $('<div/>', {
                                                            'class': 'w-1/3',
                                                        }).append(
                                                            $('<div/>', {
                                                                'class': 'w-full flex justify-end gap-2 mb-3',
                                                            }).append(
                                                                $('<p/>', {
                                                                    'class': 'font-semibold text-md',
                                                                    'text': 'Code:'
                                                                }),
                                                                $('<p/>', {
                                                                    'class': 'text-md',
                                                                    'text': item.code
                                                                })
                                                            ),
                                                            $('<div/>', {
                                                                'class': 'w-full flex justify-end gap-2',
                                                            }).append(
                                                                $('<p/>', {
                                                                    'class': 'font-semibold text-md',
                                                                    'text': 'Time:'
                                                                }),
                                                                $('<p/>', {
                                                                    'class': 'text-md',
                                                                    'text': item.from + ' - ' + item.to
                                                                })
                                                            )
                                                        )
                                                    )
                                                )
                                            );
                                        dataContainer.append($scheduleCard);
                                        });
                    
                                    },
                                    error: function(xhr){
                                        console.log(xhr.responseText);
                                    }
                                });
                            });
                        });
                    </script>
                    {{-- @foreach ($schedule as $sched)
                        <a id="schedule_card" href="{{route('admin.open_il', ['code' => $sched->code])}}">
                            <div class="w-full border border-[#a9a9a9] rounded-lg p-4 mb-2">
                                <div class="w-full flex items-center gap-2 ">
                                    <div class="w-1/3">
                                        <div class="w-full flex items-center gap-2 mb-3">
                                            <p class="font-semibold text-md">Course:</p>
                                            <p class="text-md">{{ $sched->course }}</p>
                                        </div>
                                        <div class="w-full flex items-center gap-2">
                                            <p class="font-semibold text-md">Teacher:</p>
                                            <p class="text-md">{{ $sched->teacher }}</p>
                                        </div>
                                    </div>
                                    <div class="w-1/3 flex font-semibold gap-2 items-center justify-center">
                                        <p class="text-md">{{ $sched->mm }}</p>
                                        <p class="text-md">{{ $sched->dd }}</p>
                                        <p>-</p>
                                        <p class="text-md">{{ $sched->day }}</p>
                                    </div>
                                    <div class="w-1/3">
                                        <div class="w-full flex justify-end gap-2 mb-3">
                                            <p class="font-semibold text-md">Code:</p>
                                            <p class="text-md">{{$sched->code}}</p>
                                        </div>
                                        <div class="w-full flex justify-end gap-2">
                                            <p class="font-semibold text-md">Time:</p>
                                            <p class="text-md">{{ $sched->time_slot }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach --}}
                    
                </div>
            </div>
        </div>
    </div>
</body>
</html>