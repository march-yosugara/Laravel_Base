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
    $note_columns['note_id'] = Notes::getNoteID($group_id);
    $note_columns['note_name'] = $form['note_name'];
    // $note_columns = [
    //   ['group_id' => $group_id],
    //   ['note_id' => Notes::getNoteID($group_id)],
    //   ['note_name' => $form['note_name']],
    // ];
    $ret = $this->service->createNote($note_columns);
    $message = $ret ? 'Note created : ' . $form['note_name'] : 'Note create failed.';

    return response()->json(compact('ret', 'message'));
  }

  public function edit($group_id, $note_id)
  {
    $items = $this->service->getNoteInfo($group_id, $note_id);
    return view('note_edit', $items);
  }

  public function read($group_id, $note_id)
  {
    $items = $this->service->getNoteInfo($group_id, $note_id);
    return view('note_read', $items);
  }

  public function delete(Request $req)
  {
    $form = $req->toArray();
    $group_id = $form['group_id'];
    $note_id = $form['note_id'];

    $ret = $this->service->deleteNote($group_id, $note_id);
    $message = $ret ? 'Note delete : ' . $group_id . ':' . $note_id : 'Note delete failed.';

    return response()->json(compact('ret', 'message'));
  }

  public function update(Request $req)
  {
    $validator = Validator::make($req->all(), $this->rules());
    if ($validator->fails()) {
      return response()->json(['errors' => $validator->errors()], 422);
    }

    $form = $req->toArray();
    $note_name = $form['note_name'];
    $group_id = $form['group_id'];
    $note_id = $form['note_id'];
    $note_items = $form['note_items'];

    $note_columns = array();
    $note_columns['group_id'] = $group_id;
    $note_columns['note_id'] = $note_id;
    $note_columns['note_name'] = $note_name;
    // $note_columns = [
    //   ['group_id' => $group_id],
    //   ['note_id' => $note_id],
    //   ['note_name' => $note_name],
    // ];

    $ret_note = $this->service->updateNote($note_columns);
    $ret_items = $this->service->updateNoteItems($group_id, $note_id, $note_items);

    $message_note = $ret_note ? 'Note name updated : ' . $note_name : 'Note name update failed.';
    $message_items = $ret_items ? 'Note items updated : ' . count($note_items) . 'items' : 'Note items update failed.';

    return response()->json(compact('ret_note', 'ret_items', 'message_note', 'message_items'));
  }

  private function rules()
  {
    return [
      'note_name' => 'required|max:100',
      'note_items.*.note_item_title' => 'max:100',
      'note_items.*.str1' => 'max:100',
      'note_items.*.int1' => 'integer',
      'note_items.*.unit1' => 'max:20',
      'note_items.*.str2' => 'max:100',
      'note_items.*.int2' => 'integer',
      'note_items.*.unit2' => 'max:20',
    ];
  }
}
