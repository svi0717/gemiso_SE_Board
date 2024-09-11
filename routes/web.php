<?php

use App\Http\Controllers\BoardController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/schedule', [ScheduleController::class, 'scheduleList'])->name('schedule');
Route::post('/schedule', [BoardController::class, 'insertBoard'])->name('schedule');

Route::get('/editboard', function () {
    return view('editboard');
});

// 게시판 목록을 보여주는 라우트
Route::get('/boardList', [BoardController::class, 'boardlist'])->name('boardList');

// 일정 목록을 보여주는 라우트
Route::get('/scheduleList', [ScheduleController::class, 'scheduleLists'])->name('scheduleList');

Route::get('/file/download/{id}', [BoardController::class, 'downloadFile'])->name('file.download');

// 공개 페이지 (미들웨어 필요 없음)
Route::view('/', 'login')->name('login.form');
Route::post('/login', [UserController::class, 'login'])->name('login');
Route::post('/register', [UserController::class, 'register'])->name('register');
Route::view('/findId', 'findId');
Route::post('/find-id', [UserController::class, 'findId'])->name('findId');
Route::view('/findIdCompleted', 'findIdCompleted')->name('findIdCompleted');
Route::view('/findPassword', 'findPassword');
Route::post('/find-Password', [UserController::class, 'findPassword'])->name('findPassword');
Route::post('/password/update', [UserController::class, 'updatePassword'])->name('updatePassword');
Route::view('/findPasswordCompleted', 'findPasswordCompleted')->name('findPasswordCompleted');
Route::view('/join', 'join');


// 로그아웃 라우트
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

// 인증 미들웨어가 필요한 라우트
Route::get('/boardList', [BoardController::class, 'boardList'])
    ->middleware(\App\Http\Middleware\CheckAuth::class)
    ->name('boardList');

Route::get('/insertboard', [BoardController::class, 'showInsertForm'])
    ->middleware(\App\Http\Middleware\CheckAuth::class)
    ->name('boards.create');

Route::post('/insertboard', [BoardController::class, 'insertBoard'])
    ->middleware(\App\Http\Middleware\CheckAuth::class)
    ->name('boards.insert');

Route::get('/board/{id}', [BoardController::class, 'showBoard'])
    ->middleware(\App\Http\Middleware\CheckAuth::class)
    ->name('boards.show');

Route::get('/boards/{id}/edit', [BoardController::class, 'edit'])
    ->middleware(\App\Http\Middleware\CheckAuth::class)
    ->name('boards.edit');

Route::put('/boards/{id}', [BoardController::class, 'update'])
    ->middleware(\App\Http\Middleware\CheckAuth::class)
    ->name('boards.update');

Route::delete('/boards/{id}', [BoardController::class, 'deleteBoard'])
    ->middleware(\App\Http\Middleware\CheckAuth::class)
    ->name('boards.delete');

// 일정 관련 라우트
Route::get('/schedule', [ScheduleController::class, 'scheduleList'])
    ->middleware(\App\Http\Middleware\CheckAuth::class)
    ->name('schedule');

Route::post('/schedule', [ScheduleController::class, 'insertSchedule'])
    ->middleware(\App\Http\Middleware\CheckAuth::class)
    ->name('schedule');

Route::get('/scheduleList', [ScheduleController::class, 'scheduleLists'])
    ->middleware(\App\Http\Middleware\CheckAuth::class)
    ->name('scheduleList');

Route::get('/insertsch', [ScheduleController::class, 'showInsertForm'])
    ->middleware(\App\Http\Middleware\CheckAuth::class)
    ->name('sch.create');

Route::post('/insertsch', [ScheduleController::class, 'insertSchedule'])
    ->middleware(\App\Http\Middleware\CheckAuth::class)
    ->name('sch.insert');

Route::get('/schedule/{sch_id}', [ScheduleController::class, 'showSchedule'])
    ->middleware(\App\Http\Middleware\CheckAuth::class)
    ->name('schedules.show');

Route::get('/schedule/{sch_id}/editschedule', [ScheduleController::class, 'editSchedule'])
    ->middleware(\App\Http\Middleware\CheckAuth::class)
    ->name('schedules.edit');

Route::put('/schedule/{sch_id}', [ScheduleController::class, 'updateSchedule'])
    ->middleware(\App\Http\Middleware\CheckAuth::class)
    ->name('schedules.update');

Route::delete('/schedule/{sch_id}', [ScheduleController::class, 'deleteSchedule'])
    ->middleware(\App\Http\Middleware\CheckAuth::class)
    ->name('schedules.delete');

Route::get('/check-login-status', function () {
    return response()->json(['loggedIn' => Auth::check()]);
});
Route::post('/update-event', [ScheduleController::class, 'updateEvent'])->name('updateEvent');

// 댓글 부분 라우트
Route::post('/insertcomment', [BoardController::class, 'Insertcomment'])->name('comment.insert');

Route::post('/comment/reply', [BoardController::class, 'insertReply'])->name('comment.reply');

Route::delete('/comment/delete/{id}', [BoardController::class, 'deleteComments'])->name('comment.delete');


