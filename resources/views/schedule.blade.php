<!DOCTYPE html>
<html lang='en'>
<head>
    <title>일정관리</title>
    <meta charset='utf-8' />
    <style>
        #calendar-container {
            max-width: 900px;
            margin: 40px auto;
            position: relative;
            height: 700px;
        }
        #calendar {
            height: 100%;
            color: #000000 !important;
        }
        .btn-container {
            position: absolute;
            right: 0;
            margin-top: 15px;
        }
    </style>
    <link href="{{ asset('css/custom-buttons.css') }}" rel="stylesheet">
    <link href='css/main.css' rel='stylesheet' />
    <script src='js/main.js'></script>
    <script src='js/locales-all.js'></script>
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
                navLinks: true,
                editable: true,
                dayCellContent: function(arg) {
                    if (arg.view.type === 'dayGridMonth') {
                        arg.dayNumberText = arg.date.getDate();
                    }
                },
                dateClick: function(arg) {
                    var selectedDate = arg.dateStr;
                    var url = '/scheduleList?date=' + selectedDate;
                    window.location.href = url;
                },
                select: function (arg) {
                    var start = arg.startStr;
                    var end = arg.endStr;
                    var url = '/insertsch?start_date=' + start + '&end_date=' + end;
                    window.location.href = url;
                },
                eventClick: function (arg) {
                    var scheduleId = arg.event.id;
                    var url = '/schedule/' + scheduleId;
                    window.location.href = url;
                },
                eventDrop: function (info) {
                    updateEventDate(info.event);
                },
                eventResize: function (info) {
                    updateEventDate(info.event);
                },
                dayMaxEvents: true,
                events: [
                    @foreach ($schedule as $item)
                    {
                        id: "{{ $item->sch_id }}",
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
    <div id="calendar-container">
        <div id='calendar'></div>
        <div class="btn-container">
            <a href="/insertsch" class="btn-custom">등록</a>
        </div>
    </div>
    @endsection
</body>
</html>
