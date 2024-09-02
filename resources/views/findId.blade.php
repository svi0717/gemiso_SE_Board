<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>아이디 찾기</title>
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

@section('title', '아이디 찾기')

@section('content')
<div class="container ml-5">
    <div class="card p-4">
        <div class="text-center mb-4">
            <h4>아이디 찾기</h4>
        </div>
        <form action="{{ route('findId') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">이름</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">전화번호</label>
                <input type="text" class="form-control" id="phone" name="phone" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">아이디 찾기</button>
        </form>
    </div>
</div>
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
