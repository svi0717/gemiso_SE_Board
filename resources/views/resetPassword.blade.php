<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>비밀번호 재설정</title>
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
        <form action="{{ route('updatePassword') }}" method="POST" id="updatePasswordForm">
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
<script>
    document.getElementById('updatePasswordForm').addEventListener('submit', function(event) {
        event.preventDefault(); // 기본 폼 제출 방지

        const newPassword = document.getElementById('new_password').value;
        const confirmPassword = document.getElementById('confirm_password').value;

        if (newPassword !== confirmPassword) {
            // 비밀번호와 비밀번호 확인이 일치하지 않는 경우 SweetAlert로 알림
            Swal.fire({
                icon: 'error',
                title: '비밀번호 불일치',
                text: '비밀번호와 비밀번호 확인이 일치하지 않습니다.',
            });
        } else {
            // 비밀번호가 일치하면 폼을 제출
            this.submit();
        }
    });
</script>
@endsection
</body>
</html>
