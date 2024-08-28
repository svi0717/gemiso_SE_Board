<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>비밀번호 찾기</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
</head>
<style>
    html, body {
        height: 100%;
        margin: 0;
        overflow: hidden;
    }

    .container {
        height: 100vh; 
        display: flex;
        align-items: center; 
    }

    .card {
        width: 400px;
    }

    </style>
<body>
@extends('layouts.loginHeader')

@section('title', '비밀번호 찾기')

@section('content')
<div class="container ml-5">
    <div class="card p-4">
        <div class="text-center mb-4">
            <h4>비밀번호 찾기</h4>
        </div>
        <form>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">아이디</label>
                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">이름</label>
                <input type="email" class="form-control" id="name">
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">전화번호</label>
                <input type="email" class="form-control" id="phone">
            </div>
            <button type="submit" class="btn btn-primary btn-block">비밀번호 찾기</button>
        </form>
    </div>
</div>
@endsection
</body>
</html>
