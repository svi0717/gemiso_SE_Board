<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>로그인</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
</head>
<style>
    html, body {
        height: 100%;
        margin: 0;
        overflow: hidden; /* 스크롤이 생기지 않도록 설정 */
    }

    .container {
        height: 100vh; /* 전체 화면 높이를 차지 */
        display: flex;
        align-items: center; /* 수직으로 중앙 정렬 */
    }

    .card {
        width: 400px;
    }

    .text-center {
        text-align: center;
    }

    .link-group {
        display: flex;
        justify-content: space-evenly;
    }
    </style>
<body>
@extends('layouts.loginHeader')

@section('title', '로그인')

@section('content')
<div class="container ml-5">
    <div class="card p-4">
        <div class="text-center mb-4">
            <h4>제머나이소프트 SE팀</h4>
        </div>
        <form>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">아이디</label>
                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">비밀번호</label>
                <input type="password" class="form-control" id="exampleInputPassword1">
            </div>
            <div class="mb-3 form-check">
                <div class="d-inline-block mr-5 ml-4">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">아이디 저장</label>
                </div>
                <div class="d-inline-block ml-5">
                    <input type="checkbox" class="form-check-input" id="autoLoginCheck">
                    <label class="form-check-label" for="autoLoginCheck">자동 로그인</label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-block">로그인</button>
            <a href="#" class="btn btn-primary btn-block">회원가입</a>
        </form>
        
        <!-- 아이디 찾기, 비밀번호 찾기, 회원가입 -->
        <div class="link-group mt-3">
            <a href="#" class="text-decoration-none">아이디 찾기</a>
            <a href="#" class="text-decoration-none">비밀번호 찾기</a>
        </div>
    </div>
</div>
@endsection
</body>
</html>
