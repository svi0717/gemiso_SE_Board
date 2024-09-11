<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게시판 목록</title>
</head>
<link href="{{ asset('css/custom-buttons.css') }}" rel="stylesheet">
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
    .btn-disabled {
        pointer-events: none;
        opacity: 0.5;
    }
</style>

<body>
@extends('layouts.header')

@section('title', '게시판 목록')

@section('content')
    <div class="container mt-5">
        <div class="row mb-4">
            <strong>
                <div>목록</div>
            </strong>
            <div class="col-md-12">
                <form class="form-inline" method="GET" action="{{ route('boardList') }}">
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
                    <button type="submit" class="btn-custom">검색</button>
                </form>
            </div>
        </div>
        <table class="table">
            <thead class="table-header">
                <tr>
                    <th style="width: 100px;">번호</th>
                    <th style="width: 100px;">일정 유무</th>
                    <th style="width: 300px;">제목</th>
                    <th style="width: 150px;">작성자</th>
                    <th>등록일자</th>
                    <th>수정일자</th>
                    <th>조회수</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($board as $item)
                <tr>
                    <td>{{ ($board->currentPage() - 1) * $board->perPage() + $loop->iteration }}</td>
                    <td>
                        @php
                            // 게시판에 연동된 일정이 있는지 확인
                            $hasSchedules = DB::table('gemiso_se.schedule')
                                ->where('board_id', $item->board_id)
                                ->exists();
                        @endphp
                        @if($hasSchedules) <!-- 연동된 일정이 있는 경우 -->
                            <input type="checkbox" checked disabled>
                        @else
                            <input type="checkbox" disabled>
                        @endif
                    </td>
                    <td>
                        <!-- 제목을 클릭하면 게시글 상세 페이지로 이동 -->
                        <a href="{{ route('boards.show', ['id' => $item->board_id]) }}">{{ $item->title }}</a>
                    </td>
                    <td>{{ $item->user_name }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->reg_date)->format('Y-m-d') }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->upd_date)->format('Y-m-d') }}</td>
                    <td>{{ $item->views }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="text-right">
            <a href="/insertboard" class="btn-custom">등록</a>
        </div>
        <nav class="fixed-bottom-pagination">
            <ul class="pagination justify-content-center">
                {{ $board->links('vendor.pagination.custom') }}
            </ul>
        </nav>
    </div>
@endsection
</body>
</html>
