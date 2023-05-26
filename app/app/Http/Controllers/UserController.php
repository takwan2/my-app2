<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
     /**
     * ユーザ一覧を表示する
     * @return view
     */

     public function showList() {

      $users = User::all();

      return view('user.list', ['users' => $users]);
     }

     /**
     * ユーザ登録画面を表示する
     * @return view
     */
     public function showCreate() 
     {
      return view('user.form');
     }

     /**
     * ユーザをデータベースに保存する
     * 
     */
    public function exeStore(UserRequest $request)
     {

      DB::beginTransaction();
      try {
         $inputs = $request->only(['nickname', 'password']);
         $userdata = array_merge($inputs, ['password' => Hash::make($request->input('password'))]);
         User::create($userdata);
         DB::commit();
      } catch(\Throwable $e) {
         DB::rollBack();
         abort(500);
      }

      return redirect()->route('users')->with('success', 'ユーザを登録しました。');
     }

     /**
     * ユーザ編集画面を表示する
     * @param int $id
     * @return view
     */

     public function showEdit($id) 
     {

      $user = User::find($id);

      if(is_null($user)) {
         return redirect()->route('users')->with('danger', 'そのIDのユーザはいません!');
      }

      return view('user.edit', ['user' => $user]);

     }

     public function exeUpdate(Request $request)
     {
        $this->validate($request, [
           'nickname' => 'required|max:100',
        ]);
        $inputs = $request->only(['nickname', 'password', 'id', 'locked_flg']);

      DB::beginTransaction();
      try {
         $user = User::find($inputs['id']);
         if(is_null($inputs['password'])) {
            $user->fill([
               'nickname' => $inputs['nickname'],
               'locked_flg' => $inputs['locked_flg']
            ]);
         } else {
            $user->fill([
               'nickname' => $inputs['nickname'],
               'password' => Hash::make($inputs['password']),
               'locked_flg' => $inputs['locked_flg']
            ]);
         }
         $user->save();
         DB::commit();
      } catch(\Throwable $e) {
         DB::rollBack();
         abort(500);
      }

      return redirect()->route('users')->with('success', 'ユーザを更新しました。');
     }

     /**
     * ユーザをデータベースから削除する
     * 
     */
    public function exeDelete($id)
    {

       if(empty($id)) {
          return redirect()->route('users')->with('danger', 'そのIDのユーザはいません!');
       }

      try {
         User::destroy($id);
      } catch(\Throwable $e) {
         abort(500);
      }

      return redirect()->route('users')->with('success', 'ユーザを削除しました。');
     }
}
