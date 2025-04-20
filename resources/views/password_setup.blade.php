<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <title>Teacher's Login | AlgoHub</title>
  <link rel="shortcut icon" href="{{asset('images/algo-logo.png')}}" type="image/x-icon">
  @vite('resources/css/app.css')
  <style>
    .loader {
  width: 40px;
  height: 40px;
  border: 3px solid #929292;
  border-radius: 50%;
  display: inline-block;
  position: relative;
  box-sizing: border-box;
  animation: rotation 1s linear infinite;
}
.loader::after {
    content: '';  
  box-sizing: border-box;
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    width: 32px;
    height: 32px;
    border-radius: 50%;
    border: 3px solid transparent;
    border-bottom-color: #632c7d;
}
    
@keyframes rotation {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
} 
  </style>
</head>
<body class="bg-[#ececec] grid place-items-center min-h-screen relative">
    <p class="text-xs text-gray-500 mb-4 absolute bottom-5 left-1/2 transform -translate-x-1/2">© 2024 Algorithmics International School of Programming. All Rights Reserved.</p>

    <div class="w-3/4 h-3/4 flex shadow-2xl rounded-3xl ">
        <div class="w-3/12 rounded-tl-3xl rounded-bl-3xl flex-col items-center p-5 bg-white relative">
            <img src="https://lms.alg.academy/auth/v3/img/logo.d1092e37.svg" alt="Algohub Logo" class="w-36 h-auto-left-1 -top-7">
            <form action="{{route('password.set')}}" method="POST">
                @csrf
                <div class="w-full absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 px-5">
                    <p class="text-2xl font-bold mb-2">Password set up</p>
                    @if ($errors->any())
    <div class="bg-red-500 text-white p-2 rounded mb-4">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

                    <label for="Login" class="text-gray-600 text-sm">Username</label>
                    <input id="username" type="text" name="username" class="border-2 border-[#632c7d] w-full rounded-lg py-1 px-2 outline-none focus:border-[#632c7d] mb-3 font-medium" value="{{$username}}" readonly>
                    <label for="Login" class="text-gray-600 text-sm">Password</label>
                    <input id="password" type="text" name="password" class="border border-slate-300 mt-1 w-full rounded-lg py-1 px-2 outline-none focus:border-[#632c7d]">
                    <input type="hidden" name="email_address" value="{{$email}}">
                    <button id="continue-btn" class="bg-[#632c7d] border border-slate-300 mt-2 w-full rounded-lg py-1 px-2 text-white">Submit</button>
                </div>
            </form>
            
        </div>
        <div class="w-3/4 rounded-tr-3xl rounded-br-3xl bg-[#632c7d] flex items-center justify-center">
            <img src="{{asset('images/hero2.png')}}" alt="Algohub Hero" class="w-2/4 h-auto">
        </div>
    </div>
</body>
</html>