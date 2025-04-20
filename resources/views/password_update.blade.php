<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Teacher's Login | AlgoHub</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="shortcut icon" href="{{asset('images/algo-logo.png')}}" type="image/x-icon">
  @vite('resources/css/app.css')
</head>
<body class="bg-[#ececec] grid place-items-center min-h-screen relative">
    <p class="text-xs text-gray-500 mb-4 absolute bottom-5 left-1/2 transform -translate-x-1/2">© 2024 Algorithmics International School of Programming. All Rights Reserved.</p>

    <div class="w-3/4 h-3/4 flex shadow-2xl rounded-3xl ">
        <div class="w-3/12 rounded-tl-3xl rounded-bl-3xl flex-col items-center p-5 bg-white relative">
            <img src="https://lms.alg.academy/auth/v3/img/logo.d1092e37.svg" alt="Algohub Logo" class="w-36 h-auto-left-1 -top-7">
            <form action="{{route('password.update')}}" method="POST" class="w-full absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 px-5">
                @csrf
                <p class="text-2xl font-bold mb-2">Reset your password</p>
                <label for="Login">New password</label>
                <input id="password" type="text" name="password" class="border border-slate-300 mt-1 w-full rounded-lg py-1 px-2 outline-none focus:border-[#632c7d]">
                <span id="error" class="text-red-500 text-xs"></span>
                <div class="mt-3">
                    <label for="Login" class="">Repeat password</label>
                <input id="repeat_password" type="password" name="repeat_password" class="border border-slate-300 mt-1 mb-3 w-full rounded-lg py-1 px-2 outline-none focus:border-[#632c7d]">
                </div>
                
                <input type="hidden" name="email" value="{{$email}}">
                <button id="submit-btn" class="bg-gray-500 cursor-not-allowed border border-slate-300 mt-2 w-full rounded-lg py-1 px-2 text-white" disabled>Submit</button>
            </form>
            <script>
                $(document).ready(function () {
                    $('#password, #repeat_password').on('input', function () {
                        let password = $('#password').val().trim();
                        let repeatPassword = $('#repeat_password').val().trim();
                        let errorText = $('#error');
                        let submitBtn = $('#submit-btn');

                        // Reset error message
                        errorText.text('').addClass('hidden');

                        if (password.length < 7) {
                            errorText.text('Password must be at least 7 characters long.').removeClass('hidden');
                            submitBtn.prop('disabled', true).removeClass('bg-[#632c7d]').addClass('bg-gray-500 cursor-not-allowed');
                            return;
                        }

                        if (repeatPassword.length > 0 && password !== repeatPassword) {
                            errorText.text('Passwords do not match.').removeClass('hidden');
                            submitBtn.prop('disabled', true).removeClass('bg-[#632c7d]').addClass('bg-gray-500 cursor-not-allowed');
                            return;
                        }

                        // Enable button if all conditions are met
                        if (password.length >= 7 && password === repeatPassword) {
                            submitBtn.prop('disabled', false).removeClass('bg-gray-500 cursor-not-allowed').addClass('bg-[#632c7d]');
                        }
                    });
                });


            </script>
        </div>
        <div class="w-3/4 rounded-tr-3xl rounded-br-3xl bg-[#632c7d] flex items-center justify-center">
            <img src="{{asset('images/hero2.png')}}" alt="Algohub Hero" class="w-2/4 h-auto">
        </div>
    </div>
</body>
</html>