<?php

namespace App\Http\Controllers;

use App\Services\NoteManageBaseService;
use Illuminate\Http\Request;
use Auth;
use Validator;
use App\Models\Groups;

class NoteManageController extends Controller
{
  private $service;

  public function __construct(NoteManageBaseService $service)
  {
    $this->service = $service;
  }

  // グループ管理画面
  public function index()
  {
    $groups = Auth::user()->getGroups();
    $add_groups = Auth::user()->getAddGroups();
    $items = compact('groups', 'add_groups');

    return view('note_manage', $items);
  }

  public function select(Request $req)
  {
    $form = $req->toArray();
    $group_id = $form['group_id'];
    $notes = Groups::getNotes($group_id);

    return response()->json(compact('notes'));
  }

  public function create(Request $req, $group_id)
  {
    $validator = Validator::make($req->all(), $this->rules());
    if ($validator->fails()) {
      return response()->json(['errors' => $validator->errors()], 422);
    }

    $form = $req->toArray();
    $note_columns = array();
    $note_columns['group_id'] = $group_id;
    $note_columns['note_id'] = Notes::getPrimary($group_id);
    $note_columns['note_name'] = $form['note_name'];
    $ret = $this->service->createNote($note_columns);
    $message = $ret ? 'Note created : ' . $form['note_name'] : 'Note create failed.';

    return response()->json(compact('ret', 'message'));
  }

  public function edit($note_id)
  {
  }

  public function read($note_id)
  {
  }

  public function delete(Request $req)
  {
  }

  private function rules()
  {
    return [
      'note_name' => 'required|max:100',
    ];
  }
}
