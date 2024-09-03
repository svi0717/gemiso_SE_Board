<?php

use App\Http\Controllers\BoardController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/schedule', [ScheduleController::class, 'scheduleList'])->name('schedule');
Route::post('/schedule', [BoardController::class, 'insertBoard'])->name('schedule');

Route::get('/editboard', function () {
    return view('editboard');
});

// 게시판 목록을 보여주는 라우트
Route::get('/boardList', [BoardController::class, 'boardlist'])->name('boardList');

// 게시판 등록 폼을 보여주는 라우트
Route::get('/insert', [BoardController::class, 'showInsertForm'])->name('boards.create');

// 폼에서 전송된 데이터를 처리하여 데이터베이스에 저장하는 라우트
Route::post('/insert', [BoardController::class, 'insertBoard'])->name('boards.insert');

// 게시글 조회 라우트
Route::get('/board/{id}', [BoardController::class, 'showBoard'])->name('boards.show');

// 스케줄 조회 라우트
Route::get('/schedule/{sch_id}', [ScheduleController::class, 'showSchedule'])->name('schedules.show');

// 게시글 수정 라우트
Route::put('/boards/{id}', [BoardController::class, 'update'])->name('boards.update');

// 게시물 조회, 수정 화면, 삭제 라우트
Route::get('/boards/{id}/edit', [BoardController::class, 'edit'])->name('boards.edit');
Route::delete('/boards/{id}', [BoardController::class, 'deleteBoard'])->name('boards.delete');

// 스케줄 수정 라우트
Route::get('/schedule/{sch_id}/editschedule', [ScheduleController::class, 'editSchedule'])->name('schedules.edit');
Route::put('/schedule/{sch_id}', [ScheduleController::class, 'updateSchedule'])->name('boards.update');

Route::get('/boardview', function () {
    return view('boardview');
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

// 회원가입 페이지
Route::get('/join', function () {
    return view('join');
});

// 회원가입 POST 요청
Route::post('/register', [UserController::class, 'register'])->name('register');

// 로그인 페이지
Route::get('/', function () {
    return view('login');
})->name('login.form');

// 로그인 POST 요청
Route::post('/login', [UserController::class, 'login'])->name('login');

// 로그아웃 POST 요청
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

// 아이디 중복확인
Route::get('/check-user-id', [UserController::class, 'checkUserId']);

// 아이디 찾기 POST 요청
Route::post('/find-id', [UserController::class, 'findId'])->name('findId');

// 아이디 찾기 완료
Route::get('/findIdCompleted', [UserController::class, 'findIdCompleted'])->name('findIdCompleted');

// 비밀번호 찾기 요청을 처리하는 POST 요청
Route::post('/find-Password', [UserController::class, 'findPassword'])->name('findPassword');

// 비밀번호 변경 처리
Route::post('/password/update', [UserController::class, 'updatePassword'])->name('updatePassword');

// 비밀번호 찾기 완료 페이지
Route::get('/findPasswordCompleted', [UserController::class, 'findPasswordCompleted'])->name('findPasswordCompleted');
