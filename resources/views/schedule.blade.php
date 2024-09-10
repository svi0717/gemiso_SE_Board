<!DOCTYPE html>
<html lang='en'>
<head>
    <title>일정관리</title>
    <meta charset='utf-8' />
    <style>
        #calendar {
            max-width: 900px; /* 원하는 너비로 조정 */
            margin: 40px auto; /* 중앙 정렬 */
            height: 700px; /* 원하는 높이로 조정 */
            color: #000000 !important;
        }
    </style>
    <link href="{{ asset('css/custom-buttons.css') }}" rel="stylesheet">
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
                    // 선택한 날짜 정보를 GET 파라미터로 전달
                    var start = arg.startStr;
                    var end = arg.endStr;

                    // 일정 등록 페이지로 이동할 URL 생성 (GET 파라미터 포함)
                    var url = '/insertsch?start_date=' + start + '&end_date=' + end;

                    // URL로 리디렉션
                    window.location.href = url;
                },
                eventClick: function (arg) {
                    console.log("Event clicked:", arg);  // 이벤트 객체 로그

                    var scheduleId = arg.event.id; // 이벤트의 ID를 가져옴
                    var url = '/schedule/' + scheduleId; // 상세 페이지 URL 생성
                    window.location.href = url; // 해당 URL로 리디렉션
               },
                // 이벤트 이동 후 날짜 업데이트
                eventDrop: function (info) {
                    updateEventDate(info.event);
                },
                // 이벤트 크기 조정 후 날짜 업데이트
                eventResize: function (info) {
                    updateEventDate(info.event);
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
            function updateEventDate(event) {
            var eventData = {
                id: event.id,
                start_date: event.startStr,
                end_date: event.endStr
            };

            // end 날짜에서 하루 빼기
            if (eventData.end_date) {
                var endDate = new Date(eventData.end_date);
                endDate.setDate(endDate.getDate() - 1);
                eventData.end_date = endDate.toISOString().split('T')[0];
            }

            fetch('/update-event', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(eventData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('성공', data.message, 'success');
                } else {
                    Swal.fire('오류', data.message, 'error');
                }
            })
            .catch(error => {
                Swal.fire('오류', '일정 업데이트 중 오류가 발생했습니다.', 'error');
                console.error('Error:', error);
            });
            }
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
            <a href="/insertsch" class="btn-custom">등록</a>
        </div>
    @endsection
</body>
</html>
