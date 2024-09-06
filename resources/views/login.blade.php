<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, max-age=0">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>로그인</title>
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            overflow: hidden;
            /* 스크롤이 생기지 않도록 설정 */
        }

        .container {
            height: 100vh;
            /* 전체 화면 높이를 차지 */
            display: flex;
            align-items: center;
            /* 수직으로 중앙 정렬 */
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
</head>

<body>
    @extends('layouts.loginHeader')
    @section('title', '로그인')
    @section('content')
        <div class="container ml-5">
            <div class="card p-4">
                <div class="text-center mb-4">
                    <h3>로그인</h3>
                </div>
                <form action="{{ route('login') }}" method="POST" id="loginForm">
                    @csrf
                    <div class="mb-3">
                        <label for="user_id" class="form-label">아이디</label>
                        <input type="text" class="form-control" id="user_id" name="user_id" autocomplete="off" required
                            placeholder="아이디">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">비밀번호</label>
                        <input type="password" class="form-control" id="password" name="password" autocomplete="off"
                            required placeholder="비밀번호">
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
                    <a href="/join" class="btn btn-secondary btn-block">회원가입</a>
                </form>

                <!-- 아이디 찾기, 비밀번호 찾기, 회원가입 -->
                <div class="link-group mt-3">
                    <a href="/findId" class="text-decoration-none">아이디 찾기</a>
                    <a href="/findPassword" class="text-decoration-none">비밀번호 찾기</a>
                </div>
                @if ($errors->any())
                    <div class="alert alert-danger mt-3 small-text">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // 서버에 로그인 상태를 확인
                fetch('/check-login-status')
                    .then(response => response.json())
                    .then(data => {
                        if (data.loggedIn) {
                            // 로그인 상태일 때 SweetAlert로 알림을 띄우고 다른 페이지로 리디렉션
                            Swal.fire({
                                title: '이미 로그인 되어 있습니다',
                                text: '다른 페이지로 이동합니다.',
                                icon: 'info',
                                timer: 2000, // 2초 후 자동으로 리디렉션
                                timerProgressBar: true,
                                didClose: () => {
                                    window.location.replace('/boardList');
                                }
                            });
                        }
                    });
            });
        </script>
        <!-- Error Alert -->
        @if (session('error'))
            <script>
                Swal.fire({
                    icon: 'error',
                    title: '오류',
                    text: "{{ session('error') }}",
                });
            </script>
        @endif
    @endsection

</body>

</html>
