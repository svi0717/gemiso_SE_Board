<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게시물 조회</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <style>
        .centered-form {
            max-width: 800px;
            margin: 0 auto;
        }
        .card-header {
            background-color: #f8f9fa;
            font-weight: bold;
            padding: 10px 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .card-body {
            white-space: pre-wrap;
            padding: 15px;
        }
        .content-layout {
            text-align: left;
        }
        .card-title {
            padding: 10px;
            font-size: 1.25rem;
            margin-bottom: 5px;
        }
        .card-subtitle {
            padding: 10px;
        }
        .content {
            margin-bottom: 150px;
        }
        .card-title-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
@extends('layouts.header')

@section('title', '게시물 조회')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-12 centered-form">
              
                <div class="card">
                    <div class="card-header">
                        일정 조회
                        <div class="date-view"> {{ $post->start_date === $post->end_date ? $post->start_date : $post->start_date . ' ~ ' . $post->end_date }}</div>
                    </div>
                    <div class="card-title-container">
                        <div class="card-title">제목: {{ $post->title }}</div>
                        <div class="card-subtitle text-muted">
                          작성자: {{ $post->user_name}}
                        </div>
                    </div>

                    <div class="card-body content-layout">
                        <!-- 내용 -->
                        <div class="content">{{ $post->content }}</div>
                    </div>

                    
                    <div class="card-footer text-right">
                        <a href="{{ request()->get('previous_url', '/schedule') }}" class="btn btn-primary">목록</a>
                        <!-- 수정 및 삭제 버튼 추가 -->
                        @if ($userId == $post->user_id)
                                <a href="{{ route('schedules.edit', $post->sch_id) }}" class="btn btn-secondary">수정</a>
                                <form action="{{ route('schedules.delete', $post->sch_id) }}" method="POST" style="display: inline;" onsubmit="return confirm('정말 삭제하시겠습니까?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">삭제</button>
                                </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
</body>
</html>
