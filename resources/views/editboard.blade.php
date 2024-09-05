<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게시판 수정</title>
    <style>
        .centered-form {
            max-width: 600px; /* 폼의 최대 너비 설정 */
            margin: 0 auto; /* 폼을 가로로 중앙에 배치 */
        }
        .table-header {
            background-color: #f8f9fa;
        }
        .table tbody tr:last-child {
            border-bottom: 2px solid #dee2e6; /* 마지막 행에 연한 회색 테두리 */
        }
    </style>
</head>
<body>
@extends('layouts.header')

@section('title', '게시판 수정')

@section('content')
    <!-- include libraries(jQuery, bootstrap) -->
    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.css" rel="stylesheet">
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.js"></script>

    <!-- include summernote css/js-->
    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.css" rel="stylesheet">
    <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/lang/summernote-ko-KR.min.js"></script>
    <div class="container mt-5">
        <div class="row mb-4">
            <div class="col-12 centered-form">
                <h3 class="text-center">게시판 수정</h3>
                <!-- 수정 폼 시작 -->
                <form action="{{ route('boards.update', ['id' => $post->board_id]) }}" method="POST">
                    @csrf <!-- CSRF 보호 토큰 -->
                    @method('PUT') <!-- PUT 메서드를 사용하여 요청 -->

                    <!-- 제목 입력 필드 -->
                    <div class="mb-3">
                        <label for="title" class="form-label">제목</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ $post->title }}" placeholder="제목">
                    </div>

                    <!-- 작성자 입력 필드 -->
                    <div class="mb-3">
                        <label for="author" class="form-label">작성자</label>
                        <input type="text" class="form-control" id="author" name="author" value="{{ $post->user_name }}" placeholder="작성자" readonly>
                    </div>

                    <!-- 내용 입력 필드 -->
                    <div class="mb-3">
                        <label for="content" class="form-label">내용</label>
                        <textarea id="summernote" name="content" class="form-control" rows="10" required>{{ $post->content }}</textarea>
                    </div>

                    <!-- 수정 버튼 -->
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">수정</button>
                    </div>
                </form>
                <!-- 수정 폼 끝 -->
            </div>
        </div>
    </div>
    <script>
    $(document).ready(function() {
        $('#summernote').summernote({
            placeholder: '내용을 작성하세요',
            height: 300,
            maxHeight: 300,
            lang: 'ko-KR'
        });

        // 폼 제출 전에 Summernote 내용을 textarea에 동기화
        $('form').on('submit', function() {
            var summernoteContent = $('#summernote').summernote('code');
            $('#summernote').val(summernoteContent);
        });
    });
    </script>
@endsection
</body>
</html>
