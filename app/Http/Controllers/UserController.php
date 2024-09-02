<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // public function showRegistrationForm()
    // {
    //     return view('join'); // 회원가입 폼 뷰 파일
    // }

    public function loginForm()
    {
        return view('login'); // 로그인 폼 뷰 파일
    }

    // 회원가입 처리 메서드
    public function register(Request $request)
    {

        // 사용자 정보를 배열로 준비
        $userData = [
            'user_id' => $request->input('user_id'),
            'password' => Hash::make($request->input('password')), // 비밀번호 암호화
            'name' => $request->input('name'),
            'department' => $request->input('department'),
            'phone' => $request->input('phone'),
            'reg_date' => now(),
            'upd_date' => now(),
        ];
        try {
            DB::table('gemiso_se.user')->insert($userData);
            return redirect('/')->with('success', '회원가입이 완료되었습니다.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', '회원가입 중 오류가 발생했습니다. 다시 시도해 주세요.');
        }
    }

    public function login(Request $request)
    {
        // 사용자 인증 시도
        $loginAuth = $request->only('user_id', 'password');

        if (Auth::attempt($loginAuth)) {
            // 인증 성공, 세션 갱신
            $request->session()->regenerate();
            return redirect()->intended('/boardList')->with('success', '로그인 성공');
        }

        // 인증 실패
        return redirect()->back()->with('error', '아이디 또는 비밀번호가 일치하지 않습니다.');
    }

    public function logout(Request $request)
    {
        Auth::logout(); // 사용자 로그아웃
        $request->session()->invalidate(); // 세션 무효화
        $request->session()->regenerateToken(); // CSRF 토큰 재생성

        return redirect('/');
    }

    public function checkUserId(Request $request)
    {
        $userId = $request->input('user_id');

        $exists = DB::table('gemiso_se.user')->where('user_id', $userId)->exists();

        return response()->json(['exists' => $exists]);
    }

    public function findId(Request $request)
    {
        $name = $request->input('name');
        $phone = $request->input('phone');

        // 데이터베이스에서 아이디 검색
        $user = DB::table('gemiso_se.user')
            ->where('name', $name)
            ->where('phone', $phone)
            ->first();

            if ($user) {
                // 아이디 찾기 완료 페이지로 리다이렉트
                return redirect()->route('findIdCompleted')->with('user_id', $user->user_id);
            } else {
                // 에러 메시지와 함께 다시 폼으로 리다이렉트
                return redirect()->back()->with('error', '입력한 정보와 일치하는 계정을 찾을 수 없습니다.');
            }
    }

    public function findIdCompleted()
    {
        return view('findIdCompleted'); // 결과 페이지 뷰 파일
    }

     // 비밀번호 찾기 처리 메서드
     public function findPassword(Request $request)
     {

        $userId = $request->input('user_id');
        $name = $request->input('name');
        $phone = $request->input('phone');

        // 사용자 검색
        $user = DB::table('gemiso_se.user')
            ->where('user_id', $userId)
            ->where('name', $name)
            ->where('phone', $phone)
            ->first();

        if ($user) {
            // 비밀번호 재설정 폼으로 리다이렉트
            return view('resetPassword', ['user_id' => $userId]);
        } else {
            return redirect()->back()->with('error', '입력한 정보와 일치하는 계정을 찾을 수 없습니다.');
        }
    }
     // 비밀번호 변경 처리 메서드
     public function updatePassword(Request $request)
     {

         $userId = $request->input('user_id');
         $newPassword = $request->input('new_password');

         // 비밀번호 업데이트
         DB::table('gemiso_se.user')
             ->where('user_id', $userId)
             ->update(['password' => Hash::make($newPassword)]);

         return redirect()->route('findPasswordCompleted')->with('success', '비밀번호가 성공적으로 변경되었습니다.');
     }

     public function findPasswordCompleted()
     {
         return view('findPasswordCompleted'); // 결과 페이지 뷰 파일
     }
}
