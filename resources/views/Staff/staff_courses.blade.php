<!doctype html>
<html>
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="{{ asset('js/scripts.js') }}"></script>
  <title>Courses | AlgoHub</title>
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
<body class="bg-[#ececec]">
    <div class="w-full h-screen flex flex-col">
        <div class="w-full bg-[#632c7d] flex justify-end items-center py-2">
            <a href="{{route('admin.logout')}}" class="text-white px-10">Logout</a>
        </div>
        <div class="w-full flex h-screen bg-[#F2EBFB]">
            
            @include('partials.header')
            
            <div class="w-full p-7">
                <p class="text-2xl font-medium">Courses</p>
                <div class="w-full flex flex-wrap gap-5 mt-5">
                    @foreach($courses as $course)
                        <div onclick="window.location.href='{{route('admin.course_details', ['course' => $course->course])}}'" class="w-[49%] rounded-md shadow-lg bg-white py-10">
                            <p class="text-center font-semibold">{{ $course->course }}</p>
                        </div>
                    @endforeach
                    {{-- <div class="w-1/2 flex flex-col gap-5">
                        <div class="w-full">
                            <div onclick="window.location.href='{{route('admin.coding_knight')}}'" class="w-full rounded-md shadow-lg bg-white py-10">
                                <p class="text-center font-semibold">The Coding Knight</p>
                            </div>
                        </div>
                        <div class="w-full">
                            <div onclick="window.location.href='{{route('admin.visual_programming')}}'" class="w-full rounded-md shadow-lg bg-white py-10">
                                <p class="text-center font-semibold">Digital Literacy</p>
                            </div>
                        </div>
                        <div class="w-full">
                            <div onclick="window.location.href='{{route('admin.visual_programming')}}'" class="w-full rounded-md shadow-lg bg-white py-10">
                                <p class="text-center font-semibold">Visual Programming</p>
                            </div>
                        </div>
                        <div class="w-full">
                            <div onclick="window.location.href='{{route('admin.game_design')}}'" class="w-full rounded-md shadow-lg bg-white py-10">
                                <p class="text-center font-semibold">Game Design</p>
                            </div>
                        </div>
                        <div class="w-full">
                            <div onclick="window.location.href='{{route('admin.game_design')}}'" class="w-full rounded-md shadow-lg bg-white py-10">
                                <p class="text-center font-semibold">Graphic Design</p>
                            </div>
                        </div>
                        <div class="w-full">
                            <div onclick="window.location.href='{{route('admin.game_design')}}'" class="w-full rounded-md shadow-lg bg-white py-10">
                                <p class="text-center font-semibold">Unity Game Development</p>
                            </div>
                        </div>
                    </div>
                    <div class="w-1/2 flex flex-col gap-5">
                        <div class="w-full">
                            <div onclick="window.location.href='{{route('admin.building_websites')}}'" class="w-full rounded-md shadow-lg bg-white py-10">
                                <p class="text-center font-semibold">Building Websites</p>
                            </div>
                        </div>
                        <div class="w-full">
                            <div onclick="window.location.href='{{route('admin.python_start1')}}'" class="w-full rounded-md shadow-lg bg-white py-10">
                                <p class="text-center font-semibold">Python Start (Year 1)</p>
                            </div>
                        </div>
                        <div class="w-full">
                            <div onclick="window.location.href='{{route('admin.python_start2')}}'" class="w-full rounded-md shadow-lg bg-white py-10">
                                <p class="text-center font-semibold">Python Start (Year 2)</p>
                            </div>
                        </div>
                        <div class="w-full">
                            <div onclick="window.location.href='{{route('admin.python_pro1')}}'" class="w-full rounded-md shadow-lg bg-white py-10">
                                <p class="text-center font-semibold">Python Pro (Year 1)</p>
                            </div>
                        </div>
                        <div class="w-full">
                            <div onclick="window.location.href='{{route('admin.python_pro2')}}'" class="w-full rounded-md shadow-lg bg-white py-10">
                                <p class="text-center font-semibold">Python Pro (Year 2)</p>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</body>
</html>