<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>회원가입</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
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

    .btn-check {
        margin-top: 10px;
    }

    .text-danger {
        font-size: 0.875em;
    }

    .text-success {
        font-size: 0.875em;
    }
</style>
<body>
@extends('layouts.loginHeader')

@section('title', '회원가입')

@section('content')
<div class="container ml-5">
    <div class="card p-4">
        <div class="text-center mb-4">
            <h4>회원가입</h4>
        </div>

        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="user_id" class="form-label">아이디</label>
                <input type="text" class="form-control @error('user_id') is-invalid @enderror" id="user_id" name="user_id" value="{{ old('user_id') }}" placeholder="아이디">
                @error('user_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
                <button type="button" class="btn btn-secondary btn-check" id="check-id-btn">중복 확인</button>
                <div id="user-id-status" class="mt-2"></div> <!-- 상태 메시지 출력용 -->
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">비밀번호</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="비밀번호">
                @error('password')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">비밀번호 확인</label>
                <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" id="passwordCheck" placeholder="비밀번호 확인">
                @error('password_confirmation')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">이름</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="이름">
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="department" class="form-label">부서명</label>
                <input type="text" class="form-control @error('department') is-invalid @enderror" id="department" name="department" value="{{ old('department') }}" placeholder="부서명">
                @error('department')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">전화번호</label>
                <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}" placeholder="전화번호">
                @error('phone')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary btn-block">회원가입</button>
        </form>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    $(document).ready(function() {
        $('#check-id-btn').on('click', function() {
            var userId = $('#user_id').val();

            if (userId === '') {
                alert('아이디를 입력해 주세요.');
                return;
            }

            $.ajax({
                url: "{{ route('checkUserId') }}",
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    user_id: userId
                },
                success: function(response) {
                    var statusElement = $('#user-id-status');
                    if (response.exists) {
                        statusElement.html('<span class="text-danger">이 아이디는 이미 사용 중입니다.</span>');
                    } else {
                        statusElement.html('<span class="text-success">사용 가능한 아이디입니다.</span>');
                    }
                },
                error: function() {
                    alert('중복 확인 중 오류가 발생했습니다.');
                }
            });
        });
    });
</script>

@endsection
</body>
</html>
