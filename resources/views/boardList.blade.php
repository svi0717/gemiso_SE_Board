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
            <Strong>
                <div>게시판 목록</div>
            </Strong>
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
        <table class="table">
            <thead class="table-header">
                <tr>
                    <th style="width: 90px;">번호</th>
                    <th style="width: 400px;">제목</th>
                    <th style="width: 150px;">작성자</th>
                    <th>등록일자</th>
                    <th>수정일자</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>
                        <a href="/boardview">안녕하세요</a>
                    </td>
                    <td>신준수</td>
                    <td>2024.08.12</td>
                    <td>2024.08.25</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>안녕하세요</td>
                    <td>김영희</td>
                    <td>2024.08.13</td>
                    <td>2024.08.26</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>안녕하세요</td>
                    <td>김영희</td>
                    <td>2024.08.13</td>
                    <td>2024.08.26</td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>안녕하세요</td>
                    <td>김영희</td>
                    <td>2024.08.13</td>
                    <td>2024.08.26</td>
                </tr>
                <tr>
                    <td>5</td>
                    <td>안녕하세요</td>
                    <td>김영희</td>
                    <td>2024.08.13</td>
                    <td>2024.08.26</td>
                </tr>
                <tr>
                    <td>6</td>
                    <td>안녕하세요</td>
                    <td>김영희</td>
                    <td>2024.08.13</td>
                    <td>2024.08.26</td>
                </tr>
                <tr>
                    <td>7</td>
                    <td>안녕하세요</td>
                    <td>김영희</td>
                    <td>2024.08.13</td>
                    <td>2024.08.26</td>
                </tr>
                <tr>
                    <td>8</td>
                    <td>안녕하세요</td>
                    <td>김영희</td>
                    <td>2024.08.13</td>
                    <td>2024.08.26</td>
                </tr>
                <tr>
                    <td>9</td>
                    <td>안녕하세요</td>
                    <td>김영희</td>
                    <td>2024.08.13</td>
                    <td>2024.08.26</td>
                </tr>
                <tr>
                    <td>10</td>
                    <td>안녕하세요</td>
                    <td>김영희</td>
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
