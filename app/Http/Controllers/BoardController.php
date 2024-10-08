<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BoardController extends Controller
{
    public function boardList(Request $request)
    {
        try {
            $query = DB::table('gemiso_se.board')
                ->leftjoin('gemiso_se.users', 'gemiso_se.board.user_id', '=', 'gemiso_se.users.user_id')
                ->select(
                    'gemiso_se.board.*',
                    'gemiso_se.users.name as user_name',
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
            $user = DB::table('gemiso_se.users')->where('user_id', $user_id)->first();

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
                ->leftJoin('gemiso_se.users', 'gemiso_se.board.user_id', '=', 'gemiso_se.users.user_id')
                ->select('gemiso_se.board.*', 'gemiso_se.users.name as user_name')
                ->where('gemiso_se.board.board_id', $id)
                ->where('gemiso_se.board.delete_yn', '=', 'N')
                ->first();

            if (!$post) {
                return redirect()->route('boardList')->with('error', '게시글을 찾을 수 없습니다.');
            }

            // 조회수 증가
            DB::table('gemiso_se.board')->where('board_id', $id)->increment('views');

            // 게시물과 연관된 일정 데이터 가져오기
            $schedules = DB::table('gemiso_se.schedule')
                ->leftJoin('gemiso_se.users', 'gemiso_se.schedule.user_id', '=', 'gemiso_se.users.user_id')
                ->select('gemiso_se.schedule.*', 'gemiso_se.users.name as user_name')
                ->where('board_id', $id)
                ->where('gemiso_se.schedule.delete_yn', '=', 'N')
                ->get();

            // 게시물과 연관된 파일 데이터 가져오기
            $files = DB::table('gemiso_se.files')
            ->where('board_id', $id)
            ->where('gemiso_se.files.delete_yn', '=', 'N')
            ->get();

            // 게시물과 연관된 댓글 데이터 가져오기
            $comments = DB::table('gemiso_se.comments')
                ->leftJoin('gemiso_se.users', 'gemiso_se.comments.user_id', '=', 'gemiso_se.users.user_id')
                ->select('gemiso_se.comments.*', 'gemiso_se.users.name as user_name')
                ->where('board_id', $id)
                ->where('gemiso_se.comments.delete_yn', '=', 'N')
                ->orderBy('reg_date', 'desc')
                ->get();

            $commentIds = $comments->pluck('c_id');

            $replies = DB::table('gemiso_se.comments')
                ->leftJoin('gemiso_se.users', 'gemiso_se.comments.user_id', '=', 'gemiso_se.users.user_id')
                ->select('gemiso_se.comments.*', 'gemiso_se.users.name as user_name')
                ->where('gemiso_se.comments.delete_yn', '=', 'N')
                ->orderBy('reg_date', 'asc')
                ->whereIn('parent_id', $commentIds)
                ->get();

            // 뷰로 데이터 전달
            return view('boardview', [
                'post' => $post,
                'userId' => $userId,
                'schedules' => $schedules,
                'files' => $files,
                'type' => 'board',
                'comments' => $comments,
                'replies' => $replies,
                'board_id' => $id
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }



    public function edit($id)
    {
        // 수정할 게시글 데이터 가져오기
        $post = DB::table('gemiso_se.board')
            ->leftJoin('gemiso_se.users', 'gemiso_se.users.user_id', '=', 'gemiso_se.board.user_id')
            ->select('gemiso_se.board.*', 'gemiso_se.users.name as user_name')
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
            return redirect()->route('boards.show', ['id' => $id])->with('success', '수정이 완료되었습니다.');
        } catch (\Exception $e) {
            return back()->with('error', '수정 중 오류가 발생했습니다.');
        }
    }

    public function deleteBoard($id)
    {
        try {

            // 게시글을 ID를 사용하여 삭제 (delete_yn 업데이트)
            DB::table('gemiso_se.board')
                ->where('board_id', $id)
                ->update([
                    'delete_yn' => 'Y',
                    'deleted_at' => now()
                ]);

            // 연관된 일정들도 delete_yn을 Y로 업데이트
            DB::table('gemiso_se.schedule')  // 일정 테이블명으로 변경 필요
                ->where('board_id', $id)  // 일정과 게시글을 연결하는 외래 키 필드명으로 변경 필요
                ->update([
                    'delete_yn' => 'Y',
                    'deleted_at' => now()
                ]);

            DB::table('gemiso_se.comments')  // 댓글 테이블명으로 변경 필요
            ->where('board_id', $id)  // 댓글과 게시글을 연결하는 외래 키 필드명으로 변경 필요
            ->update([
                'delete_yn' => 'Y',
                'deleted_at' => now()
            ]);

            DB::table('gemiso_se.files')
            ->where('board_id', $id)
            ->update([
                'delete_yn' => 'Y',
                'deleted_at' => now()
            ]);

            return redirect()->route('boardList')->with('success', '게시글 및 연동된 일정들이 성공적으로 삭제되었습니다.');
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
            ], 'board_id');

            // 파일 저장
            $filePaths = [];
            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    if ($file->isValid()) { // 유효성 검사
                        $fileName = time() . '_' . $file->getClientOriginalName();
                        $uploadPath = 'C:/upload';

                        // 업로드 폴더가 존재하는지 확인, 없으면 생성
                        if (!file_exists($uploadPath)) {
                            mkdir($uploadPath, 0777, true);
                        }

                        $filePath = $uploadPath . '/' . $fileName;
                        $file->move($uploadPath, $fileName);

                        // 파일이 성공적으로 이동했는지 확인
                        if (file_exists($filePath)) {
                            $filePaths[] = $filePath;
                            DB::table('gemiso_se.files')->insert([
                                'file_name' => $file->getClientOriginalName(),
                                'file_path' => $filePath,
                                'file_size' => filesize($filePath), // 파일의 크기 직접 확인
                                'file_type' => $file->getClientMimeType(),
                                'board_id' => $boardId,
                                'delete_yn' => 'N'
                            ]);
                        }
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

            // 파일 경로 설정
            $filePath = $file->file_path; // 데이터베이스에서 저장된 파일 경로 사용
            if (!file_exists($filePath)) {
                return redirect()->back()->with('error', '파일이 존재하지 않습니다.');
            }

            return response()->download($filePath, $file->file_name);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', '파일 다운로드 중 오류가 발생했습니다.');
        }
    }

    public function Insertcomment(Request $request)
    {
        try {
            $user = Auth::user();

            // 사용자 인증 확인
            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => '사용자가 인증되지 않았습니다.'
                ], 401); // 401 Unauthorized 응답
            }

            // 요청 데이터 검증
            $validated = $request->validate([
                'content' => 'required|string',
                'board_id' => 'nullable|integer',
                'parent_id' => 'nullable|integer'
            ]);

            $user_id = $user->user_id;
            $board_id = $validated['board_id'] ?? null;
            $parent_id = $validated['parent_id'] ?? null;

            // 댓글 또는 답글 데이터 삽입
            $commentId = DB::table('gemiso_se.comments')->insertGetId([
                'user_id' => $user_id,
                'content' => $validated['content'],
                'reg_date' => now(),
                'delete_yn' => 'N',
                'board_id' => $board_id,
                'parent_id' => $parent_id
            ], 'c_id');

            // 삽입된 댓글을 조회하여 Ajax 응답으로 반환
            $comment = DB::table('gemiso_se.comments')
                ->where('c_id', $commentId)
                ->first();

            return response()->json([
                'status' => 'success',
                'comment_id' => $comment->c_id,
                'content' => $comment->content,
                'user_name' => $user->name,
                'reg_date' => Carbon::parse($comment->reg_date)->format('Y-m-d'),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => '댓글 등록 중 문제가 발생했습니다.'
            ], 500); // 500 Internal Server Error 응답
        }
    }

    public function updatecomment(Request $request, $id)
    {
        try {
            // 입력 데이터 검증
            $validatedData = $request->validate([
                'content' => 'required|string|max:500',
            ]);

            // 댓글 찾기
            $comment = DB::table('gemiso_se.comments')->where('c_id', $id)->first();

            if (!$comment) {
                return response()->json(['status' => 'error', 'message' => '댓글을 찾을 수 없습니다.'], 404);
            }

            // 댓글 업데이트
            DB::table('gemiso_se.comments')
                ->where('c_id', $id)
                ->update([
                    'content' => $validatedData['content'],
                    'upd_date' => now(),  // 수정 일자 업데이트
                ]);

            return response()->json([
                'status' => 'success',
                'content' => $validatedData['content'],
                'comment_id' => $id,  // 수정된 댓글 ID 반환
            ]);
        } catch (\Exception $e) {
            // 예외 발생 시 상세 오류 메시지 반환
            return response()->json([
                'status' => 'error',
                'message' => '댓글 수정 중 오류가 발생했습니다. 오류 메시지: ' . $e->getMessage()
            ], 500);
        }
    }
    public function deleteComments($id)
    {
        try {
            $comment = DB::table('gemiso_se.comments')->where('c_id', $id)->first();

            if (!$comment) {
                return response()->json([
                    'status' => 'error',
                    'message' => '댓글을 찾을 수 없습니다.'
                ], 404);
            }

            // 댓글 삭제 (soft delete를 고려하여 delete_yn 필드로 처리)
            DB::table('gemiso_se.comments')->where('c_id', $id)
            ->update([
                'delete_yn' => 'Y',
                'deleted_at' => now()
            ]);

            return response()->json([
                'status' => 'success',
                'message' => '댓글이 삭제되었습니다.',
                'comment_id' => $id
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => '댓글 삭제 중 오류가 발생했습니다.'
            ], 500);
        }
    }

}




