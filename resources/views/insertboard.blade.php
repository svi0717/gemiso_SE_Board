@extends('layouts.header')

@section('title', '게시판 등록')

@section('content')
    <!-- include libraries(jQuery, bootstrap) -->
    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.css" rel="stylesheet">
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.js"></script>

    <!-- include summernote css/js-->
    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.css" rel="stylesheet">
    <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/lang/summernote-ko-KR.min.js"></script>

    <link href="{{ asset('css/custom-buttons.css') }}" rel="stylesheet">
    <div class="container mt-5">
        <div class="row mb-4">
            <div class="col-12 centered-form">
                <h3 class="text-center" id="formTitle">게시판 등록</h3>
                <p>작성자: {{ Auth::user()->name }}</p>

                <form action="{{ route('boards.insert') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">제목</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="제목" required>
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label">내용</label>
                        <!-- Summernote 에디터를 사용하는 textarea -->
                        <textarea id="summernote" name="content" class="form-control" rows="10" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="formFileMultiple" class="form-label" >파일 등록</label>
                        <input class="form-control" type="file" id="formFileMultiple" name="files[]" multiple>
                    </div>
                    <!-- 사용자 ID를 hidden input으로 전달 -->
                    <input type="hidden" name="user_id" value="{{ $userId }}">
                    <div class="text-right">
                        <button type="submit" class="btn-custom">등록</button>
                        <!-- <button type="button" class="btn-custom" >등록</button> -->
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
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
