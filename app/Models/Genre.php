<?php

namespace App\Models;

use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Genre extends Model
{
  use SoftDeletes, Traits\Uuid;
  protected $fillable = ['name','is_active'];
  protected $date = ["deleted_at"];
  protected $casts = ['id' => 'string', 'is_active' => 'bool'];
  public $incrementing = false; // Solves issue of returning uuid in ::create
}
