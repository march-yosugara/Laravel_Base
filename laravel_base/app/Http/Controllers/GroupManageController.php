<?php

namespace App\Http\Controllers;

use App\Services\GroupManageBaseService;
use Illuminate\Http\Request;
use Auth;
use Validator;
use App\Models\Groups;

class GroupManageController extends Controller
{
  private $service;

  public function __construct(GroupManageBaseService $service)
  {
    $this->service = $service;
  }

  // グループ管理画面
  public function index()
  {
    $groups = Auth::user()->getGroups();
    $add_groups = Auth::user()->getAddGroups();
    $items = compact('groups', 'add_groups');

    return view('group_manage', $items);
  }

  // グループ追加
  public function createOrUpdate($group_id)
  {
    if (is_null($group_id) || $group_id == '0') {
      // create
      $isCreate = '1';
      $group = new Groups();
      $items = compact('group', 'isCreate');
    } else {
      // update
      $group = Groups::getGroup($group_id);
      $isCreate = '2';
      $items = compact('group', 'isCreate');
    }

    return view('group_edit', $items);
  }

  // グループ作成
  public function create(Request $req)
  {
    $validator = Validator::make($req->all(), $this->rules());
    if ($validator->fails()) {
      return response()->json(['errors' => $validator->errors()], 422);
    }

    $form = $req->toArray();
    $group_columns = array();
    $group_columns['group_id'] = Groups::getPrimary();
    $group_columns['group_name'] = $form['group_name'];
    $group_columns['group_pass'] = $form['group_pass'];
    $ret = $this->service->createGroup($group_columns);
    $message = $ret ? 'Group created : ' . $form['group_name'] : 'Group create failed.';

    return response()->json(compact('ret', 'message'));
  }

  // グループ追加
  public function add(Request $req)
  {
    $ret = false;
    $message = '';

    $form = $req->toArray();
    $add_group_id = $form['add_group_id'];
    $add_group_pass = $form['add_group_pass'];

    if (Auth::user()->checkGroupPass($add_group_id, $add_group_pass)) {
      $ret = $this->service->addGroup($add_group_id);
      $add_group = Groups::getGroup($add_group_id);
      $message = $ret ? 'Group add : ' . $add_group->group_name : 'Group add failed.';
    } else {
      $ret = false;
      $message = 'Authentication failed';
    }

    return response()->json(compact('ret', 'message'));
  }

  // グループ解除
  public function remove(Request $req)
  {
    $ret = false;
    $message = '';

    $form = $req->toArray();
    $group_id = $form['group_id'];

    $ret = $this->service->removeGroup($group_id);
    $remove_group = Groups::getGroup($group_id);
    $message = $ret ? 'Group remove : ' . $remove_group->group_name : 'Group remove failed.';

    return response()->json(compact('ret', 'message'));
  }

  // グループ編集
  public function update(Request $req)
  {
    try {
      $form = $req->toArray();
      $group_id = $form['group_id'];

      $validator = Validator::make($req->all(), $this->rules());
      $validator->after(function ($validator) use ($group_id) {
        $group = Groups::getGroup($group_id);
        if (!isset($group)) {
          $validator->errors()->add('group_id', $group_id . 'is not exists.');
        }
      });
      if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
      }

      $group_columns = array();
      $group_columns['group_id'] = $form['group_id'];
      $group_columns['group_name'] = $form['group_name'];
      $group_columns['group_pass'] = $form['group_pass'];
      $ret = $this->service->updateGroup($group_columns);
      $message = $ret ? 'Group updated : ' . $form['group_name'] : 'Group update failed.';

      return response()->json(compact('ret', 'message'));
    } catch (\Exception $err) {
      $ret = false;
      $message = $err->getMessage();
      return response()->json(compact('ret', 'message'));
    }
  }

  // グループ削除
  public function delete(Request $req)
  {
    $form = $req->toArray();
    $group_id = $form['group_id'];

    $ret = $this->service->deleteGroup($group_id);
    $message = $ret ? 'Group delete : ' . $group_id : 'Group delete failed.';

    return response()->json(compact('ret', 'message'));
  }

  private function rules()
  {
    return [
      'group_name' => 'required|max:100',
      'group_pass' => 'required|confirmed',
      'group_pass_confirmation' => 'required',
    ];
  }
}
