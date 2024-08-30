<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Board;

class BoardController extends Controller
{
    public function boardList()
    {
        // 데이터베이스에서 모든 게시판 데이터를 가져옴
        $boards = Board::all(); 
    
        // board.index 뷰에 데이터를 전달하며 반환
        return view('boardList', compact('boards'));
    }
}
