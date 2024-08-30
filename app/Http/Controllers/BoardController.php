<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BoardController extends Controller
{
    public function boardlist()
    {
        try {
            // 게시판 목록을 조회합니다.
            $board = DB::table('gemiso_se.board')->where('user_id', 1)->get();
            return view('boardList', ['board' => $board]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function showInsertForm()
    {
        try {
            // 사용자 정보를 조회
            $user = DB::table('gemiso_se.user')->where('user_id', 1)->first();

            if (!$user) {
                return redirect()->route('boardlist')->with('error', '사용자 정보를 찾을 수 없습니다.');
            }

            // 사용자 이름과 ID를 뷰에 전달
            return view('insert', ['userName' => $user->name, 'userId' => $user->user_id]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        try {
            // 특정 게시글을 조회합니다.
            $post = DB::table('gemiso_se.board')->where('board_id', $id)->first();
            if (!$post) {
                return redirect()->route('boardlist')->with('error', '게시글을 찾을 수 없습니다.');
            }

            return view('boardview', ['post' => $post]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        // 수정할 게시글 데이터 가져오기
        $post = DB::table('gemiso_se.board')->where('board_id', $id)->first();
        return view('editBoard', ['post' => $post]);
    }

    public function deleteBoard($id)
    {
        try {
            // 게시글을 ID를 사용하여 삭제
            DB::table('gemiso_se.board')->where('board_id', $id)->delete();
            
            return redirect()->route('boardlist')->with('success', '게시글이 성공적으로 삭제되었습니다.');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function insertBoard(Request $request)
    {
        try {
            // 요청 데이터 검증
            $validated = $request->validate([
                'category' => 'required|string|max:50',
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'user_id' => 'required|string'
            ]);

            // 카테고리 검증
            if ($validated['category'] !== '게시판') {
                return redirect()->back()->with('error', '잘못된 카테고리입니다.');
            }

            // 게시글 삽입
            DB::table('gemiso_se.board')->insert([
                'title' => $validated['title'],
                'user_id' => $validated['user_id'],
                'content' => $validated['content'],
                'reg_date' => now()->toDateString(),
                'upd_date' => now()->toDateString(),
                'views' => 0,
                'delete_yn' => 'N',
            ]);

            return redirect()->route('boardlist')->with('success', '게시글이 성공적으로 등록되었습니다.');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
