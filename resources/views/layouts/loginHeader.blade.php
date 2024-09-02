<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header and Sidebar Example</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- SweetAlert2 라이브러리 추가 -->

    <link rel="stylesheet" href="/css/header.css">
    <script src="{{ asset('js/buttons.js') }}" defer></script>

    <style>
        .btn-custom {
            font-size: 20px;
            padding: 10px 20px;
            width: 60%;
            text-align: center;
        }

        .sidebar {
            margin-top: 180px;
        }

        .content {
            margin-top: 20px;
        }

        .row {
            margin-left: 0;
            margin-right: 0;
        }

        .sidebar div {
            margin-bottom: 20px; /* 버튼 간의 위아래 간격 조정 */
        }
    </style>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <a class="navbar-brand" href="{{ auth()->check() ? route('boardList') : '/' }}">Gemiso SE</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ml-auto">
                    @auth
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">{{ Auth::user()->name }}</a>
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

    <main class="container col-md-4">
        @yield('content')
    </main>
</body>
<script>
    document.addEventListener('DOMContentLoaded', function() {
            addButtonsToPage();
        });
</script>
</html>
