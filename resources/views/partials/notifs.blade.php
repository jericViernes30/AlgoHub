<button id="notifButton" data-teacherid="{{ session('teacher_id') }}" class="relative">
    <div id="notifBadge" class="w-[10px] h-[10px] bg-red-500 rounded-full absolute -top-1 right-0 {{ $notSeen ? '' : 'hidden' }}"></div>
    <img src="{{ asset('images/bell.png') }}" alt="">
    <div id="notifs" class="w-[300px] h-[300px] p-5 bg-[#f3f1f1] absolute top-7 -left-12 hidden">
        <p class="text-sm text-left font-medium mb-2 text-[#632c7d]">Notifications</p>
        <div class="w-full h-[240px] overflow-auto">
            @foreach ($notifs as $notif)
                <div onclick="window.location.href='{{ $notif->type == 'New Il student' ? url('teacher/il/' . $notif->code) : url('teacher/class/' . $notif->code) }}'" class="w-full text-left py-2 border-b-2 cursor-pointer">
                    @if ($notif->type == 'New Class')
                        <p class="text-sm font-medium text-[#632c7d]">{{ $notif->type }}</p>
                        <p class="text-xs font-light mb-1 text-[#632c7d]">{{ $notif->created_at->format('F d Y h:i a') }}</p>
                        <p class="text-xs">
                            Regular class every {{ $notif->date_time }}
                        </p>
                    @else
                        <p class="text-sm font-medium text-[#632c7d]">{{ $notif->type }}</p>
                        <p class="text-xs font-light mb-1 text-[#632c7d]">{{ $notif->created_at->format('F d Y h:i a') }}</p>
                        <p class="text-xs">
                            {{ $notif->student_name }} is {{ $notif->type == 'New Il student' ? 'scheduled' : 'enrolled' }} 
                            in {{ $notif->date_time }} {{ $notif->course }} Course.
                        </p>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</button>