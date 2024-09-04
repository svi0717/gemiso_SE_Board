<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='utf-8' />
    <style>
        #calendar {
            max-width: 900px; /* 원하는 너비로 조정 */
            margin: 40px auto; /* 중앙 정렬 */
            height: 700px; /* 원하는 높이로 조정 */
            color: #000000 !important;
        }
    </style>
    <link href='css/main.css' rel='stylesheet' />
    <script src='js/main.js'></script>
    <script src='js/locales-all.js'></script>
    <!-- SweetAlert 라이브러리 추가 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                headerToolbar: {
                    left: 'prevYear,prev,next,nextYear today',
                    center: 'title',
                    right: 'dayGridMonth,dayGridWeek,dayGridDay'
                },
                locale: "ko",
                selectable: true,
                selectMirror: true,
                navLinks: true, // can click day/week names to navigate views
                editable: true,
                dayCellContent: function(arg) {
                    if (arg.view.type === 'dayGridMonth') {
                        // Month view에서만 날짜에 숫자만 표시
                        arg.dayNumberText = arg.date.getDate();
                    }
                },
                dateClick: function(arg) { 
                var selectedDate = arg.dateStr;  // 날짜 클릭 시
                var url = '/scheduleList?date=' + selectedDate; // 선택된 날짜를 URL 파라미터로 전달
                window.location.href = url;  // URL로 리디렉션
                },
                select: function (arg) {
                    // 일정 등록 페이지로 이동할 URL 생성
                    var url = '/insertsch' ;

                    // URL로 리디렉션
                    window.location.href = url;
                },
                eventClick: function (arg) {
                    console.log("Event clicked:", arg);  // 이벤트 객체 로그

                    var scheduleId = arg.event.id; // 이벤트의 ID를 가져옴
                    var url = '/schedule/' + scheduleId; // 상세 페이지 URL 생성
                    window.location.href = url; // 해당 URL로 리디렉션
               },
                dayMaxEvents: true, // allow "more" link when too many events
                events: [
                    @foreach ($schedule as $item)
                    {
                        id: "{{ $item->sch_id }}", // `id` 필드로 설정
                        title: "{{ $item->title }}",
                        start: "{{ $item->start_date }}",
                        end: "{{ \Carbon\Carbon::parse($item->end_date)->addDay()->format('Y-m-d') }}"
                    },
                    @endforeach
                ]
            });
            calendar.render();
        });
    </script>
</head>
<body>
    @extends('layouts.header')
    @section('title', '일정관리')
    @section('content')
    <div id='calendar'>
    </div>
    <div class="text-right">
            <a href="/insertsch" class="btn btn-primary">등록</a>
        </div>
    @endsection
</body>
</html>
