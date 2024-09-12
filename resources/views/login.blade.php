<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, max-age=0">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>로그인</title>
    <style>
        html,
        body {
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
                        <input type="text" class="form-control" id="user_id" name="user_id"
                               autocomplete="off" required placeholder="아이디"
                               value="{{ old('user_id', Cookie::get('user_id')) }}">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">비밀번호</label>
                        <input type="password" class="form-control" id="password" name="password"
                               autocomplete="off" required placeholder="비밀번호">
                    </div>
                    <div class="mb-3 form-check">
                        <div class="d-inline-block mr-5 ml-4">
                            <input type="checkbox" class="form-check-input" id="save_id"
                                   name="save_id" {{ Cookie::get('user_id') ? 'checked' : '' }}>
                            <label class="form-check-label" for="save_id">아이디 저장</label>
                        </div>
                        <div class="d-inline-block ml-5">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">자동 로그인</label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">로그인</button>
                    <a href="/join" class="btn btn-secondary btn-block">회원가입</a>
                </form>

                <!-- 아이디 찾기, 비밀번호 찾기 -->
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

        <!-- 로그인 에러 알림 -->
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
