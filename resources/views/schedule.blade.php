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
                select: function (arg) {
                    // 게시물 등록 페이지로 이동할 URL 생성
                    var url = '/insert?category=일정관리&start=' + arg.startStr + '&end=' + arg.endStr;

                    // URL로 리디렉션
                    window.location.href = url;
                },
                // Delete event
                eventClick: function (arg) {
                    // var eventId = arg.event.id;

                    // // 일정 조회 페이지로 이동할 URL 생성
                    // var url = '/view-schedule/' + eventId;
                    
                    // // URL로 리디렉션
                    // window.location.href = url;
                },
                dayMaxEvents: true, // allow "more" link when too many events
                events: [
                    @foreach ($schedule as $item)
                    {
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
    <div id='calendar'></div>
    @endsection
</body>
</html>
