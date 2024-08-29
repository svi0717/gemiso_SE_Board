<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('login');
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

Route::get('/boardList', function () {
    return view('boardList');
});


Route::get('/boardview', function () {
    return view('boardview');
});

Route::get('/insert', function () {
    return view('insert');
});

Route::get('/', function () {
    return view('login');
});

Route::get('/test', function () {
    return view('test');
});


