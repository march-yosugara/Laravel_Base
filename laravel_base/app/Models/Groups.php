<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Notes;

class Groups extends Model
{
  protected $table = "groups";
  protected $primaryKey = 'group_id';

  public $timestamps = true;
  public $incrementing = false;

  protected $dates = ['created_at', 'updated_at'];

  protected $fillable = [
    'group_id',
    'group_name',
    'group_pass',
  ];

  public function usersGroups()
  {
    return $this->hasMany('App\Models\UsersGroups', 'group_id', 'group_id');
  }

  public function notes()
  {
    return $this->hasMany('App\Models\Notes', 'group_id', 'group_id');
  }

  public static function getGroup($group_id)
  {
    $condition = [
      ['group_id', '=', $group_id],
    ];
    return Groups::where($condition)->first();
  }

  public static function getPrimary()
  {
    while (true) {
      $int_id = rand(0, 99999);
      $str_id = sprintf("%05d", $int_id);
      $condition = [
        ['group_id', $str_id],
      ];

      if (!Groups::where($condition)->exists()) {
        return $str_id;
      }
    }
  }

  public static function getNotes($group_id)
  {
    $condition = [
      ['group_id', '=', $group_id],
    ];
    $notes = Notes::where($condition)->get();

    return $notes;
  }
}
