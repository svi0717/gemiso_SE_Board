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
            $query = DB::table('gemiso_se.schedule')
            ->leftjoin('gemiso_se.user', 'gemiso_se.schedule.user_id', '=', 'gemiso_se.user.user_id')
            ->select(
                'gemiso_se.schedule.*',
                // 'gemiso_se.schedule.*',
                'gemiso_se.user.name as user_name',
            )
            ->where('gemiso_se.schedule.delete_yn', '=', 'N');

            // 날짜 필터링
            if ($request->has('start_date') && $request->has('end_date') && $request->input('start_date') && $request->input('end_date')) {
                $query->whereDate('start_date', '<=', $request->input('start_date'));
                $query->whereDate('end_date', '>=', $request->input('end_date'));
            }


            // 제목 검색
            if ($request->has('search') && $request->input('search')) {
                $search = $request->input('search');
                $query->where('gemiso_se.schedule.title', 'like', "%$search%");
            }

            $query->orderBy('gemiso_se.schedule.reg_date', 'desc');

            // DB::enableQueryLog();
            $schedule = $query->paginate(10);
            // dd($board);
            // 목록을 조회합니다.

            // // 쿼리 로그 활성화
            // dd(DB::getQueryLog());

            return view('schedule', ['schedule' => $schedule]);
        } catch (\Exception $e) {
            // 예외 발생 시 JSON 형식으로 에러 메시지 반환
            return response()->json(['error' => $e->getMessage()]);
        }
    }
    private function formatDate($date)
    {
        try {
            $formattedDate = \Carbon\Carbon::parse($date)->format('Y-m-d');
            return $formattedDate;
        } catch (\Exception $e) {
            // 잘못된 날짜 형식일 때 처리할 내용
            return null;
        }
    }

    public function scheduleLists(Request $request)
    {
        try {
            // 기본 쿼리 설정
            $query = DB::table('gemiso_se.schedule')
                ->leftJoin('gemiso_se.user', 'gemiso_se.schedule.user_id', '=', 'gemiso_se.user.user_id')
                ->leftJoin('gemiso_se.board', 'gemiso_se.schedule.board_id', '=', 'gemiso_se.board.board_id') // 게시판과 조인
                ->select(
                    'gemiso_se.schedule.*',
                    'gemiso_se.user.name as user_name',
                    'gemiso_se.board.title as board_title' // 게시판 제목
                )
                ->where('gemiso_se.schedule.delete_yn', '=', 'N');

            
            // 게시판 ID 필터링 추가
            if ($request->has('board_id') && $request->input('board_id')) {
                $boardId = $request->input('board_id');
                $query->where('gemiso_se.schedule.board_id', $boardId);
            }
            
            // 입력 받은 date 값을 처리하고 형식 확인
            if ($request->has('date') && $request->input('date')) {
                $date = $request->input('date');
                $date = $this->formatDate($date);

                if (!$date) {
                    // 날짜 형식이 잘못된 경우 처리
                    throw new \Exception("Invalid date format.");
                }

                // 특정 날짜에 대한 일정 필터링
                $query->where('start_date', '<=', $date)
                    ->where('end_date', '>=', $date);
            }

            // 사용자가 입력한 시작일자와 종료일자를 기준으로 일정 필터링
            if ($request->has('start_date') && $request->has('end_date') && $request->input('start_date') && $request->input('end_date')) {
                $startDate = $request->input('start_date');
                $endDate = $request->input('end_date');

                $query->where(function ($query) use ($startDate, $endDate) {
                    $query->whereBetween('gemiso_se.schedule.start_date', [$startDate, $endDate])
                        ->orWhereBetween('gemiso_se.schedule.end_date', [$startDate, $endDate])
                        ->orWhere(function ($query) use ($startDate, $endDate) {
                            $query->where('gemiso_se.schedule.start_date', '<=', $startDate)
                                ->where('gemiso_se.schedule.end_date', '>=', $endDate);
                        });
                });
            }

            // 제목 검색 기능 추가
            if ($request->has('search') && $request->input('search')) {
                $search = $request->input('search');
                $query->where('gemiso_se.schedule.title', 'like', "%$search%");
            }


            // 일정 등록 날짜로 정렬
            $query->orderBy('gemiso_se.schedule.reg_date', 'desc');

            // 페이지네이션 처리
            $schedule = $query->paginate(10);

            // 뷰 반환
            return view('scheduleList', ['schedule' => $schedule]);
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

            return view('scheduleview', ['post' => $post, 'userId' => $userId]);
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

            // 게시판 제목 가져오기
            $boards = DB::table('gemiso_se.board')->select('board_id', 'title')->get();

            // 사용자 이름과 ID를 뷰에 전달
            return view('insertsch', [
                'userName' => $user->name,
                'userId' => $user->user_id,
                'boards' => $boards
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }


    public function insertSchedule(Request $request)
    {
        try {
            $user_id = Auth::user()->user_id;

            // 입력값 검증
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'user_id' => 'required|string',
                'start_date' => 'nullable|date_format:Y-m-d',
                'end_date' => 'nullable|date_format:Y-m-d',
                'board_id' => 'nullable|integer'
            ]);

            // board_id가 존재하지 않으면 null로 설정
            $board_id = $validated['board_id'] ?? null;

            // 일정 등록
            DB::table('gemiso_se.schedule')->insert([
                'title' => $validated['title'],
                'user_id' => $user_id,
                'content' => $validated['content'],
                'reg_date' => now()->format('Y-m-d H:i:s'),
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
                'board_id' => $board_id,
                'delete_yn' => 'N',
            ]);

            $previousUrl = $request->input('previous_url', route('scheduleList'));

            return redirect()->to($previousUrl)->with('success', '일정이 성공적으로 등록되었습니다.');

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
        $post = DB::table('gemiso_se.schedule')
        ->leftJoin('gemiso_se.user', 'gemiso_se.user.user_id', '=', 'gemiso_se.schedule.user_id')
        ->select('gemiso_se.schedule.*', 'gemiso_se.user.name as user_name')
        ->where('gemiso_se.schedule.sch_id', $sch_id)->first();

        // 수정 페이지로 이동
        return view('editschedule', ['post' => $post]);
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
            DB::table('gemiso_se.schedule')
                ->where('sch_id', $sch_id)
                ->update([
                    'title' => $validated['title'],
                    'content' => $validated['content'],
                ]);

            // 플래시 메시지 설정 후 게시판 목록으로 리다이렉트
            return redirect()->route('schedule')->with('success', '수정이 완료되었습니다.');

        } catch (\Exception $e) {
            return back()->with('error', '수정 중 오류가 발생했습니다.');
        }
    }

}
