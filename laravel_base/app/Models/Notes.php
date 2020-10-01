<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\NoteItems;

class Notes extends Model
{
  protected $table = "notes";
  protected $primaryKey = ['group_id', 'note_id'];

  public $timestamps = true;
  public $incrementing = false;

  protected $dates = ['created_at', 'updated_at'];

  protected $fillable = [
    'group_id',
    'note_id',
    'note_name',
  ];

  public static function getNote($group_id, $note_id)
  {
    $condition = [
      ['group_id', '=', $group_id],
      ['note_id', '=', $note_id],
    ];
    return Notes::where($condition)->first();
  }

  public function getNoteItems()
  {
    $condition = [
      ['group_id', '=', $this->group_id],
      ['note_id', '=', $this->note_id],
    ];
    $noteItems = NoteItems::where($condition)->get();

    return $noteItems;
  }

  public static function getNoteID($group_id)
  {
    $condition = [
      ['group_id', '=', $group_id],
    ];
    $notes = Notes::where($condition);

    $next_id = 1;

    if ($notes->exists()) {
      $next_id = $notes->max('note_id') + 1;
    }

    return $next_id;
  }
}
