<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NoteItems extends Model
{
  protected $table = "note_items";
  protected $primaryKey = ['group_id', 'note_id', 'note_item_id'];

  public $timestamps = true;
  public $incrementing = false;

  protected $dates = ['created_at', 'updated_at'];

  protected $fillable = [
    'group_id',
    'note_id',
    'note_item_id',
    'note_item_title',
    'str1',
    'int_val1',
    'unit1',
    'str2',
    'int_val2',
    'unit2',
    'memo',
  ];

  // 使用可能ノートアイテムID取得
  public static function getNextItemID($group_id, $note_id)
  {
    $condition = [
      ['group_id', '=', $group_id],
      ['note_id', '=', $note_id],
    ];
    $note_items = NoteItems::where($condition);

    $next_id = 1;

    if ($note_items->exists()) {
      $next_id = $note_items->max('note_item_id') + 1;
    }

    return $next_id;
  }
}
