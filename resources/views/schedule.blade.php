<!DOCTYPE html>
<html lang='en'>
  <head>
  <style>
      #calendar {
    max-width: 900px; /* 원하는 너비로 조정 */
    margin: 40px auto; /* 중앙 정렬 */
    height: 700px; /* 원하는 높이로 조정 */
    color: #000000 !important;
}
  </style>
    <meta charset='utf-8' />
    <link href='css/main.css' rel='stylesheet' />
    <script src='js/main.js'></script>
    <script src='js/locales-all.js'></script>
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script> -->
    <script>
    	document.addEventListener('DOMContentLoaded', function() {
        	var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                // Tool Bar 목록 document : https://fullcalendar.io/docs/toolbar
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
                // dateClick: function(arg){
                //     alert('날짜가 클릭되었습니다!!');
                // },
                // Create new event
                select: function (arg) {
                    Swal.fire({
                        html: "<div class='mb-7'>Create new event?</div><div class='fw-bold mb-5'>Event Name:</div><input type='text' class='form-control' name='event_name' />",
                        icon: "info",
                        showCancelButton: true,
                        buttonsStyling: false,
                        confirmButtonText: "Yes, create it!",
                        cancelButtonText: "No, return",
                        customClass: {
                            confirmButton: "btn btn-primary",
                            cancelButton: "btn btn-active-light"
                        }
                    }).then(function (result) {
                        if (result.value) {
                            var title = document.querySelector("input[name=;event_name']").value;
                            if (title) {
                                calendar.addEvent({
                                    title: title,
                                    start: arg.start,
                                    end: arg.end,
                                    allDay: arg.allDay
                                })
                            }
                            calendar.unselect()
                        } else if (result.dismiss === "cancel") {
                            Swal.fire({
                                text: "Event creation was declined!.",
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-primary",
                                }
                            });
                        }
                    });
                },

                // Delete event
                eventClick: function (arg) {
                    Swal.fire({
                        text: "Are you sure you want to delete this event?",
                        icon: "warning",
                        showCancelButton: true,
                        buttonsStyling: false,
                        confirmButtonText: "Yes, delete it!",
                        cancelButtonText: "No, return",
                        customClass: {
                            confirmButton: "btn btn-primary",
                            cancelButton: "btn btn-active-light"
                        }
                    }).then(function (result) {
                        if (result.value) {
                            arg.event.remove()
                        } else if (result.dismiss === "cancel") {
                            Swal.fire({
                                text: "Event was not deleted!.",
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-primary",
                                }
                            });
                        }
                    });
                },
                dayMaxEvents: true, // allow "more" link when too many events
                // 이벤트 객체 필드 document : https://fullcalendar.io/docs/event-object
                events: [
                    {
                    title: 'All Day Event',
                    start: '2022-07-01'
                    },
                    {
                    title: 'Long Event',
                    start: '2022-07-07',
                    end: '2022-07-10'
                    },
                    {
                    groupId: 999,
                    title: 'Repeating Event',
                    start: '2022-07-09T16:00:00'
                    },
                    {
                    groupId: 999,
                    title: 'Repeating Event',
                    start: '2022-07-16T16:00:00'
                    },
                    {
                    title: 'Conference',
                    start: '2022-07-11',
                    end: '2022-07-13'
                    },
                    {
                    title: 'Meeting',
                    start: '2022-07-12T10:30:00',
                    end: '2022-07-12T12:30:00'
                    },
                    {
                    title: 'Lunch',
                    start: '2022-07-12T12:00:00'
                    },
                    {
                    title: 'Meeting',
                    start: '2022-07-12T14:30:00'
                    },
                    {
                    title: 'Happy Hour',
                    start: '2024-08-12T17:30:00'
                    },
                    {
                    title: 'Dinner',
                    start: '2024-08-12'
                    },
                    {
                    title: 'Birthday Party',
                    url: 'http://google.com/',
                    start: '2024-08-13'
                    },
                    {
                    title: 'Click for Google',
                    url: 'http://google.com/',
                    start: '2022-07-28'
                    },
                    {
                    title: 'Click for Google',
                    url: '/boardview',
                    start: '2024-08-29'
                    }
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