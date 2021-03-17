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
  public function updateGroup($form)
  {
    DB::beginTransaction();

    try {
      $group = Groups::getGroup($form['group_id']);
      $group->group_name = $form['group_name'];
      if ($form['change_pass']) {
        $group->group_pass = password_hash($form['group_pass'], PASSWORD_DEFAULT);
      }
      $group->save();

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

  // グループ追加(登録)
  public function addGroup($group_id, $search_type = 'ID')
  {
    DB::beginTransaction();

    try {
      if ($search_type == 'NAME') {
        $group = Groups::where('group_name', $group_id)->first();
        $group_id = $group->group_id;
      }

      $usergroup_columns = [
        'user_id' => Auth::user()->id,
        'group_id' => $group_id,
      ];
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
      $condition = [
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
