@extends('layouts.header')

@section('title', '게시판 등록')

@section('content')
    <div class="container mt-5">
        <div class="row mb-4">
            <div class="col-12 centered-form">
                <h3 class="text-center">게시판 등록</h3>
                <!-- 작성자 이름 표시 -->
                <p>작성자: {{ $userName }}</p>
                
                <form action="{{ route('boards.insert') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="category" class="form-label">카테고리 선택</label>
                        <select class="form-control" id="category" name="category">
                            <option value="게시판">게시판</option>
                            <option value="일정관리">일정관리</option>
                        </select>
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
                        <button type="submit" class="btn btn-primary">등록</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
