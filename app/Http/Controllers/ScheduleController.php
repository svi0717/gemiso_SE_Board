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

            // 날짜 필터링
            // if ($request->has('start_date') > '' && $request->has('end_date')> '' && $request->input('start_date') && $request->input('end_date')) {
            //     $query->whereBetween('gemiso_se.schedule.reg_date', [$request->input('start_date'), $request->input('end_date')]);
            // }
            // // 제목 검색
            // if ($request->has('search') &&  $request->input('search')) {
            //     $search = $request->input('search');
            //     $query->where('gemiso_se.schedule.title', 'like', "%$search%");
            // }
            // $query->orderBy('gemiso_se.schedule.reg_date', 'desc');

            // 게시판 목록을 조회합니다.
            // $schedule = $query;
            // dd($schedule);

            // dd($request->has('start_date'));
            // dd($schedule->title);

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
            $post = DB::table('gemiso_se.schedule')->where('sch_id', $sch_id)->first();
            if (!$post) {
                return redirect()->route('scheduleList')->with('error', '스케줄을 찾을 수 없습니다.');
            }

            return view('boardview', ['post' => $post, 'userId' => $userId, 'type' => 'schedule']);
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
            return redirect()->route('scheduleList')->with('success', '수정이 완료되었습니다.');

        } catch (\Exception $e) {
            return back()->with('error', '수정 중 오류가 발생했습니다.');
        }
    }

}
