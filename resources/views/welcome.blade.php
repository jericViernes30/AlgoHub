<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <!-- Add jQuery from a CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Teacher's Login | AlgoHub</title>
  <link rel="shortcut icon" href="{{asset('images/algo-logo.png')}}" type="image/x-icon">
  @vite('resources/css/app.css')
</head>
<body class="bg-[#ececec] grid place-items-center min-h-screen relative">
    <p class="text-xs text-gray-500 mb-4 absolute bottom-5 left-1/2 transform -translate-x-1/2">© 2024 Algorithmics International School of Programming. All Rights Reserved.</p>

    <div class="w-3/4 h-3/4 flex shadow-2xl rounded-3xl ">
        <div class="w-3/12 rounded-tl-3xl rounded-bl-3xl flex-col items-center p-5 bg-white relative">
            <img src="https://lms.alg.academy/auth/v3/img/logo.d1092e37.svg" alt="Algohub Logo" class="w-36 h-auto-left-1 -top-7">
            <form id="loginForm" class="w-full absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 px-5">
                @csrf
                <p class="text-2xl font-bold mb-2">Login for teachers</p>
                <label for="Login">Login</label>
                <input type="text" name="username" class="border border-slate-300 mt-1 mb-3 w-full rounded-lg py-1 px-2 outline-none focus:border-[#632c7d]">
                
                <label for="Login">Password</label>
                <input type="password" name="password" class="border border-slate-300 mt-1 mb-3 w-full rounded-lg py-1 px-2 outline-none focus:border-[#632c7d]">
                <a href="{{route('password.reset')}}" class="text-sm underline text-[#632c7d]">Forgot password?</a>
                <button class="bg-[#632c7d] border border-slate-300 mt-2 w-full rounded-lg py-1 px-2 text-white">Login</button>
                <a class="inline-block text-center w-full text-[#632c7d]" href="{{route('admin.login')}}">Login as admin</a>
            </form>
        </div>
        <div class="w-3/4 rounded-tr-3xl rounded-br-3xl bg-[#632c7d] flex items-center justify-center">
            <img src="{{asset('images/hero2.png')}}" alt="Algohub Hero" class="w-2/4 h-auto">
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $("#loginForm").submit(function (e) {
                e.preventDefault();

                $.ajax({
                    url: "{{route('teacher.login.post')}}",
                    type: "POST",
                    data: $(this).serialize(),
                    dataType: "json",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                    },
                    success: function (response) {
                        if (response.message === "Login successful") {
                            sessionStorage.setItem("teacher_logged_in", "true");
                            window.location.href = response.redirect;
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function (xhr) {
                        let errorMessage = xhr.responseJSON?.message || "An error occurred. Please try again.";

                        // Optional: Reset sessionStorage if login was blocked
                        if (xhr.status === 403) {
                            sessionStorage.removeItem("teacher_logged_in");
                        }

                        alert(errorMessage);
                    }
                });
            });
        });



    </script>
</body>
</html>