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
            $schedule = DB::table('gemiso_se.schedule')->where('user_id', $user_id)->first();
                
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
}
