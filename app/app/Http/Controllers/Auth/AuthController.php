<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginFormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }
    /**
     * @return View
     */
    public function showLogin()
    {
        return view('login.login_form');
    }

    /**
     * @param App\Http\Requests\LoginFormRequest
     * $request
     */
    public function login(LoginFormRequest $request)
    {
        $credentials = $request->validate([
            'nickname' => ['required'],
            'password' => ['required'],
        ]);

        $user = $this->user->getUserByNickname($credentials['nickname']);

        if (is_null($user)) {
            return back()->withErrors([
                'danger' => 'ニックネームかパスワードが間違っています。',
            ]);
        }

        if (!is_null($user)) {
            if ($this->user->isAccountLocked($user)) {
                return back()->withErrors([
                    'danger' => 'アカウントがロックされています。',
                ]);
            }

            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                $this->user->resetErrorCount($user);
                return redirect()->route('home')->with('success', 'ログイン成功しました！');
            }
        }

        $user->error_count = $this->user->addErrorCount($user->error_count);

        if ($this->user->lockAccount($user)) {
            return back()->withErrors([
                'danger' => 'アカウントがロックされました。解除したい場合は運営者に連絡してください。',
            ]);
        }

        $user->save();

        return back()->withErrors([
            'danger' => 'ニックネームかパスワードが間違っています。',
        ]);

    }

    /**
     * ユーザーをアプリケーションからログアウトさせる
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login.show')->with('danger', 'ログアウトしました！');
    }
}
