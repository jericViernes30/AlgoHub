<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login | AlgoHub</title>
  <link rel="shortcut icon" href="{{asset('images/algo-logo.png')}}" type="image/x-icon">
  @vite('resources/css/app.css')
</head>
<body class="bg-[#ececec] grid place-items-center min-h-screen">
    <div class="w-3/4 h-3/4 flex shadow-2xl rounded-3xl ">
        <div class="w-3/12 rounded-tl-3xl rounded-bl-3xl flex-col items-center p-5 relative bg-white">
            <img src="https://lms.alg.academy/auth/v3/img/logo.d1092e37.svg" alt="Algohub Logo" class="w-36 h-auto-left-1 -top-7">
            <form action="{{route('admin.login.post')}}" method="POST" class="w-full absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 px-5">
                @csrf
                <p class="text-2xl font-bold mb-2">Login for admin</p>
                <label for="Login">Admin</label>
                <input type="text" name="username" class="border border-slate-300 mt-1 mb-3 w-full rounded-lg py-1 px-2 outline-none focus:border-[#632c7d]">
                
                <label for="Login">Password</label>
                <input type="password" name="password" class="border border-slate-300 mt-1 mb-3 w-full rounded-lg py-1 px-2 outline-none focus:border-[#632c7d]">
                <button class="bg-[#632c7d] border border-slate-300 mt-2 w-full rounded-lg py-1 px-2 text-white">Login</button>
                <a class="text-[#632c7d] text-center w-full inline-block" href="{{route('welcome')}}">Sign in as teacher</a>
            </form>
        </div>
        <div class="w-3/4 rounded-tr-3xl rounded-br-3xl bg-[#632c7d] flex items-center justify-center">
            <img src="{{asset('images/hero2.png')}}" alt="Algohub Hero" class="w-2/4 h-auto">
        </div>
    </div>
</body>
</html>