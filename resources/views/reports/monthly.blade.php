<!doctype html>
<html>
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/5bf9be4e76.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="{{ asset('js/scripts.js') }}"></script>
    <link rel="shortcut icon" href="{{asset('images/algo-logo.png')}}" type="image/x-icon">
    @vite('resources/css/app.css')
    <title>Monthly Report - {{ now()->startOfMonth()->format('F d, Y') }} to {{ now()->endOfMonth()->format('F d, Y') }}
    </title>
    <style>
        body { font-family: 'Montserrat', Arial, sans-serif; margin: 20px; }
        .header { text-align: center; margin-bottom: 30px; }
        .header img { width: 150px; }
        .title { font-size: 20px; font-weight: bold; margin-top: 10px; color: #632c7d }
        .subtitle { font-size: 14px; color: #666; margin-bottom: 3px;}
        .subtitle2 { font-size: 14px; color: #414141; margin-bottom: 15px; font-weight: medium; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; font-size: x-small; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #F2EBFB; }
        .w-1-5 { width: 25%; }
        .w-5 { width: 8%; }
        .w-11 { width: 17%; }
        .text-center { text-align: center; }
        .border-b { border-bottom: 1px solid #d8d8d8; }
        .py-4 { padding-top: 16px; padding-bottom: 16px; }
        .py-2 { padding-top: 8px; padding-bottom: 8px; }
        .px-2 { padding-left: 8px; padding-right: 8px; }

        .walkInCountContainer {
            width: 100%;
            margin-bottom: 20px;
        }

        .walkInCount {
            font-size: 20px;
            font-weight: medium;
        }

        .walkInCount span {
            font-size: 30px;
            color: #632c7d;
            font-weight: bold;
        }
    </style>
</head>
<body style="width: 100%; margin: 0 auto;">
    <!-- Header Section -->
    <div class="header">
        <img src="{{public_path('images/algo-new.png')}}" alt="Algorithmics Logo">
        <div class="title">Algorithmics International School of Programming - Nuvali</div>
        <div class="subtitle">2nd Floor Vista Mall, Brgy. Sto. Domingo, Sta. Rosa City, Laguna</div>
        <div class="subtitle2">Monthly Report - {{ now()->startOfMonth()->format('F d, Y') }} to {{ now()->endOfMonth()->format('F d, Y') }}
        </div>
    </div>

    
    <div class="walkInCountContainer">
        <p class="walkInCount" >Walk in clients: <span>{{$scheduledCount}}</span></p>
    </div>

    
    @php
    $totalInquiries = array_sum($courseCounts); // Get the total number of inquiries across all courses
@endphp

<table border="1" style="width: 100%; margin-top: 20px; border-collapse: collapse;">
    <!-- Table Header -->
    <tr style="background-color: #f2f2f2;">
        <th colspan="3" style="text-align: center">Course Inquiry List</th>
    </tr>
    <thead>
        <tr style="background-color: #f2f2f2;">
            <th style="padding: 10px;">Course Name</th>
            <th style="padding: 10px; text-align: center;">Course Inquiries</th> 
            <th style="padding: 10px; text-align: center;">%</th>
        </tr>
    </thead>
    <tbody>
        <!-- Course Inquiry Data -->
        @foreach ($courseCounts as $courseName => $count)
            <tr>
                <td style="padding: 10px;">{{ $courseName }}</td>
                <td style="padding: 10px; text-align: center;">{{ $count }}</td>
                <td style="padding: 10px; text-align: center;">
                    {{ $totalInquiries > 0 ? number_format(($count / $totalInquiries) * 100, 2) : '0.00' }}%
                </td>
            </tr>
        @endforeach
    </tbody>
    <!-- Footer Row for Totals -->
    <tfoot>
        <tr style="background-color: #f2f2f2; font-weight: bold;">
            <td style="padding: 10px; text-align: right;">Total:</td>
            <td style="padding: 10px; text-align: center;">{{ $totalInquiries }}</td>
            <td style="padding: 10px; text-align: center;">100.00%</td>
        </tr>
    </tfoot>
</table>

    <!-- Report Table -->
    <table style="">
        <tr style="background-color: #f2f2f2;">
            <th colspan="6" style="text-align: center">Walk in clients</th>
        </tr>
        <tr>
            <th class="w-1-5 py-2 px-2">Parents Name</th>
            <th class="w-1-5 py-2">Child's Name</th>
            <th class="w-5 py-2">Age</th>
            <th class="w-11 py-2">Contact Number</th>
            <th class="w-1-5 py-2">Email Address</th>
            <th class="w-1-5 py-2">Inquired courses</th>
        </tr>
        <!-- Sample data row for reference -->
        @foreach ($scheduling as $for_scheduling)
            <tr class="border-b">
                <td class="w-1-5 py-4 px-2">{{$for_scheduling->parents_first_name}} {{$for_scheduling->parents_last_name}}</td>
                <td class="w-1-5 py-2">{{$for_scheduling->childs_name}} {{$for_scheduling->parents_last_name}}</td>
                <td class="w-5 py-2">{{$for_scheduling->age}}</td>
                <td class="w-11 py-2">{{$for_scheduling->contact_number}}</td>
                <td class="w-1-5 py-2">{{$for_scheduling->email_address}}</td>
                <td class="w-1-5 py-2">{{$for_scheduling->inquired_courses}}</td>
            </tr>
        @endforeach
    </table>   
</body>
</html>
