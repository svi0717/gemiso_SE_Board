<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>비밀번호 재설정</title>
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

@section('title', '비밀번호 재설정')

@section('content')
<div class="container ml-5">
    <div class="card p-4">
        <div class="text-center mb-4">
            <h4>비밀번호 재설정</h4>
        </div>
        <form action="{{ route('updatePassword') }}" method="POST">
            @csrf
            <input type="hidden" name="user_id" value="{{ $user_id }}">
            <div class="mb-3">
                <label for="new_password" class="form-label">새 비밀번호</label>
                <input type="password" class="form-control" id="new_password" name="new_password" required>
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">비밀번호 확인</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">비밀번호 변경</button>
        </form>
    </div>
</div>
@endsection
</body>
</html>
