<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>회원가입</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script>
        // 전역 변수로 중복 확인 상태 저장
        let isUserIdChecked = false;

        function validateForm() {
            const userId = document.getElementById('user_id').value;
            const password = document.getElementById('password').value;
            const passwordCheck = document.getElementById('passwordCheck').value;
            const name = document.getElementById('name').value;
            const department = document.getElementById('department').value;
            const phone = document.getElementById('phone').value;
            const userIdError = document.getElementById('user_id_error');

            let isValid = true;
            let errorMessage = "";

            // 아이디 유효성 검사
            if (userId === "") {
                errorMessage = "아이디를 입력해 주세요.";
                isValid = false;
            } else if (!isUserIdChecked) {
                errorMessage = "중복 확인을 해주세요.";
                isValid = false;
            } else if (password === "") {
                // 비밀번호 유효성 검사
                errorMessage = "비밀번호를 입력해 주세요.";
                isValid = false;
            } else if (password !== passwordCheck) {
                // 비밀번호 확인 유효성 검사
                errorMessage = "비밀번호가 일치하지 않습니다.";
                isValid = false;
            } else if (name === "") {
                // 이름 유효성 검사
                errorMessage = "이름을 입력해 주세요.";
                isValid = false;
            } else if (department === "") {
                // 부서명 유효성 검사
                errorMessage = "부서명을 입력해 주세요.";
                isValid = false;
            } else if (phone === "") {
                // 전화번호 유효성 검사
                errorMessage = "전화번호를 입력해 주세요.";
                isValid = false;
            }

            if (!isValid) {
                alert(errorMessage);
            }
            return isValid;
        }

        function checkUserId() {
            const userId = document.getElementById('user_id').value;
            const userIdError = document.getElementById('user_id_error');

            if (userId) {
                fetch(`/check-user-id?user_id=${encodeURIComponent(userId)}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.exists) {
                            userIdError.textContent = '이미 사용 중인 아이디입니다.';
                            userIdError.style.color = 'red';
                            isUserIdChecked = false; // 중복 확인 실패
                        } else {
                            userIdError.textContent = '사용 가능한 아이디입니다.';
                            userIdError.style.color = 'green';
                            isUserIdChecked = true; // 중복 확인 성공
                        }
                    });
            } else {
                userIdError.textContent = '아이디를 입력해 주세요.';
                userIdError.style.color = 'red';
                isUserIdChecked = false; // 아이디 입력이 없으므로 중복 확인 실패
            }
        }

        // 페이지 로드 시 URL 파라미터 확인 및 알림 표시
        function showAlertFromUrlParams() {
            const urlParams = new URLSearchParams(window.location.search);
            const status = urlParams.get('status');

            if (status === 'success') {
                alert('회원가입에 성공하셨습니다.');
            } else if (status === 'error') {
                alert('회원가입에 실패했습니다.');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const userIdInput = document.getElementById('user_id');
            const userIdError = document.createElement('div');
            userIdError.id = 'user_id_error';
            userIdError.style.color = 'red';
            userIdInput.parentElement.appendChild(userIdError);

            showAlertFromUrlParams();
        });
    </script>
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
        <form action="{{ route('register') }}" method="POST" onsubmit="return validateForm()">
            @csrf
            <div class="mb-3">
                <label for="id" class="form-label">아이디</label>
                <input type="text" class="form-control" id="user_id" name="user_id" placeholder="아이디">
                <button type="button" class="btn btn-secondary btn-check" onclick="checkUserId()">중복 확인</button>
            </div>
            <div class="mb-3">
                <label for="Password" class="form-label">비밀번호</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="비밀번호">
            </div>
            <div class="mb-3">
                <label for="PasswordCheck" class="form-label">비밀번호 확인</label>
                <input type="password" name="password_confirmation" class="form-control" id="passwordCheck" placeholder="비밀번호 확인">
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">이름</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="이름">
            </div>
            <div class="mb-3">
                <label for="department" class="form-label">부서명</label>
                <input type="text" class="form-control" id="department" name="department" placeholder="부서명">
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">전화번호</label>
                <input type="text" class="form-control" id="phone" name="phone" placeholder="전화번호">
            </div>
            <button type="submit" class="btn btn-primary btn-block">회원가입</button>
        </form>
    </div>
</div>
@endsection
</body>
</html>
