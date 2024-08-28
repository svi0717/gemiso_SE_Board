<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게시판 목록</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
</head>
<style>
    .col-md-12 {
        margin-left: 315px;

    }
    .table-header {
        background-color: #f8f9fa;
    }
      .table tbody tr:last-child {
            border-bottom: 2px solid #dee2e6; /* Light gray border for the last row */
        }
</style>
<body>
@extends('layouts.header')

@section('title', '게시판 목록')

@section('content')
    <div class="container mt-5">
        <div class="row mb-4">
            <div class="col-md-12">
                <form class="form-inline">
                    <div class="form-group mr-2">
                        <input type="date" class="form-control" id="startDate">
                    </div>
                    <div class="form-group mr-2">
                        <label for="endDate" class="mr-2">~</label>
                        <input type="date" class="form-control" id="endDate">
                    </div>
                    <div class="form-group mr-2">
                        <label for="searchQuery" class="mr-2">검색</label>
                        <input type="text" class="form-control" id="searchQuery" placeholder="검색어 입력">
                    </div>
                    <button type="submit" class="btn btn-primary">검색</button>
                </form>
            </div>
            
        </div>

        <!-- Table -->
        <table class="table">
            <thead class="table-header">
                <tr>
                    <th>번호</th>
                    <th>제목</th>
                    <th>작성자</th>
                    <th>내용</th>
                    <th>등록일자</th>
                    <th>작성일자</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>안녕하세요</td>
                    <td>신준수</td>
                    <td>테스트입니다</td>
                    <td>2024.08.12</td>
                    <td>2024.08.25</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>안녕하세요</td>
                    <td>김영희</td>
                    <td>테스트 내용</td>
                    <td>2024.08.13</td>
                    <td>2024.08.26</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>안녕하세요</td>
                    <td>김영희</td>
                    <td>테스트 내용</td>
                    <td>2024.08.13</td>
                    <td>2024.08.26</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>안녕하세요</td>
                    <td>김영희</td>
                    <td>테스트 내용</td>
                    <td>2024.08.13</td>
                    <td>2024.08.26</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>안녕하세요</td>
                    <td>김영희</td>
                    <td>테스트 내용</td>
                    <td>2024.08.13</td>
                    <td>2024.08.26</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>안녕하세요</td>
                    <td>김영희</td>
                    <td>테스트 내용</td>
                    <td>2024.08.13</td>
                    <td>2024.08.26</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>안녕하세요</td>
                    <td>김영희</td>
                    <td>테스트 내용</td>
                    <td>2024.08.13</td>
                    <td>2024.08.26</td>
                </tr>
            </tbody>
        </table>

        <div class="text-right">
            <a href="/insert" class="btn btn-primary">등록</a>
        </div>
        <nav>
            <ul class="pagination justify-content-center">
                <li class="page-item">
                    <a class="page-link" href="#" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="#" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
@endsection
</body>
</html>
