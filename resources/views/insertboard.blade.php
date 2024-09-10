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

