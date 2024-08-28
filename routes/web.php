<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('boardList');
});

Route::get('/schedule', function () {
    return view('schedule');
});

Route::get('/editboard', function () {
    return view('editboard');
});

Route::get('/deleteboard', function () {
    return view('deleteboard');
});

Route::get('/buttontest', function () {
    return view('buttontest');
});

Route::get('/boardList', function () {
    return view('boardList');
});

Route::get('/boardview', function () {
    return view('boardview');
});

Route::get('/insert', function () {
    return view('insert');
});
