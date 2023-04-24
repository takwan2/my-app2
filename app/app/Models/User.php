<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nickname',
        'password',
        'locked_flg',
        'error_count',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    // ];

    /**
     * nicknameがマッチしたユーザを返す
     * @param string $nickname
     * @return object
     */
    public function getUserByNickname($nickname)
    {
        return User::where('nickname', '=', $nickname)->first();
    }

    /**
     * アカウントがロックされているか？
     * @param object $user
     * @return bool
     */
    public function isAccountLocked($user)
    {
        if ($user->locked_flg === 1) {
            return true;
        }
        return false;
    }

    /**
     * エラーカウントをリセットする
     * @param object $user
     */
    public function resetErrorCount($user)
    {
        if ($user->error_count > 0) {
            $user->error_count = 0;
            $user->save();
        }
    }

    /**
     * エラーカウントを1増やす
     * @param int $error_count
     * @return int
     */
    public function addErrorCount($error_count)
    {
        return $error_count + 1;
    }

    /**
     * アカウントロックする
     * @param object $user
     * @return bool
     */
    public function lockAccount($user)
    {
        if ($user->error_count > 5) {
            $user->locked_flg = 1;
            return $user->save();
        }
        return false;
    }

    public function roles()
    {
        return $this->belongsToMany('\App\Models\Role')->withTimestamps();
    }

    public function days()
    {
        // return $this->belongsToMany('\App\Models\Day')->withTimestamps();
        return $this->belongsToMany('\App\Models\Day', 'day_user')->withPivot('start_time', 'end_time')->withTimestamps();
    }

    public function determined_days()
    {
        return $this->belongsToMany('\App\Models\Day', 'latest_shifts')->withPivot('start_time', 'end_time')->withTimestamps();
    }

    // public function shiftBreaks()
    // {
    //     return $this->hasManyThrough(ShiftBreak::class, LatestShift::class);
    // }
    // public function shiftBreaks()
    // {
    //     return $this->hasManyThrough('\App\Models\ShiftBreak', '\App\Models\LatestShift');
    // }

    public function shiftBreaks()
    {
        return $this->hasManyThrough(
            ShiftBreak::class,
            LatestShift::class,
            'user_id', // 中間テーブルの外部キー
            'shift_id', // Breaksテーブルの外部キー
            'id', // Userテーブルのローカルキー
            'id' // Shiftsテーブルのローカルキー
        );
    }
}
