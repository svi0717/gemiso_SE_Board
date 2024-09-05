@extends('layouts.header')

@section('title', '게시판 등록')

@section('content')
<link href="{{ asset('css/custom-buttons.css') }}" rel="stylesheet">
    <div class="container mt-5">
        <div class="row mb-4">
            <div class="col-12 centered-form">
                <!-- 동적으로 변경될 제목 -->
                <h3 class="text-center" id="formTitle">게시판 등록</h3> <!-- 처음에는 '게시판 등록' -->

                <!-- 작성자 이름 표시 -->
                <p>작성자: {{ Auth::user()->name }}</p>
                
                <form action="{{ route('boards.insert') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                    </div>
                    <div class="mb-3">
                        <label for="title" class="form-label">제목</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="제목" required>
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label">내용</label>
                        <textarea class="form-control" id="content" name="content" rows="10" required></textarea>
                    </div>
                    <!-- 사용자 ID를 hidden input으로 전달 -->
                    <input type="hidden" name="user_id" value="{{ $userId }}">
                    <div class="text-right">
                        <button type="submit" class="btn-custom">등록</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
