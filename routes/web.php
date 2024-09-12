<?php

use App\Http\Controllers\BoardController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckAuth;
use App\Http\Middleware\PreventBackHistory;
use Illuminate\Support\Facades\Route;

// 로그인 세션
Route::group(['middleware' => [PreventBackHistory::class]], function() {
    Route::get('/', [UserController::class, 'loginform'])->name('login.form');
    Route::post('/login', [UserController::class, 'login'])->name('login');
});


// 공개 페이지 (미들웨어 없음)
Route::post('/register', [UserController::class, 'register'])->name('register');
Route::view('/findId', 'findId');
Route::post('/find-id', [UserController::class, 'findId'])->name('findId');
Route::view('/findPassword', 'findPassword');
Route::post('/find-Password', [UserController::class, 'findPassword'])->name('findPassword');
Route::post('/password/update', [UserController::class, 'updatePassword'])->name('updatePassword');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

// CheckAuth와 PreventBackHistory 미들웨어를 묶은 그룹
Route::middleware([CheckAuth::class, PreventBackHistory::class])->group(function() {
    // 게시판 관련 라우트
    Route::get('/boardList', [BoardController::class, 'boardlist'])->name('boardList');
    Route::get('/insertboard', [BoardController::class, 'showInsertForm'])->name('boards.create');
    Route::post('/insertboard', [BoardController::class, 'insertBoard'])->name('boards.insert');
    Route::get('/board/{id}', [BoardController::class, 'showBoard'])->name('boards.show');
    Route::get('/boards/{id}/edit', [BoardController::class, 'edit'])->name('boards.edit');
    Route::put('/boards/{id}', [BoardController::class, 'update'])->name('boards.update');
    Route::delete('/boards/{id}', [BoardController::class, 'deleteBoard'])->name('boards.delete');

    // 일정 관련 라우트
    Route::get('/schedule', [ScheduleController::class, 'scheduleList'])->name('schedule');
    Route::post('/schedule', [ScheduleController::class, 'insertSchedule'])->name('schedule');
    Route::get('/scheduleList', [ScheduleController::class, 'scheduleLists'])->name('scheduleList');
    Route::get('/insertsch', [ScheduleController::class, 'showInsertForm'])->name('sch.create');
    Route::post('/insertsch', [ScheduleController::class, 'insertSchedule'])->name('sch.insert');
    Route::get('/schedule/{sch_id}', [ScheduleController::class, 'showSchedule'])->name('schedules.show');
    Route::get('/schedule/{sch_id}/editschedule', [ScheduleController::class, 'editSchedule'])->name('schedules.edit');
    Route::put('/schedule/{sch_id}', [ScheduleController::class, 'updateSchedule'])->name('schedules.update');
    Route::delete('/schedule/{sch_id}', [ScheduleController::class, 'deleteSchedule'])->name('schedules.delete');

    // 댓글 관련 라우트
    Route::post('/insertcomment', [BoardController::class, 'Insertcomment'])->name('comment.insert');
    Route::put('/comments/update/{id}', [BoardController::class, 'updatecomment'])->name('comment.update');
    Route::delete('/comment/delete/{id}', [BoardController::class, 'deleteComments'])->name('comment.delete');
});

// 다운로드 라우트 (CheckAuth 필요 없음)
Route::get('/file/download/{id}', [BoardController::class, 'downloadFile'])->name('file.download');
