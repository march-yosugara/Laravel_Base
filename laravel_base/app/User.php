<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Groups;
use App\Notifications\PasswordResetMultiLang;
use App\Notifications\VerifyEmailMultiLang;
use Auth;

class User extends Authenticatable implements MustVerifyEmail
{
  use Notifiable;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name', 'email', 'password',
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'password', 'remember_token',
  ];

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
  ];

  public function usersGroups()
  {
    return $this->hasMany('App\Models\UsersGroups', 'user_id', 'id');
  }

  // ユーザ登録済みグループ取得
  public function getGroups()
  {
    $group_ids = $this->usersGroups()
      ->select('group_id');
    $groups = Groups::whereIn('group_id', $group_ids)->get();

    return $groups;
  }

  // ユーザ未登録グループ取得
  public function getAddGroups()
  {
    $group_ids = $this->usersGroups()
      ->select('group_id');
    $groups = Groups::whereNotIn('group_id', $group_ids)->get();

    return $groups;
  }

  // グループパスワードチェック
  public function checkGroupPass($search_type, $group_id, $group_pass)
  {
    $search_type_clm = $search_type == 'ID' ? 'group_id' : 'group_name';
    $condition = [
      [$search_type_clm, '=', $group_id],
    ];

    $group_ids = $this->usersGroups()
      ->select('group_id');
    $group = Groups::whereNotIn('group_id', $group_ids)->where($condition)->first();

    if ($group) {
      return password_verify($group_pass, $group->group_pass);
    } else {
      return false;
    }
  }

  // グループパスワードチェック
  public function checkUpdateGroupPass($group_id, $group_pass)
  {
    $condition = [
      ['group_id', '=', $group_id],
    ];

    $group_ids = $this->usersGroups()
      ->select('group_id');
    $group = Groups::whereIn('group_id', $group_ids)->where($condition)->first();

    if ($group) {
      return password_verify($group_pass, $group->group_pass);
    } else {
      return false;
    }
  }

  // グループ・メンバーエリアタイトル
  public static function getGMTitle($window, $group_id = '')
  {
    $group = Groups::where('group_id', $group_id)->first();
    switch ($window) {
      case "G":
        return __('messages.app.glist_title');
      case "M":
        return __('messages.app.mlist_title', ['group_name' => $group->group_name]);
    }
  }

  // グループ・メンバーエリアリスト
  public static function getGMList($window, $group_id = '')
  {
    $rtn = array();
    $user = Auth::user();

    switch ($window) {
      case "G":
        $groups = $user->getGroups();
        foreach ($groups as $group) {
          $rtn[] = array(
            'id' => $group->group_id,
            'name' => $group->group_name,
          );
        }
        break;
      case "M":
        $user_ids = $user->usersGroups()
          ->where('group_id', $group_id)
          ->select('user_id');
        $members = User::whereIn('id', $user_ids)->get();
        foreach ($members as $member) {
          $rtn[] = array(
            'id' => $member->id,
            'name' => $member->name,
          );
        }
        break;
    }

    return $rtn;
  }

  public function sendEmailVerificationNotification()
  {
    $this->notify(new VerifyEmailMultiLang);
  }

  public function sendPasswordResetNotification($token)
  {
    $this->notify(new PasswordResetMultiLang($token));
  }
}
