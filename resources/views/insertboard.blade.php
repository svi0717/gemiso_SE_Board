<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>게시판 등록</title>
</head>
<body>
@extends('layouts.header')

@section('title', '게시판 등록')

@section('content')

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
    //     const fileInput = document.getElementById("formFileMultiple");
    //    // 또는 const fileInput = $("#fileUpload").get(0);

    //     fileInput.onchange = () => {
    //     const selectedFile = [...fileInput.files];
    //     console.log(selectedFile);

    //     };

    $(document).ready(function() {
        $('#summernote').summernote({
            placeholder: '내용을 작성하세요',
            height: 300,
            maxHeight: 300,
            lang: 'ko-KR',
        });
        // 폼 제출 전에 Summernote 내용을 textarea에 동기화
        $('form').on('submit', function() {
            console.log($('form'));
            var summernoteContent = $('#summernote').summernote('code');
            // $('#summernote').val(summernoteContent);
        });
    });
    </script>
@endsection

</body>
</html>

