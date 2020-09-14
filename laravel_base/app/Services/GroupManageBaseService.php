<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\Groups;
use App\Models\UsersGroups;
use Auth;
use Exception;

class GroupManageBaseService
{
  // グループ作成
  public function createGroup($group_columns)
  {
    DB::beginTransaction();

    try {
      $group_columns['group_pass'] = password_hash($group_columns['group_pass'], PASSWORD_DEFAULT);
      Groups::create($group_columns);
      DB::commit();

      return true;
    } catch (Exception $e) {
      DB::rollback();
      return false;
    }
  }

  // グループ編集
  public function updateGroup($group_columns)
  {
    DB::beginTransaction();

    try {
      $group = Groups::getGroup($group_columns['group_id']);
      $group->group_name = $group_columns['group_name'];
      $group->group_pass = password_hash($group_columns['group_pass'], PASSWORD_DEFAULT);
      $group->save();

      // $condition = [
      //   ['group_id', '=', $group_columns['group_id']],
      // ];
      // $group_columns['group_pass'] = password_hash($group_columns['group_pass'], PASSWORD_DEFAULT);
      // Groups::where($condition)
      //   ->update($group_columns);

      DB::commit();
      return true;
    } catch (Exception $e) {
      DB::rollback();
      return false;
    }
  }

  // グループ削除
  public function deleteGroup($group_id)
  {
    DB::beginTransaction();

    try {
      $condition = [
        ['group_id', '=', $group_id],
      ];

      $deleted = Groups::where($condition)->delete();

      if ($deleted == 1) {
        DB::commit();
        return true;
      } else {
        DB::rollback();
        return false;
      }
    } catch (Exception $e) {
      DB::rollback();
      return false;
    }
  }

  // グループ追加
  public function addGroup($group_id)
  {
    DB::beginTransaction();

    try {
      $usergroup_columns = array();
      $usergroup_columns['user_id'] = Auth::user()->id;
      $usergroup_columns['group_id'] = $group_id;
      // $usergroup_columns = [
      //   ['user_id' => Auth::user()->id],
      //   ['group_id' => $group_id],
      // ];
      UsersGroups::create($usergroup_columns);
      DB::commit();

      return true;
    } catch (Exception $e) {
      DB::rollback();
      return false;
    }
  }

  // グループ解除
  public function removeGroup($group_id)
  {
    DB::beginTransaction();

    try {
      $condition =
        [
          ['user_id', Auth::user()->id],
          ['group_id', $group_id],
        ];
      $deleted = UsersGroups::where($condition)->delete();

      if ($deleted == 1) {
        DB::commit();
        return true;
      } else {
        DB::rollback();
        return false;
      }
    } catch (Exception $e) {
      DB::rollback();
      return false;
    }
  }
}
