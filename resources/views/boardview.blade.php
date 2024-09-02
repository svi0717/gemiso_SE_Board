<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게시판 조회</title>
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
        .title-section {
            margin-bottom: 10px; 
        }

        .author-date {
            display: flex;
            align-items: center;
            gap: 5px; 
            margin-bottom: 10px; 
        }
        .card-title {
            padding : 10px;
            font-size: 1.25rem; 
            margin-bottom: 5px; 
        }
        .card-subtitle {
            padding : 10px;
        }
        .date-label {
            color: #6c757d;
        }
        .data-view {
            color: #000000;
            text-align: right;
        }
        .title-author {
            display: flex;
            justify-content: space-between; 
            align-items: center;
        }
        .content {
            margin-bottom: 150px;
        }
        .card-title-container {
            display: flex;
            justify-content: space-between; /* 양쪽 끝에 배치 */
            margin-bottom: 10px; /* 아래쪽 여백 */
        }
    </style>
</head>
<body>
@extends('layouts.header')

@section('title', '게시판 조회')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-12 centered-form">
                <div class="card">
                    <div class="card-header">
                        게시물 조회
                        <div class="date-view" id="current_date"></div>
                    </div>
                    <div class="card-title-container">
                        <div class="card-title">제목: {{ $post->title }}</div>
                        <div class="card-subtitle text-muted">작성자: {{ $post->user_id }}</div>
                    </div>
                    <div class="card-body content-layout">
                        <!-- 게시물 내용 -->
                        <div class="content">{{ $post->content }}</div>
                    </div>
                    <div class="card-footer text-right">
                        <!-- 수정 및 삭제 버튼 추가 -->
                        <a href="{{ route('boards.edit', ['id' => $post->board_id]) }}" class="btn btn-secondary">수정</a>
                        <form action="{{ route('boards.delete', $post->board_id) }}" method="POST" style="display: inline;" onsubmit="return confirm('정말 삭제하시겠습니까?');">
                            @csrf
                            @method('DELETE') <!-- DELETE 메서드를 사용하도록 지정 -->
                            <button type="submit" class="btn btn-danger">삭제</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        date = new Date();
        year = date.getFullYear();
        month = ('0' + (date.getMonth() + 1)).slice(-2); // 월을 2자리로 표시
        day = ('0' + date.getDate()).slice(-2); // 일을 2자리로 표시
        document.getElementById("current_date").innerHTML = year + "-" + month + "-" + day;
    </script>
@endsection
</body>
</html>
