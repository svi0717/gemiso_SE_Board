<style>
    .table a {
        color: black !important;
    }

    .card-title-container {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
    }

    .card-title {
        padding: 10px;
        font-size: 1.25rem;
        margin-bottom: 5px;
    }

    .card-header {
        background-color: #f8f9fa;
        font-weight: bold;
        padding: 10px 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
</style>
<link href="{{ asset('css/custom-buttons.css') }}" rel="stylesheet">
@extends('layouts.header')

@section('title', '게시물 조회')

@section('content')
    <div class="container mt-5">
        <div class="row mb-4">
            <div class="col-12 centered-form">
                <div class="card">
                    <div class="card-header">
                        게시물 조회
                        <div class="d-flex flex-column align-items-end">
                            <div class="date-view" id="current_date"></div>
                        </div>
                    </div>
                    <div class="card-title-container">
                        <div class="card-title p-3">제목: {{ $post->title }}</div>
                        <div class="text-muted p-3">작성자: {{ $post->user_name }}</div>
                    </div>
                    <div class="card-body content-layout">
                        <!-- 게시물 내용 -->
                        <div class="content">{!! $post->content !!}</div>
                        @if (count($files) > 0)
                            <h5 class="mt-4">첨부 파일</h5>
                            <ul>
                                @foreach ($files as $file)
                                    <li>
                                        <a href="{{ route('file.download', $file->id) }}">{{ $file->file_name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p>첨부 파일이 없습니다.</p>
                        @endif
                    </div>

                    <div class="card-footer text-right">
                        <a href="/boardList" class="btn-custom">목록</a>
                        @if ($userId == $post->user_id)
                            <a href="{{ route('boards.edit', ['id' => $post->board_id]) }}" class="btn btn-secondary">수정</a>
                            <form action="{{ route('boards.delete', $post->board_id) }}" method="POST"
                                style="display: inline;" onsubmit="return confirm('정말 삭제하시겠습니까?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">삭제</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- 게시물과 연동된 일정 목록 -->
        <div class="row mt-4">
            <div class="col-12 centered-form">
                <div class="card">
                    <div class="card-header">
                        일정 목록
                    </div>
                    <div class="card-body">
                        @if ($schedules->isEmpty())
                            <p>일정이 없습니다.</p>
                        @else
                            <table class="table table-bordered table-striped text-center">
                                <thead>
                                    <tr>
                                        <th>번호</th>
                                        <th style="width: 40%;">제목</th>
                                        <th>작성자</th>
                                        <th>등록일자</th>
                                        <th>시작일자</th>
                                        <th>종료일자</th>
                                    </tr>
                                </thead>
                                <tbody id="scheduleTableBody">
                                    @foreach ($schedules as $item)
                                        <tr class="schedule-row">
                                            <td>{{ $loop->iteration }}</td>
                                            <td class="text-truncate" style="max-width: 250px;">
                                                <a
                                                    href="{{ route('schedules.show', $item->sch_id) }}?previous_url={{ urlencode(route('schedule')) }}">{{ $item->title }}</a>
                                            </td>
                                            <td>{{ $post->user_name }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->reg_date)->format('Y-m-d') }}</td>
                                            <td>{{ $item->start_date }}</td>
                                            <td>{{ $item->end_date }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-center">
                                <button id="loadMoreBtn" class="btn btn-primary mt-2" style="display: none;">더보기</button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const scheduleRows = document.querySelectorAll('.schedule-row');
        const loadMoreBtn = document.getElementById('loadMoreBtn');
        const maxrow = 4; // 처음에 표시할 행 수

        // 초기 표시 설정
        scheduleRows.forEach((row, index) => {
            if (index >= maxrow) {
                row.style.display = 'none';
            }
        });

        // 더보기 버튼이 필요할 때만 표시
        if (scheduleRows.length > maxrow) {
            loadMoreBtn.style.display = 'block';
        }

        // 더보기 버튼 클릭 시
        loadMoreBtn.addEventListener('click', () => {
            // 모든 행을 표시
            scheduleRows.forEach((row) => {
                row.style.display = '';
            });

            // 버튼 숨기기
            loadMoreBtn.style.display = 'none';
        });

        // 현재 날짜 표시
        const date = new Date();
        const year = date.getFullYear();
        const month = ('0' + (date.getMonth() + 1)).slice(-2);
        const day = ('0' + date.getDate()).slice(-2);
        document.getElementById("current_date").innerHTML = year + "-" + month + "-" + day;
    </script>
@endsection
