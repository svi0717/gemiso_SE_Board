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
            max-width: 800px; /* Set a maximum width for the card */
            margin: 0; /* Center the card horizontally */
        }
        .card-header {
            background-color: #f8f9fa;
            font-weight: bold;
            padding: 10px 15px;
            display: flex; /* Use flexbox for alignment */
            justify-content: space-between; /* Distribute space between elements */
            align-items: center; /* Center items vertically */
        }
        .card-body {
            white-space: pre-wrap; /* Preserve whitespace formatting in content */
            padding: 15px;
        }
        .content-layout {
            margin-bottom: 100px;
            text-align: left; /* Ensure all content is left-aligned */
        }
        .author-date {
            display: flex;
            align-items: center;
            gap: 10px; /* Space between author and date */
        }
        .card-title {
            font-size: 1.25rem; /* Adjust title font size */
            margin-bottom: 5px; /* Adjust space below the title */
        }
        .card-subtitle {
            margin: 0; /* Ensure there's no extra spacing around subtitle */
        }
        .date-label {
            color: #6c757d; /* Bootstrap's secondary text color */
        }
        .data-view {
            color: #000000;
            text-align: right;
        }
    </style>
</head>
<body>
@extends('layouts.header')

@section('title', '게시판 목록')

@section('content')
    <div class="container mt-5">
        <div class="row mb-4">
            <div class="col-12 centered-form">
                <div class="card">
                    <div class="card-header">
                        <span>게시물 조회</span>
                        <span class="date-view" id="current_date"></span>
                    </div>

                    <div class="card-body content-layout">
                        <!-- 게시물 제목 -->
                        <span>게시물 제목</span>

                        <!-- 작성자와 날짜 -->
                        <div class="author-date">
                            <div class="card-subtitle text-muted">작성자: 작성자 이름</div>
                        </div>
                        <!-- 게시물 내용 -->
                        <p class="mt-3">여기에 게시물의 내용이 들어갑니다. 게시물의 내용은 본문을 나타내며, 여러 줄에 걸쳐 있을 수 있습니다.</p>
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
