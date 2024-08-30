<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BoardController;

Route::get('/', function () {
    return view('login');
});

Route::get('/schedule', function () {
    return view('schedule');
});

Route::get('/editboard', function () {
    return view('editboard');
});

// 게시판 목록을 보여주는 라우트
Route::get('/boardlist', [BoardController::class, 'boardlist'])->name('boardlist');

// 게시판 등록 폼을 보여주는 라우트
Route::get('/insert', [BoardController::class, 'showInsertForm'])->name('boards.create');

// 폼에서 전송된 데이터를 처리하여 데이터베이스에 저장하는 라우트
Route::post('/insert', [BoardController::class, 'insertBoard'])->name('boards.insert');

// 게시글 상세보기 라우트 추가
Route::get('/board/{id}', [BoardController::class, 'show'])->name('boards.show');

// 수정
Route::get('/board/{id}/edit', [BoardController::class, 'edit'])->name('boards.edit');

// 삭제
Route::delete('/board/{id}/delete', [BoardController::class, 'deleteBoard'])->name('boards.delete');

Route::get('/boardview', function () {
    return view('boardview');
});

Route::get('/join', function () {
    return view('join');
});

Route::get('/findId', function () {
    return view('findId');
});

Route::get('/findPassword', function () {
    return view('findPassword');
});

Route::get('/findIdCompleted', function () {
    return view('findIdCompleted');
});

Route::get('/findPasswordCompleted', function () {
    return view('findPasswordCompleted');
});
