@extends('layouts.header')

@section('title', '게시판 등록')

@section('content')
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
                        <label for="category" class="form-label">카테고리 선택</label>
                        <select class="form-control" id="category" name="category">
                            <option value="게시판">게시판</option>
                            <option value="일정관리">일정관리</option>
                        </select>
                    </div>
                    
                    <!-- 날짜 선택 필드 추가 -->
                    <div class="mb-3" id="dateFields" style="display: none;"> <!-- 처음에는 숨겨진 상태 -->
                        <label for="start_date" class="form-label">시작 날짜</label>
                        <input type="date" class="form-control" id="start_date" name="start_date">

                        <label for="end_date" class="form-label mt-2">종료 날짜</label>
                        <input type="date" class="form-control" id="end_date" name="end_date">
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

    <!-- JavaScript 추가 -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const categorySelect = document.getElementById('category');
            const dateFields = document.getElementById('dateFields');
            const formTitle = document.getElementById('formTitle'); // 제목 요소

            // URL에서 쿼리 파라미터 읽기
            const urlParams = new URLSearchParams(window.location.search);
            const category = urlParams.get('category');
            const startDate = urlParams.get('start');
            const endDate = urlParams.get('end');

            // 카테고리가 '일정관리'로 설정되었을 때 자동 선택 및 필드 표시
            if (category === '일정관리') {
                categorySelect.value = '일정관리';
                dateFields.style.display = 'block'; // 날짜 필드를 표시
                formTitle.textContent = '일정 등록'; // 제목을 '일정 등록'으로 변경
                
                // 날짜 필드에 값 설정
                if (startDate) {
                    document.getElementById('start_date').value = startDate.split('T')[0];
                }
                if (endDate) {
                    document.getElementById('end_date').value = endDate.split('T')[0];
                }
            }

            // 카테고리 선택시 이벤트 핸들러 등록
            categorySelect.addEventListener('change', function() {
                if (this.value === '일정관리') {
                    dateFields.style.display = 'block'; // '일정관리' 선택시 날짜 필드를 표시
                    formTitle.textContent = '일정 등록'; // 제목을 '일정 등록'으로 변경
                } else {
                    dateFields.style.display = 'none'; // 다른 카테고리 선택시 날짜 필드를 숨김
                    formTitle.textContent = '게시판 등록'; // 제목을 '게시판 등록'으로 변경
                }
            });
        });
    </script>
@endsection
