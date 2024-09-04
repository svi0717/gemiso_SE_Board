<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>일정 수정</title>
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

@section('title', '일정 수정')

@section('content')
    <div class="container mt-5">
        <div class="row mb-4">
            <div class="col-12 centered-form">
                <h3 class="text-center">일정 수정</h3>
                <!-- 수정 폼 시작 -->
                <form action="{{ route('schedules.update', $post->sch_id) }}" method="POST">
                    @csrf <!-- CSRF 보호 토큰 -->
                    @method('PUT') <!-- PUT 메서드를 사용하여 요청 -->
                    <input type="hidden" name="sch_id" value="{{ $post->sch_id }}">

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
                        <textarea class="form-control" id="content" name="content" rows="10">{{ $post->content }}</textarea>
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
@endsection
</body>
</html>
