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
    $items = compact('groups');

    return view('group_manage', $items);
  }

  // グループ編集画面
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
    $form = $req->toArray();
    $validator = Validator::make($req->all(), $this->rules($form));
    if ($validator->fails()) {
      return response()->json(['errors' => $validator->errors()], 422);
    }

    $form = $req->toArray();
    $group_columns = [
      'group_id' => Groups::getPrimary(),
      'group_name' => $form['group_name'],
      'group_pass' => $form['group_pass'],
    ];

    $ret = $this->service->createGroup($group_columns);
    $ret_add = $this->service->addGroup($group_columns['group_id']);
    $message = $ret ? __('messages.group_manage.mes_grp_created') . $form['group_name'] : __('messages.group_manage.mes_grp_creat_failed');

    return response()->json(compact('ret', 'message'));
  }

  // グループ追加(登録)
  public function add(Request $req)
  {
    $ret = false;
    $message = '';

    $form = $req->toArray();
    $search_type = $form['search_type'];
    $add_group_id = $form['add_group_id'];
    $add_group_pass = $form['add_group_pass'];

    if (Auth::user()->checkGroupPass($search_type, $add_group_id, $add_group_pass)) {
      $ret = $this->service->addGroup($add_group_id, $search_type);
      $add_group = Groups::getGroup($add_group_id, $search_type);
      $message = $ret ? __('messages.group_manage.mes_grp_add') . $add_group->group_name : __('messages.group_manage.mes_grp_add_failed');
    } else {
      $ret = false;
      $message = __('messages.group_manage.mes_grp_auth_failed');
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
    $message = $ret ? __('messages.group_manage.mes_grp_removed') . $remove_group->group_name : __('messages.group_manage.mes_grp_remove_failed');

    return response()->json(compact('ret', 'message'));
  }

  // グループ編集
  public function update(Request $req)
  {
    $form = $req->toArray();

    $validator = Validator::make($req->all(), $this->rules($form));
    if ($validator->fails()) {
      return response()->json(['errors' => $validator->errors()], 422);
    }

    $ret = false;
    $message = '';
    if (Auth::user()->checkUpdateGroupPass($form['group_id'], $form['sign_group_pass'])) {
      $ret = $this->service->updateGroup($form);
      $message = $ret ? __('messages.group_manage.mes_grp_updated') . $form['group_name'] : __('messages.group_manage.mes_grp_update_failed');
    } else {
      $ret = false;
      $message = __('messages.group_manage.mes_grp_update_auth_failed');
    }

    return response()->json(compact('ret', 'message'));
  }

  // グループ削除
  public function delete(Request $req)
  {
    $form = $req->toArray();

    $ret = false;
    $message = '';
    $group = Groups::getGroup($form['group_id']);

    //
    if (!$group) {
      $ret = false;
      $message = __('messages.group_manage.mes_grp_delete_failed');
    } else {
      if (Auth::user()->checkUpdateGroupPass($group->group_id, $form['sign_group_pass'])) {
        $ret = $this->service->deleteGroup($group->group_id);
        $message = $ret ? __('messages.group_manage.mes_grp_deleted') . $group->group_name : __('messages.group_manage.mes_grp_delete_failed');
      } else {
        $ret = false;
        $message = __('messages.group_manage.mes_grp_update_auth_failed');
      }
    }

    return response()->json(compact('ret', 'message'));
  }

  private function rules($form)
  {
    $rules = array();

    if ($form['is_create'] == '1') {
      // create
      $rules = [
        'group_name' => 'required|max:100|unique:groups',
        'group_pass' => 'required|confirmed',
        'group_pass_confirmation' => 'required',
      ];
    } else if (!$form['change_pass']) {
      // update
      $rules = [
        'group_id' => 'required|exists:groups',
        'group_name' => 'required|max:100|unique:groups,group_name,' . $form['group_id'] . ',group_id',
        'sign_group_pass' => 'required',
      ];
    } else {
      // updatepass
      $rules = [
        'group_id' => 'required|exists:groups',
        'group_name' => 'required|max:100|unique:groups,group_name,' . $form['group_id'] . ',group_id',
        'group_pass' => 'required|confirmed',
        'group_pass_confirmation' => 'required',
        'sign_group_pass' => 'required',
      ];
    }

    return $rules;
  }
}
