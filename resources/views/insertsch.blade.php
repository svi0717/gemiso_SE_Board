<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>일정 등록</title>
</head>
<body>
    @extends('layouts.header')

@section('title', '일정 등록')

@section('content')
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<!-- Include Summernote CSS for Bootstrap 4 -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>

<!-- Include Popper.js for Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

<!-- Include Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

<!-- Include Summernote JS for Bootstrap 4 -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/lang/summernote-ko-KR.min.js"></script>
    <div class="container mt-5">
        <div class="row mb-4">
            <div class="col-12 centered-form">
                <h3 class="text-center" id="formTitle">일정 등록</h3>

                <p>작성자: {{ Auth::user()->name }}</p>

                <form action="{{ route('sch.insert') }}" method="POST">
                    @csrf
                    <label for="category" class="form-label">게시판 선택</label>
                    <select class="form-control" id="category" name="board_id">
                        <option value="" selected>게시판 선택 (선택하지 않으면 일정만 등록됩니다)</option>
                        @if($boards->isNotEmpty())
                            @foreach ($boards as $board)
                                <option value="{{ $board->board_id }}">{{ $board->title }}</option>
                            @endforeach
                        @else
                            <option value="">게시판이 없습니다</option>
                        @endif
                    </select>
                    <label for="board" class="form-label mt-3" id="boardLabel" style="display:none;">게시판 제목</label>

                    <input type="hidden" name="previous_url" value="{{ request()->get('previous_url', url('/schedule')) }}">

                    <div class="mb-3" id="dateFields">
                        <label for="start_date" class="form-label">시작 날짜</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" value="{{ request()->get('start_date') }}">

                        <label for="end_date" class="form-label mt-2">종료 날짜</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" value="{{ request()->get('end_date') }}">
                    </div>

                    <div class="mb-3">
                        <label for="title" class="form-label">제목</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="제목" required>
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label">내용</label>
                        <textarea id="summernote" name="content" class="form-control" rows="10" required></textarea>
                    </div>
                    <input type="hidden" name="user_id" value="{{ $userId }}">
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">등록</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 오늘 날짜를 기준으로 어제 날짜는 선택하지 못하도록 설정
            const today = new Date();
            const minDate = today.toISOString().split('T')[0];

            // 날짜 입력 필드에 최소 날짜 설정
            document.getElementById('start_date').setAttribute('min', minDate);
            document.getElementById('end_date').setAttribute('min', minDate);

            // 페이지 로드 후 종료 날짜 조정
            const endDateInput = document.getElementById('end_date');
            const endDateValue = endDateInput.value;

            if (endDateValue) {
                const endDate = new Date(endDateValue);
                endDate.setDate(endDate.getDate() - 1);
                const eDate = endDate.toISOString().split('T')[0];
                endDateInput.value = eDate;
            }

            // 카테고리 선택에 따라 게시판 드롭다운 표시
            const categorySelect = document.getElementById('category');
            const boardSelect = document.getElementById('board');
            const boardLabel = document.getElementById('boardLabel');

            // 초기 상태 설정
            if (categorySelect.value === '제목') {
                boardSelect.style.display = 'block';
                boardLabel.style.display = 'block';
            } else {
                boardSelect.style.display = 'none';
                boardLabel.style.display = 'none';
            }

            // 카테고리 변경 이벤트 리스너 추가
            categorySelect.addEventListener('change', function() {
                if (this.value === '제목') {
                    boardSelect.style.display = 'block';
                    boardLabel.style.display = 'block';
                } else {
                    boardSelect.style.display = 'none';
                    boardLabel.style.display = 'none';
                }
            });
        });
        $(document).ready(function() {
        $('#summernote').summernote({
            placeholder: '내용을 작성하세요',
            height: 300,
            maxHeight: 300,
            lang: 'ko-KR'
        });

        // 폼 제출 전에 Summernote 내용을 textarea에 동기화
        $('form').on('submit', function() {
            var summernoteContent = $('#summernote').summernote('code');
            $('#summernote').val(summernoteContent);
        });
    });
    </script>

@endsection

</body>
</html>

