<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>헤더와 사이드바 예제</title>

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">

    <script src="{{ asset('js/buttons.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

    <!-- Include Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <!-- Include Summernote JS for Bootstrap 4 -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/lang/summernote-ko-KR.min.js"></script>

    <link href="{{ asset('css/custom-buttons.css') }}" rel="stylesheet">

    <style>
        .btn-custom {
        font-size: 20px; /* 버튼 글씨 크기 조정 */
        padding: 10px 20px; /* 버튼 패딩 조정 */
        width: 60%; /* 버튼의 폭을 컨테이너에 맞춤 */
        text-align: center; /* 버튼 텍스트 가운데 정렬 */
        }

        .sidebar {
            margin-top: 180px;
        }

        .content {
            margin-top: 20px; /* 콘텐츠를 아래로 내리는 여백 조정 */
        }

        .row {
            margin-left: 0; /* 좌우 여백 제거 */
            margin-right: 0; /* 좌우 여백 제거 */
        }

        .sidebar div {
            margin-bottom: 20px; /* 버튼 간의 위아래 간격 조정 */
        }
        .custom-navbar{
            background-color: #2BA8E0;
        }
    </style>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark custom-navbar">
            <a class="navbar-brand" href="{{ auth()->check() ? '/boardList' : '/' }}">Gemiso SE</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ml-auto">
                    @auth
                        <li class="nav-item">
                            <div class="nav-link text-white" href="#">{{ Auth::user()->name }}</div>
                        </li>
                        <li class="nav-item">
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                            <a class="nav-link text-white" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">로그아웃</a>
                        </li>
                        @else
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('login.form') }}">로그인</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </nav>
    </header>

    <main class="container col-md-10 mt-4">
        <div class="row">
            <!-- 사이드바 -->
            <div class="col-md-2 sidebar" id="sidebar-button"></div>
            <br>

            <!-- 콘텐츠 -->
            <div class="col-md-8 content">
                @yield('content')
            </div>
        </div>
    </main>
</body>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        addButtonsToPage();
    });
</script>
</html>
