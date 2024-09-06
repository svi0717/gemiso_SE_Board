<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BoardController extends Controller
{
    public function boardList(Request $request)
    {
        try {
            $query = DB::table('gemiso_se.board')
            ->leftjoin('gemiso_se.user', 'gemiso_se.board.user_id', '=', 'gemiso_se.user.user_id')
            ->select(
                'gemiso_se.board.*',
                'gemiso_se.user.name as user_name',
            )
            ->where('gemiso_se.board.delete_yn', '=', 'N');

            // 날짜 필터링
            if ($request->has('start_date') && $request->has('end_date') && $request->input('start_date') && $request->input('end_date')) {
                $query->whereBetween('gemiso_se.board.reg_date', [$request->input('start_date'), $request->input('end_date')]);
            }

            // 제목 검색
            if ($request->has('search') && $request->input('search')) {
                $search = $request->input('search');
                $query->where('gemiso_se.board.title', 'like', "%$search%");
            }

            $query->orderBy('gemiso_se.board.reg_date', 'desc');


            // $user_id = Auth::user()->user_id;
            // $user = DB::table('gemiso_se.user')->where('user_id', $user_id)->first();

            // DB::enableQueryLog();
            $board = $query->paginate(10);
            // dd($board);
            // 게시판 목록을 조회합니다.

            // // 쿼리 로그 활성화
            // dd(DB::getQueryLog());

            return view('boardList', ['board' => $board]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }


    public function showInsertForm()
    {
        try {
            // 사용자 정보를 조회
            $user_id = Auth::user()->user_id;
            $user = DB::table('gemiso_se.user')->where('user_id', $user_id)->first();

            if (!$user) {
                return redirect()->route('boardList')->with('error', '사용자 정보를 찾을 수 없습니다.');
            }

            // 사용자 이름과 ID를 뷰에 전달
            return view('insertboard', ['userName' => $user->name, 'userId' => $user->user_id]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function showBoard($id)

    {
        try {
            $userId = Auth::user()->user_id;


            // 게시물 데이터 가져오기
            $post = DB::table('gemiso_se.board')
                ->leftJoin('gemiso_se.user', 'gemiso_se.board.user_id', '=', 'gemiso_se.user.user_id')
                ->select('gemiso_se.board.*', 'gemiso_se.user.name as user_name')
                ->where('gemiso_se.board.board_id', $id)
                ->first();

            if (!$post) {
                return redirect()->route('boardList')->with('error', '게시글을 찾을 수 없습니다.');
            }

            // 조회수 증가
            DB::table('gemiso_se.board')->where('board_id', $id)->increment('views');


        // 게시물과 연관된 일정 데이터 가져오기
        $schedules = DB::table('gemiso_se.schedule')
            ->where('board_id', $id)
            ->get();

        // 게시물과 연관된 파일 데이터 가져오기
        $files = DB::table('gemiso_se.files')
        ->where('board_id', $id)
        ->get();

        // 뷰로 데이터 전달
        return view('boardview', [
            'post' => $post,
            'userId' => $userId,
            'schedules' => $schedules,
            'files' => $files, 
            'type' => 'board'
        ]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()]);
    }
    }

    public function edit($id)
    {
        // 수정할 게시글 데이터 가져오기
        $post = DB::table('gemiso_se.board')
        ->leftJoin('gemiso_se.user', 'gemiso_se.user.user_id', '=', 'gemiso_se.board.user_id')
        ->select('gemiso_se.board.*', 'gemiso_se.user.name as user_name')
        ->where('gemiso_se.board.board_id', $id)->first();

        // 수정 페이지로 이동
        return view('editboard', ['post' => $post, 'type' => 'board']);
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
            DB::table('gemiso_se.board')
            ->where('board_id', $id)
            ->update([
                'delete_yn' => 'Y',
                'deleted_at' => now()
            ]);

            return redirect()->route('boardList')->with('success', '게시글이 성공적으로 삭제되었습니다.');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function insertBoard(Request $request)
    {
        try {
            $user_id = Auth::user()->user_id;
    
            // 요청 데이터 검증
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'user_id' => 'required|string',
                'files.*' => 'nullable|file|mimes:jpg,png,pdf,docx,doc|max:2048',
            ]);
    
            // 게시글 저장
            $boardId = DB::table('gemiso_se.board')->insertGetId([
                'title' => $validated['title'],
                'user_id' => $user_id,
                'content' => $validated['content'],
                'reg_date' => now()->format('Y-m-d H:i:s'),
                'upd_date' => now()->toDateString(),
                'views' => 0,
                'delete_yn' => 'N',
            ], 'board_id'); // 여기서 'board_id'를 사용합니다.

            // 파일 저장
            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    if ($file) { // 파일이 실제로 있는지 확인
                        $filePath = $file->store('files', 'public'); // 'public/files' 디렉토리에 저장
                        DB::table('gemiso_se.files')->insert([
                            'file_name' => $file->getClientOriginalName(),
                            'file_path' => $filePath,
                            'file_size' => $file->getSize(),
                            'file_type' => $file->getClientMimeType(),
                            'board_id' => $boardId,
                        ]);
                    }
                }
            }
    
            return redirect()->route('boardList')->with('success', '게시글이 성공적으로 등록되었습니다.');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
    

    public function downloadFile($id)
    {
        try {
            $file = DB::table('gemiso_se.files')->where('id', $id)->first();

            if (!$file) {
                return redirect()->back()->with('error', '파일을 찾을 수 없습니다.');
            }

            return response()->download(storage_path('app/' . $file->file_path), $file->file_name);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', '파일 다운로드 중 오류가 발생했습니다.');
        }
    }
    }
