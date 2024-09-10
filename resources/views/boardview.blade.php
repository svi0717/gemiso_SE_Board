<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>게시판 조회</title>
    <link href="{{ asset('css/custom-buttons.css') }}" rel="stylesheet">

</head>


<style>
    .table a {
        color: black !important;
    }

    .card-title-container {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
    }

    .card-title {
        padding: 10px;
        font-size: 1.25rem;
        margin-bottom: 5px;
    }

    .card-header {
        background-color: #f8f9fa;
        font-weight: bold;
        padding: 10px 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .comment-container {
        margin-top: 20px;
    }

    .comment-form {
        margin-bottom: 20px;
    }

    .comment-list {
        list-style: none;
        padding: 0;
    }

    .comment-list li {
        border-bottom: 1px solid #ddd;
        padding: 10px 0;
    }

    .reply-form {
        display: none;
        margin-top: 10px;
    }

    .reply-list {
        list-style: none;
        padding-left: 20px;
    }
</style>
<body>

    @extends('layouts.header')

    @section('title', '게시물 조회')

    @section('content')
        <div class="container mt-5">
            <div class="row mb-4">
                <div class="col-12 centered-form">
                    <div class="card">
                        <div class="card-header">
                            게시물 조회
                            <div class="d-flex flex-column align-items-end">
                                <div class="date-view" id="current_date"></div>
                            </div>
                        </div>
                        <div class="card-title-container">
                            <div class="card-title p-3">제목: {{ $post->title }}</div>
                            <div class="text-muted p-3">작성자: {{ $post->user_name }}</div>
                        </div>
                        <div class="card-body content-layout">
                            <!-- 게시물 내용 -->
                            <div class="content">{!! $post->content !!}</div>
                            @if (count($files) > 0)
                                <h5 class="mt-4">첨부 파일</h5>
                                <ul>
                                    @foreach ($files as $file)
                                        <li>
                                            <a href="{{ route('file.download', $file->id) }}">{{ $file->file_name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p>첨부 파일이 없습니다.</p>
                            @endif
                        </div>
                        <div class="card mt-4">
                            <div class="card-header">
                                댓글 목록
                            </div>
                            <form id="comment-form">
                                @csrf
                                <input type="hidden" name="board_id" value="{{ $board_id }}">
                                <div class="form-group d-flex flex-column align-items-center">
                                    <textarea id="content" name="content" class="form-control mt-2" style="width: 90%;" rows="4" required></textarea>
                                    <div class="w-100 d-flex justify-content-end mt-2" style="max-width: 90%;">
                                        <button type="submit" class="btn btn-primary">댓글 등록</button>
                                    </div>
                                </div>
                            </form>
                            <div class="card-body">
                                @if ($comments->isEmpty())
                                    <p class="no-comments">댓글이 없습니다.</p>
                                @endif
                                <ul class="comment-list">
                                    @foreach ($comments as $comment)
                                    <li data-comment-id="{{ $comment->c_id }}">
                                        <div>
                                            <strong>{{ $post->user_name }}</strong>
                                            <p>{{ $comment->content }}</p>
                                            <small class="text-muted">{{ $comment->reg_date }}</small>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <!-- 왼쪽 버튼들 -->
                                            <div class="d-flex">
                                                <button class="btn-custom btn-reply mt-2" data-comment-id="{{ $comment->c_id }}">답글</button>
                                            </div>
                                            <!-- 오른쪽 버튼들 -->
                                            <div class="d-flex">
                                                <button class="btn btn-secondary mt-2 mr-1">수정</button>
                                                <button class="btn btn-danger mt-2 ms-2">삭제</button>
                                            </div>
                                        </div>

                                        <!-- 답글 목록 표시 -->
                                        <ul class="reply-list" data-comment-id="{{ (int)$comment->c_id }}" style="display: none;">
                                            @foreach ($replies->where('parent_id', $comment->c_id) as $reply)
                                                <li>
                                                    <strong>{{ $post->user_name }}</strong>
                                                    <p>{{ $reply->content }}</p>
                                                    <small class="text-muted">{{ $reply->reg_date }}</small>
                                                </li>
                                            @endforeach
                                        </ul>

                                        <!-- 답글 폼 -->
                                        <div class="reply-form" style="display: none;">
                                            <form class="reply-form-content">
                                                @csrf
                                                <input type="hidden" name="parent_id" value="{{ (int)$comment->c_id }}">
                                                <textarea name="content" class="form-control mt-2" style="width: 90%;" rows="2" required></textarea>
                                                <div class="w-100 d-flex justify-content-end mt-2" style="max-width: 90%;">
                                                    <button type="submit" class="btn btn-primary">답글 등록</button>
                                                </div>
                                            </form>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>

                        </div>
                        <div class="card-footer text-right">
                            <a href="/boardList" class="btn-custom">목록</a>
                            @if ($userId == $post->user_id)
                                <a href="{{ route('boards.edit', ['id' => $post->board_id]) }}" class="btn btn-secondary">수정</a>
                                <form action="{{ route('boards.delete', $post->board_id) }}" method="POST"
                                    style="display: inline;" onsubmit="return confirm('정말 삭제하시겠습니까?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">삭제</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- 게시물과 연동된 일정 목록 -->
            <div class="row mt-4">
                <div class="col-12 centered-form">
                    <div class="card">
                        <div class="card-header">
                            일정 목록
                        </div>
                        <div class="card-body">
                            @if ($schedules->isEmpty())
                                <p>일정이 없습니다.</p>
                            @else
                                <table class="table table-bordered table-striped text-center">
                                    <thead>
                                        <tr>
                                            <th>번호</th>
                                            <th style="width: 40%;">제목</th>
                                            <th>작성자</th>
                                            <th>등록일자</th>
                                            <th>시작일자</th>
                                            <th>종료일자</th>
                                        </tr>
                                    </thead>
                                    <tbody id="scheduleTableBody">
                                        @foreach ($schedules as $item)
                                            <tr class="schedule-row">
                                                <td>{{ $loop->iteration }}</td>
                                                <td class="text-truncate" style="max-width: 250px;">
                                                    <a
                                                        href="{{ route('schedules.show', $item->sch_id) }}?previous_url={{ urlencode(route('schedule')) }}">{{ $item->title }}</a>
                                                </td>
                                                <td>{{ $post->user_name }}</td>
                                                <td>{{ \Carbon\Carbon::parse($item->reg_date)->format('Y-m-d') }}</td>
                                                <td>{{ $item->start_date }}</td>
                                                <td>{{ $item->end_date }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center">
                                    <button id="loadMoreBtn" class="btn btn-primary mt-2" style="display: none;">더보기</button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function() {
            // 댓글 폼 제출 이벤트 처리
            $('#comment-form').on('submit', function(e) {
                e.preventDefault(); // 기본 폼 제출 막기

                $.ajax({
                    url: '{{ route("comment.insert") }}',  // 댓글 삽입 라우트
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        const newComment = `
                            <li data-comment-id="${response.comment_id}">
                                <div>
                                    <strong>${response.user_name}</strong>
                                    <p>${response.content}</p>
                                    <small class="text-muted">${response.reg_date}</small>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <!-- 왼쪽 버튼들 -->
                                    <div class="d-flex">
                                        <button class="btn-custom btn-reply mt-2" data-comment-id="${response.comment_id}">답글</button>
                                    </div>
                                    <!-- 오른쪽 버튼들 -->
                                    <div class="d-flex">
                                        <button class="btn btn-secondary mt-2 mr-1">수정</button>
                                        <button class="btn btn-danger mt-2 ms-2">삭제</button>
                                    </div>
                                </div>
                                <!-- 답글 목록 표시 -->
                                <ul class="reply-list"></ul>
                                <!-- 답글 폼 -->
                                <div class="reply-form">
                                    <form class="reply-form-content">
                                        @csrf
                                        <input type="hidden" name="parent_id" value="${response.comment_id}">
                                        <textarea name="content" class="form-control mt-2" style="width: 90%;" rows="2" required></textarea>
                                        <div class="w-100 d-flex justify-content-end mt-2" style="max-width: 90%;">
                                            <button type="submit" class="btn btn-primary">답글 등록</button>
                                        </div>
                                    </form>
                                </div>
                            </li>
                        `;

                        if ($('.comment-list').children().length === 0) {
                            $('.no-comments').remove();
                        }

                        $('.comment-list').append(newComment);
                        $('#content').val('');
                    },
                    error: function(xhr) {
                        alert('댓글 등록 중 문제가 발생했습니다.');
                    }
                });
            });

            // 답글 버튼 클릭 이벤트 처리
            $(document).on('click', '.btn-reply', function() {
                const commentId = $(this).data('comment-id');
                const parentLi = $(this).closest('li');
                const replyList = parentLi.find('.reply-list');
                const replyForm = parentLi.find('.reply-form');

                // 답글 목록과 답글 폼 토글
                if (replyList.is(':visible') && replyForm.is(':visible')) {
                    replyList.hide();
                    replyForm.hide();
                } else {
                    replyList.toggle();
                    replyForm.toggle();
                }
            });

            // 답글 폼 제출 이벤트 처리
            $(document).on('submit', '.reply-form-content', function(e) {
                e.preventDefault(); // 기본 폼 제출 막기

                const form = $(this);
                const formData = form.serializeArray();

                // 폼 데이터와 함께 parent_id 출력 확인
                console.log('Form Data:', formData);

                $.ajax({
                    url: '{{ route("comment.insert") }}',  // 답글 삽입 라우트
                    type: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        if (response.status === 'success') {
                            const parentLi = form.closest('li');
                            const replyList = parentLi.find('.reply-list');

                            const newReply = `
                                <li>
                                    <div>
                                        <strong>${response.user_name}</strong>
                                        <p>${response.content}</p>
                                        <small class="text-muted">${response.reg_date}</small>
                                    </div>
                                </li>
                            `;

                            if (replyList.is(':hidden')) {
                                replyList.show();
                            }

                            replyList.append(newReply);
                            form[0].reset();
                        } else {
                            alert('답글 등록 중 문제가 발생했습니다: ' + response.message);
                        }
                    },
                    error: function(xhr) {
                        const errorMessage = xhr.responseJSON?.message || '알 수 없는 오류가 발생했습니다.';
                        alert('답글 등록 중 문제가 발생했습니다: ' + errorMessage);
                        console.log('error', xhr.responseJSON);
                    }
                });
            });
        });
        </script>
    @endsection
</body>
</html>
