<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게시판 목록</title>
</head>
<style>
    .col-md-12 {
        margin-left: 315px;
    }
    .table-header {
        background-color: #f8f9fa;
    }
    .table tbody tr:last-child {
        border-bottom: 2px solid #dee2e6; 
    }

    table a {
        color: black !important;
    }

    .table {
        table-layout: auto; 
        text-align: center; 
    }
</style>
<body>
@extends('layouts.header')

@section('title', '게시판 목록')

@section('content')
    <div class="container mt-5">
        <div class="row mb-4">
            <strong>
                <div>게시판 목록</div>
            </strong>
            <div class="col-md-12">
            <form class="form-inline" method="GET" action="{{ route('boardlist') }}">
                <div class="form-group mr-2">
                    <input type="date" class="form-control" id="startDate" name="start_date">
                </div>
                <div class="form-group mr-2">
                    <label for="endDate" class="mr-2">~</label>
                    <input type="date" class="form-control" id="endDate" name="end_date">
                </div>
                <div class="form-group mr-2">
                    <label for="searchQuery" class="mr-2">검색</label>
                    <input type="text" class="form-control" id="searchQuery" name="search" placeholder="검색어 입력" value="{{ request()->query('search') }}">
                </div>
                <button type="submit" class="btn btn-primary">검색</button>
            </form>
            </div>
        </div>
        <table class="table">
            <thead class="table-header">
                <tr>
                    <th style="width: 90px;">번호</th>
                    <th style="width: 400px;">제목</th>
                    <th style="width: 150px;">작성자</th>
                    <th>등록일자</th>
                    <th>수정일자</th>
                    <th>조회수</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($board as $item)
                <tr>
                    <td>{{ $item->board_id }}</td>
                    <td>
                        <!-- 제목을 클릭하면 게시글 상세 페이지로 이동 -->
                        <a href="{{ route('boards.show', ['id' => $item->board_id]) }}">{{ $item->title }}</a>
                    </td>
                    <td>{{ $item->user_name }}</td>
                    <td>{{ $item->reg_date }}</td>
                    <td>{{ $item->upd_date }}</td>
                    <td>{{ $item->views }}</td>
                </tr>
                @endforeach
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
