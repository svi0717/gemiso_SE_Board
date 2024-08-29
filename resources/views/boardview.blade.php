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
            font-size: 1.25rem; 
            margin-bottom: 5px; 
        }
        .card-subtitle {
            margin: 0; 
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

                    <div class="card-body content-layout">
                        <!-- 게시물 제목과 작성자 -->
                        <div class="title-author">
                            <h5 class="card-title">게시물 제목</h5>
                            <div class="card-subtitle text-muted">작성자: 작성자 이름</div>
                        </div>
                        <!-- 게시물 내용 -->
                        <div class="content">여기에 게시물의 내용이 들어갑니다. 게시물의 내용은 본문을 나타내며, 여러 줄에 걸쳐 있을 수 있습니다.</div>
                    </div>
                    <div class="card-footer text-right">
                        <a href="/editboard" class="btn btn-secondary">수정</a>
                        <a href="/delete" class="btn btn-danger">삭제</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        date = new Date();
        year = date.getFullYear();
        month = date.getMonth() + 1;
        day = date.getDate();
        document.getElementById("current_date").innerHTML = year + "-" + month + "-" + day;
    </script>
@endsection
</body>
</html>
