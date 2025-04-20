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
            <div class="w-full absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 px-5">
                <p class="text-2xl font-bold mb-2">Password reset</p>
                <label for="Login">Username</label>
                <input id="username" type="text" name="username" class="border border-slate-300 mt-1 w-full rounded-lg py-1 px-2 outline-none focus:border-[#632c7d]">
                <span id="result" class="text-xs"></span>
                <div id="loader" class="hidden w-full items-center justify-center">
                    <span class="loader"></span>
                </div>
                <button id="continue-btn" class="bg-[#632c7d] border border-slate-300 mt-2 w-full rounded-lg py-1 px-2 text-white hidden">Submit</button>
                <a href="{{route('welcome')}}" class="text-sm text-[#632c7d] text-center block mx-auto mt-5">Click here to login</a>
            </div>
        </div>
        <div class="w-3/4 rounded-tr-3xl rounded-br-3xl bg-[#632c7d] flex items-center justify-center">
            <img src="{{asset('images/hero2.png')}}" alt="Algohub Hero" class="w-2/4 h-auto">
        </div>
    </div>
    <script>
        $(document).ready(function () {
            let email = ''
            $('#username').on('input', function () {
                $('#loader').removeClass('hidden').addClass('flex')
                var username = $(this).val();
                if (username.length > 0) {
    
                    // Perform the AJAX request to check if the username exists
                    $.ajax({
                        url: '/check-username',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            username: username
                        },
                        success: function (response) {
                            if (response.found) {
                                email = response.teacher.email_address
                                $('#loader').addClass('hidden').removeClass('flex')
                                // Handle the case when the username is found
                                $('#result').text('Teacher account found!')
                                $('#result').addClass('text-green-500')
                                $('#result').removeClass('text-red-500')
                                $('#continue-btn').removeClass('hidden')
                            } else {
                                $('#loader').addClass('hidden').removeClass('flex')
                                $('#continue-btn').addClass('hidden')
                                $('#result').text('Teacher account not found!')
                                $('#result').addClass('text-red-500')
                                $('#result').removeClass('text-green-500')
                            }
                        },
                        error: function () {
                            alert('An error occurred while checking the username.');
                        }
                    });
                } else {
                    // Enable the button if there's input in the username field
                    $('#result').text('Username is empty!')
                    $('#result').addClass('text-red-500')
                    $('#result').removeClass('text-green-500')
                    $('#loader').addClass('hidden').removeClass('flex')
                    $('#continue-btn').addClass('hidden')
                }
            });

            $('#continue-btn').on('click', function(){
                $('#loader').removeClass('hidden').addClass('flex')
                $('#continue-btn').text('Please wait')
                $('#continue-btn').prop('disabled', true)
                $('#continue-btn').addClass('cursor-not-allowed')
                $.ajax({
                    url: '/send-reset-email',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        email: email
                    },
                    success: function () {
                        alert('Password reset email has been sent!');
                        window.location.href='{{route('welcome')}}'
                    },
                    error: function () {
                        alert('Failed to send password reset email.');
                        location.reload()
                    }
                });
            })
        });
    </script>
</body>
</html>