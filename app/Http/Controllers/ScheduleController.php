<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Schedule; // Schedule 모델을 import

class ScheduleController extends Controller
{
    public function scheduleList(Request $request)
    {
        try {
            // $query = DB::table('gemiso_se.schedule')
            //     ->join('gemiso_se.user', 'gemiso_se.schedule.user_id', '=', 'gemiso_se.user.user_id')
            //     ->select('gemiso_se.schedule.*', 'gemiso_se.user.name as user_name')
            //     ->where('gemiso_se.schedule.delete_yn', '=', 'N');
            $user_id = Auth::user()->user_id;
            $schedule = DB::table('gemiso_se.schedule')->where('user_id', $user_id)->get();

            return view('schedule', ['schedule' => $schedule]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
    public function showSchedule($sch_id)
    {
        try {
            $userId = Auth::user()->user_id;
            // 스케줄 조회
            $post = DB::table('gemiso_se.schedule')
            ->leftJoin('gemiso_se.user', 'gemiso_se.schedule.user_id', '=', 'gemiso_se.user.user_id')
            ->select('gemiso_se.schedule.*', 'gemiso_se.user.name as user_name')
            ->where('gemiso_se.schedule.sch_id', $sch_id)
            ->first();

            if (!$post) {
                return redirect()->route('schedule')->with('error', '스케줄을 찾을 수 없습니다.');
            }

            return view('scheduleview', ['post' => $post, 'userId' => $userId, 'type' => 'schedule']);
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
                return redirect()->route('schedule')->with('error', '사용자 정보를 찾을 수 없습니다.');
            }

            // 사용자 이름과 ID를 뷰에 전달
            return view('insertsch', ['userName' => $user->name, 'userId' => $user->user_id]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function insertSchedule(Request $request)
    {
        try {
            $user_id = Auth::user()->user_id;
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'user_id' => 'required|string',
                'start_date' => 'nullable|date_format:Y-m-d',
                'end_date' => 'nullable|date_format:Y-m-d',
            ]);

            DB::table('gemiso_se.schedule')->insert([
                'title' => $validated['title'],
                'user_id' => $user_id,
                'content' => $validated['content'],
                'reg_date' => now()->format('Y-m-d H:i:s'),
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
                'delete_yn' => 'N',
            ]);

              return redirect()->route('schedule')->with('success', '일정이 성공적으로 등록되었습니다.');
            
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
    public function deleteSchedule($sch_id)
    {
        try {
            // 게시글을 ID를 사용하여 삭제
            DB::table('gemiso_se.schedule')
            ->where('sch_id', $sch_id)
            ->update([
                'delete_yn' => 'Y',
                'deleted_at' => now()
            ]);

            return redirect()->route('schedule')->with('success', '게시글이 성공적으로 삭제되었습니다.');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function editSchedule($sch_id)
    {
        // 수정할 게시글 데이터 가져오기
        $post = DB::table('gemiso_se.schedule')->where('sch_id', $sch_id)->first();

        // 수정 페이지로 이동
        return view('editboard', ['post' => $post, 'type' => 'schedule']);
    }

    public function updateSchedule(Request $request, $sch_id)
    {
        try {
            // 유효성 검사
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string'
            ]);

            // 게시글 업데이트
            DB::table('gemiso_se.board')
                ->where('sch_id', $sch_id)
                ->update([
                    'title' => $validated['title'],
                    'content' => $validated['content'],
                    'upd_date' => now()->toDateString()
                ]);

            // 플래시 메시지 설정 후 게시판 목록으로 리다이렉트
            return redirect()->route('schedule')->with('success', '수정이 완료되었습니다.');

        } catch (\Exception $e) {
            return back()->with('error', '수정 중 오류가 발생했습니다.');
        }
    }

}
