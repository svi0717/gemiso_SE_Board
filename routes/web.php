<?php

use App\Http\Controllers\BoardController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/schedule', function () {
    return view('schedule');
});

Route::get('/editboard', function () {
    return view('editboard');
});

Route::get('/deleteboard', function () {
    return view('deleteboard');
});

// Route::get('/boardList', function () {
//     return view('boardList');
// });

Route::middleware(['auth'])->group(function () {
    Route::get('/boardList', [BoardController::class, 'index'])->name('boardList');
});

Route::get('/boardview', function () {
    return view('boardview');
});

Route::get('/insert', function () {
    return view('insert');
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

