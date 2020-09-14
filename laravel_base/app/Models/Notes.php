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

  public function getNoteItems()
  {
    $condition = [
      ['group_id', '=', $this->group_id],
      ['note_id', '=', $this->note_id],
    ];
    $noteItems = NoteItems::where($condition);

    return $noteItems;
  }

  public static function getNoteID($group_id)
  {
    $condition = [
      ['group_id', '=', group_id],
    ];
  }
}
