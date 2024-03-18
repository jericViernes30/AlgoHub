<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    @vite('resources/css/app.css')
    <title>Document</title>
</head>
<body>
    <form action="" method="GET">
        @csrf
        <select name="course" id="dropdown">
            <option selected disabled>Please select a course</option>
            @foreach ($course as $courses)
                <option value="{{$courses->course_name}}">{{$courses->course_name}}</option>
            @endforeach
        </select>
    </form>
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
                        'href': 'admin/open_il/' + item.code,
                        }).append(
                            $('<div/>', {
                                'class': 'w-full border-2 border-[#833ae0] rounded-lg p-4 mb-5',
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

</body>
</html>