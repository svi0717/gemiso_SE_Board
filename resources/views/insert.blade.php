<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게시판 목록</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <style>
        .centered-form {
            max-width: 600px; /* Optional: Set a maximum width for the form */
            margin: 0 auto; /* Center the form horizontally */
        }
        .table-header {
            background-color: #f8f9fa;
        }
        .table tbody tr:last-child {
            border-bottom: 2px solid #dee2e6; /* Light gray border for the last row */
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
                <h3 class="text-center">게시판 등록</h3>
                <div class="mb-3">
                    <label for="title" class="form-label">제목</label>
                    <input type="text" class="form-control" id="title" placeholder="제목">
                </div>
                <div class="mb-3">
                    <label for="Author" class="form-label">작성자</label>
                    <input type="text" class="form-control" id="Author" placeholder="작성자">
                </div>
                <div class="mb-3">
                    <label for="content" class="form-label">내용</label>
                    <textarea class="form-control" id="content" rows="10"></textarea>
                </div>
            </div>
        </div>
        
        <div class="text-right">
            <a href="/insert" class="btn btn-primary">등록</a>
        </div>
    </div>
@endsection
</body>
</html>
