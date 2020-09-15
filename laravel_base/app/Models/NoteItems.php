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
    'int1',
    'unit1',
    'str2',
    'int2',
    'unit2',
    'memo',
  ];

  public static function getNextItemID($group_id, $note_id)
  {
    $condition = [
      ['group_id', '=', $group_id],
      ['note_id', '=', $note_id],
    ];
    $current_id = NoteItems::where($condition)
      ->max('note_item_id');

    $next_id = 1;

    if (!is_null($current_id)) {
      $next_id = $current_id + 1;
    }

    return $next_id;
  }
}
