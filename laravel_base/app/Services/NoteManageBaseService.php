<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\Notes;
use App\Models\NoteItems;
use Auth;
use Exception;

class NoteManageBaseService
{
  // ノート作成
  public function createNote($note_columns)
  {
    DB::beginTransaction();

    try {
      Notes::create($note_columns);
      DB::commit();

      return true;
    } catch (Exception $e) {
      DB::rollback();
      return false;
    }
  }

  // ノート更新
  public function updateNote($note_columns)
  {
    DB::beginTransaction();

    try {
      $note = Notes::getNote($note_columns['group_id'], $note_columns['note_id']);
      $note->note_name = $note_columns['note_name'];
      $note->save();
      DB::commit();

      return true;
    } catch (Exception $e) {
      DB::rollback();
      return false;
    }
  }

  public function getNoteInfo($group_id, $note_id)
  {
    $condition = [
      ['group_id', '=', $group_id],
      ['note_id', '=', $note_id],
    ];
    $note = Notes::where($condition)->first();
    $note_items = $note->getNoteItems();

    return compact('note', 'note_items');
  }

  // ノート編集
  public function updateNoteItems($group_id, $note_id, $note_items)
  {
    DB::beginTransaction();

    try {
      // 既存Item削除
      $condition = [
        ['group_id', '=', $group_id],
        ['note_id', '=', $note_id],
      ];
      NoteItems::where($condition)
        ->delete();

      // 改めてItem作成
      foreach ($note_items as $item) {
        $item['group_id'] = $group_id;
        $item['note_id'] = $note_id;
        $item['note_item_id'] = NoteItems::getNextItemID($group_id, $note_id);

        NoteItems::create($item);
      }

      DB::commit();
      return true;
    } catch (Exception $e) {
      DB::rollback();
      return false;
    }
  }

  // ノート削除
  public function deleteNote($group_id, $note_id)
  {
    DB::beginTransaction();

    try {
      $condition = [
        ['group_id', '=', $group_id],
        ['note_id', '=', $note_id],
      ];

      $deleted = Notes::where($condition)->delete();

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
