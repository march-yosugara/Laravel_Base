<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Groups;

class User extends Authenticatable
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
  public function checkGroupPass($group_id, $group_pass)
  {
    $condition = [
      ['group_id', '=', $group_id],
    ];

    $group_ids = $this->usersGroups()
      ->select('group_id');
    $group = Groups::whereNotIn('group_id', $group_ids)->where($condition)->first();

    if ($group->exists()) {
      return password_verify($group_pass, $group->group_pass);
    } else {
      return false;
    }
  }
}
