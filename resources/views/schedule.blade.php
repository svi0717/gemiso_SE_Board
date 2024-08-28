<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gemiso SE</title>
    <script src="{{ asset('js/buttons.js') }}" defer></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ time() }}">
</head>
<body>
    <div class="header">
        <h1>Gemiso SE</h1>
        <div class="username">
            <span>사용자 명</span>
        </div>
    </div>
    <div class="container">
        <div class="sidebar">
        <div id="sidebar-button"></div>
        </div>

        <div class="content">
           
        </div>
    </div>
    <script>
        // 페이지 로드 후 버튼 추가
        document.addEventListener('DOMContentLoaded', function() {
            addButtonsToPage();
        });
    </script>
</body>
</html>
