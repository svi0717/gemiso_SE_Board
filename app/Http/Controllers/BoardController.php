<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BoardController extends Controller
{
    public function boardList(Request $request)
    {
        try {   
            $query = DB::table('gemiso_se.board')
                ->join('gemiso_se.user', 'gemiso_se.board.user_id', '=', 'gemiso_se.user.user_id')
                ->select('gemiso_se.board.*', 'gemiso_se.user.name as user_name');

            // 날짜 필터링
            if ($request->has('start_date') > '' && $request->has('end_date')> '' && $request->input('start_date') && $request->input('end_date')) {
                $query->whereBetween('gemiso_se.board.reg_date', [$request->input('start_date'), $request->input('end_date')]);
            }
            // 제목 검색
            if ($request->has('search') &&  $request->input('search')) {
                $search = $request->input('search');
                $query->where('gemiso_se.board.title', 'like', "%$search%");
            }

            $query->orderBy('gemiso_se.board.reg_date', 'desc');

            // 게시판 목록을 조회합니다.
            $board = $query->paginate(10)->withQueryString();
        
            // dd($request->has('start_date'));


            return view('boardList', ['board' => $board]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function showInsertForm()
    {
        try {
            // 사용자 정보를 조회
            $user_id = DB::table('gemiso_se.user')->select('gemiso_se.user.user_id.*');
            $user = DB::table('gemiso_se.user')->where('user_id', $user_id)->first();

            if (!$user) {
                return redirect()->route('boardList')->with('error', '사용자 정보를 찾을 수 없습니다.');
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
            // 조회수를 증가시키기 전에 게시글이 존재하는지 확인
            $post = DB::table('gemiso_se.board')->where('board_id', $id)->first();
            if (!$post) {
                return redirect()->route('boardList')->with('error', '게시글을 찾을 수 없습니다.');
            }

            // 조회수 증가
            DB::table('gemiso_se.board')->where('board_id', $id)->increment('views');

            // 조회수 증가 후 게시글 조회
            $post = DB::table('gemiso_se.board')->where('board_id', $id)->first();

            return view('boardview', ['post' => $post]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        // 수정할 게시글 데이터 가져오기
        $post = DB::table('gemiso_se.board')->where('board_id', $id)->first();
        
        // 수정 페이지로 이동
        return view('editboard', ['post' => $post]);
    }

    public function update(Request $request, $id)
    {
        try {
            // 유효성 검사
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string'
            ]);

            // 게시글 업데이트
            DB::table('gemiso_se.board')
                ->where('board_id', $id)
                ->update([
                    'title' => $validated['title'],
                    'content' => $validated['content'],
                    'upd_date' => now()->toDateString()
                ]);

            // 플래시 메시지 설정 후 게시판 목록으로 리다이렉트
            return redirect()->route('boardList')->with('success', '수정이 완료되었습니다.');

        } catch (\Exception $e) {
            return back()->with('error', '수정 중 오류가 발생했습니다.');
        }
    }

    public function deleteBoard($id)
    {
        try {
            // 게시글을 ID를 사용하여 삭제
            DB::table('gemiso_se.board')->where('board_id', $id)->delete();
            
            return redirect()->route('boardList')->with('success', '게시글이 성공적으로 삭제되었습니다.');
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

            return redirect()->route('boardList')->with('success', '게시글이 성공적으로 등록되었습니다.');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
