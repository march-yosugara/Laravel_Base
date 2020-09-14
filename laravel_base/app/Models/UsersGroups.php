<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersGroups extends Model
{
  protected $table = "users_groups";
  protected $primaryKey = 'users_groups_id';

  public $timestamps = true;
  public $incrementing = false;

  protected $dates = ['created_at', 'updated_at'];

  protected $fillable = [
    'user_id',
    'group_id',
  ];
}
